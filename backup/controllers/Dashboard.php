<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('restaurant_model');
        $this->load->model('establishment_model');
    }

	public function index()
	{
        $data['title'] = "Restaurant | Dashboard";
        
        $data['total_restaurant'] = $this->restaurant_model->getTotalRestaurant();
        $data['total_establishment'] = $this->establishment_model->getTotalEstablishment();
        // $data['total_places'] = $this->places_model->getTotalPlaces();

		$this->load->view('template/header', $data);
		$this->load->view('dashboard/index', $data);
		$this->load->view('template/footer', $data);
	}
}
