<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'controllers/common.php');

class Mypage extends common
{
    public function __construct()
    {
        parent::__construct();

        $this->isNotLogin();

        $this->load->model('member_model');
        $this->load->model('auth_model');

        $this->load->helper('regex');
    }

    public function index()
    {
        $this->pageView('member/mypage');
    }

    public function logout()
    {
        $this->session->unset_userdata("member");
        $this->member_model->setMessage('로그아웃 하셨습니다.', 'success');
        movePage("member/login/view");
    }

    public function update()
    {
        $this->form_validation->set_rules('name', '이름', 'required|min_length[2]|max_length[8]');
        $this->form_validation->set_rules('pw', '비밀번호', 'regex_check');
        $this->form_validation->set_message('regex_check', '영문 대소문자, 숫자, 특수문자 중 2종류 조합 8글자이상 20글자이하');
        $this->form_validation->set_rules('pw_check', '새 비밀번호 확인', 'matches[pw]');
        $this->form_validation->set_rules('postcodify_postcode5', '우편번호', 'required');
        $this->form_validation->set_rules('postcodify_address', '도로명주소', 'required');
        $this->form_validation->set_rules('postcodify_details', '상세주소', 'required');
        $this->form_validation->set_rules('postcodify_extra_info', '참고항목', 'required');

        $run = $this->form_validation->run();
        if ($run) {
            $id = $this->input->post('id');

            $member = $this->member_model->makeMemberFromInput($this->input, 0, 1);
            if (trim($this->input->post("pw")) == "") {
                $member = $this->member_model->makeMemberFromInput($this->input, 0, 2);
            }
            $member["prev_pw"] = "";
            $where = array("id" => $id);
            
            $this->member_model->update("members", $member, $where);

            $member = $this->member_model->getMember($where);
            $this->session->set_userdata('member', $member);
            $this->member_model->setMessage('회원 정보를 수정하셨습니다.', 'success');

            movePage();
        }

        $this->pageView('member/update');
    }

    public function delete()
    {
        $member = $this->session->userdata('member');
        
        $this->member_model->update("members", array("mdelete" => 1), array("id" => $member->id));
        $this->member_model->update("posts", array("pdelete" => 1), array("writer" => $member->id));
        $this->member_model->update("comments", array("cdelete" => 1), array("writer" => $member->id));
        $this->member_model->setMessage('탈퇴하셨습니다.');

        $this->session->unset_userdata("member");

        movePage();
    }
}
