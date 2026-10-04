<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Product_Controller extends Controller {

    public function __construct() {
        parent::__construct();
        
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Content-Type: application/json; charset=utf-8');

        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit();
        }

        $this->call->library('api');
        $this->call->model('Product_model');
    }

    // GET /api/products
    public function index() {
        $products = $this->Product_model->get_all();
        $this->api->respond($products ? $products : [], 200);
    }

    // POST /api/products
    public function create() {
        $raw = json_decode(file_get_contents('php://input'), true);
        $data = [
            'product_name' => $raw['product_name'] ?? $this->io->post('product_name'),
            'description'  => $raw['description'] ?? $this->io->post('description'),
            'price'        => $raw['price'] ?? $this->io->post('price'),
            'quantity'     => $raw['quantity'] ?? $this->io->post('quantity')
        ];

        $res = $this->Product_model->insert($data);
        if ($res) {
            $this->api->respond(['message' => 'Product created successfully'], 201);
        } else {
            $this->api->respond(['error' => 'Failed to create product'], 500);
        }
    }

    // PUT /api/products/{id}
    public function update($id) {
        $raw = json_decode(file_get_contents('php://input'), true);
        $data = [
            'product_name' => $raw['product_name'] ?? '',
            'description'  => $raw['description'] ?? '',
            'price'        => $raw['price'] ?? 0,
            'quantity'     => $raw['quantity'] ?? 0
        ];

        $res = $this->Product_model->update($id, $data);
        $this->api->respond(['message' => 'Product updated successfully'], 200);
    }

    // DELETE /api/products/{id}
    public function delete($id) {
        $res = $this->Product_model->delete($id);
        $this->api->respond(['message' => 'Product deleted successfully'], 200);
    }
}