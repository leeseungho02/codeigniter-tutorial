<?php

class common_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    // 해당 테이블 모든 데이터 가져오기
    function fetchAll($query)
    {
        return $this->db->query($query)->result();
    }

    // 해당 테이블 데이터 가져오기
    function fetch($table, $data)
    {
        return $this->db->get_where($table, $data)->row();
    }

    // 추가
    function insert($table, $data)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    // 변경
    function update($table, $data, $where)
    {
        $this->db->update($table, $data, $where);
    }

    function updatePlus($table, $data, $where)
    {
        $this->db->set($data, $data . '+1', FALSE);
        $this->db->where($where);
        $this->db->update($table);
    }

    // success : 초록 성공
    // danger : 빨강 실패
    function setMessage($message, $type = "danger")
    {
        $this->session->set_flashdata('message', $message);
        $this->session->set_flashdata('message_type', $type);
    }

    // 접근 제어
    function memberAccess($writer)
    {
        $message = "해당 작성자만 수정 또는 삭제 가능합니다.";
        $member = $this->session->userdata('member');
        $nonMember = true;
        // 회원 일 때
        if ($member) {
            // 해당 작성자 회원인지 체크
            if ($writer != $member->id) {
                $this->setMessage($message);
                backPage();
            } else {
                $nonMember = false;
            }
        } else {
            // 회원이 아닐 때 회원의 글인지 체크
            if ($writer != 0) {
                $this->setMessage($message);
                backPage();
            }
        }

        return $nonMember;
    }

    // 암호화 비밀번호 생성
    function makeHashPassword($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    // 마지막 쿼리문 보기
    function lastQuery()
    {
        return $this->db->last_query();
    }

    // 작성자 체크
    function writerCheck($table, $id, $pw)
    {
        $data = $this->fetch($table, array("id" => $id));
        $checkPW = $data->non_member_pw;

        if ($data->writer != 0) {
            $member = $this->fetch("members", array("id" => $data->writer));
            $checkPW = $member->pw;
        }

        if (!password_verify($pw, $checkPW)) {
            $this->setMessage("비밀번호가 일치하지 않습니다.");
            backPage();
        }
    }
}
