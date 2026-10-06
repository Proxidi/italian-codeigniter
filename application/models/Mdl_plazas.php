<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mdl_plazas extends CI_model{

	public function getPlazas(){
        //Aquí se valida que la categoria se encuentre activa
		$resultados = $this->db->get("tbl_plazas");
		return $resultados->result();
	}

	public function getMeses(){        
		$resultados = $this->db->get("tbl_meses");
		return $resultados->result();
	}

	public function getYears(){        
		$resultados = $this->db->get("tbl_years");
		return $resultados->result();
	}

	public function getPlazaID($id){
		$this->db->select("Nombre as nombrePlaza");
		$this->db->from("tbl_plazas p");		
		$this->db->where("p.id",$id);		
		$query=$this->db->get();        		
        return $query->row();
	}

	public function getTiposGraficos(){
		$resultados = $this->db->get("tbl_tipo_grafico");
		return $resultados->result();
	}

	public function getTipoGraficoID($familia_id){
		$resultados = $this->db->where("familia_id",$familia_id);		
		$resultados = $this->db->get("tbl_tipo_grafico");
		return $resultados->result();
	}

	public function getYearValue($year_id){
		$this->db->select("Nombre");
		$this->db->from("tbl_years");		
		$this->db->where("id",$year_id);		
		$query=$this->db->get();        		
        return $query->row();
	}

	public function getIdValue($year){
		$this->db->select("id");
		$this->db->from("tbl_years");		
		$this->db->where("Nombre",$year);		
		$query=$this->db->get();        		
        return $query->row();
	}

	public function getNombrePlaza($plaza_id){
		$this->db->select("Nombre");
		$this->db->from("tbl_plazas");		
		$this->db->where("id",$plaza_id);		
		$query=$this->db->get();        		
        return $query->row();
	}
}




