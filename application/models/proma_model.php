<?php
class Proma_model extends CI_Model{
   
    function create_client($data=NULL){
        if ($data){
            $this->db->insert('clients', $data);
        }
        return $this->db->get('clients')->result();
    }

    function create_template(){
        // insert template

        // insert tasks

    }
}
?>