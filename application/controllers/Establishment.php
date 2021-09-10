<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Establishment extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('establishment_model');
    }

    public function index()
    {
        $data['title'] = "Establishment";

        // $data['total_restaurant'] = $this->establishment_model->getTotalEstablishment();
        // $data['total_places'] = $this->places_model->getTotalPlaces();

        $this->load->view('template/header', $data);
        $this->load->view('establishment/index', $data);
        $this->load->view('template/footer', $data);
    }

    public function get_establishment_data()
    {
        $start = $this->input->get('iDisplayStart');
        $limit = $this->input->get('iDisplayLength');
        $search = $this->input->get('sSearch');
        $sort_col = $this->input->get('iSortCol_0');
        $sort = $this->input->get('sSortDir_0');
        $filter_city = $this->input->get('filter_city');
        if ($sort_col == 0) {
            $sort_col = 'establishment_id';
        }
        if ($sort_col == 1) {
            $sort_col = 'establishment_name';
        }
        $result = $this->establishment_model->get_establishment('', $search, $limit, $start, $sort_col, $sort, $filter_city);
        $record = array();
        $k = 0;
        foreach ($result['data'] as $value) {
            $record[$k]['establishment_id'] = $value->establishment_id;
            $record[$k]['establishment_name'] = $value->establishment_name;
            $record[$k]['action'] = '<a href="javascript:void(0)" class="btn btn-success btn-flat btn-xs edit-establishment" data-id="' . $value->establishment_id . '"><i class="fa fa-edit"></i>&nbsp;&nbsp;Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" class="btn btn-danger btn-flat btn-xs delete-establishment" data-id="' . $value->establishment_id . '"><i class="fa fa-trash"></i>&nbsp;&nbsp;Delete</a>';
            $k++;
            # code...
        }
        $result['data'] = $record;
        // exit(0);
        $result['sEcho'] = $this->input->get('sEcho');
        echo json_encode($result);
        exit(0);
    }

    public function get_establishment()
    {
        $JSON = array();
        $establishment_id = $this->input->post('establishment_id');
        if ($establishment_id) {
            $establishment_data = $this->establishment_model->get_establishment($establishment_id);
            $JSON['flag'] = true;
            $JSON['data'] = $establishment_data;
        } else {
            $JSON['flag'] = false;
            $JSON['msg'] = 'Something went wrong Please try again after reloading page';
        }
        echo json_encode($JSON);
        exit(0);
    }

    public function add_edit_establishment()
    {
        $JSON = array();
        $action = $this->input->post('form-action');
        $data = array();

        $data['establishment_name'] =  $this->input->post('establishment_name');
        $data['establishment_name_pt'] =  $this->input->post('establishment_name_pt');

        if ($action && $action == 'add') {
            $id = $this->establishment_model->Add($data);
            if (!empty($id)) {
                $JSON['flag'] = true;
                $JSON['msg'] = 'Successfully Added !!';
            } else {
                $JSON['flag'] = false;
                $JSON['msg'] = 'Something went wrong Please try again after reloading page';
            }
        } else if ($action == 'edit') {
            $establishment_id = $this->input->post('establishment_id');
            if ($establishment_id && !empty($establishment_id)) {
                $this->establishment_model->Edit($establishment_id, $data);
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

    public function delete_establishment()
    {
        $JSON = array();
        $establishment_id = $this->input->post('establishment_id');
        if ($establishment_id) {
            $this->establishment_model->Delete($establishment_id);
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
