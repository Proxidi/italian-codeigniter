<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require './assets/Classes/PHPExcel/IOFactory.php';

class Reportes extends CI_Controller {
    private $permisos;  
    
    public function __construct()
    {
        parent::__construct();
        $this->permisos=$this->backend_lib->control();             
        $this->load->model('Mdl_reportes');
        if(!$this->session->userdata("login")){
        redirect(base_url());
        }
    }

    public function index()
	{
        $this->load->view("layouts/header");
        $this->load->view("layouts/aside");
        $this->load->view("manager/reportes/panel_reportes");
        $this->load->view("layouts/footer");
    }

    public function add()
    {				  
        $this->load->view("layouts/header");
        $this->load->view("layouts/aside");
        $this->load->view("manager/reportes/ventas/add");
        $this->load->view("layouts/footer");
    }

    public function list()
	{
        $data=array('reportes' => $this->Mdl_reportes->getReportes());
        $this->load->view("layouts/header");
        $this->load->view("layouts/aside");
        $this->load->view("manager/reportes/ventas/list",$data);
        $this->load->view("layouts/footer");
  	}

}