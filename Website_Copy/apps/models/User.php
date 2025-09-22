<?php
require_once __DIR__ . '/../../db.php';

class User {

    public static function login($email, $role, $password) {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM users WHERE email=? AND LOWER(role)=LOWER(?)");
        $stmt->bind_param("ss", $email, $role);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if (!$user) return false;

        $db_pass = $user['password'];
        if (str_starts_with($db_pass, '$2y$')) {
            return password_verify($password, $db_pass) ? $user : false;
        } else {
            return hash('sha256', $password) === $db_pass ? $user : false;
        }
    }

    public static function register($name, $email, $password) {
        global $conn;

        // Check if email exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if($stmt->num_rows > 0) return false;

        // Insert new user
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'customer')");
        $stmt->bind_param("sss", $name, $email, $hashedPassword);

        return $stmt->execute();
    }
}
