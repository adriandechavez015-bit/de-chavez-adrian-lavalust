<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class api_AuthController extends Controller {

    public function __construct() {
        parent::__construct();
        
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
        header('Content-Type: application/json; charset=utf-8');

        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit();
        }

        $this->call->library('api');
        $this->call->model('User_model');
    }

    public function login() {
        $raw = json_decode(file_get_contents('php://input'), true);
        $username = $raw['username'] ?? $this->io->post('username') ?? '';
        $password = $raw['password'] ?? $this->io->post('password') ?? '';

        if (empty($username) || empty($password)) {
            $this->api->respond(['error' => 'Username and password are required'], 400);
            return;
        }

        $user = $this->User_model->find_by_username($username);

        // Check password hash OR direct match for testing
        if ($user && (password_verify($password, $user['password']) || $password === $user['password'])) {
            $token = $this->api->generateToken([
                'user_id' => $user['id'] ?? 1, 
                'username' => $user['username'] ?? $username
            ]);
            $this->api->respond([
                'status'  => 'success',
                'token'   => $token,
                'message' => 'Login successful'
            ], 200);
            return;
        }

        $this->api->respond(['error' => 'Invalid credentials'], 401);
    }
}