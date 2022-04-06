<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_topics extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field(array(
            'idTema' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'NombreTema' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
            ),
        ));

        $this->dbforge->add_key('idTema', TRUE);
        $this->dbforge->create_table('Tema');
    }

    public function down()
    {
        $this->dbforge->drop_table('Tema');
    }
}
