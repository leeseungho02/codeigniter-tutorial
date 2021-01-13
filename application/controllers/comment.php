<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'controllers/common.php');

class Comment extends common
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('member_model');
        $this->load->model('comment_model');

        $this->load->helper('regex');
    }

    // 댓글 작성
    public function insert()
    {
        $member = $this->session->userdata('member');

        $this->form_validation->set_rules("content", "내용", "required");
        if (!$member) {
            $this->form_validation->set_rules("non_member_id", "비회원 아이디", "required");
            $this->form_validation->set_rules("non_member_pw", "비회원 비밀번호", "required|regex_check");
            $this->form_validation->set_message('regex_check', '영문 대소문자, 숫자, 특수문자 중 2종류 조합 8글자이상 20글자이하');
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
                $data["non_member_pw"] = $this->member_model->makeHashPassword($this->input->post("non_member_pw"));
            }

            $this->comment_model->insert("comments", $data);
            $this->comment_model->setMessage('댓글 작성 하셨습니다.', 'success');
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

            $this->comment_model->memberAccess($comment->writer);

            $data = array(
                "content" => $this->input->post("content"),
                "update_dt" => createNow()
            );

            $this->comment_model->update("comments", $data, array("id" => $id));
            $this->comment_model->setMessage('해당 댓글 수정 하셨습니다.', 'success');

            movePage("post/view/" . $comment->pid);
        }
    }

    // 댓글 삭제
    public function delete($id = 0)
    {
        $comment = $this->comment_model->getComment($id);

        $this->comment_model->memberAccess($comment->writer);
        $this->comment_model->update("comments", array("cdelete" => 1), array("id" => $id));
        $this->comment_model->setMessage('해당 댓글 삭제 하셨습니다.', 'success');

        movePage("post/view/" . $comment->pid);
    }
}
