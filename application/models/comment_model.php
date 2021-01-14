<?php

require_once(APPPATH . 'models/common_model.php');

class Comment_model extends common_model
{
    function __construct()
    {
        parent::__construct();
    }

    // 해당 글의 모든 댓글 가져오기
    function getComments($id)
    {
        $where = array("pid" => $id, "cdelete" => false);
        $query = $this->db->select('comments.*, ifnull(members.name, comments.non_member_id) name')->from('comments')->
        where($where)->join("members", "comments.writer = members.id", "left")->order_by("comments.id DESC")->get();
        return $query->result();
    }

    // 해당 댓글 가져오기
    function getComment($id)
    {
        $comment = $this->fetch("comments", array("id" => $id));

        if (!$comment || $comment->cdelete) {
            $this->setMessage("삭제된 댓글이거나 존재하지 않은 댓글입니다.");
            backPage();
        }

        return $comment;
    }

    // 해당 댓글 삭제하기
    function deleteComment($id, $pid)
    {
        $this->update("comments", array("cdelete" => 1), array("id" => $id));
        $this->setMessage('해당 댓글 삭제 하셨습니다.', 'success');
        movePage("post/view/" . $pid);
    }
}
