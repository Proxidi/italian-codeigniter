<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Unidades extends CI_Controller {
    private $permisos;  

    public function __construct()
    {
            parent::__construct();
            $this->permisos=$this->backend_lib->control();
            $this->load->model('Mdl_productos');  
            $this->load->model('Mdl_plazas');
            $this->load->model('Mdl_unidades');
            $this->load->model('Mdl_remesas'); 

            if(!$this->session->userdata("login")){
            redirect(base_url());
            }         
    }
    
    

    public function grafico(){                    
    }

    public function consultarUnidadesFamilia(){
        if($this->input->is_ajax_request())
        {            
             $fechaInicio=$this->input->post('fechaInicio');    
             $fechaFin=$this->input->post('fechaFin');
             $grupo_id=$this->input->post('categoria_id');  
             $plaza_id=$this->input->post('plaza_id');  
             echo json_encode($this->Mdl_unidades->getUnidadesFechaPlazaGrupoRango($fechaInicio,$fechaFin,$plaza_id,$grupo_id));
             
         }   
         else
         {
             redirect(base_url()."Inicio");
         }	
    }

    public function index()
    {                          
        $plaza_id=$this->input->post("plaza_id"); 
        $fechainicio=$this->input->post("fechaInicioD"); 
        $fechafin=$this->input->post("fechaFinD"); 
        $grupo_id=$this->input->post("grupo_id");
        $fechaActual=date('Y-m-d',strtotime("-1 days"));
        $busquedaPlaza=false;
        $busquedaGrupo=false;
        if($plaza_id=="")
        {
            $busquedaPlaza=false;
            if($grupo_id==""){
                $busquedaGrupo=false;               
                if($this->input->post("buscar")){
                    $fechaInicioG=$fechainicio;
                    $fechaFinG=$fechainicio;
                }else if($this->input->post("buscarRango")){
                    $fechaInicioG=$fechainicio;
                    $fechaFinG=$fechafin;
                }
                else{
                    $fechaInicioG=date('Y-m-d',strtotime("-1 days"));
                    $fechaFinG=date('Y-m-d',strtotime("-1 days"));
                }
            }else{
                $busquedaGrupo=true;               
                if($this->input->post("buscarRango")){
                    $fechaInicioG=$fechainicio;
                    $fechaFinG=$fechafin;
                }else{  
                    $fechaInicioG=date('Y-m-d',strtotime("-1 days"));
                    $fechaFinG=date('Y-m-d',strtotime("-1 days"));
                }
            }
        }else{
            $busquedaPlaza=true;
            $plaza_idG=$plaza_id;
            $nombrePlaza=$this->Mdl_plazas->getPlazaID($plaza_idG);
            $nombrePlaza=$nombrePlaza->nombrePlaza;
            if($grupo_id==""){ 
                $busquedaGrupo=false;               
                if($this->input->post("buscar")){
                    $fechaInicioG=$fechainicio;
                    $fechaFinG=$fechainicio;
                }
                else if($this->input->post("buscarRango")){
                    $fechaInicioG=$fechainicio;
                    $fechaFinG=$fechafin;
                }
            }
            else{
                $busquedaGrupo=true;               
                if($this->input->post("buscar")){       
                    $fechaInicioG=$fechainicio;
                    $fechaFinG=$fechainicio;             
                }
                else if($this->input->post("buscarRango")){  
                    $fechaInicioG=$fechainicio;
                    $fechaFinG=$fechafin;                  
                }
            }
        }
    
        $valoresX=array();
        $valoresY=array();        
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

        $valoresNombres=array("graficaPieCA","graficaPieMA","graficaPieOA","graficaPiePZ","graficaPieR1","graficaPieR2","graficaPieTZ");        
        $valoresNombresP=array("CASITAS","MATAMOROS","OAXACA","POZA RICA","REYNOSA I","REYNOSA II","TEZIUTLÁN");        
        $datosNombres=json_encode($valoresNombres);
        $datosNombresP=json_encode($valoresNombresP);
        
        if($busquedaPlaza==false){
            if($busquedaGrupo==false){
                $valorCA=$this->Mdl_unidades->getUnidadesGraficoPlaza($fechaInicioG,$fechaFinG,1);
                $valorMA=$this->Mdl_unidades->getUnidadesGraficoPlaza($fechaInicioG,$fechaFinG,2);
                $valorOA=$this->Mdl_unidades->getUnidadesGraficoPlaza($fechaInicioG,$fechaFinG,3);
                $valorPZ=$this->Mdl_unidades->getUnidadesGraficoPlaza($fechaInicioG,$fechaFinG,4);
                $valorR1=$this->Mdl_unidades->getUnidadesGraficoPlaza($fechaInicioG,$fechaFinG,5);
                $valorR2=$this->Mdl_unidades->getUnidadesGraficoPlaza($fechaInicioG,$fechaFinG,6);
            }else{
                $valorCA=$this->Mdl_unidades->getProductosGraficoPlaza($fechaInicioG,$fechaFinG,1,$grupo_id);                            
                $valorMA=$this->Mdl_unidades->getProductosGraficoPlaza($fechaInicioG,$fechaFinG,2,$grupo_id);                            
                $valorOA=$this->Mdl_unidades->getProductosGraficoPlaza($fechaInicioG,$fechaFinG,3,$grupo_id);                            
                $valorPZ=$this->Mdl_unidades->getProductosGraficoPlaza($fechaInicioG,$fechaFinG,4,$grupo_id);                            
                $valorR1=$this->Mdl_unidades->getProductosGraficoPlaza($fechaInicioG,$fechaFinG,5,$grupo_id);                            
                $valorR2=$this->Mdl_unidades->getProductosGraficoPlaza($fechaInicioG,$fechaFinG,6,$grupo_id);                            
            }
            
            foreach ($valorCA as $key) {                                                
                $valoresXCA[]=$key->Nombre;
                $valoresYCA[]=$key->Cantidad;            
            }
            $datosXCA=json_encode($valoresXCA);
            $datosYCA=json_encode($valoresYCA);
            
         
            foreach ($valorMA as $key) {                                                
                $valoresXMA[]=$key->Nombre;
                $valoresYMA[]=$key->Cantidad;            
            }
            $datosXMA=json_encode($valoresXMA);
            $datosYMA=json_encode($valoresYMA);

            
            foreach ($valorOA as $key) {                                                
                $valoresXOA[]=$key->Nombre;
                $valoresYOA[]=$key->Cantidad;            
            }
            $datosXOA=json_encode($valoresXOA);
            $datosYOA=json_encode($valoresYOA);

        
            foreach ($valorPZ as $key) {                                                
                $valoresXPZ[]=$key->Nombre;
                $valoresYPZ[]=$key->Cantidad;            
            }
            $datosXPZ=json_encode($valoresXPZ);
            $datosYPZ=json_encode($valoresYPZ);

           
            foreach ($valorR1 as $key) {                                                
                $valoresXR1[]=$key->Nombre;
                $valoresYR1[]=$key->Cantidad;            
            }
            $datosXR1=json_encode($valoresXR1);
            $datosYR1=json_encode($valoresYR1);
            
            foreach ($valorR2 as $key) {                                                
                $valoresXR2[]=$key->Nombre;
                $valoresYR2[]=$key->Cantidad;            
            }
            $datosXR2=json_encode($valoresXR2);
            $datosYR2=json_encode($valoresYR2);


        }else{
            if($busquedaGrupo==false){
                $valor=$this->Mdl_unidades->getUnidadesGraficoPlaza($fechaInicioG,$fechaFinG,$plaza_idG);
            }else{
                $valor=$this->Mdl_unidades->getProductosGraficoPlaza($fechaInicioG,$fechaFinG,$plaza_idG,$grupo_id);                
            }            
            foreach ($valor as $key) {                                                
                $valoresX[]=$key->Nombre;
                $valoresY[]=$key->Cantidad;            
            }
            $datosX=json_encode($valoresX);
            $datosY=json_encode($valoresY);
        }
                       

        if($plaza_id=="")
        {
            if($grupo_id==""){
                if($this->input->post("buscar")){
                    $unidades=$this->Mdl_unidades->getUnidadesFechaGrupoGeneral($fechainicio,$fechainicio); 
                    $data=
                    array(
                    'unidades' => $unidades,
                    'fechainicio' => $fechainicio,
                    'plazas'   => $this->Mdl_plazas->getPlazas(),
                    'grupos' =>  $this->Mdl_productos->getFamilias(),
                    'id_familia'          => $grupo_id,
                    'id'          => $plaza_id,
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
                    
                    'busquedaPlaza'=>$busquedaPlaza,

                    'fechaInicioG'=>$fechaInicioG,
                    'fechaFinG'=>$fechaFinG,
                                         
                    'datosNombres'=>$datosNombres,
                    'datosNombresP'=>$datosNombresP
                    ); 
                }
                else if($this->input->post("buscarRango")){
                    $unidades=$this->Mdl_unidades->getUnidadesFechaGrupoGeneral($fechainicio,$fechafin); 
                    $data=
                    array(
                    'unidades' => $unidades,
                    'fechainicio' => $fechainicio,
                    'fechafin' => $fechafin,
                    'plazas'   => $this->Mdl_plazas->getPlazas(),
                    'grupos' =>  $this->Mdl_productos->getFamilias(),
                    'id_familia'          => $grupo_id,
                    'id'          => $plaza_id,
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
                 
                    'busquedaPlaza'=>$busquedaPlaza,

                    'fechaInicioG'=>$fechaInicioG,
                    'fechaFinG'=>$fechaFinG,


                    'datosNombres'=>$datosNombres,
                    'datosNombresP'=>$datosNombresP
                    ); 
                }
                else{
                    $unidades=$this->Mdl_unidades->getUnidadesFechaGrupoGeneral($fechaActual,$fechaActual); 
                    $data=
                    array(
                    'unidades' => $unidades,
                    'fechainicio' => $fechainicio,
                    'plazas'   => $this->Mdl_plazas->getPlazas(),
                    'grupos' =>  $this->Mdl_productos->getFamilias(),
                    'id_familia'          => $grupo_id,
                    'id'          => $plaza_id ,
                    'fechaConsulta' => $fechaActual,
                    
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
                 
                    'busquedaPlaza'=>$busquedaPlaza,

                    'fechaInicioG'=>$fechaInicioG,
                    'fechaFinG'=>$fechaFinG,

                    'datosNombres'=>$datosNombres,
                    'datosNombresP'=>$datosNombresP
                    ); 
                }
                
            }
            else{
                if($this->input->post("buscarRango")){
                    $unidadesFP=$this->Mdl_unidades->getUnidadesFechaGrupo3($fechainicio,$fechafin,$grupo_id);                                                                               
                    $data=
                    array(
                    'unidadesFP' => $unidadesFP,
                    'fechainicio' => $fechainicio,
                    'fechafin' => $fechafin,
                    'plazas'   => $this->Mdl_plazas->getPlazas(),
                    'grupos' =>  $this->Mdl_productos->getFamilias(),
                    'id_familia'          => $grupo_id,
                    'id' => $plaza_id  ,
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
                    
                    'busquedaPlaza'=>$busquedaPlaza,

                    'fechaInicioG'=>$fechaInicioG,
                    'fechaFinG'=>$fechaFinG,

                    'datosNombres'=>$datosNombres,
                    'datosNombresP'=>$datosNombresP
                    );
                }
                else{
                    $unidadesFP=$this->Mdl_unidades->getUnidadesFechaGrupo3($fechainicio,$fechainicio,$grupo_id);                                                                               
                    $data=
                    array(
                    'unidadesFP' => $unidadesFP,
                    'fechainicio' => $fechainicio,
                    'plazas'   => $this->Mdl_plazas->getPlazas(),
                    'grupos' =>  $this->Mdl_productos->getFamilias(),
                    'id_familia'          => $grupo_id,
                    'id' => $plaza_id,
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
                   
                    'busquedaPlaza'=>$busquedaPlaza,

                    'fechaInicioG'=>$fechaInicioG,
                    'fechaFinG'=>$fechaFinG,

                    'datosNombres'=>$datosNombres,
                    'datosNombresP'=>$datosNombresP
                    );
                }                
            }                                          
        }
        else{
            if($grupo_id==""){
                if($this->input->post("buscar")){
                    $unidadesFP2=$this->Mdl_unidades->getUnidadesFechaGrupoGeneralPlaza2($fechainicio,$fechainicio,$plaza_id);                                                                                                       
                    $data=
                    array(
                    'unidades2' => $unidadesFP2,
                    'fechainicio' => $fechainicio,
                    'fechafin' => $fechainicio,
                    'plazas'   => $this->Mdl_plazas->getPlazas(),
                    'grupos' =>  $this->Mdl_productos->getFamilias(),
                    'id'          => $plaza_id,
                    'fechaConsulta' => $fechainicio,
                                    
                    'datosX'=>$datosX,
                    'datosY'=>$datosY,
                    'nombrePlaza'=>$nombrePlaza,

                    'busquedaPlaza'=>$busquedaPlaza,

                    'fechaInicioG'=>$fechaInicioG,
                    'fechaFinG'=>$fechaFinG,

                    'datosNombres'=>$datosNombres,
                    'datosNombresP'=>$datosNombresP
                    );                                                                     
        }
        else if($this->input->post("buscarRango")){
            $unidadesFP2=$this->Mdl_unidades->getUnidadesFechaGrupoGeneralPlaza2($fechainicio,$fechafin,$plaza_id);                                                                                                       
                    $data=
                    array(
                    'unidades2' => $unidadesFP2,
                    'fechainicio' => $fechainicio,
                    'fechafin' => $fechafin,
                    'plazas'   => $this->Mdl_plazas->getPlazas(),
                    'grupos' =>  $this->Mdl_productos->getFamilias(),
                    'id'          => $plaza_id,
                    'fechaConsulta' => $fechainicio."<br>".$fechafin,
                                       
                    'datosX'=>$datosX,
                    'datosY'=>$datosY,
                    'nombrePlaza'=>$nombrePlaza,

                    'busquedaPlaza'=>$busquedaPlaza,

                    'fechaInicioG'=>$fechaInicioG,
                    'fechaFinG'=>$fechaFinG,

                    'datosNombres'=>$datosNombres,
                    'datosNombresP'=>$datosNombresP
                    ); 
        }        
            }     
            else{
                if($this->input->post("buscar")){
                    $unidadesFP2=$this->Mdl_unidades->getUnidadesFechaPlazaGrupo($fechainicio,$fechainicio,$plaza_id,$grupo_id);                                                                                                       
                    $data=
                    array(
                    'unidadesFP2' => $unidadesFP2,
                    'fechainicio' => $fechainicio,                                            
                    'plazas'   => $this->Mdl_plazas->getPlazas(),
                    'grupos' =>  $this->Mdl_productos->getFamilias(),
                    'id'          => $plaza_id,
                    'id_familia'          => $grupo_id,
                    'fechaConsulta' => $fechainicio,
                                      
                    'datosX'=>$datosX,
                    'datosY'=>$datosY,
                    'nombrePlaza'=>$nombrePlaza,

                    'busquedaPlaza'=>$busquedaPlaza,

                    'fechaInicioG'=>$fechaInicioG,
                    'fechaFinG'=>$fechaFinG,

                    'datosNombres'=>$datosNombres,
                    'datosNombresP'=>$datosNombresP
                    );                                                                     
                }
                else if($this->input->post("buscarRango")){
                    $unidadesFP2=$this->Mdl_unidades->getUnidadesFechaPlazaGrupoRango($fechainicio,$fechafin,$plaza_id,$grupo_id);                                                                                                       
                    $data=
                    array(
                    'unidadesFP2' => $unidadesFP2,
                    'fechainicio' => $fechainicio,
                    'fechafin' => $fechafin,
                    'plazas'   => $this->Mdl_plazas->getPlazas(),
                    'grupos' =>  $this->Mdl_productos->getFamilias(),
                    'id'          => $plaza_id,
                    'id_familia'          => $grupo_id,
                    'fechaConsulta' => $fechainicio."<br>".$fechafin,
                                    
                    'datosX'=>$datosX,
                    'datosY'=>$datosY,
                    'nombrePlaza'=>$nombrePlaza,

                    'busquedaPlaza'=>$busquedaPlaza,

                    'fechaInicioG'=>$fechaInicioG,
                    'fechaFinG'=>$fechaFinG,

                    'datosNombres'=>$datosNombres,
                    'datosNombresP'=>$datosNombresP
                    );   
                }                                         
            }        
        }
            
        $this->load->view("layouts/header");
        $this->load->view("layouts/aside");
        $this->load->view("administrador/unidades/listP",$data);
        $this->load->view("layouts/footer");
    }

    public function listUnidadesOaxaca(){

        $plaza_id=$this->session->userdata("plaza"); 
        $fechainicio=$this->input->post("fechaInicioD"); 
        $fechafin=$this->input->post("fechaFinD"); 
        $grupo_id=$this->input->post("grupo_id");
        $fechaActual=date('Y-m-d',strtotime("-1 days"));  
                       
        if($this->input->post("buscar")){            
            if($grupo_id==""){
                
                $unidadesFP2=$this->Mdl_unidades->getUnidadesFechaGrupoGeneralPlaza($fechainicio,$fechainicio,$plaza_id);                                                                                                       
                $data=
                array(
                'unidades' => $unidadesFP2,
                'fechainicio' => $fechainicio,
                'plazas'   => $this->Mdl_plazas->getPlazas(),
                'grupos' =>  $this->Mdl_productos->getFamilias(),
                'id'          => $plaza_id,
                'fechaConsulta' => $fechainicio 
                ); 

            }else{
                $unidadesFP2=$this->Mdl_unidades->getUnidadesFechaPlazaGrupo($fechainicio,$fechainicio,$plaza_id,$grupo_id);                                                                                                       
                $data=
                array(
                'unidadesFP2' => $unidadesFP2,
                'fechainicio' => $fechainicio,                        
                'plazas'   => $this->Mdl_plazas->getPlazas(),
                'grupos' =>  $this->Mdl_productos->getFamilias(),
                'id'          => $plaza_id,
                'id_familia'          => $grupo_id,
                'fechaConsulta' => $fechainicio
                );    

            }            
        }
        else if ($this->input->post("buscarRango")){
            if($grupo_id==""){
                $unidadesFP2=$this->Mdl_unidades->getUnidadesFechaGrupoGeneralPlaza($fechainicio,$fechafin,$plaza_id);                                                                                                       
                $data=
                array(
                'unidades' => $unidadesFP2,
                'fechainicio' => $fechainicio,
                'fechafin' => $fechafin,
                'plazas'   => $this->Mdl_plazas->getPlazas(),
                'grupos' =>  $this->Mdl_productos->getFamilias(),
                'id'          => $plaza_id,
                'fechaConsulta' => $fechainicio."<br>".$fechafin
                ); 
            }else{
                $unidadesFP2=$this->Mdl_unidades->getUnidadesFechaPlazaGrupoRango($fechainicio,$fechafin,$plaza_id,$grupo_id);                                                                                                       
                $data=
                array(
                'unidadesFP2' => $unidadesFP2,
                'fechainicio' => $fechainicio,
                'fechafin' => $fechafin,
                'plazas'   => $this->Mdl_plazas->getPlazas(),
                'grupos' =>  $this->Mdl_productos->getFamilias(),
                'id'          => $plaza_id,
                'id_familia'          => $grupo_id,
                'fechaConsulta' => $fechainicio."<br>".$fechafin
                ); 
            }
        }
        else
        {
            $unidades=$this->Mdl_unidades->getUnidadesFechaGrupoGeneral($fechaActual,$fechaActual); 
            $data=
            array(
            'unidades' => $unidades,
            'fechainicio' => $fechainicio,
            'plazas'   => $this->Mdl_plazas->getPlazas(),
            'grupos' =>  $this->Mdl_productos->getFamilias(),
            'id_familia'          => $grupo_id,
            'id'          => $plaza_id ,
            'fechaConsulta' => $fechaActual
            ); 
        }

        $this->load->view("layouts/header");
        $this->load->view("layouts/aside");
        $this->load->view("socio/unidades/list_unidades",$data);
        $this->load->view("layouts/footer");
    }

 

}
