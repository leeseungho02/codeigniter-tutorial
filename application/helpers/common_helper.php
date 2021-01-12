<?php

function isNotLogin()
{
    if (!isset($_SESSION['member'])) {
        redirect('/member/login');
    }
}

function isLogin()
{
    if (isset($_SESSION['member'])) {
        // $this->member_model->setMessage('존재하지 않은 아이디거나 비밀번호 입니다.');
        redirect('/');
    }
}

function movePage($url = "")
{
    echo "<script> window.location.href = '/index.php/$url'; </script>";
    exit;
}

function backPage()
{
    echo "<script> window.history.back(); </script>";
    exit;
}

function createNow()
{
    return date('Y-m-d H:i:s');
}
