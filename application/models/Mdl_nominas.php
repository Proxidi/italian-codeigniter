<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mdl_nominas extends CI_model
{

	public function getRoles()
	{
		//Aquí se valida que la categoria se encuentre activa
		$resultados = $this->db->get("tbl_roles_nomina");
		return $resultados->result();
	}

	public function saveUsuario($data)
	{
		$this->db->trans_begin();
		$this->db->insert("tbl_usuarios_nomina", $data);
		$insert_id = $this->db->insert_id();
		if ($this->db->trans_status() === FALSE) {
			//Hubo errores en la consulta, entonces se cancela la transacción.
			$this->db->trans_rollback();
			return false;
		} else {
			//Todas las consultas se hicieron correctamente.
			$this->db->trans_commit();
			return $insert_id;
		}
	}

	public function saveExtra($data)
	{
		return $this->db->insert("tbl_extras_nomina", $data);
	}

	public function getUsuarios($plaza_id)
	{
		$this->db->select("u.*,r.Nombre as Rol,r.id as rolID,p.Nombre as Plaza");
		$this->db->from("tbl_usuarios_nomina u");
		$this->db->join("tbl_roles_nomina r ", "u.rol_nomina_id=r.id");
		$this->db->join("tbl_plazas p ", "u.plaza_id=p.id");
		$this->db->where('u.plaza_id', $plaza_id);
		$this->db->where('u.Activo', 1);
		$resultados = $this->db->get();
		return $resultados->result();
	}

	public function getUsuariosEliminados($plaza_id)
	{
		$this->db->select("u.*,r.Nombre as Rol,p.Nombre as Plaza");
		$this->db->from("tbl_usuarios_nomina u");
		$this->db->join("tbl_roles_nomina r ", "u.rol_nomina_id=r.id");
		$this->db->join("tbl_plazas p ", "u.plaza_id=p.id");
		$this->db->where('u.plaza_id', $plaza_id);
		$this->db->where('u.Activo', 0);
		$resultados = $this->db->get();
		return $resultados->result();
	}


	public function getUsuariosEliminadosT()
	{
		$this->db->select("u.*,r.Nombre as Rol,p.Nombre as Plaza");
		$this->db->from("tbl_usuarios_nomina u");
		$this->db->join("tbl_roles_nomina r ", "u.rol_nomina_id=r.id");
		$this->db->join("tbl_plazas p ", "u.plaza_id=p.id");
		$this->db->where('u.Activo', 0);
		$this->db->order_by('u.plaza_id');
		$resultados = $this->db->get();
		return $resultados->result();
	}

	public function getUsuariosT()
	{
		$this->db->select("u.*,r.Nombre as Rol,r.id as rolID,p.Nombre as Plaza");
		$this->db->from("tbl_usuarios_nomina u");
		$this->db->join("tbl_roles_nomina r ", "u.rol_nomina_id=r.id");
		$this->db->join("tbl_plazas p ", "u.plaza_id=p.id");
		$this->db->where('u.Activo', 1);
		$this->db->order_by('u.plaza_id');
		$resultados = $this->db->get();
		return $resultados->result();
	}

	public function consultarFechaIngreso($id)
	{
		$this->db->select("u.Fecha_Ingreso as fechaIngreso");
		$this->db->from("tbl_usuarios_nomina u");
		$this->db->where("id", $id);
		$resultados = $this->db->get();
		return $resultados->row();
	}


	public function getLugares()
	{
		$this->db->select("r.*");
		$this->db->from("tbl_roles_cafeteria_nomina r");
		$resultados = $this->db->get();
		return $resultados->result();
	}

	public function getActivos()
	{
		$this->db->select("u.*,r.Nombre as Rol,p.Nombre as Plaza");
		$this->db->from("tbl_usuarios_nomina u");
		$this->db->join("tbl_roles_nomina r ", "u.rol_nomina_id=r.id");
		$this->db->join("tbl_plazas p ", "u.plaza_id=p.id");
		$this->db->where('u.Activo', 1);
		$resultados = $this->db->get();
		return $resultados->result();
	}

	public function getDiasNominaCompleto()
	{
		$resultados = $this->db->get("tbl_dias_nomina");
		return $resultados->result();
	}


	public function getPlazaUsuario($usuario_id)
	{
		$this->db->select("u.plaza_id as Plaza");
		$this->db->from("tbl_usuarios_nomina u");
		$this->db->where("u.id", $usuario_id);
		$resultados = $this->db->get();
		return $resultados->row();
	}

	public function getDiasNomina($id)
	{
		$this->db->where('id>=', $id);
		$resultados = $this->db->get("tbl_dias_nomina");
		return $resultados->result();
	}

	public function getConceptos()
	{
		$this->db->where('Nomina', 1);
		$resultados = $this->db->get("tbl_conceptos_nomina");
		return $resultados->result();
	}

	public function getTurnosNomina()
	{
		$resultados = $this->db->get("tbl_turnos_nomina");
		return $resultados->result();
	}

	public function saveRolNominas($data)
	{
		return $this->db->insert("tbl_rol_semanal_nomina", $data);
	}

	public function saveRolNominasDoble($data)
	{
		return $this->db->insert_batch('tbl_rol_semanal_nomina', $data);
	}

	public function getEstado($plaza_id, $fechaInicio, $fechaFin)
	{
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("r.Estado as Estado");
		$this->db->from("tbl_rol_semanal_nomina r");
		$this->db->where("r.plaza_id", $plaza_id);
		$this->db->where("r.Fecha>=", $fechaInicio);
		$this->db->where("r.Fecha<=", $fechaFin);
		$resultados = $this->db->get();
		return $resultados->row();
	}

	public function getRolSemanal($plaza_id, $fechaInicio, $fechaFin)
	{
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("r.*,
        p.Nombre as Plaza,
        u.Nombre as Nombre,      
        n.Nombre as Rol,      
        SUM((if(r.dia_id =1,r.Valor,0))) as Lunes, 
        SUM((if(r.dia_id =2,r.Valor,0))) as Martes, 
        SUM((if(r.dia_id =3,r.Valor,0))) as Miercoles, 
        SUM((if(r.dia_id =4,r.Valor,0))) as Jueves, 
        SUM((if(r.dia_id =5,r.Valor,0))) as Viernes, 
        SUM((if(r.dia_id =6,r.Valor,0))) as Sabado,
        SUM((if(r.dia_id =7,r.Valor,0))) as Domingo,
        SUM(r.Sueldo) as Total,
        SUM(r.Extra) as Extra,
        r.Sueldo as Sueldo
        ");

		$this->db->from("tbl_rol_semanal_nomina r");
		$this->db->join("tbl_usuarios_nomina u", "u.id = r.usuario_nomina_id");
		$this->db->join("tbl_roles_nomina n", "n.id = u.rol_nomina_id");
		$this->db->join("tbl_plazas p", "p.id = r.plaza_id");
		$this->db->where("r.Fecha>=", $fechaInicio);
		$this->db->where("r.Fecha<=", $fechaFin);
		$this->db->where("r.plaza_id", $plaza_id);
		$this->db->group_by("u.id");
		$resultados = $this->db->get();
		return $resultados->result();
	}

	public function getRolSemanalCompleto($fechaInicio, $fechaFin)
	{
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("r.*,
        p.Nombre as Plaza,
        u.Nombre as Nombre,      
        n.Nombre as Rol,      
        SUM((if(r.dia_id =1,r.Valor,0))) as Lunes, 
        SUM((if(r.dia_id =2,r.Valor,0))) as Martes, 
        SUM((if(r.dia_id =3,r.Valor,0))) as Miercoles, 
        SUM((if(r.dia_id =4,r.Valor,0))) as Jueves, 
        SUM((if(r.dia_id =5,r.Valor,0))) as Viernes, 
        SUM((if(r.dia_id =6,r.Valor,0))) as Sabado,
        SUM((if(r.dia_id =7,r.Valor,0))) as Domingo,
        SUM(r.Sueldo) as Total,
        SUM(r.Extra) as Extra,
        r.Sueldo as Sueldo
        ");

		$this->db->from("tbl_rol_semanal_nomina r");
		$this->db->join("tbl_usuarios_nomina u", "u.id = r.usuario_nomina_id");
		$this->db->join("tbl_roles_nomina n", "n.id = u.rol_nomina_id");
		$this->db->join("tbl_plazas p", "p.id = r.plaza_id");
		$this->db->where("r.Fecha>=", $fechaInicio);
		$this->db->where("r.Fecha<=", $fechaFin);
		$this->db->group_by("p.id");
		$resultados = $this->db->get();
		return $resultados->result();
	}


	public function getRolMatutino($plaza_id, $fechaInicio, $fechaFin, $rol_cafeteria_id)
	{
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("r.*,u.Nombre as Nombre,u.Nombre_Rol as Nombre_Rol");
		$this->db->from("tbl_rol_semanal_nomina r");
		$this->db->join("tbl_usuarios_nomina u", "u.id = r.usuario_nomina_id");
		$this->db->join("tbl_roles_nomina n", "n.id = u.rol_nomina_id");
		$this->db->where("r.turno_id", 1);
		$this->db->where("r.plaza_id", $plaza_id);
		$this->db->where("r.Fecha>=", $fechaInicio);
		$this->db->where("r.Fecha<=", $fechaFin);
		$this->db->where("r.rol_cafeteria_id", $rol_cafeteria_id);
		$resultados = $this->db->get();
		return $resultados->result();
	}


	public function getRangoLugarPlaza($plaza_id, $fechaInicio, $fechaFin, $rol_cafeteria_id)
	{
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("COUNT(r.id) as Total");
		$this->db->from("tbl_rol_semanal_nomina r");
		$this->db->where("r.plaza_id", $plaza_id);
		$this->db->where("r.Fecha>=", $fechaInicio);
		$this->db->where("r.Fecha<=", $fechaFin);
		$this->db->where("r.rol_cafeteria_id", $rol_cafeteria_id);
		$resultados = $this->db->get();
		return $resultados->row();
	}


	public function getTotalRolMatutino($plaza_id, $fechaInicio, $fechaFin, $rol_cafeteria_id, $dia_id)
	{
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("COUNT(r.id) as Total");
		$this->db->from("tbl_rol_semanal_nomina r");
		$this->db->where("r.turno_id", 1);
		$this->db->where("r.plaza_id", $plaza_id);
		$this->db->where("r.Fecha>=", $fechaInicio);
		$this->db->where("r.Fecha<=", $fechaFin);
		$this->db->where("r.rol_cafeteria_id", $rol_cafeteria_id);
		$this->db->where("r.dia_id", $dia_id);
		$resultados = $this->db->get();
		return $resultados->row();
	}

	public function getTotalRolVespertino($plaza_id, $fechaInicio, $fechaFin, $rol_cafeteria_id, $dia_id)
	{
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("COUNT(r.id) as Total");
		$this->db->from("tbl_rol_semanal_nomina r");
		$this->db->where("r.turno_id", 2);
		$this->db->where("r.plaza_id", $plaza_id);
		$this->db->where("r.Fecha>=", $fechaInicio);
		$this->db->where("r.Fecha<=", $fechaFin);
		$this->db->where("r.rol_cafeteria_id", $rol_cafeteria_id);
		$this->db->where("r.dia_id", $dia_id);
		$resultados = $this->db->get();
		return $resultados->row();
	}


	public function getTotalFilaLugar($plaza_id, $fechaInicio, $fechaFin, $rol_cafeteria_id)
	{
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("COUNT(r.id) as Total");
		$this->db->from("tbl_rol_semanal_nomina r");
		$this->db->where("r.plaza_id", $plaza_id);
		$this->db->where("r.Fecha>=", $fechaInicio);
		$this->db->where("r.Fecha<=", $fechaFin);
		$this->db->where("r.rol_cafeteria_id", $rol_cafeteria_id);
		$resultados = $this->db->get();
		return $resultados->row();
	}

	public function getTotalFilaPlaza($plaza_id, $fechaInicio, $fechaFin)
	{
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("COUNT(r.id) as Total");
		$this->db->from("tbl_rol_semanal_nomina r");
		$this->db->where("r.plaza_id", $plaza_id);
		$this->db->where("r.Fecha>=", $fechaInicio);
		$this->db->where("r.Fecha<=", $fechaFin);
		$resultados = $this->db->get();
		return $resultados->row();
	}

	public function getTotalFilaRolLugar($plaza_id, $fechaInicio, $fechaFin, $rol_cafeteria_id, $turno_id)
	{
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("COUNT(r.id) as Total");
		$this->db->from("tbl_rol_semanal_nomina r");
		$this->db->where("r.plaza_id", $plaza_id);
		$this->db->where("r.Fecha>=", $fechaInicio);
		$this->db->where("r.Fecha<=", $fechaFin);
		$this->db->where("r.rol_cafeteria_id", $rol_cafeteria_id);
		$this->db->where("r.turno_id", $turno_id);
		$resultados = $this->db->get();
		return $resultados->row();
	}

	public function getTotalColumnaSubTotalTurno($turno_id, $fechaInicio, $fechaFin, $rol_cafeteria_id, $dia_id)
	{
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("COUNT(r.id) as Total");
		$this->db->from("tbl_rol_semanal_nomina r");
		$this->db->where("r.Fecha>=", $fechaInicio);
		$this->db->where("r.Fecha<=", $fechaFin);
		$this->db->where("r.rol_cafeteria_id", $rol_cafeteria_id);
		$this->db->where("r.dia_id", $dia_id);
		$this->db->where("r.turno_id", $turno_id);
		$resultados = $this->db->get();
		return $resultados->row();
	}

	public function getTotalColumnaDia($fechaInicio, $fechaFin, $rol_cafeteria_id, $dia_id)
	{
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("COUNT(r.id) as Total");
		$this->db->from("tbl_rol_semanal_nomina r");
		$this->db->where("r.Fecha>=", $fechaInicio);
		$this->db->where("r.Fecha<=", $fechaFin);
		$this->db->where("r.rol_cafeteria_id", $rol_cafeteria_id);
		$this->db->where("r.dia_id", $dia_id);
		$resultados = $this->db->get();
		return $resultados->row();
	}

	public function getTotalColumnaLugar($fechaInicio, $fechaFin, $rol_cafeteria_id)
	{
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("COUNT(r.id) as Total");
		$this->db->from("tbl_rol_semanal_nomina r");
		$this->db->where("r.Fecha>=", $fechaInicio);
		$this->db->where("r.Fecha<=", $fechaFin);
		$this->db->where("r.rol_cafeteria_id", $rol_cafeteria_id);
		$resultados = $this->db->get();
		return $resultados->row();
	}

	public function getTotalColumnaDiaTurnoLugar($fechaInicio, $fechaFin, $rol_cafeteria_id, $dia_id, $turno_id)
	{
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("COUNT(r.id) as Total");
		$this->db->from("tbl_rol_semanal_nomina r");
		$this->db->where("r.Fecha>=", $fechaInicio);
		$this->db->where("r.Fecha<=", $fechaFin);
		$this->db->where("r.rol_cafeteria_id", $rol_cafeteria_id);
		$this->db->where("r.dia_id", $dia_id);
		$this->db->where("r.turno_id", $turno_id);
		$resultados = $this->db->get();
		return $resultados->row();
	}

	public function getTotalSemanaRol($fechaInicio, $fechaFin, $rol_cafeteria_id)
	{
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("COUNT(r.id) as Total");
		$this->db->from("tbl_rol_semanal_nomina r");
		$this->db->where("r.Fecha>=", $fechaInicio);
		$this->db->where("r.Fecha<=", $fechaFin);
		$this->db->where("r.rol_cafeteria_id", $rol_cafeteria_id);
		$resultados = $this->db->get();
		return $resultados->row();
	}

	public function getTotalRangoRol($fechaInicio, $fechaFin)
	{
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("COUNT(r.id) as Total");
		$this->db->from("tbl_rol_semanal_nomina r");
		$this->db->where("r.Fecha>=", $fechaInicio);
		$this->db->where("r.Fecha<=", $fechaFin);
		$resultados = $this->db->get();
		return $resultados->row();
	}

	public function getTotalSemanaTurnoLugar($fechaInicio, $fechaFin, $rol_cafeteria_id, $turno_id)
	{
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("COUNT(r.id) as Total");
		$this->db->from("tbl_rol_semanal_nomina r");
		$this->db->where("r.Fecha>=", $fechaInicio);
		$this->db->where("r.Fecha<=", $fechaFin);
		$this->db->where("r.rol_cafeteria_id", $rol_cafeteria_id);
		$this->db->where("r.turno_id", $turno_id);
		$resultados = $this->db->get();
		return $resultados->row();
	}

	public function getTotalRolLugarDia($plaza_id, $fechaInicio, $fechaFin, $rol_cafeteria_id, $dia_id, $turno_id)
	{
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("COUNT(r.id) as Total");
		$this->db->from("tbl_rol_semanal_nomina r");
		$this->db->where("r.turno_id", $turno_id);
		$this->db->where("r.plaza_id", $plaza_id);
		$this->db->where("r.Fecha>=", $fechaInicio);
		$this->db->where("r.Fecha<=", $fechaFin);
		$this->db->where("r.rol_cafeteria_id", $rol_cafeteria_id);
		$this->db->where("r.dia_id", $dia_id);
		$resultados = $this->db->get();
		return $resultados->row();
	}


	public function getTotalRol($plaza_id, $fechaInicio, $fechaFin, $rol_cafeteria_id)
	{
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("COUNT(r.id) as Total");
		$this->db->from("tbl_rol_semanal_nomina r");
		$this->db->where("r.plaza_id", $plaza_id);
		$this->db->where("r.Fecha>=", $fechaInicio);
		$this->db->where("r.Fecha<=", $fechaFin);
		$this->db->where("r.rol_cafeteria_id", $rol_cafeteria_id);
		$resultados = $this->db->get();
		return $resultados->row();
	}


	public function getTotalDia($plaza_id, $fechaInicio, $fechaFin, $dia_id)
	{
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("COUNT(r.id) as Total");
		$this->db->from("tbl_rol_semanal_nomina r");
		$this->db->where("r.plaza_id", $plaza_id);
		$this->db->where("r.Fecha>=", $fechaInicio);
		$this->db->where("r.Fecha<=", $fechaFin);
		//$this->db->where("r.rol_cafeteria_id",$rol_cafeteria_id);
		$this->db->where("r.dia_id", $dia_id);
		$resultados = $this->db->get();
		return $resultados->row();
	}

	public function getTotalDiaGenerico($plaza_id, $fechaInicio, $fechaFin, $dia_id, $rol_cafeteria_id)
	{
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("COUNT(r.id) as Total");
		$this->db->from("tbl_rol_semanal_nomina r");
		$this->db->where("r.plaza_id", $plaza_id);
		$this->db->where("r.Fecha>=", $fechaInicio);
		$this->db->where("r.Fecha<=", $fechaFin);
		$this->db->where("r.rol_cafeteria_id", $rol_cafeteria_id);
		$this->db->where("r.dia_id", $dia_id);
		$resultados = $this->db->get();
		return $resultados->row();
	}

	public function getNombreLugar($lugar_id)
	{
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("r.Nombre as Nombre");
		$this->db->from("tbl_roles_cafeteria_nomina r");
		$this->db->where("r.id", $lugar_id);
		$resultados = $this->db->get();
		return $resultados->row();
	}

	public function getNombreTurno($turno_id)
	{
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("r.Nombre as Nombre");
		$this->db->from("tbl_turnos_nomina r");
		$this->db->where("r.id", $turno_id);
		$resultados = $this->db->get();
		return $resultados->row();
	}


	public function getRolMatutinoPlazas($plaza_id, $fechaInicio, $fechaFin, $rol_cafeteria_id)
	{
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("r.*,u.Nombre as Nombre");
		$this->db->from("tbl_rol_semanal_nomina r");
		$this->db->join("tbl_usuarios_nomina u", "u.id = r.usuario_nomina_id");
		$this->db->join("tbl_roles_nomina n", "n.id = u.rol_nomina_id");
		$this->db->where("r.turno_id", 1);
		$this->db->where("r.Fecha>=", $fechaInicio);
		$this->db->where("r.Fecha<=", $fechaFin);
		$this->db->where("r.rol_cafeteria_id", $rol_cafeteria_id);
		$resultados = $this->db->get();
		return $resultados->result();
	}

	public function getRolVespertinoPlazas($plaza_id, $fechaInicio, $fechaFin, $rol_cafeteria_id)
	{
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("r.*,u.Nombre as Nombre");
		$this->db->from("tbl_rol_semanal_nomina r");
		$this->db->join("tbl_usuarios_nomina u", "u.id = r.usuario_nomina_id");
		$this->db->join("tbl_roles_nomina n", "n.id = u.rol_nomina_id");
		$this->db->where("r.turno_id", 2);
		$this->db->where("r.Fecha>=", $fechaInicio);
		$this->db->where("r.Fecha<=", $fechaFin);
		$this->db->where("r.rol_cafeteria_id", $rol_cafeteria_id);
		$resultados = $this->db->get();
		return $resultados->result();
	}

	public function getRolVespertino($plaza_id, $fechaInicio, $fechaFin, $rol_cafeteria_id)
	{
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("r.*,u.Nombre as Nombre,u.Nombre_Rol as Nombre_Rol");
		$this->db->from("tbl_rol_semanal_nomina r");
		$this->db->join("tbl_usuarios_nomina u", "u.id = r.usuario_nomina_id");
		$this->db->join("tbl_roles_nomina n", "n.id = u.rol_nomina_id");
		$this->db->where("r.turno_id", 2);
		$this->db->where("r.plaza_id", $plaza_id);
		$this->db->where("r.Fecha>=", $fechaInicio);
		$this->db->where("r.Fecha<=", $fechaFin);
		$this->db->where("r.rol_cafeteria_id", $rol_cafeteria_id);
		$resultados = $this->db->get();
		return $resultados->result();
	}


	//$plaza_id,$lunes,$domingo
	public function getRolMatutinoAdmin($plaza_id, $fechaInicio, $fechaFin)
	{
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("r.*,u.Nombre as Nombre");
		$this->db->from("tbl_rol_semanal_nomina r");
		$this->db->join("tbl_usuarios_nomina u", "u.id = r.usuario_nomina_id");
		$this->db->join("tbl_roles_nomina n", "n.id = u.rol_nomina_id");
		$this->db->where("r.turno_id", 1);
		$this->db->where("r.plaza_id", $plaza_id);
		$this->db->where("r.Fecha>=", $fechaInicio);
		$this->db->where("r.Fecha<=", $fechaFin);
		$resultados = $this->db->get();
		return $resultados->result();
	}

	public function getRolVespertinoAdmin($plaza_id, $fechaInicio, $fechaFin)
	{
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("r.*,u.Nombre as Nombre");
		$this->db->from("tbl_rol_semanal_nomina r");
		$this->db->join("tbl_usuarios_nomina u", "u.id = r.usuario_nomina_id");
		$this->db->join("tbl_roles_nomina n", "n.id = u.rol_nomina_id");
		$this->db->where("r.turno_id", 2);
		$this->db->where("r.plaza_id", $plaza_id);
		$this->db->where("r.Fecha>=", $fechaInicio);
		$this->db->where("r.Fecha<=", $fechaFin);
		$resultados = $this->db->get();
		return $resultados->result();
	}


	public function checarTurnos($fecha, $usuario_id, $turno_id)
	{
		$this->db->select("COUNT(r.Valor) as Total");
		$this->db->from("tbl_rol_semanal_nomina r");
		$this->db->where("usuario_nomina_id", $usuario_id);
		$this->db->where("Fecha", $fecha);
		$this->db->where("turno_id", $turno_id);
		$query = $this->db->get();
		return $query->row();
	}

	public function borrarUsuarioRol($usuario_id, $fechaInicio, $fechaFin)
	{
		$this->db->where("usuario_nomina_id", $usuario_id);
		$this->db->where("Fecha>=", $fechaInicio);
		$this->db->where("Fecha<=", $fechaFin);
		return $this->db->delete("tbl_rol_semanal_nomina");
	}

	public function getTurno($usuario_id, $dia_id, $fechaInicio, $fechaFin)
	{
		$this->db->select("r.turno_id_editar as Turno");
		$this->db->from("tbl_rol_semanal_nomina r");
		$this->db->where("usuario_nomina_id", $usuario_id);
		$this->db->where("Fecha>=", $fechaInicio);
		$this->db->where("Fecha<=", $fechaFin);
		$this->db->where("dia_id", $dia_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->row();
		} else {
			return false;
		}
	}


	public function checarDisponibilidadRol($lunes, $domingo, $usuario_id)
	{
		$this->db->select("r.*");
		$this->db->from("tbl_rol_semanal_nomina r");
		$this->db->where("usuario_nomina_id", $usuario_id);
		$this->db->where("Fecha>=", $lunes);
		$this->db->where("Fecha<=", $domingo);
		$this->db->where("Estado!=", 2);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->row();
		} else {
			return false;
		}
	}


	public function saveRolNominasU($data, $fecha, $usuario_id, $turno_id)
	{
		$this->db->trans_begin();
		$this->db->insert("tbl_rol_semanal_nomina", $data);
		if ($this->db->trans_status() === FALSE) {
			//Hubo errores en la consulta, entonces se cancela la transacción.
			$this->db->trans_rollback();
			return false;
		} else {
			//Todas las consultas se hicieron correctamente.
			$this->db->trans_commit();
			return true;
		}
	}


	public function getTurnosID($id)
	{
		$query = $this->db->get('tbl_turnos_nomina');
		$output = '';
		foreach ($query->result() as $row) {
			if ($row->id == $id) {
				$output .= '<option value="' . $row->id . '" selected>' . $row->Nombre . '</option>';
			} else {
				$output .= '<option value="' . $row->id . '">' . $row->Nombre . '</option>';
			}
		}
		if ($id == 0) {
			$output .= '<option value="0" selected>NO ASIGNADO</option>';
		} else {
			$output .= '<option value="0">NO ASIGNADO</option>';
		}
		return $output;
	}

	public function getRolSemanalUsuario($usuario_id, $fechaInicio, $fechaFin)
	{
		$this->db->select("r.*");
		$this->db->from("tbl_rol_semanal_nomina r");
		$this->db->where("usuario_nomina_id", $usuario_id);
		$this->db->where("Fecha>=", $fechaInicio);
		$this->db->where("Fecha<=", $fechaFin);
		$this->db->order_by('r.dia_id', 'ASC');
		$resultados = $this->db->get();
		return $resultados->result();
	}


	public function existenciaTurno($usuario_id, $dia_id, $fechaInicio, $fechaFin)
	{
		$this->db->select("r.*");
		$this->db->from("tbl_rol_semanal_nomina r");
		$this->db->where("r.usuario_nomina_id", $usuario_id);
		$this->db->where("r.Fecha>=", $fechaInicio);
		$this->db->where("r.Fecha<=", $fechaFin);
		$this->db->where("r.dia_id", $dia_id);
		$resultados = $this->db->get();
		return $resultados->result();
	}

	public function existenciaTurno2($usuario_id, $turno_id, $fechaInicio, $fechaFin)
	{
		$this->db->select("r.*");
		$this->db->from("tbl_rol_semanal_nomina r");
		$this->db->where("r.usuario_nomina_id", $usuario_id);
		$this->db->where("r.Fecha>=", $fechaInicio);
		$this->db->where("r.Fecha<=", $fechaFin);
		$this->db->where("r.turno_id", $turno_id);
		$resultados = $this->db->get();
		return $resultados->result();
	}

	public function eliminarTurnos($usuario_id, $fechaInicio, $fechaFin)
	{
		$this->db->where("usuario_nomina_id", $usuario_id);
		$this->db->where("Fecha>=", $fechaInicio);
		$this->db->where("Fecha<=", $fechaFin);
		return $this->db->delete("tbl_rol_semanal_nomina");
	}

	public function eliminarTurnoEspecifico($usuario_id, $turno_id, $fechaInicio, $fechaFin)
	{
		$this->db->where("usuario_nomina_id", $usuario_id);
		$this->db->where("Fecha>=", $fechaInicio);
		$this->db->where("Fecha<=", $fechaFin);
		$this->db->where("turno_id", $turno_id);
		return $this->db->delete("tbl_rol_semanal_nomina");
	}


	public function actualizarTurnoEspecifico($usuario_id, $turno_id, $fechaInicio, $fechaFin, $data)
	{
		$this->db->trans_begin();
		$this->db->where("usuario_nomina_id", $usuario_id);
		$this->db->where("Fecha>=", $fechaInicio);
		$this->db->where("Fecha<=", $fechaFin);
		$this->db->where("turno_id", $turno_id);
		$this->db->update('tbl_rol_semanal_nomina', $data);
		if ($this->db->trans_status() === FALSE) {
			//Hubo errores en la consulta, entonces se cancela la transacción.
			$this->db->trans_rollback();
			return false;
		} else {
			//Todas las consultas se hicieron correctamente.
			$this->db->trans_commit();
			return true;
		}
	}

	public function getUsuariosRol($plaza_id)
	{
		$this->db->select("u.*,r.Nombre as Rol,p.Nombre as Plaza");
		$this->db->from("tbl_usuarios_nomina u");
		$this->db->join("tbl_roles_nomina r ", "u.rol_nomina_id=r.id");
		$this->db->join("tbl_plazas p ", "u.plaza_id=p.id");
		$this->db->where('u.plaza_id', $plaza_id);
		$this->db->where('u.Activo', 0);
		$resultados = $this->db->get();
		return $resultados->result();
	}

	public function asignarSueldoColaborador($usuario_id, $fechaInicio, $fechaFin, $data)
	{
		$this->db->trans_begin();
		$this->db->where("Fecha>=", $fechaInicio);
		$this->db->where("Fecha<=", $fechaFin);
		$this->db->where("usuario_nomina_id", $usuario_id);
		$this->db->update('tbl_rol_semanal_nomina', $data);
		if ($this->db->trans_status() === FALSE) {
			//Hubo errores en la consulta, entonces se cancela la transacción.
			$this->db->trans_rollback();
			return false;
		} else {
			//Todas las consultas se hicieron correctamente.
			$this->db->trans_commit();
			return true;
		}
	}

	public function actualizarRolSemanal($plaza_id, $fechaInicio, $fechaFin, $data)
	{
		$bandera = false;
		$this->db->trans_begin();
		$this->db->where("Fecha>=", $fechaInicio);
		$this->db->where("Fecha<=", $fechaFin);
		$this->db->where("plaza_id", $plaza_id);
		$this->db->update('tbl_rol_semanal_nomina', $data);
		if ($this->db->affected_rows()) {
			$bandera = true;
		} else {
			$bandera = false;
		}
		if ($this->db->trans_status() === FALSE) {
			//Hubo errores en la consulta, entonces se cancela la transacción.
			$this->db->trans_rollback();
			return false;
		} else {
			//Todas las consultas se hicieron correctamente.
			$this->db->trans_commit();
			return $bandera;
		}
	}

	public function disponibilidadNomina($plaza_id, $fechaInicio, $fechaFin)
	{
		$this->db->from("tbl_rol_semanal_nomina r");
		$this->db->where("r.plaza_id", $plaza_id);
		$this->db->where("r.Fecha>=", $fechaInicio);
		$this->db->where("r.Fecha<=", $fechaFin);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function disponibilidadNominaManager($plaza_id, $fechaInicio, $fechaFin)
	{
		$this->db->from("tbl_rol_semanal_nomina r");
		$this->db->where("r.plaza_id", $plaza_id);
		$this->db->where("r.Fecha>=", $fechaInicio);
		$this->db->where("r.Fecha<=", $fechaFin);
		$this->db->where("r.Estado", 0);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return false;
		} else {
			return true;
		}
	}

	public function actualizarUsuarioN($usuario_id, $data)
	{
		$this->db->trans_begin();
		$this->db->where("id", $usuario_id);
		$this->db->update('tbl_usuarios_nomina', $data);
		if ($this->db->trans_status() === FALSE) {
			//Hubo errores en la consulta, entonces se cancela la transacción.
			$this->db->trans_rollback();
			return false;
		} else {
			//Todas las consultas se hicieron correctamente.
			$this->db->trans_commit();
			return true;
		}
	}


	public function agregarNotaUsuarioN($data)
	{
		$this->db->trans_begin();
		$this->db->insert("tbl_historial_usuarios_nomina", $data);
		if ($this->db->trans_status() === FALSE) {
			//Hubo errores en la consulta, entonces se cancela la transacción.
			$this->db->trans_rollback();
			return false;
		} else {
			//Todas las consultas se hicieron correctamente.
			$this->db->trans_commit();
			return true;
		}
	}

	public function eliminarUsuarioN($usuario_id, $data)
	{
		$this->db->trans_begin();
		$this->db->where("id", $usuario_id);
		$this->db->update('tbl_usuarios_nomina', $data);
		if ($this->db->trans_status() === FALSE) {
			//Hubo errores en la consulta, entonces se cancela la transacción.
			$this->db->trans_rollback();
			return false;
		} else {
			//Todas las consultas se hicieron correctamente.
			$this->db->trans_commit();
			return true;
		}
	}

	public function getUsuariosPlaza($plaza_id)
	{
		$this->db->where('plaza_id', $plaza_id);
		$this->db->where('Activo', 1);
		$this->db->order_by('Nombre', 'ASC');
		$query = $this->db->get('tbl_usuarios_nomina');
		$output = '<option value="">Seleccionar Usuario</option>';
		foreach ($query->result() as $row) {
			$output .= '<option value="' . $row->id . '">' . $row->Nombre . " " . $row->Apellido_Paterno . '</option>';
		}
		return $output;
	}

	public function gethistorialUsuarioAPI($fechaInicio, $fechaFin, $usuario_id)
	{
		$this->db->select("e.*,u.Nombre as Usuario,n.Nombre as Concepto");
		$this->db->from("tbl_extras_nomina e");
		$this->db->join("tbl_usuarios_nomina u", "u.id = e.usuario_nomina_id");
		$this->db->join("tbl_conceptos_nomina n", "n.id = e.concepto_id");
		$this->db->where('e.Fecha>=', $fechaInicio);
		$this->db->where('e.Fecha<=', $fechaFin);
		$this->db->where('e.usuario_nomina_id', $usuario_id);
		$resultados = $this->db->get();
		return $resultados->result();
	}

	public function gethistorialUsuarioAPIManager($usuario_id)
	{
		$this->db->select("e.*,u.Nombre as Usuario,u.Apellido_Paterno as Paterno,n.Nombre as Concepto");
		$this->db->from("tbl_extras_nomina e");
		$this->db->join("tbl_usuarios_nomina u", "u.id = e.usuario_nomina_id");
		$this->db->join("tbl_conceptos_nomina n", "n.id = e.concepto_id");
		$this->db->where('e.usuario_nomina_id', $usuario_id);
		$this->db->order_by('e.id');
		$resultados = $this->db->get();
		return $resultados->result();
	}

	public function gethistorialUsuarioAPI2($fechaInicio, $fechaFin, $usuario_id)
	{
		$this->db->select("r.*,u.Nombre as Usuario,n.Nombre as Concepto");
		$this->db->from("tbl_rol_semanal_nomina r");
		$this->db->join("tbl_usuarios_nomina u", "u.id = r.usuario_nomina_id");
		$this->db->join("tbl_conceptos_nomina n", "n.id = r.concepto_id");
		$this->db->where('r.usuario_nomina_id', $usuario_id);
		$this->db->where('r.concepto_id !=', 1);
		$resultados = $this->db->get();
		return $resultados->result();
	}

	public function getDatos($fechaInicio, $fechaFin, $usuario_id)
	{
		$this->db->select("r.*,u.Nombre as Usuario,n.Nombre as Concepto");
		$this->db->from("tbl_rol_semanal_nomina r");
		$this->db->join("tbl_usuarios_nomina u", "u.id = r.usuario_nomina_id");
		$this->db->join("tbl_conceptos_nomina n", "n.id = r.concepto_id");
		$this->db->where('r.usuario_nomina_id', $usuario_id);
		$this->db->where('r.concepto_id !=', 1);
		$resultados = $this->db->get();
		return $resultados->result();
	}


	public function eliminarEventoUsuarioN($id)
	{
		$this->db->where("id", $id);
		$this->db->delete("tbl_historial_usuarios_nomina");
		if ($this->db->affected_rows()) {
			return true;
		} else {
			return false;
		}
	}

	public function consultarSueldoUsuario($usuario_id)
	{
		$this->db->select("r.Sueldo as Sueldo");
		$this->db->from("tbl_usuarios_nomina r");
		$this->db->where("id", $usuario_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->row();
		} else {
			return false;
		}
	}

	public function consultarDisponibilidadDia($fecha, $usuario_id, $turno_id)
	{
		$this->db->select("r.Sueldo as Sueldo");
		$this->db->from("tbl_rol_semanal_nomina r");
		$this->db->where("r.usuario_nomina_id", $usuario_id);
		$this->db->where("r.Fecha", $fecha);
		$this->db->where("r.turno_id", $turno_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->row();
		} else {
			return false;
		}
	}

	public function consultarDisponibilidadExtrasNomina($fechaInicio, $fechaFin, $usuario_id)
	{
		$this->db->from("tbl_rol_semanal_nomina r");
		$this->db->where("r.usuario_nomina_id", $usuario_id);
		$this->db->where("r.Fecha>=", $fechaInicio);
		$this->db->where("r.Fecha<=", $fechaFin);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function agregarNotaUsuarioM($usuario_id, $fechaInicio, $fechaFin, $dataU, $dataI)
	{
		$this->db->trans_begin();

		$this->db->where("usuario_nomina_id", $usuario_id);
		$this->db->where("Fecha>=", $fechaInicio);
		$this->db->where("Fecha<=", $fechaFin);
		$this->db->limit(1);
		$this->db->update('tbl_rol_semanal_nomina', $dataU);

		$this->db->insert("tbl_extras_nomina", $dataI);
		if ($this->db->trans_status() === FALSE) {
			//Hubo errores en la consulta, entonces se cancela la transacción.
			$this->db->trans_rollback();
			return false;
		} else {
			//Todas las consultas se hicieron correctamente.
			$this->db->trans_commit();
			return true;
		}
	}

	public function consultarAcumuladoExtra($fechaInicio, $fechaFin, $usuario_id)
	{
		$this->db->select("SUM(r.Extra) as Extra");
		$this->db->from("tbl_rol_semanal_nomina r");
		$this->db->where("r.usuario_nomina_id", $usuario_id);
		$this->db->where("r.Fecha>=", $fechaInicio);
		$this->db->where("r.Fecha<=", $fechaFin);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->row();
		} else {
			return false;
		}
	}


	public function getImporteExtras($id)
	{
		$this->db->select("e.Importe as Importe");
		$this->db->from("tbl_extras_nomina e");
		$this->db->where("e.id", $id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->row();
		} else {
			return false;
		}
	}


	public function eliminarNotaUsuarioM($usuario_id, $fechaInicio, $fechaFin, $dataU, $code)
	{
		$this->db->trans_begin();

		$this->db->where("usuario_nomina_id", $usuario_id);
		$this->db->where("Fecha>=", $fechaInicio);
		$this->db->where("Fecha<=", $fechaFin);
		$this->db->limit(1);
		$this->db->update('tbl_rol_semanal_nomina', $dataU);


		$this->db->where('id', $code);
		$this->db->delete('tbl_extras_nomina');

		if ($this->db->trans_status() === FALSE) {
			//Hubo errores en la consulta, entonces se cancela la transacción.
			$this->db->trans_rollback();
			return false;
		} else {
			//Todas las consultas se hicieron correctamente.
			$this->db->trans_commit();
			return true;
		}
	}

	public function actualizarEvento($concepto_id, $usuario_id, $data)
	{
		$this->db->trans_begin();
		$this->db->where("concepto_id", $concepto_id);
		$this->db->where("usuario_nomina_id", $usuario_id);
		$this->db->update('tbl_extras_nomina', $data);
		if ($this->db->trans_status() === FALSE) {
			//Hubo errores en la consulta, entonces se cancela la transacción.
			$this->db->trans_rollback();
			return false;
		} else {
			//Todas las consultas se hicieron correctamente.
			$this->db->trans_commit();
			return true;
		}
	}

	public function getTotalTurnosPlaza($plaza_id, $fechaInicio, $fechaFin)
	{
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("SUM(r.Valor) as sumaTurnos");
		$this->db->from("tbl_rol_semanal_nomina r");
		$this->db->where("r.plaza_id", $plaza_id);
		$this->db->where("r.Fecha>=", $fechaInicio);
		$this->db->where("r.Fecha<=", $fechaFin);
		$resultados = $this->db->get();
		return $resultados->row();
	}

	public function getTotalTurnos($fechaInicio, $fechaFin)
	{
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("SUM(r.Valor) as sumaTurnos");
		$this->db->from("tbl_rol_semanal_nomina r");
		$this->db->where("r.Fecha>=", $fechaInicio);
		$this->db->where("r.Fecha<=", $fechaFin);
		$resultados = $this->db->get();
		return $resultados->row();
	}

	public function getTotalUnidadesPlaza($plaza_id, $fechaInicio, $fechaFin)
	{
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("SUM(pv.Cantidad) as sumaUnidades");
		$this->db->from("tbl_platillos_vendidos_resumen pv");
		$this->db->where("pv.plaza_id", $plaza_id);
		$this->db->where("pv.Fecha>=", $fechaInicio);
		$this->db->where("pv.Fecha<=", $fechaFin);
		$resultados = $this->db->get();
		return $resultados->row();
	}


	public function getTotalUnidades($fechaInicio, $fechaFin)
	{
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("SUM(pv.Cantidad) as sumaUnidades");
		$this->db->from("tbl_platillos_vendidos_resumen pv");
		$this->db->where("pv.Fecha>=", $fechaInicio);
		$this->db->where("pv.Fecha<=", $fechaFin);
		$resultados = $this->db->get();
		return $resultados->row();
	}

	public function getTotalIngresosPlaza($plaza_id, $fechaInicio, $fechaFin)
	{
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("SUM(r.Total_Ingresos) as sumaIngresos");
		$this->db->from("tbl_reporte_ventas r");
		$this->db->where("r.plaza_id", $plaza_id);
		$this->db->where("r.Fecha>=", $fechaInicio);
		$this->db->where("r.Fecha<=", $fechaFin);
		$resultados = $this->db->get();
		return $resultados->row();
	}

	public function getTotalIngresos($fechaInicio, $fechaFin)
	{
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("SUM(r.Total_Ingresos) as sumaIngresos");
		$this->db->from("tbl_reporte_ventas r");
		$this->db->where("r.Fecha>=", $fechaInicio);
		$this->db->where("r.Fecha<=", $fechaFin);
		$resultados = $this->db->get();
		return $resultados->row();
	}

	// NUEVA FUNCIÓN MAESTRA PARA ROLES
	public function getMatrizRoles($fechaInicio, $fechaFin, $plaza_id = null, $lugar_id = null, $turno_id = null) {
		$this->db->select("r.*, u.Nombre_Rol, p.Nombre as Plaza, lc.Nombre as Lugar, t.Nombre as Turno");
		$this->db->from("tbl_rol_semanal_nomina r");
		$this->db->join("tbl_usuarios_nomina u", "u.id = r.usuario_nomina_id");
		$this->db->join("tbl_plazas p", "p.id = r.plaza_id");
		$this->db->join("tbl_roles_cafeteria_nomina lc", "lc.id = r.rol_cafeteria_id");
		$this->db->join("tbl_turnos_nomina t", "t.id = r.turno_id", "left");
		$this->db->where("r.Fecha >=", $fechaInicio);
		$this->db->where("r.Fecha <=", $fechaFin);

		if (!empty($plaza_id)) $this->db->where("r.plaza_id", $plaza_id);
		if (!empty($lugar_id)) $this->db->where("r.rol_cafeteria_id", $lugar_id);
		if (!empty($turno_id)) $this->db->where("r.turno_id", $turno_id);

		return $this->db->get()->result();
	}

	// =========================================================================
	// CONSULTAS AGRUPADAS PARA ANÁLISIS DE NÓMINAS
	// =========================================================================

	public function getResumenTurnos($fechaInicio, $fechaFin, $plaza_id = null){
		$this->db->select("plaza_id, SUM(Valor) as sumaTurnos");
		$this->db->from("tbl_rol_semanal_nomina");
		$this->db->where("Fecha >=", $fechaInicio);
		$this->db->where("Fecha <=", $fechaFin);
		if (!empty($plaza_id)) $this->db->where("plaza_id", $plaza_id);
		$this->db->group_by("plaza_id");
		$query = $this->db->get();

		$result = [];
		foreach ($query->result() as $row) { $result[$row->plaza_id] = $row->sumaTurnos; }
		return $result;
	}

	public function getResumenUnidades($fechaInicio, $fechaFin, $plaza_id = null){
		$this->db->select("plaza_id, SUM(Cantidad) as sumaUnidades");
		$this->db->from("tbl_platillos_vendidos_resumen");
		$this->db->where("Fecha >=", $fechaInicio);
		$this->db->where("Fecha <=", $fechaFin);
		if (!empty($plaza_id)) $this->db->where("plaza_id", $plaza_id);
		$this->db->group_by("plaza_id");
		$query = $this->db->get();

		$result = [];
		foreach ($query->result() as $row) { $result[$row->plaza_id] = $row->sumaUnidades; }
		return $result;
	}

	public function getResumenIngresos($fechaInicio, $fechaFin, $plaza_id = null){
		$this->db->select("plaza_id, SUM(Total_Ingresos) as sumaIngresos");
		$this->db->from("tbl_reporte_ventas");
		$this->db->where("Fecha >=", $fechaInicio);
		$this->db->where("Fecha <=", $fechaFin);
		if (!empty($plaza_id)) $this->db->where("plaza_id", $plaza_id);
		$this->db->group_by("plaza_id");
		$query = $this->db->get();

		$result = [];
		foreach ($query->result() as $row) { $result[$row->plaza_id] = $row->sumaIngresos; }
		return $result;
	}
}
