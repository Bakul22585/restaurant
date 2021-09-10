<?php
class Meal_model extends CI_Model
{

    function get_meal($id = NULL, $search = '', $limit = '', $start = '', $sort_col = 0, $sort = 'asc')
    {

        $this->db->select('SQL_CALC_FOUND_ROWS *', FALSE);
        $this->db->from('meal');
        if ($id != NULL) {
            // Getting only ONE row
            $this->db->where('meal.meal_id', $id);
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
                $this->db->like('meal_name', $search);
            }
            $this->db->order_by($sort_col . " " . $sort);
            $query = $this->db->get();
            $data["data"] = array();
            if ($query->num_rows() > 0) {
                $data["data"] = $query->result();
            }
            $count = $this->db->query('SELECT FOUND_ROWS() AS Count');
            $data["recordsTotal"] = $this->db->count_all('meal');
            $data["recordsFiltered"] = $count->row()->Count;
            return $data;
        }
    }
    function Add($data)
    {
        $this->db->insert('meal', $data);

        // Get id of inserted record
        $id = $this->db->insert_id();
        return $id;
    }
    function Edit($id, $data)
    {
        $this->db->where('meal_id', $id);
        $result = $this->db->update('meal', $data);

        // Return
        if ($result) {
            return $id;
        } else {
            return false;
        }
    }

    function Delete($id)
    {
        $this->db->where('meal_id', $id);
        $this->db->delete('meal');
    }

    function getTotalMeal()
    {
        $query = $this->db->select('*', FALSE)->from('meal')->get();
        return $query->num_rows();
    }

    function GetFromField($where)
    {
        $this->db->select('*', FALSE)->from('meal');
        $query = $this->db->where($where)->get();
        $data = $query->result();
        return $data;
    }

    function GetAllMeal()
    {
        $query = $this->db->select('*', FALSE)->from('meal')->get();
        $data = $query->result_array();
        return $data;
    }

    function DeleteRestaurantToMeal($id)
    {
        $this->db->where('res_id', $id);
        $this->db->delete('res_meal');
    }

    function AddRestaurantToMeal($data)
    {
        $this->db->insert_batch('res_meal', $data);
        $id = $this->db->insert_id();
        return $id;
    }

    function GetRestaurantToMeal($id)
    {
        $query = $this->db->select('*', FALSE)->from('res_meal')->where('res_id', $id)->get();
        $data = $query->result_array();
        return $data;
    }
}
