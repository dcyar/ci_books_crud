<?php

defined('BASEPATH') or exit('No direct script access allowed');

class ApiBooks extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database('default');
        $this->load->model('Book');
        $this->load->model('BookUpdate');
        $this->load->library('form_validation');
    }

    public function getAll()
    {
        $results = $this->Book->getPaginate(...$this->getRequestParams());

        header('Content-Type: application/json');

        echo json_encode($results);
    }

    public function getOne($id)
    {
        header('Content-Type: application/json');

        try {
            $book = $this->Book->getOne($id);


            if (!$book) throw new Exception('Book not found', 404);

            http_response_code(200);

            echo json_encode($book);
        } catch (\Exception $e) {
            http_response_code($e->getCode());
            echo json_encode([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function store()
    {
        header('Content-Type: application/json');

        try {
            $params = $this->load();

            $errors = $this->validateFields();

            if ($errors) throw new Exception($errors, 422);

            $book = $this->Book->store($params);

            http_response_code(201);

            echo json_encode([
                'status' => true,
                'message' => 'Record created successfully',
                'data' => $book
            ]);
        } catch (\Exception $e) {
            http_response_code($e->getCode());

            echo json_encode([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function update($id)
    {
        header('Content-Type: application/json');

        try {
            $params = $this->load();

            $errors = $this->validateFields();

            if ($errors) throw new Exception($errors, 422);

            $book = $this->Book->getOne($id);

            $this->BookUpdate->store([
                'idLibro' => $id,
                'ISBNAnterior' => $book->ISBN,
                'TituloAnterior' => $book->Titulo,
                'NumeroEjemplaresAnterior' => $book->NumeroEjemplares,
                'FechaModificacion' => date('Y-m-d H:i:s'),
            ]);

            $bookUpdated = $this->Book->update($id, $params);

            http_response_code(201);

            echo json_encode([
                'status' => true,
                'message' => 'Record updated successfully.',
                'data' => $bookUpdated
            ]);
        } catch (\Exception $e) {
            http_response_code($e->getCode());

            echo json_encode([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
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

    private function validateFields(): ?string
    {
        $this->form_validation->set_error_delimiters('', '');

        $this->form_validation->set_rules('ISBN', 'ISBN', 'required');
        $this->form_validation->set_rules('Titulo', 'Titulo', 'required');
        $this->form_validation->set_rules('NumeroEjemplares', 'NumeroEjemplares', 'required');
        $this->form_validation->set_rules('idAutor', 'idAutor', 'required');
        $this->form_validation->set_rules('idEditorial', 'idEditorial', 'required');
        $this->form_validation->set_rules('idTema', 'idTema', 'required');


        return $this->form_validation->run() == false ? validation_errors() : false;
    }

    private function load(): array
    {
        return [
            'ISBN'             => $this->input->post('ISBN'),
            'Titulo'           => $this->input->post('Titulo'),
            'NumeroEjemplares' => $this->input->post('NumeroEjemplares'),
            'idAutor'          => $this->input->post('idAutor'),
            'idEditorial'      => $this->input->post('idEditorial'),
            'idTema'           => $this->input->post('idTema'),
        ];
    }
}
