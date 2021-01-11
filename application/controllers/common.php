<?php

defined('BASEPATH') or exit('No direct script access allowed');

class common extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->helper('common');
	}

	public function pageView($body_template, $data = null)
	{
		$this->load->view('template/header');
		$this->load->view($body_template, $data);
		$this->load->view('template/footer');
	}
}
