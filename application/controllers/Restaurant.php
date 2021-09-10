<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Restaurant extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('restaurant_model', 'cuisine_model', 'establishment_model', 'meal_model', 'food_model'));
        $this->load->model('places_model');
    }

    public function index()
    {
        $data['title'] = "Restaurant | Dashboard";

        $data['total_restaurant'] = $this->restaurant_model->getTotalRestaurant();
        $data['total_cuisine'] = $this->cuisine_model->GetAllCuisine();
        $data['total_establishment'] = $this->establishment_model->GetAllEstablishment();
        $data['total_meal'] = $this->meal_model->GetAllMeal();
        $data['total_food'] = $this->food_model->GetAllFood();

        $this->load->view('template/header', $data);
        $this->load->view('restaurant/index', $data);
        $this->load->view('template/footer', $data);
    }

    public function get_restaurant_data()
    {
        $start = $this->input->get('iDisplayStart');
        $limit = $this->input->get('iDisplayLength');
        $search = $this->input->get('sSearch');
        $sort_col = $this->input->get('iSortCol_0');
        $sort = $this->input->get('sSortDir_0');
        $filter_city = $this->input->get('filter_city');
        if ($sort_col == 0) {
            $sort_col = 'res_id';
        }
        if ($sort_col == 1) {
            $sort_col = 'res_name';
        }
        if ($sort_col == 2) {
            $sort_col = 'desc';
        }
        if ($sort_col == 3) {
            $sort_col = 'address';
        }
        if ($sort_col == 4) {
            $sort_col = 'serves_alcohol';
        }
        if ($sort_col == 5) {
            $sort_col = 'veg';
        }
        if ($sort_col == 6) {
            $sort_col = 'halal';
        }
        if ($sort_col == 7) {
            $sort_col = 'kosher';
        }
        if ($sort_col == 8) {
            $sort_col = 'delivery';
        }
        if ($sort_col == 9) {
            $sort_col = 'res_type';
        }
        $result = $this->restaurant_model->get_restaurant('', $search, $limit, $start, $sort_col, $sort, $filter_city);
        $record = array();
        $k = 0;
        foreach ($result['data'] as $value) {
            $record[$k]['res_id'] = $value->res_id;
            $record[$k]['res_name'] = $value->res_name;
            $record[$k]['desc'] = $value->desc;
            $record[$k]['address'] = $value->address;
            $record[$k]['serves_alcohol'] = ($value->serves_alcohol)? 'Yes': 'No';
            $record[$k]['veg'] = ($value->veg)? 'Yes': 'No';
            $record[$k]['halal'] = ($value->halal)? 'Yes': 'No';
            $record[$k]['kosher'] = ($value->kosher)? 'Yes': 'No';
            $record[$k]['delivery'] = ($value->delivery)? 'Yes': 'No';
            $record[$k]['res_images'] = $value->res_images;
            $record[$k]['res_type'] = $value->res_type;
            $record[$k]['action'] = '<a href="javascript:void(0)" class="btn btn-success btn-flat btn-xs edit-restaurant" data-id="' . $value->res_id . '"><i class="fa fa-edit"></i>&nbsp;&nbsp;Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" class="btn btn-danger btn-flat btn-xs delete-restaurant" data-id="' . $value->res_id . '"><i class="fa fa-trash"></i>&nbsp;&nbsp;Delete</a>';
            $k++;
            # code...
        }
        $result['data'] = $record;
        // exit(0);
        $result['sEcho'] = $this->input->get('sEcho');
        echo json_encode($result);
        exit(0);
    }

    public function get_restaurant()
    {
        $JSON = array();
        $restaurant_id = $this->input->post('restaurant_id');
        $userTimeZone = $this->input->post('userTimeZone');
        if ($restaurant_id) {
            $restaurant_data = $this->restaurant_model->get_restaurant($restaurant_id);
            $CuisineData = $this->cuisine_model->GetRestaurantToCuisineData($restaurant_id);
            $EstablishmentData = $this->establishment_model->GetRestaurantToEstablishment($restaurant_id);
            $MealData = $this->meal_model->GetRestaurantToMeal($restaurant_id);
            $FoodData = $this->food_model->GetRestaurantToFood($restaurant_id);
            $Image_data = $this->restaurant_model->GetUploadRestaurantImage($restaurant_id);
            $MenuImage_data = $this->restaurant_model->GetUploadMenuRestaurantImage($restaurant_id);
            $Time_data = $this->restaurant_model->GetRestaurantTime($restaurant_id);
            // print_r($Time_data);
            $time_data = array();
            if(isset($Time_data[0])){
	            $Time_data[0]['sun_start_time'] = $this->zone_conversion_date($Time_data[0]['sun_start_time'],'UTC',$userTimeZone);
	            $Time_data[0]['sun_end_time'] = $this->zone_conversion_date($Time_data[0]['sun_end_time'],'UTC',$userTimeZone);
	            $Time_data[0]['sat_end_time'] = $this->zone_conversion_date($Time_data[0]['sat_end_time'],'UTC',$userTimeZone);
	            $Time_data[0]['sat_start_time'] = $this->zone_conversion_date($Time_data[0]['sat_start_time'],'UTC',$userTimeZone);
	            $Time_data[0]['fri_end_time'] = $this->zone_conversion_date($Time_data[0]['fri_end_time'],'UTC',$userTimeZone);
	            $Time_data[0]['fri_start_time'] = $this->zone_conversion_date($Time_data[0]['fri_start_time'],'UTC',$userTimeZone);
	            $Time_data[0]['thu_end_time'] = $this->zone_conversion_date($Time_data[0]['thu_end_time'],'UTC',$userTimeZone);
	            $Time_data[0]['thu_start_time'] = $this->zone_conversion_date($Time_data[0]['thu_start_time'],'UTC',$userTimeZone);
	            $Time_data[0]['wed_end_time'] = $this->zone_conversion_date($Time_data[0]['wed_end_time'],'UTC',$userTimeZone);
	            $Time_data[0]['wed_start_time'] = $this->zone_conversion_date($Time_data[0]['wed_start_time'],'UTC',$userTimeZone);
	            $Time_data[0]['tue_end_time'] = $this->zone_conversion_date($Time_data[0]['tue_end_time'],'UTC',$userTimeZone);
	            $Time_data[0]['tue_start_time'] = $this->zone_conversion_date($Time_data[0]['tue_start_time'],'UTC',$userTimeZone);
	            $Time_data[0]['mon_end_time'] = $this->zone_conversion_date($Time_data[0]['mon_end_time'],'UTC',$userTimeZone);
	            $Time_data[0]['mon_start_time'] = $this->zone_conversion_date($Time_data[0]['mon_start_time'],'UTC',$userTimeZone);
            }

             // print_r($Time_data);die;
            $restaurant_data->establishment = $EstablishmentData;
            $restaurant_data->cuisine = $CuisineData;
            $restaurant_data->meal = $MealData;
            $restaurant_data->food = $FoodData;
            $restaurant_data->image = $Image_data;
            $restaurant_data->menu = $MenuImage_data;
            $restaurant_data->time = $Time_data;

            $JSON['flag'] = true;
            $JSON['data'] = $restaurant_data;
        } else {
            $JSON['flag'] = false;
            $JSON['msg'] = 'Something went wrong Please try again after reloading page';
        }
        echo json_encode($JSON);
        exit(0);
    }

     public function zone_conversion_date($time, $cur_zone, $req_zone)
    {   
        date_default_timezone_set("GMT");
        $gmt = date("Y-m-d H:i:s");

        date_default_timezone_set($cur_zone);
        $local = date("Y-m-d H:i:s");

        date_default_timezone_set($req_zone);
        $required = date("Y-m-d H:i:s");

        /* return $required; */
        $diff1 = (strtotime($gmt) - strtotime($local));
        $diff2 = (strtotime($required) - strtotime($gmt));

        $date = new DateTime($time);
        $date->modify("+$diff1 seconds");
        $date->modify("+$diff2 seconds");

        return $timestamp = $date->format("H:i:s");
    }

    public function add_edit_restaurant()
    {
        $JSON = array();
        $action = $this->input->post('form-action');
        $data = array();
        $FilesArray = array();
        $MenuFilesArray = array();
        $Time = array();

        $userTimeZone =  $this->input->post('userTimeZone');
        $data['res_name'] =  $this->input->post('restaurant_name');
        $data['res_mob'] =  $this->input->post('restaurant_mobile');
        $data['desc'] =  $this->input->post('restaurant_description');
        $data['address'] = $address =  $this->input->post('restaurant_address');
        $data['res_latitude'] =  $this->input->post('latitude');
        $data['res_longitude'] =  $this->input->post('longitude'); 
        $Time['sun_start_time'] = $this->zone_conversion_date($this->input->post('sunday_open'),$userTimeZone,'UTC');

        $Time['sun_end_time'] = $this->zone_conversion_date($this->input->post('sunday_close'),$userTimeZone,'UTC');

        $Time['mon_start_time'] = date('H:i:s', strtotime($this->input->post('monday_open')));
        $Time['mon_end_time'] = date('H:i:s', strtotime($this->input->post('monday_close')));
        $Time['tue_start_time'] = date('H:i:s', strtotime($this->input->post('tuesday_open')));
        $Time['tue_end_time'] = date('H:i:s', strtotime($this->input->post('tuesday_close')));
        $Time['wed_start_time'] = date('H:i:s', strtotime($this->input->post('wednesday_open')));
        $Time['wed_end_time'] = date('H:i:s', strtotime($this->input->post('wednesday_close')));
        $Time['thu_start_time'] = date('H:i:s', strtotime($this->input->post('thursday_open')));
        $Time['thu_end_time'] = date('H:i:s', strtotime($this->input->post('thursday_close')));
        $Time['fri_start_time'] = date('H:i:s', strtotime($this->input->post('friday_open')));
        $Time['fri_end_time'] = date('H:i:s', strtotime($this->input->post('friday_close')));
        $Time['sat_start_time'] = date('H:i:s', strtotime($this->input->post('saturday_open')));
        $Time['sat_end_time'] = date('H:i:s', strtotime($this->input->post('saturday_close')));
        $data['halal'] = $this->input->post('halal');

        // $geocodeFromAddr = file_get_contents('https://maps.google.com/maps/api/geocode/json?address=' . urlencode($address) . '&sensor=false&key=AIzaSyA2SdIhCxV7iE-IsnBZXpXktuIa880s0wg');
        // $output = json_decode($geocodeFromAddr);
        //Get latitude and longitute from json data
        // $data['res_latitude']  = $output->results[0]->geometry->location->lat;
        // $data['res_longitude'] = $output->results[0]->geometry->location->lng;
        if ($_FILES['restaurant_photo']['name'][0] != '') {
            for ($i = 0; $i < count($_FILES['restaurant_photo']['name']); $i++) {
                $folder_name = "Restaurant";
                $img_pdf = $_FILES["restaurant_photo"]["name"][$i];
                $tmp_name = $_FILES["restaurant_photo"]["tmp_name"][$i];
                $path = $this->image_pdf_upload($img_pdf, $tmp_name, $folder_name);
                $FilesArray[] = array(
                    'res_id' => 0,
                    'images' => $path
                );
            }
        }

        if ($_FILES['main_image']['name'] != '') {
            $folder_name = "Restaurant";
            $img_pdf = $_FILES["main_image"]["name"];
            $tmp_name = $_FILES["main_image"]["tmp_name"];
            $path = $this->image_pdf_upload($img_pdf, $tmp_name, $folder_name);
            $data['res_images'] = $path;
        }
        
        if ($_FILES['menu_photo']['name'][0] != '') {
            for ($i = 0; $i < count($_FILES['menu_photo']['name']); $i++) {
                $folder_name = "menu";
                $img_pdf = $_FILES["menu_photo"]["name"][$i];
                $tmp_name = $_FILES["menu_photo"]["tmp_name"][$i];
                $path = $this->image_pdf_upload($img_pdf, $tmp_name, $folder_name);
                $MenuFilesArray[] = array(
                    'res_id' => 0,
                    'menu_name' => '',
                    'menu_image' => $path
                );
            }
        }
        $service = array('serves_alcohol', 'veg',  'kosher', 'delivery');

        foreach ($service as $key => $value) {
            if (in_array($value, $this->input->post('allow'))) {
                $data[$value] = 1;
            } else {
                $data[$value] = 0;
            }
        }

        if ($action && $action == 'add') {
            $data['created_date'] =  date('Y-m-d H:i:s');
            $id = $this->restaurant_model->Add($data);
            if (!empty($id)) {
                $establishment = array();
                $cuisine = array();
                $meal = array();
                $food = array();
                foreach ($this->input->post('establishment') as $key => $value) {
                    $establishment[] = array(
                        'establishment_id' => $value,
                        'res_id' => $id
                    );
                }
                foreach ($this->input->post('cuisine') as $key => $value) {
                    $cuisine[] = array(
                        'res_cuisine_id' => $value,
                        'res_id' => $id
                    );
                }
                foreach ($this->input->post('meal') as $key => $value) {
                    $meal[] = array(
                        'meal_id' => $value,
                        'res_id' => $id
                    );
                }
                foreach ($this->input->post('food') as $key => $value) {
                    $food[] = array(
                        'food_id' => $value,
                        'res_id' => $id
                    );
                }
                $this->establishment_model->AddRestaurantToEstablishment($establishment);
                $this->cuisine_model->AddRestaurantToCuisine($cuisine);
                $this->meal_model->AddRestaurantToMeal($meal);
                $this->food_model->AddRestaurantToFood($food);

                foreach ($FilesArray as $key => $value) {
                    $FilesArray[$key]['res_id'] = $id;
                }
                foreach ($MenuFilesArray as $key => $value) {
                    $MenuFilesArray[$key]['res_id'] = $id;
                }
               
                if(count($FilesArray) > 0){
                    $this->restaurant_model->UploadMultipleRestaurantImage($FilesArray);    
                }
                
                if (count($MenuFilesArray) > 0) {
                    $this->restaurant_model->UploadMultipleMenuRestaurantImage($MenuFilesArray);
                }
                $Time['res_id'] = $id;
                $this->restaurant_model->AddRestaurantTime($Time);
                $JSON['flag'] = true;
                $JSON['msg'] = 'Successfully Added !!';
            } else {
                $JSON['flag'] = false;
                $JSON['msg'] = 'Something went wrong Please try again after reloading page';
            }
        } else if ($action == 'edit') {
            $restaurant_id = $this->input->post('restaurant_id');
            $data['updated_date'] =  date('Y-m-d H:i:s');
            if ($restaurant_id && !empty($restaurant_id)) {
                $this->restaurant_model->Edit($restaurant_id, $data);
                $this->establishment_model->DeleteRestaurantToEstablishment($restaurant_id);
                $this->cuisine_model->DeleteRestaurantToCuisine($restaurant_id);
                $this->meal_model->DeleteRestaurantToMeal($restaurant_id);
                $this->food_model->DeleteRestaurantToFood($restaurant_id);
                
                $establishment = array();
                $cuisine = array();
                $meal = array();
                $food = array();
                foreach ($this->input->post('establishment') as $key => $value) {
                    $establishment[] = array(
                        'establishment_id' => $value,
                        'res_id' => $restaurant_id
                    );
                }
                foreach ($this->input->post('cuisine') as $key => $value) {
                    $cuisine[] = array(
                        'res_cuisine_id' => $value,
                        'res_id' => $restaurant_id
                    );
                }
                foreach ($this->input->post('meal') as $key => $value) {
                    $meal[] = array(
                        'meal_id' => $value,
                        'res_id' => $restaurant_id
                    );
                }
                foreach ($this->input->post('food') as $key => $value) {
                    $food[] = array(
                        'food_id' => $value,
                        'res_id' => $restaurant_id
                    );
                }
                $this->establishment_model->AddRestaurantToEstablishment($establishment);
                $this->cuisine_model->AddRestaurantToCuisine($cuisine);
                $this->meal_model->AddRestaurantToMeal($meal);
                $this->food_model->AddRestaurantToFood($food);
                foreach ($FilesArray as $key => $value) {
                    $FilesArray[$key]['res_id'] = $restaurant_id;
                }
                foreach ($MenuFilesArray as $key => $value) {
                    $MenuFilesArray[$key]['res_id'] = $restaurant_id;
                }
                if(count($MenuFilesArray) > 0){
                    $this->restaurant_model->UploadMultipleMenuRestaurantImage($MenuFilesArray);    
                }
                if(count($FilesArray) > 0){
                    $this->restaurant_model->UploadMultipleRestaurantImage($FilesArray);
                }
                
                
                $Time['res_id'] = $restaurant_id;
                $this->restaurant_model->UpdateRestaurantTime($restaurant_id, $Time);
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

    public function delete_restaurant()
    {
        $JSON = array();
        $restaurant_id = $this->input->post('restaurant_id');
        if ($restaurant_id) {
            $this->restaurant_model->Delete($restaurant_id);
            $JSON['flag'] = true;
            $JSON['msg'] = 'Successfully Deleted !!';
        } else {
            $JSON['flag'] = false;
            $JSON['msg'] = 'Something went wrong Please try again after reloading page';
        }
        echo json_encode($JSON);
        exit(0);
    }

    function image_pdf_upload($img_pdf, $tmp_name, $folder_name)
    {
        $main_dir = P_IMG_PATH;
        $tmp_arr = explode(".", $img_pdf);
        $img_extn = end($tmp_arr);
        $new_img_pdf_name = uniqid() . '_' . date("YmdHis") . '.' . $img_extn;
        $flag = 0;
        if (!file_exists('../' . $main_dir)) {
            @mkdir($main_dir, 0777, true);
            if (!file_exists('../' . $main_dir . '/' . $folder_name)) {
                @mkdir($main_dir . '/' . $folder_name, 0777, true);
            }
        } elseif (!file_exists($main_dir . '/' . $folder_name)) {
            @mkdir($main_dir . '/' . $folder_name, 0777, true);
        }
        if (file_exists($main_dir . '/' . $folder_name . '/' . $new_img_pdf_name)) {
            return true;
        } else {
            move_uploaded_file($tmp_name, $main_dir . "/" . $folder_name . "/" . $new_img_pdf_name);
            $flag = 1;
            return $new_img_pdf_name;
        }
    }

    public function delete_restaurant_image()
    {
        $JSON = array();
        $restaurant_image_id = $this->input->post('restaurant_image_id');
        $imageName = $this->input->post('imageName');
        if ($restaurant_image_id) {
            unlink(P_IMG_PATH.'Restaurant/'. $imageName);
            $this->restaurant_model->DeleteImage($restaurant_image_id);
            $JSON['flag'] = true;
            $JSON['msg'] = 'Successfully Deleted !!';
        } else {
            $JSON['flag'] = false;
            $JSON['msg'] = 'Something went wrong Please try again after reloading page';
        }
        echo json_encode($JSON);
        exit(0);
    }

    public function delete_menu_restaurant_image()
    {
        $JSON = array();
        $restaurant_image_id = $this->input->post('restaurant_image_id');
        $imageName = $this->input->post('imageName');
        if ($restaurant_image_id) {
            unlink(P_IMG_PATH.'menu/'. $imageName);
            $this->restaurant_model->DeleteMenuImage($restaurant_image_id);
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
