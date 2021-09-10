<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faq extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('faq_model');
    }

    public function index()
    {
        $data['title'] = "Lark | Faq";

        $this->load->view('template/header', $data);
        $this->load->view('faq/index', $data);
        $this->load->view('template/footer', $data);
    }

    public function get_faq(){
        $JSON = array();
        $faq_id = $this->input->post('faq_id');
        if($faq_id){
            $faq_data = $this->faq_model->get_faq($faq_id);
            $JSON['flag'] = true;
            $JSON['data'] = $faq_data;
        }else{
            $JSON['flag'] = false;
            $JSON['msg'] = 'Something went wrong Please try again after reloading page';
        }
        echo json_encode($JSON);
        exit(0);
    }

    public function get_faq_data(){
        $start = $this->input->get('iDisplayStart');
        $limit = $this->input->get('iDisplayLength');
        $search = $this->input->get('sSearch');
        $sort_col = $this->input->get('iSortCol_0');
        $sort = $this->input->get('sSortDir_0');
        if($sort_col == 0){
            $sort_col = 'faq_question';
        }
        $result = $this->faq_model->get_faq('',$search,$limit,$start,$sort_col,$sort);
        $record = array();
        $k = 0;
        foreach ($result['data'] as $value) {
            $record[$k]['faq_question']=$value->faq_question;
            $record[$k]['faq_ans']=$value->faq_ans;
            $record[$k]['action']='<a href="javascript:void(0)" class="btn btn-success btn-flat btn-xs edit-faq" data-id="'.$value->faq_id.'"><i class="fa fa-edit"></i>&nbsp;&nbsp;Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" class="btn btn-danger btn-flat btn-xs delete-faq" data-id="'.$value->faq_id.'"><i class="fa fa-trash"></i>&nbsp;&nbsp;Delete</a>';
            $k++;
        }
        $result['data'] = $record;
        // exit(0);
        $result['sEcho'] = $this->input->get('sEcho');
        echo json_encode($result);
        exit(0);
    }

    public function add_edit_faq(){
        $JSON = array();
        $this->load->library('form_validation');
        $action = $this->input->post('form-action');
        $formConfig = array(
            array(
                'field' => 'faq_question',
                'label' => 'Faq Question',
                'rules' => 'trim|required',
                array(
                    'required'   => '%s required',
                )
            )
        );
        $this->form_validation->set_rules($formConfig);
        if($this->form_validation->run() == FALSE){
            $JSON['flag']= false;
            $JSON['msg'] = 'Please Check Form!!';
        }else{
            $data = array();
            $data['faq_question'] =  $this->input->post('faq_question');
            $data['faq_ans'] =  $this->input->post('faq_ans');
            if($action && $action == 'add'){
                $id = $this->faq_model->Add($data);
                if(!empty($id)){
                    $JSON['flag'] = true;
                    $JSON['msg'] = 'Successfully Added !!';
                }else{
                    $JSON['flag'] = false;
                    $JSON['msg'] = 'Something went wrong Please try again after reloading page';
                }
            }else if($action == 'edit'){
                $faq_id = $this->input->post('faq_id');
                if($faq_id && !empty($faq_id)){
                    $this->faq_model->Edit($faq_id,$data);
                    $JSON['flag'] = true;
                    $JSON['msg'] = 'Successfully Edited !!';
                }else{
                    $JSON['flag'] = false;
                    $JSON['msg'] = 'Something went wrong Please try again after reloading page';
                }
            }else{
                $JSON['flag'] = false;
                $JSON['msg'] = 'Something went wrong Please try again after reloading page';
            }
        }
        echo json_encode($JSON);
        exit(0);
    }

    public function delete_faq(){
        $JSON = array();

        $faq_id = $this->input->post('faq_id');
        if($faq_id){
            $this->faq_model->Delete($faq_id);
            $JSON['flag'] = true;
            $JSON['msg'] = 'Successfully Deleted !!';
        }else{
            $JSON['flag'] = false;
            $JSON['msg'] = 'Something went wrong Please try again after reloading page';
        }
        echo json_encode($JSON);
        exit(0);
    }
}
