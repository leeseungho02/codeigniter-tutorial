<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'controllers/common.php');

class Post extends common
{
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
    public function index($page = 1)
    {
        $item = 10;
        $start = ($page - 1) * $item;
        $posts = $this->post_model->getPosts($start, $item);
        $total_count = $this->post_model->getPostsCount();
        $currentNumber = $total_count - (($page - 1) * $item);
        $keyword = "";
        $type = "title";
        $this->form_validation->set_rules("keyword", "검색어", "required");

        $run = $this->form_validation->run();
        if ($run) {
            $type = $this->input->post("type");
            $keyword = $this->input->post("keyword");
            $posts = $this->post_model->getPosts($start, $item, $type, $keyword);
            $total_count = $this->post_model->getPostsCount($type, $keyword);
        }

        $datas['currentNumber'] = $currentNumber;
        $datas['keyword'] = $keyword;
        $datas['type'] = $type;
        $datas['posts'] = $posts;
        $this->pagination->initialize(getPaginationInit($item, $total_count));

        $this->pageView("post/list", $datas);
    }

    // 글 작성
    public function insert($id = 0)
    {
        $member = $this->session->userdata('member');

        $this->form_validation->set_rules("title", "제목", "required");
        $this->form_validation->set_rules("content", "내용", "required");
        $this->form_validation->set_rules("type", "타입", "required");
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
                $data['type'] = $post->type;
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
            } else {
                if (!empty($_FILES['userFile']['name'])) {
                    $this->post_model->setMessage($this->upload->display_errors());
                    backPage();
                }
            }

            $this->post_model->setMessage('글 작성 하셨습니다.', 'success');
            movePage("post");
        }

        $datas['id'] = $id;
        $this->pageView("post/insert", $datas);
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
        // if ($datas['post']->type == "private" && $datas['post']->writer != $this->session->userdata('member')->id) {
        //     $this->post_model->setMessage('비밀글은 해당 작성자만 읽기가 가능합니다.');
        //     backPage();
        // }

        $this->pageView("post/view", $datas);
    }

    // 글 수정
    public function update($id = 0)
    {
        $datas['post'] = $this->post_model->getPost($id);
        $datas['files'] = $this->post_model->getPostFiles($id);

        $this->post_model->memberAccess($datas['post']->writer);

        $this->form_validation->set_rules("title", "제목", "required");
        $this->form_validation->set_rules("content", "내용", "required");
        $this->form_validation->set_rules("type", "타입", "required");

        $run = $this->form_validation->run();
        if ($run) {
            $data = $this->post_model->makePostFromInput($this->input);
            $data["update_dt"] = createNow();

            // 첨부파일 등록 시
            if ($this->upload->do_upload("userFile")) {
                $upload_data = $this->upload->data();
                $posts_file = array(
                    "name" => $upload_data['file_name'],
                    "original_name" => $upload_data['orig_name'],
                    "path" => $upload_data['full_path'],
                    "size" => $upload_data['file_size'],
                    "pid" => $id
                );
                $this->post_model->insert("posts_files", $posts_file);
            } else {
                if (!empty($_FILES['userFile']['name'])) {
                    $this->post_model->setMessage($this->upload->display_errors());
                    backPage();
                }
            }

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

        $this->post_model->memberAccess($post->writer);
        $this->post_model->update("posts", array("pdelete" => 1), array("id" => $id));
        $this->post_model->update("posts_files", array("pfdelete" => 1), array("pid" => $id));
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

    // 작성자 처리
    public function writerCheck()
    {
        $table = $this->input->post("table");
        $pw = $this->input->post("pw");
        $data = $this->post_model->fetch($table, array("non_member_pw" => $pw));
        $result = $data ? true : false;
        echo json_encode( $result );
    }
}
