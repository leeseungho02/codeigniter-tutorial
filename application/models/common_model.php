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
}
