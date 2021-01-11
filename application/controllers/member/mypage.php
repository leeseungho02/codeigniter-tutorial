<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'controllers/common.php');

class Mypage extends common
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('member_model');
        $this->load->model('auth_model');
    }

    public function index()
    {
        $this->pageView('member/mypage');
    }
    
	public function logout()
	{
		$this->session->unset_userdata("member");
		redirect("member/login/view");
    }
    
    public function update()
    {

        $this->pageView('member/update');
    }

    public function delete($uid = 0)
    {

    }
}
