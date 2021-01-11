<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'controllers/common.php');

class Post extends common
{
	public function __construct()
	{
        parent::__construct();
        $this->load->model('post_model');
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
            $data["create_dt"] = createNow();
            $member = $this->session->userdata('member');
            if($member){
                $data["writer"] = $member->id;
            }

            $pid = $this->post_model->insert("posts", $data);
            movePage("post");
        }

        $this->pageView("post/insert");
    }

    // 글 상세보기
    public function view($id = 0)
    {
        $this->post_model->updatePlus("posts", "hit", array("id" => $id));

        $datas['post'] = $this->post_model->getPost($id);

        $this->pageView("post/view", $datas);
    }

    // 글 수정
    public function update($id = 0)
    {
        $post = $this->post_model->getPost($id);
        $member = $this->session->userdata('member');
        
        if (!$member || $post->writer != $member->id) {
            backPage();
        }

        $this->form_validation->set_rules("title", "제목", "required");
        $this->form_validation->set_rules("content", "내용", "required");
        $this->form_validation->set_rules("type", "타입", "required");

        $run = $this->form_validation->run();
		if ($run) {
            $data = $this->post_model->makePostFromInput($this->input);
            $data["update_dt"] = createNow();
            $this->post_model->update("posts", $data, array("id" => $id));
            movePage("post/view/" . $id);
        }

        $this->pageView("post/update", $post);
    }

    // 글 삭제
    public function delete($id = 0)
    {
        $post = $this->post_model->getPost($id);
        $member = $this->session->userdata('member');

        if (!$member || $post->writer != $member->id) {
            backPage();
        }

        $this->post_model->update("posts", array("pdelete" => 1), array("id" => $id));
    }
}
