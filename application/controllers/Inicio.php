<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//require 'Classes/PHPExcel/IOFactory.php';
require './assets/Classes/PHPExcel/IOFactory.php';

class Inicio extends CI_Controller {

	public function __construct()
	{
			parent::__construct();			
			$this->load->model('Mdl_inicio');
			$this->load->model('Mdl_inventario');	
			$this->load->model('Mdl_ventas');	
			$this->load->model('Mdl_pedidos');	
			$this->load->model('Mdl_usuarios');	
			if(!$this->session->userdata("login")){
				redirect(base_url());
			}
	}
			
	public function index()
	{
		$exibirModal = false;		
		
		$data  = array(
			'exibirModal' => $exibirModal	
		);

		if($this->session->userdata("rol_id")==2 || $this->session->userdata("rol_id")==4){
			$vista="admin";
		}		
		else if($this->session->userdata("rol_id")==3){
			$vista="root";
		}
		else if($this->session->userdata("rol_id")==1){
			$vista="superadmin";
		}
		else if($this->session->userdata("rol_id")==5){
			$vista="socio";
		}
			
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("paneles/".$vista,$data);
		$this->load->view("layouts/footer");
	}
	
	public function reasignar()
	{
		if($this->input->is_ajax_request()){
			$fechaCorte=$this->Mdl_usuarios->getFechaCorte();
			if($fechaCorte!=false){
				$fechaCorte=$fechaCorte->Fecha;
			}
				
		if($this->session->userdata("rol_id")==2 || $this->session->userdata("rol_id")==4){
			$plaza_id=$this->session->userdata("plaza");
			
			$cadena="";		
			$cadena2="";
			$cadena3="";
			$cadena4="";
			$cadena5="";

				
			$erroresVentas=$this->Mdl_ventas->getErroresVentasPlazas($plaza_id,$fechaCorte);		
			if($erroresVentas!=false){
				$cadena2="<h3>Cortes Faltantes</h3>";												
				foreach ($erroresVentas as $r) {					
					$cadena2.="".$r->Fecha." : ".$r->Plaza;
					$cadena2.="<br>";							
				}			
			}
			
			$faltantesDLC=$this->Mdl_inventario->getFaltantesDLCPlaza($plaza_id,$fechaCorte);		
			if($faltantesDLC!=false){
				$cadena3="<h3>DLC Faltantes</h3>";			
				foreach ($faltantesDLC as $r) {					
					$cadena3.="".$r->Fecha." : ".$r->Plaza;
					$cadena3.="<br>";					
				}			
			}

			
			
			$pedidosPendientes=$this->Mdl_pedidos->getPedidosPendientesPlaza($plaza_id);		
			if($pedidosPendientes!=false){
				$cadena4="<h3>Nuevos Pedidos</h3>";
				foreach ($pedidosPendientes as $r) {					
					$cadena4.="".$r->Fecha." : ".$r->Plaza;
					$cadena4.="<br>";				
				}			
			}

			$pedidosPendientesPasteleria=$this->Mdl_pedidos->getPedidosPasteleriaPendientesPlaza($plaza_id);
			if($pedidosPendientesPasteleria!=false){
				$cadena5="<h3>Nuevo Pedido Pasteleria</h3>";
				foreach ($pedidosPendientesPasteleria as $r) {					
					$cadena5.="".$r->Fecha." : ".$r->Plaza;
					$cadena5.="<br>";				
				}			
			}


			if($cadena2=="" && $cadena3=="" && $cadena4=="" && $cadena5==""){
				$cadena="<h1>Libre de Notificaciones</h1>";
			}

				
			$return_arr[] = array
			("cadena" => $cadena,
			"cadena2" => $cadena2,
			"cadena3" => $cadena3,
			"cadena4" => $cadena4,
			"cadena5" => $cadena5
			);                          
			echo json_encode($return_arr); 
		}	

		else if($this->session->userdata("rol_id")==3){			

			$cadena="";
			$erroresDLC=$this->Mdl_inventario->getErroresDLC();
			if($erroresDLC!=false){
				$cadena="<h3>Errores en DLC</h3>";
				$cadena.="<ul>";
				foreach ($erroresDLC as $r) {
					$cadena.="<li>".$r->Acronimo."--".$r->Usuario."--".$r->Fecha."</li>";					
				}
				$cadena.="</ul>";
			}

			$cadena2="";
			$fechaC="";
			$bandera=false;
			
			$erroresVentas=$this->Mdl_ventas->getErroresVentas($fechaCorte);		
			if($erroresVentas!=false){
				$cadena2="<h3>Cortes Faltantes</h3>";						
				$i=0;			
				foreach ($erroresVentas as $r) {
					if($i==0){
						$fechaC=$r->Fecha;
						$cadena2.="".$fechaC." :";
					}				
					if($fechaC==$r->Fecha){
						if($i==0 || $bandera==true){
							$cadena2.=" ".$r->Acronimo;	
							$bandera=false;
						}
						else{
							$cadena2.=" - ".$r->Acronimo;	
						}
					}
					else{
						$fechaC=$r->Fecha;
						$cadena2.="<br>";
						$cadena2.="".$fechaC." : ".$r->Acronimo." -";
						$bandera=true;
						
					}
					$i++;

													
				}			
			}
			
			$cadena3="";
			$fechaC="";
			$bandera=false;
			$faltantesDLC=$this->Mdl_inventario->getFaltantesDLC($fechaCorte);		
			if($faltantesDLC!=false){
				$cadena3="<h3>DLC Faltantes</h3>";
				$i=0;
				foreach ($faltantesDLC as $r) {					
					if($i==0){
						$fechaC=$r->Fecha;
						$cadena3.="".$fechaC." :";
					}				
					if($fechaC==$r->Fecha){
						if($i==0 || $bandera==true){
							$cadena3.=" ".$r->Acronimo;	
							$bandera=false;
						}
						else{
							$cadena3.=" - ".$r->Acronimo;	
						}
					}
					else{
						$fechaC=$r->Fecha;
						$cadena3.="<br>";
						$cadena3.="".$fechaC." : ".$r->Acronimo." -";
						$bandera=true;
						
					}
					$i++;							
				}			
			}


			$cadena4="";
			$fechaC="";
			$bandera=false;
			$pedidosPendientes=$this->Mdl_pedidos->getPedidosPendientes();		
			if($pedidosPendientes!=false){
				$cadena4="<h3>Pedidos Pendientes</h3>";
				$i=0;
				foreach ($pedidosPendientes as $r) {					
					if($i==0){
						$fechaC=$r->Fecha;
						$cadena4.="".$fechaC." :";
					}				
					if($fechaC==$r->Fecha){
						if($i==0 || $bandera==true){
							$cadena4.=" ".$r->Acronimo;	
							$bandera=false;
						}
						else{
							$cadena4.=" - ".$r->Acronimo;	
						}
					}
					else{
						$fechaC=$r->Fecha;
						$cadena4.="<br>";
						$cadena4.="".$fechaC." : ".$r->Acronimo." -";
						$bandera=true;
						
					}
					$i++;							
				}			
			}
			
			
			$cadena5="";
			$fechaC="";
			$bandera=false;
			$pedidosPasteleriaPendientes=$this->Mdl_pedidos->getPedidosPasteleriaPendientes();		
			if($pedidosPasteleriaPendientes!=false){
				$cadena5="<h3>Pedidos Pendientes Pasteleria</h3>";
				$i=0;
				foreach ($pedidosPasteleriaPendientes as $r) {					
					if($i==0){
						$fechaC=$r->Fecha;
						$cadena5.="".$fechaC." :";
					}				
					if($fechaC==$r->Fecha){
						if($i==0 || $bandera==true){
							$cadena5.=" ".$r->Acronimo;	
							$bandera=false;
						}
						else{
							$cadena5.=" - ".$r->Acronimo;	
						}
					}
					else{
						$fechaC=$r->Fecha;
						$cadena5.="<br>";
						$cadena5.="".$fechaC." : ".$r->Acronimo." -";
						$bandera=true;						
					}
					$i++;							
				}			
			}
				
			$return_arr[] = array
			("cadena" => $cadena,
			"cadena2" => $cadena2,
			"cadena3" => $cadena3,
			"cadena4" => $cadena4,
			"cadena5" => $cadena5
			);               

			echo json_encode($return_arr); 
		}
		else if($this->session->userdata("rol_id")==1){	
			$cadena="";		
			$cadena2="";
			$cadena3="";
				
			$cadena4="";
			$fechaC="";
			$bandera=false;
			$pedidosPendientes=$this->Mdl_pedidos->getPedidosPendientes();		
			if($pedidosPendientes!=false){
				$cadena4="<h3>Pedidos Pendientes</h3>";
				$i=0;
				foreach ($pedidosPendientes as $r) {					
					if($i==0){
						$fechaC=$r->Fecha;
						$cadena4.="".$fechaC." :";
					}				
					if($fechaC==$r->Fecha){
						if($i==0 || $bandera==true){
							$cadena4.=" ".$r->Acronimo;	
							$bandera=false;
						}
						else{
							$cadena4.=" - ".$r->Acronimo;	
						}
					}
					else{
						$fechaC=$r->Fecha;
						$cadena4.="<br>";
						$cadena4.="".$fechaC." : ".$r->Acronimo." -";
						$bandera=true;
						
					}
					$i++;							
				}			
			}
			
			
			$cadena5="";
			$fechaC="";
			$bandera=false;
			$pedidosPasteleriaPendientes=$this->Mdl_pedidos->getPedidosPasteleriaPendientes();		
			if($pedidosPasteleriaPendientes!=false){
				$cadena5="<h3>Pedidos Pendientes Pasteleria</h3>";
				$i=0;
				foreach ($pedidosPasteleriaPendientes as $r) {					
					if($i==0){
						$fechaC=$r->Fecha;
						$cadena5.="".$fechaC." :";
					}				
					if($fechaC==$r->Fecha){
						if($i==0 || $bandera==true){
							$cadena5.=" ".$r->Acronimo;	
							$bandera=false;
						}
						else{
							$cadena5.=" - ".$r->Acronimo;	
						}
					}
					else{
						$fechaC=$r->Fecha;
						$cadena5.="<br>";
						$cadena5.="".$fechaC." : ".$r->Acronimo." -";
						$bandera=true;						
					}
					$i++;							
				}			
			}

				
			$return_arr[] = array
			("cadena" => $cadena,
			"cadena2" => $cadena2,
			"cadena3" => $cadena3,
			"cadena4" => $cadena4,
			"cadena5" => $cadena5
			);                          
			echo json_encode($return_arr); 
		}

		else if($this->session->userdata("rol_id")==5){	
			$plaza_id=$this->session->userdata("plaza");
			
			$cadena="";		
			$cadena2="";
			$cadena3="";				
			$cadena4="";						
			$cadena5="";


			$erroresVentas=$this->Mdl_ventas->getErroresVentasPlazas($plaza_id,$fechaCorte);		
			if($erroresVentas!=false){
				$cadena2="<h3>Cortes Faltantes</h3>";												
				foreach ($erroresVentas as $r) {					
					$cadena2.="".$r->Fecha." : ".$r->Plaza;
					$cadena2.="<br>";							
				}			
			}
			
			$faltantesDLC=$this->Mdl_inventario->getFaltantesDLCPlaza($plaza_id,$fechaCorte);		
			if($faltantesDLC!=false){
				$cadena3="<h3>DLC Faltantes</h3>";			
				foreach ($faltantesDLC as $r) {					
					$cadena3.="".$r->Fecha." : ".$r->Plaza;
					$cadena3.="<br>";					
				}			
			}

			
				
			$return_arr[] = array
			("cadena" => $cadena,
			"cadena2" => $cadena2,
			"cadena3" => $cadena3,
			"cadena4" => $cadena4,
			"cadena5" => $cadena5
			);                          
			echo json_encode($return_arr); 
		}
		}else{
			redirect(base_url()."Inicio");
		}
		
	}
	
}
