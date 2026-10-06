<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mdl_inventario extends CI_model{
		
	public function getInventario(){		
		$this->db->select("inv.*,i.Nombre as Nombre,p.Nombre as Plaza,u.Nombre as Unidad");
		$this->db->from("tbl_inventario_productos inv");		
		$this->db->join("tbl_insumos i","inv.insumo_id = i.id");
		$this->db->join("tbl_plazas p","inv.plaza_id = p.id");
		$this->db->join("tbl_unidades u","i.unidad_final = u.id");
		$this->db->order_by('inv.insumo_id', 'ASC');
		$this->db->order_by('inv.plaza_id', 'ASC');
		//$query=$this->db->where("u.Estado","1");				
        $resultados=$this->db->get();
        return $resultados->result();
	}

	public function getInventarios(){		
		$this->db->select("inv.*,i.Nombre as Nombre,p.Nombre as Plaza,u.Nombre as Unidad");
		$this->db->from("tbl_inventario_productos inv");		
		$this->db->join("tbl_insumos i","inv.insumo_id = i.id");
		$this->db->join("tbl_plazas p","inv.plaza_id = p.id");
		$this->db->join("tbl_unidades u","i.unidad_final = u.id");		
		$this->db->order_by('inv.plaza_id', 'ASC');					
        $resultados=$this->db->get();
        return $resultados->result();
	}

	public function getInventarioInsumo($insumo_id){
		
		$this->db->select("inv.*,i.Nombre as Nombre,p.Nombre as Plaza,u.Nombre as Unidad");
		$this->db->from("tbl_inventario_productos inv");		
		$this->db->join("tbl_insumos i","inv.insumo_id = i.id");
		$this->db->join("tbl_plazas p","inv.plaza_id = p.id");
		$this->db->join("tbl_unidades u","i.unidad_final = u.id");
		$this->db->where("inv.insumo_id",$insumo_id);
		$this->db->order_by('inv.insumo_id', 'ASC');
		$this->db->order_by('inv.plaza_id', 'ASC');
		//$query=$this->db->where("u.Estado","1");				
        $resultados=$this->db->get();
        return $resultados->result();
	}
	
	public function getInventarioPlaza($plaza_id){		
		$this->db->select("inv.*,i.Nombre as Nombre,p.Nombre as Plaza,u.Nombre as Unidad");
		$this->db->from("tbl_inventario_productos inv");		
		$this->db->join("tbl_insumos i","inv.insumo_id = i.id");
		$this->db->join("tbl_plazas p","inv.plaza_id = p.id");
		$this->db->join("tbl_unidades u","i.unidad_final = u.id");
		$this->db->where("inv.plaza_id",$plaza_id);
		$this->db->order_by('i.id', 'ASC');						
        $resultados=$this->db->get();
        return $resultados->result();
	}

	public function getInventarioInsumoPlaza($plaza_id,$insumo_id){
		
		$this->db->select("inv.*,i.Nombre as Nombre,p.Nombre as Plaza,u.Nombre as Unidad");
		$this->db->from("tbl_inventario_productos inv");		
		$this->db->join("tbl_insumos i","inv.insumo_id = i.id");
		$this->db->join("tbl_plazas p","inv.plaza_id = p.id");
		$this->db->join("tbl_unidades u","i.unidad_final = u.id");
		$this->db->where("inv.insumo_id",$insumo_id);
		$this->db->where("inv.plaza_id",$plaza_id);
		$this->db->order_by('i.id', 'ASC');
		//$query=$this->db->where("u.Estado","1");				
        $resultados=$this->db->get();
        return $resultados->result();
	}

	public function getNotificaciones(){
		
		$this->db->select("inv.*,i.Nombre as Nombre,p.Nombre as Plaza,u.Nombre as Unidad");
		$this->db->from("tbl_inventario_productos inv");		
		$this->db->join("tbl_insumos i","inv.insumo_id = i.id");
		$this->db->join("tbl_plazas p","inv.plaza_id = p.id");
		$this->db->join("tbl_unidades u","i.unidad_final = u.id");
		$this->db->where("inv.Cantidad <=",70);						
		$this->db->order_by('i.id', 'ASC');						
        $resultados=$this->db->get();
        return $resultados->result();
	}

	public function getCapturaInventario($plaza_id){
		$this->db->select("ci.*,i.Nombre as UnidadB,ii.Nombre as UnidadP,iii.Nombre as UnidadT,in.Nombre as Insumo");
		$this->db->from("tbl_captura_inventario ci");	
		$this->db->join("tbl_unidades i","ci.Unidad_Bodega = i.id");
		$this->db->join("tbl_unidades ii","ci.Unidad_Piso = ii.id");
		$this->db->join("tbl_unidades iii","ci.Unidad_Total = iii.id");
		$this->db->join("tbl_insumos in","ci.insumo_id = in.id");
		$this->db->where("ci.plaza_id",$plaza_id);
		$this->db->where("ci.Activo", 1);
		$this->db->order_by('in.Orden_Captura_Inventario', 'ASC');
		$resultados = $this->db->get();		
		return $resultados->result();
	}
	
	public function getCapturaInventarioGeneral(){
		$this->db->select("ci.*,p.Nombre as Plaza,i.Nombre as UnidadB,ii.Nombre as UnidadP,iii.Nombre as UnidadT,in.Nombre as Insumo");
		$this->db->from("tbl_captura_inventario ci");	
		$this->db->join("tbl_unidades i","ci.Unidad_Bodega = i.id");
		$this->db->join("tbl_unidades ii","ci.Unidad_Piso = ii.id");
		$this->db->join("tbl_unidades iii","ci.Unidad_Total = iii.id");
		$this->db->join("tbl_insumos in","ci.insumo_id = in.id");	
		$this->db->join("tbl_plazas p","ci.plaza_id=p.id");	
		$this->db->order_by('in.Orden_Captura_Inventario', 'ASC');
		$this->db->order_by('p.id', 'ASC');
		$this->db->where("ci.Activo", 1);
		$resultados = $this->db->get();		
		return $resultados->result();
	}

	

	public function getCapturaInventarioGeneralInsumo($insumo_id){
		$this->db->select("ci.*,p.Nombre as Plaza,i.Nombre as UnidadB,ii.Nombre as UnidadP,iii.Nombre as UnidadT,in.Nombre as Insumo");
		$this->db->from("tbl_captura_inventario ci");	
		$this->db->join("tbl_unidades i","ci.Unidad_Bodega = i.id");
		$this->db->join("tbl_unidades ii","ci.Unidad_Piso = ii.id");
		$this->db->join("tbl_unidades iii","ci.Unidad_Total = iii.id");
		$this->db->join("tbl_insumos in","ci.insumo_id = in.id");	
		$this->db->join("tbl_plazas p","ci.plaza_id=p.id");	
		$this->db->where("ci.insumo_id",$insumo_id);
		$this->db->order_by('in.id', 'ASC');
		$this->db->order_by('p.id', 'ASC');
		$resultados = $this->db->get();		
		return $resultados->result();
	}

	

	public function getCapturaInventarioGeneralPlaza($plaza_id){
		$this->db->select("ci.*,p.Nombre as Plaza,i.Nombre as UnidadB,ii.Nombre as UnidadP,iii.Nombre as UnidadT,in.Nombre as Insumo");
		$this->db->from("tbl_captura_inventario ci");	
		$this->db->join("tbl_unidades i","ci.Unidad_Bodega = i.id");
		$this->db->join("tbl_unidades ii","ci.Unidad_Piso = ii.id");
		$this->db->join("tbl_unidades iii","ci.Unidad_Total = iii.id");
		$this->db->join("tbl_insumos in","ci.insumo_id = in.id");	
		$this->db->join("tbl_plazas p","ci.plaza_id=p.id");	
		$this->db->where("ci.plaza_id",$plaza_id);
		$this->db->order_by('in.Orden_Captura_Inventario', 'ASC');
		$this->db->order_by('p.id', 'ASC');
		$this->db->where("ci.Activo", 1);
		$resultados = $this->db->get();		
		return $resultados->result();
	}

	

	public function getCapturaInventarioGeneralPlazaInsumo($plaza_id,$insumo_id){
		$this->db->select("ci.*,p.Nombre as Plaza,i.Nombre as UnidadB,ii.Nombre as UnidadP,iii.Nombre as UnidadT,in.Nombre as Insumo");
		$this->db->from("tbl_captura_inventario ci");	
		$this->db->join("tbl_unidades i","ci.Unidad_Bodega = i.id");
		$this->db->join("tbl_unidades ii","ci.Unidad_Piso = ii.id");
		$this->db->join("tbl_unidades iii","ci.Unidad_Total = iii.id");
		$this->db->join("tbl_insumos in","ci.insumo_id = in.id");	
		$this->db->join("tbl_plazas p","ci.plaza_id=p.id");	
		$this->db->where("ci.plaza_id",$plaza_id);
		$this->db->where("ci.insumo_id",$insumo_id);
		$this->db->order_by('in.id', 'ASC');
		$this->db->order_by('p.id', 'ASC');
		$resultados = $this->db->get();		
		return $resultados->result();
	}

	

	public function getCapturaInventarioPlaza($plaza_id){
		$this->db->select("ci.*,i.Nombre as UnidadB,ii.Nombre as UnidadP,iii.Nombre as UnidadT,in.Nombre as Insumo");
		$this->db->from("tbl_historial_completo_if ci");	
		$this->db->join("tbl_unidades i","ci.Unidad_Bodega = i.id");
		$this->db->join("tbl_unidades ii","ci.Unidad_Piso = ii.id");
		$this->db->join("tbl_unidades iii","ci.Unidad_Total = iii.id");
		$this->db->join("tbl_insumos in","ci.insumo_id = in.id");
		$this->db->where("ci.plaza_id",$plaza_id);
		$this->db->where("Fecha>=",date("Y-m-d", strtotime('07-04-2019')));
		$this->db->where("Fecha<=",date("Y-m-d", strtotime('08-04-2019')));		
		$this->db->order_by('ci.id', 'ASC');
		$resultados = $this->db->get();		
		return $resultados->result();
	}


	public function getCapturaInventarioFechaPlaza($fecha,$plaza_id){
		$this->db->select("ci.*,i.Nombre as UnidadB,ii.Nombre as UnidadP,iii.Nombre as UnidadT,in.Nombre as Insumo");
		$this->db->from("tbl_historial_completo_if ci");	
		$this->db->join("tbl_unidades i","ci.Unidad_Bodega = i.id");
		$this->db->join("tbl_unidades ii","ci.Unidad_Piso = ii.id");
		$this->db->join("tbl_unidades iii","ci.Unidad_Total = iii.id");
		$this->db->join("tbl_insumos in","ci.insumo_id = in.id");
		$this->db->where("ci.plaza_id",$plaza_id);		
		$this->db->where("ci.Fecha",$fecha);
		$this->db->order_by('ci.id', 'ASC');
		$resultados = $this->db->get();		
		return $resultados->result();
	}
	

	public function getCapturaInventario2($plaza_id){			
		$this->db->select("ci.*,i.Nombre as UnidadB,ii.Nombre as UnidadP,iii.Nombre as UnidadT,in.Nombre as Insumo");
		$this->db->from("tbl_captura_inventario ci");	
		$this->db->join("tbl_unidades i","ci.Unidad_Bodega = i.id");
		$this->db->join("tbl_unidades ii","ci.Unidad_Piso = ii.id");
		$this->db->join("tbl_unidades iii","ci.Unidad_Total = iii.id");
		$this->db->join("tbl_insumos in","ci.insumo_id = in.id");
		$this->db->where("ci.plaza_id",$plaza_id);
		$this->db->order_by('ci.id', 'ASC');
		$query = $this->db->get();	
		$output ='';
		
		foreach($query->result() as $row)
		{
			if($row->Bandera==1){
				$output .='<tr bgcolor="#99ddff">';
			}
			else{
				$output .='<tr >';
			}		
				
		$output .= '<td><h4>'.$row->Insumo.'</h4></td>';
		$output .= '<td><h4>'.$row->Bodega.'</h4></td>';
		$output .= '<td><h4>'.$row->Piso.'</h4></td>';
		if($row->Bandera==1){
			$output .= '<td bgcolor="#ffb380"><h4>'.$row->Total.'</h4></td>';
		}
		else{
			$output .= '<td><h4>'.$row->Total.'</h4></td>';
		}		
		$output .= '<td><h4>'.$row->UnidadT.'</h4></td>';
		$output .= '<td> <a href="#" onclick="asignarValoresModal('.$row->id.','.$row->insumo_id.','.$row->Bodega.','.$row->Piso.','.$row->Total.',\''.$row->UnidadB.'\',\''.$row->UnidadP.'\',\''.$row->UnidadT.'\',\''.$row->Insumo.'\')" data-toggle="modal" data-target="#editarInventario" class="btn btn-warning">';	
		$output .= '<span class="fa fa-pencil"> </span></a> </td>';								
		$output.='</tr>';
		}		
		return $output;
	}	


	
	public function getDLCAgregado($plaza_id,$fecha){
		$this->db->select("pv.*,i.Nombre as Nombre");
		$this->db->from("tbl_platillos_vendidos pv");					
		$this->db->where("pv.plaza_id",$plaza_id);
		$this->db->where("pv.Fecha",$fecha);
		$this->db->join("tbl_insumos i","pv.insumo_id = i.id");
		$this->db->order_by('pv.insumo_id',"ASC");
		$this->db->group_by('pv.insumo_id');
		$resultados = $this->db->get();		
		return $resultados->result();
	}

	public function getSumaDLCAgregado($plaza_id,$fecha,$insumo_id){
		$this->db->select("SUM(pv.Total) as Total");
		$this->db->from("tbl_platillos_vendidos pv");			
		$this->db->where("pv.plaza_id",$plaza_id);
		$this->db->where("pv.Fecha",$fecha);
		$this->db->where("pv.insumo_id",$insumo_id);
		$this->db->order_by('pv.insumo_id',"ASC");
		$this->db->group_by('pv.insumo_id');
		$resultados = $this->db->get();		
		return $resultados->row();
	}


	public function conversion($clave){		
		$this->db->select("pi.Cantidad,pi.insumo_id");
		$this->db->from("tbl_productos_insumos pi");
		$this->db->join("tbl_productos p","pi.producto_id = p.id");
		$this->db->where("p.Clave",$clave);
		$query=$this->db->get();        		
		if($query->num_rows()>0){
			return $query->result();
		}
		else{
			return 0;
		}		
	}


	public function save($data){
		return $this->db->insert("tbl_inventario_productos",$data);
	}

	public function saveQuebrantos($data){
		return $this->db->insert_batch("tbl_quebrantos",$data);
	}
	

	public function savePlatillos($data){		
		$this->db->trans_begin();   					 		 
		$this->db->insert_batch('tbl_platillos_vendidos', $data);
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

	public function savePlatillosResumen($data){		
		$this->db->trans_begin();   					 		 
		$this->db->insert_batch('tbl_platillos_vendidos_resumen', $data);
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
	
	
	public function saveUnidades($data){
		return $this->db->insert("tbl_unidades_vendidas",$data);
    }
	
	public function delete($id){
		$this->db->where('id', $id);
		$this->db->delete('tbl_inventario_productos');
		return;
	}

	public function update($id,$data){
		$this->db->where("id",$id);
		return $this->db->update("tbl_inventario_productos",$data);
	}

	public function updateCaptura($insumo_id,$plaza_id,$data){
		$this->db->where("insumo_id",$insumo_id);
		$this->db->where("plaza_id",$plaza_id);
		return $this->db->update("tbl_captura_inventario",$data);
	}

	public function liberarCaptura($plaza_id,$data){
		$this->db->where("plaza_id",$plaza_id);
		return $this->db->update("tbl_captura_inventario",$data);
	}

	
	public function getCantidad($id,$plaza_id){
		$this->db->select("Cantidad");
		$this->db->from("tbl_inventario_productos");
		$this->db->where("insumo_id",$id);
		$this->db->where("plaza_id",$plaza_id);
		$query=$this->db->get();        		
		if($query->num_rows()>0){
			return $query->row();
		}
		else{
			return false;
		}	
	}

	
	public function getCantidadCaptura($insumo_id,$plaza_id,$campo){
		$this->db->select($campo);
		$this->db->from("tbl_captura_inventario");
		$this->db->where("insumo_id",$insumo_id);
		$this->db->where("plaza_id",$plaza_id);
		$query=$this->db->get();        		
		if($query->num_rows()>0){
			return $query->row();
		}
		else{
			return false;
		}
		
	}

	public function getOperacionBodega($insumo_id){
		$this->db->select("Bodega");
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

	public function getOperacionPiso($insumo_id){
		$this->db->select("Piso");
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

	public function getOperacionTotal($insumo_id){
		$this->db->select("Total");
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

	public function getOperacionDLC($insumo_id){
		$this->db->select("DLC");
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


	public function actualizarCantidad($insumo_id,$plaza_id,$data){				
		$this->db->where('insumo_id', $insumo_id);
		$this->db->where('plaza_id', $plaza_id);
		return $this->db->update('tbl_inventario_productos', $data);
	}


	public function actualizarCantidadInventario($plaza_id,$data){				
		$this->db->trans_begin();   					 		 
		$this->db->where('plaza_id', $plaza_id);		
		$this->db->update_batch('tbl_inventario_productos', $data, 'insumo_id');
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

	public function actualizarInventario($plaza_id,$data){		
		$this->db->where('plaza_id', $plaza_id);
		return $this->db->update_batch('tbl_inventario_productos', $data, 'insumo_id');
	}


	public function actualizarMovimiento($data){				
		return $this->db->insert("tbl_movimientos_inventario",$data);
	}

	public function getBandera($insumo_id,$plaza_id){
		$this->db->select("Bandera");
		$this->db->from("tbl_captura_inventario");
		$this->db->where('plaza_id', $plaza_id);
		$this->db->where("insumo_id",$insumo_id);		
		$query=$this->db->get();        		
		if($query->num_rows()>0){
			return $query->row();
		}
		else{
			return false;
		}	
	}

	public function getTotalCapturaInventario($plaza_id){
		$this->db->select("ci.*,i.Nombre as Insumo");
		$this->db->from("tbl_captura_inventario ci");
		$this->db->join("tbl_insumos i","ci.insumo_id = i.id");
		$this->db->where('ci.plaza_id', $plaza_id);	
		$this->db->where("ci.Activo", 1);
		$this->db->order_by('i.Orden_Captura_Inventario', 'ASC');
		$query=$this->db->get();        
		return $query->result();
	}

	public function saveHistorialInventarioFisico($data){
		return $this->db->insert_batch("tbl_historial_completo_if",$data);
	}

	public function actualizarMovimientos($data){
		return $this->db->insert_batch("tbl_movimientos_inventario",$data);
	}

	public function getErroresDLC(){
		$this->db->select("pv.*,p.Nombre as Plaza,u.Nombre as Usuario,,p.Acronimo as Acronimo");
		$this->db->from("tbl_detalles_platillos_vendidos pv");
		$this->db->join("tbl_plazas p","p.id = pv.plaza_id");
		$this->db->join("tbl_usuarios u","u.id=pv.usuario_id");
		$this->db->where('pv.Correcto',0);	
		$this->db->order_by('pv.Fecha','asc');
		$this->db->order_by('p.id','asc');
		$query=$this->db->get();        
		return $query->result();
	}

	//////////////////////Aquí le movi 14_01_2019////////////////////////
	/////////////////////////////////////////////////////////////////////
	public function getExistencia($plaza_id,$one,$two){
		$this->db->select("*");
		$this->db->from("tbl_historial_inventario_fisico");
		$this->db->where('plaza_id',$plaza_id);	
		$this->db->where('Fecha >=',$one);
		$this->db->where('Fecha <=',$two);
		$resultados=$this->db->get();        			
		if($resultados->num_rows()>0){
			return $resultados->row();
		}
		else{
			return false;
		}
	}
	/////////////////////////////////////////////////////////////////////


	//////////////////////Aquí le movi 14_01_2019////////////////////////////
	/////////////////////////////////////////////////////////////////////////
		public function getExistenciaSemana($fechaInicio,$fechaFin,$plaza_id){
			$this->db->select("*");
			$this->db->from("tbl_historial_inventario_fisico");
			$this->db->where('plaza_id',$plaza_id);	
			$this->db->where('Fecha>=',$fechaInicio);
			$this->db->where('Fecha<=',$fechaFin);
			$resultados=$this->db->get();        			
			if($resultados->num_rows()>0){
				return $resultados->row();
			}
			else{
				return false;
			}
		}
	/////////////////////////////////////////////////////////////////////////

	
	//////////////////////14_01_2019/////////////////////////////////////
	//LO CAMBIE DE LUGAR, Y LE MOVI
	/////////////////////////////////////////////////////////////////////
	public function updateDetallesInventarioFisico($plaza_id,$data){
		$this->db->trans_begin();   					 		 
		 $this->db->where("plaza_id",$plaza_id);		 
		 $this->db->update('tbl_historial_inventario_fisico', $data);		 

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
	/////////////////////////////////////////////////////////////////////


	//////////////////////14_01_2019/////////////////////////////////////
	//LO CAMBIE DE LUGAR, Y LE MOVI
	/////////////////////////////////////////////////////////////////////
	public function updateDetallesInventarioFisicoSemana($fechaInicio,$fechaFin,$plaza_id,$data){
		$this->db->trans_begin();   					 		 
		 $this->db->where("plaza_id",$plaza_id);		
		 $this->db->where("Fecha>=",$fechaInicio);
		 $this->db->where("Fecha<=",$fechaFin);		
		 $this->db->update('tbl_historial_inventario_fisico', $data);		 
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
	/////////////////////////////////////////////////////////////////////

	
	public function getCapturasAdministrador(){
		$this->db->select("inv.*,p.Nombre as Plaza,u.Nombre as Usuario");
		$this->db->from("tbl_historial_inventario_fisico inv");
		$this->db->join("tbl_plazas p","p.id = inv.plaza_id");
		$this->db->join("tbl_usuarios u","u.id=inv.usuario_id");					
		$this->db->order_by('inv.plaza_id','asc');
		$query=$this->db->get();        
		return $query->result();
	}

	public function permitirEdicion($fecha,$plaza_id,$data){
		$this->db->select('plaza_id');
		$this->db->where('Fecha', $fecha);
		$this->db->where('plaza_id', $plaza_id);		
		$query=$this->db->get('tbl_historial_inventario_fisico');
		if($query->num_rows()>0){
			$this->db->where('Fecha', $fecha);
			$this->db->where('plaza_id', $plaza_id);			
			return $this->db->update('tbl_historial_inventario_fisico', $data);		
		}else{
			return false;
		}
	}


	public function getPlatillosPlaza($plaza_id){
		$this->db->select("pv.plaza_id as plaza_id,pv.Correcto as Estatus,pv.Fecha as Fecha,p.Nombre as Plaza,u.Nombre as Usuario");
		$this->db->from("tbl_detalles_platillos_vendidos pv");
		$this->db->join("tbl_plazas p","p.id = pv.plaza_id");
		$this->db->join("tbl_usuarios u","u.id=pv.usuario_id");
		$this->db->where('pv.plaza_id',$plaza_id);	
		$this->db->order_by('pv.Fecha','desc');		
		$query=$this->db->get();        
		return $query->result();
	}

	public function getPlatillos(){
		$this->db->select("pv.plaza_id as plaza_id,pv.Correcto as Estatus,pv.Fecha as Fecha,p.Nombre as Plaza,u.Nombre as Usuario");
		$this->db->from("tbl_detalles_platillos_vendidos pv");
		$this->db->join("tbl_plazas p","p.id = pv.plaza_id");
		$this->db->join("tbl_usuarios u","u.id=pv.usuario_id");		
		$this->db->order_by('pv.Fecha','asc');
		$this->db->order_by('p.id','asc');
		$query=$this->db->get();        
		return $query->result();
	}


	public function getFaltantesDLC($fecha){
		$this->db->select("ec.*,p.Nombre as Plaza,p.Acronimo as Acronimo");
		$this->db->from("tbl_envio_cortes ec");		
		$this->db->join("tbl_plazas p","ec.plaza_id = p.id");			
		$this->db->where("ec.Fecha>=",$fecha);
		$this->db->where("ec.Fecha<=",date('Y-m-d'));
		$this->db->where("ec.DLC",0);
		$this->db->order_by('ec.Fecha','asc');
		$this->db->order_by('p.id','asc');
		$query=$this->db->get();        
		return $query->result();
	}

	public function getFaltantesDLCPlaza($plaza_id,$fecha){
		$this->db->select("ec.*,p.Nombre as Plaza,p.Acronimo as Acronimo");
		$this->db->from("tbl_envio_cortes ec");		
		$this->db->join("tbl_plazas p","ec.plaza_id = p.id");			
		$this->db->where("ec.Fecha>=",$fecha);
		$this->db->where("ec.Fecha<=",date('Y-m-d'));
		$this->db->where("ec.DLC",0);
		$this->db->where("ec.plaza_id",$plaza_id);
		$this->db->order_by('ec.Fecha','asc');
		$this->db->order_by('p.id','asc');
		$query=$this->db->get();        
		return $query->result();
	}

	public function consultarFechaDLC($fecha,$plaza_id){
		$this->db->select("Fecha");							
		$query=$this->db->where("Fecha",$fecha);
		$query=$this->db->where("plaza_id",$plaza_id);			
		$resultados=$this->db->get("tbl_detalles_platillos_vendidos");
		if($resultados->num_rows()>0){
			return $resultados->row();
		}
		else{
			return false;
		}
	}

	public function saveDetallesPlatillos($data){
		$this->db->trans_begin();   
		$this->db->insert("tbl_detalles_platillos_vendidos",$data);	
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

	public function deleteDetallesPlatillos($fecha,$plaza_id){
		$bandera=false;
		$this->db->trans_begin();   									
		$this->db->where("Fecha",$fecha);
		$this->db->where("plaza_id",$plaza_id);		
		$this->db->delete("tbl_detalles_platillos_vendidos");	
		if($this->db->affected_rows()){
			$bandera=true;
		}
		else{
			$bandera=false;
		}
	   if ($this->db->trans_status() === FALSE){      
		   //Hubo errores en la consulta, entonces se cancela la transacción.   
		   $this->db->trans_rollback();      
		   return false;
		   //return false;    
		}else{      
		   //Todas las consultas se hicieron correctamente.  
		   $this->db->trans_commit();    
		   return $bandera;    
		}  			  	
	}


	public function eliminarPlatillosVendidos($fecha,$plaza_id){
		$bandera=false;
		$this->db->trans_begin();   			
		
		$this->db->where("Fecha",$fecha);
		$this->db->where("plaza_id",$plaza_id);		
		$this->db->delete("tbl_platillos_vendidos");	

		$this->db->where("Fecha",$fecha);
		$this->db->where("plaza_id",$plaza_id);		
		$this->db->delete("tbl_platillos_vendidos_resumen");	

		if($this->db->affected_rows()){
			$bandera=true;
		}
		else{
			$bandera=false;
		}
	   if ($this->db->trans_status() === FALSE){      
		   //Hubo errores en la consulta, entonces se cancela la transacción.   
		   $this->db->trans_rollback();      
		   return false;
		   //return false;    
		}else{      
		   //Todas las consultas se hicieron correctamente.  
		   $this->db->trans_commit();    
		   return $bandera;    
		}  			  	
	}

	public function saveDetallesInventarioFisico($data){
		$this->db->trans_begin();   
		$this->db->insert("tbl_historial_inventario_fisico",$data);	
		if ($this->db->trans_status() === FALSE){      			
			$this->db->trans_rollback();      
			return false;    
		}else{      			
			$this->db->trans_commit();    
			return true;    
		}  	
	}

	public function actualizarDetallesPlatillos($usuario_id,$fecha,$plaza_id,$data,$dataU){
		$this->db->trans_begin();   	
		$this->db->where("plaza_id",$plaza_id);			
		$this->db->update('tbl_detalles_platillos_vendidos', $data);
		 
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


	public function getUnidadesPlatillos($fecha,$plaza_id){
		$this->db->select("Unidades");
		$this->db->from("tbl_detalles_platillos_vendidos");
		$this->db->where('plaza_id', $plaza_id);
		$this->db->where("Fecha",$fecha);
		$this->db->where("Correcto",1);		
		$query=$this->db->get();        		
		if($query->num_rows()>0){
			return $query->row();
		}
		else{
			return false;
		}
	}

	/*
	public function getUltimaCantidad($plaza_id,$insumo_id){
		$this->db->select("mi.Nueva_Cantidad as Nueva_Cantidad ");
		$this->db->from("tbl_movimientos_inventario mi");			
		$this->db->where("mi.plaza_id",$plaza_id);
		$this->db->where("mi.insumo_id",$insumo_id);			
		$this->db->order_by('mi.id', 'desc');
		$this->db->limit(1);			
		$resultados = $this->db->get();		
		return $resultados->row();
	}*/

	public function getUltimaCantidad($plaza_id,$insumo_id){
		$this->db->select("mi.*");
		$this->db->from("tbl_movimientos_inventario mi");			
		$this->db->where("mi.plaza_id",$plaza_id);
		$this->db->where("mi.insumo_id",$insumo_id);			
		$this->db->order_by('mi.id', 'desc');
		$this->db->limit(1);			
		$resultados = $this->db->get();		
		return $resultados->row();
	}

	public function getMovimientos(){
		$this->db->select("mi.*,u.Nombre as Usuario,p.Nombre as Plaza,p.Acronimo as Acronimo,i.Nombre as Insumo,uni.Nombre as Unidad");
		$this->db->from("tbl_movimientos_inventario mi");	
		$this->db->join("tbl_usuarios u","mi.usuario_id = u.id");
		$this->db->join("tbl_plazas p","mi.plaza_id = p.id");
		$this->db->join("tbl_insumos i","mi.insumo_id = i.id");	
		$this->db->join("tbl_unidades uni","i.unidad_final = uni.id");			
		$this->db->where("mi.Fecha",date('Y-m-d',strtotime("-1 days")));			
		$this->db->order_by('mi.plaza_id', 'ASC');
		$this->db->order_by('mi.id', 'ASC');
		$resultados = $this->db->get();		
		return $resultados->result();
	}

	public function getMovimientosFecha($fechaInicio,$fechaFin){
		$this->db->select("mi.*,u.Nombre as Usuario,p.Nombre as Plaza,p.Acronimo as Acronimo,i.Nombre as Insumo,uni.Nombre as Unidad");
		$this->db->from("tbl_movimientos_inventario mi");	
		$this->db->join("tbl_usuarios u","mi.usuario_id = u.id");
		$this->db->join("tbl_plazas p","mi.plaza_id = p.id");
		$this->db->join("tbl_insumos i","mi.insumo_id = i.id");	
		$this->db->join("tbl_unidades uni","i.unidad_final = uni.id");			
		$this->db->where("mi.Fecha>=",$fechaInicio);			
		$this->db->where("mi.Fecha<=",$fechaFin);			
		$this->db->order_by('mi.plaza_id', 'ASC');
		$this->db->order_by('mi.id', 'ASC');

		$resultados = $this->db->get();		
		return $resultados->result();
	}

	public function getMovimientosPlaza($plaza_id,$fechaInicio,$fechaFin){
		$this->db->select("mi.*,u.Nombre as Usuario,p.Nombre as Plaza,p.Acronimo as Acronimo,i.Nombre as Insumo,uni.Nombre as Unidad");
		$this->db->from("tbl_movimientos_inventario mi");	
		$this->db->join("tbl_usuarios u","mi.usuario_id = u.id");
		$this->db->join("tbl_plazas p","mi.plaza_id = p.id");
		$this->db->join("tbl_insumos i","mi.insumo_id = i.id");	
		$this->db->join("tbl_unidades uni","i.unidad_final = uni.id");			
		$this->db->where("mi.Fecha>=",$fechaInicio);			
		$this->db->where("mi.Fecha<=",$fechaFin);
		$this->db->where("mi.plaza_id",$plaza_id);			
		$this->db->order_by('mi.id', 'ASC');
		$resultados = $this->db->get();		
		return $resultados->result();
	}

	public function getMovimientosPlazaInsumo($plaza_id,$insumo_id,$fechaInicio,$fechaFin){
		$this->db->select("mi.*,u.Nombre as Usuario,p.Nombre as Plaza,p.Acronimo as Acronimo,i.Nombre as Insumo,uni.Nombre as Unidad");
		$this->db->from("tbl_movimientos_inventario mi");	
		$this->db->join("tbl_usuarios u","mi.usuario_id = u.id");
		$this->db->join("tbl_plazas p","mi.plaza_id = p.id");
		$this->db->join("tbl_insumos i","mi.insumo_id = i.id");	
		$this->db->join("tbl_unidades uni","i.unidad_final = uni.id");			
		$this->db->where("mi.Fecha>=",$fechaInicio);			
		$this->db->where("mi.Fecha<=",$fechaFin);
		$this->db->where("mi.plaza_id",$plaza_id);			
		$this->db->where("mi.insumo_id",$insumo_id);			
		$this->db->order_by('mi.id', 'ASC');
		$resultados = $this->db->get();		
		return $resultados->result();
	}

	public function getMovimientosInsumo($insumo_id,$fechaInicio,$fechaFin){
		$this->db->select("mi.*,u.Nombre as Usuario,p.Nombre as Plaza,p.Acronimo as Acronimo,i.Nombre as Insumo,uni.Nombre as Unidad");
		$this->db->from("tbl_movimientos_inventario mi");	
		$this->db->join("tbl_usuarios u","mi.usuario_id = u.id");
		$this->db->join("tbl_plazas p","mi.plaza_id = p.id");
		$this->db->join("tbl_insumos i","mi.insumo_id = i.id");	
		$this->db->join("tbl_unidades uni","i.unidad_final = uni.id");			
		$this->db->where("mi.Fecha>=",$fechaInicio);			
		$this->db->where("mi.Fecha<=",$fechaFin);			
		$this->db->where("mi.insumo_id",$insumo_id);			
		$this->db->order_by('mi.plaza_id', 'ASC');
		$this->db->order_by('mi.id', 'ASC');
		$resultados = $this->db->get();		
		return $resultados->result();
	}

	public function actualizarStock($insumo_id,$plaza_id,$data){				
		$this->db->where('insumo_id', $insumo_id);
		$this->db->where('plaza_id', $plaza_id);
		return $this->db->update('tbl_inventario_productos', $data);
	}

	public function getStocksAJAX()
	{					
		$this->db->select("inv.*,i.Nombre as Nombre,p.Nombre as Plaza,u.Nombre as Unidad");
		$this->db->from("tbl_inventario_productos inv");		
		$this->db->join("tbl_insumos i","inv.insumo_id = i.id");
		$this->db->join("tbl_plazas p","inv.plaza_id = p.id");
		$this->db->join("tbl_unidades u","i.unidad_final = u.id");
		$this->db->order_by('inv.insumo_id', 'ASC');
		$this->db->order_by('inv.plaza_id', 'ASC');				           
		$query = $this->db->get();	
		$output ='';
		foreach($query->result() as $row)
		{			
		$output .='<tr >';		
		
		switch ($row->plaza_id) {
			case 1:
			$output .= '<td bgcolor="#bae6ff"><h4>'.$row->Plaza.'</h4></td>';
			break;
			
			case 2:
			$output .= '<td bgcolor="#FA8072"><h4>'.$row->Plaza.'</h4></td>';
			break;

			case 3:
			$output .= '<td bgcolor="#8cedbc"><h4>'.$row->Plaza.'</h4></td>';
			break;

			case 4:
			$output .= '<td bgcolor="#ecccbb"><h4>'.$row->Plaza.'</h4></td>';
			break;

			case 5:
			$output .= '<td bgcolor="#ffd682"><h4>'.$row->Plaza.'</h4></td>';
			break;

			case 6:
			$output .= '<td bgcolor="#e7bbec"><h4>'.$row->Plaza.'</h4></td>';
			break;

			case 7:
			$output .= '<td bgcolor="#3396ff"><h4>'.$row->Plaza.'</h4></td>';
			break;						
		}
									
		$output .= '<td><h4>'.$row->Nombre.'</h4></td>';
		$output .= '<td><h4>'.$row->stock_minimo.'</h4></td>';
		$output .= '<td><h4>'.$row->stock_medio.'</h4></td>';	
		$output .= '<td><h4>'.$row->Unidad.'</h4></td>';	
		$output .= '<td><button type="button" class="btn btn-info"  onclick="asignarValoresModalStock(\''.$row->Nombre.'\','.$row->stock_minimo.','.$row->stock_medio.',\''.$row->Unidad.'\','.$row->plaza_id.','.$row->insumo_id.')" data-toggle="modal" data-target="#editarStock" >';	
		$output .= '<span class="fa fa-edit"> </span></button></td>';		
			
		$output.='</tr>';
		}		
		return $output;
	}

	public function getStocksAJAXPlaza($plaza_id)
	{					
		$this->db->select("inv.*,i.Nombre as Nombre,p.Nombre as Plaza,u.Nombre as Unidad");
		$this->db->from("tbl_inventario_productos inv");		
		$this->db->join("tbl_insumos i","inv.insumo_id = i.id");
		$this->db->join("tbl_plazas p","inv.plaza_id = p.id");
		$this->db->join("tbl_unidades u","i.unidad_final = u.id");
		$this->db->where('inv.plaza_id', $plaza_id);
		$this->db->order_by('inv.insumo_id', 'ASC');
		$this->db->order_by('inv.plaza_id', 'ASC');				           
		$query = $this->db->get();	
		$output ='';
		foreach($query->result() as $row)
		{			
		$output .='<tr >';		
		
		switch ($row->plaza_id) {
			case 1:
			$output .= '<td bgcolor="#bae6ff"><h4>'.$row->Plaza.'</h4></td>';
			break;
			
			case 2:
			$output .= '<td bgcolor="#FA8072"><h4>'.$row->Plaza.'</h4></td>';
			break;

			case 3:
			$output .= '<td bgcolor="#8cedbc"><h4>'.$row->Plaza.'</h4></td>';
			break;

			case 4:
			$output .= '<td bgcolor="#ecccbb"><h4>'.$row->Plaza.'</h4></td>';
			break;

			case 5:
			$output .= '<td bgcolor="#ffd682"><h4>'.$row->Plaza.'</h4></td>';
			break;

			case 6:
			$output .= '<td bgcolor="#e7bbec"><h4>'.$row->Plaza.'</h4></td>';
			break;

			case 7:
			$output .= '<td bgcolor="#3396ff"><h4>'.$row->Plaza.'</h4></td>';
			break;						
		}
								
		$output .= '<td><h4>'.$row->Nombre.'</h4></td>';
		$output .= '<td><h4>'.$row->stock_minimo.'</h4></td>';	
		$output .= '<td><h4>'.$row->stock_medio.'</h4></td>';	
		$output .= '<td><h4>'.$row->Unidad.'</h4></td>';	

		$output .= '<td><button type="button" class="btn btn-info"  onclick="asignarValoresModalStock(\''.$row->Nombre.'\','.$row->stock_minimo.','.$row->stock_medio.',\''.$row->Unidad.'\','.$row->plaza_id.','.$row->insumo_id.')" data-toggle="modal" data-target="#editarStock" >';	
		$output .= '<span class="fa fa-edit"> </span></button></td>';		
			
		$output.='</tr>';
		}		
		return $output;
	}

	public function getOperacionPedido($insumo_id){
		$this->db->select("Pedido");
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
	
	public function getQuebranto2(){
		
		$this->db->select
		(
		"inv.*,
		p.Nombre as Plaza,
		i.Nombre as Insumo,
			i.categoria_quebranto_id as categoria_quebranto_id,
			MAX((if(inv.Fecha='2026-01-02',inv.Cantidad,NULL))) as Uno, 
			MAX((if(inv.Fecha='2026-01-09',inv.Cantidad,NULL))) as Dos, 
			MAX((if(inv.Fecha='2026-01-16',inv.Cantidad,NULL))) as Tres,
			MAX((if(inv.Fecha='2026-01-23',inv.Cantidad,NULL))) as Cuatro,
		u.Nombre as Unidad"		
		);
		$this->db->from("tbl_quebrantos inv");		
		$this->db->join("tbl_insumos i","inv.insumo_id = i.id");
		$this->db->join("tbl_plazas p","inv.plaza_id = p.id");
		$this->db->join("tbl_unidades u","i.unidad_final = u.id");
		$this->db->group_by('p.id', 'ASC');					
		$this->db->group_by('i.Nombre', 'ASC');					
        $resultados=$this->db->get();
        return $resultados->result();
	}

	public function getQuebrantoCategoria2($categoria_id_filtrar){
		
		$this->db->select
		(
		"inv.*,
		p.Nombre as Plaza,
		i.Nombre as Insumo, 
			i.categoria_quebranto_id as categoria_quebranto_id,
			MAX((if(inv.Fecha='2026-01-02',inv.Cantidad,NULL))) as Uno, 
			MAX((if(inv.Fecha='2026-01-09',inv.Cantidad,NULL))) as Dos, 
			MAX((if(inv.Fecha='2026-01-16',inv.Cantidad,NULL))) as Tres,
			MAX((if(inv.Fecha='2026-01-23',inv.Cantidad,NULL))) as Cuatro,
		u.Nombre as Unidad"		
		);
		$this->db->from("tbl_quebrantos inv");		
		$this->db->join("tbl_insumos i","inv.insumo_id = i.id");
		$this->db->join("tbl_plazas p","inv.plaza_id = p.id");
		$this->db->join("tbl_unidades u","i.unidad_final = u.id");
		$this->db->where('i.categoria_quebranto_id',$categoria_id_filtrar);					
		$this->db->order_by('i.Nombre,p.id', 'ASC');					
		$this->db->group_by('p.id,i.Nombre');					
		//$this->db->group_by('i.Nombre', 'ASC');					
        $resultados=$this->db->get();
        return $resultados->result();
	}

	public function getQuebrantoPlaza2($plaza_id){
		
		$this->db->select
		(
		"inv.*,
		p.Nombre as Plaza,
		i.Nombre as Insumo, 
			i.categoria_quebranto_id as categoria_quebranto_id,
			MAX((if(inv.Fecha='2026-01-02',inv.Cantidad,NULL))) as Uno, 
			MAX((if(inv.Fecha='2026-01-09',inv.Cantidad,NULL))) as Dos, 
			MAX((if(inv.Fecha='2026-01-16',inv.Cantidad,NULL))) as Tres,
			MAX((if(inv.Fecha='2026-01-23',inv.Cantidad,NULL))) as Cuatro,
		u.Nombre as Unidad"		
		);
		$this->db->from("tbl_quebrantos inv");		
		$this->db->join("tbl_insumos i","inv.insumo_id = i.id");
		$this->db->join("tbl_plazas p","inv.plaza_id = p.id");
		$this->db->join("tbl_unidades u","i.unidad_final = u.id");
		$this->db->where("inv.plaza_id",$plaza_id);	
		$this->db->group_by('p.id', 'ASC');					
		$this->db->group_by('i.Nombre', 'ASC');					
        $resultados=$this->db->get();
        return $resultados->result();
	}


	public function getQuebrantoPlazaCategoria2($plaza_id,$categoria_id_filtrar){
		
		$this->db->select
		(
		"inv.*,
		p.Nombre as Plaza,
		i.Nombre as Insumo, 
			i.categoria_quebranto_id as categoria_quebranto_id,
			MAX((if(inv.Fecha='2026-01-02',inv.Cantidad,NULL))) as Uno, 
			MAX((if(inv.Fecha='2026-01-09',inv.Cantidad,NULL))) as Dos, 
			MAX((if(inv.Fecha='2026-01-16',inv.Cantidad,NULL))) as Tres,
			MAX((if(inv.Fecha='2026-01-23',inv.Cantidad,NULL))) as Cuatro,
			u.Nombre as Unidad"		
		);
		$this->db->from("tbl_quebrantos inv");		
		$this->db->join("tbl_insumos i","inv.insumo_id = i.id");
		$this->db->join("tbl_plazas p","inv.plaza_id = p.id");
		$this->db->join("tbl_unidades u","i.unidad_final = u.id");
		$this->db->where("inv.plaza_id",$plaza_id);	
		$this->db->where('i.categoria_quebranto_id',$categoria_id_filtrar);		
		$this->db->group_by('p.id', 'ASC');					
		$this->db->group_by('i.Nombre', 'ASC');					
        $resultados=$this->db->get();
        return $resultados->result();
	}

	public function getQuebrantoInsumo2($insumo_id){
		
		$this->db->select
		(
		"inv.*,
		p.Nombre as Plaza,
		i.Nombre as Insumo, 
			i.categoria_quebranto_id as categoria_quebranto_id,
			MAX((if(inv.Fecha='2026-01-02',inv.Cantidad,NULL))) as Uno, 
			MAX((if(inv.Fecha='2026-01-09',inv.Cantidad,NULL))) as Dos, 
			MAX((if(inv.Fecha='2026-01-16',inv.Cantidad,NULL))) as Tres,
			MAX((if(inv.Fecha='2026-01-23',inv.Cantidad,NULL))) as Cuatro,
		u.Nombre as Unidad"	);
		$this->db->from("tbl_quebrantos inv");		
		$this->db->join("tbl_insumos i","inv.insumo_id = i.id");
		$this->db->join("tbl_plazas p","inv.plaza_id = p.id");
		$this->db->join("tbl_unidades u","i.unidad_final = u.id");
		$this->db->where("inv.insumo_id",$insumo_id);	
		$this->db->group_by('p.id', 'ASC');					
		$this->db->group_by('i.Nombre', 'ASC');					
        $resultados=$this->db->get();
        return $resultados->result();
	}

	public function getQuebrantoInsumoPlaza2($insumo_id,$plaza_id){		
		$this->db->select
		(
		"inv.*,
		p.Nombre as Plaza,
		i.Nombre as Insumo, 
			i.categoria_quebranto_id as categoria_quebranto_id,
			MAX((if(inv.Fecha='2026-01-02',inv.Cantidad,NULL))) as Uno, 
			MAX((if(inv.Fecha='2026-01-09',inv.Cantidad,NULL))) as Dos, 
			MAX((if(inv.Fecha='2026-01-16',inv.Cantidad,NULL))) as Tres,
			MAX((if(inv.Fecha='2026-01-23',inv.Cantidad,NULL))) as Cuatro,
		u.Nombre as Unidad");
		$this->db->from("tbl_quebrantos inv");		
		$this->db->join("tbl_insumos i","inv.insumo_id = i.id");
		$this->db->join("tbl_plazas p","inv.plaza_id = p.id");
		$this->db->join("tbl_unidades u","i.unidad_final = u.id");
		$this->db->where("inv.insumo_id",$insumo_id);
		$this->db->where("inv.plaza_id",$plaza_id);	
		$this->db->group_by('p.id', 'ASC');					
		$this->db->group_by('i.Nombre', 'ASC');					
        $resultados=$this->db->get();
        return $resultados->result();
	}


	public function getFechasQuebrantos(){
		$this->db->select("inv.*,p.Nombre as Plaza");
		$this->db->from("tbl_quebrantos inv");				
		$this->db->join("tbl_plazas p","inv.plaza_id = p.id");	
		$this->db->group_by('inv.plaza_id', 'ASC');			
		$this->db->group_by('inv.Fecha', 'ASC');	
        $resultados=$this->db->get();
        return $resultados->result();
	}

	public function getFechasQuebrantosPlaza($plaza_id){
		$this->db->select("inv.*,p.Nombre as Plaza");
		$this->db->from("tbl_quebrantos inv");				
		$this->db->join("tbl_plazas p","inv.plaza_id = p.id");	
		$this->db->where("inv.plaza_id",$plaza_id);			
		$this->db->group_by('inv.Fecha', 'ASC');	
        $resultados=$this->db->get();
        return $resultados->result();
	}

	public function getNotificacionesQuebrantos(){
		$this->db->select("inv.*,i.Nombre as Nombre,p.Nombre as Plaza,u.Nombre as Unidad");
		$this->db->from("tbl_quebrantos inv");
		$this->db->join("tbl_insumos i","inv.insumo_id = i.id");
		$this->db->join("tbl_plazas p","inv.plaza_id = p.id");
		$this->db->join("tbl_unidades u","i.unidad_final = u.id");
		$this->db->where("inv.Cantidad <", 0);
		$this->db->order_by('inv.Fecha', 'DESC');
		$this->db->order_by('i.id', 'ASC');
		$this->db->limit(100);
		$resultados = $this->db->get();
		return $resultados->result();
	}

	public function getNotificacionesQuebrantosPlaza($plaza_id){
		$this->db->select("inv.*,i.Nombre as Nombre,p.Nombre as Plaza,u.Nombre as Unidad");
		$this->db->from("tbl_quebrantos inv");		
		$this->db->join("tbl_insumos i","inv.insumo_id = i.id");
		$this->db->join("tbl_plazas p","inv.plaza_id = p.id");
		$this->db->where("inv.plaza_id",$plaza_id);	
		$this->db->join("tbl_unidades u","i.unidad_final = u.id");
		$this->db->where("inv.Cantidad <",0);						
		$this->db->order_by('i.id', 'ASC');						
        $resultados=$this->db->get();
        return $resultados->result();
	}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////AREA DE PRUEBAS/////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////

public function getEstatusCIF2($fechaInicio,$fechaFin,$plaza_id){		
	$this->db->select("Inventario");
	$this->db->from("tbl_historial_inventario_fisico");
	$this->db->where('plaza_id',$plaza_id);				
	$this->db->where("Fecha>=",$fechaInicio);
	$this->db->where("Fecha<=",$fechaFin);						
	$resultados=$this->db->get();        			
	if($resultados->num_rows()>0){
		return $resultados->row();
	}
	else{
		return false;
	}		
}

public function getCapturaInventarioPlaza2($fechaInicio,$fechaFin,$plaza_id){
	$this->db->select("ci.*,i.Nombre as UnidadB,ii.Nombre as UnidadP,iii.Nombre as UnidadT,in.Nombre as Insumo");
	$this->db->from("tbl_historial_completo_if ci");	
	$this->db->join("tbl_unidades i","ci.Unidad_Bodega = i.id");
	$this->db->join("tbl_unidades ii","ci.Unidad_Piso = ii.id");
	$this->db->join("tbl_unidades iii","ci.Unidad_Total = iii.id");
	$this->db->join("tbl_insumos in","ci.insumo_id = in.id");
	$this->db->where("ci.plaza_id",$plaza_id);
	$this->db->where("Fecha>=",$fechaInicio);
	$this->db->where("Fecha<=",$fechaFin);		
	$this->db->order_by('ci.id', 'ASC');
	$resultados = $this->db->get();		
	return $resultados->result();
}

public function getCapturaInventarioGeneralHistorico2($fechaInicio,$fechaFin){
	$this->db->select("ci.*,p.Nombre as Plaza,i.Nombre as UnidadB,ii.Nombre as UnidadP,iii.Nombre as UnidadT,in.Nombre as Insumo");
	$this->db->from("tbl_historial_completo_if ci");	
	$this->db->join("tbl_unidades i","ci.Unidad_Bodega = i.id");
	$this->db->join("tbl_unidades ii","ci.Unidad_Piso = ii.id");
	$this->db->join("tbl_unidades iii","ci.Unidad_Total = iii.id");
	$this->db->join("tbl_insumos in","ci.insumo_id = in.id");	
	$this->db->join("tbl_plazas p","ci.plaza_id=p.id");		
	$this->db->where("ci.Fecha>=",$fechaInicio);
	$this->db->where("ci.Fecha<=",$fechaFin);
	$this->db->order_by('in.Orden_Captura_Inventario', 'ASC');
	$this->db->order_by('p.id', 'ASC');
	$resultados = $this->db->get();		
	return $resultados->result();
}


public function getCapturaInventarioGeneralInsumoHistorico2($fechaInicio,$fechaFin,$insumo_id){
	$this->db->select("ci.*,p.Nombre as Plaza,i.Nombre as UnidadB,ii.Nombre as UnidadP,iii.Nombre as UnidadT,in.Nombre as Insumo");
	$this->db->from("tbl_historial_completo_if ci");	
	$this->db->join("tbl_unidades i","ci.Unidad_Bodega = i.id");
	$this->db->join("tbl_unidades ii","ci.Unidad_Piso = ii.id");
	$this->db->join("tbl_unidades iii","ci.Unidad_Total = iii.id");
	$this->db->join("tbl_insumos in","ci.insumo_id = in.id");	
	$this->db->join("tbl_plazas p","ci.plaza_id=p.id");		
	$this->db->where("ci.Fecha>=",$fechaInicio);
	$this->db->where("ci.Fecha<=",$fechaFin);
	$this->db->where("ci.insumo_id",$insumo_id);
	$this->db->order_by('in.Orden_Captura_Inventario', 'ASC');
	$this->db->order_by('p.id', 'ASC');
	$resultados = $this->db->get();		
	return $resultados->result();
}


public function getCapturaInventarioGeneralPlazaHistorico2($fechaInicio,$fechaFin,$plaza_id){
	$this->db->select("ci.*,p.Nombre as Plaza,i.Nombre as UnidadB,ii.Nombre as UnidadP,iii.Nombre as UnidadT,in.Nombre as Insumo");
	$this->db->from("tbl_historial_completo_if ci");	
	$this->db->join("tbl_unidades i","ci.Unidad_Bodega = i.id");
	$this->db->join("tbl_unidades ii","ci.Unidad_Piso = ii.id");
	$this->db->join("tbl_unidades iii","ci.Unidad_Total = iii.id");
	$this->db->join("tbl_insumos in","ci.insumo_id = in.id");	
	$this->db->join("tbl_plazas p","ci.plaza_id=p.id");		
	$this->db->where("ci.Fecha>=",$fechaInicio);
	$this->db->where("ci.Fecha<=",$fechaFin);
	$this->db->where("ci.plaza_id",$plaza_id);
	$this->db->order_by('in.Orden_Captura_Inventario', 'ASC');
	$this->db->order_by('p.id', 'ASC');
	$resultados = $this->db->get();		
	return $resultados->result();
}


	public function getCapturaInventarioGeneralPlazaInsumoHistorico2($fechaInicio,$fechaFin,$plaza_id,$insumo_id){
		$this->db->select("ci.*,p.Nombre as Plaza,i.Nombre as UnidadB,ii.Nombre as UnidadP,iii.Nombre as UnidadT,in.Nombre as Insumo");
		$this->db->from("tbl_historial_completo_if ci");	
		$this->db->join("tbl_unidades i","ci.Unidad_Bodega = i.id");
		$this->db->join("tbl_unidades ii","ci.Unidad_Piso = ii.id");
		$this->db->join("tbl_unidades iii","ci.Unidad_Total = iii.id");
		$this->db->join("tbl_insumos in","ci.insumo_id = in.id");	
		$this->db->join("tbl_plazas p","ci.plaza_id=p.id");		
		$this->db->where("ci.Fecha>=",$fechaInicio);
		$this->db->where("ci.Fecha<=",$fechaFin);
		$this->db->where("ci.plaza_id",$plaza_id);
		$this->db->where("ci.insumo_id",$insumo_id);
		$this->db->order_by('in.Orden_Captura_Inventario', 'ASC');
		$this->db->order_by('p.id', 'ASC');
		$resultados = $this->db->get();		
		return $resultados->result();
	}


	public function getMensajes2($fechaInicio,$fechaFin){		
		$this->db->select("inv.*,p.Nombre as Plaza,u.Nombre as Usuario");
		$this->db->from("tbl_historial_inventario_fisico inv");
		$this->db->join("tbl_plazas p","p.id = inv.plaza_id");
		$this->db->join("tbl_usuarios u","u.id=inv.usuario_id");											
		$this->db->where("inv.Fecha>=",$fechaInicio);
		$this->db->where("inv.Fecha<=",$fechaFin);
		$this->db->order_by('inv.plaza_id', 'ASC');
		$resultados = $this->db->get();		
		return $resultados->result();
	}

	public function getMensajesPlaza2($fechaInicio,$fechaFin,$plaza_id){		
		$this->db->select("inv.*,p.Nombre as Plaza,u.Nombre as Usuario");
		$this->db->from("tbl_historial_inventario_fisico inv");
		$this->db->join("tbl_plazas p","p.id = inv.plaza_id");
		$this->db->join("tbl_usuarios u","u.id=inv.usuario_id");											
		$this->db->where("inv.Fecha>=",$fechaInicio);
		$this->db->where("inv.Fecha<=",$fechaFin);
		$this->db->where("inv.plaza_id",$plaza_id);
		$this->db->order_by('inv.plaza_id', 'ASC');
		$resultados = $this->db->get();		
		return $resultados->result();
	}


	public function getLiberaciones2($fechaInicio,$fechaFin){		
		$this->db->select("inv.*");
		$this->db->from("tbl_historial_inventario_fisico inv");		
		$this->db->where("inv.Fecha>=",$fechaInicio);
		$this->db->where("inv.Fecha<=",$fechaFin);	
		$this->db->where("inv.Inventario",1);		
		$resultados = $this->db->get();		
		return $resultados->result();
	}

	public function getFechasRespaldos(){
		$this->db->select("inv.*,p.Nombre as Plaza,u.Nombre as Usuario");
		$this->db->from("tbl_respaldos_inventario inv");				
		$this->db->join("tbl_plazas p","inv.plaza_id = p.id");	
		$this->db->join("tbl_usuarios u","inv.usuario_id = u.id");	
		$this->db->join("tbl_insumos i","inv.insumo_id = i.id");
		$this->db->group_by("inv.plaza_id,inv.Fecha,inv.Hora");		
		$this->db->order_by("inv.plaza_id","ASC");			
		$resultados=$this->db->get();
		return $resultados->result();
	}

	public function getFechasRespaldosPlaza($plaza_id){
		$this->db->select("inv.*,p.Nombre as Plaza,u.Nombre as Usuario");
		$this->db->from("tbl_respaldos_inventario inv");				
		$this->db->where("inv.plaza_id",$plaza_id);
		$this->db->join("tbl_plazas p","inv.plaza_id = p.id");	
		$this->db->join("tbl_usuarios u","inv.usuario_id = u.id");	
		$this->db->join("tbl_insumos i","inv.insumo_id = i.id");
		$this->db->group_by("inv.plaza_id,inv.Fecha,inv.Hora");		
		$this->db->order_by("inv.plaza_id","ASC");			
		$resultados=$this->db->get();
		return $resultados->result();
	}

	public function saveRespaldo($data){
		return $this->db->insert_batch("tbl_respaldos_inventario",$data);
	}

	public function getRespaldoInventario($fecha,$hora,$plaza_id){
		$this->db->select("inv.*,p.Nombre as Plaza,u.Nombre as Usuario,i.Nombre as Insumo");
		$this->db->from("tbl_respaldos_inventario inv");				
		$this->db->where("inv.plaza_id",$plaza_id);
		$this->db->where("inv.Fecha",$fecha);
		$this->db->where("inv.Hora",$hora);
		$this->db->join("tbl_plazas p","inv.plaza_id = p.id");	
		$this->db->join("tbl_usuarios u","inv.usuario_id = u.id");	
		$this->db->join("tbl_insumos i","inv.insumo_id = i.id");		
		$this->db->order_by("inv.insumo_id","ASC");			
		$resultados=$this->db->get();
		return $resultados->result();
	}

	public function eliminarRespaldoInventarioPlaza($fecha,$hora,$plaza_id){
		$this->db->where('Fecha',$fecha);
		$this->db->where('Hora',$hora);
		$this->db->where('plaza_id', $plaza_id);
		$this->db->delete('tbl_respaldos_inventario');
		if($this->db->affected_rows()){
			return true;
		}
		else{
			return false;
		}
	}

	/////////////////////////////////////////////////////////////////////////////////////
	public function getSumaInsumosReceta($fecha,$plaza_id){
		$this->db->select("SUM(inv.Total) as Cantidad,i.Nombre as Insumo,ii.DLC as Operacion");
		$this->db->from("tbl_platillos_vendidos inv");				
		$this->db->where("inv.plaza_id",$plaza_id);
		$this->db->where("inv.Fecha",$fecha);			
		$this->db->join("tbl_insumos i","inv.insumo_id = i.id");
		$this->db->join("tbl_insumos_inventario ii","inv.insumo_id=ii.insumo_id");
		$this->db->group_by("inv.insumo_id");				
		$resultados=$this->db->get();
		return $resultados->result();
	}
	/////////////////////////////////////////////////////////////////////////////////////////
	public function getMaquinas(){
        //Aquí se valida que la categoria se encuentre activa
		$resultados = $this->db->get("tbl_maquinas");
		return $resultados->result();
	}

	public function saveMaquina($data){
		return $this->db->insert("tbl_maquinas",$data);
	}
	
	public function actualizarMaquina($id,$data){
		$this->db->where("id",$id);
		return $this->db->update("tbl_maquinas",$data);			
	}

	public function getRefacciones(){
        //Aquí se valida que la categoria se encuentre activa		
		$this->db->select("r.*,m.Nombre as Maquina");
		$this->db->from("tbl_refacciones r");						
		$this->db->join("tbl_maquinas m","r.maquina_id = m.id");			
		$resultados=$this->db->get();
		return $resultados->result();
	}

	public function getRefaccionesID($maquina_id){        
		$this->db->select("r.*,m.Nombre as Maquina");		
		$this->db->from("tbl_refacciones r");		
		$this->db->where("r.maquina_id",$maquina_id);						
		$this->db->join("tbl_maquinas m","r.maquina_id = m.id");			
		$resultados=$this->db->get();
		return $resultados->result();
	}

	public function saveRefaccion($data){
		return $this->db->insert("tbl_refacciones",$data);
	}
	
	public function actualizarRefaccion($id,$data){
		$this->db->where("id",$id);
		return $this->db->update("tbl_refacciones",$data);			
	}

	public function getPlazasMaquinaria(){
        //Aquí se valida que la categoria se encuentre activa
		$resultados = $this->db->get("tbl_plazas_maquinaria");
		return $resultados->result();
	}

	public function getMaquinaria(){
        //Aquí se valida que la categoria se encuentre activa		
		$this->db->select("m.*,n.Nombre as Maquina,p.Nombre as Plaza");
		$this->db->from("tbl_maquinaria m");						
		$this->db->join("tbl_maquinas n","m.maquina_id = n.id");			
		$this->db->join("tbl_plazas_maquinaria p","m.plaza_maquinaria_id = p.id");			
		$resultados=$this->db->get();
		return $resultados->result();
	}

	public function saveMaquinaria($data){
		return $this->db->insert("tbl_maquinaria",$data);
	}

	public function actualizarMaquinaria($id,$data){
		$this->db->where("id",$id);
		return $this->db->update("tbl_maquinaria",$data);			
	}

	public function getCategoriasQuebrantos(){
		$this->db->order_by("Nombre","desc");	
		$resultados = $this->db->get("tbl_categorias_quebrantos");			
		return $resultados->result();
	}

	/**
    * NUEVA MANERA DE CAPTURAR EL INVENTARIO FISICO
    */

	public function getInsumoSiguienteIF($insumo_id,$plaza_id){
		$this->db->select("c.*,i.Nombre as NombreInsumo,u.Nombre as UnidadBodega,uu.Nombre as UnidadPiso,uuu.Nombre as UnidadTotal,i.Orden_Captura_Inventario as OrdenCapturaInventario");		
		$this->db->from("tbl_captura_inventario c");		
		$this->db->where('i.Orden_Captura_Inventario',$insumo_id);
		$this->db->where('c.plaza_id',$plaza_id);		
		$this->db->where("c.Activo", 1);
		$this->db->join("tbl_insumos i","c.insumo_id = i.id");
		$this->db->join("tbl_unidades u","c.Unidad_Bodega = u.id");
		$this->db->join("tbl_unidades uu","c.Unidad_Piso = uu.id");
		$this->db->join("tbl_unidades uuu","c.Unidad_Total = uuu.id");
		$this->db->order_by('i.Orden_Captura_Inventario', 'ASC');
		$resultados=$this->db->get();        			
		if($resultados->num_rows()>0){
			return $resultados->row();
		}
		else{
			return false;
		}
	}

	public function getCapturaInventarioPrueba($plaza_id) {			
		$this->db->select("ci.*,i.Nombre as UnidadB,ii.Nombre as UnidadP,iii.Nombre as UnidadT,in.Nombre as Insumo,in.Orden_Captura_Inventario as OrdenCapturaInventario");
		$this->db->from("tbl_captura_inventario ci");
		$this->db->join("tbl_unidades i","ci.Unidad_Bodega = i.id");
		$this->db->join("tbl_unidades ii","ci.Unidad_Piso = ii.id");
		$this->db->join("tbl_unidades iii","ci.Unidad_Total = iii.id");
		$this->db->join("tbl_insumos in","ci.insumo_id = in.id");
		$this->db->where("ci.plaza_id", $plaza_id);
		$this->db->where("ci.Activo", 1);
		$this->db->order_by('in.Orden_Captura_Inventario', 'ASC');
		$query = $this->db->get();	
		$output ='';
		$contador = 1;
		
		foreach($query->result() as $row)
		{
			if($row->Bandera==1){
				$output .='<tr bgcolor="#99ddff">';
			}
			else{
				$output .='<tr >';
			}		

			$output .= '<td><h4>'.$contador.'</h4></td>';
			$output .= '<td><h4>'.$row->Insumo.'</h4></td>';	
			$output .= '<td><h4>'.$row->Insumo.'</h4></td>';
			$output .= '<td><h4>'.$row->Bodega.'</h4></td>';
			$output .= '<td><h4>'.$row->Piso.'</h4></td>';
			if($row->Bandera==1){
				$output .= '<td bgcolor="#ffb380"><h4>'.$row->Total.'</h4></td>';
			}
			else{
				$output .= '<td><h4>'.$row->Total.'</h4></td>';
			}		
			$output .= '<td><h4>'.$row->UnidadT.'</h4></td>';
			$output .= '<td> <a href="#" onclick="asignarValoresModal('.$row->id.','.$row->insumo_id.','.$row->Bodega.','.$row->Piso.','.$row->Total.',\''.$row->UnidadB.'\',\''.$row->UnidadP.'\',\''.$row->UnidadT.'\',\''.$row->Insumo.'\','.$row->Bandera.','.$row->OrdenCapturaInventario.')" data-toggle="modal" data-target="#modalNuevaCapturaDatos" class="btn btn-warning">';	
			$output .= '<span class="fa fa-pencil"> </span></a> </td>';								
			$output.='</tr>';
			$contador++;
		}		
		
		
		return $output;
	}	

	public function getCapturaInventarioPruebaOrden($plaza_id){
		$this->db->select("ci.*,i.Nombre as UnidadB,ii.Nombre as UnidadP,iii.Nombre as UnidadT,in.Nombre as Insumo, in.Orden_Captura_Inventario as OrdenCapturaInventario");
		$this->db->from("tbl_captura_inventario ci");	
		$this->db->join("tbl_unidades i","ci.Unidad_Bodega = i.id");
		$this->db->join("tbl_unidades ii","ci.Unidad_Piso = ii.id");
		$this->db->join("tbl_unidades iii","ci.Unidad_Total = iii.id");
		$this->db->join("tbl_insumos in","ci.insumo_id = in.id");
		$this->db->where("ci.plaza_id", $plaza_id);
		$this->db->where("ci.Activo", 1);
		$this->db->order_by('in.Orden_Captura_Inventario', 'ASC');
		$resultados = $this->db->get();		
		return $resultados->result();
	}

	public function get_max_value_with_alias($column_name, $alias, $table_name) {
        $this->db->select_max($column_name, $alias);
        $query = $this->db->get($table_name);

        if ($query->num_rows() > 0) {
            return $query->row()->$alias; // Returns the max value using the alias
        } else {
            return NULL;
        }
    }

	/**
    * NUEVA MANERA DE CAPTURAR EL INVENTARIO FISICO
    */

	// =========================================================================
	// SERVER-SIDE: MODAL NOTIFICACIONES (#tbl_datos)
	// =========================================================================

	public function getNotificacionesDT($start, $length, $search = null)
	{
		$this->db->select("inv.Cantidad, i.Nombre as Insumo, p.Nombre as Plaza");
		$this->db->from("tbl_quebrantos inv");
		$this->db->join("tbl_insumos i", "inv.insumo_id = i.id");
		$this->db->join("tbl_plazas p", "inv.plaza_id = p.id");
		$this->db->where("inv.Cantidad <", 0);

		if (!empty($search)) {
			$this->db->group_start();
			$this->db->like('p.Nombre', $search);
			$this->db->or_like('i.Nombre', $search);
			$this->db->group_end();
		}

		$this->db->order_by('inv.Fecha', 'DESC');
		$this->db->order_by('i.id', 'ASC');
		$this->db->limit($length, $start);
		return $this->db->get()->result();
	}

	public function countTotalNotificacionesDT()
	{
		$this->db->from("tbl_quebrantos");
		$this->db->where("Cantidad <", 0);
		return $this->db->count_all_results();
	}

	public function countFilteredNotificacionesDT($search = null)
	{
		$this->db->from("tbl_quebrantos inv");
		$this->db->join("tbl_insumos i", "inv.insumo_id = i.id");
		$this->db->join("tbl_plazas p", "inv.plaza_id = p.id");
		$this->db->where("inv.Cantidad <", 0);

		if (!empty($search)) {
			$this->db->group_start();
			$this->db->like('p.Nombre', $search);
			$this->db->or_like('i.Nombre', $search);
			$this->db->group_end();
		}

		return $this->db->count_all_results();
	}

	// =========================================================================
	// SERVER-SIDE: TABLA PRINCIPAL QUEBRANTOS (#tbl_inventario)
	// =========================================================================

	private function _aplicarFiltrosQuebrantosDT($plazaId, $categoriaId, $insumoId, $search)
	{
		if (!empty($plazaId)) {
			$this->db->where('inv.plaza_id', $plazaId);
		}
		if (!empty($categoriaId)) {
			$this->db->where('i.categoria_quebranto_id', $categoriaId);
		}
		if (!empty($insumoId)) {
			$this->db->where('inv.insumo_id', $insumoId);
		}
		if (!empty($search)) {
			$this->db->group_start();
			$this->db->like('p.Nombre', $search);
			$this->db->or_like('i.Nombre', $search);
			$this->db->group_end();
		}
	}

	public function getQuebrantosDT($start, $length, $search, $plazaId, $categoriaId, $insumoId)
	{
		$this->db->select("
            inv.plaza_id,
            p.Nombre as Plaza,
            i.Nombre as Insumo,
            i.categoria_quebranto_id,
            MAX(IF(inv.Fecha='2026-01-02', inv.Cantidad, NULL)) as Uno, 
            MAX(IF(inv.Fecha='2026-01-09', inv.Cantidad, NULL)) as Dos, 
            MAX(IF(inv.Fecha='2026-01-16', inv.Cantidad, NULL)) as Tres,
            MAX(IF(inv.Fecha='2026-01-23', inv.Cantidad, NULL)) as Cuatro,
            u.Nombre as Unidad
        ");
		$this->db->from("tbl_quebrantos inv");
		$this->db->join("tbl_insumos i", "inv.insumo_id = i.id");
		$this->db->join("tbl_plazas p", "inv.plaza_id = p.id");
		$this->db->join("tbl_unidades u", "i.unidad_final = u.id");

		$this->_aplicarFiltrosQuebrantosDT($plazaId, $categoriaId, $insumoId, $search);

		$this->db->group_by(['p.id', 'i.Nombre']);
		$this->db->order_by('p.id', 'ASC');
		$this->db->order_by('i.Nombre', 'ASC');
		$this->db->limit($length, $start);

		return $this->db->get()->result();
	}

	public function countTotalQuebrantosDT($plazaId = null, $categoriaId = null, $insumoId = null, $search = null)
	{
		$this->db->select("p.id");
		$this->db->from("tbl_quebrantos inv");
		$this->db->join("tbl_insumos i", "inv.insumo_id = i.id");
		$this->db->join("tbl_plazas p", "inv.plaza_id = p.id");

		$this->_aplicarFiltrosQuebrantosDT($plazaId, $categoriaId, $insumoId, $search);

		$this->db->group_by(['p.id', 'i.Nombre']);
		$query = $this->db->get();
		return $query->num_rows();
	}

	// =========================================================================
	// CONSULTAS DINÁMICAS (DRY) PARA INVENTARIO Y MOVIMIENTOS
	// =========================================================================

	public function getInventarioFiltrado($plaza_id = null, $insumo_id = null)
	{
		$this->db->select("inv.*, i.Nombre as Nombre, p.Nombre as Plaza, u.Nombre as Unidad");
		$this->db->from("tbl_inventario_productos inv");
		$this->db->join("tbl_insumos i", "inv.insumo_id = i.id");
		$this->db->join("tbl_plazas p", "inv.plaza_id = p.id");
		$this->db->join("tbl_unidades u", "i.unidad_final = u.id");

		// Filtros dinámicos
		if (!empty($plaza_id)) {
			$this->db->where("inv.plaza_id", $plaza_id);
		}
		if (!empty($insumo_id)) {
			$this->db->where("inv.insumo_id", $insumo_id);
		}

		$this->db->order_by('i.id', 'ASC');
		$this->db->order_by('inv.plaza_id', 'ASC');
		return $this->db->get()->result();
	}

	public function getMovimientosFiltrados($fechaInicio = null, $fechaFin = null, $plaza_id = null, $insumo_id = null)
	{
		$this->db->select("mi.*, u.Nombre as Usuario, p.Nombre as Plaza, p.Acronimo as Acronimo, i.Nombre as Insumo, uni.Nombre as Unidad");
		$this->db->from("tbl_movimientos_inventario mi");
		$this->db->join("tbl_usuarios u", "mi.usuario_id = u.id");
		$this->db->join("tbl_plazas p", "mi.plaza_id = p.id");
		$this->db->join("tbl_insumos i", "mi.insumo_id = i.id");
		$this->db->join("tbl_unidades uni", "i.unidad_final = uni.id");

		// Filtros dinámicos
		if (!empty($fechaInicio)) {
			$this->db->where("mi.Fecha >=", $fechaInicio);
		}
		if (!empty($fechaFin)) {
			$this->db->where("mi.Fecha <=", $fechaFin);
		}
		if (!empty($plaza_id)) {
			$this->db->where("mi.plaza_id", $plaza_id);
		}
		if (!empty($insumo_id)) {
			$this->db->where("mi.insumo_id", $insumo_id);
		}

		$this->db->order_by('mi.plaza_id', 'ASC');
		$this->db->order_by('mi.id', 'DESC'); // Mejor ver los movimientos recientes primero
		return $this->db->get()->result();
	}
}

