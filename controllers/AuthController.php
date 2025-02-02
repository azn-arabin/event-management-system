<?php
require_once __DIR__ . '/../models/User.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
class AuthController {
    private $user;

    public function __construct($pdo) {
        $this->user = new User($pdo);
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            // ✅ Check if all fields are filled
            if (empty($name) || empty($email) || empty($password)) {
                $_SESSION['error'] = "All fields are required.";
                header("Location: /event-management-system/register");
                exit;
            }

            // ✅ Name validation (min 3 chars, max 255 chars)
            if (strlen($name) < 3 || strlen($name) > 255) {
                $_SESSION['error'] = "Name must be between 3 and 255 characters.";
                exit;
            }

            // ✅ Validate email format
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = "Invalid email format.";
                header("Location: /event-management-system/register");
                exit;
            }

            // ✅ Check if email already exists
            if ($this->user->emailExists($email)) {
                $_SESSION['error'] = "Email already registered. Please use another.";
                header("Location: /event-management-system/register");
                exit;
            }

            // ✅ Check password length
            if (strlen($password) < 8) {
                $_SESSION['error'] = "Password must be at least 8 characters long.";
                header("Location: /event-management-system/register");
                exit;
            }

            // ✅ Check if passwords match
            if ($password !== $confirm_password) {
                $_SESSION['error'] = "Passwords do not match.";
                header("Location: /event-management-system/register");
                exit;
            }

            // ✅ Register the user
            if ($this->user->register($name, $email, $password)) {
                $_SESSION['success'] = "Registration successful! You can now log in.";
                header("Location: /event-management-system/login");
                exit;
            } else {
                $_SESSION['error'] = "Registration failed. Try again.";
                header("Location: /event-management-system/register");
                exit;
            }
        }
    }


    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $email = trim($_POST['email']);
            $password = $_POST['password'];


            if (empty($email) || empty($password)) {
                $_SESSION['error'] = "Email and password are required.";
                header("Location: /event-management-system/login");
                exit;
            }

            $user = $this->user->login($email, $password);
            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                header("Location: /event-management-system/dashboard");
                exit;
            } else {
                $_SESSION['error'] = "Invalid email or password.";
                header("Location: /event-management-system/login");
                exit;
            }
        }
    }


    public function logout() {
        session_destroy();
        header("Location: /event-management-system/login");
        exit;
    }
}
?>
