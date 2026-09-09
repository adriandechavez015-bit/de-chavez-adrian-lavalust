<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class ProductModel extends Model {
    protected $table = 'products';

    // Fetch active products only
    public function all() {
        return $this->db->table($this->table)->where('is_deleted', 0)->get_all();
    }

    public function find($id) {
        return $this->db->table($this->table)->where('id', $id)->get();
    }

    public function insert($data) {
        return $this->db->table($this->table)->insert($data);
    }

    public function update($id, $data) {
        return $this->db->table($this->table)->where('id', $id)->update($data);
    }

    // Soft Delete: Sets is_deleted flag to 1 instead of removing row
    public function delete($id) {
        return $this->db->table($this->table)->where('id', $id)->update(['is_deleted' => 1]);
    }
}