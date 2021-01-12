<?php

require_once(APPPATH . 'models/common_model.php');

class Post_model extends common_model
{
    function __construct()
    {
        parent::__construct();
    }

    // DB에 들어갈 배열 생성
    function makePostFromInput()
    {
        $post = array(
            "title" => $this->input->post("title"),
            "content" => $this->input->post("content"),
            "type" => $this->input->post("type")
        );
        return $post;
    }

    // 모든 글 가져오기
    function getPosts($limit, $start)
    {
        $query = $this->db->select('*')->from('posts')->where("pdelete = false")->
        order_by('pid DESC, porder ASC, depth DESC')->limit($limit, $start)->get();
        return $query->result();
    }

    // 삭제되지 않은 모든 글 갯수
    function getPostsCount()
    {
        $this->db->select('*')->from('posts')->where("pdelete = false");
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
