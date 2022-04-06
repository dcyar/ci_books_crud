<?php

defined('BASEPATH') or exit('No direct script access allowed');

class BookUpdate extends CI_Model
{
    public $table = 'Actualizaciones_Libro';
    public $idActualizacion;
    public $idLibro;
    public $ISBNAnterior;
    public $TituloAnterior;
    public $NumeroEjemplaresAnterior;
    public $FechaModificacion;

    public function store(array $params)
    {
        $this->db->insert($this->table, $params);

        return $this->db->insert_id();
    }
}
