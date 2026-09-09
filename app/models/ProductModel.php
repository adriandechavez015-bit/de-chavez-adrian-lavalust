<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class ProductModel extends Model {
    protected $table = 'products';

    public function all() {
        return $this->db->table($this->table)->get_all();
    }

    public function find($id) {
    return $this->db->table($this->table)->where('id', $id)->get_one();
}

    public function insert($data) {
        return $this->db->table($this->table)->insert($data);
    }

    public function update($id, $data) {
        return $this->db->table($this->table)->where('id', $id)->update($data);
    }

    public function delete($id) {
        return $this->db->table($this->table)->where('id', $id)->delete();
    }
}