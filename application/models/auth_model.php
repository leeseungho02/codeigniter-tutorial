<?php

require_once(APPPATH.'models/common_model.php');

class auth_model extends common_model
{
    function __construct()
    {
        parent::__construct();
    }

    function get($data)
    {
        return $this->fetch("authInfo", $data);
    }

    function isCode()
    {
        $code = $this->createCode(5);
        while (true) {
            $prevCode = $this->auth_model->get(array('code' => $code));
            if (!$prevCode) {
                return $code;
                break;
            }
        }
    }

    function createCode($length = 8)
    {
        $k = "01234567890ABCDEFGHJKLMNPQRSTUVWXYZabcdefghjklmnpqrstuvwxyz";
        $code = "";
        for ($i = 0; $i < $length; $i++) {
            $code .= substr($k, rand(0, strlen($k) - 1), 1);
        }
        return $code;
    }

    function insert($code, $issu, $time, $uid)
    {
        $this->db->set('code', $code);
        $this->db->set('issu', $issu);
        $this->db->set('time', $time);
        $this->db->set('uid', $uid);
        $this->db->set('create_at', date('Y-m-d H:i:s'));
        $this->db->insert('authInfo');
    }
}
