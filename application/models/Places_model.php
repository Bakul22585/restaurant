<?php
class Places_model extends CI_Model  {

    function get_places($id = NULL, $search='',$limit='',$start='',$sort_col=0,$sort='asc',$filter_city=0){
        $this->db->select('SQL_CALC_FOUND_ROWS places.*,city.city_name', FALSE);
        $this->db->from('places');
        $this->db->join('city', 'places.city_id = city.city_id', 'left');
        if($filter_city!=0){
            $this->db->where('places.city_id', $filter_city);
        }
        if ($id != NULL) {
            // Getting only ONE row
            $this->db->where('places.places_id', $id);
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
                $this->db->like('places.places_id', $search);
                $this->db->or_like('places.places_name', $search);
                $this->db->or_like('places.places_address', $search);
                $this->db->or_like('city.city_name', $search);
            }
            $this->db->order_by($sort_col." ".$sort);
            $query = $this->db->get();
            $data["data"] = array();
            if ($query->num_rows() > 0) {
                $data["data"] = $query->result();
            }
            $count = $this->db->query('SELECT FOUND_ROWS() AS Count');
            $data["recordsTotal"] = $this->db->count_all('places');
            $data["recordsFiltered"] = $count->row()->Count;
            return $data;
        }
    }

    function Add($data) {
        $this->db->insert('places', $data);

        // Get id of inserted record
        $id = $this->db->insert_id();
        return $id;
    }

    function Edit($id, $data) {
        $this->db->where('places_id', $id);
        $result = $this->db->update('places', $data);

        // Return
        if($result){
            return $id;
        } else {
            return false;
        }
    }

    function Delete($id) {
        $this->db->where('places_id', $id);
        $this->db->delete('places');
    }

    function getTotalPlaces() {
        $query = $this->db->select('*', FALSE)->from('places')->get();
        return $query->num_rows();
    }

    function CheckPlace($name) {
        $this->db->select('*', FALSE)->from('places');
        $query = $this->db->where('places_name', $name)->get();
        $data = $query->row();
        return $data;
    }
}