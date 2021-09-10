<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Places extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('places_model');
        $this->load->model('city_model');
        $this->load->model('category_model');
        $this->load->model('interesttags_model');
    }

    public function index()
    {
        $data['title'] = "Lark | Places";
        $data['city'] = $this->city_model->GetFromField(array('city_name !=' => NULL));
        $data['category'] = $this->category_model->GetFromField(array('category_name !=' => NULL));

        $this->load->view('template/header', $data);
        $this->load->view('places/index', $data);
        $this->load->view('template/footer', $data);
    }

    public function get_place(){
        $JSON = array();
        $places_id = $this->input->post('places_id');
        if($places_id){
            $places_data = $this->places_model->get_places($places_id);
            $places_tags = array();
            $tag_data = $this->interesttags_model->GetFromField(array('places_id' => $places_id));
            if(!empty($tag_data)){
                foreach ($tag_data as $tag){
                    $places_tags[] = $tag->category_id;
                }
            }
            $places_data->places_tags = $places_tags;
            $JSON['flag'] = true;
            $JSON['data'] = $places_data;
        }else{
            $JSON['flag'] = false;
            $JSON['msg'] = 'Something went wrong Please try again after reloading page';
        }
        echo json_encode($JSON);
        exit(0);
    }

    public function get_places_data(){
        $start = $this->input->get('iDisplayStart');
        $limit = $this->input->get('iDisplayLength');
        $search = $this->input->get('sSearch');
        $sort_col = $this->input->get('iSortCol_0');
        $sort = $this->input->get('sSortDir_0');
        $filter_city = $this->input->get('filter_city');
        if($sort_col == 0){
            $sort_col = 'places_id';
        }
        if($sort_col == 1){
            $sort_col = 'places_name';
        }
        if($sort_col == 2){
            $sort_col = 'places_address';
        }
        if($sort_col == 3){
            $sort_col = 'city_name';
        }
        $result = $this->places_model->get_places('',$search,$limit,$start,$sort_col,$sort,$filter_city);
        $record = array();
        $k = 0;
        foreach ($result['data'] as $value) {
            $record[$k]['places_id']=$value->places_id;
            $record[$k]['places_name']=$value->places_name;
            $record[$k]['places_address']=$value->places_address;
            $record[$k]['city_name']=$value->city_name;
            $record[$k]['action']='<a href="javascript:void(0)" class="btn btn-success btn-flat btn-xs edit-places" data-id="'.$value->places_id.'"><i class="fa fa-edit"></i>&nbsp;&nbsp;Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" class="btn btn-danger btn-flat btn-xs delete-places" data-id="'.$value->places_id.'"><i class="fa fa-trash"></i>&nbsp;&nbsp;Delete</a>';
            $k++;
            # code...
        }
        $result['data'] = $record;
        // exit(0);
        $result['sEcho'] = $this->input->get('sEcho');
        echo json_encode($result);
        exit(0);
    }

    public function add_edit_place(){
        $JSON = array();
        $this->load->library('form_validation');
        $action = $this->input->post('form-action');
        $formConfig = array(
            array(
                'field' => 'places_name',
                'label' => 'Places Name',
                'rules' => 'trim|required',
                array(
                    'required'   => '%s required',
                )
            )
        );
        $this->form_validation->set_rules($formConfig);
        if($this->form_validation->run() == FALSE){
            $JSON['flag']= false;
            $JSON['msg'] = 'Please Check Form!';
        }else{
            $data = array();
            if($_FILES['places_photo']['name']!=''){
                $uploadPath = P_IMG_PATH;
                $config['upload_path'] = $uploadPath;
                $config['allowed_types'] = 'jpeg|jpg|png|gif';
                $config['max_size'] = '20480000';

                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if($this->upload->do_upload('places_photo')){
                    $fileData = $this->upload->data();
                    $data['places_photo'] = $fileData['file_name'];
                }
            }
            $day_close = array();
            $day_arr = array('Sun', 'Mon', 'Tues', 'Wed', 'Thurs', 'Fri', 'Sat');
            foreach ($day_arr as $val){
                if(!in_array($val, $this->input->post('day_open'))){
                    $day_close[] = $val;
                }
            }
            $data['places_name'] =  $this->input->post('places_name');
            $data['places_address'] =  $this->input->post('places_address');
            $data['city_id'] =  $this->input->post('city_id');
            $data['places_city'] =  $this->input->post('places_city');
            $data['places_stateprovince'] =  $this->input->post('places_stateprovince');
            $data['places_country'] =  $this->input->post('places_country');
            $data['latitude'] =  $this->input->post('latitude');
            $data['longitude'] =  $this->input->post('longitude');
            $data['places_description'] =  $this->input->post('places_description');
            $data['places_website'] =  $this->input->post('places_website');
            $data['places_budget'] =  $this->input->post('places_budget');
            $data['places_timeopen'] =  $this->input->post('places_timeopen');
            $data['places_timeclosed'] =  $this->input->post('places_timeclosed');
            $data['places_timevisit'] =  $this->input->post('places_timevisit');
            $data['day_open'] =  implode(', ', $this->input->post('day_open'));
            $data['day_close'] =  (empty($day_close)) ? 'None' : implode(', ', $day_close);
            $data['hours_complete'] =  $this->input->post('hours_complete');
            $data['places_must_see'] =  $this->input->post('places_must_see');
            $data['places_group'] =  $this->input->post('places_group');

            if($action && $action == 'add'){
                $data['created_date'] =  date('Y-m-d H:i:s');
                $id = $this->places_model->Add($data);
                if(!empty($id)){
                    if($this->input->post('interest_tags')){
                        foreach ($this->input->post('interest_tags') as $val){
                            $insert_tag_data = array(
                                'category_id' => $val,
                                'places_id' => $id,
                                'created_date' => date('Y-m-d H:i:s')
                            );
                            $this->interesttags_model->Add($insert_tag_data);
                        }
                    }
                    $JSON['flag'] = true;
                    $JSON['msg'] = 'Successfully Added !!';
                }else{
                    $JSON['flag'] = false;
                    $JSON['msg'] = 'Something went wrong Please try again after reloading page';
                }
            }else if($action == 'edit'){
                $places_id = $this->input->post('places_id');
                if($places_id && !empty($places_id)){
                    $this->places_model->Edit($places_id,$data);
                    if($this->input->post('interest_tags')){
                        $this->interesttags_model->deleteAllTag($places_id);
                        foreach ($this->input->post('interest_tags') as $val){
                            //$this->interesttags_model->deleteTag($val, $places_id);
                            $insert_tag_data = array(
                                'category_id' => $val,
                                'places_id' => $places_id,
                                'created_date' => date('Y-m-d H:i:s')
                            );
                            $this->interesttags_model->Add($insert_tag_data);
                        }
                    }
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

    public function delete_place(){
        $JSON = array();
        $places_id = $this->input->post('places_id');
        if($places_id){
            $this->places_model->Delete($places_id);
            $JSON['flag'] = true;
            $JSON['msg'] = 'Successfully Deleted !!';
        }else{
            $JSON['flag'] = false;
            $JSON['msg'] = 'Something went wrong Please try again after reloading page';
        }
        echo json_encode($JSON);
        exit(0);
    }

    public function import_places(){
        $JSON = array();
        $this->load->library('form_validation');
        $formConfig = array(
            array(
                'field' => 'file_city',
                'label' => 'City',
                'rules' => 'trim|required',
                array(
                    'required'   => '%s required',
                )
            )
        );
        $this->form_validation->set_rules($formConfig);
        if($this->form_validation->run() == FALSE){
            $JSON['flag']= false;
            $JSON['msg'] = 'Please Check Form!';
        }else{
            if($_FILES['file_csv']['name']!=''){
                $uploadPath = P_CSV_PATH;
                $config['upload_path'] = $uploadPath;
                $config['allowed_types'] = 'csv';
                $config['max_size'] = '0';

                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if($this->upload->do_upload('file_csv')){
                    $fileData = $this->upload->data();
                    $csv = $fileData['file_name'];
                    $arrResult = array();
                    $handle = fopen(P_CSV_PATH . $csv, "r");
                    if ($handle) {
                        while (($row = fgetcsv($handle, 5000, ",")) !== FALSE) {
                            $arrResult[] = $row;
                        }
                        fclose($handle);
                    }
                    array_shift($arrResult);
                    $keys = array('places_name', 'places_address', 'places_city', 'places_stateprovince', 'places_country', 'latitude', 'longitude', 'places_photo', 'places_description', 'places_website', 'tags', 'places_budget', 'places_timeopen', 'places_timeclosed', 'places_timevisit', 'day_open', 'day_close', 'hours_complete', 'places_must_see', 'places_group');
                    $final = array();
                    foreach ($arrResult as $key => $value) {
                        $final[] = array_combine($keys, $value);
                    }
                    if(!empty($final)){
                        foreach ($final as $value) {
                            $record = $this->places_model->CheckPlace($value['places_name']);
                            $data = array(
                                'places_name' => $value['places_name'],
                                'places_address' => $value['places_address'],
                                'city_id' => $_POST['file_city'],
                                'places_city' => $value['places_city'],
                                'places_stateprovince' => $value['places_stateprovince'],
                                'places_country' => $value['places_country'],
                                'latitude' => $value['latitude'],
                                'longitude' => $value['longitude'],
                                'places_photo' => $value['places_photo'],
                                'places_description' => $value['places_description'],
                                'places_website' => $value['places_website'],
                                'places_budget' => $value['places_budget'],
                                'places_timeopen' => $value['places_timeopen'],
                                'places_timeclosed' => $value['places_timeclosed'],
                                'places_timevisit' => $value['places_timevisit'],
                                'day_open' => $value['day_open'],
                                'day_close' => $value['day_close'],
                                'hours_complete' => $value['hours_complete'],
                                'places_must_see' => ($value['places_must_see']=='No') ? 0 : 1,
                                'places_group' => $value['places_group']
                            );
                            if(empty($record)){
                                $data['created_date'] = date('Y-m-d H:i:s');
                                $places_id = $this->places_model->Add($data);
                            }
                            else{
                                $places_id = $this->places_model->Edit($record->places_id, $data);
                            }
                            if($value['tags']!=''){
                                $tag_array = explode(',', $value['tags']);
                                if(!empty($tag_array)){
                                    foreach ($tag_array as $tag){
                                        $places_tag = $this->interesttags_model->GetSingleFromField(array('category_id' => $tag, 'places_id' => $places_id));
                                        if(!empty($places_tag)){
                                            $this->interesttags_model->deleteTag($tag, $places_id);
                                        }
                                        $category_data = $this->category_model->get_category($tag);
                                        if(!empty($category_data)){
                                            $insert_tag_data = array(
                                                'category_id' => $tag,
                                                'places_id' => $places_id,
                                                'created_date' => date('Y-m-d H:i:s')
                                            );
                                            $this->interesttags_model->Add($insert_tag_data);
                                        }
                                    }
                                }
                            }
                        }
                    }
                    unlink(P_CSV_PATH . $csv);
                    $JSON['flag'] = true;
                    $JSON['msg'] = 'Successfully Import!';
                }
                else{
                    $JSON['flag'] = false;
                    $JSON['msg'] = 'Please Upload only CSV file';
                }
            }
            else{
                $JSON['flag'] = false;
                $JSON['msg'] = 'Please upload csv file!';
            }
        }
        echo json_encode($JSON);
        exit(0);
    }
}
