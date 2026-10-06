<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mdl_usuarios extends CI_model{
	
	public function getUsuarios(){
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("u.*,r.Nombre as Rol,p.Nombre as Plaza");
		$this->db->from("tbl_usuarios u");
		$this->db->join("tbl_roles r","u.rol_id = r.id");
		$this->db->join("tbl_plazas p","u.plaza_id = p.id");	
		$this->db->order_by('u.id', 'ASC');	
        $resultados=$this->db->get();
        return $resultados->result();
	}


	public function getNotificaciones(){
        //Aquí se valida que la categoria se encuentre activa
		$resultados = $this->db->get("tbl_notificaciones");
		return $resultados->result();
	}



	public function getUsuariosID($id){
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("u.*,r.Nombre as Rol,p.Nombre as Plaza");
		$this->db->from("tbl_usuarios u");
		$this->db->join("tbl_roles r","u.rol_id = r.id");
		$this->db->join("tbl_plazas p","u.plaza_id = p.id");		
		$query=$this->db->where("u.id",$id);
        $resultados=$this->db->get();
        return $resultados->result();
	}

	public function getIDTextoPlano($sha1_id){
		$this->db->select("id");											
		$query=$this->db->where("sha1_id",$sha1_id);	
		$resultados=$this->db->get("tbl_usuarios");
		if($resultados->num_rows()>0){
			return $resultados->row();
		}
		else{
			return false;
		}
	}


	public function pwdVerify($password,$id)
	{
		$this->db->select("Password");									
		$query=$this->db->where("Password",$password);	
		$query=$this->db->where("id",$id);	
		$resultados=$this->db->get("tbl_usuarios");
		if($resultados->num_rows()>0){
			return $resultados->row();
		}
		else{
			return false;
		}
	}
	
	public function getUsuario($id){
		$this->db->where("sha1_id",$id);
		$resultado=$this->db->get("tbl_usuarios");
		return $resultado->row();
	}

	public function getUsuarioID($id){
		$this->db->where("id",$id);
		$resultado=$this->db->get("tbl_usuarios");
		return $resultado->row();
	}



	public function update($id,$data){
		$this->db->where("id",$id);
		return $this->db->update("tbl_usuarios",$data);
	}


	public function delete($hash){			
		$this->db->where('Hash', $hash);
		$this->db->delete('tbl_usuarios');			 		 								
		if($this->db->affected_rows()){
			return true;
		}
		else{
			return false;
		}
	}


	public function save($data){	
			$this->db->trans_begin();   				
			$this->db->insert("tbl_usuarios",$data);
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

	public function insertarHash($id,$data){
		$this->db->trans_begin();   
		$this->db->where("id",$id);
		$this->db->update("tbl_usuarios",$data);
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

	public function insertarAcceso($data){
		return $this->db->insert("tbl_bitacora_accesos",$data);
	}

	public function getListaAccesos(){
		$this->db->select("ba.*,p.Nombre as Plaza,u.Nombre as Usuario,r.Nombre as Rol");
		$this->db->from("tbl_bitacora_accesos ba");
		$this->db->join("tbl_usuarios u","ba.usuario_id = u.id");
		$this->db->join("tbl_plazas p","ba.plaza_id = p.id");		
		$this->db->join("tbl_roles r","u.rol_id = r.id");				
		$this->db->order_by("ba.Fecha","desc");
		$this->db->order_by("ba.Hora","desc");
        $resultados=$this->db->get();
        return $resultados->result();
	}
	
	public function getListaAccesosFecha($fecha){
		$this->db->select("ba.*,p.Nombre as Plaza,u.Nombre as Usuario,r.Nombre as Rol");
		$this->db->from("tbl_bitacora_accesos ba");
		$this->db->join("tbl_usuarios u","ba.usuario_id = u.id");
		$this->db->join("tbl_plazas p","ba.plaza_id = p.id");		
		$this->db->join("tbl_roles r","u.rol_id = r.id");	
		$this->db->where("ba.Fecha",$fecha);
		$this->db->order_by("ba.Fecha","desc");
		$this->db->order_by("ba.Hora","desc");
        $resultados=$this->db->get();
        return $resultados->result();
	}


	public function actualizarFechaNotificacion($fecha){
		$data=array("Fecha"=>$fecha);
		return $this->db->update("tbl_notificaciones",$data);
	}

	public function getFechaCorte(){
		$this->db->select("Fecha");
		$resultado=$this->db->get("tbl_notificaciones");
		return $resultado->row();
	}

	


}

