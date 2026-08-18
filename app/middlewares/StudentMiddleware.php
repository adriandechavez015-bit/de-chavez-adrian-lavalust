<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class StudentMiddleware {
    public function handle($next) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Block access if session key is missing or false
        if (!isset($_SESSION['student_access']) || $_SESSION['student_access'] !== true) {
            header("Location: /lavalust/student");
            exit();
        }

        return $next();
    }
}
?>