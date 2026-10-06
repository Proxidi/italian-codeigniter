<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require './assets/Classes/PHPExcel/IOFactory.php';

class Archivos extends CI_Controller {

    private $permisos;    
    
    public function __construct()
    {
        parent::__construct();
        $this->permisos=$this->backend_lib->control();
        $this->load->model('Mdl_depositos');
        $this->load->model('Mdl_plazas');
        if(!$this->session->userdata("login")){
        redirect(base_url());
        }
    }

    public function index()
    {
        $this->load->view("layouts/header");
        $this->load->view("layouts/aside");
        $this->load->view("administrador/archivos/panel_archivos");
        $this->load->view("layouts/footer");
    }
}

