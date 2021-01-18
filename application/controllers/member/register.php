<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'controllers/common.php');

class Register extends common
{
	public function __construct()
	{
		parent::__construct();

		$this->isLogin();

		$this->load->model('member_model');
		$this->load->model('auth_model');

		$this->load->helper('regex');
	}

	public function view()
	{
		$this->form_validation->set_rules('email', '이메일 주소', 'required|valid_email|is_unique[members.email]');
		$this->form_validation->set_rules('name', '이름', 'required|min_length[2]|max_length[8]');
		$this->form_validation->set_rules('pw', '비밀번호', 'required|regex_check');
		$this->form_validation->set_message('regex_check', '영문 대소문자, 숫자, 특수문자 중 2종류 조합 8글자이상 20글자이하');
		$this->form_validation->set_rules('postcodify_postcode5', '우편번호', 'required');
		$this->form_validation->set_rules('postcodify_address', '도로명주소', 'required');
		$this->form_validation->set_rules('postcodify_details', '상세주소', 'required');
		$this->form_validation->set_rules('postcodify_extra_info', '참고항목', 'required');

		$run = $this->form_validation->run();
		if ($run) {
			$member = $this->member_model->makeMemberFromInput($this->input);
			$uid = $this->member_model->insert("members", $member);
			$data = $this->auth_model->makeCodeData("이메일 인증 코드 발급", $uid);

			$this->auth_model->insert("authInfo", $data);
			$this->auth_model->setMessage('회원가입에 성공했습니다.', 'success');

			movePage('member/register/auth/register');
		}

		$this->pageView('member/register');
	}
	
	public function auth($type = "")
	{
		$this->form_validation->set_rules('code', '인증번호', 'required');

		$run = $this->form_validation->run();
		if ($run) {
			$auth = $this->auth_model->getCode($this->input->post("code"));
			if (!$auth) {
				$this->member_model->setMessage('인증번호가 유효하지 않습니다.');
				backPage();	
			}

			$this->auth_model->setMessage('인증 하셨습니다.', 'success');

			if ($type == "register") {
				$this->member_model->update("members", array("email_code_status" => true), array("id" => $auth->uid));
				movePage("member/login/view");
			} else if ($type == "passwordFind") {
				movePage("member/login/passwordUpdate/" . $auth->uid);
			}
		}

		$this->pageView('member/auth');
	}
}
