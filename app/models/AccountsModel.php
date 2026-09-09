<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AccountsModel extends Model {
    protected $table = 'accounts';

    public function get_by_username($username) {
        return $this->db->table($this->$table)
                        ->where('username', $username)
                        ->get(); // Changed from get_one() to get()
    }
}