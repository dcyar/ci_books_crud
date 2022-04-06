<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_authors extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field(array(
            'idAutor' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'NombreAutor' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
        ));

        $this->dbforge->add_key('idAutor', TRUE);
        $this->dbforge->create_table('Autor');
    }

    public function down()
    {
        $this->dbforge->drop_table('Autor');
    }
}
