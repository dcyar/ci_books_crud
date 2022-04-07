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
        $this->load->helper('api');
    }

    public function getAll()
    {
        try {
            $results = $this->Book->getPaginate(...$this->getRequestParams());

            json_output(200, array_merge($results, ['status' => true]));
        } catch (\Exception $e) {
            json_output($e->getCode(), [
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function getOne($id)
    {
        try {
            $book = $this->Book->getOne($id);

            if (!$book) throw new Exception('Book not found', 404);

            json_output(200, $book);
        } catch (\Exception $e) {
            json_output($e->getCode(), [
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function store()
    {
        try {
            $errors = $this->validateFields();

            if ($errors) throw new Exception($errors, 422);

            $params = $this->loadParams();

            $this->Book->store($params);

            json_output(201, [
                'status' => true,
                'message' => 'Record created successfully',
            ]);
        } catch (\Exception $e) {
            json_output($e->getCode(), [
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function update($id)
    {
        try {
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

            $params = $this->loadParams();

            $this->Book->update($id, $params);

            json_output(201, [
                'status' => true,
                'message' => 'Record updated successfully.',
            ]);
        } catch (\Exception $e) {
            json_output($e->getCode(), [
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function delete($id)
    {
        try {
            $book = $this->Book->getOne($id);

            if (!$book) throw new Exception('Book not found', 404);

            $this->Book->delete($id);

            json_output(204, [
                'status' => true,
                'message' => 'Record deleted successfully.'
            ]);
        } catch (\Exception $e) {
            json_output($e->getCode(), [
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
        $keys    = ['search'];
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

    private function loadParams(): array
    {
        return [
            'ISBN'             => $this->input->post('ISBN') ?? NULL,
            'Titulo'           => $this->input->post('Titulo') ?? NULL,
            'NumeroEjemplares' => $this->input->post('NumeroEjemplares') ?? NULL,
            'idAutor'          => $this->input->post('idAutor') ?? NULL,
            'idEditorial'      => $this->input->post('idEditorial') ?? NULL,
            'idTema'           => $this->input->post('idTema') ?? NULL,
        ];
    }
}
