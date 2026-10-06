<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mdl_productos extends CI_model{


	public function getProductos(){		
		$this->db->select("p.*,fp.Nombre as Familia");
		$this->db->from("tbl_productos p");
		$this->db->join("tbl_familia_productos fp","p.familia_id = fp.id");									
		$this->db->order_by("p.id","asc");	
		$resultados=$this->db->get();	
        return $resultados->result();
	}

	public function getProductosFamilia($familia_id){		
		$this->db->select("p.*,fp.Nombre as Familia");
		$this->db->from("tbl_productos p");
		$this->db->join("tbl_familia_productos fp","p.familia_id = fp.id");									
		$this->db->where("p.familia_id",$familia_id);	
		$this->db->order_by("p.id","asc");	
		$resultados=$this->db->get();	
        return $resultados->result();
	}


	public function getProductoID($id){
		$this->db->select("p.*");
		$this->db->from("tbl_productos p");	
		$this->db->where("p.id",$id);			
		$resultado=$this->db->get();
		return $resultado->row();
	}
	

	
	public function getInsumoID($id){
		$this->db->where("id",$id);
		$resultado=$this->db->get("tbl_insumos");
		return $resultado->row();
	}

	public function getInsumoPedido($clave_pedido){
		$this->db->select("i.*");
		$this->db->from("tbl_insumos i");
		$this->db->where("i.clave_pedido",$clave_pedido);
		$resultado=$this->db->get();
		return $resultado->row();
	}

	public function getInsumos(){
		$this->db->select("i.*,u.Nombre as UnidadFinal,uu.Nombre as UnidadPedido,uuu.Nombre as Unidad,i.inv_produccion as Inventario");
		$this->db->from("tbl_insumos i");
		$this->db->join("tbl_categorias_insumos c ","i.categorias_insumos_id = c.id");				
		$this->db->join("tbl_unidades u ","i.unidad_final = u.id");		
		$this->db->join("tbl_unidades uu","i.unidad_pedido = uu.id");
		$this->db->join("tbl_unidades uuu","i.unidad_id = uuu.id");
		$this->db->order_by('i.Nombre', 'ASC');
		$resultados=$this->db->get();
		return $resultados->result();
	}

	public function getInsumosInventario(){
		$this->db->select("i.*,c.Nombre as NombreC,u.Nombre as Unidad");
		$this->db->from("tbl_insumos i");
		$this->db->join("tbl_categorias_insumos c ","i.categorias_insumos_id = c.id");				
		$this->db->join("tbl_unidades u ","i.unidad_final = u.id");		
		$this->db->where("i.inv_produccion",1);		
		$this->db->order_by('i.id','ASC');		
		$resultados=$this->db->get();
		return $resultados->result();
	}

	public function getInsumosPasteleria(){
		$this->db->select("i.*,c.Nombre as NombreC,u.Nombre as Unidad");
		$this->db->from("tbl_insumos i");
		$this->db->join("tbl_categorias_insumos c ","i.categorias_insumos_id = c.id");				
		$this->db->join("tbl_unidades u ","i.unidad_final = u.id");		
		$this->db->order_by('i.Nombre', 'ASC');		
		$names = array(87,88,89,90,91,92);
		$this->db->where_in('i.id', $names);			
		$resultados=$this->db->get();
		return $resultados->result();
	}

	public function getUnidades(){
		$this->db->from("tbl_unidades");
		$this->db->order_by('Nombre','asc');
		$resultados=$this->db->get();
        return $resultados->result();
	}

	public function actualizarUnidad($id,$data){
		$this->db->where("id",$id);
		return $this->db->update("tbl_unidades",$data);				
	}

	public function getUnidadID($id){
		$this->db->select("unidad_id");
		$this->db->where("id",$id);
		$resultados=$this->db->get("tbl_insumos_gastos");
        return $resultados->row();
	}

	public function getUnidadIDFormula($id){
		$this->db->select("unidad_id");
		$this->db->where("id",$id);
		$resultados=$this->db->get("tbl_insumos");
        return $resultados->row();
	}

	public function getUnidadFinalID($id){
		$this->db->select("unidad_final");
		$this->db->where("id",$id);
		$resultados=$this->db->get("tbl_insumos");
        return $resultados->row();
	}

	public function getFamilias(){			
		$this->db->select("*");
		$resultados=  $this->db->order_by('id', 'ASC');
		$resultados = $this->db->get("tbl_familia_productos");				
		return $resultados->result();
	}

	public function  getUnidadesID($id){			
		$this->db->where('id', $id);		
		$query = $this->db->get('tbl_unidades');
		$output = '';
		foreach($query->result() as $row)
		{
		$output .= '<option value="'.$row->id.'">'.$row->Nombre.'</option>';
		}
		return $output;
	}	

	
	public function save($data){				
		$this->db->trans_begin();   
		$this->db->insert("tbl_productos",$data);	
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


	public function saveInsumo($data){				
		$this->db->trans_begin();   				
		$this->db->insert("tbl_insumos",$data);
		$insert_id = $this->db->insert_id();
		if ($this->db->trans_status() === FALSE){      
		//Hubo errores en la consulta, entonces se cancela la transacción.   
		$this->db->trans_rollback();      
		return false;    
	 }else{      
		//Todas las consultas se hicieron correctamente.  
		$this->db->trans_commit();    			 
		return $insert_id;
	 } 	
	}

	public function saveInventarioProducccion($data){
		$this->db->trans_begin();   							
		$this->db->insert_batch("tbl_inventario_productos",$data);	
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

	public function saveInventarioFisico($data){
		$this->db->trans_begin();   							
		$this->db->insert_batch("tbl_captura_inventario",$data);	
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

	public function saveInsumosInventario($data){
		$this->db->trans_begin();   							
		$this->db->insert("tbl_insumos_inventario",$data);	
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

	public function getNombreInsumo($insumo_id){
		$this->db->select("Nombre");
		$this->db->where("id",$insumo_id);
		$resultado=$this->db->get("tbl_insumos");
		return $resultado->row();
	}

	public function getCategorias(){		
		$resultados = $this->db->get("tbl_categorias_insumos");
		return $resultados->result();				
	}

	public function consultarEstadoProducto($producto_id){
		$this->db->select("Estado");
		$this->db->from("tbl_productos");
		$this->db->where("id",$producto_id);		
		$query=$this->db->get();        		
		return $query->row();		
	}

	public function cambiarEstadoProducto($producto_id,$data){
		$this->db->trans_begin();   		
		$this->db->where('id', $producto_id);		
		$this->db->update('tbl_productos', $data);		
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

	public function consultarExistencia($nombre,$clave){		
		$this->db->from("tbl_productos");
		$this->db->where("Nombre",$nombre);
		$this->db->or_where("Clave",$clave);
		$query=$this->db->get();        		
		if($query->num_rows()>0){
			return true;
		}
		else{
			return false;
		}	
	}

	public function getOperacionesInsumo($insumo_id)
	{			
		$this->db->select("in.*");
		$this->db->from("tbl_insumos_inventario in");						
		$this->db->where("in.insumo_id",$insumo_id);	
		$query = $this->db->get();	
		$output ='';
		foreach($query->result() as $row)
		{			
		$output .='<tr >';					
		$output .= '<td>'.$row->Bodega.'</td>';				
		//$output .= '<td>'.$row->Piso.'</td>';
		//$output .= '<td>'.$row->Total.'</td>';	
		//$output .= '<td>'.$row->DLC.'</td>';	
		$output .= '<td>'.$row->Pedido.'</td>';	
		$output .= '<td><button type="button" class="btn btn-info"  onclick="asignarValoresModalOperacionesInsumo('.$row->id.',\''.$row->Bodega.'\', \''.$row->Pedido.'\')" data-toggle="modal" data-target="#editarOperacionInsumo" >';	
		$output .= '<span class="fa fa-edit"> </span></button></td>';	

		

		$output.='</tr>';
		}		
		return $output;
	}

	public function checarInsumoInventario($insumo_id){
		$this->db->from("tbl_insumos_inventario");
		$this->db->where("insumo_id",$insumo_id);		
		$query=$this->db->get();        		
		if($query->num_rows()>0){
			return false;
		}
		else{
			return true;
		}
	}

	//Costo de venta
	public function getInsumosCostoVentaPedido(){
		$this->db->select("i.*");
		$this->db->from("tbl_insumos i");		
		$this->db->where("i.pedido",1);		
		$this->db->where("i.Analisis_CV",1);
		$this->db->or_where("i.Pedido_Pasteleria",1);
		$this->db->where("i.Analisis_CV",1);
		$this->db->order_by('i.id', 'ASC');		
		$resultados=$this->db->get();
		return $resultados->result();
	}

	public function getInsumosCostoVentaCompras(){
		$this->db->select("i.*");
		$this->db->from("tbl_insumos i");		
		$this->db->where("i.pedido",0);
		$this->db->where("i.Pedido_Pasteleria",0);
		$this->db->where("i.Analisis_CV",1);
		$this->db->order_by('i.id', 'ASC');		
		$resultados=$this->db->get();
		return $resultados->result();
	}

	public function getInsumoCostoVenta($insumo_id)
	{			
		$this->db->select("i.*,u.Nombre as UnidadFinal,uu.Nombre as UnidadPedido,uuu.Nombre as Unidad,i.inv_produccion as Inventario");
		$this->db->from("tbl_insumos i");
		$this->db->join("tbl_categorias_insumos c ","i.categorias_insumos_id = c.id");				
		$this->db->join("tbl_unidades u ","i.unidad_final = u.id");		
		$this->db->join("tbl_unidades uu","i.unidad_pedido = uu.id");
		$this->db->join("tbl_unidades uuu","i.unidad_id = uuu.id");
		$this->db->where("i.id",$insumo_id);
		$this->db->order_by('i.Nombre', 'ASC');
		$resultados=$this->db->get();
		return $resultados->result();
	}

	public function actualizarCostoVenta($id,$data){
		$this->db->where("id",$id);
		return $this->db->update("tbl_insumos",$data);
	}

	//De lunes a domingo el análisis
	public function getPrecioPromedioInsumo($fechaInicial,$fechaFinal,$plaza_id,$insumo_id){
		$this->db->select("SUM(g.Importe) as Importe,SUM(g.Cantidad) as Cantidad");
		$this->db->from("tbl_gastos g");
		$this->db->join("tbl_insumos_gastos ig","g.insumo_gasto_id = ig.id");				
		$this->db->join("tbl_insumos i","ig.insumo_id = i.id");								
		$this->db->where("g.Fecha >=",$fechaInicial);
		$this->db->where("g.Fecha <=",$fechaFinal);	
		$this->db->where("g.plaza_id",$plaza_id);	
		$this->db->where("ig.insumo_id",$insumo_id);						
		$resultados=$this->db->get();
		return $resultados->row();
    }


	//Actualizar operaciones Insumo
	public function actualizarOperacionInsumo($id,$data){
		$this->db->where("id",$id);
		return $this->db->update("tbl_insumos_inventario",$data);
	}

	public function getOperacionInsumo($insumo_id)
	{			
		$this->db->select("in.Pedido");
		$this->db->from("tbl_insumos_inventario in");						
		$this->db->where("in.insumo_id",$insumo_id);			
		$resultado=$this->db->get();
		return $resultado->result();					
	}

	
	
}
