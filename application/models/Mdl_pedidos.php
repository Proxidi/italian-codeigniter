<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mdl_pedidos extends CI_model{

	public function addInsumoPedidoPasteleria($data){
		return $this->db->insert("tbl_temp_pedidos_pasteleria",$data);
	}

	

	public function save($data){
		return $this->db->insert("tbl_pedidos",$data);
	}

	public function savePedidos($data){
		return $this->db->insert_batch('tbl_pedidos', $data);		
	}

	public function savePedidoPasteleria($data){
		return $this->db->insert_batch('tbl_pedidos_pasteleria', $data);		
	}

	public function saveDetallesPedido($data){
		return $this->db->insert('tbl_detalles_pedido', $data);
	}

	public function saveDetallesPedidoPasteleria($data){
		return $this->db->insert('tbl_detalles_pedido_pasteleria', $data);
	}

	public function getPedidos(){		
		$this->db->select("p.*");
		$this->db->from("tbl_pedidos p");		
        $resultados=$this->db->get();
        return $resultados->result();
	}

	public function getDetallesPedido(){			
		$this->db->select("dp.*,p.Nombre as Plaza");
		$this->db->from("tbl_detalles_pedido dp");
		$this->db->join("tbl_plazas p","p.id = dp.plaza_id");	
		$this->db->where("dp.Liberado",0);				
		$resultados=$this->db->get();
		return $resultados->result();
	}

	public function getDetallesPedidoPasteleria(){			
		$this->db->select("dp.*,p.Nombre as Plaza");
		$this->db->from("tbl_detalles_pedido_pasteleria dp");
		$this->db->join("tbl_plazas p","p.id = dp.plaza_id");	
		$this->db->where("dp.Estatus",0);				
		$resultados=$this->db->get();
		return $resultados->result();
	}

	public function getDetallesPedidoLiberadoPasteleria(){			
		$this->db->select("dp.*,p.Nombre as Plaza,p.Acronimo as Acronimo");
		$this->db->from("tbl_detalles_pedido_pasteleria dp");
		$this->db->join("tbl_plazas p","p.id = dp.plaza_id");	
		$this->db->where("dp.Estatus",1);				
		$resultados=$this->db->get();
		return $resultados->result();
	}

	public function getDetallesPedidoLiberadoPasteleriaFecha($fechainicio,$fechafin){			
		$this->db->select("dp.*,p.Nombre as Plaza,p.Acronimo as Acronimo");
		$this->db->from("tbl_detalles_pedido_pasteleria dp");
		$this->db->join("tbl_plazas p","p.id = dp.plaza_id");			
		$this->db->where("dp.Estatus",1);				
		$this->db->where("dp.Fecha>=",$fechainicio);				
		$this->db->where("dp.Fecha<=",$fechafin);				
		$resultados=$this->db->get();
		return $resultados->result();
	}


	public function getInsumosPedidoPasteleria(){			
		$this->db->select("pp.*,p.Nombre as Plaza,i.Nombre as Insumo");
		$this->db->from("tbl_temp_pedidos_pasteleria pp");
		$this->db->join("tbl_plazas p","p.id = pp.plaza_id");		
		$this->db->join("tbl_insumos i","i.id = pp.insumo_id");			
		$resultados=$this->db->get();
		return $resultados->result();
	}

	public function eliminarInsumoTempPasteleria($code){
		$this->db->where('id', $code);
		$this->db->delete('tbl_temp_pedidos_pasteleria');
		if($this->db->affected_rows()){
			return true;
		}
		else{
			return false;
		}
	}

	public function getDetallesPedidoLiberado(){			
		$this->db->select("dp.*,p.Nombre as Plaza,p.Acronimo as Acronimo");
		$this->db->from("tbl_detalles_pedido dp");
		$this->db->join("tbl_plazas p","p.id = dp.plaza_id");	
		$this->db->where("dp.Liberado",1);				
		$resultados=$this->db->get();
		return $resultados->result();
	}

	public function getDetallesPedidoLiberadoPlaza($plaza_id){			
		$this->db->select("dp.*,p.Nombre as Plaza,p.Acronimo as Acronimo");
		$this->db->from("tbl_detalles_pedido dp");
		$this->db->join("tbl_plazas p","p.id = dp.plaza_id");	
		$this->db->where("dp.plaza_id",$plaza_id);				
		$this->db->where("dp.Liberado",1);				
		$resultados=$this->db->get();
		return $resultados->result();
	}

	public function getDetallesPedidoLiberadoPasteleriaPlaza($plaza_id){			
		$this->db->select("dp.*,p.Nombre as Plaza,p.Acronimo as Acronimo");
		$this->db->from("tbl_detalles_pedido_pasteleria dp");
		$this->db->join("tbl_plazas p","p.id = dp.plaza_id");	
		$this->db->where("dp.plaza_id",$plaza_id);				
		$this->db->where("dp.Estatus",1);				
		$resultados=$this->db->get();
		return $resultados->result();
	}

	public function getDetallesPedidoLiberadoPlazaFecha($plaza_id,$fechainicio,$fechafin){			
		$this->db->select("dp.*,p.Nombre as Plaza,p.Acronimo as Acronimo");
		$this->db->from("tbl_detalles_pedido dp");
		$this->db->join("tbl_plazas p","p.id = dp.plaza_id");	
		$this->db->where("dp.plaza_id",$plaza_id);				
		$this->db->where("dp.Liberado",1);				
		$this->db->where("dp.Fecha>=",$fechainicio);				
		$this->db->where("dp.Fecha<=",$fechafin);				
		$resultados=$this->db->get();
		return $resultados->result();
	}

	public function getDetallesPedidoLiberadoPasteleriaPlazaFecha($plaza_id,$fechainicio,$fechafin){			
		$this->db->select("dp.*,p.Nombre as Plaza,p.Acronimo as Acronimo");
		$this->db->from("tbl_detalles_pedido_pasteleria dp");
		$this->db->join("tbl_plazas p","p.id = dp.plaza_id");	
		$this->db->where("dp.plaza_id",$plaza_id);				
		$this->db->where("dp.Estatus",1);				
		$this->db->where("dp.Fecha>=",$fechainicio);				
		$this->db->where("dp.Fecha<=",$fechafin);				
		$resultados=$this->db->get();
		return $resultados->result();
	}

	public function getDetallesPedidoLiberadoFecha($fechainicio,$fechafin){			
		$this->db->select("dp.*,p.Nombre as Plaza,p.Acronimo as Acronimo");
		$this->db->from("tbl_detalles_pedido dp");
		$this->db->join("tbl_plazas p","p.id = dp.plaza_id");			
		$this->db->where("dp.Liberado",1);				
		$this->db->where("dp.Fecha>=",$fechainicio);				
		$this->db->where("dp.Fecha<=",$fechafin);				
		$resultados=$this->db->get();
		return $resultados->result();
	}



	public function getDetallesPedidoPlaza($plaza_id){			
		$this->db->select("dp.*,p.Nombre as Plaza");
		$this->db->from("tbl_detalles_pedido dp");
		$this->db->join("tbl_plazas p","p.id = dp.plaza_id");
		$this->db->where("dp.plaza_id",$plaza_id);
		$this->db->where("dp.Liberado",1);
		$this->db->order_by("dp.Fecha","desc");	 					
		$resultados=$this->db->get();
		return $resultados->result();
	}

	public function getPedido($fecha,$plaza_id)
	{			
		$this->db->select("pd.*,p.Nombre as Plaza");
		$this->db->from("tbl_pedidos pd");	

		$this->db->join("tbl_plazas p","p.id = pd.plaza_id");		
		$this->db->where("pd.Fecha",$fecha);
		$this->db->where("pd.plaza_id",$plaza_id);		
		$query = $this->db->get();	
		$output ='';
		
		foreach($query->result() as $row)
		{			
		$output .='<tr >';	
		if($row->Bandera==1 || $row->Bandera==3){
			$output .= '<td bgcolor="#99ddff">REVISADO</td>';
		}
		else if($row->Bandera==2){
			$output .= '<td bgcolor="#ff0000">NO LLEGO</td>';
		}
		//Seria 0
		else{
			$output .= '<td>NO REVISADO</td>';
		}

		if($row->Bandera==1 || $row->Bandera==3){
			if($row->Cantidad_Pedido==$row->Cantidad_Inventario){
				$output .= '<td >MISMA CANTIDAD</td>';
			}
			else if($row->Cantidad_Pedido>$row->Cantidad_Inventario){
				$output .= '<td >CAPTURA MENOR A PEDIDO</td>';
			}
			else if($row->Cantidad_Pedido<$row->Cantidad_Inventario){
				$output .= '<td>CAPTURA MAYOR A PEDIDO</td>';
			}			
		}
		else if($row->Bandera==2){
			$output .= '<td>NO LLEGO</td>';
		}
		//Seria 0
		else{
			$output .= '<td>NO REVISADO</td>';
		}
		
		$output .= '<td>'.$row->Plaza.'</td>';				
		$output .= '<td>'.$row->Nombre.'</td>';
		$output .= '<td>'.$row->Cantidad_Pedido.'</td>';
		$output .= '<td>'.$row->Cantidad_Inventario.'</td>';
		$output .= '<td>'.$row->Cantidad_Final.'</td>';							
		$output.='</tr>';
		}		
		return $output;
	}	

	public function getPedidoPasteleria($fecha,$plaza_id){
		$this->db->select("pd.*,p.Nombre as Plaza,i.Nombre as Insumo");
		$this->db->from("tbl_pedidos_pasteleria pd");	
		$this->db->join("tbl_plazas p","p.id = pd.plaza_id");	
		$this->db->join("tbl_insumos i","i.id = pd.insumo_id");	
		$this->db->where("pd.Fecha",$fecha);
		$this->db->where("pd.plaza_id",$plaza_id);			
		$this->db->order_by("pd.id","asc");	 	
		$resultados = $this->db->get();	
		return $resultados->result();
	}

	public function getPedidoManager($fecha,$plaza_id){			
		$this->db->select("pd.*,p.Nombre as Plaza,u.Nombre as Unidad");
		$this->db->from("tbl_pedidos pd");	
		$this->db->join("tbl_plazas p","p.id = pd.plaza_id");	
		$this->db->join("tbl_insumos i","i.id = pd.insumo_id");		
		$this->db->join("tbl_unidades u","u.id = i.unidad_pedido");		
		$this->db->where("pd.Fecha",$fecha);
		$this->db->where("pd.plaza_id",$plaza_id);		
		$resultados = $this->db->get();	
		return $resultados->result();						
	}	

	public function getPedidoManagerPasteleria($fecha,$plaza_id){			
		$this->db->select("pd.*,p.Nombre as Plaza,u.Nombre as Unidad,i.Nombre as Nombre");
		$this->db->from("tbl_pedidos_pasteleria pd");	
		$this->db->join("tbl_plazas p","p.id = pd.plaza_id");	
		$this->db->join("tbl_insumos i","i.id = pd.insumo_id");		
		$this->db->join("tbl_unidades u","u.id = i.unidad_pedido");		
		$this->db->where("pd.Fecha",$fecha);
		$this->db->where("pd.plaza_id",$plaza_id);		
		$resultados = $this->db->get();	
		return $resultados->result();						
	}	
	

	public function miPedido($fecha,$plaza_id){			
		$this->db->select("pd.*,p.Nombre as Plaza");
		$this->db->from("tbl_detalles_pedido pd");	
		$this->db->join("tbl_plazas p","p.id = pd.plaza_id");			
		$this->db->where("pd.Fecha",$fecha);
		$this->db->where("pd.plaza_id",$plaza_id);		
		$resultados = $this->db->get();	
		return $resultados->result();						
	}

	public function miPedidoPasteleria($fecha,$plaza_id){			
		$this->db->select("pd.*,p.Nombre as Plaza");
		$this->db->from("tbl_detalles_pedido_pasteleria pd");	
		$this->db->join("tbl_plazas p","p.id = pd.plaza_id");			
		$this->db->where("pd.Fecha",$fecha);
		$this->db->where("pd.plaza_id",$plaza_id);		
		$resultados = $this->db->get();	
		return $resultados->result();						
	}

	public function getPedidoPlaza($fecha,$plaza_id){			
		$this->db->select("pd.*,p.Nombre as Plaza,i.Nombre as Nombre,u.Nombre as Unidad");
		$this->db->from("tbl_pedidos pd");	
		$this->db->join("tbl_plazas p","p.id = pd.plaza_id");	
		$this->db->join("tbl_insumos i","i.id = pd.insumo_id");		
		$this->db->join("tbl_unidades u","u.id = i.unidad_pedido");		
		$this->db->where("pd.Fecha",$fecha);		
		$this->db->where("pd.plaza_id",$plaza_id);		
		$resultados = $this->db->get();	
		return $resultados->result();					
	}

	public function getPedidoPasteleriaPlaza($fecha,$plaza_id){			
		$this->db->select("pd.*,p.Nombre as Plaza,i.Nombre as Nombre,u.Nombre as Unidad");
		$this->db->from("tbl_pedidos_pasteleria pd");	
		$this->db->join("tbl_plazas p","p.id = pd.plaza_id");	
		$this->db->join("tbl_insumos i","i.id = pd.insumo_id");		
		$this->db->join("tbl_unidades u","u.id = i.unidad_pedido");		
		$this->db->where("pd.Fecha",$fecha);		
		$this->db->where("pd.plaza_id",$plaza_id);		
		$resultados = $this->db->get();	
		return $resultados->result();					
	}

	public function consultarMisPedidos(){		
		$this->db->from("tbl_insumos_gastos");
		//$this->db->where("id",$insumo_gasto_id);		
		$query=$this->db->get();        
		if($query->num_rows()>0){
			return $query->row();
		}
		else{
			return false;
		}
	}

	public function deleteDetalles($id){			
		$bandera=false;
		$this->db->trans_begin();   							
		$this->db->where('id', $id);		
		$this->db->delete('tbl_detalles_pedido');		
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

	public function deleteDetallesPasteleria($fecha,$plaza_id){
		$this->db->where('Fecha', $fecha);
		$this->db->where('plaza_id', $plaza_id);
		return $this->db->delete('tbl_detalles_pedido_pasteleria');
	}

	public function deletePedidos($fecha,$plaza_id){
		$this->db->where('Fecha', $fecha);
		$this->db->where('plaza_id', $plaza_id);
		return $this->db->delete('tbl_pedidos');
	}

	public function deletePedidosPasteleria($fecha,$plaza_id){
		$this->db->where('Fecha', $fecha);
		$this->db->where('plaza_id', $plaza_id);
		return $this->db->delete('tbl_pedidos_pasteleria');
	}

	public function deleteTempPasteleria(){			
		$this->db->empty_table('tbl_temp_pedidos_pasteleria');
		if($this->db->affected_rows()){
			return true;
		}
		else{
			return false;
		}
	}

	public function deleteInsumoPedido($fecha,$plaza_id,$insumo_id){
		$this->db->select('insumo_id');
		$this->db->where('Fecha', $fecha);
		$this->db->where('plaza_id', $plaza_id);
		$this->db->where('insumo_id', $insumo_id);
		$query=$this->db->get('tbl_pedidos');
		if($query->num_rows()>0){
			$this->db->where('Fecha', $fecha);
			$this->db->where('plaza_id', $plaza_id);
			$this->db->where('insumo_id', $insumo_id);
			return $this->db->delete('tbl_pedidos');	
		}else{
			return false;
		}
	}

	public function liberarPedidoManager($fecha,$plaza_id,$data){
		$this->db->select('plaza_id');
		$this->db->where('Fecha', $fecha);
		$this->db->where('plaza_id', $plaza_id);		
		$query=$this->db->get('tbl_detalles_pedido');
		if($query->num_rows()>0){
			$this->db->where('Fecha', $fecha);
			$this->db->where('plaza_id', $plaza_id);			
			return $this->db->update('tbl_detalles_pedido', $data);		
		}else{
			return false;
		}
	}

	public function permitirEdicion($fecha,$plaza_id,$data){
		$this->db->select('plaza_id');
		$this->db->where('Fecha', $fecha);
		$this->db->where('plaza_id', $plaza_id);		
		$query=$this->db->get('tbl_detalles_pedido');
		if($query->num_rows()>0){
			$this->db->where('Fecha', $fecha);
			$this->db->where('plaza_id', $plaza_id);			
			return $this->db->update('tbl_detalles_pedido', $data);		
		}else{
			return false;
		}
	}


	public function cuadrarPedido($fecha,$plaza_id,$insumo_id,$data){
		$this->db->where('Fecha', $fecha);
		$this->db->where('plaza_id', $plaza_id);		
		$this->db->where('insumo_id', $insumo_id);
		return $this->db->update('tbl_pedidos', $data);
	}

	public function cuadrarPedidoPasteleria($fecha,$plaza_id,$insumo_id,$data){
		$this->db->where('Fecha', $fecha);
		$this->db->where('plaza_id', $plaza_id);		
		$this->db->where('insumo_id', $insumo_id);
		return $this->db->update('tbl_pedidos_pasteleria', $data);
	}

	public function updateCantidadDetalles($fecha,$plaza_id,$data){
		$this->db->select('plaza_id');
		$this->db->where('Fecha', $fecha);
		$this->db->where('plaza_id', $plaza_id);		
		$query=$this->db->get('tbl_detalles_pedido');
		if($query->num_rows()>0){
			$this->db->where('Fecha', $fecha);
			$this->db->where('plaza_id', $plaza_id);				
			return $this->db->update('tbl_detalles_pedido', $data);	
		}else{
			return false;
		}
	}

	public function consultarPedidoDuplicadoPasteleria($fecha,$plaza_id){
		$this->db->select('*');
		$this->db->from('tbl_detalles_pedido_pasteleria');
		$this->db->where('Fecha', $fecha);
		$this->db->where('plaza_id', $plaza_id);		
		$query=$this->db->get();
		if($query->num_rows()>=1){
			return false;
		}else{
			return true;
		}
	}

	public function consultarEstadoPedido($fecha,$plaza_id){
		$this->db->select('Estatus');
		$this->db->from('tbl_detalles_pedido');
		$this->db->where('Fecha', $fecha);
		$this->db->where('plaza_id', $plaza_id);		
		$query=$this->db->get();
		if($query->num_rows()>0){
			return $query->row();
		}else{
			return false;
		}
	}

	public function consultarEstadoPedidoPasteleria($fecha,$plaza_id){
		$this->db->select('Estatus');
		$this->db->from('tbl_detalles_pedido_pasteleria');
		$this->db->where('Fecha', $fecha);
		$this->db->where('plaza_id', $plaza_id);		
		$query=$this->db->get();
		if($query->num_rows()>0){
			return $query->row();
		}else{
			return false;
		}
	}

	public function consultarEstadoFactura($fecha,$plaza_id){
		$this->db->select('Estatus_Factura');
		$this->db->from('tbl_detalles_pedido');
		$this->db->where('Fecha', $fecha);
		$this->db->where('plaza_id', $plaza_id);		
		$query=$this->db->get();
		if($query->num_rows()>0){
			return $query->row();
		}else{
			return false;
		}
	}

	public function consultarEstadoFacturaPasteleria($fecha,$plaza_id){
		$this->db->select('Estatus_Factura');
		$this->db->from('tbl_detalles_pedido_pasteleria');
		$this->db->where('Fecha', $fecha);
		$this->db->where('plaza_id', $plaza_id);		
		$query=$this->db->get();
		if($query->num_rows()>0){
			return $query->row();
		}else{
			return false;
		}
	}

	public function consultarEstadoImporte($fecha,$plaza_id){
		$this->db->select('Importe');
		$this->db->from('tbl_detalles_pedido');
		$this->db->where('Fecha', $fecha);
		$this->db->where('plaza_id', $plaza_id);		
		$query=$this->db->get();
		if($query->num_rows()>0){
			return $query->row();
		}else{
			return false;
		}
	}

	public function consultarEstatus($fecha,$plaza_id){
		$this->db->select('Estatus');
		$this->db->from('tbl_detalles_pedido');
		$this->db->where('Fecha', $fecha);
		$this->db->where('plaza_id', $plaza_id);		
		$query=$this->db->get();
		if($query->num_rows()>0){
			return $query->row();
		}else{
			return false;
		}
	}

	public function consultarFechaUltimoPedido($plaza_id){
		$this->db->select('MIN(Fecha) as Fecha');
		$this->db->from('tbl_detalles_pedido');		
		$this->db->where('plaza_id', $plaza_id);		
		$this->db->where('Estatus',0);		
		$query=$this->db->get();
		if($query->num_rows()>0){
			return $query->row();
		}else{
			return false;
		}
	}

	public function consultarFechaUltimoPedidoPasteleria($plaza_id){
		$this->db->select('MIN(Fecha) as Fecha');
		$this->db->from('tbl_detalles_pedido_pasteleria');		
		$this->db->where('plaza_id', $plaza_id);		
		$this->db->where('Estatus',0);		
		$query=$this->db->get();
		if($query->num_rows()>0){
			return $query->row();
		}else{
			return false;
		}
	}

	public function getPedidoManager2($fecha,$plaza_id){			
		$this->db->select("pd.*,p.Nombre as Plaza,u.Nombre as Unidad");
		$this->db->from("tbl_pedidos pd");	
		$this->db->join("tbl_plazas p","p.id = pd.plaza_id");	
		$this->db->join("tbl_insumos i","i.id = pd.insumo_id");		
		$this->db->join("tbl_unidades u","u.id = i.unidad_pedido");		
		$this->db->where("pd.Fecha",$fecha);
		$this->db->where("pd.plaza_id",$plaza_id);		
		$query = $this->db->get();	
		$output ='';
		
		foreach($query->result() as $row)
		{		
			if($row->Bandera==1){
				$output .='<tr bgcolor="#99ddff">';
			}
			else if($row->Bandera==2){
				$output .='<tr bgcolor="#f2a1a1">';
			}
			else if($row->Bandera==3){
				$output .='<tr bgcolor="#fff7c5">';
			}
			else{
				$output .='<tr >';
			}	

		$output .= '<td>'.$row->Fecha.'</td>';
		$output .= '<td>'.$row->Plaza.'</td>';				
		$output .= '<td>'.$row->Nombre.'</td>';
		$output .= '<td>'.$row->Unidad.'</td>';
		$output .= '<td>'.$row->Cantidad_Pedido.'</td>';
		$output .= '<td>'.$row->Cantidad_Inventario.'</td>';
		
		$output .= '<td> 
					<button type="button" class="btn btn-success"  onclick="cuadrarPedido(\''.$row->Fecha.'\','.$row->plaza_id.','.$row->insumo_id.','.$row->Cantidad_Pedido.')" >';	
		$output .= '<span class="fa fa-check"> </span></button> 
					</td>';		
		
		$output .= '<td> 
					<button type="button" class="btn btn-info"  onclick="asignarValoresModalPedido(\''.$row->Nombre.'\','.$row->Cantidad_Pedido.','.$row->Cantidad_Inventario.',\''.$row->Unidad.'\','.$row->insumo_id.',\''.$row->Fecha.'\','.$row->plaza_id.')" data-toggle="modal" data-target="#editarCantidadRecibida" value="">';	
		$output .= '<span class="fa fa-edit"> </span></button> 
				    </td>';							

		$output .= '<td> 
					<button type="button" onclick="noRecibido(\''.$row->Fecha.'\','.$row->plaza_id.','.$row->insumo_id.')" class="btn btn-danger">';	
		$output .= '<span class="fa fa-remove"> </span></button> 
					</td>';								
		$output.='</tr>';
		}		
		return $output;
	}	

	public function getPedidoManager2Pasteleria($fecha,$plaza_id){	
		$this->db->select("pd.*,p.Nombre as Plaza,u.Nombre as Unidad,i.Nombre as Nombre");
		$this->db->from("tbl_pedidos_pasteleria pd");	
		$this->db->join("tbl_plazas p","p.id = pd.plaza_id");	
		$this->db->join("tbl_insumos i","i.id = pd.insumo_id");		
		$this->db->join("tbl_unidades u","u.id = i.unidad_pedido");		
		$this->db->where("pd.Fecha",$fecha);
		$this->db->where("pd.plaza_id",$plaza_id);		
		$query = $this->db->get();	
		$output ='';
		
		foreach($query->result() as $row)
		{
		
			if($row->Bandera==1){
				$output .='<tr bgcolor="#99ddff">';
			}
			else if($row->Bandera==2){
				$output .='<tr bgcolor="#f2a1a1">';
			}
			else if($row->Bandera==3){
				$output .='<tr bgcolor="#fff7c5">';
			}

			else{
				$output .='<tr >';
			}	

		$output .= '<td>'.$row->Fecha.'</td>';
		$output .= '<td>'.$row->Plaza.'</td>';				
		$output .= '<td>'.$row->Nombre.'</td>';
		$output .= '<td>'.$row->Unidad.'</td>';
		$output .= '<td>'.$row->Cantidad.'</td>';
		$output .= '<td>'.$row->Cantidad_Final.'</td>';
		
		$output .= '<td> 
					<button type="button" class="btn btn-success"  onclick="cuadrarPedidoPasteleria(\''.$row->Fecha.'\','.$row->plaza_id.','.$row->insumo_id.','.$row->Cantidad.')" >';	
		$output .= '<span class="fa fa-check"> </span></button> 
					</td>';		
		
		$output .= '<td> 
					<button type="button" class="btn btn-info"  onclick="asignarValoresModalPedidoPasteleria(\''.$row->Nombre.'\','.$row->Cantidad.','.$row->Cantidad_Final.',\''.$row->Unidad.'\','.$row->insumo_id.',\''.$row->Fecha.'\','.$row->plaza_id.')" data-toggle="modal" data-target="#editarCantidadRecibida" value="">';	
		$output .= '<span class="fa fa-edit"> </span></button> 
				    </td>';							

		$output .= '<td> 
					<button type="button" onclick="noRecibidoPasteleria(\''.$row->Fecha.'\','.$row->plaza_id.','.$row->insumo_id.')" class="btn btn-danger">';	
		$output .= '<span class="fa fa-remove"> </span></button> 
					</td>';								
		$output.='</tr>';
		}		
		return $output;
	}

	public function getPedidoHistorialManager($fecha,$plaza_id)
	{			
		$this->db->select("pd.*,p.Nombre as Plaza");
		$this->db->from("tbl_pedidos pd");	
		$this->db->join("tbl_plazas p","p.id = pd.plaza_id");		
		$this->db->where("pd.Fecha",$fecha);
		$this->db->where("pd.plaza_id",$plaza_id);		
		$query = $this->db->get();	
		$output ='';

		foreach($query->result() as $row)
		{			
		$output .='<tr >';			
		$output .= '<td>'.$row->Plaza.'</td>';				
		$output .= '<td>'.$row->Nombre.'</td>';
		$output .= '<td>'.$row->Cantidad_Pedido.'</td>';
		$output .= '<td>'.$row->Cantidad_Inventario.'</td>';							
		$output.='</tr>';
		}		
		return $output;
	}	

	public function getFactura($factura){
		$this->db->where("Factura",$factura);
		$resultado=$this->db->get("tbl_detalles_pedido");
		return $resultado->row();
	}

	public function actualizarFacturas($fecha,$plaza_id,$data,$data2){		
		$this->db->where('Fecha', $fecha);
		$this->db->where('plaza_id', $plaza_id);		
		$query=$this->db->get('tbl_detalles_pedido');
		if($query->num_rows()>0){
			$this->db->where('Fecha', $fecha);
			$this->db->where('plaza_id', $plaza_id);				
			if($this->db->update('tbl_detalles_pedido', $data)){
				$this->db->where('Fecha', $fecha);
				$this->db->where('plaza_id', $plaza_id);				
				return $this->db->update('tbl_pedidos', $data2);
			}
		}else{
			return false;
		}
	}

	public function actualizarFacturasPasteleria($fecha,$plaza_id,$data,$data2){		
		$this->db->where('Fecha', $fecha);
		$this->db->where('plaza_id', $plaza_id);		
		$query=$this->db->get('tbl_detalles_pedido_pasteleria');
		if($query->num_rows()>0){
			$this->db->where('Fecha', $fecha);
			$this->db->where('plaza_id', $plaza_id);				
			if($this->db->update('tbl_detalles_pedido_pasteleria', $data)){
				$this->db->where('Fecha', $fecha);
				$this->db->where('plaza_id', $plaza_id);				
				return $this->db->update('tbl_pedidos_pasteleria', $data2);
			}
		}else{
			return false;
		}
	}


	public function actualizarFactura($fecha,$plaza_id,$data){		
		$this->db->where('Fecha', $fecha);
		$this->db->where('plaza_id', $plaza_id);		
		$query=$this->db->get('tbl_detalles_pedido');
		if($query->num_rows()>0){
			$this->db->where('Fecha', $fecha);
			$this->db->where('plaza_id', $plaza_id);				
			return $this->db->update('tbl_detalles_pedido', $data);	
		}else{
			return false;
		}
	}

	public function actualizarFacturaPasteleria($fecha,$plaza_id,$data){		
		$this->db->where('Fecha', $fecha);
		$this->db->where('plaza_id', $plaza_id);		
		$query=$this->db->get('tbl_detalles_pedido_pasteleria');
		if($query->num_rows()>0){
			$this->db->where('Fecha', $fecha);
			$this->db->where('plaza_id', $plaza_id);				
			return $this->db->update('tbl_detalles_pedido_pasteleria', $data);	
		}else{
			return false;
		}
	}

	public function getPedidosPendientes(){
		$this->db->select("dp.*,p.Nombre as Plaza,,p.Acronimo as Acronimo");
		$this->db->from("tbl_detalles_pedido dp");		
		$this->db->join("tbl_plazas p","p.id = dp.plaza_id");	
		$this->db->where("dp.Liberado",0);				
		$this->db->order_by('dp.Fecha','asc');
		$this->db->order_by('p.id','asc');
		$query=$this->db->get();        
		return $query->result();
	}

	public function getPedidosPasteleriaPendientes(){
		$this->db->select("dp.*,p.Nombre as Plaza,,p.Acronimo as Acronimo");
		$this->db->from("tbl_detalles_pedido_pasteleria dp");		
		$this->db->join("tbl_plazas p","p.id = dp.plaza_id");	
		$this->db->where("dp.Estatus",0);				
		$this->db->order_by('dp.Fecha','asc');
		$this->db->order_by('p.id','asc');
		$query=$this->db->get();        
		return $query->result();
	}

	public function getPedidosPendientesPlaza($plaza_id){
		$this->db->select("dp.*,p.Nombre as Plaza,p.Acronimo as Acronimo");
		$this->db->from("tbl_detalles_pedido dp");		
		$this->db->join("tbl_plazas p","p.id = dp.plaza_id");					
		$this->db->where("dp.plaza_id",$plaza_id);
		$this->db->where("dp.Estatus",0);		
		$this->db->order_by('dp.Fecha','asc');
		$this->db->order_by('p.id','asc');
		$query=$this->db->get();        
		return $query->result();
	}

	public function getPedidosPasteleriaPendientesPlaza($plaza_id){
		$this->db->select("dp.*,p.Nombre as Plaza,p.Acronimo as Acronimo");
		$this->db->from("tbl_detalles_pedido_pasteleria dp");		
		$this->db->join("tbl_plazas p","p.id = dp.plaza_id");					
		$this->db->where("dp.plaza_id",$plaza_id);
		$this->db->where("dp.Estatus",0);		
		$this->db->order_by('dp.Fecha','asc');
		$this->db->order_by('p.id','asc');
		$query=$this->db->get();        
		return $query->result();
	}

	
	public function deleteHistorialPedidoManager($fecha,$plaza_id){
		$this->db->where('Fecha', $fecha);
		$this->db->where('plaza_id', $plaza_id);
		$this->db->delete('tbl_detalles_pedido');
		if($this->db->affected_rows()){
			return true;
		}
		else{
			return false;
		}
	}

	public function actualizarEstatusLiberacionPedido($fecha,$plaza_id,$data){
		$this->db->where('Fecha', $fecha);
		$this->db->where('plaza_id', $plaza_id);		
		$query=$this->db->get('tbl_detalles_pedido');
		if($query->num_rows()>0){
			$this->db->where('Fecha', $fecha);
			$this->db->where('plaza_id', $plaza_id);				
			return $this->db->update('tbl_detalles_pedido', $data);	
		}else{
			return false;
		}
	}

	public function actualizarEstatusLiberacionPedidoPasteleria($fecha,$plaza_id,$data){
		$this->db->where('Fecha', $fecha);
		$this->db->where('plaza_id', $plaza_id);		
		$query=$this->db->get('tbl_detalles_pedido_pasteleria');
		if($query->num_rows()>0){
			$this->db->where('Fecha', $fecha);
			$this->db->where('plaza_id', $plaza_id);				
			return $this->db->update('tbl_detalles_pedido_pasteleria', $data);	
		}else{
			return false;
		}
	}

	public function guardarFacturaAjax($data){
		$this->db->trans_begin();   							
		
		$this->db->insert("tbl_detalles_pedido",$data);	
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

	public function actualizarFacturaAjax($idFactura,$data){
		$this->db->trans_begin();   
		
		$this->db->where('id',$idFactura);	
		$this->db->update("tbl_detalles_pedido",$data);	
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

	public function eliminarPedidoCompleto($fecha,$plaza_id,$id){			
		$bandera=false;
		$this->db->trans_begin();   							

		$this->db->where('id', $id);		
		$this->db->delete('tbl_detalles_pedido');
		
		$this->db->where('Fecha', $fecha);		
		$this->db->where('plaza_id', $plaza_id);		
		$this->db->delete('tbl_pedidos');			
		
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

	public function consultarDisponibilidadPedido($fecha,$plaza_id){
		$this->db->select('Fecha');
		$this->db->from('tbl_detalles_pedido');		
		$this->db->where('Fecha', $fecha);		
		$this->db->where('plaza_id',$plaza_id);						
		$query=$this->db->get();
		if($query->num_rows()>0){
			return true;
		}else{
			return false;
		}
	}

	public function consultarFechasPedido($plaza_id){
		$this->db->select('Fecha');
		$this->db->from('tbl_detalles_pedido');		
		$this->db->where('plaza_id', $plaza_id);		
		$this->db->where('Estatus',0);
		$query=$this->db->get();		
		return $query->result();				
	}

	public function consultarCapturaActual($fecha,$plaza_id){
		$this->db->select('dp.*');
		$this->db->from('tbl_detalles_pedido dp');		
		$this->db->where('dp.plaza_id', $plaza_id);
		$this->db->where('dp.Fecha', $fecha);
		$this->db->where('dp.Estatus_Factura',1);
		$query=$this->db->get();		
		if($query->num_rows()>0){
			return true;
		}else{
			return false;
		}				
	}

	public function reiniciarPedido($fecha,$plaza_id,$data,$data2){								
			$this->db->trans_begin();   

			$this->db->where('Fecha', $fecha);
			$this->db->where('plaza_id', $plaza_id);				
			$this->db->update('tbl_pedidos', $data);

			$this->db->where('Fecha', $fecha);
			$this->db->where('plaza_id', $plaza_id);				
			$this->db->update('tbl_detalles_pedido', $data2);
			
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

	/////////////////////////////////////////////////////////////////////////////////////////////
	
	public function consultarPedidoDuplicadoFranquicia($fecha,$plaza_id){
		$this->db->select('*');
		$this->db->from('tbl_detalles_pedido');
		$this->db->where('Fecha', $fecha);
		$this->db->where('plaza_id', $plaza_id);		
		$query=$this->db->get();
		if($query->num_rows()>=1){
			return false;
		}else{
			return true;
		}
	}

	public function getInsumosPedidoFranquicia(){			
		$this->db->select("pp.*,p.Nombre as Plaza,i.Nombre as Insumo");
		$this->db->from("tbl_temp_pedidos_franquicia pp");
		$this->db->join("tbl_plazas p","p.id = pp.plaza_id");		
		$this->db->join("tbl_insumos i","i.id = pp.insumo_id");			
		$resultados=$this->db->get();
		return $resultados->result();
	}

	public function addInsumoPedidoFranquicia($data){
		return $this->db->insert("tbl_temp_pedidos_franquicia",$data);
	}

	public function getDetallesPedidoFranquicia(){			
		$this->db->select("dp.*,p.Nombre as Plaza");
		$this->db->from("tbl_detalles_pedido dp");
		$this->db->join("tbl_plazas p","p.id = dp.plaza_id");	
		$this->db->where("dp.Estatus",0);				
		$resultados=$this->db->get();
		return $resultados->result();
	}

	public function getDetallesPedidoLiberadoFranquicia(){			
		$this->db->select("dp.*,p.Nombre as Plaza,p.Acronimo as Acronimo");
		$this->db->from("tbl_detalles_pedido dp");
		$this->db->join("tbl_plazas p","p.id = dp.plaza_id");	
		$this->db->where("dp.Estatus",1);				
		$resultados=$this->db->get();
		return $resultados->result();
	}

	public function eliminarInsumoTempFranquicia($code){
		$this->db->where('id', $code);
		$this->db->delete('tbl_temp_pedidos_franquicia');
		if($this->db->affected_rows()){
			return true;
		}
		else{
			return false;
		}
	}

	public function savePedidoFranquicia($data){
		return $this->db->insert_batch('tbl_pedidos', $data);		
	}

	public function saveDetallesPedidoFranquicia($data){
		return $this->db->insert('tbl_detalles_pedido', $data);
	}

	public function deleteTempFranquicia(){			
		$this->db->empty_table('tbl_temp_pedidos_franquicia');
		if($this->db->affected_rows()){
			return true;
		}
		else{
			return false;
		}
	}

	//////////////////////////////////////////////////////////////

	public function getFaltantes(){
		$this->db->select("pd.*,p.Nombre as Plaza,i.Nombre as Nombre,u.Nombre as Unidad");
		$this->db->from("tbl_pedidos pd");	
		$this->db->join("tbl_plazas p","p.id = pd.plaza_id");	
		$this->db->join("tbl_insumos i","i.id = pd.insumo_id");		
		$this->db->join("tbl_unidades u","u.id = i.unidad_pedido");				
		$banderas = array(2,3);
		$this->db->where_in('pd.Bandera', $banderas);	
		$this->db->where('pd.Completo',0);	
		$this->db->order_by("pd.Fecha","desc");
		$resultados = $this->db->get();	
		return $resultados->result();	
	}

	public function getFaltantesPlaza($plaza_id){
		$this->db->select("pd.*,p.Nombre as Plaza,i.Nombre as Nombre,u.Nombre as Unidad");
		$this->db->from("tbl_pedidos pd");	
		$this->db->join("tbl_plazas p","p.id = pd.plaza_id");	
		$this->db->join("tbl_insumos i","i.id = pd.insumo_id");		
		$this->db->join("tbl_unidades u","u.id = i.unidad_pedido");			
		$banderas = array(2,3);
		$this->db->where_in('pd.Bandera', $banderas);		
		$this->db->where('pd.Completo',0);
		$this->db->where('pd.plaza_id',$plaza_id);		
		$this->db->order_by("pd.Fecha","desc");
		$resultados = $this->db->get();	
		return $resultados->result();	
	}



	public function getFaltantesManager($plaza_id){
		$this->db->select("pd.*,p.Nombre as Plaza,i.Nombre as Nombre,u.Nombre as Unidad");
		$this->db->from("tbl_pedidos pd");	
		$this->db->join("tbl_plazas p","p.id = pd.plaza_id");	
		$this->db->join("tbl_insumos i","i.id = pd.insumo_id");		
		$this->db->join("tbl_unidades u","u.id = i.unidad_pedido");			
		$this->db->where("pd.plaza_id",$plaza_id);					
		$banderas = array(2,3);
		$this->db->where_in('pd.Bandera', $banderas);
		$resultados = $this->db->get();	
		return $resultados->result();	
	}

	public function consultarFechaRecepcionPedido($factura){		
		$this->db->select('Fecha_Recepcion');
		$this->db->from('tbl_detalles_pedido');		
		$this->db->where('Factura', $factura);		
		$query=$this->db->get();
		if($query->num_rows()>0){
			return $query->row();
		}else{
			return false;
		}		
	}

	public function getFaltantesCount(){
		$this->db->select("COUNT(*) as Total");
		$this->db->from("tbl_pedidos pd");			
		$banderas = array(2,3);
		$this->db->where_in('pd.Bandera', $banderas);	
		$this->db->where('pd.Completo',0);	
		$resultado = $this->db->get();	
		return $resultado->row();
	}

	public function actualizarEstadoCompletoPedido($id,$data){
		$this->db->where('id',$id);				
		return $this->db->update('tbl_pedidos', $data);
	}


}

