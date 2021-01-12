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
            $prevCode = $this->getCode($code);
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

        // if (!$auth) {
        //     $this->setMessage('인증번호가 일치하지 않습니다.');
        //     backPage();
        // }

        return $auth;
    }
}
