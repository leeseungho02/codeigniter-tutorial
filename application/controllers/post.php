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

        $this->load->library('upload');
        $this->load->library('pagination');

        $this->upload->initialize(getUploadInit());
        $this->pagination->initialize(getPaginationInit($this->item, $this->post_model->getPostsCount()));
    }

    // redirect php vs js
    // https://www.edureka.co/community/74742/which-is-best-window-location-js-header-php-for-redirection
    // https://stackoverflow.com/questions/15655017/window-location-js-vs-header-php-for-redirection

    // search
    // https://stackoverflow.com/questions/14374188/search-data-in-codeigniter

    // pagenation
    // https://www.guru99.com/codeigniter-pagination.html

    // 목록
    public function index($page = 0)
    {
        $datas['posts'] = $this->post_model->getPosts($this->item, $page);
        $this->pageView("post/list", $datas);
    }

    // 글 작성
    public function insert($id = 0)
    {
        $this->form_validation->set_rules("title", "제목", "required");
        $this->form_validation->set_rules("content", "내용", "required");
        $this->form_validation->set_rules("type", "타입", "required");

        $run = $this->form_validation->run();
        if ($run) {
            $data = $this->post_model->makePostFromInput($this->input);
            $data["create_dt"] = createNow();
            $member = $this->session->userdata('member');
            if ($member) {
                $data["writer"] = $member->id;
            }

            if ($id != 0) {
                $post = $this->post_model->getPost($id);
                $this->post_model->updatePlus("posts", "porder", array("pid" => $post->pid, "porder >=" => $post->porder + 1));
                $data["depth"] = $post->depth + 1;
                $data["porder"] = $post->porder + 1;
                $data["pid"] = $post->id;
            }

            $pid = $this->post_model->insert("posts", $data);

            if ($id == 0) {
                $this->post_model->update("posts", array("pid" => $pid), array("id" => $pid));
            }

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
        $datas['comments'] = $this->comment_model->getComments($id);

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
    }
}
