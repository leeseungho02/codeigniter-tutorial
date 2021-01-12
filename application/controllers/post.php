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

    // redirect php vs js
    // https://www.edureka.co/community/74742/which-is-best-window-location-js-header-php-for-redirection
    // https://stackoverflow.com/questions/15655017/window-location-js-vs-header-php-for-redirection

    // search
    // https://stackoverflow.com/questions/14374188/search-data-in-codeigniter

    // pagenation
    // https://www.guru99.com/codeigniter-pagination.html

    // 2020-01-12 점검 피드백
    // 회원수정 비밀번호 확인 추가
    // 글 수정 시 첨부파일 수정
    // 페이지네이션 수정
    // 로그인 시 비밀번호 변경 창 발생
    // 탈퇴한 회원 비밀번호 찾기 가능
    // 비밀번호 찾기 시 인증 추가
    // 비밀글 권한 수정
    // 목록 정렬 수정
    // 글 작성 시 첨부파일 없을때 오류 수정
    // 첨부파일 확장자 에러
    // 글 타입 수정
    // 글, 댓글 수정, 삭제 권한 처리 수정
    // 댓글 수정 삭제 시 비밀번호 여부

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
            } else {
                var_dump($this->upload->display_errors());
                // $error = array('error' => $this->upload->display_errors());
            }

            movePage("post");
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
        $post = $this->post_model->getPost($id);
        $member = $this->session->userdata('member');

        if (!$member || $post->writer != $member->id) {
            backPage();
        }

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

        $this->pageView("post/update", $post);
    }

    // 글 삭제
    public function delete($id = 0)
    {
        $post = $this->post_model->getPost($id);
        $member = $this->session->userdata('member');

        if (!$member || $post->writer != $member->id) {
            backPage();
        }

        $this->post_model->update("posts", array("pdelete" => 1), array("id" => $id));
        $this->comment_model->update("comments", array("cdelete" => 1), array("pid" => $id));
        $this->post_model->setMessage('해당 글 삭제 하셨습니다.', 'success');

        movePage("post/index");
    }
}
