<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Product_controller extends Controller {

    public function __construct() {
        parent::__construct();

        // CORS Configuration
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');

        // Handle OPTIONS Preflight Requests
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit();
        }

        $this->call->library('api');
        $this->call->model('Product_model');

        // Robust Authorization Header Parsing
        $authHeader = '';
        if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $authHeader = $_SERVER['HTTP_AUTHORIZATION'];
        } elseif (function_exists('getallheaders')) {
            $headers = getallheaders();
            $authHeader = $headers['Authorization'] ?? $headers['authorization'] ?? '';
        }

        if (empty($authHeader) || !preg_match('/Bearer\s(\S+)/i', $authHeader)) {
            $this->api->respond(['error' => 'Unauthorized access'], 401);
            exit;
        }
    }

    public function index() {
        $products = $this->Product_model->get_all();
        $this->api->respond($products, 200);
    }

    public function create() {
        $data = json_decode(file_get_contents('php://input'), true);

        if (empty($data['product_name']) || !isset($data['price'])) {
            $this->api->respond(['error' => 'Missing required fields'], 400);
            return;
        }

        $this->Product_model->insert([
            'product_name' => $data['product_name'],
            'description'  => $data['description'] ?? '',
            'price'        => $data['price'],
            'quantity'     => $data['quantity'] ?? 0,
        ]);

        $this->api->respond(['message' => 'Product created successfully'], 201);
    }

    public function update($id = null) {
        if (!$id) {
            $this->api->respond(['error' => 'Product ID is required'], 400);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);

        $this->Product_model->update($id, [
            'product_name' => $data['product_name'] ?? '',
            'description'  => $data['description'] ?? '',
            'price'        => $data['price'] ?? 0,
            'quantity'     => $data['quantity'] ?? 0,
        ]);

        $this->api->respond(['message' => 'Product updated successfully'], 200);
    }

    public function delete($id = null) {
        if (!$id) {
            $this->api->respond(['error' => 'Product ID is required'], 400);
            return;
        }

        $this->Product_model->delete($id);
        $this->api->respond(['message' => 'Product deleted successfully'], 200);
    }
}