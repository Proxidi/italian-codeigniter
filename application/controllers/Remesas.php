<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Remesas extends CI_Controller {
    private $permisos;
    
    public function __construct()
    {
             parent::__construct();
             $this->permisos=$this->backend_lib->control();
             $this->load->model('Mdl_remesas');
             $this->load->model('Mdl_inventario');
             $this->load->model('Mdl_productos');
             $this->load->model('Mdl_unidades');
             $this->load->model('Mdl_depositos');
             $this->load->model('Mdl_plazas');
             $this->load->model('Mdl_ventas');
             $this->load->model('Mdl_remesas');


             $this->load->model('Mdl_plazas');
             if(!$this->session->userdata("login")){
				redirect(base_url());
				}
    }
 
    public function index()
	{
        $this->load->view("layouts/header");
	    $this->load->view("layouts/aside");
		$this->load->view("administrador/remesas/panel_remesas");
        $this->load->view("layouts/footer");                   
    }

    public function indexManager()
    {
        $plaza_id=$this->session->userdata("plaza");
        $banderaCorte=0;
        $grupos=$this->Mdl_remesas->getGrupos();

        $banderaCorte=$this->Mdl_ventas->getBanderaCorte($plaza_id);                
        if($banderaCorte!=null){
            $banderaCorte=$banderaCorte->Enviado;
        }
        
        if($plaza_id==3){
            $grupos=$this->Mdl_remesas->getGruposOaxaca();
        }        

        $data=array(
            'gastos' => $this->Mdl_remesas->getGastosDia($plaza_id),
            'gastosT' => $this->Mdl_remesas->getGastos($plaza_id),
            'grupos' =>  $grupos,
            'insumos' =>  $this->Mdl_remesas->getInsumos(),
            'pagos'  =>   $this->Mdl_remesas->getUnidadesPago(),
            'banderaCorte'=>$banderaCorte
        );        

        $this->load->view("layouts/header");
	    $this->load->view("layouts/aside");
		$this->load->view("manager/reportes/remesas/list_gastos",$data);
        $this->load->view("layouts/footer");
    }

    
  public function addRemesasAdministrador()
	{
		// Obteniendo las variables por medio de posteo GET
		$fechaInicio = $this->input->get("fechaInicio");
		$fechaFin    = $this->input->get("fechaFin"); 
		$plaza_id    = $this->input->get("plaza_id");

		// Si no hay nada en el input dejamos la fecha de hoy
		if(!$fechaInicio){
			$fechaInicio = date("Y-m-d");
		}

		// Si solo buscamos un día no en rango la fecha de fin se iguala a la de inicio
		if($this->input->get("buscar")){
			$fechaFin = $fechaInicio;
		}

		// Si no hay nada en la fecha de fin le dejamos la fecha de inicio
		if(!$fechaFin || $fechaInicio > $fechaFin){
			$fechaFin = $fechaInicio;
		}
		
		$data=array(
			'gastos'      => $this->Mdl_remesas->getGastosAdminFecha($fechaInicio, $fechaFin, $plaza_id),        
			'insumos'     => $this->Mdl_remesas->getInsumosAdmin(),            
			'pagos'       => $this->Mdl_remesas->getUnidadesPago(),
			'plazas'      => $this->Mdl_plazas->getPlazas(),
			'plaza_id'    => $plaza_id,
			'fechaInicio' => $fechaInicio,
			'fechaFin'    => $fechaFin,			
		);      

		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("administrador/remesas/list_remesas_fgf", $data);
		$this->load->view("layouts/footer");                     
  }

    public function analisisRemesas()
    {        
        //VARIABLES INICIALES DEL PROYECTO
            
            $plaza_id=$this->input->post("plaza_id"); 
            $fechainicio=$this->input->post("fechaInicioD"); 
            $fechafin=$this->input->post("fechaFinD"); 

            $id_grafico=$this->input->post("grafico_id");
            $insumo_gasto_remesa_id=$this->input->post("insumo_gasto_remesa_id");
            $grupo_remesa_id=$this->input->post("grupo_remesa_id");
            $fechaActual=date('Y-m-d',strtotime("-1 days"));
            $tipos=$this->Mdl_plazas->getTipoGraficoID(2);   
            $busquedaPlaza=false;
            $valorGenerico="";
            $campo="";
            $acronimoCampo="";
            $nombreInsumo="";    
            $banderaDias=true;
            $weekday=0;
        //VARIABLES INICIALES DEL PROYECTO 
            
        //MÉTODO PARA VERIFICAR SI LA BUSQUEDA ES POR MES O POR DÍAS
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
        //MÉTODO PARA VERIFICAR SI LA BUSQUEDA ES POR MES O POR DÍAS

        //ARREGLOS PARA LOS GRAFICOS
            $valoresXCA=array();
            $valoresYCA=array();        
            $valoresXMA=array();
            $valoresYMA=array();        
            $valoresXOA=array();        
            $valoresYOA=array();        
            $valoresXPZ=array();
            $valoresYPZ=array();        
            $valoresXR1=array();
            $valoresYR1=array();
            $valoresXR2=array();
            $valoresYR2=array();
            $valoresXTZ=array();
            $valoresYTZ=array(); 
            $valoresXGenerico=array();
            $valoresYGenerico=array(); 
        //ARREGLOS PARA LOS GRAFICOS

        //DESIGNACIÓN DEL TIPO DE CAMPO A GRAFICAR
            if($id_grafico!=""){
                switch ($id_grafico) {
                    case 7:                    
                        $campo="Importe";
                        $acronimoCampo="Importe";
                    break;
                    
                    case 8:                    
                    $campo="Cantidad";
                    $acronimoCampo="Cantidad";
                    break;
                                                      
                    default:                    
                    $campo="Importe";
                    $acronimoCampo="Importe";
                    break;
                }
            }else{
                $campo="Importe";
                $acronimoCampo="Importe";
            }
        //DESIGNACIÓN DEL TIPO DE CAMPO A GRAFICAR

        //ASIGNANDO EL NOMBRE DE LA PLAZA         
         $nombrePlaza=$this->Mdl_plazas->getPlazaID($plaza_id);
            if($nombrePlaza!=null){
                $nombrePlaza=$nombrePlaza->nombrePlaza;
            }else{
                $nombrePlaza="";
            }
        //ASIGNANDO EL NOMBRE DE LA PLAZA         
         
        //VALORES POR DEFECTO PARA LOS GRAFICOS
            $valorCA=$this->Mdl_remesas->getGastosGraficoPlaza($fechaActual,$fechaActual,1,$campo);
            $valorMA=$this->Mdl_remesas->getGastosGraficoPlaza($fechaActual,$fechaActual,2,$campo);
            $valorOA=$this->Mdl_remesas->getGastosGraficoPlaza($fechaActual,$fechaActual,3,$campo);
            $valorPZ=$this->Mdl_remesas->getGastosGraficoPlaza($fechaActual,$fechaActual,4,$campo);
            $valorR1=$this->Mdl_remesas->getGastosGraficoPlaza($fechaActual,$fechaActual,5,$campo);
            $valorR2=$this->Mdl_remesas->getGastosGraficoPlaza($fechaActual,$fechaActual,6,$campo);
            $valorTZ=$this->Mdl_remesas->getGastosGraficoPlaza($fechaActual,$fechaActual,7,$campo);
            $fechaInicioG=$fechaActual;
            $fechaFinG=$fechaActual;
        //VALORES POR DEFECTO PARA LOS GRAFICOS
             
        //ASIGNACIÓN DEL TIPO DE GRAFICO SEGUN EL TIPO DE BUSQUEDA REALIZDA POR EL USUARIO
            if($plaza_id==""){
                if($grupo_remesa_id==""){
                if($insumo_gasto_remesa_id==""){                    
                    if($this->input->post("buscar")){
                        //Este método se carga en la pantalla principal al buscar realizar un análisis de una fecha en particular
                        //Para esta condición deben estar seleccionadas todas las plazas,todas las familias y ningun insumo      
                        $valorCA=$this->Mdl_remesas->getGastosGraficoPlaza($fechainicio,$fechainicio,1,$campo);
                        $valorMA=$this->Mdl_remesas->getGastosGraficoPlaza($fechainicio,$fechainicio,2,$campo);
                        $valorOA=$this->Mdl_remesas->getGastosGraficoPlaza($fechainicio,$fechainicio,3,$campo);
                        $valorPZ=$this->Mdl_remesas->getGastosGraficoPlaza($fechainicio,$fechainicio,4,$campo);
                        $valorR1=$this->Mdl_remesas->getGastosGraficoPlaza($fechainicio,$fechainicio,5,$campo);
                        $valorR2=$this->Mdl_remesas->getGastosGraficoPlaza($fechainicio,$fechainicio,6,$campo);
                        $valorTZ=$this->Mdl_remesas->getGastosGraficoPlaza($fechainicio,$fechainicio,7,$campo);
                        $fechaInicioG=$fechainicio;
                        $fechaFinG=$fechainicio;

                    }
                    else if($this->input->post("buscarRango")){
                        //Este método se carga en la pantalla principal al buscar realizar un análisis por medio de rangos
                        //Para esta condición deben estar seleccionadas todas las plazas,todas las familias y ningun insumo                    
                        $valorCA=$this->Mdl_remesas->getGastosGraficoPlaza($fechainicio,$fechafin,1,$campo);
                        $valorMA=$this->Mdl_remesas->getGastosGraficoPlaza($fechainicio,$fechafin,2,$campo);
                        $valorOA=$this->Mdl_remesas->getGastosGraficoPlaza($fechainicio,$fechafin,3,$campo);
                        $valorPZ=$this->Mdl_remesas->getGastosGraficoPlaza($fechainicio,$fechafin,4,$campo);
                        $valorR1=$this->Mdl_remesas->getGastosGraficoPlaza($fechainicio,$fechafin,5,$campo);
                        $valorR2=$this->Mdl_remesas->getGastosGraficoPlaza($fechainicio,$fechafin,6,$campo);
                        $valorTZ=$this->Mdl_remesas->getGastosGraficoPlaza($fechainicio,$fechafin,7,$campo);
                        $fechaInicioG=$fechainicio;
                        $fechaFinG=$fechafin;
                    }
                    else{
                        //Este método se carga por defecto una vez que entramos a la aplicación, muestra los gastos
                        //realizados el día anterior, junto con los porcentajes sobre ventas igualmente del día anterior                                        
                    }                   
                }                
                }
                else {
                    if($insumo_gasto_remesa_id==""){
                    if($this->input->post("buscar")){
                        //Este método se utiliza para hacer una busqueda normal de una familia sin insumo para solo un día
                        //Todas las plazas seleccionadas   
                        $valorCA=$this->Mdl_remesas->getGastosGraficoPlazaGrupo($fechainicio,$fechainicio,1,$grupo_remesa_id,$campo);
                        $valorMA=$this->Mdl_remesas->getGastosGraficoPlazaGrupo($fechainicio,$fechainicio,2,$grupo_remesa_id,$campo);
                        $valorOA=$this->Mdl_remesas->getGastosGraficoPlazaGrupo($fechainicio,$fechainicio,3,$grupo_remesa_id,$campo);
                        $valorPZ=$this->Mdl_remesas->getGastosGraficoPlazaGrupo($fechainicio,$fechainicio,4,$grupo_remesa_id,$campo);
                        $valorR1=$this->Mdl_remesas->getGastosGraficoPlazaGrupo($fechainicio,$fechainicio,5,$grupo_remesa_id,$campo);
                        $valorR2=$this->Mdl_remesas->getGastosGraficoPlazaGrupo($fechainicio,$fechainicio,6,$grupo_remesa_id,$campo);
                        $valorTZ=$this->Mdl_remesas->getGastosGraficoPlazaGrupo($fechainicio,$fechainicio,7,$grupo_remesa_id,$campo);
                        $fechaInicioG=$fechainicio;
                        $fechaFinG=$fechainicio;                                                                 
                    }
                    else if($this->input->post("buscarRango")){
                        //Este método se utiliza para hacer una busqueda por rangos todas las plazas con una familia seleccionadad, sin insumo
                        //realizados el día anterior, junto con los porcentajes sobre ventas igualmente del día anterior                         
                        $valorCA=$this->Mdl_remesas->getGastosGraficoPlazaGrupo($fechainicio,$fechafin,1,$grupo_remesa_id,$campo);
                        $valorMA=$this->Mdl_remesas->getGastosGraficoPlazaGrupo($fechainicio,$fechafin,2,$grupo_remesa_id,$campo);
                        $valorOA=$this->Mdl_remesas->getGastosGraficoPlazaGrupo($fechainicio,$fechafin,3,$grupo_remesa_id,$campo);
                        $valorPZ=$this->Mdl_remesas->getGastosGraficoPlazaGrupo($fechainicio,$fechafin,4,$grupo_remesa_id,$campo);
                        $valorR1=$this->Mdl_remesas->getGastosGraficoPlazaGrupo($fechainicio,$fechafin,5,$grupo_remesa_id,$campo);
                        $valorR2=$this->Mdl_remesas->getGastosGraficoPlazaGrupo($fechainicio,$fechafin,6,$grupo_remesa_id,$campo);
                        $valorTZ=$this->Mdl_remesas->getGastosGraficoPlazaGrupo($fechainicio,$fechafin,7,$grupo_remesa_id,$campo);
                        $fechaInicioG=$fechainicio;
                        $fechaFinG=$fechafin;                                                                 
                    }            
                    }
                    else{
                        if($this->input->post("buscar")){
                        //Este método se utiliza para hacer una busqueda cuando son todas las plazas, familia seleccionada e insumo seleccionado
                        //Todas las plazas seleccionadas  
                        $nombreInsumo=$this->Mdl_remesas->getNombreInsumoGasto($insumo_gasto_remesa_id); 
                        $nombreInsumo=$nombreInsumo->nombreInsumo;                    
                        $valorCA=$this->Mdl_remesas->getGastosGraficoPlazaInsumoDias($fechainicio,$fechainicio,1,$insumo_gasto_remesa_id,$campo);
                        $valorMA=$this->Mdl_remesas->getGastosGraficoPlazaInsumoDias($fechainicio,$fechainicio,2,$insumo_gasto_remesa_id,$campo);
                        $valorOA=$this->Mdl_remesas->getGastosGraficoPlazaInsumoDias($fechainicio,$fechainicio,3,$insumo_gasto_remesa_id,$campo);
                        $valorPZ=$this->Mdl_remesas->getGastosGraficoPlazaInsumoDias($fechainicio,$fechainicio,4,$insumo_gasto_remesa_id,$campo);
                        $valorR1=$this->Mdl_remesas->getGastosGraficoPlazaInsumoDias($fechainicio,$fechainicio,5,$insumo_gasto_remesa_id,$campo);
                        $valorR2=$this->Mdl_remesas->getGastosGraficoPlazaInsumoDias($fechainicio,$fechainicio,6,$insumo_gasto_remesa_id,$campo);
                        $valorTZ=$this->Mdl_remesas->getGastosGraficoPlazaInsumoDias($fechainicio,$fechainicio,7,$insumo_gasto_remesa_id,$campo);                                        
                        $fechaInicioG=$fechainicio;
                        $fechaFinG=$fechainicio;                        
                    }   
                        else if($this->input->post("buscarRango")){
                        //Este método se utiliza para hacer una busqueda cuando son todas las plazas, familia seleccionada e insumo seleccionado
                        // Busqueda en rango
                        //Todas las plazas seleccionadas 
                        $nombreInsumo=$this->Mdl_remesas->getNombreInsumoGasto($insumo_gasto_remesa_id); 
                        $nombreInsumo=$nombreInsumo->nombreInsumo;   
                        
                        if($banderaDias==true){
                            $valorCA=$this->Mdl_remesas->getGastosGraficoPlazaInsumoDias($fechainicio,$fechafin,1,$insumo_gasto_remesa_id,$campo);
                            $valorMA=$this->Mdl_remesas->getGastosGraficoPlazaInsumoDias($fechainicio,$fechafin,2,$insumo_gasto_remesa_id,$campo);
                            $valorOA=$this->Mdl_remesas->getGastosGraficoPlazaInsumoDias($fechainicio,$fechafin,3,$insumo_gasto_remesa_id,$campo);
                            $valorPZ=$this->Mdl_remesas->getGastosGraficoPlazaInsumoDias($fechainicio,$fechafin,4,$insumo_gasto_remesa_id,$campo);
                            $valorR1=$this->Mdl_remesas->getGastosGraficoPlazaInsumoDias($fechainicio,$fechafin,5,$insumo_gasto_remesa_id,$campo);
                            $valorR2=$this->Mdl_remesas->getGastosGraficoPlazaInsumoDias($fechainicio,$fechafin,6,$insumo_gasto_remesa_id,$campo);
                            $valorTZ=$this->Mdl_remesas->getGastosGraficoPlazaInsumoDias($fechainicio,$fechafin,7,$insumo_gasto_remesa_id,$campo);                                            
                        }else{
                            $valorCA=$this->Mdl_remesas->getGastosGraficoPlazaInsumoMes($fechainicio,$fechafin,1,$insumo_gasto_remesa_id,$campo);
                            $valorMA=$this->Mdl_remesas->getGastosGraficoPlazaInsumoMes($fechainicio,$fechafin,2,$insumo_gasto_remesa_id,$campo);
                            $valorOA=$this->Mdl_remesas->getGastosGraficoPlazaInsumoMes($fechainicio,$fechafin,3,$insumo_gasto_remesa_id,$campo);
                            $valorPZ=$this->Mdl_remesas->getGastosGraficoPlazaInsumoMes($fechainicio,$fechafin,4,$insumo_gasto_remesa_id,$campo);
                            $valorR1=$this->Mdl_remesas->getGastosGraficoPlazaInsumoMes($fechainicio,$fechafin,5,$insumo_gasto_remesa_id,$campo);
                            $valorR2=$this->Mdl_remesas->getGastosGraficoPlazaInsumoMes($fechainicio,$fechafin,6,$insumo_gasto_remesa_id,$campo);
                            $valorTZ=$this->Mdl_remesas->getGastosGraficoPlazaInsumoMes($fechainicio,$fechafin,7,$insumo_gasto_remesa_id,$campo);                                        
                        }
                        $fechaInicioG=$fechainicio;
                        $fechaFinG=$fechafin;                                                   
                    }                        
                    }                 
                }                                                       
            }else{
                $busquedaPlaza=true;
                if($grupo_remesa_id==""){
                    if($this->input->post("buscar")){                    
                        //Este método se carga por defecto una vez que entramos a la aplicación, muestra los gastos
                        //realizados el día anterior, junto con los porcentajes sobre ventas igualmente del día anterior
                        $valorGenerico=$this->Mdl_remesas->getGastosGraficoPlaza($fechainicio,$fechainicio,$plaza_id,$campo);                
                        $fechaInicioG=$fechainicio;
                        $fechaFinG=$fechainicio;                
                    }
                    else if($this->input->post("buscarRango")){
                        //Este método se carga por defecto una vez que entramos a la aplicación, muestra los gastos
                        //realizados el día anterior, junto con los porcentajes sobre ventas igualmente del día anterior                          
                        $valorGenerico=$this->Mdl_remesas->getGastosGraficoPlaza($fechainicio,$fechafin,$plaza_id,$campo);                
                        $fechaInicioG=$fechainicio;
                        $fechaFinG=$fechafin;                    
                    }                
                }
                else{
                    if($insumo_gasto_remesa_id==""){                        
                        if($this->input->post("buscar")){
                            //Este método se utiliza para hacer una busqueda normal de una familia sin insumo para solo un día
                            //Todas las plazas seleccionadas
                            $valorGenerico=$this->Mdl_remesas->getGastosGraficoPlazaGrupo($fechainicio,$fechainicio,$plaza_id,$grupo_remesa_id,$campo);
                            $fechaInicioG=$fechainicio;
                            $fechaFinG=$fechainicio;                                                                                                                         
                        }
                        else if($this->input->post("buscarRango")){                                     
                            $valorGenerico=$this->Mdl_remesas->getGastosGraficoPlazaGrupo($fechainicio,$fechafin,$plaza_id,$grupo_remesa_id,$campo);
                            $fechaInicioG=$fechainicio;
                            $fechaFinG=$fechafin;
                        }                    
                    }
                    else{                    
                    if($this->input->post("buscar")){  
                            $nombreInsumo=$this->Mdl_remesas->getNombreInsumoGasto($insumo_gasto_remesa_id); 
                            $nombreInsumo=$nombreInsumo->nombreInsumo;                       
                            $valorGenerico=$this->Mdl_remesas->getGastosGraficoPlazaInsumoDias($fechainicio,$fechainicio,$plaza_id,$insumo_gasto_remesa_id,$campo);
                            $fechaInicioG=$fechainicio;
                            $fechaFinG=$fechainicio;                                                                                                                         
                        }
                        else if($this->input->post("buscarRango")){                                     
                            $nombreInsumo=$this->Mdl_remesas->getNombreInsumoGasto($insumo_gasto_remesa_id); 
                            $nombreInsumo=$nombreInsumo->nombreInsumo; 

                            if($banderaDias==true){
                                $valorGenerico=$this->Mdl_remesas->getGastosGraficoPlazaInsumoDias($fechainicio,$fechafin,$plaza_id,$insumo_gasto_remesa_id,$campo);
                            }else{
                                $valorGenerico=$this->Mdl_remesas->getGastosGraficoPlazaInsumoMes($fechainicio,$fechafin,$plaza_id,$insumo_gasto_remesa_id,$campo);
                            }
                            
                            $fechaInicioG=$fechainicio;
                            $fechaFinG=$fechafin;
                        }
                    }
                }                  
                
                foreach ($valorGenerico as $key) {                                                
                    $valoresXGenerico[]=$key->Nombre;
                    $valoresYGenerico[]=round($key->Cantidad,2);            
                }

                $datosXGenerico=json_encode($valoresXGenerico);
                $datosYGenerico=json_encode($valoresYGenerico);
            }


        //ASIGNACIÓN DEL TIPO DE GRAFICO SEGUN EL TIPO DE BUSQUEDA REALIZDA POR EL USUARIO

        //ASIGNACIÓN DE LOS VALORES PARA JSON MEDIANTE CICLOS
            foreach ($valorCA as $key) {                                                
                $valoresXCA[]=$key->Nombre;
                $valoresYCA[]=round($key->Cantidad,2);            
            }
            $datosXCA=json_encode($valoresXCA);
            $datosYCA=json_encode($valoresYCA);
            
        
            foreach ($valorMA as $key) {                                                
                $valoresXMA[]=$key->Nombre;
                $valoresYMA[]=round($key->Cantidad,2);            
            }
            $datosXMA=json_encode($valoresXMA);
            $datosYMA=json_encode($valoresYMA);

            
            foreach ($valorOA as $key) {                                                
                $valoresXOA[]=$key->Nombre;
                $valoresYOA[]=round($key->Cantidad,2);            
            }
            $datosXOA=json_encode($valoresXOA);
            $datosYOA=json_encode($valoresYOA);

        
            foreach ($valorPZ as $key) {                                                
                $valoresXPZ[]=$key->Nombre;
                $valoresYPZ[]=round($key->Cantidad,2);            
            }
            $datosXPZ=json_encode($valoresXPZ);
            $datosYPZ=json_encode($valoresYPZ);

        
            foreach ($valorR1 as $key) {                                                
                $valoresXR1[]=$key->Nombre;
                $valoresYR1[]=round($key->Cantidad,2);            
            }
            $datosXR1=json_encode($valoresXR1);
            $datosYR1=json_encode($valoresYR1);
            
            foreach ($valorR2 as $key) {                                                
                $valoresXR2[]=$key->Nombre;
                $valoresYR2[]=round($key->Cantidad,2);            
            }
            $datosXR2=json_encode($valoresXR2);
            $datosYR2=json_encode($valoresYR2);

            foreach ($valorTZ as $key) {                                                
                $valoresXTZ[]=$key->Nombre;
                $valoresYTZ[]=round($key->Cantidad,2);            
            }
            $datosXTZ=json_encode($valoresXTZ);
            $datosYTZ=json_encode($valoresYTZ);
        //ASIGNACIÓN DE LOS VALORES PARA JSON MEDIANTE CICLOS    
    
        //ASIGNACIÓN DE LOS VALORES PARA LAS TABLAS SEGUN EL TIPO DE BUSQUEDA
            if($plaza_id==""){
                if($grupo_remesa_id==""){
                    if($insumo_gasto_remesa_id==""){                    
                        if($this->input->post("buscar")){
                            //Este método se carga en la pantalla principal al buscar realizar un análisis de una fecha en particular
                            //Para esta condición deben estar seleccionadas todas las plazas,todas las familias y ningun insumo
                            $unidades=$this->Mdl_remesas->getGastosGeneral($fechainicio,$fechainicio); 
                            $data=array
                            (
                                'unidades' => $unidades,
                                'fechainicio' => $fechainicio,
                                'fechafin' => $fechafin,                                
                                'plazas'   => $this->Mdl_plazas->getPlazas(),
                                'grupos' =>  $this->Mdl_remesas->getGrupos(),
                                'id_plaza'          => $plaza_id,
                                'fechaConsulta' => $fechainicio,
                                'id_familia'    => $grupo_remesa_id,
                                'ventas' =>$this->Mdl_depositos->getIngresosFecha($fechainicio,$fechainicio),
                                'datosXCA'=>$datosXCA,
                                'datosYCA'=>$datosYCA,
                                'datosXMA'=>$datosXMA,
                                'datosYMA'=>$datosYMA,    
                                'datosXOA'=>$datosXOA,
                                'datosYOA'=>$datosYOA,
                                'datosXPZ'=>$datosXPZ,
                                'datosYPZ'=>$datosYPZ,
                                'datosXR1'=>$datosXR1,
                                'datosYR1'=>$datosYR1,
                                'datosXR2'=>$datosXR2,
                                'datosYR2'=>$datosYR2,
                                'datosXTZ'=>$datosXTZ,
                                'datosYTZ'=>$datosYTZ,                                        
                                'fechaInicioG'=>$fechaInicioG,
                                'fechaFinG'=>$fechaFinG,
                                'nombreInsumo'=>$nombreInsumo,
                                'busquedaPlaza'=>$busquedaPlaza,
                                'tipos'       => $tipos,
                                'id_grafico' =>$id_grafico,
                                'acronimoCampo'=>$acronimoCampo
                            ); 
                        }
                        else if($this->input->post("buscarRango")){
                            //Este método se carga en la pantalla principal al buscar realizar un análisis por medio de rangos
                            //Para esta condición deben estar seleccionadas todas las plazas,todas las familias y ningun insumo
                            $unidades=$this->Mdl_remesas->getGastosGeneral($fechainicio,$fechafin); 
                            $data=array
                            (
                                'unidades' => $unidades,
                                'fechainicio' => $fechainicio,
                                'fechafin' => $fechafin,                                
                                'plazas'   => $this->Mdl_plazas->getPlazas(),
                                'grupos' =>  $this->Mdl_remesas->getGrupos(),
                                'id_plaza'          => $plaza_id,
                                'fechaConsulta' => $fechainicio."<br>".$fechafin,                                
                                'id_familia'    => $grupo_remesa_id,
                                'ventas' => $this->Mdl_depositos->getIngresosFechaRango($fechainicio,$fechafin),
                                'datosXCA'=>$datosXCA,
                                'datosYCA'=>$datosYCA,
                                'datosXMA'=>$datosXMA,
                                'datosYMA'=>$datosYMA,    
                                'datosXOA'=>$datosXOA,
                                'datosYOA'=>$datosYOA,
                                'datosXPZ'=>$datosXPZ,
                                'datosYPZ'=>$datosYPZ,
                                'datosXR1'=>$datosXR1,
                                'datosYR1'=>$datosYR1,
                                'datosXR2'=>$datosXR2,
                                'datosYR2'=>$datosYR2,
                                'datosXTZ'=>$datosXTZ,
                                'datosYTZ'=>$datosYTZ,
                                'fechaInicioG'=>$fechaInicioG,
                                'fechaFinG'=>$fechaFinG,
                                'nombreInsumo'=>$nombreInsumo,
                                'busquedaPlaza'=>$busquedaPlaza,
                                'tipos'=> $tipos,
                                'id_grafico' =>$id_grafico,
                                'acronimoCampo'=>$acronimoCampo
                            ); 
                        }
                        else{
                            //Este método se carga por defecto una vez que entramos a la aplicación, muestra los gastos
                            //realizados el día anterior, junto con los porcentajes sobre ventas igualmente del día anterior
                            $unidades=$this->Mdl_remesas->getGastosGeneral($fechaActual,$fechaActual); 
                            $data=array
                            (
                                'unidades' => $unidades,
                                'fechainicio' => $fechaActual,
                                'fechafin' => $fechaActual,
                                'plazas'   => $this->Mdl_plazas->getPlazas(),
                                'grupos' =>  $this->Mdl_remesas->getGrupos(),
                                'id_plaza'          => $plaza_id,
                                'fechaConsulta' => $fechaActual ,
                                'id_familia'          => $grupo_remesa_id,
                                'ventas' =>$this->Mdl_depositos->getIngresosFecha($fechaActual,$fechaActual),
                                'datosXCA'=>$datosXCA,
                                'datosYCA'=>$datosYCA,
                                'datosXMA'=>$datosXMA,
                                'datosYMA'=>$datosYMA,    
                                'datosXOA'=>$datosXOA,
                                'datosYOA'=>$datosYOA,
                                'datosXPZ'=>$datosXPZ,
                                'datosYPZ'=>$datosYPZ,
                                'datosXR1'=>$datosXR1,
                                'datosYR1'=>$datosYR1,
                                'datosXR2'=>$datosXR2,
                                'datosYR2'=>$datosYR2,
                                'datosXTZ'=>$datosXTZ,
                                'datosYTZ'=>$datosYTZ,
                                'fechaInicioG'=>$fechaInicioG,
                                'fechaFinG'=>$fechaFinG,
                                'nombreInsumo'=>$nombreInsumo,
                                'busquedaPlaza'=>$busquedaPlaza,
                                'tipos'=> $tipos,
                                'id_grafico' =>$id_grafico,
                                'acronimoCampo'=>$acronimoCampo
                            ); 
                        }                   
                    }                
                }
                else{
                    if($insumo_gasto_remesa_id==""){
                        if($this->input->post("buscar")){
                            //Este método se utiliza para hacer una busqueda normal de una familia sin insumo para solo un día
                            //Todas las plazas seleccionadas                        
                            $remesasFP=$this->Mdl_remesas->getGastosFechaGrupo($fechainicio,$fechainicio,$grupo_remesa_id);                                                                               
                            $data=
                            array
                            (
                                'remesasFP' => $remesasFP,
                                'fechainicio' => $fechainicio,
                                'fechafin' => $fechainicio,
                                'plazas'   => $this->Mdl_plazas->getPlazas(),
                                'grupos' =>  $this->Mdl_remesas->getGrupos(),
                                'id_plaza' => $plaza_id,
                                'fechaConsulta' => $fechainicio,
                                'id_familia'          => $grupo_remesa_id,
                                'insumos' => $this->Mdl_remesas->getInsumosID($grupo_remesa_id),
                                "id_insumo" => $insumo_gasto_remesa_id,                                                                    
                                'datosXCA'=>$datosXCA,
                                'datosYCA'=>$datosYCA,
                                'datosXMA'=>$datosXMA,
                                'datosYMA'=>$datosYMA,    
                                'datosXOA'=>$datosXOA,
                                'datosYOA'=>$datosYOA,
                                'datosXPZ'=>$datosXPZ,
                                'datosYPZ'=>$datosYPZ,
                                'datosXR1'=>$datosXR1,
                                'datosYR1'=>$datosYR1,
                                'datosXR2'=>$datosXR2,
                                'datosYR2'=>$datosYR2,
                                'datosXTZ'=>$datosXTZ,
                                'datosYTZ'=>$datosYTZ,
                                'fechaInicioG'=>$fechaInicioG,
                                'fechaFinG'=>$fechaFinG,
                                'nombreInsumo'=>$nombreInsumo,
                                'busquedaPlaza'=>$busquedaPlaza,
                                'tipos'=> $tipos,
                                'id_grafico' =>$id_grafico,
                                'acronimoCampo'=>$acronimoCampo
                            );                    
                        }
                        else if($this->input->post("buscarRango")){
                            //Este método se utiliza para hacer una busqueda por rangos todas las plazas con una familia seleccionadad, sin insumo
                            //realizados el día anterior, junto con los porcentajes sobre ventas igualmente del día anterior
                            $remesasFP=$this->Mdl_remesas->getGastosFechaGrupo($fechainicio,$fechafin,$grupo_remesa_id);                                                                               
                            $data=
                            array
                            (
                                'remesasFP' => $remesasFP,
                                'fechainicio' => $fechainicio,
                                'fechafin' => $fechafin,
                                'plazas'   => $this->Mdl_plazas->getPlazas(),
                                'grupos' =>  $this->Mdl_remesas->getGrupos(),
                                'id_familia'          => $grupo_remesa_id,
                                'insumos' => $this->Mdl_remesas->getInsumosID($grupo_remesa_id),
                                "id_insumo" => $insumo_gasto_remesa_id,    
                                'id_plaza' => $plaza_id  ,
                                'fechaConsulta' => $fechainicio."<br>".$fechafin,
                                'datosXCA'=>$datosXCA,
                                'datosYCA'=>$datosYCA,
                                'datosXMA'=>$datosXMA,
                                'datosYMA'=>$datosYMA,    
                                'datosXOA'=>$datosXOA,
                                'datosYOA'=>$datosYOA,
                                'datosXPZ'=>$datosXPZ,
                                'datosYPZ'=>$datosYPZ,
                                'datosXR1'=>$datosXR1,
                                'datosYR1'=>$datosYR1,
                                'datosXR2'=>$datosXR2,
                                'datosYR2'=>$datosYR2,
                                'datosXTZ'=>$datosXTZ,
                                'datosYTZ'=>$datosYTZ,
                                'fechaInicioG'=>$fechaInicioG,
                                'fechaFinG'=>$fechaFinG,
                                'nombreInsumo'=>$nombreInsumo,
                                'busquedaPlaza'=>$busquedaPlaza,
                                'tipos'=> $tipos,
                                'id_grafico' =>$id_grafico,
                                'acronimoCampo'=>$acronimoCampo
                            ); 
                        }
                    }
                    else{
                        if($this->input->post("buscar")){
                            //Este método se utiliza para hacer una busqueda cuando son todas las plazas, familia seleccionada e insumo seleccionado
                            //Todas las plazas seleccionadas     
                            $remesasFP2=$this->Mdl_remesas->getGastosFechaGrupoInsumo($fechainicio,$fechainicio,$insumo_gasto_remesa_id);                                                                               
                            $data=
                            array
                            (
                                'remesasFP2' => $remesasFP2,
                                'fechainicio' => $fechainicio,
                                'plazas'   => $this->Mdl_plazas->getPlazas(),
                                'grupos' =>  $this->Mdl_remesas->getGrupos(),
                                'id_familia'          => $grupo_remesa_id,
                                'insumos' => $this->Mdl_remesas->getInsumosID($grupo_remesa_id),
                                "id_insumo" => $insumo_gasto_remesa_id,                        
                                'id_plaza' => $plaza_id  ,
                                'fechaConsulta' => $fechainicio,
                                'datosXCA'=>$datosXCA,
                                'datosYCA'=>$datosYCA,
                                'datosXMA'=>$datosXMA,
                                'datosYMA'=>$datosYMA,    
                                'datosXOA'=>$datosXOA,
                                'datosYOA'=>$datosYOA,
                                'datosXPZ'=>$datosXPZ,
                                'datosYPZ'=>$datosYPZ,
                                'datosXR1'=>$datosXR1,
                                'datosYR1'=>$datosYR1,
                                'datosXR2'=>$datosXR2,
                                'datosYR2'=>$datosYR2,
                                'datosXTZ'=>$datosXTZ,
                                'datosYTZ'=>$datosYTZ,
                                'fechaInicioG'=>$fechaInicioG,
                                'fechaFinG'=>$fechaFinG,
                                'nombreInsumo'=>$nombreInsumo,
                                'busquedaPlaza'=>$busquedaPlaza,
                                'tipos'=> $tipos,
                                'id_grafico' =>$id_grafico,
                                'acronimoCampo'=>$acronimoCampo
                            );
                        }   
                        else if($this->input->post("buscarRango")){
                            //Este método se utiliza para hacer una busqueda cuando son todas las plazas, familia seleccionada e insumo seleccionado
                            // Busqueda en rango
                            //Todas las plazas seleccionadas 
                            $remesasFP2=$this->Mdl_remesas->getGastosFechaGrupoInsumo($fechainicio,$fechafin,$insumo_gasto_remesa_id);                                                                               
                            $data=array
                            (
                                'remesasFP2' => $remesasFP2,
                                'fechainicio' => $fechainicio,
                                'fechafin' => $fechafin,
                                'plazas'   => $this->Mdl_plazas->getPlazas(),
                                'grupos' =>  $this->Mdl_remesas->getGrupos(),
                                'id_familia'          => $grupo_remesa_id,
                                'insumos' => $this->Mdl_remesas->getInsumosID($grupo_remesa_id),
                                "id_insumo" => $insumo_gasto_remesa_id,    
                                'id_plaza' => $plaza_id  ,
                                'fechaConsulta' => $fechainicio."<br>".$fechafin,
                                'datosXCA'=>$datosXCA,
                                'datosYCA'=>$datosYCA,
                                'datosXMA'=>$datosXMA,
                                'datosYMA'=>$datosYMA,    
                                'datosXOA'=>$datosXOA,
                                'datosYOA'=>$datosYOA,
                                'datosXPZ'=>$datosXPZ,
                                'datosYPZ'=>$datosYPZ,
                                'datosXR1'=>$datosXR1,
                                'datosYR1'=>$datosYR1,
                                'datosXR2'=>$datosXR2,
                                'datosYR2'=>$datosYR2,
                                'datosXTZ'=>$datosXTZ,
                                'datosYTZ'=>$datosYTZ,
                                'fechaInicioG'=>$fechaInicioG,
                                'fechaFinG'=>$fechaFinG,
                                'nombreInsumo'=>$nombreInsumo,
                                'busquedaPlaza'=>$busquedaPlaza,
                                'tipos'=> $tipos,
                                'id_grafico' =>$id_grafico,
                                'acronimoCampo'=>$acronimoCampo
                            ); 
                        }                        
                    }                 
                }                                                       
            }
            else{
                if($grupo_remesa_id==""){
                    if($this->input->post("buscar")){
                        //Este método se carga por defecto una vez que entramos a la aplicación, muestra los gastos
                        //realizados el día anterior, junto con los porcentajes sobre ventas igualmente del día anterior
                        //SOLO PARA UNA PLAZA
                        $unidadesP=$this->Mdl_remesas->getGastosGeneralPlaza($fechainicio,$fechainicio,$plaza_id); 
                        $data=array
                        (
                            'unidadesP' => $unidadesP,
                            'fechainicio' => $fechainicio,
                            'fechafin' =>$fechainicio,
                            'plazas'   => $this->Mdl_plazas->getPlazas(),
                            'grupos' =>  $this->Mdl_remesas->getGrupos(),
                            'fechaConsulta' => $fechainicio ,
                            'id_familia'          => $grupo_remesa_id,
                            'id_plaza' => $plaza_id  , 
                            'nombrePlaza'=>$nombrePlaza,                       
                            'ventas' =>$this->Mdl_depositos->getIngresosFechaPlaza($fechainicio,$fechainicio,$plaza_id),
                            'datosXGenerico'=>$datosXGenerico,
                            'datosYGenerico'=>$datosYGenerico,
                            'fechaInicioG'=>$fechaInicioG,
                            'fechaFinG'=>$fechaFinG,
                            'nombreInsumo'=>$nombreInsumo,
                            'busquedaPlaza'=>$busquedaPlaza,
                            'tipos'=> $tipos,
                            'id_grafico' =>$id_grafico,
                            'acronimoCampo'=>$acronimoCampo
                        );  
                    }
                    else if($this->input->post("buscarRango")){
                        //Este método se carga por defecto una vez que entramos a la aplicación, muestra los gastos
                        //realizados el día anterior, junto con los porcentajes sobre ventas igualmente del día anterior
                        //SOLO PARA UNA PLAZA
                        $unidadesP=$this->Mdl_remesas->getGastosGeneralPlaza($fechainicio,$fechafin,$plaza_id); 
                        $data=array
                        (
                            'unidadesP' => $unidadesP,
                            'fechainicio' => $fechainicio,
                            'fechafin' => $fechafin,
                            'plazas'   => $this->Mdl_plazas->getPlazas(),
                            'grupos' =>  $this->Mdl_remesas->getGrupos(),                            
                            'id_familia'          => $grupo_remesa_id,
                            'id_plaza' => $plaza_id  ,  
                            'nombrePlaza'=>$nombrePlaza,
                            'ventas' => $this->Mdl_depositos->getIngresosFechaRangoPlaza($fechainicio,$fechafin,$plaza_id),
                            'fechaConsulta' => $fechainicio."<br>".$fechafin,
                            'datosXGenerico'=>$datosXGenerico,
                            'datosYGenerico'=>$datosYGenerico,
                            'fechaInicioG'=>$fechaInicioG,
                            'fechaFinG'=>$fechaFinG,
                            'nombreInsumo'=>$nombreInsumo,
                            'busquedaPlaza'=>$busquedaPlaza,
                            'tipos'=> $tipos,
                            'id_grafico' =>$id_grafico,
                            'acronimoCampo'=>$acronimoCampo
                        );  
                    }                         
                }
                else{
                    if($insumo_gasto_remesa_id==""){
                        if($this->input->post("buscar")){
                            //Este método se utiliza para hacer una busqueda normal de una familia sin insumo para solo un día
                            //SOLO UNA PLAZA SELECCIONADA                       
                            $remesasFP=$this->Mdl_remesas->getGastosFechaGrupoPlaza($fechainicio,$fechainicio,$grupo_remesa_id,$plaza_id);                                                                               
                            $data=array
                            (
                                'remesasFP' => $remesasFP,
                                'fechainicio' => $fechainicio,
                                'fechafin' => $fechafin,
                                'plazas'   => $this->Mdl_plazas->getPlazas(),
                                'grupos' =>  $this->Mdl_remesas->getGrupos(),
                                'id_familia'          => $grupo_remesa_id,
                                'insumos' => $this->Mdl_remesas->getInsumosID($grupo_remesa_id),
                                "id_insumo" => $insumo_gasto_remesa_id,    
                                'id_plaza' => $plaza_id,
                                'nombrePlaza'=>$nombrePlaza,  
                                'fechaConsulta' => $fechainicio,
                                'datosXGenerico'=>$datosXGenerico,
                                'datosYGenerico'=>$datosYGenerico,
                                'fechaInicioG'=>$fechaInicioG,
                                'fechaFinG'=>$fechaFinG,
                                'nombreInsumo'=>$nombreInsumo,
                                'busquedaPlaza'=>$busquedaPlaza,
                                'tipos'=> $tipos,
                                'id_grafico' =>$id_grafico,
                                'acronimoCampo'=>$acronimoCampo
                            );     
                        }
                        else if($this->input->post("buscarRango")){
                            //Este método se utiliza para hacer una busqueda en rango de una familia sin insumo para solo un día
                            //SOLO UNA PLAZA SELECCIONADA     
                            $remesasFP=$this->Mdl_remesas->getGastosFechaGrupoPlaza($fechainicio,$fechafin,$grupo_remesa_id,$plaza_id);                                                                               
                            $data=array
                            (
                                'remesasFP' => $remesasFP,
                                'fechainicio' => $fechainicio,
                                'fechafin' => $fechafin,
                                'plazas'   => $this->Mdl_plazas->getPlazas(),
                                'grupos' =>  $this->Mdl_remesas->getGrupos(),
                                'id_familia'          => $grupo_remesa_id,
                                'insumos' => $this->Mdl_remesas->getInsumosID($grupo_remesa_id),
                                "id_insumo" => $insumo_gasto_remesa_id,    
                                'id_plaza' => $plaza_id,
                                'nombrePlaza'=>$nombrePlaza,  
                                'fechaConsulta' => $fechainicio."<br>".$fechafin,
                                'datosXGenerico'=>$datosXGenerico,
                                'datosYGenerico'=>$datosYGenerico,
                                'fechaInicioG'=>$fechaInicioG,
                                'fechaFinG'=>$fechaFinG,
                                'nombreInsumo'=>$nombreInsumo,
                                'busquedaPlaza'=>$busquedaPlaza,
                                'tipos'=> $tipos,
                                'id_grafico' =>$id_grafico,
                                'acronimoCampo'=>$acronimoCampo
                            );          
                        }
                    }
                    else{                        
                        if($this->input->post("buscar")){
                            //Este método se utiliza para hacer una busqueda normal de una familia con insumo para solo un día
                            //UNA PLAZA SELECCIONADA                                                      
                            $remesasFP2=$this->Mdl_remesas->getGastosFechaGrupoInsumoPlaza($fechainicio,$fechainicio,$plaza_id,$insumo_gasto_remesa_id);                                                                               
                            $data=array
                            (
                                'remesasFP2' => $remesasFP2,
                                'fechainicio' => $fechainicio,
                                'plazas'   => $this->Mdl_plazas->getPlazas(),
                                'grupos' =>  $this->Mdl_remesas->getGrupos(),
                                'id_familia'          => $grupo_remesa_id,
                                'insumos' => $this->Mdl_remesas->getInsumosID($grupo_remesa_id),
                                "id_insumo" => $insumo_gasto_remesa_id,    
                                'id_plaza' => $plaza_id,
                                'nombrePlaza'=>$nombrePlaza,  
                                'fechaConsulta' => $fechainicio,
                                'datosXGenerico'=>$datosXGenerico,
                                'datosYGenerico'=>$datosYGenerico,
                                'fechaInicioG'=>$fechaInicioG,
                                'fechaFinG'=>$fechaFinG,
                                'nombreInsumo'=>$nombreInsumo,
                                'busquedaPlaza'=>$busquedaPlaza,
                                'tipos'=> $tipos,
                                'id_grafico' =>$id_grafico,
                                'acronimoCampo'=>$acronimoCampo
                            );  
                        }
                        else if($this->input->post("buscarRango")){
                            //Este método se utiliza para hacer una busqueda normal de una familia con insumo para un rango de días
                            //UNA PLAZA SELECCIONADA                                                      
                            $remesasFP2=$this->Mdl_remesas->getGastosFechaGrupoInsumoPlaza($fechainicio,$fechafin,$plaza_id,$insumo_gasto_remesa_id);                                                                               
                            $data=
                            array
                            (
                                'remesasFP2' => $remesasFP2,
                                'fechainicio' => $fechainicio,
                                'fechafin' => $fechafin,
                                'plazas'   => $this->Mdl_plazas->getPlazas(),
                                'grupos' =>  $this->Mdl_remesas->getGrupos(),
                                'id_familia'          => $grupo_remesa_id,
                                'insumos' => $this->Mdl_remesas->getInsumosID($grupo_remesa_id),
                                "id_insumo" => $insumo_gasto_remesa_id,    
                                'id_plaza' => $plaza_id,
                                'nombrePlaza'=>$nombrePlaza,  
                                'fechaConsulta' => $fechainicio."<br>".$fechafin,
                                'datosXGenerico'=>$datosXGenerico,
                                'datosYGenerico'=>$datosYGenerico,
                                'fechaInicioG'=>$fechaInicioG,
                                'fechaFinG'=>$fechaFinG,
                                'nombreInsumo'=>$nombreInsumo,
                                'busquedaPlaza'=>$busquedaPlaza,
                                'tipos'=> $tipos,
                                'id_grafico' =>$id_grafico,
                                'acronimoCampo'=>$acronimoCampo
                            );          
                        }
                    }                        
                }                                                    
            }
        //ASIGNACIÓN DE LOS VALORES PARA LAS TABLAS SEGUN EL TIPO DE BUSQUEDA

         $this->load->view("layouts/header");
         $this->load->view("layouts/aside");
         $this->load->view("administrador/remesas/analisis_remesas",$data);
         $this->load->view("layouts/footer");
    }

    public function consultarInsumo()
    {   
        if($this->input->is_ajax_request()){
            if($this->input->post('grupo_id'))
            {
                echo $this->Mdl_remesas->getInsumoGastoID($this->input->post('grupo_id'));
            }
        }   
        else{
                redirect(base_url()."Inicio");
          }                        
    }

    public function consultarUnidad()
    { 
        if($this->input->is_ajax_request()){
            if($this->input->post('insumo_gasto_id'))
            {
                $igid=$this->input->post('insumo_gasto_id');                       
                $unidad=$this->Mdl_productos->getUnidadID($igid); 
                $valor=$unidad->unidad_id;         
                echo $this->Mdl_productos->getUnidadesID($valor);
            }
        }   
        else{
                redirect(base_url()."Inicio");
          }                  
    }

    public function consultarGastoModal()
    {
       if($this->input->is_ajax_request())
       {            
            $fecha=$this->input->post('fecha');    
            $plaza_id=$this->input->post('plaza_id');                
            echo json_encode($this->Mdl_remesas->getGastosModalAPI($fecha,$plaza_id));
        }   
        else
        {
            redirect(base_url()."Inicio");
        }															
    }

    public function consultarGastoModalAdmin()
    {
       if($this->input->is_ajax_request())
       {            
            $fecha=$this->input->post('fecha');    
            $plaza_id=$this->input->post('plaza_id');                
            echo json_encode($this->Mdl_remesas->getGastosModalAPIAdmin($fecha,$plaza_id));
        }   
        else
        {
            redirect(base_url()."Inicio");
        }															
    }
    
    public function consultarGastoFamiliaModal()
    {
        if($this->input->is_ajax_request()){
                
                $fechainicio=$this->input->post('fechainicio');    
                $fechafin=$this->input->post('fechafin');
                $familia_id=$this->input->post('familia_id');
                $plaza_id=$this->input->post('plaza_id');

                echo json_encode($this->Mdl_remesas->getGastosModalFamiliaAPI($fechainicio,$fechafin,$plaza_id,$familia_id));
            }   
        else{
                redirect(base_url()."Inicio");
            }															
    }

    public function consultarGastoFamiliaModalDesglose()
    {
        if($this->input->is_ajax_request()){
                
                $fechainicio=$this->input->post('fechainicio');    
                $fechafin=$this->input->post('fechafin');
                $familia_id=$this->input->post('familia_id');
                $plaza_id=$this->input->post('plaza_id');
                $insumo_id=$this->input->post('insumo_id');


                echo json_encode($this->Mdl_remesas->getGastosModalDesgloseFamiliaAPI($fechainicio,$fechafin,$plaza_id,$familia_id,$insumo_id));
            }   
        else{
                redirect(base_url()."Inicio");
            }															
    }
    
    public function consultarGastoModalRango()
    {
        if($this->input->is_ajax_request()){
            
            $fechainicio=$this->input->post('fechainicio');
            $fechafin=$this->input->post('fechafin');            
            $plaza_id=$this->input->post('plaza_id');    
            
            echo json_encode($this->Mdl_remesas->getGastosModalRango($fechainicio,$fechafin,$plaza_id));
        }   
        else{
                redirect(base_url()."Inicio");
            }															
    }

    private function consultarCantidad($id,$plaza_id)
    {
        $reportes=$this->Mdl_inventario->getCantidad($id,$plaza_id); 
        if($reportes!=false){
            return $reportes->Cantidad;        
        }           
    }

    public function deleteAdmin(){
        if($this->input->is_ajax_request()){             
            $id=$this->input->post("id");
            $usuario_id=$this->input->post("usuario_id");
            $plaza_id=$this->input->post("plaza_id");
            $insumo_gasto_id=$this->input->post("insumo_gasto_id");
            $cantidad=$this->input->post("cantidad");	

            $nombresArchivos=$this->Mdl_remesas->getNombresArchivos($id);            
            $folioArchivos=$nombresArchivos->Folio;
            $nombresArchivos=$nombresArchivos->Archivos;            
            $nombresArchivos=explode(',',$nombresArchivos);               

                                
            $insumoV=$this->insumoReal($insumo_gasto_id);                
            if($insumoV!=116){
                $valorA=$this->consultarCantidad($insumoV,$plaza_id);	
                $valorB=$valorA-$cantidad;
                $data = array('Cantidad' => $valorB);
                if($this->Mdl_inventario->actualizarCantidad($insumoV,$plaza_id,$data)){
                    $this->Mdl_remesas->delete($id);
                    $data=
                    array(
                        'usuario_id'=>$usuario_id,
                        'plaza_id'=>$plaza_id,                            
                        'Tipo_Movimiento'=>"Gasto Restado",
                        'insumo_id'=>$insumoV,                            
                        "Nueva_Cantidad" => $valorB,
                        "Antigua_Cantidad" =>$valorA,
                        "Fecha"=>date("Y-m-d")
                    );
                    if($this->Mdl_inventario->actualizarMovimiento($data)){
                        //VAMOS A BUSCAR LAS IMAGENES EN LA CARPETA PARA POSTERIORMENTE ELIMINARLAS
                        $folio_archivo=$folioArchivos;
                        $ruta="./assets/remesas/".$folio_archivo."/";
                        $this->eliminarArchivos($ruta,$folio_archivo);                                                                                                        
                        echo 1;                                                                                            
                    }
                    else{
                        echo 0;
                    }        
                }
            
            }
            else{
                if($this->Mdl_remesas->delete($id)){                    
                    $folio_archivo=$folioArchivos;
                    $ruta="./assets/remesas/".$folio_archivo."/";
                    $this->eliminarArchivos($ruta,$folio_archivo);                                                                                                        
                    echo 1;
                }else{
                    echo 0;
                }
                
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
             $usuario_id=$this->input->post("usuario_id");
             $plaza_id=$this->input->post("plaza_id");
             $insumo_gasto_id=$this->input->post("insumo_gasto_id");
             $cantidad=$this->input->post("cantidad");	             
             $insumoV=$this->insumoReal($insumo_gasto_id);  
             $fecha=$this->input->post("fecha");
             
             $nuevoTotal=0;
             $nuevoTotalAdmin=0;
             $acumuladoTotal=0;

             if($insumoV!=116){
                 $valorA=$this->consultarCantidad($insumoV,$plaza_id);	
                 $valorB=$valorA-$cantidad;
                 $data = array('Cantidad' => $valorB);
                 if($this->Mdl_inventario->actualizarCantidad($insumoV,$plaza_id,$data)){
                     $this->Mdl_remesas->delete($id);
                     $data=
                     array(
                         'usuario_id'=>$usuario_id,
                         'plaza_id'=>$plaza_id,                            
                         'Tipo_Movimiento'=>"Gasto Restado",
                         'insumo_id'=>$insumoV,                            
                         "Nueva_Cantidad" => $valorB,
                         "Antigua_Cantidad" =>$valorA,
                         "Fecha"=>date("Y-m-d")
                     );
                     if($this->Mdl_inventario->actualizarMovimiento($data)){
                        $reportes=$this->Mdl_remesas->getGastosVentas($fecha,$plaza_id); 
                        $reportes2=$this->Mdl_remesas->getGastosVentasAdmin($fecha,$plaza_id);
                        if($reportes!=null && $reportes2!=null ){
                            
                            $nuevoTotal=$reportes->Importe;
                            $nuevoTotalAdmin=$reportes2->Importe;
                            $acumuladoTotal=$nuevoTotal+$nuevoTotalAdmin; 
    
                            $totalIngresos=$this->Mdl_ventas->getTotalIngresos($fecha,$plaza_id);                                                            
                            $totalIngresos=$totalIngresos->Total;
    
                            $totalTPV=$this->Mdl_ventas->getTotalTPV($fecha,$plaza_id);                                                            
                            $totalTPV=$totalTPV->Total;
    
                            $nuevoEfectivo=($totalIngresos-$nuevoTotal)-$totalTPV;
    
                            $data=array('Gastos'=>$nuevoTotal,'Gastos_Admin'=>$nuevoTotalAdmin,'Total_Gastos'=>$acumuladoTotal,"Efectivo_Real"=>$nuevoEfectivo);
                            if($this->Mdl_ventas->actualizarGastos($fecha,$plaza_id,$data)){
                                echo 1;                                                                
                            }else{
                                echo 0;
                            }     
                        }else{
                            echo 0;
                        }  
                         //echo 1;
                     }
                     else{
                         echo 0;
                     }        
                 }
             
             }
             else{
                 if($this->Mdl_remesas->delete($id)){
                    $reportes=$this->Mdl_remesas->getGastosVentas($fecha,$plaza_id); 
                    $reportes2=$this->Mdl_remesas->getGastosVentasAdmin($fecha,$plaza_id);
                    if($reportes!=null && $reportes2!=null ){
                        
                        $nuevoTotal=$reportes->Importe;
                        $nuevoTotalAdmin=$reportes2->Importe;
                        $acumuladoTotal=$nuevoTotal+$nuevoTotalAdmin; 

                        $totalIngresos=$this->Mdl_ventas->getTotalIngresos($fecha,$plaza_id);                                                            
                        $totalIngresos=$totalIngresos->Total;

                        $totalTPV=$this->Mdl_ventas->getTotalTPV($fecha,$plaza_id);                                                            
                        $totalTPV=$totalTPV->Total;

                        $nuevoEfectivo=($totalIngresos-$nuevoTotal)-$totalTPV;

                        $data=array('Gastos'=>$nuevoTotal,'Gastos_Admin'=>$nuevoTotalAdmin,'Total_Gastos'=>$acumuladoTotal,"Efectivo_Real"=>$nuevoEfectivo);
                        if($this->Mdl_ventas->actualizarGastos($fecha,$plaza_id,$data)){
                            echo 1;                                                                
                        }else{
                            echo 0;
                        }     
                    }else{
                        echo 0;
                    } 
                 }else{
                     echo 0;
                 }                 
             }            
        }   
        else{
                redirect(base_url()."Inicio");
          }                               
    }   
    
    public function insumosGastos()
    {
        $data=array(
            'remesas' => $this->Mdl_remesas->getInsumosGastos()         
		);
        
        $this->load->view("layouts/header");
	    $this->load->view("layouts/aside");
		$this->load->view("manager/reportes/remesas/list_insumos",$data);
        $this->load->view("layouts/footer");   
    }

    private function insumoReal($insumo_gasto_id)
    {
        $reportes=$this->Mdl_remesas->getInsumoReal($insumo_gasto_id);   
        if($reportes!=false){
            return $reportes->insumo_id;
        } 
    }

    public function listRemesasGenerales()
	{
        $plaza_id=$this->input->post("plaza_id"); 
        $fechainicio=$this->input->post("fechaInicioD"); 
        $fechafin=$this->input->post("fechaFinD"); 
        $insumo_gasto_remesa_id=$this->input->post("insumo_gasto_remesa_id");
        $grupo_remesa_id=$this->input->post("grupo_remesa_id");
      
        
        if($this->input->post("buscar")){
            if($plaza_id==""){

                if($fechainicio==date("Y-m-d")){
                    $data=array(
                        'gastos' => $this->Mdl_remesas->getListGastosFecha(date("Y-m-d")),
                        'plazas'  =>   $this->Mdl_plazas->getPlazas(),
                        'mensaje'=> "Remesas del día: ".date("Y-m-d"),
                        'fechaConsulta' => $fechainicio,
                        'fechainicio' => $fechainicio,
                        "fecha"=>date("Y-m-d"),
                        'id' => $plaza_id         
                    );  
                }
                else{

                    $data=array(
                        'gastosPasados' => $this->Mdl_remesas->getListGastosFecha2($fechainicio),
                        'fechaConsulta' => $fechainicio,
                        'fechainicio' => $fechainicio,
                        'plazas'  =>   $this->Mdl_plazas->getPlazas(),
                        'id' => $plaza_id,    
                        "fecha"=>date("Y-m-d"),                
                        'mensaje'=> "Remesas del día: ".$fechainicio    
                    ); 

                }
                
            }      
            else{
                if($fechainicio==date("Y-m-d")){                   
                    $data=array(
                        'gastos' => $this->Mdl_remesas->getListGastosFechaPlaza(date("Y-m-d"),$plaza_id),
                        'plazas'  =>   $this->Mdl_plazas->getPlazas(),
                        'mensaje'=> "Remesas del día: ".date("Y-m-d"),
                        'fechaConsulta' => $fechainicio,
                        'fechainicio' => $fechainicio,
                        "fecha"=>date("Y-m-d"),
                        'id' => $plaza_id         
                    ); 

                }else{

                    $data=array(
                        'gastosPasados' => $this->Mdl_remesas->getListGastosFechaPlaza2($fechainicio,$plaza_id),
                        'fechaConsulta' => $fechainicio,
                        'fechainicio' => $fechainicio,
                        'plazas'  =>   $this->Mdl_plazas->getPlazas(),
                        'id' => $plaza_id,
                        "fecha"=>date("Y-m-d"),
                        'mensaje'=> "Remesas del día: ".$fechainicio
                    ); 
                    
                }  
            }                 
        }        
        else{
            $data=array(
                'gastos' => $this->Mdl_remesas->getListGastosFecha(date("Y-m-d")),
                'plazas'  =>   $this->Mdl_plazas->getPlazas(),
                'mensaje'=> "Remesas del día: ".date("Y-m-d"),
                "fecha"=>date("Y-m-d"),
                'id' => $plaza_id         
            );   
        } 
        $this->load->view("layouts/header");
	    $this->load->view("layouts/aside");
		$this->load->view("administrador/remesas/list_remesas_generales",$data);
        $this->load->view("layouts/footer");                 
    }

    public function store()
	{
        if($this->input->is_ajax_request()){
            
            $usuario_id=$this->input->post("usuario_id");
            $insumo_gasto_id=$this->input->post("insumo_gasto_id");
            $cantidad=$this->input->post("cantidad");
            $importe=$this->input->post("importe");
            $plaza_id=$this->input->post("plaza_id");
            $notas=$this->input->post("notas");

            $this->form_validation->set_rules("usuario_id","usuario_id","required");		
            $this->form_validation->set_rules("insumo_gasto_id","insumo_gasto_id","required");
            $this->form_validation->set_rules("cantidad","cantidad","required");
            $this->form_validation->set_rules("importe","importe","required");		
            $this->form_validation->set_rules("plaza_id","plaza_id","required");

            if($this->form_validation->run()){              
                $consultarBandera=$this->Mdl_remesas->getBanderaInsumo($insumo_gasto_id);
                if($consultarBandera!=null){
                    $consultarBandera=$consultarBandera->Bandera;                    
                    if($consultarBandera==1){                                                                           
                        //AREA EN DONDE SE CONSULTAN LOS MINIMOS Y MAXIMOS
                            $consultarMinimo=$this->Mdl_remesas->getMinimoInsumo($insumo_gasto_id);
                            if($consultarMinimo!=null){
                                $consultarMinimo=$consultarMinimo->Minimo;
                            }    
                            
                            $consultarMaximo=$this->Mdl_remesas->getMaximoInsumo($insumo_gasto_id);
                            if($consultarMaximo!=null){
                                $consultarMaximo=$consultarMaximo->Maximo;
                            }
                        //AREA EN DONDE SE CONSULTAN LOS MINIMOS Y MAXIMOS

                        if($cantidad>=$consultarMinimo && $cantidad<=$consultarMaximo){
                            //CODIGO BASE O PRINCIPAL
                                if($cantidad > 0 && $importe>0){                    
                        
                                    $insumoV=$this->insumoReal($insumo_gasto_id);
                                    if($insumoV<116){
                                    $valorA=$this->consultarCantidad($insumoV,$plaza_id);	
                                    $valorB=0;
                                    $total=0;
                                    $valorB=$valorA+$cantidad;                                         
                                    $data=
                                    array(
                                            'usuario_id'=>$usuario_id,
                                            'plaza_id' =>$plaza_id,
                                            "insumo_gasto_id"=>$insumo_gasto_id,
                                            'unidad_pago_id'=>1,
                                            "Cantidad"=>$cantidad,
                                            'Importe'=>$importe,                        
                                            "Modificacion"=>1,
                                            "Nueva_Cantidad" => $valorB,
                                            "Antigua_Cantidad" =>$valorA,
                                            "Fecha"=>date("Y-m-d"),
                                            "Estado" => 1,
                                            "Notas"=>$notas
                                        );
                                    if($this->Mdl_remesas->save($data)){  
                                        $data = array('Cantidad' => $valorB);                                  
                                        if($this->Mdl_inventario->actualizarCantidad($insumoV,$plaza_id,$data)){
                                            $data=
                                            array(
                                                'usuario_id'=>$usuario_id,
                                                'plaza_id'=>$plaza_id,                            
                                                'Tipo_Movimiento'=>"GASTO",
                                                'insumo_id'=>$insumoV,                            
                                                "Nueva_Cantidad" => $valorB,
                                                "Antigua_Cantidad" =>$valorA,
                                                "Fecha"=>date("Y-m-d")
                                            );
                                            if($this->Mdl_inventario->actualizarMovimiento($data)){
                                                echo 1;
                                            }
                                            
                                        }                                    
                                    }
                                    else{
                                        $this->session->set_flashdata("error","No se pudo guardar la información");
                                        echo 0;
                                    
                                    }
                                }  
                                else{                                                
                                    $data=
                                    array(
                                            'usuario_id'=>$usuario_id,
                                            'plaza_id'=>$plaza_id,
                                            "insumo_gasto_id"=>$insumo_gasto_id,
                                            'unidad_pago_id'=>1,
                                            "Cantidad"=>$cantidad,
                                            'Importe'=>$importe,					                        
                                            "Modificacion"=>0,
                                            "Nueva_Cantidad" => 0,
                                            "Antigua_Cantidad" =>0,
                                            "Fecha"=>date("Y-m-d"),
                                            "Estado" => 1,
                                            "Notas"=>$notas
                                        );   
                                    if($this->Mdl_remesas->save($data)){  
                                            echo 1;                                                        
                                    }
                                    else{
                                        $this->session->set_flashdata("error","No se pudo guardar la información");
                                        echo 0;
                                    
                                    }
                                }
                                }
                                else{
                                    echo 2;
                                }
                            //CODIGO BASE O PRINCIPAL
                        }
                        else{
                            echo 3;
                        }                        
                    }else{
                        //CODIGO BASE O PRINCIPAL
                            if($cantidad > 0 && $importe>0){                    
                    
                                $insumoV=$this->insumoReal($insumo_gasto_id);
                                if($insumoV<116){
                                $valorA=$this->consultarCantidad($insumoV,$plaza_id);	
                                $valorB=0;
                                $total=0;
                                $valorB=$valorA+$cantidad;                                         
                                $data=
                                array(
                                        'usuario_id'=>$usuario_id,
                                        'plaza_id' =>$plaza_id,
                                        "insumo_gasto_id"=>$insumo_gasto_id,
                                        'unidad_pago_id'=>1,
                                        "Cantidad"=>$cantidad,
                                        'Importe'=>$importe,                        
                                        "Modificacion"=>1,
                                        "Nueva_Cantidad" => $valorB,
                                        "Antigua_Cantidad" =>$valorA,
                                        "Fecha"=>date("Y-m-d"),
                                        "Estado" => 1,
                                        "Notas"=>$notas
                                    );
                                if($this->Mdl_remesas->save($data)){  
                                    $data = array('Cantidad' => $valorB);                                  
                                    if($this->Mdl_inventario->actualizarCantidad($insumoV,$plaza_id,$data)){
                                        $data=
                                        array(
                                            'usuario_id'=>$usuario_id,
                                            'plaza_id'=>$plaza_id,                            
                                            'Tipo_Movimiento'=>"GASTO",
                                            'insumo_id'=>$insumoV,                            
                                            "Nueva_Cantidad" => $valorB,
                                            "Antigua_Cantidad" =>$valorA,
                                            "Fecha"=>date("Y-m-d")
                                        );
                                        if($this->Mdl_inventario->actualizarMovimiento($data)){
                                            echo 1;
                                        }
                                        
                                    }                                    
                                }
                                else{
                                    $this->session->set_flashdata("error","No se pudo guardar la información");
                                    echo 0;
                                
                                }
                            }  
                            else{                                                
                                $data=
                                array(
                                        'usuario_id'=>$usuario_id,
                                        'plaza_id'=>$plaza_id,
                                        "insumo_gasto_id"=>$insumo_gasto_id,
                                        'unidad_pago_id'=>1,
                                        "Cantidad"=>$cantidad,
                                        'Importe'=>$importe,					                        
                                        "Modificacion"=>0,
                                        "Nueva_Cantidad" => 0,
                                        "Antigua_Cantidad" =>0,
                                        "Fecha"=>date("Y-m-d"),
                                        "Estado" => 1,
                                        "Notas"=>$notas
                                    );   
                                if($this->Mdl_remesas->save($data)){  
                                        echo 1;                                                        
                                }
                                else{
                                    $this->session->set_flashdata("error","No se pudo guardar la información");
                                    echo 0;
                                
                                }
                            }
                            }
                            else{
                                echo 2;
                            }
                        //CODIGO BASE O PRINCIPAL
                    }
                }else{
                    echo 4;
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

    public function storeAdmin()
	{
        if($this->input->is_ajax_request()){
        $usuario_id=$this->input->post("usuario_id");
        $user_id=$this->session->userdata("id");	

        $plaza_id=$this->input->post("plaza_id_gastos");            
        $insumo_gasto_id=$this->input->post("insumo_gasto_id");
        $unidad_pago_id=$this->input->post("unidad_pago_id");			
        $importe=$this->input->post("importe");
        $notas=$this->input->post("notas");

        $countfiles = count($_FILES['archivosRemesa']['name']);
        $nombresArchivos="";
        $folioArchivo=$this->Mdl_remesas->getFolio(1);            
        $folioArchivo=$folioArchivo->Folio;

        //PROBAR CON 1 BARRA O SIN BARRA AL FINAL
        $ruta="./assets/remesas/".$folioArchivo."/";
        if (!file_exists($ruta)) {
            mkdir($ruta);
        }

        $fecha=date("Ymd");
        $hora=date('H:i:s');

        $banderaErrorNombre=false;
        $banderaErrorCaracteres=false;


        // VERIFICACIÓN DE NOMBRES
			for($i=0;$i<$countfiles;$i++){
                if(!empty($_FILES['archivosRemesa']['name'][$i])){                     
			   		$_FILES['file']['name'] = $folioArchivo."ICC_".$_FILES['archivosRemesa']['name'][$i];
			   		$_FILES['file']['type'] = $_FILES['archivosRemesa']['type'][$i];
			   		$_FILES['file']['tmp_name'] = $_FILES['archivosRemesa']['tmp_name'][$i];
			   		$_FILES['file']['error'] = $_FILES['archivosRemesa']['error'][$i];
                    $_FILES['file']['size'] = $_FILES['archivosRemesa']['size'][$i];                       
                                
                    $config["upload_path"]      = $ruta;                                               
                    $config["max_size"]         = '25000';
                    $config["allowed_types"]    = "*";  
                                                                                                      	                    
                    $nombreArchivo=$stripped = str_replace(' ', '_',$_FILES['file']['name']);
                    if(strlen($nombreArchivo)>60){
                        $banderaErrorNombre=true;
                    }
                    
                    if (preg_match('/[()}{@$]/',$nombreArchivo)){
                        $banderaErrorCaracteres=true;
                    }    
                }            
            }
        // VERIFICACIÓN DE NOMBRES   
        
        
          // SUBIDA DE ARCHIVOS
          for($i=0;$i<$countfiles;$i++){
            if(!empty($_FILES['archivosRemesa']['name'][$i])){                     
                $_FILES['file']['name'] = $folioArchivo."ICC_".$_FILES['archivosRemesa']['name'][$i];
                $_FILES['file']['type'] = $_FILES['archivosRemesa']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['archivosRemesa']['tmp_name'][$i];
                $_FILES['file']['error'] = $_FILES['archivosRemesa']['error'][$i];
                $_FILES['file']['size'] = $_FILES['archivosRemesa']['size'][$i];                       
                            
                $config["upload_path"]      = $ruta;                                               
                $config["max_size"]         = '20000';
                $config["allowed_types"]    = "*";  
                
                                    
                //Load upload library
                $this->load->library('upload',$config);			
                
                // File upload
                if($this->upload->do_upload('file')){                    
                    // Get data about the file
                    $uploadData = $this->upload->data();		
                    $nombreArchivo=$stripped = str_replace(' ', '_',$_FILES['file']['name']);				
                    $nombresArchivos=$nombresArchivos.$nombreArchivo.",";                                              
                }
                else{
                    //$banderaError=true;
                }
            }            
        }
        // SUBIDA DE ARCHIVOS
                                
        $this->form_validation->set_rules("usuario_id","usuario_id","required");		
        $this->form_validation->set_rules("unidad_pago_id","unidad_pago_id","required");	
				$this->form_validation->set_rules("insumo_gasto_id","insumo_gasto_id","required");		
				$this->form_validation->set_rules("importe","importe","required");		
        $this->form_validation->set_rules("plaza_id_gastos","plaza_id_gastos","required");

        if($this->form_validation->run()){		            
            $insumoV=$this->insumoReal($insumo_gasto_id);
            
            if($insumoV!=116){
                $valorA=$this->consultarCantidad($insumoV,$plaza_id);	
                $valorB=0;
                $total=0;
                $valorB=$valorA+$cantidad;                                         
                $data=
                array(
                        'usuario_id'=>$usuario_id,
                        'plaza_id' =>$plaza_id,
                        "insumo_gasto_id"=>$insumo_gasto_id,
                        'unidad_pago_id'=>$unidad_pago_id,
                        "Cantidad"=>1,
                        'Importe'=>$importe,                        
                        "Modificacion"=>1,
                        "Nueva_Cantidad" => $valorB,
                        "Antigua_Cantidad" =>$valorA,
                        "Fecha"=>date("Y-m-d"),
                        "Estado" => 1,
                        "Notas"=>$notas,
                        'Archivos'=>$nombresArchivos,
                        'Folio'=>$folioArchivo
                    );
                if($this->Mdl_remesas->save($data)){  
                    $data = array('Cantidad' => $valorB);                                  
                    if($this->Mdl_inventario->actualizarCantidad($insumoV,$plaza_id,$data)){
                        $data=
                        array(
                            'usuario_id'=>$usuario_id,
                            'plaza_id'=>$plaza_id,                            
                            'Tipo_Movimiento'=>"GASTO",                            
                            "Nueva_Cantidad" => $valorB,
                            "Antigua_Cantidad" =>$valorA,
                            "Fecha"=>date("Y-m-d")
                        );
                        if($this->Mdl_inventario->actualizarMovimiento($data)){
                            $folioArchivo=$folioArchivo+1;
                            $data=array("Folio"=>$folioArchivo);                                               
                            if($this->Mdl_remesas->actualizarFolio(1,$data)){
                                echo 1;
                            }else{
                                echo 0;
                            }
                        }                        
                    }                                    
                }
                else{
                    $this->session->set_flashdata("error","No se pudo guardar la información");
                    echo 0;
                   
                }
            }  
            else{                                                
                $data=
                array(
                        'usuario_id'=>$usuario_id,
                        'plaza_id'=>$plaza_id,
                        "insumo_gasto_id"=>$insumo_gasto_id,
                        'unidad_pago_id'=>$unidad_pago_id,
                        "Cantidad"=>1,
                        'Importe'=>$importe,					                        
                        "Modificacion"=>0,
                        "Nueva_Cantidad" => 0,
                        "Antigua_Cantidad" =>0,
                        "Fecha"=>date("Y-m-d"),
                        "Estado" => 1,
                        "Notas"=>$notas,
                        'Archivos'=>$nombresArchivos,
                        'Folio'=>$folioArchivo
                    );   
                if($this->Mdl_remesas->save($data)){  
                        //echo 1;         
                        $folioArchivo=$folioArchivo+1;
                        $data=array("Folio"=>$folioArchivo);                                               
                        if($this->Mdl_remesas->actualizarFolio(1,$data)){
                            echo 1;
                        }else{
                            echo 0;
                        }
                }
                else{
                    $this->session->set_flashdata("error","No se pudo guardar la información");
                    echo 0;
                   
                }
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

    public function actualizarGasto(){

        if($this->input->is_ajax_request()){

            $id=$this->input->post("id_gasto_deposito");
            $usuario_id=$this->session->userdata("id");
            $plaza_id=$this->input->post("plaza_id_gasto_deposito"); 
            $insumo_gasto_id=$this->input->post("insumo_id_gasto_deposito"); 
            $cantidad=$this->input->post("cantidad");
            $insumoV=$this->insumoReal($insumo_gasto_id);
            $fecha=$this->input->post("fecha_editar_gasto");  

            $importe=$this->input->post("importe");                          
            $antCantidad=$this->input->post("antigua_cantidad_gasto_deposito");
            $valorCentinela=0;
            $banderaInventario=false;
           
            if($cantidad!=$antCantidad){
                $banderaInventario=true;
            }
              
            $nuevoTotal=0;
            $nuevoTotalAdmin=0;
            $acumuladoTotal=0;

            if($insumoV!=116){
                //CHECANDO CUANTO TIENE ESTE INSUMO EN INV DE PRODUCCIÓN
                $valorA=$this->consultarCantidad($insumoV,$plaza_id);
                if($banderaInventario){
                    //LA MODIFICACIÓN AFECTA AL INVENTARIO                    
                        //VOLVEMOS A SUMAR AL INVENTARIO LO QUE LE HABIAMOS RESTADO ANTES
                        $valorB=$valorA-$antCantidad;
                        //ARREGLO PARA ACTUALIZAR EL INVENTARIO
                        $data = array('Cantidad' => $valorB);
                        //ACTUALIZAMOS LA CANTIDAD DE LA MANERA QUE SE ENCONTRABA ANTES
                        if($this->Mdl_inventario->actualizarCantidad($insumoV,$plaza_id,$data))
                        {
                            $valorA=$this->consultarCantidad($insumoV,$plaza_id);
                            //UNA VEZ VUELTO EL ESTADO ANTES DEL GASTO PROCEDEMOS CON LA NUEVA CANTIDAD SEA MAYOR O MENOR
                            $valorB=$valorA+$cantidad;
                            //ASIGNAMOS DE NUEVO EL ARREGLO
                            $data = array('Cantidad' => $valorB);
                            //UNA VEZ ASIGNADO SE PROCEDE A REALIZAR DE NUEVO LA ACTUALIZACIÓN
                            if($this->Mdl_inventario->actualizarCantidad($insumoV,$plaza_id,$data)){
                                //SE REGISTRA EL MOVIMIENTO PARA LLEVAR A CABO EL SEGUIMIENTO DE
                                $data=
                                array(
                                    'usuario_id'=>$usuario_id,
                                    'plaza_id'=>$plaza_id,                            
                                    'Tipo_Movimiento'=>"Gasto Actualizado",
                                    'insumo_id'=>$insumoV,                            
                                    "Nueva_Cantidad" => $valorB,
                                    "Antigua_Cantidad" =>$valorA,
                                    "Fecha"=>date("Y-m-d")
                                );
                                //SE PROCEDE CON EL REGISTRO DEL MOVIMIENTO PARA EL SEGUIMIENTO DE INV
                                if($this->Mdl_inventario->actualizarMovimiento($data)){
                                    $data=array
                                    (                                                        
                                        'Cantidad' =>$cantidad,
                                        "Importe"=>$importe
                                    );
                            
                                if($this->Mdl_remesas->actualizarGasto2($id,$data)){
                                $reportes=$this->Mdl_remesas->getGastosVentas($fecha,$plaza_id); 
                                $reportes2=$this->Mdl_remesas->getGastosVentasAdmin($fecha,$plaza_id); 
            
                                if($reportes!=null && $reportes2!=null ){
                                    $nuevoTotal=$reportes->Importe;
                                    $nuevoTotalAdmin=$reportes2->Importe;
                                    $acumuladoTotal=$nuevoTotal+$nuevoTotalAdmin; 
            
                                    $totalIngresos=$this->Mdl_ventas->getTotalIngresos($fecha,$plaza_id);                                                            
                                    $totalIngresos=$totalIngresos->Total;
            
                                    $totalTPV=$this->Mdl_ventas->getTotalTPV($fecha,$plaza_id);                                                            
                                    $totalTPV=$totalTPV->Total;
            
                                    $nuevoEfectivo=($totalIngresos-$nuevoTotal)-$totalTPV;
            
                                    $data=array('Gastos'=>$nuevoTotal,'Gastos_Admin'=>$nuevoTotalAdmin,'Total_Gastos'=>$acumuladoTotal,"Efectivo_Real"=>$nuevoEfectivo);
                                    if($this->Mdl_ventas->actualizarGastos($fecha,$plaza_id,$data)){
                                        echo 1;                                                                
                                    }else{
                                        echo 0;
                                    }     
                                }                                                                        
                                }
                                else{                        
                                    echo 0;                    
                                } 
                                }
                            }
                        }
                    
                }
                else{
                    $data=array
                    (                                                        
                        'Cantidad' =>$cantidad,
                        "Importe"=>$importe
                    );
            
                if($this->Mdl_remesas->actualizarGasto2($id,$data)){
                $reportes=$this->Mdl_remesas->getGastosVentas($fecha,$plaza_id); 
                $reportes2=$this->Mdl_remesas->getGastosVentasAdmin($fecha,$plaza_id); 

                if($reportes!=null && $reportes2!=null ){
                    $nuevoTotal=$reportes->Importe;
                    $nuevoTotalAdmin=$reportes2->Importe;
                    $acumuladoTotal=$nuevoTotal+$nuevoTotalAdmin; 

                    $totalIngresos=$this->Mdl_ventas->getTotalIngresos($fecha,$plaza_id);                                                            
                    $totalIngresos=$totalIngresos->Total;

                    $totalTPV=$this->Mdl_ventas->getTotalTPV($fecha,$plaza_id);                                                            
                    $totalTPV=$totalTPV->Total;

                    $nuevoEfectivo=($totalIngresos-$nuevoTotal)-$totalTPV;

                    $data=array('Gastos'=>$nuevoTotal,'Gastos_Admin'=>$nuevoTotalAdmin,'Total_Gastos'=>$acumuladoTotal,"Efectivo_Real"=>$nuevoEfectivo);
                    if($this->Mdl_ventas->actualizarGastos($fecha,$plaza_id,$data)){
                        echo 1;                                                                
                    }else{
                        echo 0;
                    }     
                }                                                                        
                }
                else{                        
                    echo 0;                    
                }
                }
            }else{

                $data=array
                (                                                        
                    'Cantidad' =>$cantidad,
                    "Importe"=>$importe
                );
        
            if($this->Mdl_remesas->actualizarGasto2($id,$data)){
            $reportes=$this->Mdl_remesas->getGastosVentas($fecha,$plaza_id); 
            $reportes2=$this->Mdl_remesas->getGastosVentasAdmin($fecha,$plaza_id); 

            if($reportes!=null && $reportes2!=null ){
                $nuevoTotal=$reportes->Importe;
                $nuevoTotalAdmin=$reportes2->Importe;
                $acumuladoTotal=$nuevoTotal+$nuevoTotalAdmin; 

                $totalIngresos=$this->Mdl_ventas->getTotalIngresos($fecha,$plaza_id);                                                            
                $totalIngresos=$totalIngresos->Total;

                $totalTPV=$this->Mdl_ventas->getTotalTPV($fecha,$plaza_id);                                                            
                $totalTPV=$totalTPV->Total;

                $nuevoEfectivo=($totalIngresos-$nuevoTotal)-$totalTPV;

                $data=array('Gastos'=>$nuevoTotal,'Gastos_Admin'=>$nuevoTotalAdmin,'Total_Gastos'=>$acumuladoTotal,"Efectivo_Real"=>$nuevoEfectivo);
                if($this->Mdl_ventas->actualizarGastos($fecha,$plaza_id,$data)){
                    echo 1;                                                                
                }else{
                    echo 0;
                }     
            }                                                                        
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

    public function actualizarGastoAdmin(){
        if($this->input->is_ajax_request()){

            $id=$this->input->post("id_admin_gasto_deposito");            
            $plaza_id=$this->input->post("plaza_id_admin_gasto_deposito");             
            $cantidad=$this->input->post("cantidad_admin");            
            $fecha=$this->input->post("fecha_editar_gasto_admin");  
            $importe=$this->input->post("importe_admin");                                      
            
            $nuevoTotal=0;
            $nuevoTotalAdmin=0;
            $acumuladoTotal=0;

                $data=array
                (                                                                            
                    "Importe"=>$importe
                );
        
            if($this->Mdl_remesas->actualizarGasto2($id,$data)){
            $reportes=$this->Mdl_remesas->getGastosVentas($fecha,$plaza_id); 
            $reportes2=$this->Mdl_remesas->getGastosVentasAdmin($fecha,$plaza_id); 

            if($reportes!=null && $reportes2!=null ){
                $nuevoTotal=$reportes->Importe;
                $nuevoTotalAdmin=$reportes2->Importe;
                $acumuladoTotal=$nuevoTotal+$nuevoTotalAdmin; 

                $data=array('Gastos'=>$nuevoTotal,'Gastos_Admin'=>$nuevoTotalAdmin,'Total_Gastos'=>$acumuladoTotal);
                if($this->Mdl_ventas->actualizarGastos($fecha,$plaza_id,$data)){
                    echo 1;                                                                
                }else{
                    echo 0;
                }     
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

    public function listRemesasOaxaca(){
       
        $plaza_id=$this->session->userdata("plaza"); 
        $fechainicio=$this->input->post("fechaInicioD"); 
               
        if($this->input->post("buscar")){                
            $data=array(
                'gastosPasados' => $this->Mdl_remesas->getListGastosFechaPlaza2($fechainicio,$plaza_id),
                'fechaConsulta' => $fechainicio,
                'fechainicio' => $fechainicio,
                'plazas'  =>   $this->Mdl_plazas->getPlazas(),
                'id' => $plaza_id,
                "fecha"=>date("Y-m-d"),
                'mensaje'=> "Remesas del día: ".$fechainicio
            );                                                               
        }        
        else{
            $data=array(
                'gastos' => $this->Mdl_remesas->getListGastosFechaPlaza2(date("Y-m-d"),$plaza_id),
                'plazas'  =>   $this->Mdl_plazas->getPlazas(),
                'mensaje'=> "Remesas del día: ".date("Y-m-d"),
                "fecha"=>date("Y-m-d"),
                'id' => $plaza_id         
            );   
        } 
        $this->load->view("layouts/header");
	    $this->load->view("layouts/aside");
		$this->load->view("socio/remesas/list_remesas_socio",$data);
        $this->load->view("layouts/footer");    
    }

    public function stocks(){                                                   
        $data=array(                
            'insumos_remesa' => $this->Mdl_remesas->getInsumosGastos()                                            
        );                   
        $this->load->view("layouts/header");
        $this->load->view("layouts/aside");
        $this->load->view("administrador/remesas/stocks",$data);        
        $this->load->view("layouts/footer");
    }

    public function actualizarStockRemesa(){
        if($this->input->is_ajax_request()){            
            $insumo_gasto_id=$this->input->post("id_stock_remesa");        
            $stockMinimo=$this->input->post("stockMinimo");
            $stockMaximo=$this->input->post("stockMaximo");                               
            if(is_numeric($stockMinimo) && is_numeric($stockMaximo)){                
                $data=array("stock_minimo" => $stockMinimo,"stock_maximo" => $stockMaximo);            
                if($this->Mdl_remesas->actualizarStockRemesaModelo($insumo_gasto_id,$data)){                                                                            
                   
                    $tabla= $this->Mdl_remesas->getInsumosGastosAJAX();
                    $return_arr[] = array
                    ("tabla" => $tabla,
                    "valor" => 1
                    );  
                    echo json_encode($return_arr);                                          
                }
                else{
                    $tabla= $this->Mdl_remesas->getInsumosGastosAJAX();
                    $return_arr[] = array
                    ("tabla" => $tabla,
                    "valor" => 0
                    );  
                    echo json_encode($return_arr); 
                }  
            }else{
                $tabla= $this->Mdl_remesas->getInsumosGastosAJAX();
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

    public function actualizarBandera(){
        if($this->input->is_ajax_request()){

            $insumo_gasto_id=$this->input->post("insumo_gasto_id");        
            $valor=$this->input->post("valor");
            
            $data=array 
            ("bandera_stocks"=>$valor);

            if($this->Mdl_remesas->actualizarBanderaModelo($insumo_gasto_id,$data)){
                $tabla= $this->Mdl_remesas->getInsumosGastosAJAX();
                $return_arr[] = array
                ("tabla" => $tabla,
                "valor" => 1
                );  
                echo json_encode($return_arr); 
            }
            else{
                $tabla= $this->Mdl_remesas->getInsumosGastosAJAX();
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

    public function verArchivo($folioArchivo,$imagen){                       
        $ruta="./assets/remesas/".$folioArchivo."/".$imagen;
        header('Content-Description: File Transfer');
        //header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . basename($ruta) . '"');
        header('Content-Length: ' . filesize($ruta));
        readfile($ruta);
        exit;           
    }
    
    private function eliminarArchivos($ruta,$folio_archivo){                      
        // Se comprueba que realmente sea la ruta de un directorio
        if (is_dir($ruta)){
            // Abre un gestor de directorios para la ruta indicada
            $gestor = opendir($ruta);            
            // Recorre todos los elementos del directorio
            while (($archivo = readdir($gestor)) !== false)  {                    
                $ruta_completa = $ruta . "/" . $archivo;    
                // Se muestran todos los archivos y carpetas excepto "." y ".."
                if ($archivo != "." && $archivo != "..") {
                    // Si es un directorio se recorre recursivamente                                                                                                              
                        $findme   = $folio_archivo."ICC";
                        $pos = strpos($archivo, $findme);                        
                        if ($pos !== false) {
                          unlink($ruta.$archivo);
                          //unlink($ruta);
                        }else{
                            unlink($ruta.$archivo);
                            //unlink($ruta);
                        } 
                }
            }            
            // Cierra el gestor de directorios
            closedir($gestor);            
        } 
    }

    public function deleteAdminManager(){
        if($this->input->is_ajax_request()){  
            //VERIFICAR QUE SOLO SE PUEDA ELIMINAR EL GASTO DEL DÍA
            $id=$this->input->post("id");
            $usuario_id=$this->input->post("usuario_id");
            $plaza_id=$this->input->post("plaza_id");
            $insumo_gasto_id=$this->input->post("insumo_gasto_id");
            $cantidad=$this->input->post("cantidad");	

            $fechaGasto=$this->Mdl_remesas->getDatosGasto($id);
            $fechaGasto=$fechaGasto->Fecha;

            if($this->session->userdata("plaza")==$plaza_id){
                if($fechaGasto==date("Y-m-d")){
                    $insumoV=$this->insumoReal($insumo_gasto_id);                
                    if($insumoV!=116){
                        $valorA=$this->consultarCantidad($insumoV,$plaza_id);	
                        $valorB=$valorA-$cantidad;
                        $data = array('Cantidad' => $valorB);
                        if($this->Mdl_inventario->actualizarCantidad($insumoV,$plaza_id,$data)){
                            $this->Mdl_remesas->delete($id);
                            $data=
                            array(
                                'usuario_id'=>$usuario_id,
                                'plaza_id'=>$plaza_id,                            
                                'Tipo_Movimiento'=>"Gasto Restado",
                                'insumo_id'=>$insumoV,                            
                                "Nueva_Cantidad" => $valorB,
                                "Antigua_Cantidad" =>$valorA,
                                "Fecha"=>date("Y-m-d")
                            );
                            if($this->Mdl_inventario->actualizarMovimiento($data)){                            
                                echo 1;                                                                                            
                            }
                            else{
                                echo 0;
                            }        
                        }                
                    }
                    else{
                        if($this->Mdl_remesas->delete($id)){                                                                                                                                            
                            echo 1;
                        }else{
                            echo 0;
                        }                    
                    } 
                }else{
                    echo 2;
                }            
            }else{
                echo 3;
            }                
       }   
       else{
               redirect(base_url()."Inicio");
         } 
    }

   
  
    
}









   
    

        
        

	





