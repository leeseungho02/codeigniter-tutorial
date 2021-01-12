<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'controllers/common.php');

class Comment extends common
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('comment_model');
    }

    // 댓글 작성
    public function insert()
    {
        $member = $this->session->userdata('member');

        $this->form_validation->set_rules("content", "내용", "required");
        if (!$member) {
            $this->form_validation->set_rules("non_member_id", "비회원 아이디", "required");
            $this->form_validation->set_rules("non_member_pw", "비회원 비밀번호", "required");
        }

        $run = $this->form_validation->run();
        if ($run) {
            $pid = $this->input->post("pid");
            $data = array(
                "content" => $this->input->post("content"),
                "create_dt" => createNow(),
                "pid" => $pid
            );

            if ($member) {
                $data["writer"] = $member->id;
            } else {
                $data["non_member_id"] = $this->input->post("non_member_id");
                $data["non_member_pw"] = $this->input->post("non_member_pw");
            }

            $this->comment_model->insert("comments", $data);
            movePage("post/view/" . $pid);
        }
    }

    // 댓글 수정
    public function update()
    {
        $this->form_validation->set_rules("content", "내용", "required");

        $run = $this->form_validation->run();
        if ($run) {
            $id = $this->input->post("id");
            $comment = $this->comment_model->getComment($id);
            $data = array(
                "content" => $this->input->post("content"),
                "update_dt" => createNow()
            );

            $this->comment_model->update("comments", $data, array("id" => $id));

            movePage("post/view/" . $comment->pid);
        }
    }

    // 댓글 삭제
    public function delete($id = 0)
    {
        $comment = $this->comment_model->getComment($id);

        $this->comment_model->update("comments", array("cdelete" => 1), array("id" => $id));

        movePage("post/view/" . $comment->pid);
    }
}
