<?php
class Cityimages_model extends CI_Model  {

    function GetSingleFromField($where) {
        $this->db->select('*', FALSE)->from('city_images');
        $query = $this->db->where($where)->get();
        $data = $query->row();
        return $data;
    }

    function GetFromField($where) {
        $this->db->select('*', FALSE)->from('city_images');
        $query = $this->db->where($where)->get();
        $data = $query->result();
        return $data;
    }

    function Add($data) {
        $this->db->insert('city_images', $data);
        // Get id of inserted record
        $id = $this->db->insert_id();
        return $id;
    }

    function Delete($city_image_id) {
        $this->db->where('city_image_id', $city_image_id);
        $this->db->delete('city_images');
    }
}