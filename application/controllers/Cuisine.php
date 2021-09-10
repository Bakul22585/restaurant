<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cuisine extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('cuisine_model');
    }

    public function index()
    {
        $data['title'] = "Cuisine";

        $this->load->view('template/header', $data);
        $this->load->view('cuisine/index', $data);
        $this->load->view('template/footer', $data);
    }

    public function get_cuisine_data()
    {
        $start = $this->input->get('iDisplayStart');
        $limit = $this->input->get('iDisplayLength');
        $search = $this->input->get('sSearch');
        $sort_col = $this->input->get('iSortCol_0');
        $sort = $this->input->get('sSortDir_0');
        $filter_city = $this->input->get('filter_city');
        if ($sort_col == 0) {
            $sort_col = 'res_cuisine_id';
        }
        if ($sort_col == 1) {
            $sort_col = 'res_cuisine_name';
        }
        $result = $this->cuisine_model->get_cuisine('', $search, $limit, $start, $sort_col, $sort, $filter_city);
        $record = array();
        $k = 0;
        foreach ($result['data'] as $value) {
            $record[$k]['res_cuisine_id'] = $value->res_cuisine_id;
            $record[$k]['res_cuisine_name'] = $value->res_cuisine_name;
            $record[$k]['action'] = '<a href="javascript:void(0)" class="btn btn-success btn-flat btn-xs edit-cuisine" data-id="' . $value->res_cuisine_id . '"><i class="fa fa-edit"></i>&nbsp;&nbsp;Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" class="btn btn-danger btn-flat btn-xs delete-cuisine" data-id="' . $value->res_cuisine_id . '"><i class="fa fa-trash"></i>&nbsp;&nbsp;Delete</a>';
            $k++;
            # code...
        }
        $result['data'] = $record;
        // exit(0);
        $result['sEcho'] = $this->input->get('sEcho');
        echo json_encode($result);
        exit(0);
    }

    public function get_cuisine()
    {
        $JSON = array();
        $cuisine_id = $this->input->post('res_cuisine_id');
        if ($cuisine_id) {
            $cuisine_data = $this->cuisine_model->get_cuisine($cuisine_id);
            $JSON['flag'] = true;
            $JSON['data'] = $cuisine_data;
        } else {
            $JSON['flag'] = false;
            $JSON['msg'] = 'Something went wrong Please try again after reloading page';
        }
        echo json_encode($JSON);
        exit(0);
    }

    public function add_edit_cuisine()
    {
        $JSON = array();
        $action = $this->input->post('form-action');
        $data = array();

        $data['res_cuisine_name'] =  $this->input->post('res_cuisine_name');
        $data['res_cuisine_name_pt'] = $this->input->post('res_cuisine_name_pt');

        if ($action && $action == 'add') {
            $data['created_date'] = date('Y-m-d H:i:s');
            $id = $this->cuisine_model->Add($data);
            if (!empty($id)) {
                $JSON['flag'] = true;
                $JSON['msg'] = 'Successfully Added !!';
            } else {
                $JSON['flag'] = false;
                $JSON['msg'] = 'Something went wrong Please try again after reloading page';
            }
        } else if ($action == 'edit') {
            $res_cuisine_id = $this->input->post('res_cuisine_id');
            $data['updated_date'] = date('Y-m-d H:i:s');
            if ($res_cuisine_id && !empty($res_cuisine_id)) {
                $this->cuisine_model->Edit($res_cuisine_id, $data);
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

    public function delete_cuisine()
    {
        $JSON = array();
        $res_cuisine_id = $this->input->post('res_cuisine_id');
        if ($res_cuisine_id) {
            $this->cuisine_model->Delete($res_cuisine_id);
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
