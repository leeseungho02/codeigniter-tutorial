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