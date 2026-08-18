<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class StudentController extends Controller {

    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Grant access when visiting home page
        $_SESSION['student_access'] = true;

        $this->call->view('student_home');
    }

    public function profile() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Middleware check
        if (!isset($_SESSION['student_access']) || $_SESSION['student_access'] !== true) {
            header("Location: " . site_url('student'));
            exit();
        }

        $student = [
            'student_id'  => 'MCC2024-2026 00094',
            'name'        => 'Adrian De Chavez',
            'course'      => 'BS Information Technology',
            'year'        => '3rd Year',
            'section'     => '3F2',
            'email'       => 'adriandechavez@015gmail.com',
            'description' => 'Passionate full-stack developer in training with a focus on web systems and clean UI design.',
            'skills'      => ['PHP', 'LavaLust Framework', 'HTML5 & CSS3', 'JavaScript', 'SQL & Database Design'],
            'hobbies'     => ['Digital Sketching', 'Pencil Drawing', 'Coding Projects', 'Gaming']
        ];

        $this->call->view('student_profile', $student);
    }

    public function clear() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        unset($_SESSION['student_access']);
        session_destroy();
        
        header("Location: " . site_url('student/profile'));
        exit();
    }
}
?>