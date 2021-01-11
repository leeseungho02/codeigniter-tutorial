<?php

require_once(APPPATH . 'models/common_model.php');

class Post_model extends common_model
{
    function __construct()
    {
        parent::__construct();
    }

    function makePostFromInput()
    {
        $post = array(
            "title" => $this->input->post("title"),
            "content" => $this->input->post("content"),
            "type" => $this->input->post("type")
        );
        return $post;
    }
}
