<?php
class Interesttags_model extends CI_Model  {

    function GetSingleFromField($where) {
        $this->db->select('*', FALSE)->from('interest_tags');
        $query = $this->db->where($where)->get();
        $data = $query->row();
        return $data;
    }

    function GetFromField($where) {
        $this->db->select('*', FALSE)->from('interest_tags');
        $query = $this->db->where($where)->get();
        $data = $query->result();
        return $data;
    }

    function Add($data) {
        $this->db->insert('interest_tags', $data);
        // Get id of inserted record
        $id = $this->db->insert_id();
        return $id;
    }

    function deleteAllTag($places_id) {
        $this->db->where('places_id', $places_id);
        $this->db->delete('interest_tags');
    }

    function deleteTag($category_id, $places_id) {
        $this->db->where('category_id', $category_id);
        $this->db->where('places_id', $places_id);
        $this->db->delete('interest_tags');
    }
}