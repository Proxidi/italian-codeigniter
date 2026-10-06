<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mdl_unidades extends CI_model{
    
    public function getUnidadesFechaPlaza($fechainicio,$fechafin,$plaza_id){
        $this->db->select("pv.*,pv.Cantidad as Total,p.Nombre as Producto,pl.Nombre as Plaza,fp.Nombre as Familia");
        $this->db->from("tbl_platillos_vendidos_resumen pv");        		
        $this->db->join("tbl_productos p","p.Clave = pv.Clave");
        $this->db->join("tbl_plazas pl","pv.plaza_id = pl.id");
        $this->db->join("tbl_familia_productos fp","p.familia_id = fp.id");
        $query=$this->db->where("pv.plaza_id",$plaza_id);
		$query=$this->db->where("pv.Fecha >=",$fechainicio);
		$query=$this->db->where("pv.Fecha <=",$fechafin);		        
        $this->db->group_by('pv.Clave'); 	
        $resultados=$this->db->get();
        return $resultados->result();  
    }

    public function getUnidadesFechaPlazaRango($fechainicio,$fechafin,$plaza_id){
        $this->db->select("pv.*,SUM(pv.Cantidad) as Total,p.Nombre as Producto,pl.Nombre as Plaza,fp.Nombre as Familia");
        $this->db->from("tbl_platillos_vendidos_resumen pv");        		
        $this->db->join("tbl_productos p","p.Clave = pv.Clave");
        $this->db->join("tbl_plazas pl","pv.plaza_id = pl.id");
        $this->db->join("tbl_familia_productos fp","p.familia_id = fp.id");
        $query=$this->db->where("pv.plaza_id",$plaza_id);
		$query=$this->db->where("pv.Fecha >=",$fechainicio);
		$query=$this->db->where("pv.Fecha <=",$fechafin);		        
        $this->db->group_by('pv.Clave'); 	
        $resultados=$this->db->get();
        return $resultados->result();  
    }

    public function getUnidadesFechaPlazaGrupoRango($fechainicio,$fechafin,$plaza_id,$grupo_id){
        $this->db->select("pv.*,sum(pv.Cantidad) as Total,p.Nombre as Producto,pl.Nombre as Plaza,fp.Nombre as Familia");
        $this->db->from("tbl_platillos_vendidos_resumen pv");        		
        $this->db->join("tbl_productos p","p.Clave = pv.Clave");
        $this->db->join("tbl_plazas pl","pv.plaza_id = pl.id");
        $this->db->join("tbl_familia_productos fp","p.familia_id = fp.id");
        $query=$this->db->where("pv.plaza_id",$plaza_id);
		$query=$this->db->where("pv.Fecha >=",$fechainicio);
        $query=$this->db->where("pv.Fecha <=",$fechafin);
        $query=$this->db->where("fp.id",$grupo_id);
        $this->db->group_by('pv.Clave'); 	
        $resultados=$this->db->get();
        return $resultados->result();  
    }



    public function getUnidadesFechaPlazaGrupo($fechainicio,$fechafin,$plaza_id,$grupo_id){
        $this->db->select("pv.*,pv.Cantidad as Total,p.Nombre as Producto,pl.Nombre as Plaza,fp.Nombre as Familia");
        $this->db->from("tbl_platillos_vendidos_resumen pv");        		
        $this->db->join("tbl_productos p","p.Clave = pv.Clave");
        $this->db->join("tbl_plazas pl","pv.plaza_id = pl.id");
        $this->db->join("tbl_familia_productos fp","p.familia_id = fp.id");
        $query=$this->db->where("pv.plaza_id",$plaza_id);
		$query=$this->db->where("pv.Fecha >=",$fechainicio);
        $query=$this->db->where("pv.Fecha <=",$fechafin);
        $query=$this->db->where("fp.id",$grupo_id);
        $this->db->group_by('pv.Clave'); 	
        $resultados=$this->db->get();
        return $resultados->result();  
    }



    public function getUnidadesFechaGrupo($fechainicio,$fechafin,$grupo_id){
        $this->db->select("pv.*,p.Nombre as Producto,pl.Nombre as Plaza,fp.Nombre as Familia");
        $this->db->from("tbl_platillos_vendidos pv");        		
        $this->db->join("tbl_productos p","p.Clave = pv.Clave");
        $this->db->join("tbl_plazas pl","pv.plaza_id = pl.id");
        $this->db->join("tbl_familia_productos fp","p.familia_id = fp.id");        
		$query=$this->db->where("pv.Fecha >=",$fechainicio);
        $query=$this->db->where("pv.Fecha <=",$fechafin);
        $query=$this->db->where("fp.id",$grupo_id);  
        $this->db->order_by("pl.id","asc");	  
        $this->db->group_by(array("pv.Clave", "pl.Nombre")); 	    
        $resultados=$this->db->get();
        return $resultados->result();  
    }

    public function getUnidadesFechaGrupo2(){        
        $resultados=
        $this->db->query
        ("SELECT `tbl_productos`.Nombre as Producto, 
        MIN((if(`tbl_plazas`.`id`=1,tbl_platillos_vendidos.Total,NULL))) as Casitas, 
        MIN((if(`tbl_plazas`.`id`=2,tbl_platillos_vendidos.Total,NULL))) as Matamoros, 
        MIN((if(`tbl_plazas`.`id`=3,tbl_platillos_vendidos.Total,NULL))) as Oaxaca, 
        MIN((if(`tbl_plazas`.`id`=4,tbl_platillos_vendidos.Total,NULL))) as Poza_Rica, 
        MIN((if(`tbl_plazas`.`id`=5,tbl_platillos_vendidos.Total,NULL))) as Reynosa_I, 
        MIN((if(`tbl_plazas`.`id`=6,tbl_platillos_vendidos.Total,NULL))) as Reynosa_II, 
        MIN((if(`tbl_plazas`.`id`=7,tbl_platillos_vendidos.Total,NULL))) as Teziutlan, 
        `tbl_familia_productos`.Nombre FROM `tbl_platillos_vendidos` 
        INNER JOIN `tbl_productos` ON `tbl_productos`.Clave = `tbl_platillos_vendidos`.`Clave` 
        INNER JOIN `tbl_plazas` ON `tbl_plazas`.`id` = `tbl_platillos_vendidos`.`plaza_id` 
        INNER JOIN `tbl_familia_productos` ON `tbl_familia_productos`.`id` = `tbl_productos`.`familia_id` 
        WHERE `tbl_platillos_vendidos`.`Fecha` >= '2018-11-16' 
        and 
              `tbl_familia_productos`.`id`= 1 
        GROUP BY `tbl_productos`.Nombre ");            
        return $resultados->result();  
    }

   
    public function getUnidadesFechaGrupo3($fechainicio,$fechafin,$grupo_id){
        $this->db->select(" `p`.Nombre as Producto, 
        SUM((if(`pl`.`id`=1,pv.Cantidad,NULL))) as Casitas, 
        SUM((if(`pl`.`id`=2,pv.Cantidad,NULL))) as Matamoros, 
        SUM((if(`pl`.`id`=3,pv.Cantidad,NULL))) as Oaxaca, 
        SUM((if(`pl`.`id`=4,pv.Cantidad,NULL))) as Poza_Rica, 
        SUM((if(`pl`.`id`=5,pv.Cantidad,NULL))) as Reynosa_I, 
        SUM((if(`pl`.`id`=6,pv.Cantidad,NULL))) as Reynosa_II, 
        SUM((if(`pl`.`id`=7,pv.Cantidad,NULL))) as Teziutlan,     
        `fp`.Nombre")
        ;
        $this->db->from("tbl_platillos_vendidos_resumen pv");        		
        $this->db->join("tbl_productos p","p.Clave = pv.Clave");
        $this->db->join("tbl_plazas pl","pv.plaza_id = pl.id");
        $this->db->join("tbl_familia_productos fp","p.familia_id = fp.id");        
		$query=$this->db->where("pv.Fecha >=",$fechainicio);
        $query=$this->db->where("pv.Fecha <=",$fechafin);
        $query=$this->db->where("fp.id",$grupo_id);  
        //$this->db->order_by("pl.id","asc");	  
        $this->db->group_by("p.Nombre"); 	    
        $resultados=$this->db->get();
        return $resultados->result();  
    }

    public function getUnidadesFechaGrupoGeneral($fechainicio,$fechafin){
        
        $this->db->select(" `fp`.Nombre as Categoria, 
        SUM((if(`pl`.`id`=1,pv.Cantidad,NULL))) as Casitas, 
        SUM((if(`pl`.`id`=2,pv.Cantidad,NULL))) as Matamoros, 
        SUM((if(`pl`.`id`=3,pv.Cantidad,NULL))) as Oaxaca, 
        SUM((if(`pl`.`id`=4,pv.Cantidad,NULL))) as Poza_Rica, 
        SUM((if(`pl`.`id`=5,pv.Cantidad,NULL))) as Reynosa_I, 
        SUM((if(`pl`.`id`=6,pv.Cantidad,NULL))) as Reynosa_II,
        SUM((if(`pl`.`id`=7,pv.Cantidad,NULL))) as Teziutlan,     
        pv.Fecha as Fecha
        ");


        $this->db->from("tbl_platillos_vendidos_resumen pv");        		
        $this->db->join("tbl_productos p","p.Clave = pv.Clave");
        $this->db->join("tbl_plazas pl","pv.plaza_id = pl.id");
        $this->db->join("tbl_familia_productos fp","p.familia_id = fp.id");        
		$query=$this->db->where("pv.Fecha >=",$fechainicio);
        $query=$this->db->where("pv.Fecha <=",$fechafin);
        //$query=$this->db->where("fp.id",$grupo_id);  
        //$this->db->order_by("pl.id","asc");	  
        $this->db->group_by("fp.Nombre"); 	    
        $resultados=$this->db->get();
        return $resultados->result();  
    }

    public function getUnidadesFechaGrupoGeneralPlaza($fechainicio,$fechafin,$plaza_id){
        
        $this->db->select(" `fp`.Nombre as Categoria, 
        SUM((if(`pl`.`id`=1,pv.Cantidad,NULL))) as Casitas, 
        SUM((if(`pl`.`id`=2,pv.Cantidad,NULL))) as Matamoros, 
        SUM((if(`pl`.`id`=3,pv.Cantidad,NULL))) as Oaxaca, 
        SUM((if(`pl`.`id`=4,pv.Cantidad,NULL))) as Poza_Rica, 
        SUM((if(`pl`.`id`=5,pv.Cantidad,NULL))) as Reynosa_I, 
        SUM((if(`pl`.`id`=6,pv.Cantidad,NULL))) as Reynosa_II,
        SUM((if(`pl`.`id`=7,pv.Cantidad,NULL))) as Teziutlan,     
        pv.Fecha as Fecha
        ");


        $this->db->from("tbl_platillos_vendidos_resumen pv");        		
        $this->db->join("tbl_productos p","p.Clave = pv.Clave");
        $this->db->join("tbl_plazas pl","pv.plaza_id = pl.id");
        $this->db->join("tbl_familia_productos fp","p.familia_id = fp.id");        
		$query=$this->db->where("pv.Fecha >=",$fechainicio);
        $query=$this->db->where("pv.Fecha <=",$fechafin);
        $query=$this->db->where("pv.plaza_id",$plaza_id);  
        //$this->db->order_by("pl.id","asc");	  
        $this->db->group_by("fp.Nombre"); 	    
        $resultados=$this->db->get();
        return $resultados->result();  
    }

    public function getUnidadesFechaGrupoGeneralPlaza2($fechainicio,$fechafin,$plaza_id){
        
        $this->db->select(" `fp`.Nombre as Categoria, 
        SUM(pv.Cantidad) as Plaza,      
        pv.Fecha as Fecha,
        fp.id as categoria_id,
        pl.id as plaza_id
        ");

        $this->db->from("tbl_platillos_vendidos_resumen pv");        		
        $this->db->join("tbl_productos p","p.Clave = pv.Clave");
        $this->db->join("tbl_plazas pl","pv.plaza_id = pl.id");
        $this->db->join("tbl_familia_productos fp","p.familia_id = fp.id");        
		$query=$this->db->where("pv.Fecha >=",$fechainicio);
        $query=$this->db->where("pv.Fecha <=",$fechafin);
        $query=$this->db->where("pv.plaza_id",$plaza_id);  
        //$this->db->order_by("pl.id","asc");	  
        $this->db->group_by("fp.Nombre"); 	    
        $resultados=$this->db->get();
        return $resultados->result();  
    }

    public function getUnidadesGraficoPlaza($fechaInicio,$fechaFin,$plaza_id){
        $this->db->select("CONCAT(f.Nombre,' ',SUM(r.Cantidad)) as Nombre,SUM(r.Cantidad) as Cantidad");
        $this->db->from("tbl_platillos_vendidos_resumen r");        		
        $this->db->join("tbl_productos p","p.Clave = r.Clave");
        $this->db->join("tbl_familia_productos f","f.id = p.familia_id");        
        $query=$this->db->where("r.Fecha >=",$fechaInicio);	
        $query=$this->db->where("r.Fecha <=",$fechaFin);	
        $query=$this->db->where("r.plaza_id",$plaza_id);	        
        $this->db->group_by('f.Nombre'); 	
        $resultados=$this->db->get();
        //echo json_encode($resultados->result());
        return $resultados->result();  
    }
    
    public function getProductosGraficoPlaza($fechaInicio,$fechaFin,$plaza_id,$grupo_id){
        $this->db->select("CONCAT(p.Nombre,' ',SUM(r.Cantidad)) as Nombre,SUM(r.Cantidad) as Cantidad");
        $this->db->from("tbl_platillos_vendidos_resumen r");        		
        $this->db->join("tbl_productos p","p.Clave = r.Clave");
        $this->db->join("tbl_familia_productos f","f.id = p.familia_id");        
        $query=$this->db->where("r.Fecha >=",$fechaInicio);	
        $query=$this->db->where("r.Fecha <=",$fechaFin);	
        $query=$this->db->where("r.plaza_id",$plaza_id);	        
        $query=$this->db->where("f.id",$grupo_id);	        
        $this->db->group_by('p.Nombre'); 	
        $resultados=$this->db->get();
        //echo json_encode($resultados->result())
        return $resultados->result();  
    }




    public function getUnidadesGrafico($fechaInicio,$fechaFin){
        $this->db->select("z.Nombre as Plaza,CONCAT(f.Nombre,' ',SUM(r.Cantidad)) as Nombre,SUM(r.Cantidad) as Cantidad");
        $this->db->from("tbl_platillos_vendidos_resumen r");        		
        $this->db->join("tbl_productos p","p.Clave = r.Clave");
        $this->db->join("tbl_familia_productos f","f.id = p.familia_id");        
        $this->db->join("tbl_plazas z","z.id = r.plaza_id");        
        $query=$this->db->where("r.Fecha >=",$fechaInicio);	
        $query=$this->db->where("r.Fecha <=",$fechaFin);	                
        $this->db->group_by('f.Nombre,r.plaza_id'); 	
        $resultados=$this->db->get();
        //echo json_encode($resultados->result())
        return $resultados->result();  
    }

    
    
}

