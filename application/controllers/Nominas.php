<?php
header("Content-Type: text/html; charset=utf-8");
defined('BASEPATH') or exit('No direct script access allowed');

class Nominas extends CI_Controller
{

	private $permisos;

	public function __construct()
	{
		parent::__construct();
		$this->permisos = $this->backend_lib->control();
		$this->load->model('Mdl_nominas');
		$this->load->model('Mdl_plazas');
		$this->load->model('Mdl_remesas');

		$this->load->library('encryption');
		if (!$this->session->userdata("login")) {
			redirect(base_url());
		}
	}

	public function index()
	{
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("administrador/nominas/panel_nominas");
		$this->load->view("layouts/footer");
	}

	public function tabla()
	{
		$plaza_id = $this->input->post("plaza_id") ?: 0;
		$usuario_id = $this->input->post("usuario_id");

		$fechas = $this->_procesarRangoFechas(
			$this->input->post("fechaInicioD"),
			$this->input->post("fechaFinD"),
			$this->input->post("buscar")
		);

		$estadoObj = $this->Mdl_nominas->getEstado($plaza_id, $fechas['fechaInicio'], $fechas['fechaFin']);

		$data = [
			'fechainicio' => $fechas['fechaInicio'],
			'fechafin'    => $fechas['fechaFin'],
			'usuarios'    => $this->Mdl_nominas->getUsuarios($plaza_id),
			'plazas'      => $this->Mdl_plazas->getPlazas(),
			'dias'        => $this->Mdl_nominas->getDiasNominaCompleto(),
			'conceptos'   => $this->Mdl_nominas->getConceptos(),
			'id_plaza'    => $plaza_id,
			'id_usuario'  => $usuario_id,
			'semanas'     => $this->Mdl_nominas->getRolSemanal($plaza_id, $fechas['fechaInicio'], $fechas['fechaFin']),
			'diasE'       => $fechas['diasE'],
			'estado'      => $estadoObj ? $estadoObj->Estado : 0
		];

		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("administrador/nominas/tabla", $data);
		$this->load->view("layouts/footer");
	}

	public function roles()
	{
		$plaza_id = $this->input->post("plaza_id");
		$id_lugar = $this->input->post("lugar_id_busqueda");
		$id_turno = $this->input->post("turno_id_busqueda");

		$fechas = $this->_procesarRangoFechas(
			$this->input->post("fechaInicioD"),
			$this->input->post("fechaFinD"),
			$this->input->post("buscar"),
			$this->input->post("buscarRango")
		);

		$raw_data = $this->Mdl_nominas->getMatrizRoles($fechas['fechaInicio'], $fechas['fechaFin'], $plaza_id, $id_lugar, $id_turno);

		$matriz = [];
		$totalesFila = [];

		foreach ($raw_data as $row) {
			$p_id = $row->plaza_id;
			$l_id = $row->rol_cafeteria_id;
			$t_id = $row->turno_id;
			$d_id = $row->dia_id;

			if (!isset($matriz[$p_id])) $matriz[$p_id] = [];
			if (!isset($matriz[$p_id][$l_id])) $matriz[$p_id][$l_id] = [];
			if (!isset($matriz[$p_id][$l_id][$t_id])) $matriz[$p_id][$l_id][$t_id] = [];
			if (!isset($matriz[$p_id][$l_id][$t_id][$d_id])) $matriz[$p_id][$l_id][$t_id][$d_id] = [];

			$matriz[$p_id][$l_id][$t_id][$d_id][] = $row->Nombre_Rol;

			if (!isset($totalesFila[$p_id][$l_id])) $totalesFila[$p_id][$l_id] = 0;
			$totalesFila[$p_id][$l_id]++;
		}

		$data = [
			'fechaInicio' => $fechas['fechaInicio'],
			'fechaFin'    => $fechas['fechaFin'],
			'plazas'      => $this->Mdl_plazas->getPlazas(),
			'lugares'     => $this->Mdl_nominas->getLugares(),
			'turnos'      => $this->Mdl_nominas->getTurnosNomina(),
			'usuarios'    => $this->Mdl_nominas->getUsuarios($plaza_id),
			'id'          => $plaza_id,
			'id_lugar'    => $id_lugar,
			'id_turno'    => $id_turno,
			'diasE'       => $fechas['diasE'],
			'matriz'      => $matriz,
			'totalesFila' => $totalesFila
		];

		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("administrador/nominas/roles", $data);
		$this->load->view("layouts/footer");
	}

	public function correccionRoles()
	{
		$plaza_id = $this->input->post("plaza_id") ?: 0;

		$fechas = $this->_procesarRangoFechas(
			$this->input->post("fechaInicioD"),
			$this->input->post("fechaFinD"),
			$this->input->post("buscar")
		);

		$nombrePlazaObj = $plaza_id > 0 ? $this->Mdl_plazas->getPlazaID($plaza_id) : null;
		$nombrePlaza = $nombrePlazaObj ? $nombrePlazaObj->nombrePlaza : "";

		$estadoObj = $this->Mdl_nominas->getEstado($plaza_id, $fechas['fechaInicio'], $fechas['fechaFin']);

		$matrizAsignaciones = [];
		if ($plaza_id > 0) {
			$raw_data = $this->Mdl_nominas->getMatrizRoles($fechas['fechaInicio'], $fechas['fechaFin'], $plaza_id);
			foreach ($raw_data as $row) {
				if (!isset($matrizAsignaciones[$row->rol_cafeteria_id][$row->turno_id][$row->dia_id])) {
					$matrizAsignaciones[$row->rol_cafeteria_id][$row->turno_id][$row->dia_id] = [];
				}
				$matrizAsignaciones[$row->rol_cafeteria_id][$row->turno_id][$row->dia_id][] = $row->Nombre_Rol;
			}
		}

		$data = [
			'fechaInicio'        => $fechas['fechaInicio'],
			'fechaFin'           => $fechas['fechaFin'],
			'plazas'             => $this->Mdl_plazas->getPlazas(),
			'id_plaza'           => $plaza_id,
			'nombrePlaza'        => $nombrePlaza,
			'usuarios'           => $this->Mdl_nominas->getUsuarios($plaza_id),
			'turnos'             => $this->Mdl_nominas->getTurnosNomina(),
			'dias'               => $this->Mdl_nominas->getDiasNominaCompleto(),
			'lugares'            => $this->Mdl_nominas->getLugares(),
			'semanas'            => $this->Mdl_nominas->getRolSemanal($plaza_id, $fechas['fechaInicio'], $fechas['fechaFin']),
			'estado'             => $estadoObj ? $estadoObj->Estado : 0,
			'diasE'              => $fechas['diasE'],
			'matrizAsignaciones' => $matrizAsignaciones,
			'roles'              => $this->Mdl_nominas->getRoles()
		];

		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("administrador/nominas/correccion_roles", $data);
		$this->load->view("layouts/footer");
	}

	public function rolManager()
	{
		$plaza_id = $this->session->userdata("plaza");

		$fechas = $this->_procesarRangoFechas(
			$this->input->post("fechaInicioD"),
			$this->input->post("fechaFinD"),
			$this->input->post("buscar")
		);

		$nombrePlazaObj = $this->Mdl_plazas->getPlazaID($plaza_id);
		$nombrePlaza = $nombrePlazaObj ? $nombrePlazaObj->nombrePlaza : "";

		$estadoObj = $this->Mdl_nominas->getEstado($plaza_id, $fechas['fechaInicio'], $fechas['fechaFin']);

		$matrizAsignaciones = [];
		$raw_data = $this->Mdl_nominas->getMatrizRoles($fechas['fechaInicio'], $fechas['fechaFin'], $plaza_id);
		foreach ($raw_data as $row) {
			if (!isset($matrizAsignaciones[$row->rol_cafeteria_id][$row->turno_id][$row->dia_id])) {
				$matrizAsignaciones[$row->rol_cafeteria_id][$row->turno_id][$row->dia_id] = [];
			}
			$matrizAsignaciones[$row->rol_cafeteria_id][$row->turno_id][$row->dia_id][] = $row->Nombre_Rol;
		}

		$data = [
			'fechaInicio'        => $fechas['fechaInicio'],
			'fechaFin'           => $fechas['fechaFin'],
			'id_plaza'           => $plaza_id,
			'nombrePlaza'        => $nombrePlaza,
			'usuarios'           => $this->Mdl_nominas->getUsuarios($plaza_id),
			'turnos'             => $this->Mdl_nominas->getTurnosNomina(),
			'dias'               => $this->Mdl_nominas->getDiasNominaCompleto(),
			'lugares'            => $this->Mdl_nominas->getLugares(),
			'semanas'            => $this->Mdl_nominas->getRolSemanal($plaza_id, $fechas['fechaInicio'], $fechas['fechaFin']),
			'estado'             => $estadoObj ? $estadoObj->Estado : 0,
			'diasE'              => $fechas['diasE'],
			'matrizAsignaciones' => $matrizAsignaciones,
			'roles'              => $this->Mdl_nominas->getRoles()
		];

		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("manager/nominas/list", $data);
		$this->load->view("layouts/footer");
	}

	public function consultarEstado()
	{
		if ($this->input->is_ajax_request()) {
			$plaza_id = $this->input->post("plaza_id");
			$fechaInicio = $this->input->post("fechaInicio");
			$fechaFin = $this->input->post("fechaFin");
			$estado = 0;
			$estado = $this->Mdl_nominas->getEstado($plaza_id, $fechaInicio, $fechaFin);

			if ($estado != null) {
				$estado = $estado->Estado;
				echo $estado;
			} else {
				$estado = 0;
				echo $estado;
			}

		} else {
			redirect(base_url() . "Inicio");
		}
	}

	public function analisisNominas()
	{
		$plaza_id = $this->input->post("plaza_id");
		$fechaInicio = $this->input->post("fechaInicioD");
		$fechaFin = $this->input->post("fechaFinD");
		$buscar = $this->input->post("buscar");
		$buscarRango = $this->input->post("buscarRango");

		// Lógica de fechas
		if (!$buscar && !$buscarRango) {
			// Por defecto carga el día de ayer
			$fechaInicio = date('Y-m-d', strtotime("-1 days"));
			$fechaFin = date('Y-m-d', strtotime("-1 days"));
		} else if ($buscar) {
			// Búsqueda simple: la fecha fin es igual a la de inicio
			$fechaFin = $fechaInicio;
		} // Si es buscarRango, respeta ambas fechas tal cual vienen del POST

		// Obtener datos consolidados en 3 consultas exactas (0 Lag)
		$turnosData = $this->Mdl_nominas->getResumenTurnos($fechaInicio, $fechaFin, $plaza_id);
		$unidadesData = $this->Mdl_nominas->getResumenUnidades($fechaInicio, $fechaFin, $plaza_id);
		$ingresosData = $this->Mdl_nominas->getResumenIngresos($fechaInicio, $fechaFin, $plaza_id);

		$data = array(
			'fechaInicio' => $fechaInicio,
			'fechaFin' => $fechaFin,
			'plazas' => $this->Mdl_plazas->getPlazas(),
			'id' => $plaza_id,
			'turnosData' => $turnosData,
			'unidadesData' => $unidadesData,
			'ingresosData' => $ingresosData
		);

		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("administrador/nominas/analisis_nominas", $data);
		$this->load->view("layouts/footer");
	}

	public function manager()
	{
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("manager/nominas/panel_nominas");
		$this->load->view("layouts/footer");
	}

	public function usuariosManager()
	{
		// Obtenemos la plaza de la sesión y el número de día actual para el modal
		$plaza_id = $this->session->userdata("plaza");
		$numeroDia = date('N');

		$data = [
			'usuarios' => $this->Mdl_nominas->getUsuarios($plaza_id),
			'roles'    => $this->Mdl_nominas->getRoles(),
			'lugares'  => $this->Mdl_nominas->getLugares(),
			'turnos'   => $this->Mdl_nominas->getTurnosNomina(),
			'dias'     => $this->Mdl_nominas->getDiasNomina($numeroDia)
		];

		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("manager/nominas/users", $data);
		$this->load->view("layouts/footer");
	}

	public function usuariosAdministrador()
	{
		$plaza_id = $this->input->post("plaza_id");

		// Si no hay plaza seleccionada, cargamos todos los usuarios (UsuariosT)
		if (empty($plaza_id)) {
			$usuarios = $this->Mdl_nominas->getUsuariosT();
			$plaza_id = ""; // Normalizamos a string vacío para la validación de la vista
		} else {
			$usuarios = $this->Mdl_nominas->getUsuarios($plaza_id);
		}

		$data = [
			'id'       => $plaza_id, // La vista de admin usa $id para el "selected" del combobox
			'usuarios' => $usuarios,
			'plazas'   => $this->Mdl_plazas->getPlazas(),
			'roles'    => $this->Mdl_nominas->getRoles()
		];

		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("administrador/nominas/users", $data);
		$this->load->view("layouts/footer");
	}

	public function usuariosEliminadosManager()
	{
		// Solo necesitamos la plaza de la sesión para mostrar sus usuarios eliminados
		$plaza_id = $this->session->userdata("plaza");

		$data = [
			'usuarios' => $this->Mdl_nominas->getUsuariosEliminados($plaza_id)
		];

		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("manager/nominas/users_delete", $data);
		$this->load->view("layouts/footer");
	}

	public function usuariosEliminadosAdministrador()
	{
		$plaza_id = $this->input->post("plaza_id");

		// Si no hay plaza seleccionada, traemos todos los eliminados a nivel global
		if (empty($plaza_id)) {
			$usuarios = $this->Mdl_nominas->getUsuariosEliminadosT();
			$nombrePlaza = "";
			$plaza_id = ""; // Normalizamos a string vacío para el selected de la vista
		} else {
			$usuarios = $this->Mdl_nominas->getUsuariosEliminados($plaza_id);
			$nombrePlazaObj = $this->Mdl_plazas->getPlazaID($plaza_id);
			// Validamos que el objeto exista antes de intentar acceder a la propiedad
			$nombrePlaza = $nombrePlazaObj ? $nombrePlazaObj->nombrePlaza : "";
		}

		$data = [
			'id'          => $plaza_id,
			'usuarios'    => $usuarios,
			'plazas'      => $this->Mdl_plazas->getPlazas(),
			'nombrePlaza' => $nombrePlaza
		];

		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("administrador/nominas/users_delete", $data);
		$this->load->view("layouts/footer");
	}

	public function saveUsuario()
	{
		if ($this->input->is_ajax_request()) {

			$nombre = $this->input->post("nombre_agregar");
			$apellido_paterno = $this->input->post("apellido_paterno_agregar");
			$apellido_materno = $this->input->post("apellido_materno_agregar");
			$fecha_nacimiento = $this->input->post("fecha_nacimiento_agregar");
			$nombre_rol = $this->input->post("nombre_rol_agregar");

			$telefono = $this->input->post("telefono_agregar");
			$CURP = $this->input->post("CURP_agregar");
			$fecha_ingreso = $this->input->post("fecha_ingreso_agregar");
			$rol_nomina_id = $this->input->post("rol_id_agregar");
			$sueldo = $this->input->post("sueldo_agregar");
			$plaza_id = $this->session->userdata("plaza");


			if (is_numeric($sueldo)) {
				if ($sueldo > 0) {

					$data = array(
						"Nombre" => $nombre,
						"Apellido_Paterno" => $apellido_paterno,
						"Apellido_Materno" => $apellido_materno,
						"Nombre_Rol" => $nombre_rol,
						"plaza_id" => $plaza_id,
						"rol_nomina_id" => $rol_nomina_id,
						"Fecha_Nacimiento" => $fecha_nacimiento,
						"Fecha_Ingreso" => $fecha_ingreso,
						"Fecha_Egreso" => "0000-00-00",
						"Telefono" => $telefono,
						"CURP" => $CURP,
						"Sueldo" => $sueldo
					);

					//GUARDAMOS EL ID DEL INSUMO INSERTADO EN CASO DE QUE NO SE INSERTO SE GUARD FALSE
					$usuario_id = $this->Mdl_nominas->saveUsuario($data);
					//PRIMERO GUARDAMOS EL USUARIO
					if ($usuario_id != false) {
						//DESPUES DE GUARDARLO REGISTRAMOS EL EVENTO DE INICIO LABORAL
						$data = array(
							"usuario_nomina_id" => $usuario_id,
							"concepto_id" => 8,
							"Fecha" => $fecha_ingreso,
							"Importe" => 0,
							"Nota" => "INGRESO A LA EMPRESA"
						);
						if ($this->Mdl_nominas->saveExtra($data)) {
							echo 1;
						} else {
							echo 0;
						}
					} else {
						echo 0;
					}
				} else {
					echo 0;
				}
			} else {
				echo 0;
			}
		} else {
			redirect(base_url() . "Inicio");
		}
	}

	public function agregarRolSemanal()
	{
		$this->_procesarAgregarRol(false); // Manager
	}

	public function agregarRolSemanalAdmin()
	{
		$this->_procesarAgregarRol(true); // Admin
	}

	public function actualizarRolSemanal()
	{
		$this->_procesarActualizarRol(false); // Manager
	}

	public function actualizarRolSemanalAdmin()
	{
		$this->_procesarActualizarRol(true); // Admin
	}

	public function asignarDias()
	{
		if ($this->input->is_ajax_request()) {
			$nombres = ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'];
			$output = "";

			for ($i = 0; $i < 7; $i++) {
				$fechaExacta = date('Y-m-d', strtotime('monday this week + ' . $i . ' days'));
				$diaMes = date('d', strtotime($fechaExacta));
				$output .= '<option value="' . $i . '">' . $nombres[$i] . ' ' . $diaMes . '</option>';
			}
			echo $output;
		} else {
			redirect(base_url() . "Inicio");
		}
	}

	public function asignarDiasManager()
	{
		if ($this->input->is_ajax_request()) {
			$fechaInicio = $this->input->post('fechaInicio');
			$indiceDia = date('N', strtotime($fechaInicio)) - 1; // 0 (Lunes) a 6 (Domingo)

			$nombres = ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'];
			$output = "";

			for ($i = $indiceDia; $i < 7; $i++) {
				$fechaExacta = date('Y-m-d', strtotime('monday this week + ' . $i . ' days'));
				$diaMes = date('d', strtotime($fechaExacta));
				$output .= '<option value="' . $i . '">' . $nombres[$i] . ' ' . $diaMes . '</option>';
			}
			echo $output;
		} else {
			redirect(base_url() . "Inicio");
		}
	}

	public function asignarDias2()
	{
		$fechaInicio = date("Y-m-d");
		$indiceDia = date('N', strtotime($fechaInicio)) - 1;
		$data = array();

		for ($i = $indiceDia; $i < 7; $i++) {
			$data[] = date('Y-m-d', strtotime('monday this week + ' . $i . ' days'));
		}
		return $data;
	}

	public function consultarDetallesRol2()
	{
		if ($this->input->is_ajax_request()) {
			$usuario_id = $this->input->post("usuario_id");
			$fecha_id = $this->input->post("fecha_id"); // Recibe de 0 (Lunes) a 6 (Domingo)

			$fechaExacta = date('Y-m-d', strtotime('monday this week + ' . $fecha_id . ' days'));

			echo json_encode($this->Mdl_nominas->getRolSemanalUsuario($usuario_id, $fechaExacta, $fechaExacta));
		} else {
			redirect(base_url() . "Inicio");
		}
	}

	public function consultarTurno()
	{
		if ($this->input->is_ajax_request()) {

			$usuario_id = $this->input->post("usuario_id");
			$fechaInicio = $this->input->post("fecha_inicio");
			$fechaFin = $this->input->post("fecha_fin");
			$dia_id = $this->input->post("dia_id");

			$turno = $this->Mdl_nominas->getTurno($usuario_id, $dia_id, $fechaInicio, $fechaFin);
			if ($turno) {
				$turno = $turno->Turno;
				echo $this->Mdl_nominas->getTurnosID($turno);
			} else {
				$turno = 0;
				echo $this->Mdl_nominas->getTurnosID($turno);
			}


		} else {
			redirect(base_url() . "Inicio");
		}
	}

	public function consultarDetallesRol()
	{
		if ($this->input->is_ajax_request()) {
			$usuario_id = $this->input->post("usuario_id");
			//$fechaInicio=$this->input->post("fecha_inicio");
			//$fechaFin=$this->input->post("fecha_fin");
			$fechaInicio = date("Y-m-d");
			$fechaFin = date("Y-m-d");
			echo json_encode($this->Mdl_nominas->getRolSemanalUsuario($usuario_id, $fechaInicio, $fechaFin));
		} else {
			redirect(base_url() . "Inicio");
		}
	}

	public function consultarDetallesRolAdmin()
	{
		if ($this->input->is_ajax_request()) {
			$usuario_id = $this->input->post("usuario_id");
			$fechaInicio = $this->input->post("fechaInicio");
			//$fechaFin=$this->input->post("fechaFin");
			echo json_encode($this->Mdl_nominas->getRolSemanalUsuario($usuario_id, $fechaInicio, $fechaInicio));
		} else {
			redirect(base_url() . "Inicio");
		}
	}

	public function asignarSueldo()
	{
		if ($this->input->is_ajax_request()) {

			$usuario_id = $this->input->post("id_editarN");
			$fechaInicio = $this->input->post("fecha_inicio_editarN");
			$fechaFin = $this->input->post("fecha_fin_editarN");
			$cantidad = $this->input->post("cantidad_N");
			$data = array("Sueldo" => $cantidad);

			if ($this->Mdl_nominas->asignarSueldoColaborador($usuario_id, $fechaInicio, $fechaFin, $data)) {
				echo 1;
			} else {
				echo 0;
			}
		} else {
			redirect(base_url() . "Inicio");
		}
	}

	public function liberarNominaManagerC() {
		if ($this->input->is_ajax_request()) {
			$this->_procesarEstadoNomina($this->session->userdata("plaza"), $this->input->post("fechaInicio"), $this->input->post("fechaFin"), 1);
		} else { redirect(base_url() . "Inicio"); }
	}

	public function liberarNominaManagerAdminC() {
		if ($this->input->is_ajax_request()) {
			$this->_procesarEstadoNomina($this->input->post("plaza_id"), $this->input->post("fechaInicio"), $this->input->post("fechaFin"), 1);
		} else { redirect(base_url() . "Inicio"); }
	}

	public function habilitarNominaManagerAdminC() {
		if ($this->input->is_ajax_request()) {
			$this->_procesarEstadoNomina($this->input->post("plaza_id"), $this->input->post("fechaInicio"), $this->input->post("fechaFin"), 0);
		} else { redirect(base_url() . "Inicio"); }
	}

	public function liberarNominaAdmin()
	{
		if ($this->input->is_ajax_request()) {

			$fechaInicio = $this->input->post("fechaInicio");
			$fechaFin = $this->input->post("fechaFin");
			$plaza_id = $this->input->post("plaza_id");

			$data = array("Estado" => 2);
			if ($plaza_id != 0) {
				if ($this->Mdl_nominas->disponibilidadNomina($plaza_id, $fechaInicio, $fechaFin)) {
					if ($this->Mdl_nominas->disponibilidadNominaManager($plaza_id, $fechaInicio, $fechaFin)) {
						if ($this->Mdl_nominas->actualizarRolSemanal($plaza_id, $fechaInicio, $fechaFin, $data)) {
							echo 1;
						} else {
							echo 0;
						}
					} else {
						echo 4;
					}
				} else {
					echo 3;
				}
			} else {
				echo 2;
			}
		} else {
			redirect(base_url() . "Inicio");
		}
	}

	public function fechaLunes($fecha)
	{
		$year = date("Y", strtotime($fecha)); // Se extrae el año real de la fecha
		$weeknumber = date("W", strtotime($fecha));
		$gendate = new DateTime();
		$gendate->setISODate($year, $weeknumber, 1);
		return $gendate->format('Y-m-d');
	}

	public function fechaDomingo($fecha)
	{
		$year = date("Y", strtotime($fecha)); // Se extrae el año real de la fecha
		$weeknumber = date("W", strtotime($fecha));
		$gendate = new DateTime();
		$gendate->setISODate($year, $weeknumber, 7);
		return $gendate->format('Y-m-d');
	}

	public function getSemana($fecha)
	{
		$date = $fecha;
		$Y_date = explode("-", $date);
		$year = $Y_date[0];
		$weeknumber = date("W", strtotime($date));
		return $weeknumber;
	}

	function getWeekDates($year, $week, $day, $start = true)
	{
		$from = date("d", strtotime("{$year}-W{$week}-{$day}")); //Returns the date of monday in week
		$to = date("d", strtotime("{$year}-W{$week}-{$day}"));   //Returns the date of sunday in week

		if ($start) {
			return $from;
		} else {
			return $to;
		}
		//return "Week {$week} in {$year} is from {$from} to {$to}.";
	}

	public function otorgarPermiso()
	{
		if ($this->input->is_ajax_request()) {
			$plaza_id = $this->input->post("plaza_id");
			$fechaInicio = $this->input->post("fechaInicio");
			$fechaFin = $this->input->post("fechaFin");
			$data = array("Estado" => 0);
			if ($this->Mdl_nominas->actualizarRolSemanal($plaza_id, $fechaInicio, $fechaFin, $data)) {
				echo 1;
			} else {
				echo 0;
			}
		} else {
			redirect(base_url() . "Inicio");
		}
	}

	public function actualizarUsuario()
	{
		if ($this->input->is_ajax_request()) {
			$usuario_id = $this->input->post("usuario_id_editar");
			$fechaIngreso = $this->input->post("fecha_ingreso_editar");

			// 1. Construimos el arreglo UNA SOLA VEZ (DRY)
			$dataUsuario = array(
				"Nombre"           => $this->input->post("nombre_editar"),
				"Apellido_Paterno" => $this->input->post("apellido_paterno_editar"),
				"Apellido_Materno" => $this->input->post("apellido_materno_editar"),
				"Nombre_Rol"       => $this->input->post("nombre_rol_editar"),
				"rol_nomina_id"    => $this->input->post("rol_id_editar"),
				"Fecha_Nacimiento" => $this->input->post("fecha_nacimiento_editar"),
				"Fecha_Ingreso"    => $fechaIngreso,
				"Telefono"         => $this->input->post("telefono_editar"),
				"CURP"             => $this->input->post("CURP_editar"),
				"Sueldo"           => $this->input->post("sueldo_editar")
			);

			$fechaIngresoActual = $this->Mdl_nominas->consultarFechaIngreso($usuario_id);
			$fechaAnterior = $fechaIngresoActual ? $fechaIngresoActual->fechaIngreso : null;

			// 2. Si la fecha cambió, registramos el evento antes de actualizar
			if ($fechaAnterior != $fechaIngreso) {
				$dataEvento = array("Fecha" => $fechaIngreso);
				$this->Mdl_nominas->actualizarEvento(8, $usuario_id, $dataEvento);
			}

			// 3. Actualizamos al usuario
			if ($this->Mdl_nominas->actualizarUsuarioN($usuario_id, $dataUsuario)) {
				echo 1;
			} else {
				echo 0;
			}
		} else {
			redirect(base_url() . "Inicio");
		}
	}

	public function actualizarUsuarioManager()
	{
		if ($this->input->is_ajax_request()) {

			$usuario_id = $this->input->post("usuario_id_editar");
			$nombre = $this->input->post("nombre_editar");
			$apellidoPaterno = $this->input->post("apellido_paterno_editar");
			$apellidoMaterno = $this->input->post("apellido_materno_editar");
			$nombre_rol = $this->input->post("nombre_rol_editar");
			$fechaNacimiento = $this->input->post("fecha_nacimiento_editar");
			$telefono = $this->input->post("telefono_editar");
			$curp = $this->input->post("CURP_editar");


			$data = array(
				"Nombre" => $nombre,
				"Apellido_Paterno" => $apellidoPaterno,
				"Apellido_Materno" => $apellidoMaterno,
				"Nombre_Rol" => $nombre_rol,
				"Fecha_Nacimiento" => $fechaNacimiento,
				"Telefono" => $telefono,
				"CURP" => $curp
			);

			if ($this->Mdl_nominas->actualizarUsuarioN($usuario_id, $data)) {
				echo 1;
			} else {
				echo 0;
			}
		} else {
			redirect(base_url() . "Inicio");
		}
	}

	public function eliminarUsuario()
	{
		if ($this->input->is_ajax_request()) {
			$usuario_id = $this->input->post("usuario_id");

			$lunes = $this->fechaLunes(date("Y-m-d"));
			$domingo = $this->fechaDomingo(date("Y-m-d"));

			$disponibilidad = $this->Mdl_nominas->checarDisponibilidadRol($lunes, $domingo, $usuario_id);
			if ($disponibilidad == null) {
				$data = array("Activo" => 0);
				if ($this->Mdl_nominas->eliminarUsuarioN($usuario_id, $data)) {
					//UNA VEZ QUE SE ELIMINO EL REGISTRO GUARDAMOS EN EL HISTORIAL SU BAJA Y LE ASIGNAMOS LA FECHA DE EGRESO
					$data = array(
						"usuario_nomina_id" => $usuario_id,
						"concepto_id" => 9,
						"Fecha" => date("Y-m-d"),
						"Importe" => 0,
						"Nota" => "EGRESO DE LA EMPRESA. Fecha: " . date("Y-m-d")
					);
					if ($this->Mdl_nominas->saveExtra($data)) {
						echo 1;
					} else {
						echo 0;
					}
				} else {
					echo 0;
				}
			} else {
				echo 2;
			}
		} else {
			redirect(base_url() . "Inicio");
		}
	}

	public function consultarUsuarios()
	{
		if ($this->input->is_ajax_request()) {
			$plaza_id = $this->input->post('plaza_id');
			echo $this->Mdl_nominas->getUsuariosPlaza($plaza_id);
		} else {
			redirect(base_url() . "Inicio");
		}
	}

	public function consultarHistorialUsuarios()
	{
		if ($this->input->is_ajax_request()) {
			$usuario_id = $this->input->post('usuario_id');
			$fechaInicio = $this->input->post('fechaInicio');
			$fechaFin = $this->input->post('fechaFin');
			echo json_encode($this->Mdl_nominas->gethistorialUsuarioAPI($fechaInicio, $fechaFin, $usuario_id));
		} else {
			redirect(base_url() . "Inicio");
		}
	}

	public function consultarHistorialUsuariosAdministrador()
	{
		if ($this->input->is_ajax_request()) {
			$usuario_id = $this->input->post('usuario_id');
			echo json_encode($this->Mdl_nominas->gethistorialUsuarioAPIManager($usuario_id));
		} else {
			redirect(base_url() . "Inicio");
		}
	}

	public function eliminarEventoUsuario()
	{
		if ($this->input->is_ajax_request()) {
			$id = $this->input->post('id');
			if ($this->Mdl_nominas->eliminarEventoUsuarioN($id)) {
				echo 1;
			} else {
				echo 0;
			}
		} else {
			redirect(base_url() . "Inicio");
		}
	}

	public function diaFeriadoC()
	{
		if ($this->input->is_ajax_request()) {
			$usuario_id = $this->input->post('usuario_id_DF');
			$concepto_id = $this->input->post('concepto_id_DF');
			$importe = $this->input->post('importe_DF');
			$nota = $this->input->post('nota_nota_DF');
			$dia_id = $this->input->post('dia_editar_DF');

			// 1. Recibir las fechas exactas que tienes filtradas en la vista
			$lunes = $this->input->post('fechaInicio');
			$domingo = $this->input->post('fechaFin');

			// 2. Calcular la fecha exacta sumando días al lunes (dia_id 1 = +0 días, dia_id 2 = +1 día, etc.)
			$dias_extra = $dia_id - 1;
			$fecha = date('Y-m-d', strtotime($lunes . " + $dias_extra days"));

			$disponibilidadExtra = $this->Mdl_nominas->consultarDisponibilidadExtrasNomina($lunes, $domingo, $usuario_id);

			if ($disponibilidadExtra != null) {

				$extraAcumulado = $this->Mdl_nominas->consultarAcumuladoExtra($lunes, $domingo, $usuario_id);
				if ($extraAcumulado != null) {
					$extraAcumulado = $extraAcumulado->Extra;
				} else {
					$extraAcumulado = 0;
				}

				$extraAcumulado += $importe;

				$dataU = array(
					"Extra" => $extraAcumulado
				);

				$dataI = array(
					"usuario_nomina_id" => $usuario_id,
					"concepto_id" => $concepto_id,
					"Fecha" => $fecha,
					"Importe" => $importe,
					"Nota" => $nota
				);

				if ($this->Mdl_nominas->agregarNotaUsuarioM($usuario_id, $lunes, $domingo, $dataU, $dataI)) {
					echo 1;
				} else {
					echo 0;
				}
			} else {
				echo 2;
			}
		} else {
			redirect(base_url() . "Inicio");
		}
	}

	public function aumentarSueldo()
	{
		if ($this->input->is_ajax_request()) {
			// Asegúrate de que estos nombres coincidan con los que envías desde el AJAX de tu vista
			$usuario_id = $this->input->post("usuario_id");
			$nuevo_sueldo = $this->input->post("nuevo_sueldo");

			$data = array("Sueldo" => $nuevo_sueldo);

			// actualizarUsuarioN ya existe en tu modelo para actualizar tbl_usuarios_nomina
			if ($this->Mdl_nominas->actualizarUsuarioN($usuario_id, $data)) {
				echo 1;
			} else {
				echo 0;
			}
		} else {
			redirect(base_url() . "Inicio");
		}
	}

	public function eliminarEventoC()
	{
		if ($this->input->is_ajax_request()) {
			$fecha = $this->input->post('fecha');
			$usuario_id = $this->input->post('usuario_id');
			$code = $this->input->post('code');

			$importeObj = $this->Mdl_nominas->getImporteExtras($code);
			$importe = $importeObj ? $importeObj->Importe : 0;

			// Calcular la semana usando la fecha exacta del evento
			$lunes = $this->fechaLunes($fecha);
			$domingo = $this->fechaDomingo($fecha);

			$extraAcumuladoObj = $this->Mdl_nominas->consultarAcumuladoExtra($lunes, $domingo, $usuario_id);
			$extraAcumulado = $extraAcumuladoObj ? $extraAcumuladoObj->Extra : 0;

			$nuevoExtra = $extraAcumulado - $importe;
			$dataU = array("Extra" => $nuevoExtra);

			if ($this->Mdl_nominas->eliminarNotaUsuarioM($usuario_id, $lunes, $domingo, $dataU, $code)) {
				echo 1;
			} else {
				echo 0;
			}
		} else {
			redirect(base_url() . "Inicio");
		}
	}

	public function consultarSueldoID()
	{
		if ($this->input->is_ajax_request()) {
			$usuario_id = $this->input->post('usuario_id');
			$sueldo = $this->Mdl_nominas->consultarSueldoUsuario($usuario_id);
			if ($sueldo != null) {
				$sueldo = $sueldo->Sueldo;
			} else {
				$sueldo = 0;
			}

			echo $sueldo;

		} else {
			redirect(base_url() . "Inicio");
		}
	}

	// =========================================================================
	// MÉTODOS PRIVADOS REFACTORIZADOS (DRY)
	// =========================================================================

	private function _obtenerFechaPorDiaSemana($dia_id)
	{
		// dia_id viene de la BD (1 = Lunes, 7 = Domingo)
		$dias = [
			1 => 'monday this week', 2 => 'tuesday this week', 3 => 'wednesday this week',
			4 => 'thursday this week', 5 => 'friday this week', 6 => 'saturday this week', 7 => 'sunday this week'
		];
		return date('Y-m-d', strtotime($dias[$dia_id]));
	}

	private function _procesarAgregarRol($esAdmin = false)
	{
		if (!$this->input->is_ajax_request()) {
			redirect(base_url() . "Inicio");
			exit;
		}

		$usuario_id = $this->input->post("usuario_agregar_id");
		$dia_id = $this->input->post("dia_id");
		$turno_id = $this->input->post("turno_id");
		$lugar_id = $this->input->post("lugar_id");

		$plaza_id = $esAdmin ? $this->Mdl_nominas->getPlazaUsuario($usuario_id)->Plaza : $this->session->userdata("plaza");
		$fecha = $this->_obtenerFechaPorDiaSemana($dia_id);

		if ($fecha < date("Y-m-d")) {
			echo 3; // No se puede agregar a días anteriores
			return;
		}

		$sueldoObj = $this->Mdl_nominas->consultarSueldoUsuario($usuario_id);
		$sueldo = $sueldoObj ? $sueldoObj->Sueldo : 0;

		// Si es turno 3 (Ambos), insertamos el 1 (Matutino) y el 2 (Vespertino)
		$turnosAIngresar = ($turno_id == 3) ? [1, 2] : [$turno_id];
		$datosInsertar = [];

		foreach ($turnosAIngresar as $t_id) {
			$asignados = $this->Mdl_nominas->checarTurnos($fecha, $usuario_id, $t_id);
			if ($asignados && $asignados->Total >= 1) {
				echo 2; // Número de turnos sobrepasado
				return;
			}
			$datosInsertar[] = [
				"usuario_nomina_id" => $usuario_id,
				"rol_cafeteria_id" => $lugar_id,
				"plaza_id" => $plaza_id,
				"Fecha" => $fecha,
				"dia_id" => $dia_id,
				"turno_id" => $t_id,
				"Sueldo" => $sueldo,
				"Extra" => 0
			];
		}

		if (count($datosInsertar) == 1) {
			echo $this->Mdl_nominas->saveRolNominas($datosInsertar[0]) ? 1 : 0;
		} else {
			echo $this->Mdl_nominas->saveRolNominasDoble($datosInsertar) ? 1 : 0;
		}
	}

	private function _procesarActualizarRol($esAdmin = false)
	{
		if (!$this->input->is_ajax_request()) {
			redirect(base_url() . "Inicio");
			exit;
		}

		$usuario_id = $this->input->post("id_editarN");
		// El frontend manda un índice de 0 a 6. Lo convertimos a 1 a 7.
		$dia_id = $this->input->post("dia_editarN") + 1;

		$mat_editar = $this->input->post("matutino_editar");
		$vesp_editar = $this->input->post("vespertino_editar");

		$plaza_id = $esAdmin ? $this->Mdl_nominas->getPlazaUsuario($usuario_id)->Plaza : $this->session->userdata("plaza");
		$fecha = $this->_obtenerFechaPorDiaSemana($dia_id);

		$sueldoObj = $this->Mdl_nominas->consultarSueldoUsuario($usuario_id);
		$sueldo = $sueldoObj ? $sueldoObj->Sueldo : 0;

		$banderaError = false;

		// Arreglo para procesar ambos turnos dinámicamente [turno_id => valor_recibido]
		$turnosAProcesar = [1 => $mat_editar, 2 => $vesp_editar];

		foreach ($turnosAProcesar as $t_id => $lugar_cafeteria_id) {
			if ($lugar_cafeteria_id == 5) {
				// 5 significa "No" (Eliminar turno)
				$this->Mdl_nominas->eliminarTurnoEspecifico($usuario_id, $t_id, $fecha, $fecha);
			} else {
				$existe = $this->Mdl_nominas->existenciaTurno2($usuario_id, $t_id, $fecha, $fecha);
				if (!empty($existe)) {
					if (!$this->Mdl_nominas->actualizarTurnoEspecifico($usuario_id, $t_id, $fecha, $fecha, ["rol_cafeteria_id" => $lugar_cafeteria_id])) {
						$banderaError = true;
					}
				} else {
					$data = [
						"usuario_nomina_id" => $usuario_id, "rol_cafeteria_id" => $lugar_cafeteria_id,
						"plaza_id" => $plaza_id, "Fecha" => $fecha, "dia_id" => $dia_id,
						"turno_id" => $t_id, "Sueldo" => $sueldo, "Extra" => 0
					];
					if (!$this->Mdl_nominas->saveRolNominas($data)) $banderaError = true;
				}
			}
		}

		echo $banderaError ? 0 : 1;
	}

	private function _procesarEstadoNomina($plaza_id, $fechaInicio, $fechaFin, $estadoObjetivo)
	{
		if (!$this->Mdl_nominas->disponibilidadNomina($plaza_id, $fechaInicio, $fechaFin)) {
			echo 2; // Nómina vacía
			return;
		}

		$estadoObj = $this->Mdl_nominas->getEstado($plaza_id, $fechaInicio, $fechaFin);
		$estadoActual = $estadoObj ? $estadoObj->Estado : 0;

		// Reglas de negocio centralizadas
		if ($estadoActual == $estadoObjetivo) {
			echo 3; // Ya está en el estado solicitado
			return;
		} elseif ($estadoActual == 2) {
			echo 4; // Ya liberada por admin, inamovible
			return;
		} elseif ($estadoObjetivo == 0 && $estadoActual != 1) {
			echo 3; // Solo se puede habilitar si estaba en revisión
			return;
		}

		$data = array("Estado" => $estadoObjetivo);
		echo $this->Mdl_nominas->actualizarRolSemanal($plaza_id, $fechaInicio, $fechaFin, $data) ? 1 : 0;
	}

	private function _procesarRangoFechas($fechaInicioPOST, $fechaFinPOST, $buscarPOST, $buscarRangoPOST = false)
	{
		if (empty($fechaInicioPOST)) {
			$lunes = $this->fechaLunes(date("Y-m-d"));
			$domingo = $this->fechaDomingo(date("Y-m-d"));
		} else if ($buscarPOST) {
			$lunes = $this->fechaLunes($fechaInicioPOST);
			$domingo = $this->fechaDomingo($fechaInicioPOST);
		} else if ($buscarRangoPOST) {
			$lunes = $fechaInicioPOST;
			$domingo = $fechaFinPOST;
		} else {
			$lunes = $this->fechaLunes(date("Y-m-d"));
			$domingo = $this->fechaDomingo(date("Y-m-d"));
		}

		$anioActual = date('Y', strtotime($lunes));
		$numeroSemana = $this->getSemana($lunes);

		$diasE = [];
		for ($i = 1; $i <= 7; $i++) {
			$diasE[$i] = $this->getWeekDates($anioActual, $numeroSemana, $i, true);
		}

		return [
			'fechaInicio' => $lunes,
			'fechaFin'    => $domingo,
			'diasE'       => $diasE
		];
	}
}
