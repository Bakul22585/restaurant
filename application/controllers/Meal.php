<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Meal extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('meal_model');
    }

    public function index()
    {
        $data['title'] = "Meal";

        $this->load->view('template/header', $data);
        $this->load->view('meal/index', $data);
        $this->load->view('template/footer', $data);
    }

    public function get_meal_data()
    {
        $start = $this->input->get('iDisplayStart');
        $limit = $this->input->get('iDisplayLength');
        $search = $this->input->get('sSearch');
        $sort_col = $this->input->get('iSortCol_0');
        $sort = $this->input->get('sSortDir_0');
        $filter_city = $this->input->get('filter_city');
        if ($sort_col == 0) {
            $sort_col = 'meal_id';
        }
        if ($sort_col == 1) {
            $sort_col = 'meal_name';
        }
        $result = $this->meal_model->get_meal('', $search, $limit, $start, $sort_col, $sort, $filter_city);
        $record = array();
        $k = 0;
        foreach ($result['data'] as $value) {
            $record[$k]['meal_id'] = $value->meal_id;
            $record[$k]['meal_name'] = $value->meal_name;
            $record[$k]['action'] = '<a href="javascript:void(0)" class="btn btn-success btn-flat btn-xs edit-meal" data-id="' . $value->meal_id . '"><i class="fa fa-edit"></i>&nbsp;&nbsp;Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" class="btn btn-danger btn-flat btn-xs delete-meal" data-id="' . $value->meal_id . '"><i class="fa fa-trash"></i>&nbsp;&nbsp;Delete</a>';
            $k++;
            # code...
        }
        $result['data'] = $record;
        // exit(0);
        $result['sEcho'] = $this->input->get('sEcho');
        echo json_encode($result);
        exit(0);
    }

    public function get_meal()
    {
        $JSON = array();
        $meal_id = $this->input->post('meal_id');
        if ($meal_id) {
            $meal_data = $this->meal_model->get_meal($meal_id);
            $JSON['flag'] = true;
            $JSON['data'] = $meal_data;
        } else {
            $JSON['flag'] = false;
            $JSON['msg'] = 'Something went wrong Please try again after reloading page';
        }
        echo json_encode($JSON);
        exit(0);
    }

    public function add_edit_meal()
    {
        $JSON = array();
        $action = $this->input->post('form-action');
        $data = array();

        $data['meal_name'] =  $this->input->post('meal_name');
        $data['meal_name_pt'] =  $this->input->post('meal_name_pt');

        if ($action && $action == 'add') {
            $id = $this->meal_model->Add($data);
            if (!empty($id)) {
                $JSON['flag'] = true;
                $JSON['msg'] = 'Successfully Added !!';
            } else {
                $JSON['flag'] = false;
                $JSON['msg'] = 'Something went wrong Please try again after reloading page';
            }
        } else if ($action == 'edit') {
            $meal_id = $this->input->post('meal_id');
            if ($meal_id && !empty($meal_id)) {
                $this->meal_model->Edit($meal_id, $data);
                $JSON['flag'] = true;
                $JSON['msg'] = 'Successfully Edited !!';
            } else {
                $JSON['flag'] = false;
                $JSON['msg'] = 'Something went wrong Please try again after reloading page';
            }
        } else {
            $JSON['flag'] = false;
            $JSON['msg'] = 'Something went wrong Please try again after reloading page';
        }
        echo json_encode($JSON);
        exit(0);
    }

    public function delete_meal()
    {
        $JSON = array();
        $meal_id = $this->input->post('meal_id');
        if ($meal_id) {
            $this->meal_model->Delete($meal_id);
            $JSON['flag'] = true;
            $JSON['msg'] = 'Successfully Deleted !!';
        } else {
            $JSON['flag'] = false;
            $JSON['msg'] = 'Something went wrong Please try again after reloading page';
        }
        echo json_encode($JSON);
        exit(0);
    }
}
