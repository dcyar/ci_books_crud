<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_books extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field(array(
            'idLibro' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'ISBN' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
            ),
            'Titulo' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'NumeroEjemplares' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
            ),
            'idAutor' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
            ),
            'idEditorial' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
            ),
            'idTema' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
            ),
        ));

        $this->dbforge->add_key('idLibro', TRUE);
        $this->dbforge->create_table('Libro');
    }

    public function down()
    {
        $this->dbforge->drop_table('Libro');
    }
}
