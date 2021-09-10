<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class City extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('city_model');
        $this->load->model('cityimages_model');
    }

    public function index()
    {
        $data['title'] = "Lark | City";

        $this->load->view('template/header', $data);
        $this->load->view('city/index', $data);
        $this->load->view('template/footer', $data);
    }

    public function get_city(){
        $JSON = array();
        $city_id = $this->input->post('city_id');
        if($city_id){
            $city_data = $this->city_model->get_city($city_id);
            $JSON['flag'] = true;
            $JSON['data'] = $city_data;
        }else{
            $JSON['flag'] = false;
            $JSON['msg'] = 'Something went wrong Please try again after reloading page';
        }
        echo json_encode($JSON);
        exit(0);
    }

    public function get_city_data(){
        $start = $this->input->get('iDisplayStart');
        $limit = $this->input->get('iDisplayLength');
        $search = $this->input->get('sSearch');
        $sort_col = $this->input->get('iSortCol_0');
        $sort = $this->input->get('sSortDir_0');
        if($sort_col == 0){
            $sort_col = 'city_name';
        }
        $result = $this->city_model->get_city('',$search,$limit,$start,$sort_col,$sort);
        $record = array();
        $k = 0;
        foreach ($result['data'] as $value) {
            $record[$k]['city_name']=$value->city_name;
            $record[$k]['action']='<a href="javascript:void(0)" class="btn btn-success btn-flat btn-xs edit-city" data-id="'.$value->city_id.'"><i class="fa fa-edit"></i>&nbsp;&nbsp;Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" class="btn btn-danger btn-flat btn-xs delete-city" data-id="'.$value->city_id.'"><i class="fa fa-trash"></i>&nbsp;&nbsp;Delete</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" class="btn btn-info btn-flat btn-xs view-city-images" data-id="'.$value->city_id.'"><i class="fa fa-eye"></i>&nbsp;&nbsp;View Images</a>';
            $k++;
        }
        $result['data'] = $record;
        // exit(0);
        $result['sEcho'] = $this->input->get('sEcho');
        echo json_encode($result);
        exit(0);
    }

    public function add_edit_city(){
        $JSON = array();
        $this->load->library('form_validation');
        $action = $this->input->post('form-action');
        $formConfig = array(
            array(
                'field' => 'city_name',
                'label' => 'City Name',
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
            if($_FILES['city_cover_image']['name']!=''){
                $uploadPath = C_IMG_PATH;
                $config['upload_path'] = $uploadPath;
                $config['allowed_types'] = 'jpeg|jpg|png|gif';
                $config['max_size'] = '20480000';
                $config['encrypt_name'] = true;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if($this->upload->do_upload('city_cover_image')){
                    $fileData = $this->upload->data();
                    $data['city_cover_image'] = $fileData['file_name'];
                }
            }
            $data['city_name'] =  $this->input->post('city_name');
            $data['city_description'] =  $this->input->post('city_description');
            $data['city_type'] =  $this->input->post('city_type');
            $data['inapp_product'] = ($this->input->post('inapp_product')) ? $this->input->post('inapp_product') : '';
            $data['city_price'] =  $this->input->post('city_price');
            $data['popular_interests'] =  $this->input->post('popular_interests');
            $data['version'] = ($this->input->post('version')!='') ? $this->input->post('version') : 0;
            if($action && $action == 'add'){
                $data['created_date'] =  date('Y-m-d H:i:s');
                $c_id = $id = $this->city_model->Add($data);
                if(!empty($id)){
                    $JSON['flag'] = true;
                    $JSON['msg'] = 'Successfully Added !!';
                }else{
                    $JSON['flag'] = false;
                    $JSON['msg'] = 'Something went wrong Please try again after reloading page';
                }
            }else if($action == 'edit'){
                $data['updated_date'] =  date('Y-m-d H:i:s');
                $c_id = $city_id = $this->input->post('city_id');
                if($city_id && !empty($city_id)){
                    $this->city_model->Edit($city_id,$data);
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
            if($_FILES['city_other_images']['name'][0]!=''){
                $files = $_FILES;
                $cpt = count($_FILES['city_other_images']['name']);
                for($i=0; $i<$cpt; $i++){
                    $uploadPath = C_IMG_PATH;
                    $config['upload_path'] = $uploadPath;
                    $config['allowed_types'] = 'jpeg|jpg|png|gif';
                    $config['max_size'] = '0';
                    $config['encrypt_name'] = true;
                    $this->load->library('upload', $config);

                    $_FILES['file_images']['name'] = $files['city_other_images']['name'][$i];
                    $_FILES['file_images']['type'] = $files['city_other_images']['type'][$i];
                    $_FILES['file_images']['tmp_name'] = $files['city_other_images']['tmp_name'][$i];
                    $_FILES['file_images']['error'] = $files['city_other_images']['error'][$i];
                    $_FILES['file_images']['size'] = $files['city_other_images']['size'][$i];

                    $this->upload->initialize($config);
                    if($this->upload->do_upload('file_images')){
                        $fileData = $this->upload->data();
                        $c_img_data['city_id'] = $c_id;
                        $c_img_data['city_image'] = $fileData['file_name'];
                        $this->cityimages_model->Add($c_img_data);
                    }
                }
            }
        }
        echo json_encode($JSON);
        exit(0);
    }

    public function delete_city(){
        $JSON = array();

        $city_id = $this->input->post('city_id');
        if($city_id){
            $this->city_model->Delete($city_id);
            $JSON['flag'] = true;
            $JSON['msg'] = 'Successfully Deleted !!';
        }else{
            $JSON['flag'] = false;
            $JSON['msg'] = 'Something went wrong Please try again after reloading page';
        }
        echo json_encode($JSON);
        exit(0);
    }

    public function get_city_images(){
        $JSON = array();
        $img_city_id = $this->input->post('img_city_id');
        if($img_city_id){
            $city_images_data = $this->cityimages_model->GetFromField(array('city_id' => $img_city_id));
            $JSON['flag'] = true;
            $JSON['data'] = $city_images_data;
        }else{
            $JSON['flag'] = false;
            $JSON['msg'] = 'Something went wrong Please try again after reloading page';
        }
        echo json_encode($JSON);
        exit(0);
    }

    public function upload_city_images(){
        if($_FILES['other_images']['name'][0]!=''){
            $files = $_FILES;
            $cpt = count($_FILES['other_images']['name']);
            for($i=0; $i<$cpt; $i++){
                $uploadPath = C_IMG_PATH;
                $config['upload_path'] = $uploadPath;
                $config['allowed_types'] = 'jpeg|jpg|png|gif';
                $config['max_size'] = '0';
                $config['encrypt_name'] = true;
                $this->load->library('upload', $config);

                $_FILES['file_images']['name'] = $files['other_images']['name'][$i];
                $_FILES['file_images']['type'] = $files['other_images']['type'][$i];
                $_FILES['file_images']['tmp_name'] = $files['other_images']['tmp_name'][$i];
                $_FILES['file_images']['error'] = $files['other_images']['error'][$i];
                $_FILES['file_images']['size'] = $files['other_images']['size'][$i];

                $this->upload->initialize($config);
                if($this->upload->do_upload('file_images')){
                    $fileData = $this->upload->data();
                    $c_img_data['city_id'] = $this->input->post('img_city_id');
                    $c_img_data['city_image'] = $fileData['file_name'];
                    $this->cityimages_model->Add($c_img_data);
                }
            }
            $JSON['flag'] = true;
            $JSON['msg'] = 'Successfully Uploaded!';
        }
        else{
            $JSON['flag'] = false;
            $JSON['msg'] = 'Please upload images!';
        }
        echo json_encode($JSON);
        exit(0);
    }

    public function delete_city_images(){
        $JSON = array();
        $city_image_id = $this->input->post('city_image_id');
        if($city_image_id){
            $img_Data = $this->cityimages_model->GetSingleFromField(array('city_image_id' => $city_image_id));
            if(!empty($img_Data)){
                unlink(C_IMG_PATH . $img_Data->city_image);
            }
            $this->cityimages_model->Delete($city_image_id);
            $JSON['flag'] = true;
            $JSON['msg'] = 'Successfully Deleted!!';
        }else{
            $JSON['flag'] = false;
            $JSON['msg'] = 'Something went wrong Please try again after reloading page';
        }
        echo json_encode($JSON);
        exit(0);
    }
}
