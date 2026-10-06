<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productos extends CI_Controller {
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
        $this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("administrador/productos/panel_productos");
		$this->load->view("layouts/footer");
    }

    public function list()
	{
        $familia_id_busqueda=$this->input->post("familia_id_busqueda"); 

        if($this->input->post("buscar")){            
        if($familia_id_busqueda!=""){
            $data=
            array(
                    'productos' => $this->Mdl_productos->getProductosFamilia($familia_id_busqueda), 
                    'familias'=>$this->Mdl_productos->getFamilias(),
                    'id_familia'=>$familia_id_busqueda,                    		
			        'insumos' => $this->Mdl_productos->getInsumosInventario()
                ); 
            }
            else{
            $data=
            array(
                    'productos' => $this->Mdl_productos->getProductos(), 
                    'familias'=>$this->Mdl_productos->getFamilias(),                    
			        'insumos' => $this->Mdl_productos->getInsumosInventario()
                ); 
            }                               
        }        
        else{
            $data=
            array(
                    'productos' => $this->Mdl_productos->getProductos(), 
                    'familias'=>$this->Mdl_productos->getFamilias(),                    			
			        'insumos' => $this->Mdl_productos->getInsumosInventario()
                ); 
        }        
        $this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("administrador/productos/productos/list",$data);
		$this->load->view("layouts/footer");
    }

    public function save()
    {
        if($this->input->is_ajax_request()){
            $nombre=$this->input->post("nombre");
            $clave=$this->input->post("clave");
            $familia_id=$this->input->post("familia_id");            

            $data=array(
                "Nombre"=>$nombre,
                "Clave"=>$clave,
                "familia_id"=>$familia_id,
                'Estado'=>1  
            );

            $consultar=$this->Mdl_productos->consultarExistencia($nombre,$clave);
            if(!$consultar){
                    if($this->Mdl_productos->save($data)){
                        echo 1;
                    }
                    else{
                        echo 0;
                    }                 
            }
            else{
                echo 2;                
                //echo "NO SE PROCEDE";
            }                                    
        }   
        else{
                redirect(base_url()."Inicio");
          }        
    }
    
    public function activarProducto()
    {
        if($this->input->is_ajax_request()){
            $producto_id=$this->input->post("producto_id");   

            $estadoActual=$this->Mdl_productos->consultarEstadoProducto($producto_id);
            if($estadoActual!=null){$estadoActual=$estadoActual->Estado;}else{
                $estadoActual=-1;
            }            
            $data=array(
                "Estado"=>1    
            );

            if($estadoActual!=-1){
               if($estadoActual==0){
                    if($this->Mdl_productos->cambiarEstadoProducto($producto_id,$data)){
                        echo 1;
                    }
                    else{
                        echo 0;
                    }
                }else if($estadoActual==1){
                    //echo "EL PRODUCTO YA ESTA DESACTIVADO";
                    echo 2;
                }
                else{
                    echo 0;
                }
            }else{
                echo 0;
            }            
        }   
        else{
                redirect(base_url()."Inicio");
          }        
    }

    public function desactivarProducto()
    {
        if($this->input->is_ajax_request()){
            $producto_id=$this->input->post("producto_id");   

            $estadoActual=$this->Mdl_productos->consultarEstadoProducto($producto_id);
            if($estadoActual!=null){$estadoActual=$estadoActual->Estado;}else{
                $estadoActual=-1;
            }            
            $data=array(
                "Estado"=>0    
            );

            if($estadoActual!=-1){
               if($estadoActual==1){
                    if($this->Mdl_productos->cambiarEstadoProducto($producto_id,$data)){
                        echo 1;
                    }
                    else{
                        echo 0;
                    }
                }else if($estadoActual==0){
                    //echo "EL PRODUCTO YA ESTA DESACTIVADO";
                    echo 2;
                }
                else{
                    echo 0;
                }
            }else{
                echo 0;
            }            
        }   
        else{
                redirect(base_url()."Inicio");
          }        
    }


    public function actualizarUnidad(){
        if($this->input->is_ajax_request()){				
            $id=$this->input->post("id_editar");
            $nombre=$this->input->post("nombre_editar");

            $data=array("Nombre" => $nombre);
            if($this->Mdl_productos->actualizarUnidad($id,$data)){				
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

}
