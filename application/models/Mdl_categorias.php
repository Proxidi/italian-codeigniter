<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mdl_categorias extends CI_model{
	

	public function getCategorias(){
		//Aquí se valida que la categoria se encuentre activa
		$query=$this->db->where("estado","1");
        $resultados=$this->db->get("categorias");
        return $resultados->result();
	}

	

	public function save($data){
		return $this->db->insert("categorias",$data);

	}

	public function getCategoria($id){
		$this->db->where("id",$id);
		$resultado=$this->db->get("categorias");
		return $resultado->row();
	}

	public function update($id,$data){
		$this->db->where("id",$id);
		return $this->db->update("categorias",$data);
	}

	

}

