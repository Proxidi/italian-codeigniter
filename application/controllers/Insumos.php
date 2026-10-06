<?php

use function PHPSTORM_META\type;

defined('BASEPATH') OR exit('No direct script access allowed');

class Insumos extends CI_Controller {

    private $permisos; 
    
    public function __construct()
    {
        parent::__construct();
        $this->permisos=$this->backend_lib->control();
        $this->load->model('Mdl_productos');  
        $this->load->model('Mdl_remesas'); 
        $this->load->model('Mdl_plazas'); 

        if(!$this->session->userdata("login")){
            redirect(base_url());
        }         
    }
    
    public function index()
    {            
            $data=array
            (
                'insumos' => $this->Mdl_productos->getInsumos(),
                'categorias' => $this->Mdl_productos->getCategorias(),
                'unidades' => $this->Mdl_productos->getUnidades(),
                'gruposRemesa'=>$this->Mdl_remesas->getGrupos()  
            );
            
            $this->load->view("layouts/header");
            $this->load->view("layouts/aside");
            $this->load->view("administrador/productos/insumos/list",$data);
            $this->load->view("layouts/footer");           
    }

    public function save()
    {            
        if($this->input->is_ajax_request()){        
            $categoria_id=$this->input->post("categoria_id");
            $nombre=$this->input->post("nombre");

            $inventario=$this->input->post("inventario");
            $unidad_id_produccion=$this->input->post("unidad_id_produccion");

            $inventario_fisico=$this->input->post("inventario_fisico");            
            $unidad_id_piso=$this->input->post("unidad_id_piso");
            $formula_piso=$this->input->post("formula_piso");                        
            $unidad_id_bodega=$this->input->post("unidad_id_bodega");
            $formula_bodega=$this->input->post("formula_bodega");            
            $unidad_id_total=$this->input->post("unidad_id_total");
            $formula_total=$this->input->post("formula_total");

            $remesa=$this->input->post("remesa");
            $categoria_id_remesa=$this->input->post("categoria_id_remesa");
            $unidad_id_remesa=$this->input->post("unidad_id_remesa");
            $limite_captura_remesa=$this->input->post("limite_captura_remesa");

            $pedido=$this->input->post("pedido");
            $clave_pedido=$this->input->post("clave_pedido");            
            $unidad_id_pedido=$this->input->post("unidad_id_pedido");            
            $formula_pedido=$this->input->post("formula_pedido");
                            
            $banderaInvProduccion=false;
            $banderaInvFisico=false;       
            $banderaRemesa=false;            
            $banderaError=false;


            //ASIGNACIONES DE LAS BANDERAS
                if($inventario==1){
                    $banderaInvProduccion=true;
                }   
                else if($inventario==0){
                    $banderaInvProduccion=false;            
                }

                if($inventario_fisico==1){
                    $banderaInvFisico=true;
                }
                else if($inventario_fisico==0){
                    $banderaInvFisico=false;
                }

                if($remesa==1){
                    $banderaRemesa=true;
                }
                else if($remesa==0){
                    $banderaRemesa=false;
                }

                if($pedido==1){
                    $banderaPedido=true;
                }
                else if($pedido==0){
                    $banderaPedido=false;
                }
            //ASIGNACIONES DE LAS BANDERAS

            if($this->checarBanderas($banderaInvProduccion,$banderaInvFisico,$banderaRemesa,$banderaPedido))
            {
                //LLENAR VARIABLES FALTANTES PARA SOLO EL REGISTRO DEL INSUMO                 
                    if($unidad_id_produccion==null){$unidad_id_produccion=13;}
                    if($unidad_id_pedido==null){$unidad_id_pedido=13;}
                    if($clave_pedido==null){$clave_pedido="";}    
                //LLENAR VARIABLES FALTANTES PARA SOLO EL REGISTRO DEL INSUMO

                    
                //ARREGLO PARA LA TABLA INSUMOS POR DEFECTO SE AGREGA
                    $data=array(
                        "Nombre"=>$nombre,
                        "clave_pedido"=>$clave_pedido,
                        "categorias_insumos_id"=>$categoria_id,
                        "unidad_id"=>$unidad_id_produccion,
                        "unidad_pedido"=>$unidad_id_pedido,
                        "unidad_final"=>$unidad_id_produccion,
                        "inv_produccion"=>$inventario,
                        "inv_fisico"=>$inventario_fisico
                    );

                //GUARDAMOS EL ID DEL INSUMO INSERTADO EN CASO DE QUE NO SE INSERTO SE GUARD FALSE            
                $insumo_id=$this->Mdl_productos->saveInsumo($data);

                    if($insumo_id!=false){
                        //EN DADO CASO DE QUE SEA CORRECTO CONTINUAMOS EVALUANDO CADA UNA DE LAS VARIABLES                
                        
                        //INSUMO HABILITADO PARA EL INVENTARIO DE PRODUCCIÓN
                        if($banderaInvProduccion){
                            $dataIP = array(
                                array(
                                    'insumo_id' => $insumo_id,
                                    'plaza_id' => 1,
                                    'stock_minimo' =>0,
                                    'stock_medio' =>0,
                                    'Cantidad' =>0                        
                                ),
                                array(
                                    'insumo_id' => $insumo_id,
                                    'plaza_id' => 2,
                                    'stock_minimo' =>0,
                                    'stock_medio' =>0,
                                    'Cantidad' =>0   
                                    
                                ),
                                array(
                                    'insumo_id' => $insumo_id,
                                    'plaza_id' => 3,
                                    'stock_minimo' =>0,
                                    'stock_medio' =>0,
                                    'Cantidad' =>0   
                
                                ),
                                array(
                                    'insumo_id' => $insumo_id,
                                    'plaza_id' => 4,
                                    'stock_minimo' =>0,
                                    'stock_medio' =>0,
                                    'Cantidad' =>0   
                                    
                                ),
                                array(
                                    'insumo_id' => $insumo_id,
                                    'plaza_id' => 5,
                                    'stock_minimo' =>0,
                                    'stock_medio' =>0,
                                    'Cantidad' =>0   
                                    
                                ),
                                array(
                                    'insumo_id' => $insumo_id,
                                    'plaza_id' => 6,
                                    'stock_minimo' =>0,
                                    'stock_medio' =>0,
                                    'Cantidad' =>0   
                
                                ),
                                array(
                                    'insumo_id' => $insumo_id,
                                    'plaza_id' => 7,
                                    'stock_minimo' =>0,
                                    'stock_medio' =>0,
                                    'Cantidad' =>0                           
                                )
                            );
                        if($this->Mdl_productos->saveInventarioProducccion($dataIP)){                                      
                            $banderaError=false;
                        }
                        else{
                            //echo 0;
                            $banderaError=true;
                        }   
                        }                     
                        //.INSUMO HABILITADO PARA EL INVENTARIO DE PRODUCCIÓN
                        
                        
                        //INSUMO HABILITADO PARA EL INVENTARIO FÍSICO
                        if($banderaInvFisico){
                            //echo 1;
                            $dataIF = array(
                                    array(
                                        'plaza_id' => 1,
                                        'insumo_id' => $insumo_id,                            
                                        'Bodega' =>0,
                                        'Unidad_Bodega' =>$unidad_id_bodega,
                                        'Piso' =>0,
                                        'Unidad_Piso' =>$unidad_id_piso,
                                        'Total' =>0,
                                        'Unidad_Total' =>$unidad_id_total,
                                        'Bandera' =>0,
                                        'Centinela' =>1
            
                                    ),
                                    array(
                                        'plaza_id' => 2,
                                        'insumo_id' => $insumo_id,   
                                        'Bodega' =>0,
                                        'Unidad_Bodega' =>$unidad_id_bodega,
                                        'Piso' =>0,
                                        'Unidad_Piso' =>$unidad_id_piso,
                                        'Total' =>0,
                                        'Unidad_Total' =>$unidad_id_total,
                                        'Bandera' =>0,
                                        'Centinela' =>1                         
                                        
                                        
                                    ),
                                    array(
                                        'plaza_id' => 3,
                                        'insumo_id' => $insumo_id,    
                                        'Bodega' =>0,
                                        'Unidad_Bodega' =>$unidad_id_bodega,
                                        'Piso' =>0,
                                        'Unidad_Piso' =>$unidad_id_piso,
                                        'Total' =>0,
                                        'Unidad_Total' =>$unidad_id_total,
                                        'Bandera' =>0,
                                        'Centinela' =>1                        
                                        
                    
                                    ),
                                    array(
                                        'plaza_id' => 4,
                                        'insumo_id' => $insumo_id,
                                        'Bodega' =>0,
                                        'Unidad_Bodega' =>$unidad_id_bodega,
                                        'Piso' =>0,
                                        'Unidad_Piso' =>$unidad_id_piso,
                                        'Total' =>0,
                                        'Unidad_Total' =>$unidad_id_total,
                                        'Bandera' =>0,
                                        'Centinela' =>1                            
                                        
                                        
                                    ),
                                    array(
                                        'plaza_id' => 5,
                                        'insumo_id' => $insumo_id,
                                        'Bodega' =>0,
                                        'Unidad_Bodega' =>$unidad_id_bodega,
                                        'Piso' =>0,
                                        'Unidad_Piso' =>$unidad_id_piso,
                                        'Total' =>0,
                                        'Unidad_Total' =>$unidad_id_total,
                                        'Bandera' =>0,
                                        'Centinela' =>1                            
                                        
                                        
                                    ),
                                    array(
                                        'plaza_id' => 6,
                                        'insumo_id' => $insumo_id,
                                        'Bodega' =>0,
                                        'Unidad_Bodega' =>$unidad_id_bodega,
                                        'Piso' =>0,
                                        'Unidad_Piso' =>$unidad_id_piso,
                                        'Total' =>0,
                                        'Unidad_Total' =>$unidad_id_total,
                                        'Bandera' =>0,
                                        'Centinela' =>1                            
                                        
                    
                                    ),
                                    array(
                                        'plaza_id' => 7,
                                        'insumo_id' => $insumo_id,
                                        'Bodega' =>0,
                                        'Unidad_Bodega' =>$unidad_id_bodega,
                                        'Piso' =>0,
                                        'Unidad_Piso' =>$unidad_id_piso,
                                        'Total' =>0,
                                        'Unidad_Total' =>$unidad_id_total,
                                        'Bandera' =>0,
                                        'Centinela' =>1                                                                                 
                                    )
                            );
                            if($this->Mdl_productos->saveInventarioFisico($dataIF)){
                                $nombre=$this->Mdl_productos->getNombreInsumo($insumo_id);
                                if($nombre!=null){
                                    $nombre=$nombre->Nombre;
                                    
                                    $disponibilidad=$this->Mdl_productos->checarInsumoInventario($insumo_id);

                                    if($disponibilidad){
                                        //INSERTAMOS
                                        $dataII=array(
                                            'Nombre' => $nombre,
                                            'insumo_id' => $insumo_id,
                                            'Bodega' =>$formula_bodega,
                                            'Piso' =>$formula_piso,
                                            'Total' =>$formula_total,
                                            'DLC' =>'*,1',
                                            'Pedido' =>'*,1'
                                        );
                                    }else{
                                        //ACTUALIZAMOS
                                        $dataII=array(
                                            'Nombre' => $nombre,
                                            'insumo_id' => $insumo_id,
                                            'Bodega' =>$formula_bodega,
                                            'Piso' =>$formula_piso,
                                            'Total' =>$formula_total,
                                            'DLC' =>'*,1',
                                            'Pedido' =>'*,1'
                                        );

                                    }

                                    if($this->Mdl_productos->saveInsumosInventario($dataII)){
                                        $banderaError=false;
                                    }
                                    else{
                                        $banderaError=true;
                                    }
                                }
                                else{
                                    //echo 0;
                                    $banderaError=true;
                                }                            
                                //echo 1;
                            }else{
                                //echo 0;
                                $banderaError=true;
                            }                        
                        }                
                        //.INSUMO HABILITADO PARA EL INVENTARIO FÍSICO  


                        //INSUMO HABILITADO PARA LA CAPTURA DE LA REMESA
                        if($banderaRemesa){
                            $dataII=array(
                                'grupo_id' =>1,
                                'insumo_id' => $insumo_id,
                                'unidad_id' =>$unidad_id_remesa,
                                'grupo_rol_id' =>'*,1',
                                'Nombre' =>'*,1'                        
                            );                   
                            if($this->Mdl_productos->saveInventarioFisico($dataIF)){
                                $nombre=$this->Mdl_productos->getNombreInsumo($insumo_id);
                                if($nombre!=null){
                                    $nombre=$nombre->Nombre;
                                                                
                                    if($this->Mdl_productos->saveInsumosInventario($dataII)){
                                        $banderaError=false;
                                    }
                                    else{
                                        $banderaError=true;
                                    }
                                }
                                else{
                                    //echo 0;
                                    $banderaError=true;
                                }                            
                                //echo 1;
                            }else{
                                //echo 0;
                                $banderaError=true;
                            }                        
                        }                
                        //./INSUMO HABILITADO PARA LA CAPTURA DE LA REMESA                      
                    }
                    //SE EJECUTA EN DADO CASO DE QUE EL INSUMO DESDE EL PRINCIPIO NO SE HAYA PODIDO REGISTRAR
                    else{                       
                        $banderaError=true;
                    }
                    if($banderaError){
                        echo 0;
                    }else{
                        echo 1;
                    }
            }else{
                echo 0;
            }
        }   
        else{
                redirect(base_url()."Inicio");
            }                                  
    }

    public function checarBanderas($bUno,$bDos,$bTres,$bCuatro){
        if($bUno==false && $bDos==false && $bTres==false && $bCuatro==false){
            return false;
        }else{
            return true;
        }
    }
    
    public function consultarOperacionesInsumo()
    {
        if($this->input->is_ajax_request()){
            $insumo_id=$this->input->post('insumo_id');   			                                                	                
            $return_arr[] = array
            ("tabla" => $this->Mdl_productos->getOperacionesInsumo($insumo_id)				
            );
            echo json_encode($return_arr); 
        }   
        else{
                redirect(base_url()."Inicio");
            }															
    }

    public function actualizarOperaciones()
	{			                    
        if($this->input->is_ajax_request()){

            $id=$this->input->post("id_operacion_insumo");
            $pedido=$this->input->post("pedido_operacion_insumo");
            $bodega=$this->input->post("bodega_operacion_insumo");
            
            if(empty($pedido) || empty($bodega)){

                $arreglo[] = array
                (
                    "data" => "No se admiten campos vacios o nulos",
                    "value"=>false                   
                );

                echo json_encode($arreglo);
                return;
            }

            $regexPedido=preg_match("/^(((\*|\+|\-|\/),(\d+(\.\d+)?)),?)+$/",$pedido);
            $regexBodega=preg_match("/^(((\*|\+|\-|\/),(\d+(\.\d+)?)),?)+$/",$bodega);

            //Ahora solo nos falta validar la ultima coma
            $sizeStringPedido=strlen($pedido);
            $sizeStringBodega=strlen($bodega);

            $indexStringPedido=$sizeStringPedido-1;
            $indexStringBodega=$sizeStringBodega-1;

            $comaPedido=$pedido[$indexStringPedido];
            $comaBodega=$bodega[$indexStringBodega];

            //En dado caso las cadenas que nos enviaron son correctas procedemos
            //a guardar los valores            
            if ($regexPedido && $regexBodega && $comaPedido!=',' && $comaBodega!=',') 
            {                
                $data=array("Bodega"=>$bodega,"Pedido"=>$pedido);

                if($this->Mdl_productos->actualizarOperacionInsumo($id,$data)){                
                    $arreglo[] = array
                    (
                        "data" => $data,
                        "value"=>true                        
                    );
                    
                    echo json_encode($arreglo);
                }
                else{
                    $arreglo[] = array
                    (
                        "data" => "Ha ocurrido un error al establecer la comunicación con la DB",
                        "value"=>false                        
                    );
                    
                    echo json_encode($arreglo);
                }                
            } else 
            {                
                $arreglo[] = array
                (
                    "data" => "Los valores enviados no cumplen la expresión regular",
                    "value"=>false                     
                );
                    
                echo json_encode($arreglo);
            }                                                                              
        }   
        else{
            redirect(base_url()."Inicio");
        }				                     
    }
    
    public function getInsumosCostoVenta()
    {                    

        $insumosCompras=$this->Mdl_productos->getInsumosCostoVentaCompras();               

        $fechaInicial=$this->fechaLunes(date("Y-m-d"));
        $fechaFinal=$this->fechaDomingo(date("Y-m-d"));          
                
        $plazas=$this->Mdl_plazas->getPlazas();

        $arrayInsumosCompras=array();
        $k=0;
        for ($i=0; $i <sizeof($plazas); $i++) {             
            for ($j=0; $j <sizeof($insumosCompras); $j++) { 
                $arrayInsumosCompras[$k]["id"]=$insumosCompras[$j]->id;
                $arrayInsumosCompras[$k]["Nombre"]=$insumosCompras[$j]->Nombre;
                $arrayInsumosCompras[$k]["Plaza"]=$plazas[$i]->Nombre;
                //El cálculo del costo de venta será por plazas un promedio en un rango de fechas que
                //Iran desde el lunes hasta el domingo  
                $sumaImporteInsumo=$this->Mdl_productos->getPrecioPromedioInsumo($fechaInicial,$fechaFinal,$plazas[$i]->id,$insumosCompras[$j]->id)->Importe;
                $sumaCantidadInsumo=$this->Mdl_productos->getPrecioPromedioInsumo($fechaInicial,$fechaFinal,$plazas[$i]->id,$insumosCompras[$j]->id)->Cantidad;

                if(empty($sumaImporteInsumo) && empty($sumaCantidadInsumo)){                        
                    $arrayInsumosCompras[$k]["Costo_Venta"]=0;   
                }else{                                    
                    $arrayInsumosCompras[$k]["Costo_Venta"]=round($sumaImporteInsumo/$sumaCantidadInsumo,3);
                }          
                $k++;                        
            }
        }
    
        $data=array
        (
            'insumosPedido' => $this->Mdl_productos->getInsumosCostoVentaPedido(),
            'insumosCompras' => $arrayInsumosCompras,
            'fechaInicioBusqueda'=>$fechaInicial,                        
            'fechaFinBusqueda'=>$fechaFinal,
            'plazas'=>$plazas
        );
        
        
        $this->load->view("layouts/header");
        $this->load->view("layouts/aside");
        $this->load->view("administrador/productos/insumos/costo_venta",$data);
        $this->load->view("layouts/footer");           
    }

    //Este método atiende el formulario es una petición ajax y regresa solo datos de las compras
    public function getInsumosCompras(){
        if($this->input->is_ajax_request()){

            $fechaInicioBusqueda=$this->input->post('fechaInicioBusqueda');
            $plaza_id=$this->input->post('plaza_id');

            $fechaInicial=$this->fechaLunes($fechaInicioBusqueda);
            $fechaFinal=$this->fechaDomingo($fechaInicioBusqueda);            

            if($plaza_id==0){
                $data=array
                (            
                    'fechaInicioBusqueda' => $fechaInicial,
                    'fechaFinBusqueda' => $fechaFinal,
                    'insumosCompras' => $this->fncInsumosCompras($fechaInicial,$fechaFinal)
                );

                echo json_encode($data);
            }else{                                
                $data=array
                (            
                    'fechaInicioBusqueda' => $fechaInicial,
                    'fechaFinBusqueda' => $fechaFinal,
                    'insumosCompras' => $this->fncInsumosComprasPlaza($fechaInicial,$fechaFinal,$plaza_id)
                );

                echo json_encode($data);
            }                                                                    
        }   
        else{
            redirect(base_url()."Inicio");
        }
    }

    public function fncInsumosComprasPlaza($fechaInicial,$fechaFinal,$plaza_id){
        $insumosCompras=$this->Mdl_productos->getInsumosCostoVentaCompras();
        $arrayInsumosCompras=array();
                        
        for ($i=0; $i <sizeof($insumosCompras); $i++) { 
            $arrayInsumosCompras[$i]["id"]=$insumosCompras[$i]->id;
            $arrayInsumosCompras[$i]["Nombre"]=$insumosCompras[$i]->Nombre;
            $arrayInsumosCompras[$i]["Plaza"]=$this->Mdl_plazas->getNombrePlaza($plaza_id)->Nombre;
            
            //El cálculo del costo de venta será por plazas un promedio en un rango de fechas que
            //Iran desde el lunes hasta el domingo  
            $sumaImporteInsumo=$this->Mdl_productos->getPrecioPromedioInsumo($fechaInicial,$fechaFinal,$plaza_id,$insumosCompras[$i]->id)->Importe;
            $sumaCantidadInsumo=$this->Mdl_productos->getPrecioPromedioInsumo($fechaInicial,$fechaFinal,$plaza_id,$insumosCompras[$i]->id)->Cantidad;

            if(empty($sumaImporteInsumo) && empty($sumaCantidadInsumo)){                         
                $arrayInsumosCompras[$i]["Costo_Venta"]=0;   
            }else{                                    
                $arrayInsumosCompras[$i]["Costo_Venta"]=$sumaImporteInsumo/$sumaCantidadInsumo;
            }                      
        }               

        return $arrayInsumosCompras;
    }

    public function fncInsumosCompras($fechaInicial,$fechaFinal){        
       
        $insumosCompras=$this->Mdl_productos->getInsumosCostoVentaCompras();
        $arrayInsumosCompras=array();
        $plazas=$this->Mdl_plazas->getPlazas();
        $k=0;

        for ($i=0; $i <sizeof($plazas); $i++) { 
            for ($j=0; $j <sizeof($insumosCompras); $j++) { 
                $arrayInsumosCompras[$k]["id"]=$insumosCompras[$j]->id;
                $arrayInsumosCompras[$k]["Nombre"]=$insumosCompras[$j]->Nombre;
                $arrayInsumosCompras[$k]["Plaza"]=$this->Mdl_plazas->getNombrePlaza($plazas[$i]->id)->Nombre;
                //El cálculo del costo de venta será por plazas un promedio en un rango de fechas que
                //Iran desde el lunes hasta el domingo  
                $sumaImporteInsumo=$this->Mdl_productos->getPrecioPromedioInsumo($fechaInicial,$fechaFinal,$plazas[$i]->id,$insumosCompras[$j]->id)->Importe;
                $sumaCantidadInsumo=$this->Mdl_productos->getPrecioPromedioInsumo($fechaInicial,$fechaFinal,$plazas[$i]->id,$insumosCompras[$j]->id)->Cantidad;
    
                if(empty($sumaImporteInsumo) && empty($sumaCantidadInsumo)){                         
                    $arrayInsumosCompras[$k]["Costo_Venta"]=0;   
                }else{                                    
                    $arrayInsumosCompras[$k]["Costo_Venta"]=$sumaImporteInsumo/$sumaCantidadInsumo;
                }                      
                $k++;
            }
        }

        return $arrayInsumosCompras;
    }

    public function getInsumoCostoVenta()
    {
        if($this->input->is_ajax_request()){

            $insumo_id=$this->input->post('insumo_id');   			                                                	                

            $data[] = array
            (
                "data" => $this->Mdl_productos->getInsumoCostoVenta($insumo_id)				
            );
            echo json_encode($data); 
        }   
        else{
                redirect(base_url()."Inicio");
        }															
    }

    public function actualizarCostoVenta()
	{			
        if($this->input->is_ajax_request()){

            $id=$this->input->post("insumo_id");
            $costoVenta=$this->input->post("costo_venta");

            if(is_numeric($costoVenta)){
                $data=array("Costo_Venta" =>$costoVenta);
                if($this->Mdl_productos->actualizarCostoVenta($id,$data)){
                    
                    $data=array
                    (
                        "data" => $this->Mdl_productos->getInsumosCostoVentaPedido()
                    );
                    
                    echo json_encode($data);                                      
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

    public function getCurrentYearFromDate($date){        
        $timestamp = strtotime($date);
        echo date("Y", $timestamp);
    }

    public function fechaLunes($date){        
        $year = strtotime($date);
        $year= date("Y", $year);        
        $weeknumber=date("W", strtotime($date));
        $gendate = new DateTime();
        $gendate->setISODate($year,$weeknumber,1); //year , week num , day
        return $gendate->format('Y-m-d');                
    }

    public function fechaDomingo($date){        
        $year = strtotime($date);
        $year= date("Y", $year);        
        $weeknumber=date("W", strtotime($date));
        $gendate = new DateTime();
        $gendate->setISODate($year,$weeknumber,7); //year , week num , day
        return $gendate->format('Y-m-d');                
    }
    
}
