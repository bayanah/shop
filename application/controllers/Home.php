<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('form');
    }

    public function index($category_id = 0) {
        $viewData = [];
        $search = $this->input->get('search');

        $start = (int) $this->input->get('per_page');
        $limit = $this->config->item('per_page');
        $where = [];

        if ($search) {
            $where['title LIKE'] = '%' . $search . '%';
        }

        if ($category_id) {
            $where['category_id'] = (int)$category_id;
        }

        $viewData['items'] = $this->db->where($where)->limit($limit, $start)->get('items')->result();
        $this->pagination->initialize([
            'base_url' => base_url() . ($category_id ? 'category/'.$category_id :'') .($search ? '?search=' . $search : ''),
            'total_rows' => $this->db->where($where)->count_all_results('items')
        ]);
        $viewData['pagination'] = $this->pagination->create_links();

        $categories = $this->db->get('categories')->result();

        $this->load->view('inc/header', ['categories' => $categories]);
        $this->load->view('home', $viewData);
        $this->load->view('inc/footer');
    }

    public function add_item() {
        $viewData = [];

        $this->load->library('form_validation');

        $this->form_validation->set_rules('title', 'Title', 'required|min_length[3]|max_length[30]');
        $this->form_validation->set_rules('price', 'Price', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('description', 'Description', 'required');


        if ($this->form_validation->run()) {
            $upload = $this->do_upload();
            if (isset($upload['error'])) {
                $viewData['error'] = $upload['error'];
            } else {
                $insertData = [
                    'title' => $this->input->post('title'),
                    'price' => $this->input->post('price'),
                    'description' => $this->input->post('description'),
                    'image' => $upload['data']
                ];
                $this->db->insert('items', $insertData);
            }
        }
        $this->load->view('inc/header');
        $this->load->view('add_item', $viewData);
        $this->load->view('inc/footer');
    }

    public function add_category() {
        $viewData = [];
        $this->load->library('form_validation');
        $this->form_validation->set_rules('title', 'Title', 'required|min_length[3]|max_length[30]');

        if ($this->form_validation->run()) {
            $insertData = [
                'title' => $this->input->post('title'),
            ];
            $this->db->insert('categories', $insertData);
        }
        $this->load->view('inc/header');
        $this->load->view('add_category', $viewData);
        $this->load->view('inc/footer');
    }

    private function do_upload() {
        $config = [
            'upload_path' => './uploads/',
            'allowed_types' => 'gif|jpg|png',
            'max_size' => 1024,
            'encrypt_name' => TRUE
        ];

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('image')) {
            return array('error' => $this->upload->display_errors($this->config->item('error_prefix'), $this->config->item('error_suffix')));
        } else {
            return array('data' => $this->upload->data('file_name'));
        }
    }

}
