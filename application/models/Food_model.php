<?php
class Food_model extends CI_Model
{

    function get_food($id = NULL, $search = '', $limit = '', $start = '', $sort_col = 0, $sort = 'asc')
    {

        $this->db->select('SQL_CALC_FOUND_ROWS *', FALSE);
        $this->db->from('food');
        if ($id != NULL) {
            // Getting only ONE row
            $this->db->where('food.food_id', $id);
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
                $this->db->like('food_name', $search);
            }
            $this->db->order_by($sort_col . " " . $sort);
            $query = $this->db->get();
            $data["data"] = array();
            if ($query->num_rows() > 0) {
                $data["data"] = $query->result();
            }
            $count = $this->db->query('SELECT FOUND_ROWS() AS Count');
            $data["recordsTotal"] = $this->db->count_all('food');
            $data["recordsFiltered"] = $count->row()->Count;
            return $data;
        }
    }
    function Add($data)
    {
        $this->db->insert('food', $data);

        // Get id of inserted record
        $id = $this->db->insert_id();
        return $id;
    }
    function Edit($id, $data)
    {
        $this->db->where('food_id', $id);
        $result = $this->db->update('food', $data);

        // Return
        if ($result) {
            return $id;
        } else {
            return false;
        }
    }

    function Delete($id)
    {
        $this->db->where('food_id', $id);
        $this->db->delete('food');
    }

    function getTotalFood()
    {
        $query = $this->db->select('*', FALSE)->from('food')->get();
        return $query->num_rows();
    }

    function GetFromField($where)
    {
        $this->db->select('*', FALSE)->from('food');
        $query = $this->db->where($where)->get();
        $data = $query->result();
        return $data;
    }

    function GetAllFood()
    {
        $query = $this->db->select('*', FALSE)->from('food')->get();
        $data = $query->result_array();
        return $data;
    }

    function DeleteRestaurantToFood($id)
    {
        $this->db->where('res_id', $id);
        $this->db->delete('res_food');
    }

    function AddRestaurantToFood($data)
    {
        $this->db->insert_batch('res_food', $data);
        $id = $this->db->insert_id();
        return $id;
    }

    function GetRestaurantToFood($id)
    {
        $query = $this->db->select('*', FALSE)->from('res_food')->where('res_id', $id)->get();
        $data = $query->result_array();
        return $data;
    }
}
