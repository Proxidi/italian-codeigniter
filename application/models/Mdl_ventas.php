<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mdl_ventas extends CI_model{
	
	public function getVentas(){
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("r.*,u.Nombre as Usuario,p.Nombre as Plaza");
		$this->db->from("tbl_reporte_ventas r");
		$this->db->join("tbl_usuarios u","r.usuario_id = u.id");
		$this->db->join("tbl_plazas p","r.plaza_id = p.id");		
        $resultados=$this->db->get();
        return $resultados->result();
	}

	public function getVentasID($plaza_id){
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("r.*,u.Nombre as Usuario,p.Nombre as Plaza");
		$this->db->from("tbl_reporte_ventas r");
		$this->db->join("tbl_usuarios u","r.usuario_id = u.id");
		$this->db->join("tbl_plazas p","r.plaza_id = p.id");		
		$query=$this->db->where("r.plaza_id",$plaza_id);
		$this->db->order_by("r.id", "desc");
        $resultados=$this->db->get();
        return $resultados->result();
	}
	
		public function getErroresVentas($fecha){
		$this->db->select("ec.*,p.Nombre as Plaza,p.Acronimo as Acronimo");
		$this->db->from("tbl_envio_cortes ec");		
		$this->db->join("tbl_plazas p","ec.plaza_id = p.id");			
		$this->db->where("ec.Fecha>=",$fecha);
		$this->db->where("ec.Fecha<=",date('Y-m-d'));
		$this->db->where("ec.Enviado",0);
		$this->db->order_by("ec.Fecha","ASC");
		$this->db->order_by('p.id','asc');
		$query=$this->db->get();        
		return $query->result();
	}

	public function getErroresVentasPlazas($plaza_id,$fecha){
		$this->db->select("ec.*,p.Nombre as Plaza,p.Acronimo as Acronimo");
		$this->db->from("tbl_envio_cortes ec");		
		$this->db->join("tbl_plazas p","ec.plaza_id = p.id");			
		$this->db->where("ec.Fecha>=",$fecha);
		$this->db->where("ec.Fecha<=",date('Y-m-d'));
		$this->db->where("ec.Enviado",0);
		$this->db->where("ec.plaza_id",$plaza_id);
		$this->db->order_by("ec.Fecha","ASC");
		$this->db->order_by('p.id','asc');
		$query=$this->db->get();        
		return $query->result();
	}





	public function getVentasIDDia($id,$fechainicio){
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("r.*,u.Nombre as Usuario,p.Nombre as Plaza");
		$this->db->from("tbl_reporte_ventas r");
		$this->db->join("tbl_usuarios u","r.usuario_id = u.id");
		$this->db->join("tbl_plazas p","r.plaza_id = p.id");		
		$query=$this->db->where("r.usuario_id",$id);
		$query=$this->db->where("r.Fecha >=",$fechainicio);			
		$this->db->order_by("r.Fecha", "asc");
        $resultados=$this->db->get();
        return $resultados->result();
	}

	
	public function consultarFechaVenta($fecha,$idPlaza){
		$this->db->select("Fecha");							
		$query=$this->db->where("Fecha",$fecha);
		$query=$this->db->where("plaza_id",$idPlaza);			
		$resultados=$this->db->get("tbl_reporte_ventas");
		if($resultados->num_rows()>0){
			return $resultados->row();
		}
		else{
			return false;
		}
	}

	public function getFolios($fecha,$plaza_id){
		$this->db->select("Tickets");							
		$query=$this->db->where("Fecha",$fecha);
		$query=$this->db->where("plaza_id",$plaza_id);			
		$resultados=$this->db->get("tbl_tickets");
		if($resultados->num_rows()>0){
			return $resultados->row();
		}
		else{
			return false;
		}
	}
	

	public function save($data,$dataU,$fecha,$plaza_id){
		$this->db->trans_begin();   
		 
		$this->db->insert("tbl_reporte_ventas",$data);
		 
		 $this->db->where("Fecha",$fecha);
		 $this->db->where("plaza_id",$plaza_id);
		 
		 $this->db->update('tbl_envio_cortes', $dataU);
		 
		 if ($this->db->trans_status() === FALSE){      
			//Hubo errores en la consulta, entonces se cancela la transacción.   
			$this->db->trans_rollback();      
			return false;    
		 }else{      
			//Todas las consultas se hicieron correctamente.  
			$this->db->trans_commit();    
			return true;    
		 } 
	}

	public function saveTickets($data){
		return $this->db->insert("tbl_tickets",$data);
	}

	public function getVenta($id){
		$this->db->where("id",$id);
		$resultado=$this->db->get("tbl_reporte_ventas");
		return $resultado->row();
	}

	public function getExistencia($fecha,$plaza_id){
		$this->db->select("Fecha");							
		$query=$this->db->where("Fecha",$fecha);
		$query=$this->db->where("plaza_id",$plaza_id);			
		$resultado=$this->db->get("tbl_tickets");
		if($resultado->num_rows()>0){
			return 1;
		}
		else{
			return 0;
		}
	}

	public function getExistenciaCorte($fecha,$plaza_id){		
		$query=$this->db->where("Fecha",$fecha);
		$query=$this->db->where("plaza_id",$plaza_id);			
		$resultado=$this->db->get("tbl_reporte_ventas");
		if($resultado->num_rows()>0){
			return 1;
		}
		else{
			return 0;
		}
	}

	public function getBanderaCorte($plaza_id){
		$this->db->select("Enviado");							
		$query=$this->db->where("Fecha",date('Y-m-d'));
		$query=$this->db->where("plaza_id",$plaza_id);			
		$resultados=$this->db->get("tbl_envio_cortes");
		if($resultados->num_rows()>0){
			return $resultados->row();
		}
		else{
			return false;
		}
	}

	public function getBanderaCorteFecha($fecha,$plaza_id){
		$this->db->select("Enviado");							
		$query=$this->db->where("Fecha",$fecha);
		$query=$this->db->where("plaza_id",$plaza_id);			
		$resultados=$this->db->get("tbl_envio_cortes");
		if($resultados->num_rows()>0){
			return $resultados->row();
		}
		else{
			return false;
		}
	}

	public function update($id,$data){
		$this->db->where("id",$id);
		return $this->db->update("tbl_reporte_ventas",$data);
	}

	public function saveUT($fecha,$plaza_id,$data){
		$this->db->where("Fecha",$fecha);
		$this->db->where("plaza_id",$plaza_id);		
		return $this->db->update("tbl_tickets",$data);				
	}

	public function delete($fecha,$plaza_id){		
		$this->db->where('plaza_id', $plaza_id);
		$this->db->where('Fecha', $fecha);
		return $this->db->delete('tbl_reporte_ventas');		
	}



	public function deleteT($fecha,$plaza_id){		
		$this->db->where('plaza_id', $plaza_id);
		$this->db->where('Fecha', $fecha);
		return $this->db->delete('tbl_tickets');		
	}


	public function deleteAll($fecha,$plaza_id){
		$this->db->trans_begin();   

		$this->db->where('plaza_id', $plaza_id);
		$this->db->where('Fecha', $fecha);
		$this->db->delete('tbl_reporte_ventas');	
		 
		$this->db->where('plaza_id', $plaza_id);
		$this->db->where('Fecha', $fecha);
		$this->db->delete('tbl_tickets');

		$dataU=array('Enviado' =>0);
		$this->db->where('plaza_id', $plaza_id);
		$this->db->where('Fecha', $fecha);
		$this->db->update('tbl_envio_cortes', $dataU);

		 
		 if ($this->db->trans_status() === FALSE){      
			//Hubo errores en la consulta, entonces se cancela la transacción.   
			$this->db->trans_rollback();      
			return false;    
		 }else{      
			//Todas las consultas se hicieron correctamente.  
			$this->db->trans_commit();    
			return true;    
		 } 
	}

	public function checarDLC($fecha,$plaza_id){		
			$this->db->select("DLC");							
			$query=$this->db->where("Fecha",$fecha);
			$query=$this->db->where("plaza_id",$plaza_id);			
			$query=$this->db->where("DLC",1);						
			$resultado=$this->db->get("tbl_envio_cortes");
			if($resultado->num_rows()>0){
				return true;
			}
			else{
				return false;
			}		
	}

	public function actualizarGastos($fecha,$plaza_id,$data){
		$this->db->trans_begin();   

		$this->db->where("Fecha",$fecha);
		$this->db->where("plaza_id",$plaza_id);
		$this->db->update("tbl_reporte_ventas",$data);
	 
		if ($this->db->trans_status() === FALSE){      
		   //Hubo errores en la consulta, entonces se cancela la transacción.   
		   $this->db->trans_rollback();      
		   return false;    
		}else{      
		   //Todas las consultas se hicieron correctamente.  
		   $this->db->trans_commit();    
		   return true;    
		} 
	}

	public function actualizarTPV($fecha,$plaza_id,$data){
		$this->db->trans_begin();   

		$this->db->where("Fecha",$fecha);
		$this->db->where("plaza_id",$plaza_id);
		$this->db->update("tbl_reporte_ventas",$data);
	 
		if ($this->db->trans_status() === FALSE){      
		   //Hubo errores en la consulta, entonces se cancela la transacción.   
		   $this->db->trans_rollback();      
		   return false;    
		}else{      
		   //Todas las consultas se hicieron correctamente.  
		   $this->db->trans_commit();    
		   return true;    
		} 
	}

	public function actualizarTPVDeposito($fecha,$plaza_id,$data1,$data2){
		$this->db->trans_begin();   

		$this->db->where("Fecha",$fecha);
		$this->db->where("plaza_id",$plaza_id);
		$this->db->update("tbl_reporte_ventas",$data1);

		$this->db->where("Fecha_Tabla",$fecha);
		$this->db->where("plaza_id",$plaza_id);
		$this->db->where("tabla_id",1);
		$this->db->update("tbl_depositos_2",$data2);
	 
		
		if ($this->db->trans_status() === FALSE){      
		   //Hubo errores en la consulta, entonces se cancela la transacción.   
		   $this->db->trans_rollback();      
		   return false;    
		}else{      
		   //Todas las consultas se hicieron correctamente.  
		   $this->db->trans_commit();    
		   return true;    
		} 
	}



	public function getTotalVentas($fecha,$plaza_id){

		$this->db->select("r.Total_Ventas as Total");
		$this->db->from("tbl_reporte_ventas r");					
		$this->db->where("r.Fecha",$fecha);
		$this->db->where("r.plaza_id",$plaza_id);				
		$query=$this->db->get();        
		return $query->row();
		
	}

	public function getTotalIngresos($fecha,$plaza_id){
		
		$this->db->select("r.Total_Ingresos as Total");
		$this->db->from("tbl_reporte_ventas r");					
		$this->db->where("r.Fecha",$fecha);
		$this->db->where("r.plaza_id",$plaza_id);				
		$query=$this->db->get();        
		return $query->row();
	}	

	public function getTotalGastos($fecha,$plaza_id){
		
		$this->db->select("r.Total_Gastos as Total");
		$this->db->from("tbl_reporte_ventas r");					
		$this->db->where("r.Fecha",$fecha);
		$this->db->where("r.plaza_id",$plaza_id);				
		$query=$this->db->get();        
		return $query->row();
	}

	
	public function getTotalTPV($fecha,$plaza_id){		
		$this->db->select("r.TPV as Total");
		$this->db->from("tbl_reporte_ventas r");					
		$this->db->where("r.Fecha",$fecha);
		$this->db->where("r.plaza_id",$plaza_id);				
		$query=$this->db->get();        
		return $query->row();
	}

	public function actualizarTablaGastos($fecha,$plaza_id,$data){
		$this->db->trans_begin();   
		$this->db->where("Fecha",$fecha);
		$this->db->where("plaza_id",$plaza_id);
		$this->db->update("tbl_gastos",$data);	
		if ($this->db->trans_status() === FALSE){      
		   //Hubo errores en la consulta, entonces se cancela la transacción.   
		   $this->db->trans_rollback();      
		   return false;    
		}else{      
		   //Todas las consultas se hicieron correctamente.  
		   $this->db->trans_commit();    
		   return true;    
		} 
	}

	//Sacar el penultimo registro maximo de una tabla
	public function getPenultimaFechaInventario($fecha,$plaza_id){				
		$this->db->select("MAX(inv.Fecha) as Fecha");		
		$this->db->from('tbl_historial_completo_if inv');
		$this->db->where("inv.plaza_id",$plaza_id);
		$this->db->where("inv.Fecha <=",$fecha);
		$sub_query = $this->db->get_compiled_select();

		$this->db->select('MAX(i.Fecha) as Fecha');
		$this->db->from('tbl_historial_completo_if i');
		$this->db->where("i.plaza_id",$plaza_id);
		$this->db->where("Fecha < ($sub_query)");
		return $this->db->get()->row();
	}
	

	public function getUltimaFechaInventarioInicial($fecha,$plaza_id){						
		$this->db->select
		(
			"MAX(inv.Fecha) as Fecha"		
		);
		$this->db->from("tbl_historial_completo_if inv");		
		$this->db->where("plaza_id",$plaza_id);		
		$this->db->where("Fecha <=",$fecha);		
        $resultado=$this->db->get();
        return $resultado->row();
	}

	public function getUltimaFechaInventarioFinal($fecha,$plaza_id){
		$this->db->select
		(
			"Fecha as Fecha"		
		);
		$this->db->from("tbl_historial_completo_if inv");		
		$this->db->where("plaza_id",$plaza_id);		
		$this->db->where("Fecha >",$fecha);		
		$this->db->limit(1);
        $resultado=$this->db->get();
        return $resultado->row();
	}

	public function getUltimaFechaInventarioFisico($plaza_id){						
		$this->db->select
		(
			"MAX(inv.Fecha) as Fecha"		
		);
		$this->db->from("tbl_historial_completo_if inv");		
		$this->db->where("plaza_id",$plaza_id);				
        $resultado=$this->db->get();
        return $resultado->row();
	}

	public function getPrimeraFechaInventarioFisico($plaza_id){						
		$this->db->select
		(
			"MIN(inv.Fecha) as Fecha"		
		);
		$this->db->from("tbl_historial_completo_if inv");		
		$this->db->where("plaza_id",$plaza_id);				
        $resultado=$this->db->get();
        return $resultado->row();
	}
	

	public function getValorInsumoInventario($fecha,$plaza_id,$insumo_id){
		$this->db->select("inv.Total as Total,inv.Unidad_Total");
		$this->db->from("tbl_historial_completo_if inv");		
		$this->db->where("Fecha",$fecha);
		$this->db->where("plaza_id",$plaza_id);										
		$this->db->where("insumo_id",$insumo_id);
        $resultado=$this->db->get();
        return $resultado->row();																		
	}	

	public function getValorPedidoInsumo($fechaInicial,$fechaFinal,$plaza_id,$insumo_id){
		$this->db->select("inv.Cantidad_Final as Cantidad_Recibida_Final");
		$this->db->from("tbl_pedidos inv");		
		$this->db->where("Fecha >=",$fechaInicial);
		$this->db->where("Fecha <=",$fechaFinal);												
		$this->db->where("insumo_id",$insumo_id);
		$this->db->where("plaza_id",$plaza_id);
		//1 Revisado 3 Llego pero menos de lo esperado
		$banderas = array(1,3);
		$this->db->where_in('Bandera', $banderas);		
        $resultados=$this->db->get();
        return $resultados->row();
	}
	
	public function getValorPedidoPasteleriaInsumo($fechaInicial,$fechaFinal,$plaza_id,$insumo_id){
		$this->db->select("inv.Cantidad_Final as Cantidad_Recibida_Final");
		$this->db->from("tbl_pedidos_pasteleria inv");		
		$this->db->where("Fecha >=",$fechaInicial);
		$this->db->where("Fecha <=",$fechaFinal);												
		$this->db->where("insumo_id",$insumo_id);
		$this->db->where("plaza_id",$plaza_id);
		//1 Revisado 3 Llego pero menos de lo esperado
		//Verificar mis banderas
		$banderas = array(1,3);
		$this->db->where_in('Bandera', $banderas);		
        $resultados=$this->db->get();
        return $resultados->row();
	}

	public function getSumaIngresos($fechaInicial,$fechaFinal,$plaza_id){
		$this->db->select
		(
			"SUM(Total_Ingresos) as Total"		
		);
		$this->db->from("tbl_reporte_ventas");		
		$this->db->where("plaza_id",$plaza_id);										
		$this->db->where("Fecha >=",$fechaInicial);
		$this->db->where("Fecha <=",$fechaFinal);										
        $resultado=$this->db->get();
        return $resultado->row();
	}

	public function getOperacionCVI($insumo_id){
		$this->db->select("CVI");
		$this->db->from("tbl_insumos_inventario");
		$this->db->where("insumo_id",$insumo_id);		
		$query=$this->db->get();        		
		if($query->num_rows()>0){
			return $query->row();
		}
		else{
			return false;
		}	
	}

	public function getOperacionCVG($insumo_id){
		$this->db->select("CVG");
		$this->db->from("tbl_insumos_inventario");
		$this->db->where("insumo_id",$insumo_id);		
		$query=$this->db->get();        		
		if($query->num_rows()>0){
			return $query->row();
		}
		else{
			return false;
		}	
	}

}

