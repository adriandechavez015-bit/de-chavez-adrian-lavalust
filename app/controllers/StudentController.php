<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class StudentController extends Controller {

    public function index() {
        $this->call->view('student_home');
    }

    public function profile() {
        $student = [
            'student_id' => 'MCC2024-2026 00094',
            'name'       => 'Adrian De Chavez',
            'course'     => 'BS Information Technology',
            'year'       => '3rd Year',
            'section'    => '3F2',
            'email'      => 'adriandechavez@015gmail.com'
        ];

        $this->call->view('student_profile', $student);
    }
}
?>