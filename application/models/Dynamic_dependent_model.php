<?php
class dynamic_dependent_model extends CI_Model{
function fetch_state(){
    $this->db->order_by('state', 'ASC');
    $query = $this->db->get('state');
    return $query->$result();
}

}
?>