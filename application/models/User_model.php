<?php

Class User_model extends CI_Model {
    
    function Get($id = NULL, $search = array()) {
      $this->db->select('SQL_CALC_FOUND_ROWS *', FALSE);
      $this->db->from('user');
      // Check if we're getting one row or all records
      if($id != NULL){
        // Getting only ONE row
        $this->db->where('user_id', $id);
        $this->db->limit('1');
        $query = $this->db->get();
        if( $query->num_rows() == 1 ) {
          // One row, match!
          return $query->row();        
        } else {
          // None
          return false;
        }
      } else {
        // Get all
        if(!empty($search)) {
            $defaultSearch = array(
                'username'     =>  '',
                'password' => '',
                'id' => '',
                
            );
            $search = array_merge($defaultSearch, $search);
            if($search['username'] != '') {
                $this->db->like('username', $search['username']); 
            }
            if($search['id'] != '') {
                $this->db->where('id', $search['id']); 
            }
            if($search['password'] != '') {
                $this->db->where('password', $search['password']); 
            }
            if($search['reset_password_code'] != '') {
                $this->db->where('reset_password_code', $search['reset_password_code']); 
            }
            if($search['signup_hash'] != '') {
                $this->db->where('signup_hash', $search['signup_hash']); 
            }
            if(isset($search['order'])) {
                $order = $search['order'];
                if($order[0]['column'] == 1) {
                    $orderby = "username ".strtoupper($order[0]['dir']);
                }
                $this->db->order_by($orderby);
            }
            if(isset($search['start'])) {
                $start = $search['start'];
                $length = $search['length'];
                if($length != -1) {
                    $this->db->limit($length, $start);
                }
            }
        }
        $query = $this->db->get();
        $data["records"] = array();
        if($query->num_rows() > 0) {
          // Got some rows, return as assoc array
            $data["records"] = $query->result();
        }
        $count = $this->db->query('SELECT FOUND_ROWS() AS Count');
        $data["countTotal"] = $this->db->count_all('user');
        $data["countFiltered"] = $count->row()->Count;
        return $data;
      }
    }

    function Add($data) {
        // Run query to insert blank row

        $this->db->insert('user', $data);
        // Get id of inserted record
        $id = $this->db->insert_id();
                
         return $this->db->affected_rows();
    }

    function Edit($id, $data) {
        $this->db->where('id', $id);
        $result = $this->db->update('user', $data);
        
        
        // Return
        if($result){
            return $id;
        } else {
            return false;
        }
    }
    
    function Delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('user'); 
    }

    function ValidateLogin($credentials) {
        $this->db->select('*', FALSE);
        $this->db->from('user_admin');
        $this->db->where('user_email', $credentials['username']); 
        $this->db->or_where('username', $credentials['username']); 
        $query = $this->db->get();

        $data["records"] = array();
        if($query->num_rows() == 1) {
            $data["records"] = $query->result();
            if($data['records'][0]->password != $credentials['password']) {
                $data["records"] = array();
            }
        }
        return $data;
    }

    function ValidateEmail($credentials) {
        $this->db->select('*', FALSE);
        $this->db->from('user');
        $this->db->where('user_email', $credentials['user_email']); 
        $query = $this->db->get();
        $data["records"] = array();
        if($query->num_rows() == 1) {
            $data["records"] = $query->row();
            
        }
        return $data;
    }
}