<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mdl_remesas extends CI_model{

	public function getTiposGastos(){
        //Aquí se valida que la categoria se encuentre activa
		$resultados = $this->db->get("tbl_tipos_gastos");
		return $resultados->result();
	}
	
	
	public function getInsumosGastos(){
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("ig.*,gr.Nombre as Rol,gg.Nombre as Grupo,i.Nombre as Insumo,gg.id as grupo_id,uni.Nombre as Unidad");
		$this->db->from("tbl_insumos_gastos ig");
		$this->db->join("tbl_grupos_roles gr","ig.grupo_rol_id = gr.id");
        $this->db->join("tbl_grupo_gastos gg","ig.grupo_id = gg.id");
		$this->db->join("tbl_insumos i","ig.insumo_id = i.id");
		$this->db->join("tbl_unidades uni","ig.unidad_id = uni.id"); 
        $resultados=$this->db->get();		
		return $resultados->result();
	}
	

	public function getInsumosGastosAJAX()
	{					
		$this->db->select("ig.*,gr.Nombre as Rol,gg.Nombre as Grupo,i.Nombre as Insumo,gg.id as grupo_id,uni.Nombre as Unidad");
		$this->db->from("tbl_insumos_gastos ig");
		$this->db->join("tbl_grupos_roles gr","ig.grupo_rol_id = gr.id");
        $this->db->join("tbl_grupo_gastos gg","ig.grupo_id = gg.id");
		$this->db->join("tbl_insumos i","ig.insumo_id = i.id");
		$this->db->join("tbl_unidades uni","ig.unidad_id = uni.id");         				
		$query = $this->db->get();	
		$output ='';
		foreach($query->result() as $row)
		{			

		$output .='<tr >';				
		switch ($row->grupo_id%2) {
			case 0:
			$output .= '<td bgcolor="#bae6ff">'.$row->Grupo.'</td>';
			break;
			
			case 1:
			$output .= '<td bgcolor="#b7e188">'.$row->Grupo.'</td>';
			break;						
		}
									
		$output .= '<td>'.$row->Nombre.'</td>';
		$output .= '<td>'.$row->stock_minimo.'</td>';
		$output .= '<td>'.$row->stock_maximo.'</td>';	
		$output .= '<td>'.$row->Unidad.'</td>';	
		$output .= '<td>'.$row->bandera_stocks.'</td>';	

		$output .= '<td><button type="button" class="btn btn-info"  onclick="asignarValoresModalStock('.$row->id.',\''.$row->Grupo.'\',\''.$row->Nombre.'\','.$row->stock_minimo.','.$row->stock_maximo.','.$row->bandera_stocks.',\''.$row->Unidad.'\')" data-toggle="modal" data-target="#editarStock" >';	
		$output .= '<span class="fa fa-edit"> </span></button></td>';	
		
		$output .= '<td><button type="button" class="btn btn-success"  onclick="habilitarBandera('.$row->id.')">';	
		$output .= '<span class="fa fa-check"> </span></button></td>';	

		$output .= '<td><button type="button" class="btn btn-danger"  onclick="deshabilitarBandera('.$row->id.')">';	
		$output .= '<span class="fa fa-remove"> </span></button></td>';	
			
		$output.='</tr>';
		}		
		return $output;
	}


	public function actualizarStockRemesaModelo($insumo_gasto_id,$data){				
		$this->db->where('id', $insumo_gasto_id);		
		return $this->db->update('tbl_insumos_gastos', $data);
	}

	public function actualizarBanderaModelo($insumo_gasto_id,$data){				
		$this->db->where('id', $insumo_gasto_id);		
		return $this->db->update('tbl_insumos_gastos', $data);
	}
	
	public function getBanderaInsumo($insumo_gasto_id){
		$this->db->select("bandera_stocks as Bandera");
		$this->db->from("tbl_insumos_gastos");
		$this->db->where("id",$insumo_gasto_id);		
		$query=$this->db->get();        
		if($query->num_rows()>0){
			return $query->row();
		}
		else{
			return false;
		}
	}

	public function getMinimoInsumo($insumo_gasto_id){
		$this->db->select("stock_minimo as Minimo");
		$this->db->from("tbl_insumos_gastos");
		$this->db->where("id",$insumo_gasto_id);		
		$query=$this->db->get();        
		if($query->num_rows()>0){
			return $query->row();
		}
		else{
			return false;
		}
	}

	public function getMaximoInsumo($insumo_gasto_id){
		$this->db->select("stock_maximo as Maximo");
		$this->db->from("tbl_insumos_gastos");
		$this->db->where("id",$insumo_gasto_id);		
		$query=$this->db->get();        
		if($query->num_rows()>0){
			return $query->row();
		}
		else{
			return false;
		}
	}

	public function getGastos($plaza_id){
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("g.*,u.Nombre as Usuario,ig.Nombre as Insumo,up.Nombre as Pago,uni.Nombre as Unidad");
		$this->db->from("tbl_gastos g");
		$this->db->join("tbl_usuarios u","g.usuario_id = u.id");
		$this->db->join("tbl_insumos_gastos ig","g.insumo_gasto_id = ig.id");        
		$this->db->join("tbl_unidades_pago up","g.unidad_pago_id = up.id"); 
		$this->db->join("tbl_insumos i","ig.insumo_id = i.id"); 
		$this->db->join("tbl_unidades uni","ig.unidad_id = uni.id"); 
		$this->db->where('g.plaza_id',$plaza_id); 
		$this->db->where('u.rol_id !=',1);
		$this->db->where('u.rol_id !=',3);
		$this->db->limit(100); 		
		$this->db->order_by("g.Fecha","DESC");	
        $resultados=$this->db->get();
        return $resultados->result();
	}


	public function getGastosModal($fecha,$plaza_id)
	{			
		$this->db->select("g.*,u.Nombre as Usuario,p.Nombre as Plaza,up.Nombre as Pago,ig.Nombre as Insumo,up.Nombre as Pago,uni.Nombre as Unidad");
		$this->db->from("tbl_gastos g");
		$this->db->join("tbl_usuarios u","g.usuario_id = u.id");
		$this->db->join("tbl_insumos_gastos ig","g.insumo_gasto_id = ig.id");        
		$this->db->join("tbl_unidades_pago up","g.unidad_pago_id = up.id"); 
		$this->db->join("tbl_insumos i","ig.insumo_id = i.id"); 
			$this->db->join("tbl_unidades uni","ig.unidad_id = uni.id"); 
		$this->db->join("tbl_plazas p","g.plaza_id = p.id"); 
		$this->db->where('g.plaza_id',$plaza_id); 
		$this->db->where('g.Fecha',$fecha); 
		$this->db->where('u.rol_id !=',1);
		$this->db->where('u.rol_id !=',3); 	
		
		$query = $this->db->get();	
		$acumulado=0;
		$output ='';
		foreach($query->result() as $row)
		{			
		$acumulado=$acumulado+$row->Importe;
		$output .='<tr >';					
		$output .= '<td>'.$row->Fecha.'</td>';		
		$output .= '<td>'.$row->Usuario.'</td>';		
		$output .= '<td>'.$row->Plaza.'</td>';							
		$output .= '<td>'.$row->Insumo.'</td>';	
		$output .= '<td>'.$row->Pago.'</td>';	
		$output .= '<td>'.$row->Cantidad.'</td>';	
		$output .= '<td>'.$row->Unidad.'</td>';	
		$output .= '<td>$'.round(number_format(($row->Importe)/($row->Cantidad)),2).'</td>';	
		$output .= '<td>$'.number_format($row->Importe).'</td>';	
		$output.='</tr>';
		}		

		$output.='<trfoot>';
			$output .='<tr >';
			$output .= '<td></td>';	
			$output .= '<td></td>';	
			$output .= '<td></td>';	
			$output .= '<td></td>';	
			$output .= '<td></td>';	
			$output .= '<td></td>';	
			$output .= '<td></td>';	
			$output .= '<td></td>';	
			$output .= '<td>$'.$acumulado.'</td>';	
			$output.='</tr>';
		$output.='</trfoot>';
		return $output;
	}
	
	public function getGastosModalAPI($fecha,$plaza_id)
	{			
		$this->db->select("g.*,u.Nombre as Usuario,p.Nombre as Plaza,up.Nombre as Pago,ig.Nombre as Insumo,up.Nombre as Pago,uni.Nombre as Unidad");
		$this->db->from("tbl_gastos g");
		$this->db->join("tbl_usuarios u","g.usuario_id = u.id");
		$this->db->join("tbl_insumos_gastos ig","g.insumo_gasto_id = ig.id");        
		$this->db->join("tbl_unidades_pago up","g.unidad_pago_id = up.id"); 
		$this->db->join("tbl_insumos i","ig.insumo_id = i.id"); 
			$this->db->join("tbl_unidades uni","ig.unidad_id = uni.id"); 
		$this->db->join("tbl_plazas p","g.plaza_id = p.id"); 
		$this->db->where('g.plaza_id',$plaza_id); 
		$this->db->where('g.Fecha',$fecha); 
		$this->db->where('u.rol_id !=',1);
		$this->db->where('u.rol_id !=',3); 	
		$resultados = $this->db->get();	
		return $resultados->result();		
	}

	public function getGastosModalAPIAdmin($fecha,$plaza_id)
	{			
		$this->db->select("g.*,u.Nombre as Usuario,p.Nombre as Plaza,up.Nombre as Pago,ig.Nombre as Insumo,up.Nombre as Pago,uni.Nombre as Unidad");
		$this->db->from("tbl_gastos g");
		$this->db->join("tbl_usuarios u","g.usuario_id = u.id");
		$this->db->join("tbl_insumos_gastos ig","g.insumo_gasto_id = ig.id");        
		$this->db->join("tbl_unidades_pago up","g.unidad_pago_id = up.id"); 
		$this->db->join("tbl_insumos i","ig.insumo_id = i.id"); 
		$this->db->join("tbl_unidades uni","ig.unidad_id = uni.id"); 
		$this->db->join("tbl_plazas p","g.plaza_id = p.id"); 
		$this->db->where('g.plaza_id',$plaza_id); 
		$this->db->where('g.Fecha',$fecha); 
		$this->db->where('u.rol_id !=',2);
		$this->db->where('u.rol_id !=',4); 	
		$resultados = $this->db->get();	
		return $resultados->result();		
	}

	public function getGastosModalFamiliaAPI($fechainicio,$fechafin,$plaza_id,$familia_id)
	{			
		$this->db->select("g.*,ROUND(SUM(g.Cantidad),2) as Cantidad,ROUND(SUM(g.Importe),2) as Importe,u.Nombre as Usuario,p.Nombre as Plaza,up.Nombre as Pago,ig.Nombre as Insumo,up.Nombre as Pago,uni.Nombre as Unidad,ig.id as Insumo_ID");
		$this->db->from("tbl_gastos g");
		$this->db->join("tbl_usuarios u","g.usuario_id = u.id");
		$this->db->join("tbl_insumos_gastos ig","g.insumo_gasto_id = ig.id");        
		$this->db->join("tbl_unidades_pago up","g.unidad_pago_id = up.id"); 
		$this->db->join("tbl_insumos i","ig.insumo_id = i.id"); 
		$this->db->join("tbl_unidades uni","ig.unidad_id = uni.id"); 
		$this->db->join("tbl_plazas p","g.plaza_id = p.id"); 
		$this->db->join("tbl_grupo_gastos gg","ig.grupo_id = gg.id"); 
		$this->db->where('g.plaza_id',$plaza_id); 
		$this->db->where('g.Fecha>=',$fechainicio);
		$this->db->where('g.Fecha<=',$fechafin);		
		$this->db->where('gg.id',$familia_id);
		$this->db->group_by("ig.id");
		$this->db->order_by("Cantidad","desc");	 	
		$resultados = $this->db->get();	
		return $resultados->result();		
	}


	public function getGastosModalDesgloseFamiliaAPI($fechainicio,$fechafin,$plaza_id,$familia_id,$insumo_id)
	{			
		$this->db->select("g.*,u.Nombre as Usuario,p.Nombre as Plaza,up.Nombre as Pago,ig.Nombre as Insumo,up.Nombre as Pago,uni.Nombre as Unidad");
		$this->db->from("tbl_gastos g");
		$this->db->join("tbl_usuarios u","g.usuario_id = u.id");
		$this->db->join("tbl_insumos_gastos ig","g.insumo_gasto_id = ig.id");        
		$this->db->join("tbl_unidades_pago up","g.unidad_pago_id = up.id"); 
		$this->db->join("tbl_insumos i","ig.insumo_id = i.id"); 
		$this->db->join("tbl_unidades uni","ig.unidad_id = uni.id"); 
		$this->db->join("tbl_plazas p","g.plaza_id = p.id"); 
		$this->db->join("tbl_grupo_gastos gg","ig.grupo_id = gg.id"); 
		$this->db->where('g.plaza_id',$plaza_id); 
		$this->db->where('g.Fecha>=',$fechainicio);
		$this->db->where('g.Fecha<=',$fechafin);		
		$this->db->where('gg.id',$familia_id);
		$this->db->where('ig.id',$insumo_id);
		//$this->db->group_by("ig.id");
		$this->db->order_by("g.Fecha","asc");	 	
		$resultados = $this->db->get();	
		return $resultados->result();		
	}

	
	public function getGastosModalRango($fechainicio,$fechafin,$plaza_id)
	{			
    	$this->db->select("g.*,u.Nombre as Usuario,p.Nombre as Plaza,up.Nombre as Pago,ig.Nombre as Insumo,up.Nombre as Pago,uni.Nombre as Unidad");
    	$this->db->from("tbl_gastos g");
    	$this->db->join("tbl_usuarios u","g.usuario_id = u.id");
    	$this->db->join("tbl_insumos_gastos ig","g.insumo_gasto_id = ig.id");        
    	$this->db->join("tbl_unidades_pago up","g.unidad_pago_id = up.id"); 
    	$this->db->join("tbl_insumos i","ig.insumo_id = i.id"); 
    	$this->db->join("tbl_unidades uni","ig.unidad_id = uni.id"); 
    	$this->db->join("tbl_plazas p","g.plaza_id = p.id"); 
    	$this->db->where('g.plaza_id',$plaza_id); 
    	$this->db->where('g.Fecha>=',$fechainicio);
    	$this->db->where('g.Fecha<=',$fechafin);
    	$this->db->where('u.rol_id !=',1);
    	$this->db->where('u.rol_id !=',3); 				
    	$this->db->order_by("g.Fecha","asc");	 	
    	$resultados = $this->db->get();	
    	return $resultados->result();	
	}


	 	public function getListGastos()
	{
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("g.*,u.rol_id as Rol,u.Nombre as Usuario,ig.Nombre as Insumo,up.Nombre as Pago,p.Nombre as Plaza");
		$this->db->from("tbl_gastos g");
		$this->db->join("tbl_usuarios u","g.usuario_id = u.id");
		$this->db->join("tbl_insumos_gastos ig","g.insumo_gasto_id = ig.id");        
		$this->db->join("tbl_unidades_pago up","g.unidad_pago_id = up.id");  
		$this->db->join("tbl_plazas p","g.plaza_id = p.id");
		$this->db->order_by("g.Fecha","DESC");	 	
        $resultados=$this->db->get();
        return $resultados->result();
	}

	public function getListGastosFecha($fecha)
	{
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("g.*,u.rol_id as Rol,u.Nombre as Usuario,ig.Nombre as Insumo,up.Nombre as Pago,p.Nombre as Plaza");
		$this->db->from("tbl_gastos g");
		$this->db->join("tbl_usuarios u","g.usuario_id = u.id");
		$this->db->join("tbl_insumos_gastos ig","g.insumo_gasto_id = ig.id");        
		$this->db->join("tbl_unidades_pago up","g.unidad_pago_id = up.id");  
		$this->db->join("tbl_plazas p","g.plaza_id = p.id");
		$query=$this->db->where("g.Fecha >=",$fecha);
		$query=$this->db->where("g.Fecha <=",$fecha);
		$query=$this->db->where("g.Corte",0);
		$this->db->order_by("g.Fecha","DESC");	 	
        $resultados=$this->db->get();
        return $resultados->result();
	}


	public function getListGastosFecha2($fecha)
	{
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("g.*,u.rol_id as Rol,u.Nombre as Usuario,ig.Nombre as Insumo,up.Nombre as Pago,p.Nombre as Plaza");
		$this->db->from("tbl_gastos g");
		$this->db->join("tbl_usuarios u","g.usuario_id = u.id");
		$this->db->join("tbl_insumos_gastos ig","g.insumo_gasto_id = ig.id");        
		$this->db->join("tbl_unidades_pago up","g.unidad_pago_id = up.id");  
		$this->db->join("tbl_plazas p","g.plaza_id = p.id");
		$query=$this->db->where("g.Fecha >=",$fecha);
		$query=$this->db->where("g.Fecha <=",$fecha);
		$this->db->order_by("g.Fecha","DESC");	 	
        $resultados=$this->db->get();
        return $resultados->result();
	}

	public function getListGastosFechaPlaza($fecha,$plaza_id)
	{
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("g.*,u.rol_id as Rol,u.Nombre as Usuario,ig.Nombre as Insumo,up.Nombre as Pago,p.Nombre as Plaza");
		$this->db->from("tbl_gastos g");
		$this->db->join("tbl_usuarios u","g.usuario_id = u.id");
		$this->db->join("tbl_insumos_gastos ig","g.insumo_gasto_id = ig.id");        
		$this->db->join("tbl_unidades_pago up","g.unidad_pago_id = up.id");  
		$this->db->join("tbl_plazas p","g.plaza_id = p.id");		
		$query=$this->db->where("g.Fecha >=",$fecha);
		$query=$this->db->where("g.Fecha <=",$fecha);
		$query=$this->db->where('g.plaza_id',$plaza_id);
		$query=$this->db->where("g.Corte",0);
		$this->db->order_by("g.Fecha","DESC");	 	
        $resultados=$this->db->get();
        return $resultados->result();
	}


	public function getListGastosFechaPlaza2($fecha,$plaza_id)
	{
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("g.*,u.rol_id as Rol,u.Nombre as Usuario,ig.Nombre as Insumo,up.Nombre as Pago,p.Nombre as Plaza");
		$this->db->from("tbl_gastos g");
		$this->db->join("tbl_usuarios u","g.usuario_id = u.id");
		$this->db->join("tbl_insumos_gastos ig","g.insumo_gasto_id = ig.id");        
		$this->db->join("tbl_unidades_pago up","g.unidad_pago_id = up.id");  
		$this->db->join("tbl_plazas p","g.plaza_id = p.id");		
		$query=$this->db->where("g.Fecha >=",$fecha);
		$query=$this->db->where("g.Fecha <=",$fecha);
		$query=$this->db->where('g.plaza_id',$plaza_id);
		$this->db->order_by("g.Fecha","DESC");	 	
        $resultados=$this->db->get();
        return $resultados->result();
	}

    public function getGastosDia($plaza_id){		
		$this->db->select("g.*,u.Nombre as Usuario,ig.Nombre as Insumo,up.Nombre as Pago,uni.Nombre as Unidad");
		$this->db->from("tbl_gastos g");
		$this->db->join("tbl_usuarios u","g.usuario_id = u.id");
		$this->db->join("tbl_insumos_gastos ig","g.insumo_gasto_id = ig.id");        
		$this->db->join("tbl_unidades_pago up","g.unidad_pago_id = up.id"); 
		$this->db->join("tbl_plazas p","g.plaza_id = p.id"); 
		$this->db->join("tbl_insumos i","ig.insumo_id = i.id"); 		
		$this->db->join("tbl_unidades uni","ig.unidad_id = uni.id"); 
		$this->db->where('g.Fecha',date("Y-m-d")); 		
		$this->db->where('g.plaza_id',$plaza_id); 	
		$this->db->where('u.rol_id !=',1);
		$this->db->where('u.rol_id !=',3); 	
        $resultados=$this->db->get();
        return $resultados->result();
	}
	
	public function getGastosDiaAdmin(){		
		$this->db->select("g.*,u.Nombre as Usuario,ig.Nombre as Insumo,up.Nombre as Pago,p.Nombre as Plaza");
		$this->db->from("tbl_gastos g");
		$this->db->join("tbl_usuarios u","g.usuario_id = u.id");
		$this->db->join("tbl_insumos_gastos ig","g.insumo_gasto_id = ig.id");        
		$this->db->join("tbl_unidades_pago up","g.unidad_pago_id = up.id");
		$this->db->join("tbl_plazas p","g.plaza_id = p.id");
		$this->db->where('g.Fecha',date("Y-m-d"));
		$names = array(3,1);
		$this->db->where_in('u.rol_id', $names);				
        $resultados=$this->db->get();
        return $resultados->result();
	}
	
	/**
	 * Listado de gastos administrativos de don Paco filtrados por fecha
	 */
	public function getGastosAdminFecha($fechaInicio, $fechaFin, $plaza_id){		
		$this->db->select("g.*,u.Nombre as Usuario,ig.Nombre as Insumo,up.Nombre as Pago,p.Nombre as Plaza");
		$this->db->from("tbl_gastos g");
		$this->db->join("tbl_usuarios u","g.usuario_id = u.id");
		$this->db->join("tbl_insumos_gastos ig","g.insumo_gasto_id = ig.id");        
		$this->db->join("tbl_unidades_pago up","g.unidad_pago_id = up.id");  
		$this->db->join("tbl_plazas p","g.plaza_id = p.id");
		$this->db->where("g.Fecha >=", $fechaInicio);
		$this->db->where("g.Fecha <=", $fechaFin);	
		// En caso venga la plaza la usamos sino no
		if($plaza_id){
			$this->db->where('g.plaza_id', $plaza_id);
		}
		$names = array(3, 1);
		$this->db->where_in('u.rol_id', $names);	
		$this->db->order_by('g.Fecha',"asc");	
		$resultados=$this->db->get();
		return $resultados->result();
	}



	public function getGruposAdmin(){	
		$this->db->where('id',21); 	
		$this->db->or_where('id',22); 	
		$this->db->or_where('id',24); 			
		$resultados = $this->db->get("tbl_grupo_gastos");		
		return $resultados->result();
	}


	public function getInsumosAdmin(){			
		$this->db->select("*");
		$this->db->from("tbl_insumos_gastos");	
		$this->db->where('grupo_rol_id',8); 					
		$this->db->or_where('grupo_rol_id',4); 	
		$this->db->order_by('Nombre', 'ASC');
		$resultados = $this->db->get();
		return $resultados->result();
	}
	
	public function getGrupos(){	
		$this->db->where('id !=',24);
		$this->db->where('id !=',26);		 	
		$resultados = $this->db->get("tbl_grupo_gastos");		
		return $resultados->result();
	}

	public function getGruposOaxaca(){	
		$this->db->where('id !=',24);				 	
		$resultados = $this->db->get("tbl_grupo_gastos");		
		return $resultados->result();
	}




	

	public function getUnidadesPago(){		
		$resultados = $this->db->get("tbl_unidades_pago");		
		return $resultados->result();
	}


	public function getInsumoGastoID($grupo_id){			
		$this->db->where('grupo_id', $grupo_id);		
		$names = array(8,5);
		$this->db->where_in('grupo_rol_id', $names);		
		$this->db->order_by('Nombre', 'ASC');
		$query = $this->db->get('tbl_insumos_gastos');
		$output = '<option value="">Seleccionar Insumo</option>';
		foreach($query->result() as $row)
		{
		$output .= '<option value="'.$row->id.'">'.$row->Nombre.'</option>';
		}
		return $output;
	}	
	


	public function getInsumos(){		
		$resultados = $this->db->get("tbl_insumos_gastos");
		return $resultados->result();
	}

	public function getInsumosID($grupo_id){		
		$this->db->select("*");
		$this->db->from("tbl_insumos_gastos");		
		$this->db->where("grupo_id",$grupo_id);	
		$resultados = $this->db->get();
		return $resultados->result();
	}

	public function getInsumoReal($insumo_gasto_id){
		$this->db->select("insumo_id");
		$this->db->from("tbl_insumos_gastos");
		$this->db->where("id",$insumo_gasto_id);		
		$query=$this->db->get();        
		if($query->num_rows()>0){
			return $query->row();
		}
		else{
			return false;
		}
	}

	public function getDatosGasto($id){
		$this->db->select("g.*");
		$this->db->from("tbl_gastos g");		
		$this->db->where("g.id",$id);	
		$resultados = $this->db->get();
		return $resultados->row();
	}

	public function getInsumoRealID($id){
		$this->db->select("i.insumo_id");
		$this->db->from("tbl_insumos i");
		$this->db->join("tbl_gastos g","i.id = g.insumo_gasto_id");
		$this->db->where("g.id",$id);		
		$query=$this->db->get();        
		return $query->result();
	}


	
	public function save($data){
		return $this->db->insert("tbl_gastos",$data);
	}

	
	public function getUsuario($id){
		$this->db->where("id",$id);
		$resultado=$this->db->get("tbl_usuarios");
		return $resultado->row();
	}

	public function update($id,$data){
		$this->db->where("id",$id);
		return $this->db->update("tbl_usuarios",$data);
	}

	public function delete($id){		
		$this->db->where('id', $id);
		return $this->db->delete('tbl_gastos');
	}

	public function deleteAdmin($id){
		$this->db->trans_begin();  		
		$this->db->where('id',$id);
		$this->db->delete('tbl_gastos');
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

	public function getGastosVentas($fecha,$plaza_id){
		$this->db->select("g.*,SUM(g.Importe) as Importe");
		$this->db->from("tbl_gastos g");		
		$this->db->join("tbl_usuarios u","g.usuario_id = u.id");
		$this->db->where('g.Fecha', $fecha);
		$this->db->where("g.plaza_id",$plaza_id);	
		$this->db->where('u.rol_id !=',1);
		$this->db->where('u.rol_id !=',3); 	
		$query=$this->db->get();        		
		if($query->num_rows()>0){
			return $query->row();
		}
		else{
			return 0;
		}	
	}




	public function getGastosVentasAdmin($fecha,$plaza_id){
		$this->db->select("g.*,SUM(g.Importe) as Importe");
		$this->db->from("tbl_gastos g");		
		$this->db->join("tbl_usuarios u","g.usuario_id = u.id");
		$this->db->where('g.Fecha', $fecha);
		$this->db->where("g.plaza_id",$plaza_id);	
		$this->db->where('u.rol_id !=',2);
		$this->db->where('u.rol_id !=',4); 	
		$query=$this->db->get();        		
		if($query->num_rows()>0){
			return $query->row();
		}
		else{
			return 0;
		}	
	}

	public function getGastosVentasAll($fecha,$plaza_id){
		$this->db->select("g.*,SUM(g.Importe) as Importe");
		$this->db->from("tbl_gastos g");		
		$this->db->join("tbl_usuarios u","g.usuario_id = u.id");
		$this->db->where('g.Fecha', $fecha);
		$this->db->where("g.plaza_id",$plaza_id);			 	
		$query=$this->db->get();        		
		if($query->num_rows()>0){
			return $query->row();
		}
		else{
			return 0;
		}	
	}


	//ANÁLISIS DE REMESAS MÉTODO CARGADO AL PRINCIPIO
	public function getGastosGeneral($fechainicio,$fechafin){
		$this->db->select(" gg.Nombre as Categoria, 
        SUM((if(g.plaza_id=1,g.Importe,NULL))) as Casitas, 
        SUM((if(g.plaza_id=2,g.Importe,NULL))) as Matamoros, 
        SUM((if(g.plaza_id=3,g.Importe,NULL))) as Oaxaca, 
        SUM((if(g.plaza_id=4,g.Importe,NULL))) as Poza_Rica, 
        SUM((if(g.plaza_id=5,g.Importe,NULL))) as Reynosa_I, 
		SUM((if(g.plaza_id=6,g.Importe,NULL))) as Reynosa_II,
		SUM((if(g.plaza_id=7,g.Importe,NULL))) as Teziutlan
		");

        $this->db->from("tbl_gastos g");        		
        $this->db->join("tbl_insumos_gastos ig","ig.id = g.insumo_gasto_id");
        $this->db->join("tbl_grupo_gastos gg","gg.id = ig.grupo_id");               
		$query=$this->db->where("g.Fecha >=",$fechainicio);
        $query=$this->db->where("g.Fecha <=",$fechafin);
        $this->db->group_by("gg.Nombre"); 	    
        $resultados=$this->db->get();
        return $resultados->result();   
	}


	


	//GRÁFICO SENCILLO PARA EL ANÁLISIS DE LAS REMESAS
	public function getGastosGraficoPlaza($fechaInicio,$fechaFin,$plaza_id,$campo){
        $this->db->select("gg.Nombre as Nombre,SUM(g.{$campo}) as Cantidad");
        $this->db->from("tbl_gastos g");        		
        $this->db->join("tbl_insumos_gastos ig","ig.id =g.insumo_gasto_id");
        $this->db->join("tbl_grupo_gastos gg","gg.id = ig.grupo_id");        
        $query=$this->db->where("g.Fecha >=",$fechaInicio);	
        $query=$this->db->where("g.Fecha <=",$fechaFin);	
		$query=$this->db->where("g.plaza_id",$plaza_id);	
		//$query=$this->db->where("gg.id!=",21);	    
		//$query=$this->db->where("gg.id!=",15);	        
        $this->db->group_by('gg.Nombre'); 	
        $resultados=$this->db->get();
        //echo json_encode($resultados->result());
        return $resultados->result();  
	}

	//GRAFICANDO UN GRUPO PARA EL ANÁLISIS DE LAS REMESAS
	public function getGastosGraficoPlazaGrupo($fechaInicio,$fechaFin,$plaza_id,$grupo_remesa_id,$campo){
        $this->db->select("ig.Nombre as Nombre,SUM(g.{$campo}) as Cantidad");
        $this->db->from("tbl_gastos g");        		
        $this->db->join("tbl_insumos_gastos ig","ig.id =g.insumo_gasto_id");
        $this->db->join("tbl_grupo_gastos gg","gg.id = ig.grupo_id");        
        $query=$this->db->where("g.Fecha >=",$fechaInicio);	
        $query=$this->db->where("g.Fecha <=",$fechaFin);	
		$query=$this->db->where("g.plaza_id",$plaza_id);
		$query=$this->db->where("gg.id",$grupo_remesa_id);	    			        
		$this->db->group_by('ig.Nombre'); 	
		$this->db->order_by("ig.Nombre",'ASC');
        $resultados=$this->db->get();
        //echo json_encode($resultados->result());
        return $resultados->result();  
	}

	public function getGastosGraficoPlazaInsumoDias($fechaInicio,$fechaFin,$plaza_id,$insumo_gasto_remesa_id,$campo){
        $this->db->select("DAYOFMONTH(g.Fecha) as Nombre,SUM(g.{$campo}) as Cantidad");
        $this->db->from("tbl_gastos g");        		
        $this->db->join("tbl_insumos_gastos ig","ig.id =g.insumo_gasto_id");
        $this->db->join("tbl_grupo_gastos gg","gg.id = ig.grupo_id");        
        $query=$this->db->where("g.Fecha >=",$fechaInicio);	
        $query=$this->db->where("g.Fecha <=",$fechaFin);	
		$query=$this->db->where("g.plaza_id",$plaza_id);
		$query=$this->db->where("ig.id",$insumo_gasto_remesa_id);	    			        
		$this->db->group_by('DAYOFMONTH(g.Fecha),ig.Nombre'); 	
		$this->db->order_by("DAY(g.Fecha)");
        $resultados=$this->db->get();
        //echo json_encode($resultados->result());
        return $resultados->result();  
	}


	public function getGastosGraficoPlazaInsumoMes($fechaInicio,$fechaFin,$plaza_id,$insumo_gasto_remesa_id,$campo){
        $this->db->select("MONTHNAME(g.Fecha) as Nombre,SUM(g.{$campo}) as Cantidad");
        $this->db->from("tbl_gastos g");        		
        $this->db->join("tbl_insumos_gastos ig","ig.id =g.insumo_gasto_id");
        $this->db->join("tbl_grupo_gastos gg","gg.id = ig.grupo_id");        
        $query=$this->db->where("g.Fecha >=",$fechaInicio);	
        $query=$this->db->where("g.Fecha <=",$fechaFin);	
		$query=$this->db->where("g.plaza_id",$plaza_id);
		$query=$this->db->where("ig.id",$insumo_gasto_remesa_id);	    			        
		$this->db->group_by('MONTHNAME(g.Fecha),ig.Nombre'); 
		$this->db->order_by("MONTH(g.Fecha)");			
        $resultados=$this->db->get();
        //echo json_encode($resultados->result());
        return $resultados->result();  
	}
	
	public function getGastosGeneralPlaza($fechainicio,$fechafin,$plaza_id){
		$this->db->select("gg.id as familia_id, gg.Nombre as Categoria, 
		SUM((if(g.plaza_id=$plaza_id,g.Importe,NULL))) as Plaza,
		p.Nombre as nombrePlaza,
		SUM(g.Cantidad) as Piezas
		");

        $this->db->from("tbl_gastos g");        		
        $this->db->join("tbl_insumos_gastos ig","ig.id = g.insumo_gasto_id");
		$this->db->join("tbl_grupo_gastos gg","gg.id = ig.grupo_id"); 
		$this->db->join("tbl_plazas p","p.id = g.plaza_id"); 
		$query=$this->db->where("g.Fecha >=",$fechainicio);
		$query=$this->db->where("g.Fecha <=",$fechafin);
		$query=$this->db->where("g.plaza_id",$plaza_id);
        $this->db->group_by("gg.Nombre"); 	    
        $resultados=$this->db->get();
        return $resultados->result();   
	}

	public function getGastosFechaGrupo($fechainicio,$fechafin,$grupo_id){
		$this->db->select("g.*,pl.Nombre as Plaza,
		SUM((if(gg.id=$grupo_id,g.Cantidad,NULL))) as Piezas,
		SUM((if(gg.id=$grupo_id,g.Importe,NULL))) as Importe,
		gg.Nombre as Grupo
		");
		$this->db->from("tbl_gastos g");        		
        $this->db->join("tbl_insumos_gastos ig","ig.id = g.insumo_gasto_id");
		$this->db->join("tbl_grupo_gastos gg","gg.id = ig.grupo_id");    
		$this->db->join("tbl_plazas pl","pl.id = g.plaza_id");    
		$query=$this->db->where("g.Fecha >=",$fechainicio);
		$query=$this->db->where("g.Fecha <=",$fechafin);
		$query=$this->db->where("gg.id",$grupo_id);   
		$this->db->group_by("g.plaza_id"); 
        $resultados=$this->db->get();
        return $resultados->result();   
	}

	public function getGastosFechaGrupoPlaza($fechainicio,$fechafin,$grupo_id,$plaza_id){
		$this->db->select("g.*,pl.Nombre as Plaza,
		SUM((if(gg.id=$grupo_id,g.Cantidad,NULL))) as Piezas,
		SUM((if(gg.id=$grupo_id,g.Importe,NULL))) as Importe,
		gg.Nombre as Grupo
		");
		$this->db->from("tbl_gastos g");        		
        $this->db->join("tbl_insumos_gastos ig","ig.id = g.insumo_gasto_id");
		$this->db->join("tbl_grupo_gastos gg","gg.id = ig.grupo_id");    
		$this->db->join("tbl_plazas pl","pl.id = g.plaza_id");    
		$query=$this->db->where("g.Fecha >=",$fechainicio);
		$query=$this->db->where("g.Fecha <=",$fechafin);
		$query=$this->db->where("g.plaza_id",$plaza_id);   
		$query=$this->db->where("gg.id",$grupo_id);   
		$this->db->group_by("g.plaza_id"); 
        $resultados=$this->db->get();
        return $resultados->result();   
	}
	
	public function getGastosFechaGrupoInsumo($fechainicio,$fechafin,$insumo_id){
		$this->db->select("g.*,pl.Nombre as Plaza,
		SUM((if(ig.id=$insumo_id,g.Cantidad,NULL))) as Piezas,
		SUM((if(ig.id=$insumo_id,g.Importe,NULL))) as Importe,
		ig.Nombre as Grupo,
		ig.id as insumo_id
		");

		$this->db->from("tbl_gastos g");        		
        $this->db->join("tbl_insumos_gastos ig","ig.id = g.insumo_gasto_id");
		$this->db->join("tbl_grupo_gastos gg","gg.id = ig.grupo_id");    
		$this->db->join("tbl_plazas pl","pl.id = g.plaza_id");    
		$query=$this->db->where("g.Fecha >=",$fechainicio);
		$query=$this->db->where("g.Fecha <=",$fechafin);
		$query=$this->db->where("ig.id",$insumo_id);   
		$this->db->group_by("g.plaza_id"); 
        $resultados=$this->db->get();
        return $resultados->result();   
	}


	public function getGastosFechaGrupoInsumoPlaza($fechainicio,$fechafin,$plaza_id,$insumo_id){
		$this->db->select("g.*,pl.Nombre as Plaza,
		SUM((if(ig.id=$insumo_id,g.Cantidad,NULL))) as Piezas,
		SUM((if(ig.id=$insumo_id,g.Importe,NULL))) as Importe,
		ig.Nombre as Grupo,
		ig.id as insumo_id
		");

		$this->db->from("tbl_gastos g");        		
        $this->db->join("tbl_insumos_gastos ig","ig.id = g.insumo_gasto_id");
		$this->db->join("tbl_grupo_gastos gg","gg.id = ig.grupo_id");    
		$this->db->join("tbl_plazas pl","pl.id = g.plaza_id");    
		$query=$this->db->where("g.Fecha >=",$fechainicio);
		$query=$this->db->where("g.Fecha <=",$fechafin);
		$query=$this->db->where("g.plaza_id",$plaza_id);
		$query=$this->db->where("ig.id",$insumo_id);   
		$this->db->group_by("g.plaza_id"); 
        $resultados=$this->db->get();
        return $resultados->result();   
	}


	public function actualizarGasto2($id,$data)
	{
		$this->db->where("id",$id);					
		return $this->db->update("tbl_gastos",$data);
	}
	
	public function getNombreInsumoGasto($insumo_gasto_remesa_id){
		$this->db->select("Nombre as nombreInsumo");
		$this->db->from("tbl_insumos_gastos i");		
		$this->db->where("i.id",$insumo_gasto_remesa_id);		
		$query=$this->db->get();        		
        return $query->row();
	}

	public function getFolio($folio_id){		
		$this->db->select("m.Folio as Folio");
		$this->db->from("tbl_folios m");					
		$this->db->where("m.id",$folio_id);																	
		$resultados=$this->db->get();		
        return $resultados->row();	
	}
	
	public function actualizarFolio($id,$data){
        $this->db->where("id",$id);
		return $this->db->update("tbl_folios",$data);
	}
	
	public function getNombresArchivos($id){
		$this->db->select("g.*");
		$this->db->from("tbl_gastos g");					
		$this->db->where("g.id",$id);																	
		$resultados=$this->db->get();		
        return $resultados->row();
	}

}

