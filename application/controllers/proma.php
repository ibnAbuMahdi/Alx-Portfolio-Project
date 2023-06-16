<?php 
defined('BASEPATH') OR exit ('No direct script access allowed');
class Proma extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->library('upload');
        $this -> load -> model('proma_model');

    }
    function index()
    {
        $jobs = $this->proma_model->fetch_jobs();
        $this->load->view("jobs", $jobs);
    }

    public function jobs(){
        return $this->index();
    }
    
    public function templates(){
        $this->load->view('templates', array('temps' => $this->proma_model->fetch_templates()));
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

    public function client_jobs(){
        $id = $this->uri->segment(3);
        $this->load->view('client_jobs', $this->proma_model->client_jobs($id));
    }

    public function create_job(){
        $id = $this->uri->segment(3);
        $this->load->view('create_job', $this->proma_model->fetch_template($id));
    }
    public function upload_files(){
        $tasksFile = array();
        foreach ($_FILES as $name => $value) {
            $fname = $_FILES[$name]['name'];
            $config = array(
                'upload_path'=> './assets/',
                'allowed_types' => 'png|pdf|doc|docx|jpg|jpeg|xlsx|xls|ppt',
                'max_size' => 100000000
            );
            $this->upload->initialize($config);
            if (!$this->upload->do_upload($name)){
                echo 'failed';              
            } else {
                $tasksFile[$name] = $this->upload->data()['file_name'];
            }
        }
        echo json_encode($tasksFile);
    }
    public function upload_input_files(){
        $tasksFile = array();
        foreach ($_FILES as $name => $value) {
            $fname = $_FILES[$name]['name'];
            $config = array(
                'upload_path'=> './assets/',
                'allowed_types' => 'png|pdf|doc|docx|jpg|jpeg|xlsx|xls|ppt',
                'max_size' => 100000000
            );
            $this->upload->initialize($config);
            if (!$this->upload->do_upload($name)){
                echo 'failed';              
            } else {
                $tasksFile[$name] = $this->upload->data()['file_name'];
            }
        }
        echo json_encode($tasksFile);
    }
    public function create_template(){
        // template keys: title, desc, file, tasks, tasksFile
        // task keys: title, desc, duration, unit
        $data = $_POST['temp'];
        $template = json_decode($data, true);
        echo $this->proma_model->create_template($template);  
    }
    
    public function post_job(){
        $data = $_POST['job'];
        $job = json_decode($data, true);
        echo $this->proma_model->create_job($job);  
    }

    public function get_tasks(){
        $id = $this->input->post('id');
        $c_id = $this->input->post('c_id');
        $data = $this->proma_model->get_tasks($id, $c_id);
        echo json_encode($data);
    }

    public function get_job(){
        $job_id = $this->uri->segment(3);
        $this->load->view('job_view', $this->proma_model->get_job($job_id));
    }

    public function update_job(){
        $job = $this->input->post('job');
        echo $this->proma_model->update_job(json_decode($job, true));
        // echo $job;
    }
}