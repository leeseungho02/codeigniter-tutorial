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

    function getPosts($limit, $start)
    {
        $query = $this->db->select('*')->from('posts')->order_by('pid DESC, porder ASC, depth DESC')->limit($limit, $start)->get();
        return $query->result();
    }

    function getPostsCount()
    {
        $this->db->select('*');
        $this->db->from('posts');
        $this->db->where("pdelete = false");
        return $this->db->count_all_results();
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
