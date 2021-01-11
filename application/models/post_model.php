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

    // 현재 글 가져오기
    function getPost($id)
    {
        $post = $this->post_model->fetch("posts", array("id" => $id));
        if (!$post) {
            movePage();
        }

        return $post;
    }
}
