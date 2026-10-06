<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Formulas extends CI_Controller {
	private $permisos; 

		public function __construct()
		{
				parent::__construct();
				$this->permisos=$this->backend_lib->control();
				$this->load->model('Mdl_formulas');			 
				$this->load->model('Mdl_productos');
				if(!$this->session->userdata("login")){
					redirect(base_url());
					}		 
		}

		public function index()
		{
			/*
			$data=array
			('formulas' => $this->Mdl_formulas->getFormulas(),
			'productos' => $this->Mdl_productos->getProductos(),
			'insumos' => $this->Mdl_productos->getInsumos()
			);
		
			$this->load->view("layouts/header");
			$this->load->view("layouts/aside");
			$this->load->view("administrador/productos/formulas/list",$data);
			$this->load->view("layouts/footer");	
			*/
		}

		public function actualizarFormula()
		{			
			if($this->input->is_ajax_request()){				
				$id=$this->input->post("id_modificar");
				$cantidad=$this->input->post("cantidadFormula_modificar");
				$producto_id=$this->input->post("producto_id_modificar");															
				if(is_numeric($cantidad)){
					$data=array("Cantidad" => $cantidad);
					if($this->Mdl_formulas->update($id,$data)){				
						$return_arr[] = array
						("formula" => $this->Mdl_formulas->getFormulaModalLeer($producto_id),						
						"correcto"=>1
						);
						echo json_encode($return_arr);										
				}else{
						$return_arr[] = array
						("formula" => $this->Mdl_formulas->getFormulaModalLeer($producto_id),						
						"correcto"=>0
						);
						echo json_encode($return_arr);
				}  
			}   
			else{
					redirect(base_url()."Inicio");
			  }								   
		}
	}

		public function consultarFormula()
		{  
			
			if($this->input->is_ajax_request()){
				$producto_id=$this->input->post('producto_id');    
				$bandera=$this->input->post("bandera");	
				if($bandera==1){
					echo $this->Mdl_formulas->getFormulaModal($producto_id);
					//echo $this->Mdl_formulas->getFormulasAJAX();
				}else if($bandera==0){
					echo $this->Mdl_formulas->getFormulasAJAX();
				}
			}   
			else{
					redirect(base_url()."Inicio");
			  }						                   
		}

		public function consultarFormulaModal()
		{
			if($this->input->is_ajax_request()){
				$producto_id=$this->input->post('producto_id');   
				$nombre=$this->Mdl_productos->getProductoID($producto_id);
				$insumo=$this->input->post('insumo_id');   
				$unidad=$this->Mdl_productos->getUnidadIDFormula($insumo); 
				if($unidad!=null){
					$valor=$unidad->unidad_id;   					   
				}else{
					$valor=13;
				}	
				$return_arr[] = array
				("formula" => $this->Mdl_formulas->getFormulaModalLeer($producto_id),
				"nombre" =>$nombre->Nombre,
				"unidad"=>$this->Mdl_productos->getUnidadesID($valor)
				);

				echo json_encode($return_arr); 
			}   
			else{
					redirect(base_url()."Inicio");
				}															
		}
							
		public function consultarUnidad()
		{
			if($this->input->is_ajax_request()){
				if($this->input->post('insumo_id_formulas'))
				{
					$insumo=$this->input->post('insumo_id_formulas');                    
					$unidad=$this->Mdl_productos->getUnidadIDFormula($insumo); 
					if($unidad!=null){
						$valor=$unidad->unidad_id;   					   
					}else{
						$valor=13;
					}					   
					echo $this->Mdl_productos->getUnidadesID($valor);
				}
			}   
			else{
					redirect(base_url()."Inicio");
			  }								  
		}

		public function delete()
		{
				if($this->input->is_ajax_request()){
					$id=$this->input->post("id");
					$producto_id=$this->input->post("producto_id");
					if($this->Mdl_formulas->delete($id)){
						$return_arr[] = array
						("formula" => $this->Mdl_formulas->getFormulaModalLeer($producto_id),						
						"correcto"=>1
						);
						echo json_encode($return_arr);	
					}else{
						$return_arr[] = array
						("formula" => $this->Mdl_formulas->getFormulaModalLeer($producto_id),						
						"correcto"=>0
						);
						echo json_encode($return_arr);	
					}	
				}   
				else{
						redirect(base_url()."Inicio");
				  }					
		}

		public function store()
		{
		
				if($this->input->is_ajax_request()){
					$producto_id=$this->input->post("producto_id_nueva_formula");
					$insumo_id=$this->input->post("insumo_id_formulas");
					$cantidad=$this->input->post("cantidad");
					
					if($this->Mdl_formulas->checarInsumoProducto($producto_id,$insumo_id)){
							$data=array(
								"producto_id"=>$producto_id,
								"insumo_id"=>$insumo_id,
								"cantidad"=>$cantidad
						);
		
						if($this->Mdl_formulas->save($data)){
							$return_arr[] = array
							("formula" => $this->Mdl_formulas->getFormulaModalLeer($producto_id),						
							"correcto"=>1
							);
							echo json_encode($return_arr);						
						}				
						else{
							$return_arr[] = array
							("formula" => $this->Mdl_formulas->getFormulaModalLeer($producto_id),						
							"correcto"=>0
							);						
							echo json_encode($return_arr);						
						}
					}else{
						$return_arr[] = array
						("formula" => $this->Mdl_formulas->getFormulaModalLeer($producto_id),						
						"correcto"=>2
						);						
						echo json_encode($return_arr);	
					}						
				}   
				else{
						redirect(base_url()."Inicio");
				  }													
		}
		
		public function update()
		{
			
				if($this->input->is_ajax_request()){
					$idFormula=$this->input->post("idFormula");
					$formulaActual=$this->Mdl_formulas->getFormulaID($idFormula);
					$producto_id=$this->input->post("producto_id");
					$insumo_id=$this->input->post("insumo_id");			
					$cantidad=$this->input->post("cantidad");
						
					
					$this->form_validation->set_rules("producto_id","producto_id","required");
					$this->form_validation->set_rules("insumo_id","insumo_id","required");		
					$this->form_validation->set_rules("cantidad","cantidad","required");
						
					if($this->form_validation->run()){
						$data=array(
								'producto_id'=>$producto_id,
								"insumo_id"=>$insumo_id,
								"cantidad"=>$cantidad										
									);
									
						if($this->Mdl_formulas->update($idFormula,$data)){
						// redirect(base_url()."Formulas/list");
						echo json_encode($data);
						}
						else{
							$this->session->set_flashdata("error","No se pudo guardar la información");
						// redirect(base_url()."Formulas/list");
						}			
					}
					else{
						$this->add();
					}
				}   
				else{
						redirect(base_url()."Inicio");
				  }									
		}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////FORMULAS/////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////////////////////		


	


}