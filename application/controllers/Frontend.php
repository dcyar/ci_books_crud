<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Frontend extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->model('Author');
		$this->load->model('Publisher');
		$this->load->model('Topic');
		$this->load->helper('url');
	}

	public function index()
	{
		$authors = $this->Author->getAll();
		$publishers = $this->Publisher->getAll();
		$topics = $this->Topic->getAll();

		$this->load->view('home', [
			'authors' => $authors,
			'publishers' => $publishers,
			'topics' => $topics,
		]);
	}
}
