<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mdl_permisos extends CI_model{
	

    public function getPermisos(){		
		
		$this->db->select("p.*,r.Nombre as Nombre,m.Nombre as Menu,m.Link as Link,p.Leer as Permiso");
		$this->db->from("tbl_permisos p");
		$this->db->join("tbl_roles r","p.rol_id = r.id");
		$this->db->join("tbl_menus m","p.menu_id = m.id");
        $resultados=$this->db->get();
        return $resultados->result();
	}


	public function getPermisosAJAX()
	{			
		$this->db->select("p.*,r.Nombre as Nombre,m.Nombre as Menu,m.Link as Link,p.Leer as Permiso");
		$this->db->from("tbl_permisos p");
		$this->db->join("tbl_roles r","p.rol_id = r.id");
		$this->db->join("tbl_menus m","p.menu_id = m.id");        
		$query = $this->db->get();	
		$output ='';
		foreach($query->result() as $row)
		{			
		$output .='<tr >';					
		$output .= '<td>'.$row->Nombre.'</td>';				
		$output .= '<td>'.$row->Menu.'</td>';
		$output .= '<td>'.$row->Link.'</td>';	
		$output .= '<td>'.$row->Permiso.'</td>';	

		$output .= '<td><button type="button" class="btn btn-success"  onclick="otorgarPermiso('.$row->rol_id.','.$row->menu_id.')" data-toggle="modal" data-target="#editarValorPermiso" >';	
		$output .= '<span class="fa fa-check"> </span></button></td>';		

		$output .= '<td><button type="button" onclick="denegarPermiso('.$row->rol_id.','.$row->menu_id.')" class="btn btn-danger"  value="">';	
		$output .= '<span class="fa fa-remove"> </span></button> </td>';	
		
	
		$output.='</tr>';
		}		
		return $output;
	}


	public function getPermiso($id){
		$this->db->where("id",$id);
		$resultado = $this->db->get("tbl_permisos");
		return $resultado->row();
	}
	

	public function getMenus(){
		$resultados = $this->db->get("tbl_menus");
		$this->db->order_by('Nombre','asc');
		return $resultados->result();
	}

	public function getRoles(){
		$resultados = $this->db->get("tbl_roles");
		return $resultados->result();
	}
	

	public function save($data){
		return $this->db->insert("tbl_permisos",$data);
	}

	public function saveMenu($data){
		return $this->db->insert("tbl_menus",$data);
	}

	public function savePermiso($data){
		return $this->db->insert("tbl_permisos",$data);
	}

	public function delete($id){
		$this->db->where("id",$id);
		$this->db->delete("tbl_permisos");
		
	}


	public function update($id,$data){
		$this->db->where("id",$id);
		return $this->db->update("tbl_permisos",$data);
	}


	public function permisos($rol_id,$menu_id,$data){						
			$this->db->where('rol_id', $rol_id);
			$this->db->where('menu_id', $menu_id);			
			return $this->db->update('tbl_permisos', $data);				
	}


}

