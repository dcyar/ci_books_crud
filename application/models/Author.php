<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Author extends CI_Model
{
    public $table = 'Autor';
    public $idAutor;
    public $NombreAutor;

    public function getAll()
    {
        $query = $this->db->get($this->table);

        return $query->result();
    }
}
