<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class api_AuthController extends Controller {

    public function __construct() {
        parent::__construct();
        
        // CORS & Content-Type Configuration
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
        header('Content-Type: application/json; charset=utf-8');

        // Handle OPTIONS Preflight Requests immediately
        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit();
        }

        $this->call->library('api');
        $this->call->model('User_model');
    }

    public function login() {
        // Handle raw JSON body or x-www-form-urlencoded / FormData fallbacks
        $raw_input = json_decode(file_get_contents('php://input'), true);
        
        $username = $raw_input['username'] ?? $this->io->post('username') ?? '';
        $password = $raw_input['password'] ?? $this->io->post('password') ?? '';

        if (empty($username) || empty($password)) {
            $this->api->respond(['error' => 'Username and password are required'], 400);
            return;
        }

        $user = $this->User_model->find_by_username($username);

        if ($user && password_verify($password, $user['password'])) {
            $token = base64_encode(json_encode([
                'user_id'  => $user['id'],
                'username' => $user['username'],
                'time'     => time()
            ]));
            
            $this->api->respond([
                'status'  => 'success',
                'token'   => $token,
                'message' => 'Login successful'
            ], 200);
        } else {
            $this->api->respond(['error' => 'Invalid credentials'], 401);
        }
    }

    public function register() {
        $raw = json_decode(file_get_contents('php://input'), true);
        
        $username = $raw['username'] ?? $this->io->post('username') ?? '';
        $password = $raw['password'] ?? $this->io->post('password') ?? '';
        
        if (empty($username) || empty($password)) {
            $this->api->respond(['error' => 'Username and password are required'], 400);
            return;
        }

        $data = [
            'username' => $username,
            'password' => password_hash($password, PASSWORD_BCRYPT)
        ];

        $this->User_model->create_user($data);
        $this->api->respond(['message' => 'User registered successfully'], 201);
    }
}