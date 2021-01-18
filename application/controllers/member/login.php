<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'controllers/common.php');

class Login extends common
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
		$this->form_validation->set_rules('email', '이메일 주소', 'required|valid_email');
		$this->form_validation->set_rules('pw', '비밀번호', 'required');

		$run = $this->form_validation->run();
		if ($run) {
			$member = $this->member_model->getMember(array('email' => $this->input->post('email')));
			$pw = $this->input->post('pw');

			if (password_verify($pw, $member->prev_pw)) {
				$this->member_model->setMessage('예전 비밀번호를 입력하셨습니다.');
				backPage();
			}

			if (!password_verify($pw, $member->pw)) {
				$this->member_model->setMessage('비밀번호가 일치하지 않습니다.');
				backPage();
			}

			$this->session->set_userdata('member', $member);
			$this->member_model->setMessage('로그인 하셨습니다.', 'success');
			movePage();
		}

		$this->pageView('member/login');
	}

	public function passwordFind()
	{
		$this->form_validation->set_rules('email', '이메일 주소', 'required|valid_email');

		$run = $this->form_validation->run();
		if ($run) {
			$member = $this->member_model->getMember(array('email' => $this->input->post('email')));
			$data = $this->auth_model->makeCodeData("비밀번호 찾기 인증 코드 발급", $member->id);

			$this->auth_model->insert("authInfo", $data);

			movePage("member/register/auth/passwordFind");
		}

		$this->pageView('member/passwordFind');
	}

	public function passwordUpdate($uid = 0)
	{
		$member = $this->member_model->getMember(array("id" => $uid));

		$this->form_validation->set_rules('pw', '새 비밀번호', 'required|regex_check');
		$this->form_validation->set_message('regex_check', '영문 대소문자, 숫자, 특수문자 중 2종류 조합 8글자이상 20글자이하');
		$this->form_validation->set_rules('pw_check', '새 비밀번호 확인', 'required|matches[pw]');

		$run = $this->form_validation->run();
		if ($run) {
			$inputPW = $this->input->post("pw");
			$pw = $this->member_model->makeHashPassword($inputPW);

			if (password_verify($inputPW, $member->pw)) {
				$this->member_model->setMessage('입력하신 비밀번호는 기존 비밀번호입니다.');
				backPage();
			}

			$this->member_model->update("members", array("pw" => $pw, "prev_pw" => $member->pw), array("id" => $member->id));
			$this->member_model->setMessage('새로운 비밀번호로 변경하셨습니다.', 'success');

			movePage("member/login/view");
		}

		$this->pageView('member/passwordUpdate');
	}
}
