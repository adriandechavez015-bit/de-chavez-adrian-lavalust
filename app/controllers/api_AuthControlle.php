<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class api_AuthController extends Controller {
    public function __construct() {
        parent::__construct();
        $this->call->library('api');
        $this->call->model('User_model');
        
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
        header('Access-Control-Allow-Methods: POST, OPTIONS');
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') exit;
    }

    public function login() {
        $raw_input = json_decode(file_get_contents('php://input'), true);
        $username = $raw_input['username'] ?? '';
        $password = $raw_input['password'] ?? '';

        $user = $this->User_model->find_by_username($username);

        if ($user && password_verify($password, $user['password'])) {
            $token = base64_encode(json_encode(['user_id' => $user['id'], 'time' => time()]));
            $this->api->respond(['token' => $token, 'message' => 'Login successful'], 200);
        } else {
            $this->api->respond(['error' => 'Invalid credentials'], 401);
        }
    }

    public function register() {
        $raw = json_decode(file_get_contents('php://input'), true);
        $data = [
            'username' => $raw['username'],
            'password' => password_hash($raw['password'], PASSWORD_BCRYPT)
        ];
        $this->User_model->create_user($data);
        $this->api->respond(['message' => 'User registered successfully'], 201);
    }
}