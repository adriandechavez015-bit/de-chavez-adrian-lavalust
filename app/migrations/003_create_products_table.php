<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Migration_create_products_table {
    public function up() {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'product_name' => array(
                'type' => 'VARCHAR',
                'constraint' => 100,
            ),
            'description' => array(
                'type' => 'TEXT',
                'null' => TRUE,
            ),
            'price' => array(
                'type' => 'DECIMAL',
                'constraint' => '10,2',
            ),
            'quantity' => array(
                'type' => 'INT',
                'constraint' => 11,
            ),
            'created_at' => array(
                'type' => 'TIMESTAMP',
                'default' => 'CURRENT_TIMESTAMP'
            ),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('products');
    }

    public function down() {
        $this->dbforge->drop_table('products');
    }
}