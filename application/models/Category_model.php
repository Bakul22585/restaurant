<?php
class Category_model extends CI_Model  {

    function get_category($id = NULL, $search='',$limit='',$start='',$sort_col=0,$sort='asc'){

        $this->db->select('SQL_CALC_FOUND_ROWS *', FALSE);
        $this->db->from('category');
        if ($id != NULL) {
            // Getting only ONE row
            $this->db->where('category.category_id', $id);
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
                $this->db->like('category_name', $search);
            }
            $this->db->order_by($sort_col." ".$sort);
            $query = $this->db->get();
            $data["data"] = array();
            if ($query->num_rows() > 0) {
                $data["data"] = $query->result();
            }
            $count = $this->db->query('SELECT FOUND_ROWS() AS Count');
            $data["recordsTotal"] = $this->db->count_all('category');
            $data["recordsFiltered"] = $count->row()->Count;
            return $data;
        }
    }
    function Add($data) {
        $this->db->insert('category', $data);

        // Get id of inserted record
        $id = $this->db->insert_id();
        return $id;
    }
    function Edit($id, $data) {
        $this->db->where('category_id', $id);
        $result = $this->db->update('category', $data);

        // Return
        if($result){
            return $id;
        } else {
            return false;
        }
    }

    function Delete($id) {
        $this->db->where('category_id', $id);
        $this->db->delete('category');
    }

    function GetFromField($where) {
        $this->db->select('*', FALSE)->from('category');
        $query = $this->db->where($where)->get();
        $data = $query->result();
        return $data;
    }
}