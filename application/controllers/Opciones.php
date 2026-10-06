<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Opciones extends CI_Controller {
    private $permisos;  
    public function __construct()
    {
        parent::__construct();
        $this->permisos=$this->backend_lib->control();
        $this->load->model('Mdl_opciones');  
        if(!$this->session->userdata("login")){
        redirect(base_url());
        }         
    }

	public function index()
	{                
        $this->load->view("layouts/header");
        $this->load->view("layouts/aside");
        $this->load->view("administrador/opciones/panel_opciones");
        $this->load->view("layouts/footer");
    }

    public function fechas()
	{                
        $data=array(
			'dias' => $this->Mdl_opciones->getDias()
		);   
        $this->load->view("layouts/header");
        $this->load->view("layouts/aside");
        $this->load->view("administrador/opciones/fechas",$data);
        $this->load->view("layouts/footer");
    }

    public function actualizarRangoDias(){
        if($this->input->is_ajax_request()){            
            $numeroDias=$this->input->post('numero_dias_valor');                        
            if($numeroDias >=1){                
                $data=array(
                    "Numero_Dias"=>$numeroDias
                );        
                if($this->Mdl_opciones->actualizarRangoArchivos($data)){
                    echo 1;
                }else{
                    echo 0;
                }   
            }else{
                echo 2;
            }                 
        }   
        else{
                redirect(base_url()."Inicio");
          }
    }

}
