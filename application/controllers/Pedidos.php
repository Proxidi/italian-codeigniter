<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pedidos extends CI_Controller {

	private $permisos;

	public function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata("login")){
			redirect(base_url());
		}

		$this->load->model('Mdl_usuarios');
		$this->load->model('Mdl_roles');
		$this->load->model('Mdl_backend');
		$this->load->model('Mdl_plazas');
		$this->load->model('Mdl_pedidos');
		$this->load->model('Mdl_productos');
		$this->load->model('Mdl_inventario');

		if (!$this->input->is_ajax_request()) {
			$this->permisos = $this->backend_lib->control();
		}
	}

	// =========================================================================
	// MÉTODOS PRIVADOS DE APOYO (REFACTORIZACIÓN)
	// =========================================================================

	private function _requireAjax()
	{
		if (!$this->input->is_ajax_request()) {
			redirect(base_url() . "Inicio");
			exit;
		}
	}

	private function _responderTablaPedidoAjax($fecha, $plaza_id, $esPasteleria = false)
	{
		if ($esPasteleria) {
			$tabla = $this->ajaxPasteleria($fecha, $plaza_id);
			$numero = $this->Mdl_backend->rowCountFecha("tbl_pedidos_pasteleria", $fecha, $plaza_id);
		} else {
			$tabla = $this->ajax($fecha, $plaza_id);
			$numero = $this->Mdl_backend->rowCountFecha("tbl_pedidos", $fecha, $plaza_id);
		}
		echo json_encode([["tabla" => $tabla, "numero" => $numero]]);
	}

	private function _obtenerRangoFechasPorMes($mes_id, $anio_id)
	{
		$year = $anio_id ?: date("Y");
		if ($mes_id >= 1 && $mes_id <= 12) {
			$mes = str_pad($mes_id, 2, "0", STR_PAD_LEFT);
			$fechainicio = "$year-$mes-01";
			// date('Y-m-t') obtiene automáticamente el último día del mes (28, 29, 30 o 31)
			$fechafin = date("Y-m-t", strtotime($fechainicio));
		} else {
			$fechainicio = "$year-01-01";
			$fechafin = "$year-12-31";
		}
		return [$fechainicio, $fechafin, $year];
	}

	private function _obtenerCarpetaPlaza($id_plaza)
	{
		$carpetas = [
			1 => "CASITAS", 2 => "MATAMOROS", 3 => "OAXACA",
			4 => "POZA RICA", 5 => "REYNOSA I", 6 => "REYNOSA II", 7 => "TEZIUTLAN"
		];
		return $carpetas[$id_plaza] ?? "";
	}

	private function _validarPlazaExcel($nombrePlaza, $plaza_id)
	{
		$mapeo = [
			'CASITAS' => 1, 'MATAMOROS' => 2, 'TUXTEPEC' => 3,
			'20 DE NOV. EN POZARICA' => 4, 'REYNOSA 1' => 5,
			'REYNOSA 2' => 6, 'TEZIUTLAN CRYSTAL' => 7
		];
		return (isset($mapeo[$nombrePlaza]) && $mapeo[$nombrePlaza] == $plaza_id);
	}

	// =========================================================================
	// MÉTODOS PÚBLICOS DEL CONTROLADOR
	// =========================================================================

	public function index()
	{
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("administrador/pedidos/panel_pedidos");
		$this->load->view("layouts/footer");
	}

	public function actualizarPedido()
	{
		$this->_requireAjax();
		$fecha = $this->input->post("fecha");
		$plaza_id = $this->input->post("plaza_id");
		$insumo_id = $this->input->post("insumo_id");
		$cantidadRecibida = (float)$this->input->post("cantidadRecibida");
		$cantidadOrdenada = (float)$this->input->post("cantidadOrdenada");

		$cantidad_final = $this->conversorPedido($insumo_id, $cantidadRecibida);
		$bandera = 1;
		$completo = 1;

		if($cantidadRecibida <= 0){
			$cantidadRecibida = 0;
			$bandera = 2;
			$completo = 0;
		} else if($cantidadRecibida < $cantidadOrdenada){
			$bandera = 3;
			$completo = 0;
		}

		$data = array("Cantidad_Inventario" => $cantidadRecibida, "Cantidad_Final" => $cantidad_final, "Bandera" => $bandera, "Completo" => $completo);
		$this->Mdl_pedidos->cuadrarPedido($fecha, $plaza_id, $insumo_id, $data);
		$this->_responderTablaPedidoAjax($fecha, $plaza_id, false);
	}

	public function actualizarPedidoPasteleria()
	{
		$this->_requireAjax();
		$fecha = $this->input->post("fecha");
		$plaza_id = $this->input->post("plaza_id");
		$insumo_id = $this->input->post("insumo_id");
		$cantidad = $this->input->post("cantidadRecibida");

		$data = array("Cantidad_Recibida" => $cantidad, "Cantidad_Final" => $cantidad, "Bandera" => 1);
		$this->Mdl_pedidos->cuadrarPedidoPasteleria($fecha, $plaza_id, $insumo_id, $data);
		$this->_responderTablaPedidoAjax($fecha, $plaza_id, true);
	}

	public function add()
	{
		$data = array(
			"plazas" => $this->Mdl_plazas->getPlazas(),
			'pedidos' => $this->Mdl_pedidos->getPedidos(),
			'detalles' => $this->Mdl_pedidos->getDetallesPedido(),
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("administrador/pedidos/add", $data);
		$this->load->view("layouts/footer");
	}

	public function addPasteleria()
	{
		$plaza_id = 0;
		$insumo_id = 0;
		$fecha = date("Y-m-d");
		$plazaDestino = $this->Mdl_pedidos->getInsumosPedidoPasteleria();

		if($plazaDestino != null){
			foreach ($plazaDestino as $key) {
				$plaza_id = $key->plaza_id;
				$insumo_id = $key->insumo_id;
				$fecha = $key->Fecha;
			}
		}

		$data = array(
			"plazas" => $this->Mdl_plazas->getPlazas(),
			'pedidos' => $this->Mdl_pedidos->getInsumosPedidoPasteleria(),
			'insumos' => $this->Mdl_productos->getInsumosPasteleria(),
			'plaza_id' => $plaza_id,
			'insumo1' => $insumo_id,
			'fecha' => $fecha,
			'misPedidos' => $this->Mdl_pedidos->getDetallesPedidoPasteleria(),
			'liberados' => $this->Mdl_pedidos->getDetallesPedidoLiberadoPasteleria()
		);

		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("administrador/pedidos/add_pasteleria", $data);
		$this->load->view("layouts/footer");
	}

	private function ajax($fecha, $plaza_id)
	{
		return $this->Mdl_pedidos->getPedidoManager2($fecha, $plaza_id);
	}

	private function ajaxPasteleria($fecha, $plaza_id)
	{
		return $this->Mdl_pedidos->getPedidoManager2Pasteleria($fecha, $plaza_id);
	}

	public function consultarPedido()
	{
		$this->_requireAjax();
		$fecha = $this->input->post('fecha');
		$plaza_id = $this->input->post('plaza_id');
		echo $this->Mdl_pedidos->getPedido($fecha, $plaza_id);
	}

	public function consultarPedidoPasteleria()
	{
		$this->_requireAjax();
		$fecha = $this->input->post('fecha');
		$plaza_id = $this->input->post('plaza_id');
		echo json_encode($this->Mdl_pedidos->getPedidoPasteleria($fecha, $plaza_id));
	}

	public function consultarPedidoManager()
	{
		$this->_requireAjax();
		$fecha = $this->input->post('fecha');
		$plaza_id = $this->input->post('plaza_id');
		echo $this->Mdl_pedidos->getPedidoHistorialManager($fecha, $plaza_id);
	}

	private function conversorPedido($insumo_id, $cantidad)
	{
		$operacion = $this->Mdl_inventario->getOperacionPedido($insumo_id);
		if($operacion != false){
			$valor = $operacion->Pedido;
			$myArray = explode(',', $valor);
			$tamaño = sizeof($myArray);

			if ($tamaño == 2) {
				switch($myArray[0]){
					case "*": return $cantidad * $myArray[1];
					case "+": return $cantidad + $myArray[1];
					case "-": return $cantidad - $myArray[1];
					case "/": return ($myArray[1] != 0) ? $cantidad / $myArray[1] : 0;
				}
			}
		}
		return 0;
	}

	public function cuadrarPedido()
	{
		$this->_requireAjax();
		$fecha = $this->input->post("fecha");
		$plaza_id = $this->input->post("plaza_id");
		$insumo_id = $this->input->post("insumo_id");
		$cantidad = $this->input->post("cantidad");
		$cantidad_final = $this->conversorPedido($insumo_id, $cantidad);

		$data = array("Cantidad_Inventario" => $cantidad, "Cantidad_Final" => $cantidad_final, "Bandera" => 1, "Completo" => 1);
		$this->Mdl_pedidos->cuadrarPedido($fecha, $plaza_id, $insumo_id, $data);
		$this->_responderTablaPedidoAjax($fecha, $plaza_id, false);
	}

	public function cuadrarPedidoPasteleria()
	{
		$this->_requireAjax();
		$fecha = $this->input->post("fecha");
		$plaza_id = $this->input->post("plaza_id");
		$insumo_id = $this->input->post("insumo_id");
		$cantidad = $this->input->post("cantidad");

		$data = array("Cantidad_Recibida" => $cantidad, "Cantidad_Final" => $cantidad, "Bandera" => 1);
		$this->Mdl_pedidos->cuadrarPedidoPasteleria($fecha, $plaza_id, $insumo_id, $data);
		$this->_responderTablaPedidoAjax($fecha, $plaza_id, true);
	}

	public function delete($fecha, $plaza_id)
	{
		$this->Mdl_pedidos->deleteDetalles($fecha, $plaza_id);
		$this->Mdl_pedidos->deletePedidos($fecha, $plaza_id);
		redirect(base_url()."Pedidos/add");
	}

	public function deletePasteleria($fecha, $plaza_id)
	{
		$this->Mdl_pedidos->deleteDetallesPasteleria($fecha, $plaza_id);
		$this->Mdl_pedidos->deletePedidosPasteleria($fecha, $plaza_id);
		redirect(base_url()."Pedidos/addPasteleria");
	}

	public function delete2($fecha, $plaza_id)
	{
		$this->Mdl_pedidos->deleteDetalles($fecha, $plaza_id);
		$this->Mdl_pedidos->deletePedidos($fecha, $plaza_id);
		redirect(base_url()."Pedidos/historialAdmin");
	}

	public function deletePasteleria2($fecha, $plaza_id)
	{
		$this->Mdl_pedidos->deleteDetallesPasteleria($fecha, $plaza_id);
		$this->Mdl_pedidos->deletePedidosPasteleria($fecha, $plaza_id);
		redirect(base_url()."Pedidos/historialPasteleria");
	}

	private function edicion()
	{
		$this->_requireAjax();
		$fecha = $this->input->post("fecha");
		$plaza_id = $this->input->post("plaza_id");
		$data = array('Estatus' => 0);

		echo $this->Mdl_pedidos->permitirEdicion($fecha, $plaza_id, $data) ? 1 : 0;
	}

	public function eliminarInsumoPedido()
	{
		$this->_requireAjax();
		$fecha = $this->input->post("fecha");
		$plaza_id = $this->input->post("plaza_id");
		$insumo_id = $this->input->post("insumo_id");

		if($this->Mdl_pedidos->deleteInsumoPedido($fecha, $plaza_id, $insumo_id)){
			$numero = $this->Mdl_backend->rowCountNormal("tbl_pedidos", $fecha, $plaza_id);
			$data = array('Cantidad' => $numero);
			echo $this->Mdl_pedidos->updateCantidadDetalles($fecha, $plaza_id, $data) ? 1 : 0;
		} else {
			echo 0;
		}
	}

	public function eliminarInsumoPasteleria()
	{
		$this->_requireAjax();
		$code = $this->input->post("code");
		echo $this->Mdl_pedidos->eliminarInsumoTempPasteleria($code) ? 1 : 0;
	}

	public function historialManager()
	{
		$plaza_id = $this->session->userdata("plaza");
		$data = array(
			'pedidos' => $this->Mdl_pedidos->getPedidos(),
			'detalles' => $this->Mdl_pedidos->getDetallesPedidoPlaza($plaza_id),
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("manager/pedidos/historial", $data);
		$this->load->view("layouts/footer");
	}

	public function historialAdmin()
	{
		$plaza_id = $this->input->post("plaza_id");
		$mes_id = $this->input->post("mes_id");
		$anio_id = $this->input->post("anio_id");

		list($fechainicio, $fechafin, $year) = $this->_obtenerRangoFechasPorMes($mes_id, $anio_id);

		$detalles = ($this->input->post("buscar") && $plaza_id != "")
			? $this->Mdl_pedidos->getDetallesPedidoLiberadoPlazaFecha($plaza_id, $fechainicio, $fechafin)
			: $this->Mdl_pedidos->getDetallesPedidoLiberadoFecha($fechainicio, $fechafin);

		$data = array(
			'pedidos' => $this->Mdl_pedidos->getPedidos(),
			'detalles' => $detalles,
			"plazas" => $this->Mdl_plazas->getPlazas(),
			'meses' => $this->Mdl_plazas->getMeses(),
			'id' => $plaza_id,
			'mes_id' => $mes_id,
			'fechaHoy' => date("Y-m-d"),
			'years' => $this->Mdl_plazas->getYears(),
			'year_id' => $year
		);

		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("administrador/pedidos/historial", $data);
		$this->load->view("layouts/footer");
	}

	public function historialPasteleria()
	{
		$plaza_id = $this->input->post("plaza_id");
		$mes_id = $this->input->post("mes_id");
		$anio_id = $this->input->post("anio_id");

		list($fechainicio, $fechafin, $year) = $this->_obtenerRangoFechasPorMes($mes_id, $anio_id);

		$detalles = ($this->input->post("buscar") && $plaza_id != "")
			? $this->Mdl_pedidos->getDetallesPedidoLiberadoPasteleriaPlazaFecha($plaza_id, $fechainicio, $fechafin)
			: $this->Mdl_pedidos->getDetallesPedidoLiberadoPasteleriaFecha($fechainicio, $fechafin);

		$data = array(
			'pedidos' => $this->Mdl_pedidos->getPedidos(),
			'detalles' => $detalles,
			"plazas" => $this->Mdl_plazas->getPlazas(),
			'meses' => $this->Mdl_plazas->getMeses(),
			'id' => $plaza_id,
			'mes_id' => $mes_id,
			'years' => $this->Mdl_plazas->getYears(),
			'year_id' => $year
		);

		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("administrador/pedidos/historial_pasteleria", $data);
		$this->load->view("layouts/footer");
	}

	public function listManager()
	{
		$plaza_id = $this->session->userdata("plaza");
		$fechaObj = $this->Mdl_pedidos->consultarFechaUltimoPedido($plaza_id);
		$fecha = $fechaObj ? $fechaObj->Fecha : date('Y-m-d');

		$estado = $this->Mdl_pedidos->consultarEstadoPedido($fecha, $plaza_id);
		$estadoFactura = $this->Mdl_pedidos->consultarEstadoFactura($fecha, $plaza_id);

		if($estado == false){
			$data = array(
				'numero' => $this->Mdl_backend->rowCountFecha("tbl_pedidos", $fecha, $plaza_id),
				'estado' => 1
			);
		} else {
			$estadoNum = $estado->Estatus;
			if($estadoFactura == false){
				$data = array(
					'pedidos' => $this->Mdl_pedidos->getPedidoManager($fecha, $plaza_id),
					'numero' => $this->Mdl_backend->rowCountFecha("tbl_pedidos", $fecha, $plaza_id),
					'estado' => $estadoNum,
					'capturar' => 0,
					'fecha' => $fecha
				);
			} else {
				$estadoF = $estadoFactura->Estatus_Factura;
				$capturar = ($estadoF == 1) ? 1 : 0;
				$data = array(
					'pedidos' => $this->Mdl_pedidos->getPedidoManager($fecha, $plaza_id),
					'miPedido' => $this->Mdl_pedidos->miPedido($fecha, $plaza_id),
					'numero' => $this->Mdl_backend->rowCountFecha("tbl_pedidos", $fecha, $plaza_id),
					'estado' => $estadoNum,
					'capturar' => $capturar,
					'fecha' => $fecha
				);
			}
		}
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("manager/pedidos/list", $data);
		$this->load->view("layouts/footer");
	}

	public function listManagerPasteleria()
	{
		$plaza_id = $this->session->userdata("plaza");
		$fechaObj = $this->Mdl_pedidos->consultarFechaUltimoPedidoPasteleria($plaza_id);
		$fecha = $fechaObj ? $fechaObj->Fecha : date('Y-m-d');

		$estado = $this->Mdl_pedidos->consultarEstadoPedidoPasteleria($fecha, $plaza_id);
		$estadoFactura = $this->Mdl_pedidos->consultarEstadoFacturaPasteleria($fecha, $plaza_id);

		if($estado == false){
			$data = array(
				'numero' => $this->Mdl_backend->rowCountFecha("tbl_pedidos_pasteleria", $fecha, $plaza_id),
				'estado' => 1
			);
		} else {
			$estadoNum = $estado->Estatus;
			if($estadoFactura == false){
				$data = array(
					'pedidos' => $this->Mdl_pedidos->getPedidoManagerPasteleria($fecha, $plaza_id),
					'numero' => $this->Mdl_backend->rowCountFecha("tbl_pedidos_pasteleria", $fecha, $plaza_id),
					'estado' => $estadoNum,
					'capturar' => 0,
					'fecha' => $fecha
				);
			} else {
				$estadoF = $estadoFactura->Estatus_Factura;
				$capturar = ($estadoF == 1) ? 1 : 0;
				$data = array(
					'pedidos' => $this->Mdl_pedidos->getPedidoManagerPasteleria($fecha, $plaza_id),
					'miPedido' => $this->Mdl_pedidos->miPedidoPasteleria($fecha, $plaza_id),
					'numero' => $this->Mdl_backend->rowCountFecha("tbl_pedidos_pasteleria", $fecha, $plaza_id),
					'estado' => $estadoNum,
					'capturar' => $capturar,
					'fecha' => $fecha
				);
			}
		}
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("manager/pedidos/list_pasteleria", $data);
		$this->load->view("layouts/footer");
	}

	public function manager()
	{
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("manager/pedidos/panel_pedidos");
		$this->load->view("layouts/footer");
	}

	public function noRecibido()
	{
		$this->_requireAjax();
		$fecha = $this->input->post("fecha");
		$plaza_id = $this->input->post("plaza_id");
		$insumo_id = $this->input->post("insumo_id");

		$data = array("Bandera" => 2, "Cantidad_Inventario" => 0, "Cantidad_Final" => 0, "Completo" => 0);
		$this->Mdl_pedidos->cuadrarPedido($fecha, $plaza_id, $insumo_id, $data);
		$this->_responderTablaPedidoAjax($fecha, $plaza_id, false);
	}

	public function noRecibidoPasteleria()
	{
		$this->_requireAjax();
		$fecha = $this->input->post("fecha");
		$plaza_id = $this->input->post("plaza_id");
		$insumo_id = $this->input->post("insumo_id");

		$data = array("Bandera" => 2, "Cantidad_Recibida" => 0, "Cantidad_Final" => 0);
		$this->Mdl_pedidos->cuadrarPedidoPasteleria($fecha, $plaza_id, $insumo_id, $data);
		$this->_responderTablaPedidoAjax($fecha, $plaza_id, true);
	}

	private function procesar($datos, $id_plaza, $nombreArchivoF)
	{
		require_once './assets/Classes/PHPExcel/IOFactory.php';

		$carpeta = $datos['carpeta'];
		$plaza_id = $id_plaza;
		$contadorInsumos = 0;
		$nombreArchivo = FCPATH . 'assets/filesPedido/' . $carpeta . "/" . $nombreArchivoF;

		if(!file_exists($nombreArchivo)) {
			return 0;
		}

		$oBjPHPExcel = PHPEXCEL_IOFactory::load($nombreArchivo);
		$oBjPHPExcel->setActiveSheetIndex(0);

		$fechaLiberacion = $oBjPHPExcel->getActiveSheet()->getCell('G7')->getCalculatedValue();
		$fechaLiberacion = \PHPExcel_Style_NumberFormat::toFormattedString($fechaLiberacion, 'YYYYMMDD');
		$nombrePlaza = $oBjPHPExcel->getActiveSheet()->getCell('E6')->getCalculatedValue();

		if($this->_validarPlazaExcel($nombrePlaza, $plaza_id)) {
			if( $fechaLiberacion == date('Ymd', strtotime($fechaLiberacion)) ) {
				if(!$this->Mdl_pedidos->consultarDisponibilidadPedido($fechaLiberacion, $plaza_id)){
					$arreglo = array();
					for ($i=13, $j=0; $i<=392; $i++){
						$tpv_2F = $oBjPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
						$tpv_3F = $oBjPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
						$tpv_5F = $oBjPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue();

						$insumoObj = $this->Mdl_productos->getInsumoPedido($tpv_2F);
						if($insumoObj != null){
							$insumo_id = $insumoObj->id;
							if($tpv_5F > 0 && $tpv_5F != null){
								$data = array(
									'Fecha' => $fechaLiberacion,
									"plaza_id" => $plaza_id,
									'insumo_id' => $insumo_id,
									"Clave" => $tpv_2F,
									"Nombre" => $tpv_3F,
									"Cantidad_Pedido" => $tpv_5F
								);
								$arreglo[$j] = $data;
								$contadorInsumos++;
								$j++;
							}
						}
					}

					$data2 = array(
						'Fecha' => $fechaLiberacion,
						'Fecha_Recepcion' => '0000-00-00',
						"plaza_id" => $plaza_id,
						'Cantidad' => $contadorInsumos,
						"Estatus" => 0, "Factura" => 0, "Factura2" => 0,
						"Factura3" => 0, "Factura4" => 0, "Importe" => 0,
						"Importe2" => 0, "Importe3" => 0, "Importe4" => 0
					);

					$this->Mdl_pedidos->savePedidos($arreglo);
					$this->Mdl_pedidos->saveDetallesPedido($data2);
					unlink($nombreArchivo);
					return 1;
				} else {
					unlink($nombreArchivo);
					return 4;
				}
			} else {
				unlink($nombreArchivo);
				return 3;
			}
		} else {
			unlink($nombreArchivo);
			return 2;
		}
	}

	public function store()
	{
		$id_plaza = $this->input->post("plaza_id");
		$nombreArchivo = trim(str_replace(" ", "_", $_FILES['pedido_file']['name']));
		$carpeta = $this->_obtenerCarpetaPlaza($id_plaza);

		$config["upload_path"] = "./assets/filesPedido/" . $carpeta;
		$config["max_size"] = 2048;
		$config["allowed_types"] = "*";
		$config['overwrite'] = TRUE;
		$this->load->library("upload", $config);

		$datos = array('carpeta' => $carpeta);

		if(!$this->upload->do_upload('pedido_file')) {
			echo $this->upload->display_errors();
		} else {
			$pedido = $this->procesar($datos, $id_plaza, $nombreArchivo);

			switch($pedido) {
				case 0: $this->session->set_flashdata("error", "No se encontro el archivo"); break;
				case 1: $this->session->set_flashdata("message", "Pedido Registrado Correctamente"); break;
				case 2: $this->session->set_flashdata("error", "La plaza seleccionada y la del archivo no coinciden"); break;
				case 3: $this->session->set_flashdata("error", "La fecha del archivo Excel no tiene el formato correcto."); break;
				case 4: $this->session->set_flashdata("error", "No se puede subir el mismo pedido dos veces."); break;
			}
			redirect(base_url() . "Pedidos/add");
		}
	}

	public function storeFacturaPasteleria()
	{
		$plaza_id = $this->session->userdata("plaza");
		if($this->input->post("editar")){
			$fechaObj = $this->Mdl_pedidos->consultarFechaUltimoPedidoPasteleria($plaza_id);
			$fechaIngreso = $fechaObj ? $fechaObj->Fecha : null;
			$data = array("Estatus_Factura" => 0);
			if($this->Mdl_pedidos->actualizarFacturaPasteleria($fechaIngreso, $plaza_id, $data)){
				$this->listManagerPasteleria();
			}
		}
		else if($this->input->post("guardar")){
			$factura = $this->input->post("factura");
			$importe = (float)$this->input->post("importe");
			$fechaIngreso = $this->input->post("fechaIngreso");
			$fechaRecepcion = $this->input->post("fechaRecepcion");

			$this->form_validation->set_rules("factura", "factura", "required");
			$this->form_validation->set_rules("importe", "importe", "required");

			if(is_numeric($factura) && $factura > 0 && is_numeric($importe) && $importe > 0) {
				if($this->form_validation->run()){
					$data = array(
						'Factura' => $factura,
						"Importe" => $importe,
						"Fecha_Recepcion" => $fechaRecepcion,
						"Estatus_Factura" => 1
					);
					$data2 = array('Factura' => $factura);

					if($this->Mdl_pedidos->actualizarFacturasPasteleria($fechaIngreso, $plaza_id, $data, $data2)){
						$this->session->set_flashdata("message", "Datos Insertados");
						redirect(base_url() . "Pedidos/listManagerPasteleria");
					}
				}
			} else {
				$this->session->set_flashdata("error", "Los números no pueden ser negativos");
				redirect(base_url() . "Pedidos/listManagerPasteleria");
			}
		}
	}

	public function storePasteleria()
	{
		$plaza_id = $this->input->post("plaza_id");
		$insumo_id = $this->input->post("insumo_id");
		$cantidad = $this->input->post("cantidad");
		$fecha = $this->input->post("fecha");

		$doble = $this->Mdl_pedidos->consultarPedidoDuplicadoPasteleria($fecha, $plaza_id);
		if($this->input->post("agregar")){
			if($doble == true){
				$plazaDestino = $this->Mdl_pedidos->getInsumosPedidoPasteleria();
				if($plazaDestino != null){
					$plazaComparacion = $plazaDestino[0]->plaza_id ?? 0;
					$fechaComparacion = $plazaDestino[0]->Fecha ?? "";

					if($plazaComparacion == $plaza_id && $fechaComparacion == $fecha){
						$data = array("Fecha" => $fecha, "plaza_id" => $plaza_id, "insumo_id" => $insumo_id, "Cantidad" => $cantidad);
						if($this->Mdl_pedidos->addInsumoPedidoPasteleria($data)){
							$this->session->set_flashdata("message", "Insumo agregado al pedido");
						} else {
							$this->session->set_flashdata("error", "Hubo un error al insertar el insumo");
						}
					} else {
						$this->session->set_flashdata("error", "Ha seleccionado una plaza diferente para el pedido o ha cambiado la fecha.");
					}
				} else {
					$data = array("Fecha" => $fecha, "plaza_id" => $plaza_id, "insumo_id" => $insumo_id, "Cantidad" => $cantidad);
					if($this->Mdl_pedidos->addInsumoPedidoPasteleria($data)){
						$this->session->set_flashdata("message", "Insumo agregado al pedido");
					} else {
						$this->session->set_flashdata("error", "Hubo un error al insertar el insumo");
					}
				}
			} else {
				$this->session->set_flashdata("error", "No es posible agregar dos pedidos el mismo día en una plaza");
			}
			redirect(base_url() . "Pedidos/addPasteleria");
		}
	}

	public function terminarPedidoPasteleria()
	{
		$this->_requireAjax();
		$resultado = $this->Mdl_pedidos->getInsumosPedidoPasteleria();
		if($resultado != null){
			$arrayP = array();
			$plaza_id = 0;
			$fecha = "";
			$i = 0;

			foreach ($resultado as $key) {
				$arrayP[] = array(
					"Fecha" => $key->Fecha,
					"plaza_id" => $key->plaza_id,
					"insumo_id" => $key->insumo_id,
					"Cantidad" => $key->Cantidad,
					"Cantidad_Recibida" => 0,
					"Cantidad_Final" => 0,
					"Bandera" => 0
				);
				$plaza_id = $key->plaza_id;
				$fecha = $key->Fecha;
				$i++;
			}

			if($this->Mdl_pedidos->savePedidoPasteleria($arrayP)){
				$data = array(
					"Fecha" => $fecha, "plaza_id" => $plaza_id,
					"Insumos" => $i, "Estatus" => 0
				);
				if($this->Mdl_pedidos->saveDetallesPedidoPasteleria($data)){
					echo $this->Mdl_pedidos->deleteTempPasteleria() ? 1 : 0;
				} else {
					echo 0;
				}
			} else {
				echo 0;
			}
		} else {
			echo 2;
		}
	}

	public function storeFacturaAjax()
	{
		$this->_requireAjax();

		$fechaEmision = $this->input->post("fecha_emision_factura_guardar");
		$fechaRecepcion = $this->input->post("fecha_recepcion_factura_guardar");
		$plaza_id = $this->input->post("plaza_id_factura_guardar");

		$facturaUno = $this->input->post("factura_guardar_uno");
		$importeUno = $this->input->post("importe_guardar_uno");
		$facturaDos = $this->input->post("factura_guardar_dos");
		$importeDos = $this->input->post("importe_guardar_dos");
		$facturaTres = $this->input->post("factura_guardar_tres");
		$importeTres = $this->input->post("importe_guardar_tres");
		$facturaCuatro = $this->input->post("factura_guardar_cuatro");
		$importeCuatro = $this->input->post("importe_guardar_cuatro");

		if (is_numeric($facturaUno) && $facturaUno >= 0 && is_numeric($importeUno) && $importeUno >= 0) {
			$data = array(
				'Fecha' => $fechaEmision,
				'Fecha_Recepcion' => $fechaRecepcion,
				'plaza_id' => $plaza_id,
				'Cantidad' => 0,
				'Estatus' => 1,
				'Estatus_Factura' => 1,
				'Liberado' => 1,
				'Factura' => $facturaUno,
				'Factura2' => $facturaDos,
				'Factura3' => $facturaTres,
				'Factura4' => $facturaCuatro,
				"Importe" => $importeUno,
				"Importe2" => $importeDos,
				"Importe3" => $importeTres,
				"Importe4" => $importeCuatro
			);
			echo $this->Mdl_pedidos->guardarFacturaAjax($data) ? 1 : 0;
		} else {
			echo 0;
		}
	}

	public function actualizarFacturaAjax()
	{
		$this->_requireAjax();

		$idFactura = $this->input->post("code_factura");
		$fechaEmision = $this->input->post("fecha_emision_factura_editar");
		$fechaRecepcion = $this->input->post("fecha_recepcion_factura_editar");

		$facturaUno = $this->input->post("factura_editar_uno");
		$importeUno = $this->input->post("importe_editar_uno");
		$facturaDos = $this->input->post("factura_editar_dos");
		$importeDos = $this->input->post("importe_editar_dos");
		$facturaTres = $this->input->post("factura_editar_tres");
		$importeTres = $this->input->post("importe_editar_tres");
		$facturaCuatro = $this->input->post("factura_editar_cuatro");
		$importeCuatro = $this->input->post("importe_editar_cuatro");

		if (is_numeric($facturaUno) && $facturaUno >= 0 && is_numeric($importeUno) && $importeUno >= 0) {
			$data = array(
				'Fecha' => $fechaEmision,
				'Fecha_Recepcion' => $fechaRecepcion,
				'Factura' => $facturaUno,
				'Factura2' => $facturaDos,
				'Factura3' => $facturaTres,
				'Factura4' => $facturaCuatro,
				"Importe" => $importeUno,
				"Importe2" => $importeDos,
				"Importe3" => $importeTres,
				"Importe4" => $importeCuatro
			);
			echo $this->Mdl_pedidos->actualizarFacturaAjax($idFactura, $data) ? 1 : 0;
		} else {
			echo 0;
		}
	}

	public function eliminarFacturaAjax()
	{
		$this->_requireAjax();
		$id = $this->input->post("id_factura");
		echo $this->Mdl_pedidos->deleteDetalles($id) ? 1 : 0;
	}

	public function eliminarPedidoAjax()
	{
		$this->_requireAjax();
		$id = $this->input->post("id_pedido");
		$fecha = $this->input->post("fecha");
		$plaza_id = $this->input->post("plaza_id");

		echo $this->Mdl_pedidos->eliminarPedidoCompleto($fecha, $plaza_id, $id) ? 1 : 0;
	}

	public function recepcionPedido()
	{
		$estadoCaptura = 0;
		$estadoPedidos = 0;
		$pedidos = "";
		$fechaEmision = "";
		$plaza_id = $this->session->userdata("plaza");
		$fechas = $this->Mdl_pedidos->consultarFechasPedido($plaza_id);

		if($fechas != null){
			foreach ($fechas as $key) {
				if($this->Mdl_pedidos->consultarCapturaActual($key->Fecha, $plaza_id)){
					$estadoCaptura = 1;
					$fechaEmision = $key->Fecha;
					$pedidos = $this->Mdl_pedidos->getPedidoManager($key->Fecha, $plaza_id);
					break;
				}
			}
			$estadoPedidos = 1;
		}

		if($this->input->post("guardar")){
			$factura = $this->input->post("factura");
			$importe = (float)$this->input->post("importe");
			$factura2 = $this->input->post("factura2");
			$importe2 = (float)$this->input->post("importe2");
			$factura3 = $this->input->post("factura3");
			$importe3 = (float)$this->input->post("importe3");
			$factura4 = $this->input->post("factura4");
			$importe4 = (float)$this->input->post("importe4");
			$fechaIngreso = $this->input->post("fechaIngreso");
			$fechaRecepcion = $this->input->post("fechaRecepcion");

			if(is_numeric($factura) && $factura >= 0 && is_numeric($importe) && $importe >= 0 &&
				is_numeric($factura2) && $factura2 >= 0 && is_numeric($importe2) && $importe2 >= 0)
			{
				$data = array(
					'Factura' => $factura, 'Factura2' => $factura2, 'Factura3' => $factura3, 'Factura4' => $factura4,
					"Importe" => $importe, "Importe2" => $importe2, "Importe3" => $importe3, "Importe4" => $importe4,
					"Fecha_Recepcion" => $fechaRecepcion, "Estatus_Factura" => 1
				);
				$data2 = array(
					'Factura' => $factura, 'Factura2' => $factura2, 'Factura3' => $factura3, 'Factura4' => $factura4
				);

				if($this->Mdl_pedidos->actualizarFacturas($fechaIngreso, $plaza_id, $data, $data2)){
					$this->session->set_flashdata("message", "Datos Insertados");
					redirect(base_url() . "Pedidos/recepcionPedido");
				}
			}
		}

		$data = array(
			'fechas' => $fechas,
			'estadoCaptura' => $estadoCaptura,
			'estadoPedidos' => $estadoPedidos,
			'pedidos' => $pedidos,
			'fechaEmision' => $fechaEmision,
			'numero' => empty($fechaEmision) ? 0 : $this->Mdl_backend->rowCountFecha("tbl_pedidos", $fechaEmision, $plaza_id),
			'miPedido' => empty($fechaEmision) ? [] : $this->Mdl_pedidos->miPedido($fechaEmision, $plaza_id)
		);

		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("manager/pedidos/nuevo_panel", $data);
		$this->load->view("layouts/footer");
	}

	public function cambiarPedidoAjax()
	{
		$this->_requireAjax();
		$fecha = $this->input->post("fecha");
		$plaza_id = $this->input->post("plaza_id");

		$data = array("Factura" => '', "Factura2" => '', "Factura3" => '', "Factura4" => '', "Cantidad_Inventario" => 0, "Cantidad_Final" => 0, "Bandera" => 0, "Completo" => 0);
		$data2 = array("Fecha_Recepcion" => '0000-00-00', "Estatus" => 0, "Estatus_Factura" => 0, "Liberado" => 0, "Factura" => 0, "Factura2" => 0, "Factura3" => 0, "Factura4" => 0, "Importe" => 0, "Importe2" => 0, "Importe3" => 0, "Importe4" => 0);

		echo $this->Mdl_pedidos->reiniciarPedido($fecha, $plaza_id, $data, $data2) ? 1 : 0;
	}

	public function faltantesPedido()
	{
		$arregloExperimental = $this->Mdl_pedidos->getFaltantes();
		$plazas = $this->Mdl_plazas->getPlazas();
		$arregloFinalPedido = array();

		foreach ($arregloExperimental as $i => $item) {
			$arregloFinalPedido[$i] = (array) $item;
			$fecha_recepcion = $this->Mdl_pedidos->consultarFechaRecepcionPedido($item->Factura);
			$arregloFinalPedido[$i]["Fecha_Recepcion"] = ($fecha_recepcion != false) ? $fecha_recepcion->Fecha_Recepcion : "";
		}

		$data = array('faltantes' => $arregloFinalPedido, 'plazas' => $plazas);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("administrador/pedidos/list_faltantes", $data);
		$this->load->view("layouts/footer");
	}

	public function faltantesPedidoTabla($plaza_id)
	{
		$this->_requireAjax();
		$arregloExperimental = ($plaza_id == 0) ? $this->Mdl_pedidos->getFaltantes() : $this->Mdl_pedidos->getFaltantesPlaza($plaza_id);
		$arregloFinalPedido = array();

		foreach ($arregloExperimental as $i => $item) {
			$arregloFinalPedido[$i] = (array) $item;
			$fecha_recepcion = $this->Mdl_pedidos->consultarFechaRecepcionPedido($item->Factura);
			$arregloFinalPedido[$i]["Fecha_Recepcion"] = ($fecha_recepcion != false) ? $fecha_recepcion->Fecha_Recepcion : "";
		}

		echo json_encode([['faltantes' => $arregloFinalPedido]]);
	}

	public function faltantesPedidoCount()
	{
		$this->_requireAjax();
		echo json_encode([['data' => $this->Mdl_pedidos->getFaltantesCount()]]);
	}

	public function agregarInventarioInsumoFaltantePedido()
	{
		$this->_requireAjax();
		$id = $this->input->post("id");
		$cantidad_pedido = $this->input->post("cantidad_pedido");
		$cantidad_inventario = $this->input->post("cantidad_inventario");
		$cantidad_agregar = $this->input->post("cantidad_agregar");
		$plaza_id = $this->input->post("plaza_id");
		$insumo_id = $this->input->post("insumo_id");

		$cantidadFinalSumada = $cantidad_inventario + $cantidad_agregar;
		$bandera = ($cantidadFinalSumada == $cantidad_pedido) ? 1 : 3;
		$completo = ($cantidadFinalSumada == $cantidad_pedido) ? 1 : 0;

		$cantidadFaltante = $this->conversorPedido($insumo_id, $cantidad_agregar);
		$cantidadFinalFaltante = $this->conversorPedido($insumo_id, $cantidadFinalSumada);

		$cantidadActualInvProd = $this->consultarCantidadInsumoInventario($insumo_id, $plaza_id);

		if($cantidadActualInvProd != null){
			$cantidadFaltante += $cantidadActualInvProd;
			$arrayInvProd = array('Cantidad' => $cantidadFaltante);

			if($this->Mdl_inventario->actualizarCantidad($insumo_id, $plaza_id, $arrayInvProd)){
				$arrayPedidos = array("Completo" => $completo, "Cantidad_Inventario" => $cantidadFinalSumada, "Cantidad_Final" => $cantidadFinalFaltante, "Bandera" => $bandera);
				if($this->Mdl_pedidos->actualizarEstadoCompletoPedido($id, $arrayPedidos)){
					echo json_encode(['id' => $id, "msj" => "Actualice todo correctamente inventario y estado completo :D", 'value' => true]);
				} else {
					echo json_encode(['id' => $id, "msj" => "No se pudo actualizar el estado a completo", 'value' => false]);
				}
			} else {
				echo json_encode(['id' => $id, "msj" => "No se pudo actualizar el inventario", 'value' => false]);
			}
		} else {
			$arrayPedidos = array("Completo" => $completo, "Cantidad_Inventario" => $cantidadFinalSumada, "Cantidad_Final" => $cantidadFinalFaltante, "Bandera" => $bandera);
			if($this->Mdl_pedidos->actualizarEstadoCompletoPedido($id, $arrayPedidos)){
				echo json_encode(['id' => $id, "msj" => "Insumo actualizado a completo :D", 'value' => true]);
			} else {
				echo json_encode(['id' => $id, "msj" => "No se pudo actualizar el estado a completo", 'value' => false]);
			}
		}
	}

	public function eliminarInventarioInsumoFaltantePedido()
	{
		$this->_requireAjax();
		$id = $this->input->post("id");
		$arrayPedidos = array("Completo" => 1);
		if($this->Mdl_pedidos->actualizarEstadoCompletoPedido($id, $arrayPedidos)){
			echo json_encode(['id' => $id, "msj" => "Insumo actualizado a completo :D", 'value' => true]);
		} else {
			echo json_encode(['id' => $id, "msj" => "No se pudo actualizar el estado a completo", 'value' => false]);
		}
	}

	public function faltantesPedidoManager()
	{
		$plaza_id = $this->session->userdata("plaza");
		$data = array('faltantes' => $this->Mdl_pedidos->getFaltantesManager($plaza_id));
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("manager/pedidos/list_faltantes", $data);
		$this->load->view("layouts/footer");
	}

	public function addFranquicia()
	{
		$plaza_id = 0;
		$insumo_id = 0;
		$categoria_id = 0;
		$fecha = date("Y-m-d");
		$plazaDestino = $this->Mdl_pedidos->getInsumosPedidoFranquicia();

		if($plazaDestino != null) {
			foreach ($plazaDestino as $key) {
				$plaza_id = $key->plaza_id;
				$insumo_id = $key->insumo_id;
				$fecha = $key->Fecha;
			}
		}

		$data = array(
			'plazas' => $this->Mdl_plazas->getPlazas(),
			'pedidos' => $this->Mdl_pedidos->getInsumosPedidoFranquicia(),
			'insumos' => $this->Mdl_productos->getInsumosInventario(),
			'plaza_id' => $plaza_id,
			'insumo1' => $insumo_id,
			'categoria1' => $categoria_id,
			'fecha' => $fecha,
			'misPedidos' => $this->Mdl_pedidos->getDetallesPedidoFranquicia(),
			'liberados' => $this->Mdl_pedidos->getDetallesPedidoLiberadoPasteleria()
		);

		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("administrador/pedidos/add_franquicia", $data);
		$this->load->view("layouts/footer");
	}

	public function storeFranquicia()
	{
		$fecha = $this->input->post("fecha");
		$plaza_id = $this->input->post("plaza_id");
		$insumo_id = $this->input->post("insumo_id");
		$cantidad = $this->input->post("cantidad");

		$doble = $this->Mdl_pedidos->consultarPedidoDuplicadoFranquicia($fecha, $plaza_id);
		if($this->input->post("agregar")){
			if($doble == true){
				$plazaDestino = $this->Mdl_pedidos->getInsumosPedidoFranquicia();
				if($plazaDestino != null){
					$plazaComparacion = $plazaDestino[0]->plaza_id ?? 0;
					$fechaComparacion = $plazaDestino[0]->Fecha ?? "";

					if($plazaComparacion == $plaza_id && $fechaComparacion == $fecha){
						$data = array("Fecha" => $fecha, "plaza_id" => $plaza_id, "insumo_id" => $insumo_id, "Cantidad" => $cantidad);
						if($this->Mdl_pedidos->addInsumoPedidoFranquicia($data)){
							$this->session->set_flashdata("message", "Insumo agregado al pedido");
						} else {
							$this->session->set_flashdata("error", "Hubo un error al insertar el insumo");
						}
					} else {
						$this->session->set_flashdata("error", "Ha seleccionado una plaza diferente o cambiado la fecha");
					}
				} else {
					$data = array("Fecha" => $fecha, "plaza_id" => $plaza_id, "insumo_id" => $insumo_id, "Cantidad" => $cantidad);
					if($this->Mdl_pedidos->addInsumoPedidoFranquicia($data)){
						$this->session->set_flashdata("message", "Insumo agregado al pedido");
					} else {
						$this->session->set_flashdata("error", "Hubo un error al insertar el insumo");
					}
				}
			} else {
				$this->session->set_flashdata("error", "No es posible agregar dos pedidos el mismo día en una plaza");
			}
			redirect(base_url() . "Pedidos/addFranquicia");
		}
	}

	public function eliminarInsumoFranquicia()
	{
		$this->_requireAjax();
		$code = $this->input->post("code");
		echo $this->Mdl_pedidos->eliminarInsumoTempFranquicia($code) ? 1 : 0;
	}

	public function terminarPedidoFranquicia()
	{
		$this->_requireAjax();
		$resultado = $this->Mdl_pedidos->getInsumosPedidoFranquicia();
		if($resultado != null){
			$arrayP = array();
			$plaza_id = 0;
			$fecha = "";
			$i = 0;

			foreach ($resultado as $key) {
				$arrayP[] = array(
					"Fecha" => $key->Fecha,
					"plaza_id" => $key->plaza_id,
					"insumo_id" => $key->insumo_id,
					"Clave" => 'NO',
					"Nombre" => 'NO2',
					"Cantidad_Pedido" => $key->Cantidad
				);
				$plaza_id = $key->plaza_id;
				$fecha = $key->Fecha;
				$i++;
			}

			if($this->Mdl_pedidos->savePedidoFranquicia($arrayP)){
				$data = array(
					"Fecha" => $fecha, 'Fecha_Recepcion' => '0000-00-00', "plaza_id" => $plaza_id,
					"Cantidad" => $i, "Estatus" => 0, "Factura" => 0, "Factura2" => 0, "Factura3" => 0,
					"Factura4" => 0, "Importe" => 0, "Importe2" => 0, "Importe3" => 0, "Importe4" => 0
				);
				if($this->Mdl_pedidos->saveDetallesPedidoFranquicia($data)){
					echo $this->Mdl_pedidos->deleteTempFranquicia() ? 1 : 0;
				} else {
					echo 0;
				}
			} else {
				echo 0;
			}
		} else {
			echo 2;
		}
	}

	private function consultarCantidadInsumoInventario($insumo_id, $plaza_id)
	{
		$reportes = $this->Mdl_inventario->getCantidad($insumo_id, $plaza_id);
		return $reportes ? $reportes->Cantidad : null;
	}
}
