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
        $this->load->view('landing_page');
    }

    public function jobs(){
        $email = $this->session->userdata('user_email');
        $jobs = $this->proma_model->fetch_jobs($email);
        $this->load->view("jobs", $jobs);
    }
    
    public function templates(){
        $email = $this->session->userdata('user_email');
        $this->load->view('templates', array('temps' => $this->proma_model->fetch_templates($email)));
    }
    
    public function clients(){
        $email = $this->session->userdata('user_email');
        $clients = $this->proma_model->create_client($email);
        $this->load->view('clients', array('clients'=>$clients));
    }

    public function history(){
        $email = $this->session->userdata('user_email');
        $this->load->view('history', $this->proma_model->fetch_jobs($email, true));
    }

    public function create_client(){
        $data['id'] = uniqid();
        $data['fullname'] = $this->input->post('name');
        $data['email'] = $this->input->post('email');
        $data['phone'] = $this->input->post('phone');
        $data['notes'] = $this->input->post('notes');

        $email = $this->session->userdata('user_email');

        $clients = $this->proma_model->create_client($email, $data);
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
                'upload_path'=> './assets/images/',
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
                'upload_path'=> './assets/images/',
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

    public function delete_client(){
        $id = $this->uri->segment(3);
        $this->proma_model->delete_client($id);
        redirect('Proma/clients', 'refresh');
    }
    public function delete_template(){
        $id = $this->uri->segment(3);
        $this->proma_model->delete_template($id);
        redirect('Proma/templates', 'refresh');
    }

    public function create_user(){
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $password = md5(trim($password));
        $resp = $this->proma_model->create_user($email, $password);
        if($resp == 'success'){
            $this->session->set_userdata('user_email', $email);
            redirect('Proma/jobs');
        }else if($resp == 'invalid'){
            $this->session->set_flashdata('invalid email', 'yes');
            redirect('Proma/index', 'refresh');   
        }
    }

    public function sign_out(){
        session_destroy();
        redirect('Proma/index');
    }

    public function download(){
        $file = $this->uri->segment(3);
        if (file_exists('assets/images/'.$file)){
            force_download('assets/images/'.$file, NULL);
        } else {
            $id = $this->uri->segment(4);
            redirect('Proma/get_job/'.$id, 'refresh');
        }
    }

    public function sign_in(){
        $this->load->view('sign_in');
    }

    public function log_in(){
        $email = $this->input->post('email');
        $pword = $this->input->post('password');
        $resp = $this->proma_model->log_in($email, $pword);
        if ($resp){
            $this->session->set_userdata('user_email', $email);
            redirect('Proma/jobs');
        } else {
            $this->session->set_flashdata('invalid email pword', 'Password or email invalid!');
            redirect('Proma/sign_in', 'refresh');   
        }
    }
}
