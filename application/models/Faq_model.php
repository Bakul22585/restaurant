<?php
class Faq_model extends CI_Model  {

    function get_faq($id = NULL, $search='',$limit='',$start='',$sort_col=0,$sort='asc'){

        $this->db->select('SQL_CALC_FOUND_ROWS *', FALSE);
        $this->db->from('faq');
        if ($id != NULL) {
            // Getting only ONE row
            $this->db->where('faq.faq_id', $id);
            $query = $this->db->get();
            if ($query->num_rows() == 1) {
                // One row, match!
                return $query->row();
            } else {
                return false;
            }
        } else {
            $this->db->limit($limit, $start);
            if(!empty($search)){
                $this->db->like('faq_question', $search);
            }
            $this->db->order_by($sort_col." ".$sort);
            $query = $this->db->get();
            $data["data"] = array();
            if ($query->num_rows() > 0) {
                $data["data"] = $query->result();
            }
            $count = $this->db->query('SELECT FOUND_ROWS() AS Count');
            $data["recordsTotal"] = $this->db->count_all('faq');
            $data["recordsFiltered"] = $count->row()->Count;
            return $data;
        }
    }
    function Add($data) {
        $this->db->insert('faq', $data);

        // Get id of inserted record
        $id = $this->db->insert_id();
        return $id;
    }
    function Edit($id, $data) {
        $this->db->where('faq_id', $id);
        $result = $this->db->update('faq', $data);

        // Return
        if($result){
            return $id;
        } else {
            return false;
        }
    }

    function Delete($id) {
        $this->db->where('faq_id', $id);
        $this->db->delete('faq');
    }
}