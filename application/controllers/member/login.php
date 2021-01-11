<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'controllers/common.php');

class Login extends common
{
	public function __construct()
	{
		parent::__construct();
		isLogin();
		$this->load->library('form_validation');
		$this->load->model('member_model');
		$this->load->helper('password');
	}

	public function view()
	{
		$this->form_validation->set_rules('email', '이메일 주소', 'required|valid_email');
		$this->form_validation->set_rules('pw', '비밀번호', 'required');

		$run = $this->form_validation->run();
		if ($run) {
			$member = $this->member_model->get(array('email' => $this->input->post('email')));
			$pw = $this->input->post('pw');

			if (password_verify($pw, $member->prev_pw)) {
				$this->member_model->setMessage('예전 비밀번호를 입력하셨습니다. 새로운 비밀번호로 변경해주세요.');
				redirect("member/login/passwordUpdate/" . $member->id);
			}

			if ($member && password_verify($pw, $member->pw)) {
				$this->session->set_userdata('member', $member);
				$this->member_model->setMessage('로그인 하셨습니다.');
				redirect("/");
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
