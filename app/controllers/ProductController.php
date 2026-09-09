<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class ProductController extends Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    public function index() {
        $this->call->model('ProductModel');
        $data['products'] = $this->ProductModel->all();
        $this->call->view('products/index', $data);
    }

    public function create() {
        $this->call->view('products/create');
    }

    public function store() {
        $this->call->model('ProductModel');
        $data = [
            'product_name' => $this->io->post('product_name'),
            'description'  => $this->io->post('description'),
            'price'        => $this->io->post('price'),
            'quantity'     => $this->io->post('quantity')
        ];
        $this->ProductModel->insert($data);
        redirect('products');
    }

    public function edit($id) {
    $this->call->model('ProductModel');
    // Fetch product record as a single array
    $data['product'] = $this->ProductModel->find($id);

    // Pass $data into the view
    $this->call->view('products/edit', $data);
}

    public function update($id) {
        $this->call->model('ProductModel');
        $data = [
            'product_name' => $this->io->post('product_name'),
            'description'  => $this->io->post('description'),
            'price'        => $this->io->post('price'),
            'quantity'     => $this->io->post('quantity')
        ];
        $this->ProductModel->update($id, $data);
        redirect('products');
    }

    public function delete($id) {
        $this->call->model('ProductModel');
        $this->ProductModel->delete($id);
        redirect('products');
    }
}