<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Book extends CI_Model
{
    public $table = 'Libro';
    public $ISBN;
    public $Titulo;
    public $NumeroEjemplares;
    public $idAutor;
    public $idEditorial;
    public $idTema;

    public function getAll()
    {
        $query = $this->db->get($this->table);

        return $query->result();
    }

    public function getPaginate(int $perPage, string $columns, int $page, array $filters, array $order)
    {
        $query = $this->db->from($this->table);

        $query->select($columns);
        $query->order_by($order['by'], $order['direction']);

        if ($filters) {
            array_walk($filters, function ($value, $key) use (&$query) {
                if ($key == 'idAutor') {
                    $query->where($key, $value);
                } else {
                    $query->where($key, $value);
                }
            });
        }

        $allItems = (clone $query)->count_all_results();

        $query = $this->author($query);
        $query = $this->editorial($query);
        $query = $this->tema($query);
        $results = $query->limit($perPage, ($page - 1) * $perPage)->get()->result();

        return [
            'data' => $results,
            'currentPage' => (int) $page,
            'totalPages' => ceil($allItems / $perPage),
            'totalItems' => $allItems,
        ];
    }

    public function author($query)
    {
        return $query->join('Autor', "Autor.idAutor = $this->table.idAutor", 'inner');
    }

    public function editorial($query)
    {
        return $query->join('Editorial', "Editorial.idEditorial = $this->table.idEditorial", 'inner');
    }

    public function tema($query)
    {
        return $query->join('Tema', "Tema.idTema = $this->table.idTema", 'inner');
    }
}
