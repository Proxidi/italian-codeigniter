<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mdl_seguridad extends CI_model{
	
	public function autenticar($username,$password){
	
		$this->db->select("u.*,p.Nombre as Plaza,r.Nombre as Rol");
		$this->db->from("tbl_usuarios u");
		$this->db->join("tbl_plazas p","u.plaza_id = p.id");
		$this->db->join("tbl_roles r","u.rol_id = r.id");		
		$query=$this->db->where("u.Usuario",$username);
		$query=$this->db->where("u.Password",$password);		
		$resultados=$this->db->get(); 
		if($resultados->num_rows()>0){
			return $resultados->row();
		}
		else{
			return false;
		}

	}


	













}

