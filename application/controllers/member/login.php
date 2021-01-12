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
	}

	public function view()
	{
		$this->form_validation->set_rules('email', '이메일 주소', 'required|valid_email');
		$this->form_validation->set_rules('pw', '비밀번호', 'required');

		$run = $this->form_validation->run();
		if ($run) {
			$member = $this->member_model->getMember(array('email' => $this->input->post('email')));
			$pw = $this->input->post('pw');

			if (!$member) {
				$this->member_model->setMessage('존재하지 않은 아이디 입니다.');
				backPage();
			}

			if ($member->mdelete) {
				$this->member_model->setMessage('탈퇴한 회원입니다. 계정 복구하실려면 관리자에게 문의하세요.');
				backPage();
			}

			if (!$member->email_code_status) {
				$this->member_model->setMessage('이메일 인증 후 이용 가능합니다.');
				movePage("member/register/auth");
			}

			if (password_verify($pw, $member->prev_pw)) {
				$this->member_model->setMessage('예전 비밀번호를 입력하셨습니다. 새로운 비밀번호로 변경해주세요.');
				movePage("member/login/passwordUpdate/" . $member->id);
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
			movePage("member/login/passwordUpdate/" . $member->id);
		}

		$this->pageView('member/passwordFind');
	}

	public function passwordUpdate($uid = 0)
	{
		$member = $this->member_model->getMember(array("id" => $uid));

		$this->form_validation->set_rules('pw', '새 비밀번호', 'required');
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
