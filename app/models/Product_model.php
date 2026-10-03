<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Product_model extends Model {
    public function get_all() {
        return $this->db->table('products')->get_all();
    }

    public function get_by_id($id) {
        return $this->db->table('products')->where('id', $id)->get();
    }

    public function insert($data) {
        return $this->db->table('products')->insert($data);
    }

    public function update($id, $data) {
        return $this->db->table('products')->where('id', $id)->update($data);
    }

    public function delete($id) {
        return $this->db->table('products')->where('id', $id)->delete();
    }
}