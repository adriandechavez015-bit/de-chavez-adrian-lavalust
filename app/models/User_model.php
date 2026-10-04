<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class User_model extends Model {

    public function find_by_username($username) {
        return $this->db->table('users')->where('username', $username)->get();
    }

    public function create_user($data) {
        return $this->db->table('users')->insert($data);
    }
}