<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Medidas extends CI_Controller {
    private $permisos;  

    public function __construct()
    {
            parent::__construct();
            $this->permisos=$this->backend_lib->control();
            $this->load->model('Mdl_productos');  
            if(!$this->session->userdata("login")){
            redirect(base_url());
            }         
    }

	public function index()
	{
        
            $data=array('unidades' => $this->Mdl_productos->getUnidades());
            $this->load->view("layouts/header");
            $this->load->view("layouts/aside");
            $this->load->view("administrador/productos/unidades/list",$data);
            $this->load->view("layouts/footer");
    }

}
