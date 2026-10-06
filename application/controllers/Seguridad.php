<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seguridad extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Mdl_seguridad');			              
		$this->load->model('Mdl_ventas');
		$this->load->model('Mdl_inventario');
		$this->load->model('Mdl_usuarios');
	}
	
	public function index()
	{     
		if($this->session->userdata("login")){
				redirect(base_url()."Inicio");
		}
		else{
			$this->load->view("login");
		}
	}
     
    public function login(){
    
        $username = $this->input->post("username");
		$password = $this->input->post("password");
		$password=sha1($password);		
        
		$res = $this->Mdl_seguridad->autenticar($username, $password);

		if (!$res) {
			$this->session->set_flashdata("error","El usuario y/o contraseña son incorrectos");
			redirect(base_url());
		}
		else{

			$arrayAcceso=array(
				"Fecha"=>date('Y-m-d'),
				"Hora"=>date('H:i:s'),
				"usuario_id"=>$res->id,
				"plaza_id"=>$res->plaza_id
			);

			if($this->Mdl_usuarios->insertarAcceso($arrayAcceso)){}

			
			$hoy=date('Y-m-d',strtotime("-2 days"));							
			$id=$res->plaza_id;
			$msj="";			
			if(!$this->Mdl_ventas->consultarFechaVenta($hoy,$id)){
				$msj="Archivo de Corte Solicitado. Fecha:  ".$hoy;							
			}			

			$data  = array(
				'id' => $res->id,
				'hash_id'=>$res->Hash,
				'username'=>$res->Usuario, 
				'nombre' => $res->Nombre,
				'plaza'  =>$res->plaza_id,
				'plaza_nombre'  =>$res->Plaza,
				'apepat'  =>$res->Apepat,
				'apemat'  =>$res->Apemat,
				'rol_id' => $res->rol_id,
				'rol' => $res->Rol,
				'sexo'=>$res->Sexo,
				'login' => TRUE,
				'modal'=>1,
				'msj' => $msj,
				'hoy' => $hoy
			);

			$this->session->set_userdata($data);
			redirect(base_url()."Inicio");
		}

	}

	public function logout(){
		$this->session->sess_destroy();
		redirect(base_url());
    }


}