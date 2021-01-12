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
    function getPosts($limit, $start, $type = "", $keyword = "")
    {
        $this->db->select('*')->from('posts');

        // 검색어가 있을 때
        if ($type != "" && $keyword != "") {
            $this->db->like($type, $keyword);
        }

        $query = $this->db->order_by('pid DESC, porder ASC, depth DESC')->limit($limit, $start)->get();
        return $query->result();
    }

    // 삭제되지 않은 모든 글 갯수
    function getPostsCount($type = "", $keyword = "")
    {
        $this->db->select('*')->from('posts');

        // 검색어가 있을 때
        if ($type != "" && $keyword != "") {
            $this->db->like($type, $keyword);
        }

        return $this->db->count_all_results();
    }

    // 현재 글 가져오기
    function getPost($id)
    {
        $post = $this->fetch("posts", array("id" => $id));

        if (!$post || $post->pdelete) {
            movePage("post");
        }

        return $post;
    }

    // 해당 글의 모든 첨부파일 가져오기
    function getPostFiles($pid)
    {
        $query = $this->db->select('*')->from('posts_files')->where(array("pid" => $pid))->get();
        return $query->result();
    }
}
