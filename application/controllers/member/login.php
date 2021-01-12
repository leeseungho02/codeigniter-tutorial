<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'controllers/common.php');

class Login extends common
{
	public function __construct()
	{
		parent::__construct();
		isLogin();
		$this->load->model('member_model');
	}

	public function view()
	{
		$this->form_validation->set_rules('email', '이메일 주소', 'required|valid_email');
		$this->form_validation->set_rules('pw', '비밀번호', 'required');

		$run = $this->form_validation->run();
		if ($run) {
			$member = $this->member_model->get(array('email' => $this->input->post('email')));
			$pw = $this->input->post('pw');

			if (!$member) {
				$this->member_model->setMessage('존재하지 않은 아이디거나 비밀번호 입니다.');
				backPage();
			}

			if ($member->mdelete) {
				$this->member_model->setMessage('탈퇴한 회원입니다. 계정 복구하실려면 관리자에게 문의하세요.');
				backPage();
			}

			if (password_verify($pw, $member->prev_pw)) {
				$this->member_model->setMessage('예전 비밀번호를 입력하셨습니다. 새로운 비밀번호로 변경해주세요.');
				movePage("member/login/passwordUpdate/" . $member->id);
			}

			if ($member && password_verify($pw, $member->pw)) {
				$this->session->set_userdata('member', $member);
				$this->member_model->setMessage('로그인 하셨습니다.');
				movePage();
			}
		}

		$this->pageView('member/login');
	}

	public function passwordFind()
	{
		$this->form_validation->set_rules('email', '이메일 주소', 'required|valid_email');

		$run = $this->form_validation->run();
		if ($run) {
			$member = $this->member_model->get(array('email' => $this->input->post('email')));
			if (!$member) {
				$this->member_model->setMessage('존재하지 않은 이메일입니다.');
			}
			movePage("member/login/passwordUpdate/" . $member->id);
		}

		$this->pageView('member/passwordFind');
	}

	public function passwordUpdate($uid = 0)
	{
		$member = $this->member_model->get(array("id" => $uid));
		if (!$member) {
			$this->member_model->setMessage('존재하지 않은 이메일입니다.');
		}

		$this->form_validation->set_rules('pw', '새 비밀번호', 'required');
		$this->form_validation->set_rules('pw_check', '새 비밀번호 확인', 'required|matches[pw]');

		$run = $this->form_validation->run();
		if ($run) {
			$pw = $this->member_model->makeHashPassword($this->input->post("pw"));
			$data = array("pw" => $pw, "prev_pw" => $member->pw);
			$where = array("id" => $member->id);
			$this->member_model->update("members", $data, $where);
			redirect("member/login/view");
		}

		$this->pageView('member/passwordUpdate');
	}
}
