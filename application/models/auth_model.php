<?php

require_once(APPPATH . 'models/common_model.php');

class auth_model extends common_model
{
    function __construct()
    {
        parent::__construct();
    }

    // 중복 체크 코드
    function isCode()
    {
        $code = $this->createCode(5);
        while (true) {
            $prevCode = $this->fetch("authInfo", array('code' => $code));
            if (!$prevCode) {
                return $code;
                break;
            }
        }
    }

    // 코드생성
    function createCode($length = 8)
    {
        $k = "01234567890ABCDEFGHJKLMNPQRSTUVWXYZabcdefghjklmnpqrstuvwxyz";
        $code = "";
        for ($i = 0; $i < $length; $i++) {
            $code .= substr($k, rand(0, strlen($k) - 1), 1);
        }
        return $code;
    }

    // 해당 코드 가져오기
    function getCode($code)
    {
        $auth = $this->fetch("authInfo", array('code' => $code));
        $create_dt = date("Y-m-d h:i:s", strtotime($auth->create_dt . "+" . $auth->time . " seconds"));
        $now_dt = date("Y-m-d h:i:s");

        if ($create_dt >= $now_dt) {
            return $auth;
        }
    }

    function makeCodeData($issu, $uid)
    {
        return array(
            "code" => $this->isCode(),
            "issu" => $issu,
            "time" => 180,
            "uid" => $uid,
            "create_dt" => createNow()
        );
    }
}
