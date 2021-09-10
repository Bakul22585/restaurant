<?php
class Cuisine_model extends CI_Model
{

    function get_cuisine($id = NULL, $search = '', $limit = '', $start = '', $sort_col = 0, $sort = 'asc')
    {

        $this->db->select('SQL_CALC_FOUND_ROWS *', FALSE);
        $this->db->from('res_cuisine');
        if ($id != NULL) {
            // Getting only ONE row
            $this->db->where('res_cuisine.res_cuisine_id', $id);
            $query = $this->db->get();
            if ($query->num_rows() == 1) {
                // One row, match!
                return $query->row();
            } else {
                return false;
            }
        } else {
            $this->db->limit($limit, $start);
            if (!empty($search)) {
                $this->db->like('res_cuisine_name', $search);
            }
            $this->db->order_by($sort_col . " " . $sort);
            $query = $this->db->get();
            $data["data"] = array();
            if ($query->num_rows() > 0) {
                $data["data"] = $query->result();
            }
            $count = $this->db->query('SELECT FOUND_ROWS() AS Count');
            $data["recordsTotal"] = $this->db->count_all('res_cuisine');
            $data["recordsFiltered"] = $count->row()->Count;
            return $data;
        }
    }
    function Add($data)
    {
        $this->db->insert('res_cuisine', $data);

        // Get id of inserted record
        $id = $this->db->insert_id();
        return $id;
    }
    function Edit($id, $data)
    {
        $this->db->where('res_cuisine_id', $id);
        $result = $this->db->update('res_cuisine', $data);

        // Return
        if ($result) {
            return $id;
        } else {
            return false;
        }
    }

    function Delete($id)
    {
        $this->db->where('res_cuisine_id', $id);
        $this->db->delete('res_cuisine');
    }

    function getTotalCuisine()
    {
        $query = $this->db->select('*', FALSE)->from('res_cuisine')->get();
        return $query->num_rows();
    }

    function GetFromField($where)
    {
        $this->db->select('*', FALSE)->from('res_cuisine');
        $query = $this->db->where($where)->get();
        $data = $query->result();
        return $data;
    }

    function GetAllCuisine()
    {
        $query = $this->db->select('*', FALSE)->from('res_cuisine')->get();
        $data = $query->result_array();
        return $data;
    }

    function DeleteRestaurantToCuisine($id)
    {
        $this->db->where('res_id', $id);
        $this->db->delete('res_type');
    }

    function AddRestaurantToCuisine($data)
    {
        $this->db->insert_batch('res_type', $data);
        $id = $this->db->insert_id();
        return $id;
    }

    function GetRestaurantToCuisineData($id) 
    {
        $query = $this->db->select('*', FALSE)->from('res_type')->where('res_id', $id)->get();
        $data = $query->result_array();
        return $data;
    }
}
