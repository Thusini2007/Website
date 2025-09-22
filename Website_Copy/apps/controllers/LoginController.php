<?php
require_once __DIR__ . '/../models/User.php';

class LoginController {

    public function index() {
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $role = $_POST['role'] ?? 'customer';

            $user = User::login($email, $role, $password);

            if ($user) {
                $_SESSION['user'] = $user;

                if ($user['role'] === 'admin') {
                    header("Location: index.php?page=admin_dashboard");
                } else {
                    header("Location: index.php?page=customer_dashboard");
                }
                exit();
            } else {
                $error = "Invalid credentials!";
            }
        }

        require __DIR__ . '/../views/login.php';
    }
}
