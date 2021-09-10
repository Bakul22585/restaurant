<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('user_model');
        if ($this->session->userdata('username')) {
            redirect('dashboard', 'redirect');
        }
    }

    public function index() {
        $this->load->view('login');
    }

    public function validate() {
        //Including validation library
        $this->load->library('form_validation');

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><span>', '</div></span>');

        //Validating Fields
        $rules[] = array('field' => 'username', 'label' => 'Username', 'rules' => 'required');
        $rules[] = array('field' => 'password', 'label' => 'Password', 'rules' => 'required|callback_validate_login', 'errors' => array('validate_login' => 'Incorrect username or password.'));

        $this->form_validation->set_rules($rules);
        echo date("Y-m-d", strtotime(date("Y-m-1")));
        echo "</br>" . date("Y-m-t");

        if ($this->form_validation->run() == FALSE) {
            // Validation failed
            return $this->index();
        } else {
            // Validation succeeded!
            redirect('dashboard', 'redirect');
        }
    }

    public function validate_login($str) {
        $this->load->helper('cookie');
        // Create array for database fields & data
        $data = array();
        $data['username'] = $this->input->post('username');
        $data['password'] = $str;

        $user = $this->user_model->ValidateLogin($data);
        if (count($user['records']) == 1) {
            $this->session->set_userdata(array('username' => $user['records'][0]->username,
                'user_id' => $user['records'][0]->id
            ));

            if ($this->input->post('remember')) {
                set_cookie(array(
                    'name' => 'username',
                    'value' => $data['user_name'],
                    'expire' => '86500',
                    'prefix' => 'lark_'
                ));
                set_cookie(array(
                    'name' => 'password',
                    'value' => $data['user_password'],
                    'expire' => '86500',
                    'prefix' => 'lark_'
                ));
            }
            return true;
        } else {
            return false;
        }
    }
}
