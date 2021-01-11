<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'controllers/common.php');

class Register extends common
{
	public function __construct()
	{
		parent::__construct();
		isLogin();
		$this->load->library('form_validation');
		$this->load->model('member_model');
		$this->load->model('auth_model');
		$this->load->helper('cookie');
		$this->load->helper('password');
	}

	public function view()
	{
		$this->form_validation->set_rules('email', '이메일 주소', 'required|valid_email|is_unique[members.email]');
		$this->form_validation->set_rules('name', '이름', 'required|min_length[2]|max_length[8]');
		$this->form_validation->set_rules('pw', '비밀번호', 'required|callback_regex_check',
			array('regex_check' => '영문 대소문자, 숫자, 특수문자 중 2종류 조합 8글자이상 20글자이하')
		);
		$this->form_validation->set_rules('postcodify_postcode5', '우편번호', 'required');
		$this->form_validation->set_rules('postcodify_address', '도로명주소', 'required');
		$this->form_validation->set_rules('postcodify_details', '상세주소', 'required');
		$this->form_validation->set_rules('postcodify_extra_info', '참고항목', 'required');

		$run = $this->form_validation->run();
		if ($run) {
			$member = $this->member_model->makeMemberFromInput($this->input);
			$code = $this->auth_model->isCode();
			$data = array(
				"code" => $code,
				"issu" => "이메일 인증 코드 발급",
				"time" => 180,
				"uid" => $this->member_model->insert($member),
				"create_at" => createNow()
			);
			$cookie = array(
				'name'   => 'emailCode',
				'value'  => $code,
				'expire' => '180',
				'path'   => '/',
				'prefix' => 'myprefix_',
			);

			set_cookie($cookie);
			$this->auth_model->insert("authInfo", $data);
			$this->auth_model->setMessage('회원가입에 성공했습니다.');
			
			redirect('/member/register/auth');
		}

		$this->pageView('member/register');
	}

	public function auth()
	{
		$this->form_validation->set_rules('code', '인증번호', 'required');

		$run = $this->form_validation->run();
		if ($run) {
			$code = $this->input->post("code");
			$auth = $this->auth_model->get(array('code' => $code));
			if (!$auth) {
				$this->auth_model->setMessage('인증번호가 일치하지 않습니다.');	
			}

			$data = array("email_code_status" => true);
			$where = array("id" => $auth->uid);
			$this->member_model->update("members", $data, $where);
			$this->auth_model->setMessage('인증되셨습니다.');
			redirect("member/login/view");
		}

		$this->pageView('member/auth');
	}
}
