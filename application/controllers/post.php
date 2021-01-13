<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'controllers/common.php');

class Post extends common
{
    private $item = 10;

    public function __construct()
    {
        parent::__construct();

        $this->load->model('post_model');
        $this->load->model('comment_model');

        $this->load->helper('post');
        $this->load->helper('regex');

        $this->load->library('upload');
        $this->load->library('pagination');

        $this->upload->initialize(getUploadInit());
    }

    // 목록
    public function index($page = 0)
    {
        $posts = $this->post_model->getPosts($this->item, $page);
        $total_count = $this->post_model->getPostsCount();
        $keyword = "";
        $type = "title";
        $this->form_validation->set_rules("keyword", "검색어", "required");

        $run = $this->form_validation->run();
        if ($run) {
            $type = $this->input->post("type");
            $keyword = $this->input->post("keyword");
            $posts = $this->post_model->getPosts($this->item, $page, $type, $keyword);
            $total_count = $this->post_model->getPostsCount($type, $keyword);
        }

        $datas['keyword'] = $keyword;
        $datas['type'] = $type;
        $datas['posts'] = $posts;
        $this->pagination->initialize(getPaginationInit($this->item, $total_count));

        $this->pageView("post/list", $datas);
    }

    // 글 작성
    public function insert($id = 0)
    {
        $member = $this->session->userdata('member');

        $this->form_validation->set_rules("title", "제목", "required");
        $this->form_validation->set_rules("content", "내용", "required");
        $this->form_validation->set_rules("type", "타입", "required");
        $this->form_validation->set_rules('userFile', 'Document', 'file_selected_check');
        if (!$member) {
            $this->form_validation->set_rules("non_member_id", "비회원 아이디", "required");
            $this->form_validation->set_rules("non_member_pw", "비회원 비밀번호", "required|regex_check");
            $this->form_validation->set_message('regex_check', '영문 대소문자, 숫자, 특수문자 중 2종류 조합 8글자이상 20글자이하');
        }

        $run = $this->form_validation->run();
        if ($run) {
            $data = $this->post_model->makePostFromInput($this->input);
            $data["create_dt"] = createNow();

            if ($member) {
                $data["writer"] = $member->id;
            } else {
                $data["non_member_id"] = $this->input->post("non_member_id");
                $data["non_member_pw"] = $this->input->post("non_member_pw");
            }

            // 답글 작성 시
            if ($id != 0) {
                $post = $this->post_model->getPost($id);
                $this->post_model->updatePlus("posts", "porder", array("pid" => $post->pid, "porder >=" => $post->porder + 1));
                $data["depth"] = $post->depth + 1;
                $data["porder"] = $post->porder + 1;
                $data["pid"] = $post->id;
            }

            $pid = $this->post_model->insert("posts", $data);

            // 글 작성 시
            if ($id == 0) {
                $this->post_model->update("posts", array("pid" => $pid), array("id" => $pid));
            }

            // 첨부파일 등록 시
            if ($this->upload->do_upload("userFile")) {
                $upload_data = $this->upload->data();
                $posts_file = array(
                    "name" => $upload_data['file_name'],
                    "original_name" => $upload_data['orig_name'],
                    "path" => $upload_data['full_path'],
                    "size" => $upload_data['file_size'],
                    "pid" => $pid
                );
                $this->post_model->insert("posts_files", $posts_file);
                $this->post_model->setMessage('글 작성 하셨습니다.', 'success');
                movePage("post");
            } else {
                $this->post_model->setMessage($this->upload->display_errors());
            }
        }

        $this->pageView("post/insert");
    }

    // 글 상세보기
    public function view($id = 0)
    {
        // 조회 수 증가
        $this->post_model->updatePlus("posts", "hit", array("id" => $id));

        $datas['post'] = $this->post_model->getPost($id);
        $datas['files'] = $this->post_model->getPostFiles($id);
        $datas['comments'] = $this->comment_model->getComments($id);

        // 비밀글 권한
        if ($datas['post']->type == "private" && $datas['post']->writer != $this->session->userdata('member')->id) {
            $this->post_model->setMessage('비밀글은 해당 작성자만 읽기가 가능합니다.');
            backPage();
        }

        $this->pageView("post/view", $datas);
    }

    // 글 수정
    public function update($id = 0)
    {
        $datas['post'] = $this->post_model->getPost($id);
        $datas['files'] = $this->post_model->getPostFiles($id);

        $this->form_validation->set_rules("title", "제목", "required");
        $this->form_validation->set_rules("content", "내용", "required");
        $this->form_validation->set_rules("type", "타입", "required");

        $run = $this->form_validation->run();
        if ($run) {
            $data = $this->post_model->makePostFromInput($this->input);
            $data["update_dt"] = createNow();
            $this->post_model->update("posts", $data, array("id" => $id));
            $this->post_model->setMessage('해당 글 수정 하셨습니다.', 'success');
            movePage("post/view/" . $id);
        }

        $this->pageView("post/update", $datas);
    }

    // 글 삭제
    public function delete($id = 0)
    {
        $post = $this->post_model->getPost($id);

        $this->post_model->update("posts", array("pdelete" => 1), array("id" => $id));
        $this->comment_model->update("comments", array("cdelete" => 1), array("pid" => $id));
        $this->post_model->setMessage('해당 글 삭제 하셨습니다.', 'success');

        movePage("post/index");
    }

    // 파일 삭제
    public function fileDelete($id = 0)
    {
        $file = $this->post_model->getPostFile($id);

        $this->post_model->update("posts_files", array("pfdelete" => 1), array("id" => $file->id));

        backPage();
    }
}
