<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_publishers extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field(array(
            'idEditorial' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'NombreEditorial' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
            ),
            'Direccion' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'Telefono' => array(
                'type' => 'VARCHAR',
                'constraint' => '20',
            ),
        ));

        $this->dbforge->add_key('idEditorial', TRUE);
        $this->dbforge->create_table('Editorial');
    }

    public function down()
    {
        $this->dbforge->drop_table('Editorial');
    }
}
