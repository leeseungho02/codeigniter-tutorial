<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'controllers/common.php');

class Post extends common
{
	public function __construct()
	{
        parent::__construct();
        $this->load->model('post_model');
        $this->load->helper('password');
        $this->load->library('form_validation');
    }

    // 목록
    public function index()
    {
        $datas['posts'] = $this->post_model->fetchAll("SELECT * FROM posts");
        $this->pageView("post/list", $datas);
    }
    
    // 글 작성
    public function insert()
    {
        $this->form_validation->set_rules("title", "제목", "required");
        $this->form_validation->set_rules("content", "내용", "required");
        $this->form_validation->set_rules("type", "타입", "required");

        $run = $this->form_validation->run();
		if ($run) {
            $data = $this->post_model->makePostFromInput($this->input);
            $member = $this->session->userdata('member');
            if($member){
                $data["writer"] = $member->id;
            }

            $pid = $this->post_model->insert("posts", $data);
            movePage();
        }

        $this->pageView("post/insert");
    }

    // 글 상세보기
    public function view($id = 0)
    {
        $where = array("id" => $id);
        $this->post_model->updatePlus("posts", "hit", $where);
        $datas['post'] = $this->post_model->fetch("posts", $where);
        if(!$datas['post']){
            movePage("/");
        }
        $this->pageView("post/view", $datas);
    }
}
