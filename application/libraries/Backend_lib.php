<?php
class Backend_lib{
	private $CI;
	public function __construct(){
		$this->CI = & get_instance();
	}

	public function control(){
		if (!$this->CI->session->userdata("login")) {
			redirect(base_url());
		}
		$url = $this->CI->uri->segment(1);
		if ($this->CI->uri->segment(2)) {
			$url = $this->CI->uri->segment(1)."/".$this->CI->uri->segment(2);
		}
				
		$infomenu = $this->CI->Mdl_backend->getID($url);
		if($infomenu==null){
			redirect(base_url()."Inicio");
		}
		else{			
			$permisos = $this->CI->Mdl_backend->getPermisos($infomenu->id,$this->CI->session->userdata("rol_id"));
			if($permisos==null){
				
				redirect(base_url()."Inicio");
			}
			else{				
			if ($permisos->Leer == 0 ) {
			    redirect(base_url()."Inicio");			
			}else{				
				return $permisos;
			}				
			}
		}		
	}
}