<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Food extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('food_model');
    }

    public function index()
    {
        $data['title'] = "Food";

        $this->load->view('template/header', $data);
        $this->load->view('food/index', $data);
        $this->load->view('template/footer', $data);
    }

    public function get_food_data()
    {
        $start = $this->input->get('iDisplayStart');
        $limit = $this->input->get('iDisplayLength');
        $search = $this->input->get('sSearch');
        $sort_col = $this->input->get('iSortCol_0');
        $sort = $this->input->get('sSortDir_0');
        $filter_city = $this->input->get('filter_city');
        if ($sort_col == 0) {
            $sort_col = 'food_id';
        }
        if ($sort_col == 1) {
            $sort_col = 'food_name';
        }
        $result = $this->food_model->get_food('', $search, $limit, $start, $sort_col, $sort, $filter_city);
        $record = array();
        $k = 0;
        foreach ($result['data'] as $value) {
            $record[$k]['food_id'] = $value->food_id;
            $record[$k]['food_name'] = $value->food_name;
            $record[$k]['action'] = '<a href="javascript:void(0)" class="btn btn-success btn-flat btn-xs edit-food" data-id="' . $value->food_id . '"><i class="fa fa-edit"></i>&nbsp;&nbsp;Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" class="btn btn-danger btn-flat btn-xs delete-food" data-id="' . $value->food_id . '"><i class="fa fa-trash"></i>&nbsp;&nbsp;Delete</a>';
            $k++;
            # code...
        }
        $result['data'] = $record;
        // exit(0);
        $result['sEcho'] = $this->input->get('sEcho');
        echo json_encode($result);
        exit(0);
    }

    public function get_food()
    {
        $JSON = array();
        $food_id = $this->input->post('food_id');
        if ($food_id) {
            $food_data = $this->food_model->get_food($food_id);
            $JSON['flag'] = true;
            $JSON['data'] = $food_data;
        } else {
            $JSON['flag'] = false;
            $JSON['msg'] = 'Something went wrong Please try again after reloading page';
        }
        echo json_encode($JSON);
        exit(0);
    }

    public function add_edit_food()
    {
        $JSON = array();
        $action = $this->input->post('form-action');
        $data = array();

        $data['food_name'] =  $this->input->post('food_name');
        $data['food_name_pt'] =  $this->input->post('food_name_pt');

        if ($action && $action == 'add') {
            $id = $this->food_model->Add($data);
            if (!empty($id)) {
                $JSON['flag'] = true;
                $JSON['msg'] = 'Successfully Added !!';
            } else {
                $JSON['flag'] = false;
                $JSON['msg'] = 'Something went wrong Please try again after reloading page';
            }
        } else if ($action == 'edit') {
            $food_id = $this->input->post('food_id');
            if ($food_id && !empty($food_id)) {
                $this->food_model->Edit($food_id, $data);
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

    public function delete_food()
    {
        $JSON = array();
        $food_id = $this->input->post('food_id');
        if ($food_id) {
            $this->food_model->Delete($food_id);
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
