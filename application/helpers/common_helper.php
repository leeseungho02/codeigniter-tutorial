<?php

function isNotLogin() {
    if (!isset($_SESSION['member'])) {
        redirect('/member/login');
    }
}

function isLogin() {
    if (isset($_SESSION['member'])) {
        redirect('/');
    }
}

function movePage($url = "") {
    echo "<script> window.location.href = '/index.php/$url'; </script>";
}

function backPage() {
    echo "<script> window.history.back(); </script>";
}

function createNow() {
    return date('Y-m-d H:i:s');
}