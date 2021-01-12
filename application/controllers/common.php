<?php

defined('BASEPATH') or exit('No direct script access allowed');

class common extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->database();

		$this->load->library('session');
		$this->load->library('form_validation');

		$this->load->model('common_model');

		$this->load->helper('url');
		$this->load->helper('password');
		$this->load->helper('common');
	}

	public function pageView($body_template, $data = null)
	{
		$this->load->view('template/header');
		$this->load->view($body_template, $data);
		$this->load->view('template/footer');
	}

	public function getMember()
	{
		$user = null;
		if ($this->session->userdata('member')) {
			$user = $this->session->userdata('member');
		}

		return $user;
	}

	public function isLogin()
	{
		if ($this->getMember()) {
			$this->common_model->setMessage("부적절한 접근입니다.");
			movePage();
		}
	}

	function isNotLogin()
	{
		if (!$this->getMember()) {
			$this->common_model->setMessage("로그인 후 사용가능 합니다.");
			movePage("member/login/view");
		}
	}
}
