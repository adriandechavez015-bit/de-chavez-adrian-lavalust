<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class StudentMiddleware
{
    public function handle($next)
    {
        session_start();

        if (!isset($_SESSION['student_access'])) {
            header('Location: /lavalust/student');
            exit;
        }

        return $next();
    }
}
?>