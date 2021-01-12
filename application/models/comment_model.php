<?php

require_once(APPPATH . 'models/common_model.php');

class Comment_model extends common_model
{
    function __construct()
    {
        parent::__construct();
    }

    function getComments($id)
    {
        $query = $this->db->select('comments.*, ifnull(members.name, comments.non_member_id) name')->from('comments')->where("pid", $id)->
        join("members", "comments.writer = members.id", "left")->get();
        return $query->result();
    }
}
