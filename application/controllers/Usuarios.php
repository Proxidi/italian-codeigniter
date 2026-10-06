<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller {
	private $permisos;

	public function __construct()
    {
		parent::__construct();
		$this->permisos=$this->backend_lib->control();
		$this->load->model('Mdl_usuarios');
		$this->load->model('Mdl_roles');
		$this->load->model('Mdl_plazas');
		$this->load->model('Mdl_seguridad');

		if(!$this->session->userdata("login")){
		redirect(base_url());
		}
	}

	public function index()
	{		
		$data=array(
			'usuarios' => $this->Mdl_usuarios->getUsuarios(),			
			'roles' => $this->Mdl_roles->getRoles(),
			'plazas' => $this->Mdl_plazas->getPlazas(),
		);	
			$this->load->view("layouts/header");
			$this->load->view("layouts/aside");
			$this->load->view("administrador/usuarios/list",$data);
			$this->load->view("layouts/footer");			
	}
	
	public function editAdmin($id)
	{		
		if($this->Mdl_usuarios->getUsuario($id)!=null){
			$data=array(
				'usuario'=>$this->Mdl_usuarios->getUsuario($id),
				'roles' => $this->Mdl_roles->getRoles(),
				'plazas' => $this->Mdl_plazas->getPlazas()
					);
	
				$this->load->view("layouts/header");
				$this->load->view("layouts/aside");
				$this->load->view("administrador/usuarios/editAdmin",$data);
				$this->load->view("layouts/footer");
		}else{
			$this->session->set_flashdata("error","El usuario que trató de editar no existe");                    
			redirect(base_url()."Usuarios");
		}		
	}

	public function editManager($id)
	{		
		$data=array(
			'usuario'=>$this->Mdl_usuarios->getUsuario($id),
			'roles' => $this->Mdl_roles->getRoles(),
			'plazas' => $this->Mdl_plazas->getPlazas()
					);

			$this->load->view("layouts/header");
			$this->load->view("layouts/aside");
			$this->load->view("administrador/usuarios/editManager",$data);
			$this->load->view("layouts/footer");		
	}

	public function delete2()
    {		
		if($this->input->is_ajax_request()){
			$id=$this->input->post("FFfR8");		
			if($this->Mdl_usuarios->delete($id)){
					echo 1;
			}else{
					echo 0;
			}
		}   
		else{
				redirect(base_url()."Inicio");
		}							   		
	} 
	
	public function listaAccesos()
	{			
    		    $fecha=$this->input->post("fecha");
    			if($this->input->post("buscar")){         
    				$accesos=$this->Mdl_usuarios->getlistaAccesosFecha($fecha);
    			}
    			else{
    			    $fecha=date("Y-m-d");
    				$accesos=$this->Mdl_usuarios->getlistaAccesosFecha($fecha);
    			}
    	
    			$data=array(
    				'accesos' => $accesos,
    				'fecha' => $fecha
    					);
    
    			$this->load->view("layouts/header");
    			$this->load->view("layouts/aside");
    			$this->load->view("administrador/usuarios/listaAccesos",$data);
    			$this->load->view("layouts/footer");			
	}

	public function notificaciones()
	{	
		$fecha=$this->input->post("fecha");
		if($this->input->post("actualizar")){
			if($this->Mdl_usuarios->actualizarFechaNotificacion($fecha)){
				
			}
		}
		$data=array(            
			'notificaciones' => $this->Mdl_usuarios->getNotificaciones()		
		);
			$this->load->view("layouts/header");
			$this->load->view("layouts/aside");
			$this->load->view("administrador/notificaciones/add",$data);
			$this->load->view("layouts/footer");
	}

	public function store()
	{		
		if($this->input->is_ajax_request()){			
			$nombre=$this->input->post("nombre");
			$apepat=$this->input->post("apepat");
			$apemat=$this->input->post("apemat");
			$edad=$this->input->post("edad");
			$email=$this->input->post("email");
			$usuario=$this->input->post("usuario");
			$password=$this->input->post("password");
			$plaza_id=$this->input->post("plaza_id");
			$rol_id=$this->input->post("rol_id");
			$sexo=$this->input->post("sexo");
	
			$this->form_validation->set_rules("nombre","nombre","required");
			$this->form_validation->set_rules("apepat","apepat","required");
			$this->form_validation->set_rules("apemat","apemat","required");
			$this->form_validation->set_rules("edad","edad","required");
			$this->form_validation->set_rules("usuario","usuario","required|is_unique[tbl_usuarios.Usuario]");
			$this->form_validation->set_rules("email","email","required|is_unique[tbl_usuarios.Email]");
			$this->form_validation->set_rules("password","password","required");
	
	
			if($this->form_validation->run()){
				$data=
							array(
						'Nombre'=>$nombre,
						"Apepat"=>$apepat,
						'Apemat'=>$apemat,
						"Edad"=>$edad,
						"Sexo"=>$sexo,
						'Email'=>$email,
						"Usuario"=>$usuario,
						"Password"=>sha1($password),					
						"plaza_id"=>$plaza_id,
						"rol_id"=>$rol_id	
							);
					$resultados=$this->Mdl_usuarios->save($data);		
				if($resultados!=false){				
					$hash=	password_hash($resultados, PASSWORD_BCRYPT);
					$pwd=sha1($resultados);
					$data=array("Hash"=>$hash,"sha1_id"=>$pwd);
					if($this->Mdl_usuarios->insertarHash($resultados,$data)){
						echo 1;
					}
					else{
						echo 0;
					}
				}
				else{
					$this->session->set_flashdata("error","No se pudo guardar la información");
					echo 0;                
				}
			}
			else{
				echo 0;
			}
			}   
			else{
					redirect(base_url()."Inicio");
				}				
	}
	public function update()
	{		
			$idCifrado=$this->input->post("FFfR8");
			$nombre=$this->input->post("nombre");
			$apepat=$this->input->post("apepat");
			$apemat=$this->input->post("apemat");
			$edad=$this->input->post("edad");
			$email=$this->input->post("email");
			$usuario=$this->input->post("usuario");
			$password=$this->input->post("password");
			$plaza_id=$this->input->post("plaza_id");
			$rol_id=$this->input->post("rol_id");

			$idTextoPlano=$this->Mdl_usuarios->getIDTextoPlano($idCifrado);	
			$idTextoPlano=$idTextoPlano->id;			
			$usuarioActual=$this->Mdl_usuarios->getUsuarioID($idTextoPlano);
			
			$uniqueUsuario='';
			$uniqueEmail='';

			if($email==$usuarioActual->Email){
				$uniqueEmail='';

			}
			else{
				$uniqueEmail='|is_unique[tbl_usuarios.Email]';				
			}


			if($usuario==$usuarioActual->Usuario){
				$uniqueUsuario='';
			}
			else{
				$uniqueUsuario='|is_unique[tbl_usuarios.Usuario]';
			}



			if(!$this->Mdl_usuarios->pwdVerify($password,$usuarioActual->id)){
				$password=sha1($password);				
			}

			$this->form_validation->set_rules("nombre","nombre","required");
			$this->form_validation->set_rules("apepat","apepat","required");
			$this->form_validation->set_rules("apemat","apemat","required");
			$this->form_validation->set_rules("edad","edad","required");
			$this->form_validation->set_rules("email","email","required".$uniqueEmail);
			$this->form_validation->set_rules("usuario","usuario","required".$uniqueUsuario);
			$this->form_validation->set_rules("password","password","required");

			if($this->form_validation->run()){
				$data=array(
						'Nombre'=>$nombre,
						"Apepat"=>$apepat,
						'Apemat'=>$apemat,
						"Edad"=>$edad,
						'Email'=>$email,
						"Usuario"=>$usuario,
						"Password"=>$password,					
						"plaza_id"=>$plaza_id,					
						"rol_id"=>$rol_id	
						 );
							
				if($this->Mdl_usuarios->update($usuarioActual->id,$data)){
					$this->session->set_flashdata("message","Perfil Actualizado");
					redirect(base_url()."Usuarios");
					//echo "Insertado";
				}
				else{
					$this->session->set_flashdata("error","Eror al procesar los datos");
					//echo "Fallo 1";
					redirect(base_url()."Usuarios/editAdmin/".$idCifrado);
				}
			}
			else{
				$this->session->set_flashdata("error","Los datos de email y usuario deben de ser únicos, trate con alguno diferente");
				//echo "Fallo 2";
				redirect(base_url()."Usuarios/editAdmin/".$idCifrado);
			}		
	}

	public function updateManager()
	{		
			$idCifrado=$this->input->post("FFfr8");
			$nombre=$this->input->post("nombre");
			$apepat=$this->input->post("apepat");
			$apemat=$this->input->post("apemat");
			$edad=$this->input->post("edad");
			$email=$this->input->post("email");
			$usuario=$this->input->post("usuario");
			$password=$this->input->post("password");
			
		

			$idTextoPlano=$this->Mdl_usuarios->getIDTextoPlano($idCifrado);	
			$idTextoPlano=$idTextoPlano->id;			
			$usuarioActual=$this->Mdl_usuarios->getUsuarioID($idTextoPlano);
			
			$uniqueUsuario='';
			$uniqueEmail='';

			if($email==$usuarioActual->Email ){				
				$uniqueEmail='';
			}
			else{
				$uniqueEmail='|is_unique[tbl_usuarios.Email]';				
			}

			if($usuario==$usuarioActual->Usuario){
				$uniqueUsuario='';
			}
			else{
				$uniqueUsuario='|is_unique[tbl_usuarios.Usuario]';
			}

			if(!$this->Mdl_usuarios->pwdVerify($password,$usuarioActual->id)){
				$password=sha1($password);				
			}

			$this->form_validation->set_rules("nombre","nombre","required");
			$this->form_validation->set_rules("apepat","apepat","required");
			$this->form_validation->set_rules("apemat","apemat","required");
			$this->form_validation->set_rules("edad","edad","required");
			$this->form_validation->set_rules("email","email","required".$uniqueEmail);
			$this->form_validation->set_rules("usuario","usuario","required".$uniqueUsuario);
			$this->form_validation->set_rules("password","password","required");

			if($this->form_validation->run()){
				$data=array(
						'Nombre'=>$nombre,
						"Apepat"=>$apepat,
						'Apemat'=>$apemat,
						"Edad"=>$edad,
						'Email'=>$email,
						"Usuario"=>$usuario,
						"Password"=>$password							
						 );
							
				if($this->Mdl_usuarios->update($usuarioActual->id,$data)){
					$this->session->set_flashdata("message","Perfil Actualizado");
					redirect(base_url()."Perfiles");
					//echo "Insertado";
				}
				else{
					$this->session->set_flashdata("error","Eror al procesar los datos");
					//echo "Fallo 1";
					redirect(base_url()."Usuarios/editManager/".$idCifrado);
				}
			}
			else{
				$this->session->set_flashdata("error","Los datos de email y usuario deben de ser únicos, trate con alguno diferente");
				//echo "Fallo 2";
				redirect(base_url()."Usuarios/editManager/".$idCifrado);
			}		
	
	}

	public function verificarPWD()
	{
		if($this->input->is_ajax_request()){
			$username =$this->session->userdata('username');
			$password = $this->input->post("pwd");		
			$password=sha1($password);		        
			$res = $this->Mdl_seguridad->autenticar($username, $password);		
			if (!$res) {
				echo 0;
			}
			else{

				echo 1;
			}
		}else{
			redirect(base_url()."Inicio");
		}
	}

}