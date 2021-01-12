<?php

function getUploadInit()
{
    $config['upload_path'] = './uploads/';
    $config['allowed_types'] = 'gif|jpg|png';
    $config['max_size'] = '10240';
    $config['overwrite'] = true;
    $config['encrypt_name'] = true;
    return $config;
}

function getPaginationInit($per_page, $total_rows)
{
    $config['base_url'] = 'http://localhost/index.php/post/index';
    $config['total_rows'] = $total_rows;
    $config['per_page'] = $per_page;
    $config['use_page_numbers'] = TRUE;
    return $config;
}