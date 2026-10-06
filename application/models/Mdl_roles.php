<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mdl_roles extends CI_model{

	public function getRoles(){
        //Aquí se valida que la categoria se encuentre activa
		$resultados = $this->db->get("tbl_roles");
		return $resultados->result();
	}
	
}
