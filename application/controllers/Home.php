<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('form');
    }

    public function add_item() {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('title', 'Title', 'required|min_length[3]|max_length[30]');
        $this->form_validation->set_rules('price', 'Price', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('description', 'Description', 'required');


        if ($this->form_validation->run()) {
            
        }
        $this->load->view('add_item');
    }

    private function do_upload() {
        $config = [
            'upload_path' => './uploads/',
            'allowed_types' => 'gif|jpg|png',
            'max_size' => 100
        ];

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('userfile')) {
            $error = array('error' => $this->upload->display_errors());

            $this->load->view('upload_form', $error);
        } else {
            return array('upload_data' => $this->upload->data());

        }
    }

}
