<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Topic extends CI_Model
{
    public $table = 'Tema';
    public $idTema;
    public $NombreTema;

    public function getAll()
    {
        $query = $this->db->get($this->table);

        return $query->result();
    }
}
