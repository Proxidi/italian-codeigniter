<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permisos extends CI_Controller {
	private $permisos;

		public function __construct()
		{
				parent::__construct();
				$this->permisos=$this->backend_lib->control();
				$this->load->model('Mdl_roles');           
				$this->load->model('Mdl_permisos');
				$this->load->model('Mdl_usuarios');
				if(!$this->session->userdata("login")){
				redirect(base_url());
				}
		}

		public function index()
		{
	
			$data=array(
			'menus' => $this->Mdl_permisos->getPermisos(),
			'menus_list' => $this->Mdl_permisos->getMenus(),
			'roles' => $this->Mdl_permisos->getRoles()
			);   

			$this->load->view("layouts/header");
			$this->load->view("layouts/aside");
			$this->load->view("administrador/permisos/list",$data);
			$this->load->view("layouts/footer");
		}

		public function otorgarPermisos(){            
			if($this->input->is_ajax_request()){
				$rol_id=$this->input->post("rol_id");
				$menu_id=$this->input->post("menu_id"); 
				$data=array('Leer' => 1);  

				if($this->Mdl_permisos->permisos($rol_id,$menu_id,$data)){                
					$tabla= $this->Mdl_permisos->getPermisosAJAX();
					$return_arr[] = array
					("tabla" => $tabla,
					"valor" => 1
					);  
					echo json_encode($return_arr); 
				} else{
					$tabla= $this->Mdl_permisos->getPermisosAJAX();
					$return_arr[] = array
					("tabla" => $tabla,
					"valor" => 0
					);  
					echo json_encode($return_arr); 
				}
			}   
			else{
					redirect(base_url()."Inicio");
				}           
		}
		
		public function denegarPermisos(){            
			if($this->input->is_ajax_request()){
				$rol_id=$this->input->post("rol_id");
				$menu_id=$this->input->post("menu_id"); 
				$data=array('Leer' => 0);  

				if($this->Mdl_permisos->permisos($rol_id,$menu_id,$data)){                
					$tabla= $this->Mdl_permisos->getPermisosAJAX();
					$return_arr[] = array
					("tabla" => $tabla,
					"valor" => 1
					);  
					echo json_encode($return_arr); 
				} else{
					$tabla= $this->Mdl_permisos->getPermisosAJAX();
					$return_arr[] = array
					("tabla" => $tabla,
					"valor" => 0
					);  
					echo json_encode($return_arr); 
				}
			}   
			else{
					redirect(base_url()."Inicio");
				}           
        }

		public function storeMenu()
		{			
				if($this->input->is_ajax_request()){
					$nombre=$this->input->post("nombre");
					$link=$this->input->post("link");
				
					$data=array(
							"Nombre"=>$nombre,
							"Link"=>$link
					);	

					if($this->Mdl_permisos->saveMenu($data)){
							echo 1;
					}				
					else{
						echo 0;
					}
				}   
				else{
						redirect(base_url()."Inicio");
				  }	
												
		}

		public function storePermiso()
		{			
				if($this->input->is_ajax_request()){
					$rol_id=$this->input->post("rol_id");
					$menu_id=$this->input->post("menu_id");
					$permiso=$this->input->post("permiso");
				
					$data=array(
							"rol_id"=>$rol_id,
							"menu_id"=>$menu_id,
							"Leer"=>$permiso
					);	

					if($this->Mdl_permisos->savePermiso($data)){
							$tabla= $this->Mdl_permisos->getPermisosAJAX();
							$return_arr[] = array
							("tabla" => $tabla,
							"valor" => 1
							);  
							echo json_encode($return_arr); 
					}				
					else{						
						$tabla= $this->Mdl_permisos->getPermisosAJAX();
						$return_arr[] = array
						("tabla" => $tabla,
						"valor" => 0
						);  
						echo json_encode($return_arr); 												
					}
				}   
				else{
						redirect(base_url()."Inicio");
				  }									
		}


}
