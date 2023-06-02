<?php 
defined('BASEPATH') OR exit ('No direct script access allowed');
class Proma extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this -> load -> model('proma_model');
    }
      function index()
    {
        $this->load->view("jobs");
    }

    public function jobs(){
        return $this->index();
    }
    
    public function templates(){
        $this->load->view('templates');
        // load 'templates' with data
    }
    
    public function clients(){
        $clients = $this->proma_model->create_client();
        $this->load->view('clients', array('clients'=>$clients));
    }

    public function history(){
        $this->load->view('history');
    }

    public function create_client(){
        $data['id'] = uniqid();
        $data['fullname'] = $this->input->post('name');
        $data['email'] = $this->input->post('email');
        $data['phone'] = $this->input->post('number');
        $data['notes'] = $this->input->post('notes');

        $clients = $this->proma_model->create_client($data);
        $this->load->view('clients', array('clients'=>$clients));
    }

    public function create_template(){
        $fname = $_FILES['temp-file']['name'];
        $config = array('upload_path'=> './assets/');
        $this->upload->initialize($config);
        $this->upload->do_upload('temp-file');
        echo $fname;
        /* if (isset($template['file'])){
            $fname = $_FILES['temp-file']['name'];
            echo $fname;
        } */
        //if everything is fine, pass data to model

        //return to templates page
        //echo $template['title'];
    }
}