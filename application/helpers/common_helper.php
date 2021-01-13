<?php

// 해당 주소로 이동
function movePage($url = "")
{
    echo "<script> window.location.href = '/$url'; </script>";
    exit;
}

// 이전 페이지로 이동
function backPage()
{
    echo "<script> window.history.back(); </script>";
    exit;
}

// 현재 시각 생성
function createNow()
{
    return date('Y-m-d H:i:s');
}
