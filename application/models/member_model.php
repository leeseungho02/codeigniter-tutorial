<?php

require_once(APPPATH . 'models/common_model.php');

class Member_model extends common_model
{

    function __construct()
    {
        parent::__construct();
    }

    // 모든 회원정보 가져오기
    function gets()
    {
        return $this->fetchAll("SELECT * FROM members");
    }

    // 해당 회원정보 가져오기
    function getMember($where)
    {
        $member = $this->fetch("members", $where);

        if (!$member) {
            $this->member_model->setMessage('존재하지 않은 이메일입니다.');
            backPage();
        }

        return $member;
    }

    // 암호화 비밀번호 생성
    function makeHashPassword($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    // 회원가입 데이터 생성
    function makeMemberFromInput($input)
    {
        $member = array(
            'email' => $input->post("email"),
            'pw' => $this->makeHashPassword($input->post('pw')),
            'name' => $input->post("name"),
            'postcodify_postcode5' => $input->post("postcodify_postcode5"),
            'postcodify_address' => $input->post("postcodify_address"),
            'postcodify_details' => $input->post("postcodify_details"),
            'postcodify_extra_info' => $input->post("postcodify_extra_info")
        );
        return $member;
    }
}
