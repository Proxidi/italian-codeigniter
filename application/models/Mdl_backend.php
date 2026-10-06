<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mdl_backend extends CI_Model {


	public function getID($link){
		$this->db->like("link",$link);
		$resultado = $this->db->get("tbl_menus");
		return $resultado->row();
	}

	public function getPermisos($menu,$rol){
		$this->db->where("menu_id",$menu);
		$this->db->where("rol_id",$rol);
		$resultado = $this->db->get("tbl_permisos");
		return $resultado->row();
    }
    
    

	public function rowCount($tabla,$plaza_id){		
		$this->db->where("Bandera !=","1");
		$this->db->where("plaza_id",$plaza_id);
		$this->db->where("Activo", 1);
		$resultados = $this->db->get($tabla);
		return $resultados->num_rows();
	}

	public function rowCountFecha($tabla,$fecha,$plaza_id){		
		$this->db->where("Bandera","0");
		$this->db->where("Fecha",$fecha);		
		$this->db->where("plaza_id",$plaza_id);				
		$resultados = $this->db->get($tabla);
		return $resultados->num_rows();
	}

	public function rowCountNormal($tabla,$fecha,$plaza_id){				
		$this->db->where("Fecha",$fecha);		
		$this->db->where("plaza_id",$plaza_id);		
		$resultados = $this->db->get($tabla);
		return $resultados->num_rows();
	}


	

	
}
