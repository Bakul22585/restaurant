<?php
class Restaurant_model extends CI_Model
{

    function get_restaurant($id = NULL, $search = '', $limit = '', $start = '', $sort_col = 0, $sort = 'asc')
    {

        $this->db->select('SQL_CALC_FOUND_ROWS *', FALSE);
        $this->db->from('restaurant');
        if ($id != NULL) {
            // Getting only ONE row
            $this->db->where('restaurant.res_id', $id);
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
                $this->db->like('res_name', $search);
            }
            $this->db->order_by($sort_col . " " . $sort);
            $query = $this->db->get();
            $data["data"] = array();
            if ($query->num_rows() > 0) {
                $data["data"] = $query->result();
            }
            $count = $this->db->query('SELECT FOUND_ROWS() AS Count');
            $data["recordsTotal"] = $this->db->count_all('restaurant');
            $data["recordsFiltered"] = $count->row()->Count;
            return $data;
        }
    }
    function Add($data)
    {
        $this->db->insert('restaurant', $data);

        // Get id of inserted record
        $id = $this->db->insert_id();
        return $id;
    }
    function Edit($id, $data)
    {
        $this->db->where('res_id', $id);
        $result = $this->db->update('restaurant', $data);

        // Return
        if ($result) {
            return $id;
        } else {
            return false;
        }
    }

    function Delete($id)
    {
        $this->db->where('res_id', $id);
        $this->db->delete('restaurant');
    }

    function getTotalRestaurant()
    {
        $query = $this->db->select('*', FALSE)->from('restaurant')->get();
        return $query->num_rows();
    }

    function GetFromField($where)
    {
        $this->db->select('*', FALSE)->from('restaurant');
        $query = $this->db->where($where)->get();
        $data = $query->result();
        return $data;
    }

    function UploadMultipleRestaurantImage($data)
    {
        $this->db->insert_batch('res_images', $data);
        $id = $this->db->insert_id();
        return $id;
    }

    function UploadMultipleMenuRestaurantImage($data)
    {
        $this->db->insert_batch('res_menu', $data);
        $id = $this->db->insert_id();
        return $id;
    }

    function GetUploadRestaurantImage($id)
    {
        $query = $this->db->select('*', FALSE)->from('res_images')->where('res_id', $id)->get();
        $data = $query->result_array();
        return $data;
    }

    function GetUploadMenuRestaurantImage($id)
    {
        $query = $this->db->select('*', FALSE)->from('res_menu')->where('res_id', $id)->get();
        $data = $query->result_array();
        return $data;
    }

    function DeleteImage($id)
    {
        $this->db->where('Images_id', $id);
        $this->db->delete('res_images');
    }

    function DeleteMenuImage($id)
    {
        $this->db->where('res_menu_id', $id);
        $this->db->delete('res_menu');
    }

    function AddRestaurantTime($data)
    {
        $this->db->insert('res_time', $data);

        $id = $this->db->insert_id();
        return $id;
    }

    function UpdateRestaurantTime($id, $data)
    {
        $this->db->where('res_id', $id);
        $result = $this->db->update('res_time', $data);

        // Return
        if ($result) {
            return $id;
        } else {
            return false;
        }
    }

    function GetRestaurantTime($id)
    {
        $query = $this->db->select('*', FALSE)->from('res_time')->where('res_id', $id)->get();
        $data = $query->result_array();
        return $data;
    }
}
