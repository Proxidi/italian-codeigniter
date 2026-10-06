<?php
 header("Content-Type: text/html; charset=utf-8");
defined('BASEPATH') OR exit('No direct script access allowed');
require './assets/Classes/PHPExcel/IOFactory.php';

class Depositos extends CI_Controller {

    private $permisos; 

    public function __construct()
    {
            parent::__construct();
            $this->permisos=$this->backend_lib->control();
            $this->load->model('Mdl_depositos');
            $this->load->model('Mdl_plazas');
            $this->load->model('Mdl_remesas');
            if(!$this->session->userdata("login")){
            redirect(base_url());
            }
    }


    public function pruebaMetodo()
    {
       
    }
    
    public function index()
    {      
        $fechainicio=$this->input->post("fechaInicioD");
        $fechafin=$this->input->post("fechaFinD");         
        $id_plaza=$this->input->post("plaza_idP");
        $id_grafico=$this->input->post("grafico_id");
        $plazas=$this->Mdl_plazas->getPlazas();
        //$tipos=$this->Mdl_plazas->getTiposGraficos();
        $tipos=$this->Mdl_plazas->getTipoGraficoID(1);        
        $grafico=0;
        $menu=0;
        $fechaConsulta=$fechainicio."<br>".$fechafin;
        $banderaDias=true;
        $weekday=0;
        $campo="";
        $acronimoCampo="";
        $busquedaPlaza=false;
        $nombrePlaza="";
        
        
        if($fechainicio!="" && $fechafin !=""){
            $date1=date_create($fechainicio);
            $date2=date_create($fechafin);
            $diff=date_diff($date1,$date2);
            $weekday= $diff->format("%R%a");
            if($weekday>31){                
                $banderaDias=false;   
            }else{                
                $banderaDias=true;
            }
        }


        if($id_grafico!=""){
            switch ($id_grafico) {
                case 1:                    
                    $campo="Total_Ingresos";
                    $acronimoCampo="Ingresos";
                break;
                
                case 2:                    
                $campo="Total_Ventas";
                $acronimoCampo="Ventas C";
                break;

                case 3:                    
                $campo="TPV";
                $acronimoCampo="TPV";
                break;

                case 4:                    
                $campo="Gastos";
                $acronimoCampo="Gastos";
                break;

                case 5:                    
                $campo="Deposito";
                $acronimoCampo="Depositos";
                break;

                case 6:
                $campo="Efectivo_Real"; 
                $acronimoCampo="Efectivo";
                break;
            
                default:                    
                $campo="Total_Ingresos";
                $acronimoCampo="Ingresos";
                break;
            }

        }else{
            $campo="Total_Ingresos";
            $acronimoCampo="Ingresos";
        }


        //VARIABLES DE INICIO Y ARREGLOS
            $graficoLineasCA="";
            $graficoLineasMA="";
            $graficoLineasOA="";
            $graficoLineasPZ="";
            $graficoLineasRI="";
            $graficoLineasRII="";
            $graficoLineasTZ="";
            $graficoPastelAll="";
            $graficoLineasGenerico="";
            $graficoPastelGenerico="";
            
            $valoresX=array();
            $valoresXCA=array();
            $valoresXMA=array();
            $valoresXOA=array();
            $valoresXPZ=array();
            $valoresXRI=array();
            $valoresXRII=array();
            $valoresXTZ=array();   
            $valoresXLineasGenerico=array();     
            $valoresXPastelGenerico=array();     

            $valoresY=array();
            $valoresYCA=array();
            $valoresYMA=array();
            $valoresYOA=array();
            $valoresYPZ=array();
            $valoresYRI=array();
            $valoresYRII=array();
            $valoresYTZ=array(); 
            $valoresYLineasGenerico=array();
            $valoresYPastelGenerico=array(); 
        //.VARIABLES DE INICIO Y ARREGLOS
        
            
        $fechaActual=date('Y-m-d',strtotime("-1 days"));
        $fechaInicioG=$fechaActual;
        $fechaFinG=$fechaActual;

        $reportes=$this->Mdl_depositos->getDepositosFecha($fechaActual,$fechaActual);
        $graficoPastelAll=$this->Mdl_depositos->getDepositosFechaGrafico($fechaActual,$fechaActual);

        $graficoLineasCA=$this->Mdl_depositos->getDepositosFechaGraficoPlazaDia($fechaActual,$fechaActual,1);
        $graficoLineasMA=$this->Mdl_depositos->getDepositosFechaGraficoPlazaDia($fechaActual,$fechaActual,2);
        $graficoLineasOA=$this->Mdl_depositos->getDepositosFechaGraficoPlazaDia($fechaActual,$fechaActual,3);

        $graficoLineasPZ=$this->Mdl_depositos->getDepositosFechaGraficoPlazaDia($fechaActual,$fechaActual,4);
        $graficoLineasRI=$this->Mdl_depositos->getDepositosFechaGraficoPlazaDia($fechaActual,$fechaActual,5);
        $graficoLineasRII=$this->Mdl_depositos->getDepositosFechaGraficoPlazaDia($fechaActual,$fechaActual,6);
        $graficoLineasTZ=$this->Mdl_depositos->getDepositosFechaGraficoPlazaDia($fechaActual,$fechaActual,7);

    
        if($id_plaza==""){
            if($this->input->post("buscar")){
                $busquedaPlaza=false;
                $reportes=$this->Mdl_depositos->getDepositosFecha($fechainicio,$fechainicio);

                $graficoPastelAll=$this->Mdl_depositos->getDepositosFechaGrafico2($fechainicio,$fechainicio,$campo);

                $graficoLineasCA=$this->Mdl_depositos->getDepositosFechaGraficoPlazaDia2($fechainicio,$fechainicio,1,$campo);   
                $graficoLineasMA=$this->Mdl_depositos->getDepositosFechaGraficoPlazaDia2($fechainicio,$fechainicio,2,$campo);   
                $graficoLineasOA=$this->Mdl_depositos->getDepositosFechaGraficoPlazaDia2($fechainicio,$fechainicio,3,$campo);   

                $graficoLineasPZ=$this->Mdl_depositos->getDepositosFechaGraficoPlazaDia2($fechainicio,$fechainicio,4,$campo);   
                $graficoLineasRI=$this->Mdl_depositos->getDepositosFechaGraficoPlazaDia2($fechainicio,$fechainicio,5,$campo);   
                $graficoLineasRII=$this->Mdl_depositos->getDepositosFechaGraficoPlazaDia2($fechainicio,$fechainicio,6,$campo);
                $graficoLineasTZ=$this->Mdl_depositos->getDepositosFechaGraficoPlazaDia2($fechainicio,$fechainicio,7,$campo);   

                $fechaInicioG=$fechainicio;                             
                $fechaFinG=$fechainicio;
                $fechafin="";
        }
        else if($this->input->post("buscarRango")){
            //getDepositosFechaGraficoPlazaDias  
            $busquedaPlaza=false;
            $reportes=$this->Mdl_depositos->getDepositosGeneralFecha($fechainicio,$fechafin);              
            $graficoPastelAll=$this->Mdl_depositos->getDepositosFechaGrafico2($fechainicio,$fechafin,$campo);             
           
            if($banderaDias==true){
                $graficoLineasCA=$this->Mdl_depositos->getDepositosFechaGraficoPlazaDias2($fechainicio,$fechafin,1,$campo);
                $graficoLineasMA=$this->Mdl_depositos->getDepositosFechaGraficoPlazaDias2($fechainicio,$fechafin,2,$campo); 
                $graficoLineasOA=$this->Mdl_depositos->getDepositosFechaGraficoPlazaDias2($fechainicio,$fechafin,3,$campo); 
                $graficoLineasPZ=$this->Mdl_depositos->getDepositosFechaGraficoPlazaDias2($fechainicio,$fechafin,4,$campo);
                $graficoLineasRI=$this->Mdl_depositos->getDepositosFechaGraficoPlazaDias2($fechainicio,$fechafin,5,$campo); 
                $graficoLineasRII=$this->Mdl_depositos->getDepositosFechaGraficoPlazaDias2($fechainicio,$fechafin,6,$campo); 
                $graficoLineasTZ=$this->Mdl_depositos->getDepositosFechaGraficoPlazaDias2($fechainicio,$fechafin,7,$campo); 
            }
            else{
                $graficoLineasCA=$this->Mdl_depositos->getDepositosFechaGraficoPlaza2($fechainicio,$fechafin,1,$campo);
                $graficoLineasMA=$this->Mdl_depositos->getDepositosFechaGraficoPlaza2($fechainicio,$fechafin,2,$campo); 
                $graficoLineasOA=$this->Mdl_depositos->getDepositosFechaGraficoPlaza2($fechainicio,$fechafin,3,$campo); 
                $graficoLineasPZ=$this->Mdl_depositos->getDepositosFechaGraficoPlaza2($fechainicio,$fechafin,4,$campo);
                $graficoLineasRI=$this->Mdl_depositos->getDepositosFechaGraficoPlaza2($fechainicio,$fechafin,5,$campo); 
                $graficoLineasRII=$this->Mdl_depositos->getDepositosFechaGraficoPlaza2($fechainicio,$fechafin,6,$campo); 
                $graficoLineasTZ=$this->Mdl_depositos->getDepositosFechaGraficoPlaza2($fechainicio,$fechafin,7,$campo); 
            }
            
            $fechaInicioG=$fechainicio;                             
            $fechaFinG=$fechafin;   
            $menu=1;            
        }
        else if($this->input->post("buscarRangoDesglose")){
            $busquedaPlaza=false;
            $reportes=$this->Mdl_depositos->getDepositosGeneralFechaDesglose($fechainicio,$fechafin); 
            $graficoPastelAll=$this->Mdl_depositos->getDepositosFechaGrafico2($fechainicio,$fechafin,$campo);
            
            if($banderaDias==true){
                $graficoLineasCA=$this->Mdl_depositos->getDepositosFechaGraficoPlazaDias2($fechainicio,$fechafin,1,$campo);   
                $graficoLineasMA=$this->Mdl_depositos->getDepositosFechaGraficoPlazaDias2($fechainicio,$fechafin,2,$campo);
                $graficoLineasOA=$this->Mdl_depositos->getDepositosFechaGraficoPlazaDias2($fechainicio,$fechafin,3,$campo);            
                $graficoLineasPZ=$this->Mdl_depositos->getDepositosFechaGraficoPlazaDias2($fechainicio,$fechafin,4,$campo);   
                $graficoLineasRI=$this->Mdl_depositos->getDepositosFechaGraficoPlazaDias2($fechainicio,$fechafin,5,$campo);
                $graficoLineasRII=$this->Mdl_depositos->getDepositosFechaGraficoPlazaDias2($fechainicio,$fechafin,6,$campo);
                $graficoLineasTZ=$this->Mdl_depositos->getDepositosFechaGraficoPlazaDias2($fechainicio,$fechafin,7,$campo);
            }
            else{
                $graficoLineasCA=$this->Mdl_depositos->getDepositosFechaGraficoPlaza2($fechainicio,$fechafin,1,$campo);   
                $graficoLineasMA=$this->Mdl_depositos->getDepositosFechaGraficoPlaza2($fechainicio,$fechafin,2,$campo);
                $graficoLineasOA=$this->Mdl_depositos->getDepositosFechaGraficoPlaza2($fechainicio,$fechafin,3,$campo);            
                $graficoLineasPZ=$this->Mdl_depositos->getDepositosFechaGraficoPlaza2($fechainicio,$fechafin,4,$campo);   
                $graficoLineasRI=$this->Mdl_depositos->getDepositosFechaGraficoPlaza2($fechainicio,$fechafin,5,$campo);
                $graficoLineasRII=$this->Mdl_depositos->getDepositosFechaGraficoPlaza2($fechainicio,$fechafin,6,$campo);
                $graficoLineasTZ=$this->Mdl_depositos->getDepositosFechaGraficoPlaza2($fechainicio,$fechafin,7,$campo);
            }

            $fechaInicioG=$fechainicio;                             
            $fechaFinG=$fechafin;
            $menu=0;
        }
        }else{

            $nombrePlaza=$this->Mdl_plazas->getPlazaID($id_plaza);
            $nombrePlaza=$nombrePlaza->nombrePlaza;
            if($this->input->post("buscar")){
                $busquedaPlaza=true;
                $reportes=$this->Mdl_depositos->getDepositosFechaPlaza($fechainicio,$fechainicio,$id_plaza);
                $fechafin="";
                
                $graficoPastelGenerico=$this->Mdl_depositos->getDepositosFechaGraficoPlaza22($fechainicio,$fechainicio,$id_plaza,$campo);
                $graficoLineasGenerico=$this->Mdl_depositos->getDepositosFechaGraficoPlazaDia2($fechainicio,$fechainicio,$id_plaza,$campo);   
                                
        }
        else if($this->input->post("buscarRango")){                        
            $busquedaPlaza=true;
            $reportes=$this->Mdl_depositos->getDepositosGeneralFechaPlaza($fechainicio,$fechafin,$id_plaza);
            $menu=1;
            
                                                                            
            $graficoPastelGenerico=$this->Mdl_depositos->getDepositosFechaGraficoPlaza22Meses($fechainicio,$fechafin,$id_plaza,$campo);
                
            
                     
            if($banderaDias==true){
                $graficoLineasGenerico=$this->Mdl_depositos->getDepositosFechaGraficoPlazaDias2($fechainicio,$fechafin,$id_plaza,$campo);
            }else{
                $graficoLineasGenerico=$this->Mdl_depositos->getDepositosFechaGraficoPlaza2($fechainicio,$fechafin,$id_plaza,$campo);
            }               
        }
        else if($this->input->post("buscarRangoDesglose")){
            $busquedaPlaza=true;
            $reportes=$this->Mdl_depositos->getDepositosGeneralFechaPlazaDesglose($fechainicio,$fechafin,$id_plaza);            
            $menu=0;

            $graficoPastelGenerico=$this->Mdl_depositos->getDepositosFechaGraficoPlaza22($fechainicio,$fechafin,$id_plaza,$campo);
            if($banderaDias==true){
                $graficoLineasGenerico=$this->Mdl_depositos->getDepositosFechaGraficoPlazaDias2($fechainicio,$fechafin,$id_plaza,$campo);
            }else{
                $graficoLineasGenerico=$this->Mdl_depositos->getDepositosFechaGraficoPlaza2($fechainicio,$fechafin,$id_plaza,$campo);
            }
        }
            foreach ($graficoLineasGenerico as $key) {                                                
                $valoresXLineasGenerico[]=$key->Nombre;                        
                $valoresYLineasGenerico[]=$key->Ingresos;            
            }    
            $datosXLineasGenerico=json_encode($valoresXLineasGenerico);
            $datosYLineasGenerico=json_encode($valoresYLineasGenerico);
            

            foreach ($graficoPastelGenerico as $key) {                                                
                $valoresXPastelGenerico[]=$key->Nombre;                        
                $valoresYPastelGenerico[]=round($key->Ingresos,2);            
            }    
            $datosXPastelGenerico=json_encode($valoresXPastelGenerico);
            $datosYPastelGenerico=json_encode($valoresYPastelGenerico);

            $fechaInicioG=$fechainicio;                             
            $fechaFinG=$fechafin;
        }
        
        

        foreach ($graficoLineasCA as $key) {                                                
            $valoresXCA[]=$key->Nombre;                        
            $valoresYCA[]=$key->Ingresos;            
        }
        
        $datosXCA=json_encode($valoresXCA);
        $datosYCA=json_encode($valoresYCA);

        foreach ($graficoLineasMA as $key) {                                                
            $valoresXMA[]=$key->Nombre;                        
            $valoresYMA[]=$key->Ingresos;            
        }
        
        $datosXMA=json_encode($valoresXMA);
        $datosYMA=json_encode($valoresYMA);
        
        foreach ($graficoLineasOA as $key) {                                                
            $valoresXOA[]=$key->Nombre;                        
            $valoresYOA[]=$key->Ingresos;            
        }
        
        $datosXOA=json_encode($valoresXOA);
        $datosYOA=json_encode($valoresYOA);


        foreach ($graficoLineasPZ as $key) {                                                
            $valoresXPZ[]=$key->Nombre;                        
            $valoresYPZ[]=$key->Ingresos;            
        }    
        $datosXPZ=json_encode($valoresXPZ);
        $datosYPZ=json_encode($valoresYPZ);

        foreach ($graficoLineasRI as $key) {                                                
            $valoresXRI[]=$key->Nombre;                        
            $valoresYRI[]=$key->Ingresos;            
        }    
        $datosXRI=json_encode($valoresXRI);
        $datosYRI=json_encode($valoresYRI);

        foreach ($graficoLineasRII as $key) {                                                
            $valoresXRII[]=$key->Nombre;                        
            $valoresYRII[]=$key->Ingresos;            
        }    
        $datosXRII=json_encode($valoresXRII);
        $datosYRII=json_encode($valoresYRII);

        foreach ($graficoLineasTZ as $key) {                                                
            $valoresXTZ[]=$key->Nombre;                        
            $valoresYTZ[]=$key->Ingresos;            
        }    
        $datosXTZ=json_encode($valoresXTZ);
        $datosYTZ=json_encode($valoresYTZ);

        foreach ($graficoPastelAll as $key) {                                                
            $valoresX[]=$key->Nombre;                        
            $valoresY[]=round($key->Ingresos,2);            
        }    
        $datosX=json_encode($valoresX);
        $datosY=json_encode($valoresY);


        if($busquedaPlaza==false){
            $data=array
            ('reportes'    => $reportes,
            'fechainicio'  => $fechainicio,
            'fechaFinG'    => $fechaFinG,
            'fechaInicioG' => $fechaInicioG,
            'fechafin'    => $fechafin,
            'plazas'      => $plazas,
            'tipos'       => $tipos,
            'menu'        => $menu,
            'id'          => $id_plaza,
            'id_grafico'  => $id_grafico,
            'fechaConsulta'=>$fechaConsulta,
            'datosX'=>$datosX,
            'datosY'=>$datosY,
            'datosXCA'=>$datosXCA,
            'datosYCA'=>$datosYCA,
            'datosXMA'=>$datosXMA,
            'datosYMA'=>$datosYMA,
            'datosXOA'=>$datosXOA,
            'datosYOA'=>$datosYOA,
            'datosXPZ'=>$datosXPZ,
            'datosYPZ'=>$datosYPZ,
            'datosXRI'=>$datosXRI,
            'datosYRI'=>$datosYRI,
            'datosXRII'=>$datosXRII,
            'datosYRII'=>$datosYRII,
            'datosXTZ'=>$datosXTZ,
            'datosYTZ'=>$datosYTZ,            
            'acronimoCampo'=>$acronimoCampo,
            'busquedaPlaza'=>$busquedaPlaza
        );
        }else{
            $data=array
            ('reportes'    => $reportes,
            'fechainicio'  => $fechainicio,
            'fechaFinG'    => $fechaFinG,
            'fechaInicioG' => $fechaInicioG,
            'fechafin'    => $fechafin,
            'plazas'      => $plazas,
            'tipos'       => $tipos,
            'menu'        => $menu,
            'id'          => $id_plaza,
            'id_grafico'  => $id_grafico,
            'fechaConsulta'=>$fechaConsulta,         
            'datosXLineasGenerico'=>$datosXLineasGenerico,
            'datosYLineasGenerico'=>$datosYLineasGenerico,
            'datosXPastelGenerico'=>$datosXPastelGenerico,
            'datosYPastelGenerico'=>$datosYPastelGenerico,
            'acronimoCampo'=>$acronimoCampo,
            'busquedaPlaza'=>$busquedaPlaza,
            'nombrePlaza'=>$nombrePlaza
        );
        

        }
        $this->load->view("layouts/header");
        $this->load->view("layouts/aside");
        $this->load->view("administrador/depositos/list",$data);
        $this->load->view("layouts/footer");          
    }

    public function analisisVentas()
    {
        $fechainicio=$this->input->post("fechaInicioD");
        $fechafin=$this->input->post("fechaFinD"); 
        $id_plaza=$this->input->post("plaza_id");
        $gasto_id=$this->input->post("gasto_id");
        $plazas=$this->Mdl_plazas->getPlazas();
        $grafico=0;
        $menu=0;
        $fechaConsulta=$fechainicio."<br>".$fechafin;

        
        $fechaActual=date('Y-m-d',strtotime("-1 days"));
        $reportes=$this->Mdl_depositos->getDepositosFecha($fechaActual,$fechaActual);        


        if($id_plaza==""){
            if($this->input->post("buscar")){
                $reportes=$this->Mdl_depositos->getDepositosFecha($fechainicio,$fechainicio);
                $fechafin="";
        }
        else if($this->input->post("buscarRango")){
            $reportes=$this->Mdl_depositos->getDepositosGeneralFechaAnalisis($fechainicio,$fechafin);            
            $menu=1;
            
        }
        else if($this->input->post("buscarRangoDesglose")){
            $reportes=$this->Mdl_depositos->getDepositosGeneralFechaDesgloseAnalisis($fechainicio,$fechafin);            
            $menu=0;
        }
        }else{
            if($this->input->post("buscar")){
                $reportes=$this->Mdl_depositos->getDepositosFechaPlaza($fechainicio,$fechainicio,$id_plaza);
                $fechafin="";
        }
        else if($this->input->post("buscarRango")){
            $reportes=$this->Mdl_depositos->getDepositosGeneralFechaPlazaAnalisis($fechainicio,$fechafin,$id_plaza);
            $menu=1;
        }
        else if($this->input->post("buscarRangoDesglose")){
            $reportes=$this->Mdl_depositos->getDepositosGeneralFechaDesglosePlazaAnalisis($fechainicio,$fechafin,$id_plaza);
            $menu=0;
        }

        }
        

        $data=array
            ('reportes'    => $reportes,
            'fechainicio' => $fechainicio,
            'fechafin'    => $fechafin,
            'plazas'      => $plazas,
            'menu'        => $menu,
            'id'          => $id_plaza,
            'id_gasto'=>$gasto_id,
            'fechaConsulta'=>$fechaConsulta            
        );

        $this->load->view("layouts/header");
        $this->load->view("layouts/aside");
        $this->load->view("administrador/depositos/analisis_ventas",$data);
        $this->load->view("layouts/footer");  
        
    }

    public function comparar()
    {        
        $fechainicio="";
        $fechafin=""; 
        $year="";
        
        $plaza_id=$this->input->post("plaza_id");
        $mes_id=$this->input->post("mes_id");
        $year_id=$this->input->post("year_id");
        
        if($year_id!=null){
            $year=$this->Mdl_plazas->getYearValue($year_id)->Nombre;
        }else{
            $year=date("Y");
            $year_id=$this->Mdl_plazas->getIdValue($year)->id;
        }
        
        if($year<=date("Y")){
            if($this->input->post("buscar")){            
                switch ($mes_id) 
                {
                    case 1:
                       $fechainicio=$year."-01-01";
                       $fechafin=$year."-01-31";
                    break;
        
                    case 2:
                        $fechainicio=$year."-02-01";
                        $fechafin=$year."-02-28";
                    break;
        
                    case 3:
                        $fechainicio=$year."-03-01";
                        $fechafin=$year."-03-31";
                    break;
        
                    case 4:
                        $fechainicio=$year."-04-01";
                        $fechafin=$year."-04-30";
                    break;
        
                    case 5:
                        $fechainicio=$year."-05-01";
                        $fechafin=$year."-05-31";
                    break;
        
                    case 6:
                        $fechainicio=$year."-06-01";
                        $fechafin=$year."-06-30";
                    break;
        
                    case 7:
                        $fechainicio=$year."-07-01";
                        $fechafin=$year."-07-31";
                    break;
        
                    case 8:
                        $fechainicio=$year."-08-01";
                        $fechafin=$year."-08-31";
                    break;
        
                    case 9:
                        $fechainicio=$year."-09-01";
                        $fechafin=$year."-09-30";
                    break;
        
                    case 10:
                        $fechainicio=$year."-10-01";
                        $fechafin=$year."-10-31";
                    break;
        
                    case 11:
                        $fechainicio=$year."-11-01";
                        $fechafin=$year."-11-30";
                    break;
        
                    case 12:
                        $fechainicio=$year."-12-01";
                            $fechafin=$year."-12-31";
                    break;           
                }
                if($plaza_id==""){
                    $reportes=$this->Mdl_depositos->compararDepositos($fechainicio,$fechafin);
                }
                else{
                    $reportes=$this->Mdl_depositos->compararDepositosPlaza($fechainicio,$fechafin,$plaza_id); 
                }
                
            }
            else{
                $fechainicio=date("Y-m")."-01";
                $fechafin=date("Y-m")."-31";
                $reportes=$this->Mdl_depositos->compararDepositos($fechainicio,$fechafin); 
            }
           
            $plazas=$this->Mdl_plazas->getPlazas();
            $meses=$this->Mdl_plazas->getMeses();
            $years=$this->Mdl_plazas->getYears();
        
            $data=array
                ('reportes'    => $reportes,
                'fechainicio' => $fechainicio,
                'fechafin'    => $fechafin,
                'plazas'      => $plazas,
                'id'          => $plaza_id,
                'meses'       => $meses,
                'years'       => $years,
                'mes_id'      => $mes_id,
                'year_id'     => $year_id
            );
                
            $this->load->view("layouts/header");
            $this->load->view("layouts/aside");
            $this->load->view("administrador/depositos/comparar",$data);
            $this->load->view("layouts/footer");
            
        }else{
            $this->session->set_flashdata("error","El año seleccionado es mayor al actual");                    
            redirect(base_url()."Depositos/comparar");
        }
    }

    public function panel()
    {
        $this->load->view("layouts/header");
        $this->load->view("layouts/aside");
        $this->load->view("administrador/depositos/panel_depositos");
        $this->load->view("layouts/footer"); 
    }
    
    public function tickets()
    {

      
        $fechainicio=$this->input->post("fechaInicioD");
        $fechafin=$this->input->post("fechaFinD"); 
        $id_plaza=$this->input->post("plaza_idP");
        $plazas=$this->Mdl_plazas->getPlazas();
        $grafico=0;
        $desglose=0;

        $fechaActual=date('Y-m-d',strtotime("-1 days"));
        $tickets=$this->Mdl_depositos->getTickets($fechaActual,$fechaActual,$id_plaza);


        if($id_plaza==""){
            if($this->input->post("buscar")){
                $tickets=$this->Mdl_depositos->getTickets($fechainicio,$fechainicio);
                $fechafin="";
                $data=array
                ('tickets'    => $tickets,
                'fechainicio' => $fechainicio,
                'fechafin'    => $fechafin,
                'plazas'      => $plazas,                
                'id'          => $id_plaza  );
        }
        else if($this->input->post("buscarRango")){
            $tickets=$this->Mdl_depositos->getTicketsRango($fechainicio,$fechafin);  
            $data=array
            ('tickets'    => $tickets,
            'fechainicio' => $fechainicio,
            'fechafin'    => $fechafin,
            'plazas'      => $plazas,            
            'id'          => $id_plaza,
            'fechaConsulta' => $fechainicio."<br>".$fechafin,
            'desglose' => 1
            );                      
        }
        else if($this->input->post("buscarRangoDesglose"))
        {
            $tickets=$this->Mdl_depositos->getTicketsRangoDesglose($fechainicio,$fechafin);  
            $data=array
            ('tickets'    => $tickets,
            'fechainicio' => $fechainicio,
            'fechafin'    => $fechafin,
            'plazas'      => $plazas,            
            'id'          => $id_plaza,
            
            'desglose' => 0
            );   
        }
        else{
            $data=array
            ('tickets'    => $tickets,
            'fechainicio' => $fechainicio,
            'fechafin'    => $fechafin,
            'plazas'      => $plazas,        
            'id'          => $id_plaza,
            'fechaConsulta' =>$fechaActual
            );
        }
        }else{
            if($this->input->post("buscar")){
                $tickets=$this->Mdl_depositos->getTicketsPlaza($fechainicio,$fechainicio,$id_plaza);
                $fechafin="";
                $data=array
                ('tickets'    => $tickets,
                'fechainicio' => $fechainicio,
                'fechafin'    => $fechafin,
                'plazas'      => $plazas,        
                'id'          => $id_plaza,
                'fechaConsulta' =>$fechaActual
                );
                
        }
        else if($this->input->post("buscarRango")){
            $tickets=$this->Mdl_depositos->getTicketsPlazaRango($fechainicio,$fechafin,$id_plaza);     
            $data=array
                ('tickets'    => $tickets,
                'fechainicio' => $fechainicio,
                'fechafin'    => $fechafin,
                'plazas'      => $plazas,        
                'id'          => $id_plaza,
                'fechaConsulta' =>$fechaActual
                );       
        }
        else if($this->input->post("buscarRangoDesglose")){
            $tickets=$this->Mdl_depositos->getTicketsPlazaRangoDesglose($fechainicio,$fechafin,$id_plaza);     
            $data=array
                ('tickets'    => $tickets,
                'fechainicio' => $fechainicio,
                'fechafin'    => $fechafin,
                'plazas'      => $plazas,        
                'id'          => $id_plaza,
                'fechaConsulta' =>$fechaActual
                );   
        }

        }

        $this->load->view("layouts/header");
        $this->load->view("layouts/aside");
        $this->load->view("administrador/tickets/list",$data);
        $this->load->view("layouts/footer");
    }
 
    public function liberarDeposito(){        
        $fecha=$this->input->post("fecha");                            
        $plaza_id=$this->input->post("plaza_id");         
        $hoy=date("Y-m-d");
        $tabla_id=1;
        //$plaza_id=1; 
        //$hoy=date('Y-m-d',strtotime("+1 days"));
        //$plaza_id=$this->input->post("plaza_id"); 
        //$fecha='2019-03-06';                    
                    
        $deposito=$this->Mdl_depositos->getDeposito($fecha,$plaza_id);
        $valorDeposito=$deposito->Deposito;        
        $data=array("Bandera" => 1);
        $banderaLiberacion=$this->Mdl_depositos->consultarLiberacion($fecha,$plaza_id);
        $banderaLiberacion=$banderaLiberacion->Bandera;
        $banderaFolio=false;
        $folioInicial=1;
            while(!$banderaFolio){                  
                $folioConsultado=$this->Mdl_depositos->consultarDisponibilidadFolio($hoy,$plaza_id,$folioInicial,$tabla_id);                
                if($folioConsultado==true){
                    $banderaFolio=true;
                }else{
                    $folioInicial++;
                }
            }
        if($banderaLiberacion==0){
            if($this->Mdl_depositos->actualizarDeposito($fecha,$hoy,$plaza_id,$data,$valorDeposito,$folioInicial)){
                //echo "Actualizado";
                echo 1;
            }        
            else{
                //echo "No actualizado";
                echo 0;
            }
        }
        else{
            //echo "El depósito ya fue liberado";
            echo 2;
        } 
    }

    public function desliberarDeposito(){        
        $fecha=$this->input->post("fecha");            
        $plaza_id=$this->input->post("plaza_id"); 
        $tabla_id=1;
        $hoy=date("Y-m-d");
        //$fecha='2019-03-05';        
        //$plaza_id=1;

        $deposito=$this->Mdl_depositos->getDeposito($fecha,$plaza_id);
        $valorDeposito=$deposito->Deposito;        
        $data=array("Bandera" => 0);

        $banderaLiberacion=$this->Mdl_depositos->consultarLiberacion($fecha,$plaza_id);
        $banderaLiberacion=$banderaLiberacion->Bandera;
            
        if($banderaLiberacion==1){
         $checarDatos=$this->Mdl_depositos->consultarFolio($fecha,$plaza_id,$valorDeposito,$tabla_id); 
         if($checarDatos!=null){
                $folioConsultado=$checarDatos->Folio;
                $fechaConsultada=$checarDatos->Fecha;                                   
                if($fechaConsultada==date("Y-m-d")){
                    $resultado=$this->Mdl_depositos->contarElementos($hoy,$plaza_id,$tabla_id);                  
                    $resultado=$resultado->Total;
                    if($resultado>0){
                        if($folioConsultado<$resultado){
                            //ELIMINANDO EL FOLIO
                            //echo $this->Mdl_depositos->desactualizarDeposito($fecha,date("Y-m-d"),$plaza_id,$data,$valorDeposito);
                            if($this->Mdl_depositos->desactualizarDeposito($fecha,$hoy,$plaza_id,$data,$valorDeposito)){
                                $obtenerValores=$this->Mdl_depositos->obtenerColumna($hoy,$plaza_id,$tabla_id);                  
                                $i=1;
                                foreach ($obtenerValores as $key) {
                                    $this->Mdl_depositos->actualizarFolio($key->id,$plaza_id,$i);
                                    $i++;
                                }
                                //echo "Actualize todo correctamente";
                                echo 1;
                                //RETORNAMOS UN VERDADERO 
                            }        
                            else{
                                //echo "El deposito no se pudo eliminar";
                                echo 0;
                                //EL DEPOSITO NO SE PUDO ELIMINAR
                            }                                               
                        }else if($folioConsultado==$resultado){
                            if($this->Mdl_depositos->desactualizarDeposito($fecha,$hoy,$plaza_id,$data,$valorDeposito)){
                                //SE OMITE LA REALIZACIÓN DE FOLIOS CUANDO SOLO EXISTE UN ELEMENTO
                                //echo "Actualize todo correctamente FOLIOS IGUALES";
                                echo 1;
                                //RETORNAMOS UN VERDADERO 
                            }        
                            else{
                                echo 0;
                                //echo "El deposito no se pudo eliminar FOLIOS IGUALES";
                                //EL DEPOSITO NO SE PUDO ELIMINAR
                            }
                            //echo  $folioConsultado."--".$resultado;//"Folio consultado es menor al resultado";
                        }
                    }
                    else{
                        //echo "No hay elementos por lo tanto no hay reasignación de folios";
                        echo 0;
                        //NO HAY ELEMENTOS POR TANTO NO SE REASIGNAN FOLIOS
                    }
                    
                }
                else{
                    //echo "El deposito a eliminar no fue realizado hoy";
                    echo 2;
                    //EL DEPÓSITO QUE SE PRETENDE ELIMINAR NO FUE REALIZADO HOY
                }
         }else{
             //echo "No existe un folio asociado a este registro";
             echo 0;
             //POR X O Y NO HAY UN FOLIO ASIGNADO PARA ESTE REGISTRO SUS DATOS SON NULOS
         }                          
            }
            else{
                //echo "Deposito aún no liberado";
                echo 3;
                //DEPOSITO AÚN NO LIBERADO NO SE PUEDE DESLIBERAR
            }  
         //FIN DEL MÉTODO   
    }


    public function liberarDepositos(){

       /* $fechainicio=$this->input->post("fechaInicioD");
        $fechafin=$this->input->post("fechaFinD"); 
        $id_plaza=$this->input->post("plaza_idP");


        $plazas=$this->Mdl_plazas->getPlazas();
        $grafico=0;
        $menu=0;
        $fechaConsulta=$fechainicio."<br>".$fechafin;

        
        $fechaActual=date('Y-m-d',strtotime("-1 days"));
        $reportes=$this->Mdl_depositos->getDepositosFecha($fechaActual,$fechaActual);


        if($id_plaza==""){
            if($this->input->post("buscar")){
                $reportes=$this->Mdl_depositos->getDepositosFecha($fechainicio,$fechainicio);
                $fechafin="";
        }        
        else if($this->input->post("buscarRangoDesglose")){
            $reportes=$this->Mdl_depositos->getDepositosGeneralFechaDesglose($fechainicio,$fechafin);            
            $menu=0;
        }
        }else{
            if($this->input->post("buscar")){
                $reportes=$this->Mdl_depositos->getDepositosFechaPlaza($fechainicio,$fechainicio,$id_plaza);
                $fechafin="";
        }        
        else if($this->input->post("buscarRangoDesglose")){
            $reportes=$this->Mdl_depositos->getDepositosGeneralFechaPlazaDesglose($fechainicio,$fechafin,$id_plaza);
            $menu=0;
        }

        }
        
        $data=array
            ('reportes'    => $reportes,
            'fechainicio' => $fechainicio,
            'fechafin'    => $fechafin,
            'plazas'      => $plazas,
            'menu'        => $menu,
            'id'          => $id_plaza,
            'fechaConsulta'=>$fechaConsulta
        );

        $this->load->view("layouts/header");
        $this->load->view("layouts/aside");
        $this->load->view("administrador/depositos/liberar_depositos",$data);
        $this->load->view("layouts/footer");  */

        $fechainicio=$this->input->get("fechaInicioD");
        $fechafin=$this->input->get("fechaFinD"); 
        $id_plaza=$this->input->get("plaza_idP");


        $plazas=$this->Mdl_plazas->getPlazas();
        $grafico=0;
        $menu=0;
        $fechaConsulta=$fechainicio."<br>".$fechafin;

        
        $fechaActual=date('Y-m-d',strtotime("-1 days"));
        $reportes=$this->Mdl_depositos->getDepositosFecha($fechaActual,$fechaActual);


        if($id_plaza==""){
            if($this->input->get("buscar")){
                $reportes=$this->Mdl_depositos->getDepositosFecha($fechainicio,$fechainicio);
                $fechafin="";
        }        
        else if($this->input->get("buscarRangoDesglose")){
            $reportes=$this->Mdl_depositos->getDepositosGeneralFechaDesglose($fechainicio,$fechafin);            
            $menu=0;
        }
        }else{
            if($this->input->get("buscar")){
                $reportes=$this->Mdl_depositos->getDepositosFechaPlaza($fechainicio,$fechainicio,$id_plaza);
                $fechafin="";
        }        
        else if($this->input->get("buscarRangoDesglose")){
            $reportes=$this->Mdl_depositos->getDepositosGeneralFechaPlazaDesglose($fechainicio,$fechafin,$id_plaza);
            $menu=0;
        }

        }
        
        $data=array
            ('reportes'    => $reportes,
            'fechainicio' => $fechainicio,
            'fechafin'    => $fechafin,
            'plazas'      => $plazas,
            'menu'        => $menu,
            'id'          => $id_plaza,
            'fechaConsulta'=>$fechaConsulta
        );

        $this->load->view("layouts/header");
        $this->load->view("layouts/aside");
        $this->load->view("administrador/depositos/liberar_depositos2",$data);
        $this->load->view("layouts/footer");  
    }
    
    public function tablaDepositos(){        

        $fechainicio=$this->input->get("fechaInicioD");
        $fechafin=$this->input->get("fechaFinD"); 
        
        //TODO check for remove (plaza_id not used)
        $plaza_id=$this->input->get("plaza_id");      
        $tabla_id=$this->input->get("tabla_id");  

        //TODO check for remove (plazas not used)
        $plazas=$this->Mdl_plazas->getPlazas();      

        $menu=0;
        $fechaConsulta=$fechainicio."<br>".$fechafin;
        $nombreTabla=$this->Mdl_depositos->getNombreTabla($tabla_id);
        
        if($nombreTabla!=null){
            $nombreTabla=$nombreTabla->Nombre;
        }
        
        $unaSemana=date('Y-m-d',strtotime("-7 days"));        
        $tresSemanas=date('Y-m-d',strtotime("-21 days"));

        //TODO check for remove (reportes not used)
        $reportes=$this->Mdl_depositos->getDepositosTabla();        
        $tablaDepositos=$this->Mdl_depositos->getTablaDepositos2(1,$unaSemana);
        $nombresTablas=$this->Mdl_depositos->getNombresTablas();
        $cajaChica=$this->Mdl_depositos->getTablaDepositosCajaChica2(7);
        $tipoTabla=1;

            switch ($tabla_id) {    
                // Fiscal
                case 1:
                    if($this->input->get("buscar")){                        
                        if($fechainicio != ""){
                            $tablaDepositos=$this->Mdl_depositos->getTablaDepositos2(1,$fechainicio);
                            $fechafin=date("Y-m-d");
                        }
                        else{
                            $tablaDepositos=$this->Mdl_depositos->getTablaDepositos2(1,$unaSemana);
                        }  
                        
                    }                    
                    else if($this->input->get("buscarRangoDesglose")){
                        $tablaDepositos=$this->Mdl_depositos->getTablaDepositosFechaRangoDesglose2(1,$fechainicio,$fechafin);                        
                    }
                    else{
                        $tablaDepositos=$this->Mdl_depositos->getTablaDepositos2(1,$unaSemana);
                    }                    
                    $tipoTabla=1;
                break;

                // Don Toño (1 Plaza)
                case 2:
                    $plaza_id_TZ = 7; // Teziutlán

                    if($this->input->get("buscar")){
                        if($fechainicio!=""){
                            $tablaDepositos=$this->Mdl_depositos->getTablaDepositosPorPlaza(2,$fechainicio,$plaza_id_TZ);
                            $fechafin=date("Y-m-d");  
                        }
                        else{
                            $tablaDepositos=$this->Mdl_depositos->getTablaDepositosPorPlaza(2,$tresSemanas,$plaza_id_TZ);
                        }
                    }
                    else if($this->input->get("buscarRangoDesglose")){
                        $tablaDepositos=$this->Mdl_depositos->getTablaDepositosFechaRangoDesglosePorPlaza(2,$fechainicio,$fechafin,$plaza_id_TZ);                        
                    }
                    else{                        
                        $tablaDepositos=$this->Mdl_depositos->getTablaDepositosPorPlaza(2,$tresSemanas,$plaza_id_TZ);
                    }                 
                    $tipoTabla=2;
                break;
                
                // Pedro (2 Plazas)
                case 3:

                    $plaza_id_MA = 2;
                    $plaza_id_R1 = 5;

                    $grupoPlazas = [$plaza_id_MA,$plaza_id_R1];

                    if($this->input->get("buscar")){
                        if($fechainicio!=""){
                            $tablaDepositos=$this->Mdl_depositos->getTablaDepositosPorGrupoPlazas(3,$fechainicio,$grupoPlazas);
                            $fechafin=date("Y-m-d");
                        }
                        else{
                            $tablaDepositos=$this->Mdl_depositos->getTablaDepositosPorGrupoPlazas(3,$tresSemanas,$grupoPlazas);
                        }   
                        
                    }                    
                    else if($this->input->get("buscarRangoDesglose")){
                        $tablaDepositos=$this->Mdl_depositos->getTablaDepositosFechaRangoDesglosePorGrupoPlazas(3,$fechainicio,$fechafin, $grupoPlazas);                        
                    }
                    else{                        
                        $tablaDepositos=$this->Mdl_depositos->getTablaDepositosPorGrupoPlazas(3,$tresSemanas,$grupoPlazas);
                    }                                          
                    $tipoTabla=3;
                break;
                
                // Pepe (1 Plaza)
                case 4:

                    $plaza_id_R2 = 6; // Reynosa 2

                    if($this->input->get("buscar")){
                        if($fechainicio!=""){
                            $tablaDepositos = $this->Mdl_depositos->getTablaDepositosPorPlaza(4,$fechainicio,$plaza_id_R2);
                            $fechafin = date("Y-m-d");  
                        }
                        else{
                            $tablaDepositos = $this->Mdl_depositos->getTablaDepositosPorPlaza(4,$tresSemanas, $plaza_id_R2);
                        }                                                 
                    }                    
                    else if($this->input->get("buscarRangoDesglose")){
                        $tablaDepositos = $this->Mdl_depositos->getTablaDepositosFechaRangoDesglosePorPlaza(4,$fechainicio,$fechafin,$plaza_id_R2);                        
                    }
                    else{                        
                        $tablaDepositos = $this->Mdl_depositos->getTablaDepositosPorPlaza(4,$tresSemanas, $plaza_id_R2);
                    }                     
                    $tipoTabla = 4;
                break;
                    
                // Vic (3 Plazas)
                case 5:

                    $plaza_id_CA = 1; // Casitas
                    $plaza_id_PZ = 4; // Poza Rica
                    $plaza_id_OA = 3; // Oaxaca

                    $grupoPlazas = [$plaza_id_CA,$plaza_id_PZ,$plaza_id_OA];

                    if($this->input->get("buscar")) {                        
                        if($fechainicio != ""){
                            $tablaDepositos = $this->Mdl_depositos->getTablaDepositosPorGrupoPlazas(5,$fechainicio,$grupoPlazas);
                            $fechafin = date("Y-m-d");
                        }
                        else{
                            $tablaDepositos = $this->Mdl_depositos->getTablaDepositosPorGrupoPlazas(5,$tresSemanas,$grupoPlazas);
                        }                          
                    } 
                    else if($this->input->get("buscarRangoDesglose")) {
                        $tablaDepositos = $this->Mdl_depositos->getTablaDepositosFechaRangoDesglosePorGrupoPlazas(5,$fechainicio,$fechafin,$grupoPlazas);
                    } 
                    else{                        
                        $tablaDepositos = $this->Mdl_depositos->getTablaDepositosPorGrupoPlazas(5,$tresSemanas,$grupoPlazas);
                    }
                    
                    $tipoTabla = 5;
                break;
                
                // MA.Teresa
                case 6:

                    $plaza_id_MA = 2; // Matamoros
                    $plaza_id_R1 = 5; // Reynosa 1
                    $plaza_id_R2 = 6; // Reynosa 2

                    $grupoPlazas = [$plaza_id_MA,$plaza_id_R1,$plaza_id_R2];

                    if($this->input->get("buscar")){
                        if($fechainicio!=""){
                            $tablaDepositos=$this->Mdl_depositos->getTablaDepositosPorGrupoPlazas(6,$fechainicio,$grupoPlazas);
                            $fechafin=date("Y-m-d");  
                        }
                        else{
                            $tablaDepositos=$this->Mdl_depositos->getTablaDepositosPorGrupoPlazas(6,$tresSemanas,$grupoPlazas);
                        }                        
                    }                    
                    else if($this->input->get("buscarRangoDesglose")){
                        $tablaDepositos=$this->Mdl_depositos->getTablaDepositosFechaRangoDesglosePorGrupoPlazas(6,$fechainicio,$fechafin,$grupoPlazas);                        
                    }
                    else{                        
                        $tablaDepositos=$this->Mdl_depositos->getTablaDepositosPorGrupoPlazas(6,$tresSemanas,$grupoPlazas);
                    }                    
                    $tipoTabla=6;
                break;
                    
                // Caja chica
                case 7:
                    $tablaDepositos=$this->Mdl_depositos->getTablaDepositosCajaChica2(7);
                    $tipoTabla=7;
                break;
                
                default:       
                    $tablaDepositos=$this->Mdl_depositos->getTablaDepositos2(1,$unaSemana);         
                    $tipoTabla=1;
                break;
            }
        
             
        $data=array
            ('reportes'    => $reportes,
            'fechainicio' => $fechainicio,
            'fechafin'    => $fechafin,
            'plazas'      => $plazas,
            'menu'        => $menu,
            'id_plaza'    => $plaza_id,
            'id_tabla'    =>$tabla_id,
            'fechaConsulta'=>$fechaConsulta,
            'tablaDepositos'=>$tablaDepositos,
            'fecha_nueva_linea'=>date("Y-m-d"),
            'nombresTablas'=>$nombresTablas,
            'cajaChica'=>$cajaChica,
            'tipoTabla'=>$tipoTabla,
            'nombreTabla'=>$nombreTabla
            );

        $this->load->view("layouts/header");
        $this->load->view("layouts/aside");
        $this->load->view("administrador/depositos/tabla_depositos",$data);
        $this->load->view("layouts/footer");  
    }


    //=====Métodos usados en la tabla de depósitos=====//
        //Guardar datos en la tabla de depósitos
        public function storeTablaDepositos(){
            if($this->input->is_ajax_request()){

            $CA=$this->input->post("CA");
            $MA=$this->input->post("MA");
            $OA=$this->input->post("OA");
            $PZ=$this->input->post("PZ");
            $R1=$this->input->post("R1");
            $R2=$this->input->post("R2");
            $TZ=$this->input->post("TZ");

            if($CA==null){$CA=0;}
            if($MA==null){$MA=0;}
            if($OA==null){$OA=0;}
            if($PZ==null){$PZ=0;}
            if($R1==null){$R1=0;}
            if($R2==null){$R2=0;}
            if($TZ==null){$TZ=0;}
            
            $fecha=$this->input->post("fecha_nueva_linea"); 
            $tabla_id=$this->input->post("tabla_id_formulario"); 
            $limite=0;

                switch ($tabla_id) {                
                    //DON TOÑO
                    case 2:
                        $limite=1;                                      
                        $banderaFolio=false;
                        $folioInicial=1;
                        $plaza_id=7;
                        
                        while(!$banderaFolio){                  
                            $folioConsultado=$this->Mdl_depositos->consultarDisponibilidadFolio($fecha,$plaza_id,$folioInicial,$tabla_id);                
                            if($folioConsultado==true){
                                $banderaFolio=true;
                            }else{
                                $folioInicial++;
                            }
                        }

                        $data=
                        array(
                                'Fecha_Tabla'=>$fecha,
                                'Fecha'=>$fecha,
                                'tabla_id' =>$tabla_id,
                                "plaza_id"=>7,
                                'Cantidad'=>$TZ,
                                "Folio"=>$folioInicial                            
                            );

                            if($this->Mdl_depositos->insertarDeposito2($data)){
                                echo 1;
                            }
                            else{
                                echo 0;
                            }                        
                    break;
                    //PEDRO
                    case 3:
                        $banderaFolio = false;
                        $folioInicial = 1;

                        $plaza_id_MA = 2; // Matamoros
                        $plaza_id_R1 = 5; // Reynosa 1
                        
                        
                        while(!$banderaFolio){          
                            // Verificando si el folio no esta ya ocupado entonces lo ocupamos
                            // Sino incrementamos el contador para crear un folio libre        
                            $folioConsultado_MA = $this->Mdl_depositos->consultarDisponibilidadFolio($fecha,$plaza_id_MA,$folioInicial,$tabla_id);                
                            $folioConsultado_R1 = $this->Mdl_depositos->consultarDisponibilidadFolio($fecha,$plaza_id_R1,$folioInicial,$tabla_id);                
                           
                            if($folioConsultado_MA == true && $folioConsultado_R1 == true){
                                $banderaFolio = true;
                            }else{
                                $folioInicial++;
                            }
                        }

                        $data=
                            array(
                                array(
                                    'Fecha_Tabla'=>$fecha,
                                    'Fecha'=>$fecha,
                                    'tabla_id' =>$tabla_id,
                                    "plaza_id"=>$plaza_id_MA,
                                    'Cantidad'=>$MA,
                                    "Folio"=>$folioInicial                            
                                ),
                                array(
                                    'Fecha_Tabla'=>$fecha,
                                    'Fecha'=>$fecha,
                                    'tabla_id' =>$tabla_id,
                                    "plaza_id"=>$plaza_id_R1,
                                    'Cantidad'=>$R1,
                                    "Folio"=>$folioInicial                            
                                )                                
                            );
                            
                            if($this->Mdl_depositos->insertarDepositoBatch2($data)){
                                echo 1;
                            }
                            else{
                                echo 0;
                            }                        
                    break;
                    //PEPE
                    case 4:
                        $banderaFolio = false;
                        $folioInicial = 1;                        
                        $plaza_id_R2 = 6; // Reynosa 2
                        
                        while(!$banderaFolio){                  
                            $folioConsultado_R2 = $this->Mdl_depositos->consultarDisponibilidadFolio($fecha,$plaza_id_R2,$folioInicial,$tabla_id);                
                            if($folioConsultado_R2 == true){
                                $banderaFolio = true;
                            }else{
                                $folioInicial++;
                            }
                        }
                        
                        $data =
                            array(
                                'Fecha_Tabla'=>$fecha,
                                'Fecha'=>$fecha,
                                'tabla_id' =>$tabla_id,
                                "plaza_id"=>$plaza_id_R2,
                                'Cantidad'=>$R2,
                                "Folio"=>$folioInicial                            
                            );

                            if($this->Mdl_depositos->insertarDeposito2($data)){
                                echo 1;
                            }
                            else{
                                echo 0;
                            }              
                        
                    break;
                    //VIC
                    case 5:
                        $banderaFolio = false;
                        $folioInicial = 1;

                        $plaza_id_CA = 1; // Casitas
                        $plaza_id_PZ = 4; // Poza Rica //Original
                        $plaza_id_OA = 3; // Oaxaca
                        
                        
                        while(!$banderaFolio){          
                            // Verificando si el folio no esta ya ocupado entonces lo ocupamos
                            // Sino incrementamos el contador para crear un folio libre        

                            $folioConsultado_CA = $this->Mdl_depositos->consultarDisponibilidadFolio($fecha,$plaza_id_CA,$folioInicial,$tabla_id);                
                            // Libre = true

                            $folioConsultado_PZ = $this->Mdl_depositos->consultarDisponibilidadFolio($fecha,$plaza_id_PZ,$folioInicial,$tabla_id);                
                            // Ocupado = false

                            $folioConsultado_OA = $this->Mdl_depositos->consultarDisponibilidadFolio($fecha,$plaza_id_OA,$folioInicial,$tabla_id);                
                            // Libre = true

                            if($folioConsultado_CA == true && $folioConsultado_PZ == true && $folioConsultado_OA == true){
                                $banderaFolio = true;
                            }else{
                                $folioInicial++;
                            }
                        }

                        $data=
                            array(
                                array(
                                    'Fecha_Tabla'=>$fecha,
                                    'Fecha'=>$fecha,
                                    'tabla_id' =>$tabla_id,
                                    "plaza_id"=>$plaza_id_CA,
                                    'Cantidad'=>$CA,
                                    "Folio"=>$folioInicial                            
                                ),
                                array(
                                    'Fecha_Tabla'=>$fecha,
                                    'Fecha'=>$fecha,
                                    'tabla_id' =>$tabla_id,
                                    "plaza_id"=>$plaza_id_PZ,
                                    'Cantidad'=>$PZ,
                                    "Folio"=>$folioInicial                            
                                ),
                                array(
                                    'Fecha_Tabla'=>$fecha,
                                    'Fecha'=>$fecha,
                                    'tabla_id' =>$tabla_id,
                                    "plaza_id"=>$plaza_id_OA,
                                    'Cantidad'=>$OA,
                                    "Folio"=>$folioInicial                            
                                )
                            );
                            
                            if($this->Mdl_depositos->insertarDepositoBatch2($data)){
                                echo 1;
                            }
                            else{
                                echo 0;
                            }         
                    break;

                    //MA TERESA
                    case 6:
                        $limite=3;

                        $banderaFolio1=false;
                        $folioInicial1=1;
                        $plaza_id1=2;
                        $plaza_id2=5;
                        $plaza_id3=6;

                        
                        while(!$banderaFolio1){                  
                            $folioConsultado1=$this->Mdl_depositos->consultarDisponibilidadFolio($fecha,$plaza_id1,$folioInicial1,$tabla_id);                
                            if($folioConsultado1==true){
                                $banderaFolio1=true;
                            }else{
                                $folioInicial1++;
                            }
                        }


                        $data=
                        array
                        (
                            array(
                                'Fecha_Tabla'=>$fecha,
                                'Fecha'=>$fecha,
                                'tabla_id' =>$tabla_id,
                                "plaza_id"=>$plaza_id1,
                                'Cantidad'=>$MA,
                                "Folio"=>$folioInicial1                            
                            ),
                            array(
                                'Fecha_Tabla'=>$fecha,
                                'Fecha'=>$fecha,
                                'tabla_id' =>$tabla_id,
                                "plaza_id"=>$plaza_id2,
                                'Cantidad'=>$R1,
                                "Folio"=>$folioInicial1                           
                            ),
                            array(
                                'Fecha_Tabla'=>$fecha,
                                'Fecha'=>$fecha,
                                'tabla_id' =>$tabla_id,
                                "plaza_id"=>$plaza_id3,
                                'Cantidad'=>$R2,
                                "Folio"=>$folioInicial1                            
                            )
                        );

                        if($this->Mdl_depositos->insertarDepositoBatch2($data)){
                            echo 1;
                        }
                        else{
                            echo 0;
                        }              

                    break;
                    //CAJA CHICA
                    case 7:
                        $banderaFolio1=false;
                        $folioInicial1=1;
                        
                        $plaza_id1=1;
                        $plaza_id2=2;
                        $plaza_id3=3;
                        $plaza_id4=4;
                        $plaza_id5=5;
                        $plaza_id6=6;
                        $plaza_id7=7;


                        
                        while(!$banderaFolio1){                  
                            $folioConsultado1=$this->Mdl_depositos->consultarDisponibilidadFolio($fecha,$plaza_id1,$folioInicial1,$tabla_id);                
                            if($folioConsultado1==true){
                                $banderaFolio1=true;
                            }else{
                                $folioInicial1++;
                            }
                        }


                        $data=
                        array
                        (
                            array(
                                'Fecha_Tabla'=>$fecha,
                                'Fecha'=>$fecha,
                                'tabla_id' =>$tabla_id,
                                "plaza_id"=>$plaza_id1,
                                'Cantidad'=>$CA,
                                "Folio"=>$folioInicial1                            
                            ),
                            array(
                                'Fecha_Tabla'=>$fecha,
                                'Fecha'=>$fecha,
                                'tabla_id' =>$tabla_id,
                                "plaza_id"=>$plaza_id2,
                                'Cantidad'=>$MA,
                                "Folio"=>$folioInicial1                           
                            ),
                            array(
                                'Fecha_Tabla'=>$fecha,
                                'Fecha'=>$fecha,
                                'tabla_id' =>$tabla_id,
                                "plaza_id"=>$plaza_id3,
                                'Cantidad'=>$OA,
                                "Folio"=>$folioInicial1                            
                            ),
                            array(
                                'Fecha_Tabla'=>$fecha,
                                'Fecha'=>$fecha,
                                'tabla_id' =>$tabla_id,
                                "plaza_id"=>$plaza_id4,
                                'Cantidad'=>$PZ,
                                "Folio"=>$folioInicial1                            
                            ),
                            array(
                                'Fecha_Tabla'=>$fecha,
                                'Fecha'=>$fecha,
                                'tabla_id' =>$tabla_id,
                                "plaza_id"=>$plaza_id5,
                                'Cantidad'=>$R1,
                                "Folio"=>$folioInicial1                            
                            ),
                            array(
                                'Fecha_Tabla'=>$fecha,
                                'Fecha'=>$fecha,
                                'tabla_id' =>$tabla_id,
                                "plaza_id"=>$plaza_id6,
                                'Cantidad'=>$R2,
                                "Folio"=>$folioInicial1                            
                            ),
                            array(
                                'Fecha_Tabla'=>$fecha,
                                'Fecha'=>$fecha,
                                'tabla_id' =>$tabla_id,
                                "plaza_id"=>$plaza_id7,
                                'Cantidad'=>$TZ,
                                "Folio"=>$folioInicial1                            
                            )
                        );

                        if($this->Mdl_depositos->insertarDepositoBatch2($data)){
                            echo 1;
                        }
                        else{
                            echo 0;
                        } 
                        break;
                    
                    default:
                        //ERROR 
                    break;
                }

            
                
            }   
            else{
                    redirect(base_url()."Inicio");
            }
        }

        //Actualizar una fila de la tabla de depósitos
        public function actualizarTablaDepositos(){
            if($this->input->is_ajax_request()){

                $CA=$this->input->post("CA_fila");
                $MA=$this->input->post("MA_fila");
                $OA=$this->input->post("OA_fila");
                $PZ=$this->input->post("PZ_fila");
                $R1=$this->input->post("R1_fila");
                $R2=$this->input->post("R2_fila");
                $TZ=$this->input->post("TZ_fila");


                if($CA==null){$CA=0;}
                if($MA==null){$MA=0;}
                if($OA==null){$OA=0;}
                if($PZ==null){$PZ=0;}
                if($R1==null){$R1=0;}
                if($R2==null){$R2=0;}
                if($TZ==null){$TZ=0;}
        
                $fecha = $this->input->post("fecha_nueva_linea_fila"); 
                $tabla_id = $this->input->post("tabla_id_formulario_fila");
                $id = $this->input->post("code");
                $folio = $this->input->post("folio_actualizar");
            
                switch ($tabla_id) {                
                    //DON TOÑO
                    case 2:                                                                                                                  
                        $data=
                        array(
                                'Cantidad'=>$TZ                          
                            );
                            if($this->Mdl_depositos->actualizarTabla2($id,$data)){
                                echo 1;
                            }
                            else{
                                echo 0;
                            }                        
                    break;
                    //PEDRO
                    case 3:                                                                                         
                        $plaza_id_MA = 2; // Matamoros
                        $plaza_id_R1 = 5; // Reynosa I                         

                        $data_MA = array( 'Cantidad' => $MA );
                        $data_R1 = array( 'Cantidad' => $R1 );


                        if($this->Mdl_depositos->actualizarTablaPedro($fecha,$folio,$data_MA,$data_R1,$plaza_id_MA,$plaza_id_R1,$tabla_id)){
                            echo 1;
                        }
                        else{
                            echo 0;
                        }

                    break;
                    //PEPE
                    case 4:                        
                        $data = array( 'Cantidad' => $R2 );
                                            
                        if($this->Mdl_depositos->actualizarTabla2($id,$data)){
                            echo 1;
                        }else{
                            echo 0;
                        }
                                                                                                                                    
                    break;
                    // VIC
                    case 5:                        

                        $plaza_id_CA = 1; // Casitas
                        $plaza_id_PZ = 4; // Poza Rica //Original
                        $plaza_id_OA = 3; // Oaxaca

                        $data_CA = array( 'Cantidad'=>$CA );
                        $data_PZ = array( 'Cantidad'=>$PZ );
                        $data_OA = array( 'Cantidad'=>$OA );


                        if($this->Mdl_depositos->actualizarTablaVic($fecha,$folio,$data_CA,$data_PZ,$data_OA,$plaza_id_CA,$plaza_id_PZ,$plaza_id_OA,$tabla_id)){
                            echo 1;
                        }
                        else{
                            echo 0;
                        }   

                    break;
                    // MA TERESA
                    case 6:                        
                        $plaza_id1=2;
                        $plaza_id2=5;
                        $plaza_id3=6;

                        $data1=
                        array(
                                'Cantidad'=>$MA                          
                        );

                        $data2=
                        array(
                                'Cantidad'=>$R1                          
                        );

                        $data3=
                        array(
                                'Cantidad'=>$R2                          
                        );                                            
                        if($this->Mdl_depositos->actualizarTablaMariaTeresa2($fecha,$folio,$data1,$data2,$data3,$plaza_id1,$plaza_id2,$plaza_id3,$tabla_id)){                            
                            echo 1;
                        }
                        else{
                            echo 0;
                        }

                    break;
                    //CAJA CHICA
                    case 7:
                        
                        $plaza_id1=1;
                        $plaza_id2=2;
                        $plaza_id3=3;
                        $plaza_id4=4;
                        $plaza_id5=5;
                        $plaza_id6=6;
                        $plaza_id7=7;


                        $data1=
                        array(
                                'Cantidad'=>$CA                         
                        );

                        $data2=
                        array(
                                'Cantidad'=>$MA                          
                        );

                        $data3=
                        array(
                                'Cantidad'=>$OA                         
                        );
                        
                        $data4=
                        array(
                                'Cantidad'=>$PZ                         
                        );

                        $data5=
                        array(
                                'Cantidad'=>$R1                         
                        );

                        $data6=
                        array(
                                'Cantidad'=>$R2                         
                        );

                        $data7=
                        array(
                                'Cantidad'=>$TZ                         
                        );
                        
                        

                        if($this->Mdl_depositos->actualizarCajaChica2($fecha,$folio,$data1,$data2,$data3,$data4,$data5,$data6,$data7,$plaza_id1,$plaza_id2,$plaza_id3,$plaza_id4,$plaza_id5,$plaza_id6,$plaza_id7,$tabla_id)){                            
                            echo 1;
                        }
                        else{
                            echo 0;
                        }

                    break;
                    
                    default:
                        //ERROR 
                    break;
                }                                            
            }   
            else{
                    redirect(base_url()."Inicio");
            }        
        }

        // Eliminar una fila de la tabla
        public function deleteFilaTabla(){
            if($this->input->is_ajax_request()){             
                $id = $this->input->post("code");                            
                if($this->Mdl_depositos->deleteFila2($id)){
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

        //Eliminar multiples filas
        public function deleteFilaTablaMultiple(){
            if($this->input->is_ajax_request()){                     
                
                $fecha = $this->input->post("fecha");            
                $tabla_id = $this->input->post("tabla_id");
                $folio = $this->input->post("folio");
                $grupoPlazas = [];

                switch ($tabla_id) {

                    // Pedro
                    case 3:    
						$plaza_id_MA = 2;
						$plaza_id_R1 = 5;
	
						$grupoPlazas = [$plaza_id_MA,$plaza_id_R1];                    

                    break;
                    
                    // Vic
                    case 5:              
						$plaza_id_CA = 1; // Casitas
						$plaza_id_PZ = 4; // Poza Rica
						$plaza_id_OA = 3; // Oaxaca

						$grupoPlazas = [$plaza_id_CA,$plaza_id_PZ,$plaza_id_OA];          
                    break;

                    // Ma. Teresa
                    case 6:                        
						$plaza_id_MA = 2; // Matamoros
						$plaza_id_R1 = 5; // Reynosa 1
						$plaza_id_R2 = 6; // Reynosa 2

						$grupoPlazas = [$plaza_id_MA,$plaza_id_R1,$plaza_id_R2];
                    break;
                                        
                    default:                        
                    break;
                }

				// Caja chica Case
                if(sizeof($grupoPlazas) == 0){
                    if($this->Mdl_depositos->deleteFilaMultiple2($fecha,$tabla_id,$folio)){
                        echo 1;  
                    }
                    else{
                        echo 0;
                    }
                }else{
					if($this->Mdl_depositos->deleteFilaMultipleGrupoPlaza($fecha,$tabla_id,$folio,$grupoPlazas)){
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
    //=====Métodos usados en la tabla de depósitos=====//

    public function consultarLiberacionDeposito(){
        if($this->input->is_ajax_request()){   

            $fecha=$this->input->post("fecha_deposito_tpv");  
            $TPV=$this->input->post("TPV");  
            $plaza_id=$this->input->post("plaza_id_TPV_deposito");
            
            //CENTINELA PARA VER SI LA MODIFICACIÓN AFECTARA LA TABLA DE DEPÓSITOS
            $banderaLiberacionDeposito=false;
            $banderaLiberacion=$this->Mdl_depositos->consultarLiberacion($fecha,$plaza_id);
            $banderaLiberacion=$banderaLiberacion->Bandera;
            
            if($banderaLiberacion==1){
                echo 1;
            }
            else if($banderaLiberacion==0){
                echo 0;
            }                                       
        }   
        else{
                redirect(base_url()."Inicio");
          }
    }

    public function ventasOaxaca(){
        $fechainicio=$this->input->post("fechaInicioD");
        $fechafin=$this->input->post("fechaFinD"); 
        $id_plaza=$this->session->userdata("plaza");
        $plazas=$this->Mdl_plazas->getPlazas();
        $grafico=0;
        $menu=0;
        $fechaConsulta=$fechainicio."<br>".$fechafin;

        $fechaActual=date('Y-m-d',strtotime("-1 days"));
        $reportes=$this->Mdl_depositos->getDepositosFechaPlaza($fechaActual,$fechaActual,$id_plaza);

        if($this->input->post("buscar")){
            $reportes=$this->Mdl_depositos->getDepositosFechaPlaza($fechainicio,$fechainicio,$id_plaza);
            $fechafin="";
        }
        else if($this->input->post("buscarRango")){
            $reportes=$this->Mdl_depositos->getDepositosGeneralFechaPlaza($fechainicio,$fechafin,$id_plaza);
            $menu=1;
        }
        else if($this->input->post("buscarRangoDesglose")){
            $reportes=$this->Mdl_depositos->getDepositosGeneralFechaPlazaDesglose($fechainicio,$fechafin,$id_plaza);
            $menu=0;
        }
        
        $data=array
            ('reportes'    => $reportes,
            'fechainicio' => $fechainicio,
            'fechafin'    => $fechafin,
            'plazas'      => $plazas,
            'menu'        => $menu,
            'id'          => $id_plaza,
            'fechaConsulta'=>$fechaConsulta
        );

        $this->load->view("layouts/header");
        $this->load->view("layouts/aside");
        $this->load->view("socio/depositos/list",$data);
        $this->load->view("layouts/footer");  
    }


    private function liberarDepositos2(){

        $fechainicio=$this->input->get("fechaInicioD");
        $fechafin=$this->input->get("fechaFinD"); 
        $id_plaza=$this->input->get("plaza_idP");


        $plazas=$this->Mdl_plazas->getPlazas();
        $grafico=0;
        $menu=0;
        $fechaConsulta=$fechainicio."<br>".$fechafin;

        
        $fechaActual=date('Y-m-d',strtotime("-1 days"));
        $reportes=$this->Mdl_depositos->getDepositosFecha($fechaActual,$fechaActual);


        if($id_plaza==""){
            if($this->input->get("buscar")){
                $reportes=$this->Mdl_depositos->getDepositosFecha($fechainicio,$fechainicio);
                $fechafin="";
        }        
        else if($this->input->get("buscarRangoDesglose")){
            $reportes=$this->Mdl_depositos->getDepositosGeneralFechaDesglose($fechainicio,$fechafin);            
            $menu=0;
        }
        }else{
            if($this->input->get("buscar")){
                $reportes=$this->Mdl_depositos->getDepositosFechaPlaza($fechainicio,$fechainicio,$id_plaza);
                $fechafin="";
        }        
        else if($this->input->get("buscarRangoDesglose")){
            $reportes=$this->Mdl_depositos->getDepositosGeneralFechaPlazaDesglose($fechainicio,$fechafin,$id_plaza);
            $menu=0;
        }

        }
        
        $data=array
            ('reportes'    => $reportes,
            'fechainicio' => $fechainicio,
            'fechafin'    => $fechafin,
            'plazas'      => $plazas,
            'menu'        => $menu,
            'id'          => $id_plaza,
            'fechaConsulta'=>$fechaConsulta
        );

        $this->load->view("layouts/header");
        $this->load->view("layouts/aside");
        $this->load->view("administrador/depositos/liberar_depositos2",$data);
        $this->load->view("layouts/footer");  
    }
    
}
