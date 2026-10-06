<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perfiles extends CI_Controller {
        
	public function __construct()
	{
			parent::__construct();			 
			$this->load->model('Mdl_usuarios');
			$this->load->model('Mdl_roles');
			$this->load->model('Mdl_plazas');
			if(!$this->session->userdata("login")){
			redirect(base_url());
			}			 
	}
    
    public function index()
	{
		$id=$this->session->userdata("id");
		$data=array(
			'usuarios' => $this->Mdl_usuarios->getUsuariosID($id)
			);

		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("perfiles/list",$data);
		$this->load->view("layouts/footer");		
	}

	public function edit($id){
		$data=array(

            'usuario'=>$this->Mdl_usuarios->getUsuario($id),
			'roles' => $this->Mdl_roles->getRoles(),
			'plazas' => $this->Mdl_plazas->getPlazas()
                  );

            $this->load->view("layouts/header");
    		$this->load->view("layouts/aside");
    		$this->load->view("perfiles/edit",$data);
    		$this->load->view("layouts/footer");
    }

}