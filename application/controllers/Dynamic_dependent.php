<?php 
defined('BASEPATH') OR exit ('No direct script access allowed');
class Dynamic_dependent extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this -> load -> model('Dynamic_dependent_model');
    }
      function index()
    {
        $data['state'] = $this -> dynamic_dependent_model -> fetch_state();
        $this->load->view("dynamic_dependent_view", $data);
    }
}