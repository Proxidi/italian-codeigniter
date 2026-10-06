<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mdl_formulas extends CI_model{
	
	public function getFormulas(){
		$this->db->select("pi.*,p.Nombre as Nombre,i.Nombre as Insumo");
		$this->db->from("tbl_productos_insumos pi");
		$this->db->join("tbl_productos p","pi.producto_id = p.id");
		$this->db->join("tbl_insumos i","pi.insumo_id = i.id");
		$this->db->order_by("p.id","ASC");				
        $resultados=$this->db->get();
        return $resultados->result();
	}

	public function getFormula($id){
		$this->db->select("pi.*,p.Nombre as Nombre,i.Nombre as Insumo,u.Nombre as Unidad");
		$this->db->from("tbl_productos_insumos pi");
		$this->db->join("tbl_productos p","pi.producto_id = p.id");
		$this->db->join("tbl_insumos i","pi.insumo_id = i.id");
		$this->db->join("tbl_unidades u","i.unidad_id = u.id");		
		$this->db->where("pi.producto_id",$id);
		$resultado=$this->db->get();
		return $resultado->result();
	}

	public function getFormulaID($id){
		$this->db->where("id",$id);
		$resultado=$this->db->get("tbl_productos_insumos");
		return $resultado->row();
	}

	public function checarInsumoProducto($producto_id,$insumo_id){		
		$query=$this->db->where("producto_id",$producto_id);
		$query=$this->db->where("insumo_id",$insumo_id);			
		$resultados=$this->db->get("tbl_productos_insumos");
		if($resultados->num_rows()>0){
			return false;
		}
		else{
			return true;
		}
	}
    
	public function save($data){
		return $this->db->insert("tbl_productos_insumos",$data);
	}

	public function delete($id){
		$this->db->where('id', $id);
		$this->db->delete('tbl_productos_insumos');
		if($this->db->affected_rows()){
			return true;
		}
		else{
			return false;
		}
	}

	
	public function update($id,$data){
		$this->db->where("id",$id);
		return $this->db->update("tbl_productos_insumos",$data);
	}

	public function getFormulaModal($producto_id)
	{			
		$this->db->select("pi.*,p.Nombre as Nombre,i.Nombre as Insumo,u.Nombre as Unidad");
		$this->db->from("tbl_productos_insumos pi");
		$this->db->join("tbl_productos p","pi.producto_id = p.id");
		$this->db->join("tbl_insumos i","pi.insumo_id = i.id");
		$this->db->join("tbl_unidades u","i.unidad_id = u.id");		
		$this->db->where("pi.producto_id",$producto_id);	
		$query = $this->db->get();	
		$output ='';
		foreach($query->result() as $row)
		{			
		$output .='<tr >';					
		$output .= '<td>'.$row->Nombre.'</td>';				
		$output .= '<td>'.$row->Insumo.'</td>';
		$output .= '<td>'.$row->Cantidad.'</td>';	
		
		$output .= '<td><button type="button" class="btn btn-info"  onclick="asignarValoresModalFormula('.$row->id.','.$row->insumo_id.',\''.$row->Nombre.'\',\''.$row->Insumo.'\','.$row->Cantidad.')" data-toggle="modal" data-target="#editarCantidadFormula" >';	
		$output .= '<span class="fa fa-edit"> </span></button></td>';		

		$output .= '<td><button type="button" class="btn btn-danger" onclick="eliminarFormula('.$row->id.')"  value="">';	
		$output .= '<span class="fa fa-remove"> </span></button> </td>';

		$output.='</tr>';
		}		
		return $output;
	}


	public function getFormulaModalLeer($producto_id)
	{			
		$this->db->select("pi.*,p.Nombre as Nombre,i.Nombre as Insumo,u.Nombre as Unidad");
		$this->db->from("tbl_productos_insumos pi");
		$this->db->join("tbl_productos p","pi.producto_id = p.id");
		$this->db->join("tbl_insumos i","pi.insumo_id = i.id");
		$this->db->join("tbl_unidades u","i.unidad_id = u.id");		
		$this->db->where("pi.producto_id",$producto_id);	
		$query = $this->db->get();	
		$output ='';
		foreach($query->result() as $row)
		{			
		$output .='<tr >';					
		$output .= '<td>'.$row->Nombre.'</td>';				
		$output .= '<td>'.$row->Insumo.'</td>';
		$output .= '<td>'.$row->Cantidad.'</td>';	
		$output .= '<td>'.$row->Unidad.'</td>';	
		$output .= '<td><button type="button" class="btn btn-info"  onclick="asignarValoresModalFormula('.$row->id.','.$row->producto_id.','.$row->insumo_id.',\''.$row->Nombre.'\',\''.$row->Insumo.'\','.$row->Cantidad.')" data-toggle="modal" data-target="#editarCantidadFormula" >';	
		$output .= '<span class="fa fa-edit"> </span></button></td>';	

		$output .= '<td><button type="button" onclick="eliminarFormula('.$row->producto_id.','.$row->id.')" class="btn btn-danger"  value="">';	
		$output .= '<span class="fa fa-remove"> </span></button> </td>';	

		$output.='</tr>';
		}		
		return $output;
	}

	public function getFormulasAJAX()
	{			
		$this->db->select("pi.*,p.Nombre as Nombre,i.Nombre as Insumo,u.Nombre as Unidad");
		$this->db->from("tbl_productos_insumos pi");
		$this->db->join("tbl_productos p","pi.producto_id = p.id");
		$this->db->join("tbl_insumos i","pi.insumo_id = i.id");
		$this->db->join("tbl_unidades u","i.unidad_id = u.id");
		$this->db->order_by("p.id","asc");
		$this->db->order_by("i.id","asc");

		$query = $this->db->get();	
		$output ='';
		foreach($query->result() as $row)
		{			
		$output .='<tr >';					
		$output .= '<td>'.$row->Nombre.'</td>';				
		$output .= '<td>'.$row->Insumo.'</td>';
		$output .= '<td>'.$row->Cantidad.'</td>';	

		$output .= '<td><button type="button" class="btn btn-info"  onclick="asignarValoresModalFormula('.$row->id.','.$row->insumo_id.',\''.$row->Nombre.'\',\''.$row->Insumo.'\','.$row->Cantidad.')" data-toggle="modal" data-target="#editarCantidadFormula" >';	
		$output .= '<span class="fa fa-edit"> </span></button></td>';		

		$output .= '<td><button type="button" onclick="eliminarFormula('.$row->id.')" class="btn btn-danger"  value="">';	
		$output .= '<span class="fa fa-remove"> </span></button> </td>';	
		
	
		$output.='</tr>';
		}		
		return $output;
	}


	

	

	

}

