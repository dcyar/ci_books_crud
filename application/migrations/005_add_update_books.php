<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_update_books extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field(array(
            'idActualizacion' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'idLibro' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
            ),
            'ISBNAnterior' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
            ),
            'TituloAnterior' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'NumeroEjemplaresAnterior' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
            ),
            'FechaModificacion' => array(
                'type' => 'DATETIME',
            ),
        ));

        $this->dbforge->add_key('idActualizacion', TRUE);
        $this->dbforge->create_table('Actualizaciones_Libro');
    }

    public function down()
    {
        $this->dbforge->drop_table('Actualizaciones_Libro');
    }
}
