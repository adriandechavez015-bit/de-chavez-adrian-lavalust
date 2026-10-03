<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/**
 * Model: Product
 * 
 * Automatically generated via CLI.
 */
class Product extends Model {
    protected $table = 'products';
    protected $primary_key = 'id';
    protected $fillable = [];
    protected $guarded = ['id'];

    public function __construct()
    {
        parent::__construct();
    }
}