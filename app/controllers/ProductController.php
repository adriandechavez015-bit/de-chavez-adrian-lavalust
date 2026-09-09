<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class ProductController extends Controller {

    public function __construct() {
        parent::__construct();
        // Protect all product pages from unauthenticated users
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    // READ: Display all products
    public function index() {
        $this->call->model('ProductModel');
        $data['products'] = $this->ProductModel->all();
        $this->call->view('products/index', $data);
    }

    // CREATE: Form
    public function create() {
        $this->call->view('products/create');
    }

    // CREATE: Submit
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

    // UPDATE: Form
    public function edit($id) {
        $this->call->model('ProductModel');
        $data['product'] = $this->ProductModel->find($id);
        $this->call->view('products/edit', $data);
    }

    // UPDATE: Submit
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

    // DELETE
    public function delete($id) {
        $this->call->model('ProductModel');
        $this->ProductModel->delete($id);
        redirect('products');
    }
}