<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AuthController extends Controller {

    public function login() {
        if ($this->session->userdata('logged_in')) {
            redirect('products');
        }
        $this->call->view('auth/login');
    }

    public function login_submit() {
        $username = $this->io->post('username');
        $password = $this->io->post('password');

        $this->call->model('UsersModel');
        $user = $this->UsersModel->get_by_username($username);

        // Replace with password_verify() if you hashed passwords in DB
        if ($user && $user['password'] === $password) {
            $this->session->set_userdata([
                'user_id'   => $user['id'],
                'username'  => $user['username'],
                'logged_in' => TRUE
            ]);
            redirect('products');
        } else {
            $data['error'] = 'Invalid username or password!';
            $this->call->view('auth/login', $data);
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('login');
    }
}