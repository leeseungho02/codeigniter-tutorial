<?php

// 비밀번호 유효성 검사 함수
function regex_check($str)
{
    // 2가 되면 영문 대소문자, 숫자, 특수문자 중 2종류 조합 성공
    $count = 0;
    if (preg_match("/[A-Z]+/", $str)) {
        $count++;
    }

    if (preg_match("/[a-z]+/", $str)) {
        $count++;
    }

    if (preg_match("/[0-9]+/", $str)) {
        $count++;
    }

    if (preg_match("/[!@#$%^&*)(~]+/", $str)) {
        $count++;
    }

    if ((strlen($str) >= 8 && strlen($str) <= 20) && $count >= 2) {
        return TRUE;
    } else {
        return FALSE;
    }
}
