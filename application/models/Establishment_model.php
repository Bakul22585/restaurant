<?php
class Establishment_model extends CI_Model
{

    function get_establishment($id = NULL, $search = '', $limit = '', $start = '', $sort_col = 0, $sort = 'asc')
    {

        $this->db->select('SQL_CALC_FOUND_ROWS *', FALSE);
        $this->db->from('establishment');
        if ($id != NULL) {
            // Getting only ONE row
            $this->db->where('establishment.establishment_id', $id);
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
                $this->db->like('establishment_name', $search);
            }
            $this->db->order_by($sort_col . " " . $sort);
            $query = $this->db->get();
            $data["data"] = array();
            if ($query->num_rows() > 0) {
                $data["data"] = $query->result();
            }
            $count = $this->db->query('SELECT FOUND_ROWS() AS Count');
            $data["recordsTotal"] = $this->db->count_all('establishment');
            $data["recordsFiltered"] = $count->row()->Count;
            return $data;
        }
    }
    function Add($data)
    {
        $this->db->insert('establishment', $data);

        // Get id of inserted record
        $id = $this->db->insert_id();
        return $id;
    }
    function Edit($id, $data)
    {
        $this->db->where('establishment_id', $id);
        $result = $this->db->update('establishment', $data);

        // Return
        if ($result) {
            return $id;
        } else {
            return false;
        }
    }

    function Delete($id)
    {
        $this->db->where('establishment_id', $id);
        $this->db->delete('establishment');
    }

    function getTotalEstablishment()
    {
        $query = $this->db->select('*', FALSE)->from('establishment')->get();
        return $query->num_rows();
    }

    function GetFromField($where)
    {
        $this->db->select('*', FALSE)->from('establishment');
        $query = $this->db->where($where)->get();
        $data = $query->result();
        return $data;
    }

    function GetAllEstablishment()
    {
        $query = $this->db->select('*', FALSE)->from('establishment')->get();
        $data = $query->result_array();
        return $data;
    }

    function DeleteRestaurantToEstablishment($id)
    {
        $this->db->where('res_id', $id);
        $this->db->delete('res_establishment');
    }

    function AddRestaurantToEstablishment($data)
    {
        $this->db->insert_batch('res_establishment', $data);
        $id = $this->db->insert_id();
        return $id;
    }

    function GetRestaurantToEstablishment($id)
    {
        $query = $this->db->select('*', FALSE)->from('res_establishment')->where('res_id', $id)->get();
        $data = $query->result_array();
        return $data;
    }
}
