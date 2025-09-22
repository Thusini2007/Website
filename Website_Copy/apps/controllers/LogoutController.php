<?php
class LogoutController {

    // Method matches router call in index.php
    public function index() {
        $this->performLogout();
    }

    // Private method that actually handles logout
    private function performLogout() {
        // Clear all session data
        $_SESSION = [];

        // Destroy session cookie
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Destroy session
        session_destroy();

        // Redirect to login page
        header("Location: index.php?page=login");
        exit();
    }
}
