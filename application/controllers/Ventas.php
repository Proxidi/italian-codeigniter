<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require './assets/Classes/PHPExcel/IOFactory.php';

class Ventas extends CI_Controller {

        private $permisos;  
        
        public function __construct()
        {
             parent::__construct();
             $this->permisos=$this->backend_lib->control();             
             $this->load->model('Mdl_ventas');
             $this->load->model('Mdl_remesas');
             $this->load->model('Mdl_depositos');
             $this->load->model('Mdl_unidades');
             $this->load->model('Mdl_inventario');
             $this->load->model('Mdl_opciones');
             $this->load->model('Mdl_productos');
             $this->load->model('Mdl_plazas');

             if(!$this->session->userdata("login")){
				redirect(base_url());
				}
        }

        public function index()
        {
            $this->load->view("layouts/header");
            $this->load->view("layouts/aside");
            $this->load->view("manager/reportes/ventas/panel_ventas");
            $this->load->view("layouts/footer");
                    
        }

        public function add2()
	    {		      
                $plaza_id=$this->session->userdata("plaza");   
                $fechainicio=date('Y-m-d',strtotime("-1 days"));

                $data=array(
                    "reportes" => $this->Mdl_ventas->getVentasID($plaza_id)                    
                );
                $this->load->view("layouts/header");
                $this->load->view("layouts/aside");
                $this->load->view("manager/reportes/ventas/teziutlan/add2",$data);
                $this->load->view("layouts/footer");
        }

        public function consultarEstadoVenta()
        {
            if($this->input->is_ajax_request()){
                $fecha=$this->input->post("fecha");
                $plaza_id=$this->input->post("plaza_id"); 

                $resultado=$this->Mdl_ventas->getBanderaCorteFecha($fecha,$plaza_id);            
                if($resultado!=false){
                    $resultado=$resultado->Enviado;
                    if($resultado==1){
                        echo 1;
                    }
                    else if($resultado==0){
                        echo 0;
                    }
                }else{
                    //Dos significa que hubo un error al consultar la bandera
                    echo 2;
            }   
            }   
            else{
                    redirect(base_url()."Inicio");
              }                     
        }

        public function delete()
        {   
            if($this->input->is_ajax_request()){
                $plaza_id=$this->session->userdata("plaza");
                $fecha=$this->input->post("fecha");  

                if($this->Mdl_ventas->checarDLC($fecha,$plaza_id)){
                        echo -1;
                }
                else{
                    if($this->Mdl_ventas->deleteAll($fecha,$plaza_id)){												
                    	echo 11;            
                    }else{
                      echo 00;      
                    }
                }
            }   
            else  {
                        redirect(base_url()."Inicio");
                }
            
        } 

        public function gastos($fecha,$plaza_id){
            $reportes=$this->Mdl_remesas->getGastosVentas($fecha,$plaza_id); 
            if($reportes!=false){
                return $reportes->Importe;        
            } 
        }

        public function gastosAdmin($fecha,$plaza_id){
            $reportes=$this->Mdl_remesas->getGastosVentasAdmin($fecha,$plaza_id); 
            if($reportes!=false){
                return $reportes->Importe;        
            } 
        }

        public function gastosAll($fecha,$plaza_id){
            $reportes=$this->Mdl_remesas->getGastosVentasAll($fecha,$plaza_id); 
            if($reportes!=false){
                return $reportes->Importe;        
            } 
        }

        private function getWeeks($date, $rollover)
        {
            
            $cut = substr($date, 0, 8);
            $daylen = 86400;
    
            $timestamp = strtotime($date);
            $first = strtotime($cut . "00");
            $elapsed = ($timestamp - $first) / $daylen;
    
            $weeks = 1;
    
            for ($i = 1; $i <= $elapsed; $i++)
            {
                $dayfind = $cut . (strlen($i) < 2 ? '0' . $i : $i);
                $daytimestamp = strtotime($dayfind);
    
                $day = strtolower(date("l", $daytimestamp));
    
                if($day == strtolower($rollover))  $weeks ++;
            }
    
            return $weeks;
        }

        private function listVentas()
	    {		                                      
                $data=array(
                    "reportes" => $this->Mdl_ventas->getVentas()
                );
                $this->load->view("layouts/header");
                $this->load->view("layouts/aside");
                $this->load->view("administrador/archivos/ventas/list",$data);
                $this->load->view("layouts/footer");
        }

        public function procesarReporte($datos)
        {
           
             $return_arr = array();	
             $carpeta=$datos['carpeta'];          
             $fechaCompleta=$datos['fecha'];
             $contadorTicket=0;	       
             $contadorLlevar=0;	   
             $contadorComedor=0;                 
             $totalIngresos="";
             $totalVentas="";
             $TPV="";
             $Efectivo="";            		                                             
             $totalVentasR=null;
             $totalIngresosR=null;             
             $EfectivoR=null;
             $banderaTipoCorte=true;
             
                 $nombreArchivo=FCPATH . 'assets/files/'.$carpeta."/".$fechaCompleta."_Corte_.xls";
                 $exists = file_exists( $nombreArchivo);
     
                 if($exists==true){                                        
                     $objPHPExcel=PHPEXCEL_IOFactory::load($nombreArchivo);
                     $objPHPExcel->setActiveSheetIndex(0);
                     $numRows=$objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

                     for ($i=10; $i <=$numRows; $i++) {                         
                        $folioP=$objPHPExcel->getActiveSheet()->getCell('A'.$i)->getValue();             
                        $mesaP=$objPHPExcel->getActiveSheet()->getCell('B'.$i)->getValue();
                        $folio2P=preg_replace('/\s+/', ',', $folioP);                                                        
                        $myArrayP = explode(',', $folio2P);                        
                        $tpv_1FP=current($myArrayP);                                                                        
                        $tpv_2FP=next($myArrayP);
                        $tpv_3FP=next($myArrayP);   
                        if($tpv_1FP=="Personas" || $tpv_1FP=="Mesas" ){
                            $banderaTipoCorte=false;                            
                            break;
                         }                                         
                    }
                    
                    if($banderaTipoCorte){
                        for ($i=10; $i<=$numRows; $i++){
     
                            $folio=$objPHPExcel->getActiveSheet()->getCell('A'.$i)->getValue();             
                            $mesa=$objPHPExcel->getActiveSheet()->getCell('B'.$i)->getValue();
   
                            $folio2=preg_replace('/\s+/', ',', $folio);                                                        
                            $myArray = explode(',', $folio2);                        
                            $tpv_1F=current($myArray);                                                                        
                            $tpv_2F=next($myArray);
                            $tpv_3F=next($myArray);    
                            
                            if($tpv_3F=="EFECTIVO" || $tpv_3F=="TARJETA"){
                               $contadorTicket=$contadorTicket+1;
                            }     
   
   
                            if($tpv_2F==-1 || $tpv_2F==-2 || $tpv_2F==-9001 || $tpv_2F==-9002){
                               $contadorLlevar=$contadorLlevar+1;
                            }  
           
                            if($tpv_1F!="Caja" && $tpv_2F>0){
                               $contadorComedor=$contadorComedor+1;
                            }
           
                                   $resultado = $folio . $mesa;                         
                                    $cadena_de_texto = $resultado;
                                    $cadena_buscada   = 'TOTAL VENTAS';
                                    $cadena_buscada2   = 'Ingresos por Ventas:';                                 
                                    
                                    
                                    $posicion_coincidencia = strrpos($cadena_de_texto, $cadena_buscada);
                                    $posicion_coincidencia2 = strrpos($cadena_de_texto, $cadena_buscada2);
                                    
                                             
                                    if ($posicion_coincidencia !== false) {
                                        $totalVentasR=$resultado;
                                        $rest = substr($resultado,19,40);
                                        $totalVentasR=$rest;       
                                    } 
                                    if ($posicion_coincidencia2 !== false) { 
                                            $totalIngresosR=$resultado;
                                            $rest = substr($resultado,23,40);
                                            $totalIngresosR=$rest;               
                                    }      
                                                                         
                          }
                    }                     
                       if($totalVentasR !=null && $totalIngresosR != null){
                             $totalVentas=$totalVentasR;
                             $totalIngresos=$totalIngresosR;    
                             return  $return_arr[] =                          
                             array(
                              "totalVentas" => $totalVentas,
                              "totalIngresos" => $totalIngresos,                             
                              'Tickets' =>$contadorTicket,
                              'Tickets_Comedor' =>$contadorComedor,
                              'Porcentaje_Comedor' =>round(($contadorComedor*100)/$contadorTicket,3),
                              'Tickets_Llevar' =>$contadorLlevar,
                              'Porcentaje_Llevar' =>round(($contadorLlevar*100)/$contadorTicket,3),
                              "TicketPromedio" => round($totalIngresos/$contadorTicket,2)                           
                              );                                                                                                   
 
                       }
                       else{
                         $totalVentas=null;
                         $totalIngresos=null;
                         return  $return_arr[] =                          
                             array(
                              "totalVentas" => $totalVentas,
                              "totalIngresos" => $totalIngresos                                                      
                              );  
                       }
                 }
                 else{                    
                     $totalIngresos=false;
                     $totalVentas=false;  
                     return  $return_arr[] =                          
                     array(
                      "totalVentas" => $totalVentas,
                      "totalIngresos" => $totalIngresos                                                      
                      );
                 }                                                                                          
        }

        public function procesarReporte2($nombreArchivoC)
        {
             $return_arr = array();	                               
             $totalIngresos="";
             $totalVentas="";
             $Efectivo="";    
             $exists = file_exists( $nombreArchivoC);
     
                 if($exists==true){                                        
                     $objPHPExcel=PHPEXCEL_IOFactory::load($nombreArchivoC);
                     $objPHPExcel->setActiveSheetIndex(0);
                     $numRows=$objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
     
                     for ($i=2; $i<=$numRows; $i++){
     
                        $tpv_2F=$objPHPExcel->getActiveSheet()->getCell('B'.$i)->getValue();
                        $tpv_5F=$objPHPExcel->getActiveSheet()->getCell('E'.$i)->getValue();								
                        $tpv_8F=$objPHPExcel->getActiveSheet()->getCell('H'.$i)->getValue();
                 
                             $totalVentas=$tpv_5F;                               
                             $totalIngresos=$tpv_8F;
                             $Efectivo=$tpv_2F;   
                             $totalVentas=str_replace("$","",$totalVentas);
                             $totalIngresos=str_replace("$","",$totalIngresos);
                             $Efectivo=str_replace("$","",$Efectivo);
                             $totalVentas=str_replace(",","",$totalVentas);
                             $totalIngresos=str_replace(",","",$totalIngresos);
                             $Efectivo=str_replace(",","",$Efectivo);                                                  
 
                       }
                       
                 }
                 else{                    
                    echo $totalIngresos=false;
                    echo $totalVentas=false;
                    echo $Efectivo=false;
                 }
     
             return  $return_arr[] =                          
                            array(
                             "totalVentas" => $totalVentas,
                             "totalIngresos" => $totalIngresos,
                             "Efectivo" => $Efectivo                            
                             );                                                                                         
        }
        
        public function store2()
        {
                #region VARIABLES INICIO DEL PROYECTO
                    $carpeta="";
                    $valoresCorte=array();
                    $usuario_id=$this->session->userdata("id");               
                    $plaza_id=$this->session->userdata("plaza");                
                    $fechaPost=$this->input->post("fecha");
										$tpv = floatval($this->input->post("tpv"));										                    
                    $fechaHoy=date('Y-m-d');

                    $diasT = $this->Mdl_opciones->getNumeroDias();
                    if($diasT != null){
                        $diasT = 30;
                    }else{
                        $diasT = 1;
                    }

                    $fechaLimiteMin = date('Y-m-d',strtotime("-".$diasT." days"));                    
                    
                    $gastos = $this->gastos($fechaPost,$plaza_id); 
                    if($gastos == null){
                        $gastos=0;
                    }

                    $gastosAdmin=$this->gastosAdmin($fechaPost,$plaza_id);                        
                    if($gastosAdmin == null){ $gastosAdmin=0;}            
        
                    $gastosAll=$this->gastosAll($fechaPost,$plaza_id);                        
                    if($gastosAll == null){ $gastosAll=0; }                    


                    $excel_file=$_FILES["excel_file"];                    
                    $nombreArchivo=trim(str_replace(" ","_", $_FILES['excel_file']['name']));                    
                    $nombreArchivoExtension=$_FILES['excel_file']['name'];  
                    
                    $finfo = finfo_open(FILEINFO_MIME_TYPE);                                        
                    $ext = pathinfo($nombreArchivoExtension, PATHINFO_EXTENSION);   
                    $name=pathinfo($nombreArchivoExtension, PATHINFO_FILENAME);                      
                    
                    if($ext=="xls" && strtotime($name)){
                        $nameMod=new DateTime($name);             
                        $nameMod=$nameMod->format('Y-m-d'); 
                    }                   
                  

                #endregion
                                            
                if($ext=="xls" && strtotime($name) && $nameMod==$fechaPost  && $fechaPost>=$fechaLimiteMin && $fechaPost<=$fechaHoy){   
                    

                    #region SELECCIONANDO LA PLAZA DE DESTINO                         
                        switch ($plaza_id) 
                        {
                            case 1: 
                            	$carpeta="CASITAS";                  
                                break;
                            case 2: 
                            	$carpeta="MATAMOROS";                  
                              break;
                            case 3: 
                            	$carpeta="OAXACA";                  
                              break;
                            case 4:
                            	$carpeta="POZA RICA";                  
                              break;
                            case 5: 
                              $carpeta="REYNOSA I";
                              break;
                            case 6: 
                            	$carpeta="REYNOSA II";                  
                              break;
                            case 7:
                              $carpeta="TEZIUTLAN";
                              break;    
                            default:                            
                        }
                    #endregion    
                        
                    #region CONFIGURACIÓN DE LAS VARIABLES PARA SUBIR EL ARHCIVO
                        $config["upload_path"]      = "./assets/files/".$carpeta;
                        $config["max_size"]         = 2048;
                        $config["allowed_types"]    = "*";
                        $config['overwrite'] = TRUE;                            
                        $this->load->library("upload",$config);
                    #endregion
                
                    #region ARREGLO CON LA FECHA Y LA CARPETA DE DESTINO                       
                    $nombreArchivo=FCPATH . 'assets/files/'.$carpeta."/".$nombreArchivo;
                    #endregion
                
                    #region SUBIENDO EL ARCHIVO Y GUARDANDO LOS DATOS A REGRESAR EN UNA VARIABLE
                        if(!$this->upload->do_upload('excel_file'))
                        {
                            //echo $this->upload->display_errors();
                        }
                        else
                        {                                                                        
                            $valoresCorte=  $this-> procesarReporte2($nombreArchivo);                             
                            unlink($nombreArchivo);                                              
                        } 
                    #endregion  
                   
                    #region APLICANDO LAS VALIDACIONES DEL FORMULARIO                       
                        $this->form_validation->set_rules("fecha","fecha","required");                        
                    #endregion

                    #region VALIDACIONES GENERALES DE INSERCIÓN A BD
                        if ($this->form_validation->run()) {
													if ($valoresCorte['totalVentas'] == false || $valoresCorte['totalIngresos'] == false) {
														$this->session->set_flashdata("error","No se encontro el archivo correspondiente a la fecha");                    
														redirect(base_url()."Ventas/add2");
													}
													else if ($valoresCorte['totalVentas'] == null || $valoresCorte['totalIngresos'] == null) {
															$this->session->set_flashdata("error","Archivo ilegible-dañado");                    
															redirect(base_url()."Ventas/add2");
													} 
													else {
															$totalVentas = $valoresCorte['totalVentas'];															
															$deposito = $totalVentas - $tpv;															
															$fechaSemana = new DateTime($fechaPost);             
															$fechaSemana = $fechaSemana->format('Y-m-d');  
															$efectivo_real = $valoresCorte['totalIngresos'] - $tpv - $gastos;
																											
															$data = array(
																			'usuario_id' => $usuario_id,
																			"plaza_id" => $plaza_id,
																			'Fecha' => $fechaPost,     
																			'Dia' => date('N', strtotime($fechaSemana)),
																			'Semana' =>  $this->getWeeks($fechaSemana,"sunday"),                       
																			'TPV' => $tpv,
																			'Gastos' => $gastos,     
																			'Gastos_Admin' => $gastosAdmin,
																			'Total_Gastos' => $gastosAll,                          
																			'Total_Ventas' => $totalVentas,
																			'Total_Ingresos' => $valoresCorte['totalIngresos'],
																			'Deposito' => $deposito,
																			'Efectivo_Real' => $efectivo_real                                
																		);

															$dataU = array('Enviado' => 1);

															
															if (!$this->Mdl_ventas->consultarFechaVenta($fechaPost,$plaza_id)) {
																	if ($this->Mdl_ventas->save($data,$dataU,$fechaPost,$plaza_id)) {                                      
																			$data = array('Corte' => 1);
																			if ($this->Mdl_ventas->actualizarTablaGastos($fechaPost,$plaza_id,$data)) {
																					$this->session->set_flashdata("message","Venta Registrada Correctamente");                                                    
																					redirect(base_url()."Ventas/add2");
																			}
																			else {
																					$this->session->set_flashdata("error","Error al guardar la información");                    
																					redirect(base_url()."Ventas/add2");    
																			}                                                                                                                     
																	}
																	else {
																		$this->session->set_flashdata("error","Error al guardar la información");                    
																		redirect(base_url()."Ventas/add2");
																	}
															}
															else {
																	$this->session->set_flashdata("error","Ya registro su archivo de corte del día, no se permiten dos reportes diarios");                    
																	redirect(base_url()."Ventas/add2");
															}                      
													}
                        }
												else {
                            $this->session->set_flashdata("error","No se cumplieron las reglas de validación del formulario");                                        
                            redirect(base_url()."Ventas/add2");
                        }
                    }
                    #endregion                    
                    else{
											$this->session->set_flashdata("error","Solo se permiten subir archivos de corte de un día anterior y del día actual. Verifique que las dos fechas coincidan y los archivos sean correctos");                    
											redirect(base_url()."Ventas/add2");
                    }                       
        }

        public function actualizarTPV(){
            if($this->input->is_ajax_request()){   
                $fecha=$this->input->post("fecha_deposito_tpv");  
                $TPV=$this->input->post("TPV");  
                $plaza_id=$this->input->post("plaza_id_TPV_deposito");
                
                //CENTINELA PARA VER SI LA MODIFICACIÓN AFECTARA LA TABLA DE DEPÓSITOS
                $banderaLiberacionDeposito=false;
                $banderaLiberacion=$this->Mdl_depositos->consultarLiberacion($fecha,$plaza_id);
                $banderaLiberacion=$banderaLiberacion->Bandera;
                
                if($banderaLiberacion==1){
                    $banderaLiberacionDeposito=true;
                }
                else if($banderaLiberacion==0){
                    $banderaLiberacionDeposito=false;
                }

                $totalIngresos=$this->Mdl_ventas->getTotalIngresos($fecha,$plaza_id);                
                $totalVentas=$this->Mdl_ventas->getTotalVentas($fecha,$plaza_id);
                $totalGastos=$this->Mdl_ventas->getTotalGastos($fecha,$plaza_id);
                
                $totalIngresos=$totalIngresos->Total;
                $totalVentas=$totalVentas->Total;
                $totalGastos=$totalGastos->Total;

                $gastosManager=$this->Mdl_remesas->getGastosVentas($fecha,$plaza_id); 
                $gastosManager=$gastosManager->Importe;


                $nuevoDeposito=$totalVentas-$TPV;
                $nuevoEfectivo=($totalIngresos-$gastosManager)-$TPV;
                $data=array('TPV' =>$TPV,"Deposito"=>$nuevoDeposito,"Efectivo_Real"=>$nuevoEfectivo);                
                $dataTablaDepositos=array('Cantidad' =>$nuevoDeposito);

                //SI YA FUE LIBERADO EL DEPÓSITO ENTONCES LO ACTUALIZO TAMBIÉN EN LA TABLA DE DEPÓSITOS
                if($banderaLiberacionDeposito==true)
                {
                    if($this->Mdl_ventas->actualizarTPVDeposito($fecha,$plaza_id,$data,$dataTablaDepositos)){
                        echo 1;                                                                                                                
                    }
                    else{                        
                        echo 0;                    
                    }
                }

                //SI EL DEPÓSITO NO HA SIDO LIBERADO SOLO ACTUALIZO LA TPV
                else if($banderaLiberacionDeposito==false)
                {
                    if($this->Mdl_ventas->actualizarTPV($fecha,$plaza_id,$data)){
                        echo 1;                        
                    }
                    else{                        
                        echo 0;                    
                    }
                }                               
            }   
            else{
                    redirect(base_url()."Inicio");
              }
        }

        //==Análisis del costo de venta
        //Debo de agregar el permiso
        public function tablaCostoVenta(){            
            $plaza_id=1;

            $ultimaFechaInventarioFisico=$this->Mdl_ventas->getUltimaFechaInventarioFisico($plaza_id)->Fecha;            
            $penultimaFechaInventarioFisico=$this->Mdl_ventas->getPenultimaFechaInventario($ultimaFechaInventarioFisico,$plaza_id)->Fecha;

            $data=$this->fnCostoVenta($penultimaFechaInventarioFisico,$plaza_id);
                        
            $this->load->view("layouts/header");
            $this->load->view("layouts/aside");
            $this->load->view("administrador/depositos/costo_venta",$data);
            $this->load->view("layouts/footer");           
        }

        public function tablaCostoVentaAjax(){
            if($this->input->is_ajax_request()){                        
                $fechaInicioBusqueda=$this->input->post('fechaInicioBusqueda');
                $plaza_id=$this->input->post('plaza_id');

                $data=$this->fnCostoVenta($fechaInicioBusqueda,$plaza_id);
                echo json_encode($data);            
            }   
            else{
                redirect(base_url()."Inicio");
            }	
        }

        public function fnCostoVenta($fechaBusqueda,$plaza_id){

            //Validacion para las fechas de busqueda :D
                $primeraFechaInventarioFisico=$this->Mdl_ventas->getPrimeraFechaInventarioFisico(1)->Fecha;
                $ultimaFechaInventarioFisico=$this->Mdl_ventas->getUltimaFechaInventarioFisico(1)->Fecha;            
                $penultimaFechaInventarioFisico=$this->Mdl_ventas->getPenultimaFechaInventario($ultimaFechaInventarioFisico,1)->Fecha;
                        
                if($fechaBusqueda>$ultimaFechaInventarioFisico || $fechaBusqueda>$penultimaFechaInventarioFisico ){                
                    $fechaBusqueda=$penultimaFechaInventarioFisico;                                                          
                }else if($fechaBusqueda<$primeraFechaInventarioFisico){                                
                    $fechaBusqueda=$primeraFechaInventarioFisico;                          
                } 
            //Validacion para las fechas de busqueda :D


            $plazas=$this->Mdl_plazas->getPlazas();
            $nombrePlaza=$this->Mdl_plazas->getNombrePlaza($plaza_id)->Nombre;
                       
            //Debemos traer los insumos
            //Debemos de traer los datos asociados al último inventario inicial y el final de la semana pasada
            $insumos=$this->Mdl_productos->getInsumosCostoVentaPedido();
            $insumosCompras=$this->Mdl_productos->getInsumosCostoVentaCompras();
            $arregloAnalisis=array();        


            //Primero vamos a consultar la fecha última de la cual tenemos registro en el inventario físico
            $ultimaFechaInventarioInicial=$this->Mdl_ventas->getUltimaFechaInventarioInicial($fechaBusqueda,$plaza_id)->Fecha;            
            $ultimaFechaInventarioFinal=$this->Mdl_ventas->getUltimaFechaInventarioFinal($ultimaFechaInventarioInicial,$plaza_id)->Fecha;            

            //===Fechas para análisis en base a lunes a domingo de la ultima fecha del inventario inicial
            $fechaLunes=$this->fechaLunes($fechaBusqueda);
            $fechaDomingo=$this->fechaDomingo($fechaBusqueda);


            //Vamos a consultar el total de ingresos            
            //ESTAMOS USANDO FECHA LUNES Y FECHA DOMINGO
            $sumaTotalIngresos=$this->Mdl_ventas->getSumaIngresos($fechaLunes,$fechaDomingo,$plaza_id)->Total;            
            if(empty($sumaTotalIngresos)){
                $sumaTotalIngresos=0;
            }

            //==CÁLCULO DEL COSTO DE VENTA PARA LOS PEDIDOS
            for ($i=0; $i <sizeof($insumos); $i++) { 
                $arregloAnalisis[$i]["id"]=$insumos[$i]->id;
                $arregloAnalisis[$i]["Nombre_Plaza"]=$nombrePlaza;
                $arregloAnalisis[$i]["Nombre"]=$insumos[$i]->Nombre;
                $arregloAnalisis[$i]["Costo_Venta"]=$insumos[$i]->Costo_Venta;                
                $arregloAnalisis[$i]["Fecha_Inicial"]=$ultimaFechaInventarioInicial;
                $arregloAnalisis[$i]["Fecha_Final"]=$ultimaFechaInventarioFinal;
                
                //Aquí vamos a traer los valores buscados por cada insumo del inventario inicial
                $valorInsumoInicial=$this->Mdl_ventas->getValorInsumoInventario($ultimaFechaInventarioInicial,$plaza_id,$insumos[$i]->id);                
                if($valorInsumoInicial!=null){
                    $valorInsumoInicial=$valorInsumoInicial->Total;
                    $arregloAnalisis[$i]["Valor_Fecha_Inicial"]=$valorInsumoInicial;
                    $arregloAnalisis[$i]["Valor_Calculado_Fecha_Inicial"]=$valorInsumoInicial*$insumos[$i]->Costo_Venta;
                }else{
                    $arregloAnalisis[$i]["Valor_Fecha_Inicial"]=0;
                    $arregloAnalisis[$i]["Valor_Calculado_Fecha_Inicial"]=0;
                }

                //Aquí vamos a traer los valores buscados por cada insumo del inventario final
                $valorInsumoFinal=$this->Mdl_ventas->getValorInsumoInventario($ultimaFechaInventarioFinal,$plaza_id,$insumos[$i]->id);                
                if($valorInsumoFinal!=null){
                    $valorInsumoFinal=$valorInsumoFinal->Total;
                    $arregloAnalisis[$i]["Valor_Fecha_Final"]=$valorInsumoFinal;
                    $arregloAnalisis[$i]["Valor_Calculado_Fecha_Final"]=$valorInsumoFinal*$insumos[$i]->Costo_Venta;                                    
                }else{
                    $arregloAnalisis[$i]["Valor_Fecha_Final"]=0;
                    $arregloAnalisis[$i]["Valor_Calculado_Fecha_Final"]=0;
                }      
                
                //Aquí vamos a comparar si en la semana en el rango de fechas hay un pedido para el insumo analizado
                //Aún falta si voy a esperar hasta que el pedido sea recibido o por simple que este cargado y recibido pues voy a digamos añadir preguntar a tio Vic
                //Estas tomando el valor convertido final para la multiplicación preguntar
                //ESTAMOS USANDO FECHA LUNES Y FECHA DOMINGO

                //==Aquí ya sabemos que estamos trayendo de pedidos y de pedidos pasteleria ahora solo debemos definir
                //==De donde vamos a traer la operación es decir si va a haber una conversión o no

                if($insumos[$i]->Pedido_Pasteleria==1 && $insumos[$i]->pedido==0){
                    $valorPedido=$this->Mdl_ventas->getValorPedidoPasteleriaInsumo($fechaLunes,$fechaDomingo,$plaza_id,$insumos[$i]->id);
                }else{
                    $valorPedido=$this->Mdl_ventas->getValorPedidoInsumo($fechaLunes,$fechaDomingo,$plaza_id,$insumos[$i]->id);
                }

                if($valorPedido!=null){
                    $valorPedido=$valorPedido->Cantidad_Recibida_Final;
                    $valorPedido=$this->conversorOperacionCVG($insumos[$i]->id,$valorPedido);
                    $arregloAnalisis[$i]["Valor_Pedido"]=$valorPedido;
                    $arregloAnalisis[$i]["Valor_Calculado_Pedido"]=$valorPedido*$insumos[$i]->Costo_Venta;
                }else{
                    $arregloAnalisis[$i]["Valor_Pedido"]=0;
                    $arregloAnalisis[$i]["Valor_Calculado_Pedido"]=0;                    
                }            
                
                //Sumatoria de gastos $ (Inv.Inicial+Compras-Inv.Final)
                $arregloAnalisis[$i]["Sumatoria_Gastos"]=(($arregloAnalisis[$i]["Valor_Calculado_Fecha_Inicial"]+$arregloAnalisis[$i]["Valor_Calculado_Pedido"])-$arregloAnalisis[$i]["Valor_Calculado_Fecha_Final"]);                                                                

                //Suma total de ingresos para calcular
                $arregloAnalisis[$i]["Sumatoria_Ingresos"]=$sumaTotalIngresos; 
                
                //Calculo de valor final
                $arregloAnalisis[$i]["Sumatoria_Final"]=($arregloAnalisis[$i]["Sumatoria_Gastos"]/$arregloAnalisis[$i]["Sumatoria_Ingresos"])*100;                 
            }

            //==CÁLCULO DEL COSTO DE VENTA PARA LOS GASTOS DE LA REMESA
            $j=sizeof($insumos);
            for ($i=0; $i <sizeof($insumosCompras); $i++) { 
                $arregloAnalisis[$j]["id"]=$insumosCompras[$i]->id;
                $arregloAnalisis[$j]["Nombre_Plaza"]=$nombrePlaza;
                $arregloAnalisis[$j]["Nombre"]=$insumosCompras[$i]->Nombre;
                
                $sumaImporteInsumo=$this->Mdl_productos->getPrecioPromedioInsumo($fechaLunes,$fechaDomingo,$plaza_id,$insumosCompras[$i]->id)->Importe;
                $sumaCantidadInsumo=$this->Mdl_productos->getPrecioPromedioInsumo($fechaLunes,$fechaDomingo,$plaza_id,$insumosCompras[$i]->id)->Cantidad;

                
                if($sumaImporteInsumo > 0 && $sumaCantidadInsumo > 0){
                    //$costoVenta=round($sumaImporteInsumo/$sumaCantidadInsumo,3);
                    $costoVenta=$sumaImporteInsumo/$sumaCantidadInsumo;
                    $arregloAnalisis[$j]["Costo_Venta"]=$costoVenta;                    
                }else{
                    //==Special Funcion not validate yet
                        //Aquí ya sabemos que no hubo compras de este insumo en esta semana
                        //Entonces vamos a tratar de comparar hace 15 días el precio
                        /* $fechaLunesDosSemanas=$this->fechaLunesDosSemanas($fechaBusqueda);
                        $fechaDomingoDosSemanas=$this->fechaDomingoDosSemanas($fechaBusqueda);

                        $sumaImporteInsumo=$this->Mdl_productos->getPrecioPromedioInsumo($fechaLunesDosSemanas,$fechaDomingoDosSemanas,$plaza_id,$insumosCompras[$i]->id)->Importe;
                        $sumaCantidadInsumo=$this->Mdl_productos->getPrecioPromedioInsumo($fechaLunesDosSemanas,$fechaDomingoDosSemanas,$plaza_id,$insumosCompras[$i]->id)->Cantidad;

                        if($sumaImporteInsumo > 0 && $sumaCantidadInsumo > 0){
                            $costoVenta=round($sumaImporteInsumo/$sumaCantidadInsumo,3);
                            $arregloAnalisis[$j]["Costo_Venta"]=$costoVenta;                    
                        }else{
                            $arregloAnalisis[$j]["Costo_Venta"]=0;
                            $costoVenta=0;
                        } */
                    //==Special Funcion not validate yet                                                            
                    $arregloAnalisis[$j]["Costo_Venta"]=0;
                    $costoVenta=0;
                }

                $arregloAnalisis[$j]["Fecha_Inicial"]=$ultimaFechaInventarioInicial;
                $arregloAnalisis[$j]["Fecha_Final"]=$ultimaFechaInventarioFinal;

                //Aquí vamos a traer los valores buscados por cada insumo del inventaro inicicial
                $valorInsumoInicial=$this->Mdl_ventas->getValorInsumoInventario($ultimaFechaInventarioInicial,$plaza_id,$insumosCompras[$i]->id);      
                if($valorInsumoInicial!=null){
                    $valorInsumoInicial=$valorInsumoInicial->Total;
                    //Aquí es en donde debemos de aplicar la operación de convertir a la operación indicada
                    $valorInsumoInicial=$this->conversorOperacionCVI($insumosCompras[$i]->id,$valorInsumoInicial); 
                    $arregloAnalisis[$j]["Valor_Fecha_Inicial"]=$valorInsumoInicial;                    
                    $arregloAnalisis[$j]["Valor_Calculado_Fecha_Inicial"]=$valorInsumoInicial*$costoVenta;
                }else{
                    $arregloAnalisis[$j]["Valor_Fecha_Inicial"]=0;
                    $arregloAnalisis[$j]["Valor_Calculado_Fecha_Inicial"]=0;
                }

                //Aquí vamos a traer los valores buscados por cada insumo del inventaro final
                $valorInsumoFinal=$this->Mdl_ventas->getValorInsumoInventario($ultimaFechaInventarioFinal,$plaza_id,$insumosCompras[$i]->id);                
                if($valorInsumoFinal!=null){
                    $valorInsumoFinal=$valorInsumoFinal->Total;
                    //Aquí es en donde debemos de aplicar la operación de convertir a la operación indicada
                    $valorInsumoFinal=$this->conversorOperacionCVI($insumosCompras[$i]->id,$valorInsumoFinal); 
                    $arregloAnalisis[$j]["Valor_Fecha_Final"]=$valorInsumoFinal;                    
                    $arregloAnalisis[$j]["Valor_Calculado_Fecha_Final"]=$valorInsumoFinal*$costoVenta;                                    
                }else{
                    $arregloAnalisis[$j]["Valor_Fecha_Final"]=0;
                    $arregloAnalisis[$j]["Valor_Calculado_Fecha_Final"]=0;
                }

                //Aquí vamos a comparar si en la semana en el rango de fechas hay un pedido para el insumo analizado
                //Aún falta si voy a esperar hasta que el pedido sea recibido o por simple que este cargado y recibido pues voy a digamos añadir preguntar a tio Vic
                //Estas tomando el valor convertido final para la multiplicación preguntar
                //ESTAMOS USANDO FECHA LUNES Y FECHA DOMINGO
                $cantidadGastos=$this->Mdl_productos->getPrecioPromedioInsumo($fechaLunes,$fechaDomingo,$plaza_id,$insumosCompras[$i]->id)->Cantidad;

                if($cantidadGastos!=null){
                    //$cantidadGastos=$cantidadGastos->Cantidad;                    
                    //Aquí es en donde debemos de aplicar la operación de convertir a la operación indicada
                    //$cantidadGastos=$this->conversorOperacionCVG($insumosCompras[$i]->id,$cantidadGastos);
                    $arregloAnalisis[$j]["Valor_Pedido"]=$cantidadGastos;
                    $arregloAnalisis[$j]["Valor_Calculado_Pedido"]=$cantidadGastos*$costoVenta;
                }else{
                    $arregloAnalisis[$j]["Valor_Pedido"]=0;
                    $arregloAnalisis[$j]["Valor_Calculado_Pedido"]=0;                    
                }    
                                                                    
                
                //Sumatoria de gastos $ (Inv.Inicial+Compras-Inv.Final)
                $arregloAnalisis[$j]["Sumatoria_Gastos"]=(($arregloAnalisis[$j]["Valor_Calculado_Fecha_Inicial"]+$arregloAnalisis[$j]["Valor_Calculado_Pedido"])-$arregloAnalisis[$j]["Valor_Calculado_Fecha_Final"]);
                                
                //Suma total de ingresos para calcular                                                           
                $arregloAnalisis[$j]["Sumatoria_Ingresos"]=$sumaTotalIngresos; 

                //Calculo de valor final
                $arregloAnalisis[$j]["Sumatoria_Final"]=($arregloAnalisis[$j]["Sumatoria_Gastos"]/$arregloAnalisis[$j]["Sumatoria_Ingresos"])*100;                
                $j++;
            }

            $data=array
            (
                'insumos' => $arregloAnalisis,                 
                "ultimaFechaInventarioInicial" => $ultimaFechaInventarioInicial,
                "ultimaFechaInventarioFinal" => $ultimaFechaInventarioFinal, 
                "fechaLunes"=>$fechaLunes,               
                "fechaDomingo"=>$fechaDomingo,
                "sumaTotalIngresos"=>$sumaTotalIngresos,
                "plazas"=>$plazas                                
            );

            return $data;            
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

        public function fechaLunesDosSemanas($date){                             
            $year = strtotime($date);
            $year= date("Y", $year);        
            $weeknumber=date("W", strtotime($date));
            if($weeknumber>1){
                $weeknumber=$weeknumber-1;
            }
            $gendate = new DateTime();
            $gendate->setISODate($year,$weeknumber,1); //year , week num , day
            return $gendate->format('Y-m-d');                
        }

        public function fechaDomingoDosSemanas($date){        
            $year = strtotime($date);
            $year= date("Y", $year);        
            $weeknumber=date("W", strtotime($date));
            if($weeknumber>1){
                $weeknumber=$weeknumber-1;
            }
            $gendate = new DateTime();
            $gendate->setISODate($year,$weeknumber,7); //year , week num , day
            return $gendate->format('Y-m-d');                
        }

        private function conversorOperacionCVI($insumo_id,$cantidad)
        {            
            $operacion=$this->Mdl_ventas->getOperacionCVI($insumo_id); 
            if($operacion!=false){            
                $valor= $operacion->CVI; 
                $myArray = explode(',', $valor);
                $tamaño=sizeof($myArray); 
    
                switch ($tamaño) {
                    case 2:
                        switch($myArray[0]){
                            case "*":
                                return $cantidad*$myArray[1];
                            break;
    
                            case "+":
                                return $cantidad+$myArray[1];
                            break;
    
                            case "-":
                                return $cantidad-$myArray[1];
                            break;
    
                            case "/":
                            return $cantidad/$myArray[1];
                            break;
                        } 
                    break;               
                }                                        
            }           
        }

        private function conversorOperacionCVG($insumo_id,$cantidad)
        {            
            $operacion=$this->Mdl_ventas->getOperacionCVG($insumo_id); 
            if($operacion!=false){            
                $valor= $operacion->CVG; 
                $myArray = explode(',', $valor);
                $tamaño=sizeof($myArray); 
    
                switch ($tamaño) {
                    case 2:
                        switch($myArray[0]){
                            case "*":
                                return $cantidad*$myArray[1];
                            break;
    
                            case "+":
                                return $cantidad+$myArray[1];
                            break;
    
                            case "-":
                                return $cantidad-$myArray[1];
                            break;
    
                            case "/":
                            return $cantidad/$myArray[1];
                            break;
                        } 
                    break;               
                }                                        
            }           
        }
                
}
