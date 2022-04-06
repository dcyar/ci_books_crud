<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Publisher extends CI_Model
{
    public $table = 'Editorial';
    public $idEditorial;
    public $NombreEditorial;
    public $Direccion;
    public $Telefono;

    public function getAll()
    {
        $query = $this->db->get($this->table);

        return $query->result();
    }
}
