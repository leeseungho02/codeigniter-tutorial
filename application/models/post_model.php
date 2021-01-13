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
    function getPosts($start, $end, $type = "", $keyword = "")
    {
        $this->db->select('*')->from('posts');

        // 검색어가 있을 때
        if ($type != "" && $keyword != "") {
            $this->db->like($type, $keyword);
        }
        
        $this->db->order_by('pid DESC, porder ASC, depth DESC');
        $this->db->limit($end, $start);

        $query = $this->db->get();
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
            $this->setMessage("삭제된 글이거나 존재하지 않은 글입니다.");
            movePage("post");
        }

        return $post;
    }

    // 해당 글의 모든 첨부파일 가져오기
    function getPostFiles($pid)
    {
        $query = $this->db->select('*')->from('posts_files')->where(array("pid" => $pid, "pfdelete" => false))->get();
        return $query->result();
    }

    // 해당 글의 해당 첨부파일 가져오기
    function getPostFile($id)
    {
        $file = $this->fetch("posts_files", array("id" => $id));

        if (!$file) {
            $this->setMessage("존재하지 않은 첨부파일 입니다.");
            backPage();
        }

        return $file;
    }
}
