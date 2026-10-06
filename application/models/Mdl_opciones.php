<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mdl_opciones extends CI_model{

	public function getDias(){        
		$resultados = $this->db->get("tbl_rango_archivos");
		return $resultados->result();
	}

	public function actualizarRangoArchivos($data){	  
      $this->db->trans_begin();   							                  
      $this->db->update('tbl_rango_archivos',$data);	            
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

	public function getNumeroDias(){	  
		$this->db->select("r.Numero_Dias as Dias");
		$this->db->from("tbl_rango_archivos r");	
		$resultado=$this->db->get();		
		return $resultado->row();
	}



	
	
}
