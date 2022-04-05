<?php

defined('BASEPATH') or exit('No direct script access allowed');

class ApiBooks extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database('default');
        $this->load->model('Book');
    }

    public function getAll()
    {
        $results = $this->Book->getPaginate(...$this->getRequestParams());

        header('Content-Type: application/json');

        echo json_encode($results);
    }

    private function getRequestParams(): array
    {
        $perPage = $this->input->get('perPage') ?? 40;
        $columns = $this->input->get('columns') ?: '*';
        $page    = $this->input->get('page') ?? 1;
        $filters = $this->getFilters();

        $order   = [
            'by' => $this->input->get('orderby') ?? 'idLibro',
            'direction' => $this->input->get('order') ?? 'desc',
        ];

        return [$perPage, $columns, $page, $filters, $order];
    }

    private function getFilters(): array
    {
        $keys    = ['idAutor'];
        $filters = [];

        array_walk($keys, function ($value) use (&$filters) {
            if ($this->input->get($value)) {
                $filters[$value] = $this->input->get($value);
            }
        });

        return $filters;
    }
}
