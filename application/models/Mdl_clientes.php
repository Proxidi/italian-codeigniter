<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mdl_clientes extends CI_model{
	

	public function getClientes(){
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("c.*,tc.nombre as tipocliente,td.nombre as tipodocumento");
		$this->db->from("clientes c");
		$this->db->join("tipo_cliente tc","c.tipo_cliente_id=tc.id");
		$this->db->join("tipo_documento td","c.tipo_documento_id=td.id");
		$query=$this->db->where("c.estado","1");
        $resultados=$this->db->get();
        return $resultados->result();
	}


	public function save($data){
		return $this->db->insert("clientes",$data);
	}

	public function getCliente($id){
		$this->db->where("id",$id);
		$resultado=$this->db->get("clientes");
		return $resultado->row();
	}

	public function update($id,$data){
		$this->db->where("id",$id);
		return $this->db->update("clientes",$data);
	}

	

}

