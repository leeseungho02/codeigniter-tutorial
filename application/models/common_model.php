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

    function setMessage($message)
    {
        $this->session->set_flashdata('message', $message);
    }
}
