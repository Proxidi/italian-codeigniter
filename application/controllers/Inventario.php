<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Inventario extends CI_Controller
{

	private $permisos;

	public function __construct()
	{
		parent::__construct();

		// 1. Validar sesión activa para cualquier petición
		if (!$this->session->userdata("login")) {
			redirect(base_url());
		}

		// 2. Solo validar permisos de menú si es navegación web (ignorar peticiones AJAX internas)
		if (!$this->input->is_ajax_request()) {
			$this->permisos = $this->backend_lib->control();
		}

		$this->load->model('Mdl_productos');
		$this->load->model('Mdl_inventario');
		$this->load->model('Mdl_plazas');
		$this->load->model('Mdl_ventas');
		$this->load->model('Mdl_backend');
		$this->load->model('Mdl_remesas');
		$this->load->model('Mdl_pedidos');
		$this->load->model('Mdl_opciones');
		$this->load->library('encryption');
	}

	//VISTA DEL PANEL ADMINISTRATIVO CON DIFERENTES OPCIONES
	public function index()
	{
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("administrador/inventario/panel_inventario");
		$this->load->view("layouts/footer");
	}

	//VISTA DEL PANEL DEL MANAGER CON DIFERENTES OPCIONES
	public function indexManager()
	{
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("manager/reportes/inventario/panel_inventario");
		$this->load->view("layouts/footer");
	}

	//ACTUALIZACIÓN DE STOCKS PARA LOS PRODUCTOS INVENTARIADOS
	public function actualizarStock()
	{
		if ($this->input->is_ajax_request()) {
			$plaza_id = $this->input->post("plaza_id_stock");
			$stockMinimo = $this->input->post("stockMinimo");
			$stockMedio = $this->input->post("stockMedio");
			$insumo_id = $this->input->post("insumo_id");
			$bandera = $this->input->post("bandera");

			if (is_numeric($stockMinimo)) {
				$data = array("stock_minimo" => $stockMinimo, "stock_medio" => $stockMedio);
				if ($this->Mdl_inventario->actualizarStock($insumo_id, $plaza_id, $data)) {
					if ($bandera == 1) {
						echo $this->Mdl_inventario->getStocksAJAXPlaza($plaza_id);
					} else if ($bandera == 0) {
						echo $this->Mdl_inventario->getStocksAJAX();
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


	//CAPTURA DEL INVENTARIO FÍSICO PARA MANAGERS
	public function add()
	{
		$plaza_id = $this->session->userdata("plaza");
		$bandera = 0;
		$envio = 0;
		$inventario = 0;
		$notas = "";
		$ayer = date('Y-m-d', strtotime("-1 days"));

		$fechas = $this->_obtenerRangoFechasInventario();
		$FirstDay = $fechas['FirstDay'];
		$LastDay = $fechas['LastDay'];

		$enviado = $this->Mdl_inventario->getExistencia($plaza_id, $FirstDay, $LastDay);
		if (date('D') == 'Sun' || date('D') == 'Mon') {
			$bandera = 1;
			if ($enviado != null) {
				if ($enviado->Correcto == 1) {
					$notas = $enviado->Notas;
					$envio = 1;
					$bandera = 0;
					$inventario = $this->Mdl_inventario->getEstatusCIF2($FirstDay, $LastDay, $plaza_id);
					if ($inventario != null) {
						$inventario = $inventario->Inventario;
						$notas = $enviado->Notas;
					} else {
						$inventario = 0;
						$notas = $enviado->Notas;
					}
				} else {
					$envio = 0;
					$notas = $enviado->Notas;
				}
			}
		} else {
			$bandera = 0;
		}

		$data = array(
			'capturas' => $this->Mdl_inventario->getCapturaInventario($plaza_id),
			'miCaptura' => $this->Mdl_inventario->getCapturaInventarioPlaza2($FirstDay, $LastDay, $plaza_id),
			'numero' => $this->Mdl_backend->rowCount("tbl_captura_inventario", $plaza_id),
			'bandera' => $bandera,
			'envio' => $envio,
			'inventario' => $inventario,
			'notas' => $notas
		);


		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("manager/reportes/inventario/add", $data);
		$this->load->view("layouts/footer");
	}

	public function liberarInventarioFisico()
	{
		if ($this->input->is_ajax_request()) {
			$plaza_id = $this->input->post("plaza_id");
			$usuario_id = $this->session->userdata("id");
			$notas = $this->input->post("notas");

			$fechas = $this->_obtenerRangoFechasInventario();
			$FirstDay = $fechas['FirstDay'];
			$LastDay = $fechas['LastDay'];

			$enviado = $this->Mdl_inventario->getExistenciaSemana($FirstDay, $LastDay, $plaza_id);
			if ($enviado != null) {
				//EL REGISTRO YA EXISTE
				//echo "El registro ya existe Acción: ACTUALIZAR";
				echo 2;
			} else {
				//PROCEDEMOS A INSERTAR UN NUEVO REGISTRO
				//echo "El registro no existe. Acción: INSERTAR";
				$data = array(
					'Fecha' => date("Y-m-d"),
					'Semana' => $this->getWeeks(date("Y-m-d"), "sunday"),
					'Hora' => date('H:i:s'),
					'plaza_id' => $plaza_id,
					'usuario_id' => $usuario_id,
					'Insumos' => 118,
					'Correcto' => 1,
					"Notas" => $notas
				);
				if ($this->Mdl_inventario->saveDetallesInventarioFisico($data)) {
					echo 1;
				} else {
					echo 0;
				}
			}
		} else {
			redirect(base_url() . "Inicio");
		}
	}

	public function listAdminF()
	{
		// 1. Recibir parámetros
		$plazaId = $this->input->post("plaza_id");
		$insumoId = $this->input->post("insumo_gasto_remesa_id");
		$buscar = $this->input->post("buscar");

		// 2. Calcular fechas base
		[$fechaInicio, $fechaFin] = $this->_obtenerRangoFechasInventario();

		// 3. Validar estado de liberaciones (Si hay 7, bandera es true)
		$liberaciones = $this->Mdl_inventario->getLiberaciones2($fechaInicio, $fechaFin);
		$todasLiberadas = (sizeof($liberaciones) == 7);

		// 4. Obtener los datos del inventario según los filtros
		if ($buscar) {
			$datosInventario = $this->_obtenerDatosInventarioListF($fechaInicio, $fechaFin, $todasLiberadas, $plazaId, $insumoId);
		} else {
			// Comportamiento por defecto al cargar la página sin buscar
			$datosInventario = $this->_obtenerDatosInventarioListF($fechaInicio, $fechaFin, $todasLiberadas, "", "");
		}

		// 5. Determinar mensajes (si hay plaza, se traen los específicos, si no, los generales)
		$mensajes = empty($plazaId)
			? $this->Mdl_inventario->getMensajes2($fechaInicio, $fechaFin)
			: $this->Mdl_inventario->getMensajesPlaza2($fechaInicio, $fechaFin, $plazaId);

		// 6. Construir el arreglo de datos UNA SOLA VEZ
		$data = array(
			'inventario_productos' => $datosInventario,
			'plazas' => $this->Mdl_plazas->getPlazas(),
			'insumos' => $this->Mdl_productos->getInsumosInventario(), // Eliminada la duplicidad que existía
			'notificaciones' => $this->Mdl_inventario->getNotificaciones(),
			'mensajes' => $mensajes,
			'insumo1' => $insumoId,
			'id' => $plazaId
		);

		// 7. Cargar las vistas
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("administrador/inventario/ifisico/listF", $data);
		$this->load->view("layouts/footer");
	}

	public function liberarInventarioFisicoAdmin()
	{
		if ($this->input->is_ajax_request()) {

			$plaza_id = $this->input->post("plaza_id");
			$fecha = date("Y-m-d");

			$fechas = $this->_obtenerRangoFechasInventario();
			$FirstDay = $fechas['FirstDay'];
			$LastDay = $fechas['LastDay'];

			// obtener la captura del inventario físico de una plaza
			$resultado = $this->Mdl_inventario->getTotalCapturaInventario($plaza_id);

			$arregloResumen2 = array();
			$arregloResumen3 = array();
			$arregloValoresEstimados = array();

			// recorrer la captura del inventario físico de la plaza
			for ($i = 0; $i < sizeof($resultado); $i++) {

				$dataHistorial = array(
					'Fecha' => $fecha,
					'Semana' => $this->getWeeks($fecha, "sunday"),
					'plaza_id' => $resultado[$i]->plaza_id,
					'insumo_id' => $resultado[$i]->insumo_id,
					'Bodega' => $resultado[$i]->Bodega,
					'Unidad_Bodega' => $resultado[$i]->Unidad_Bodega,
					"Piso" => $resultado[$i]->Piso,
					"Unidad_Piso" => $resultado[$i]->Unidad_Piso,
					"Total" => $resultado[$i]->Total,
					"Unidad_Total" => $resultado[$i]->Unidad_Total
				);

				$arregloResumen3[$i] = $dataHistorial;

				//ESTA LINEA DE CÓDIGO SIRVE PARA EVITAR QUE EL PRODUCTO MOKA Y LAS MEZCLAS SEAN CONTABILIZADAS
				if ($resultado[$i]->Centinela != 0) {
					//OBTENEMOS EL INSUMO ID DE LOS PRODUCTOS DEL INVENTARIO FISICO
					$insumo_id = $resultado[$i]->insumo_id;
					//CONSULTADOS CUANTO HAY DE ESTE INSUMO EN EL INVENTARIO DE PRODUCCIÓN ACTUAL
					$valorEstimado = $this->consultarCantidad($insumo_id, $plaza_id);
					//GUARDAMOS EN UN ARREGLO LOS VALORES DEL INVENTARIO DE PRODUCCIÓN
					$arregloValoresEstimados[$i] = $valorEstimado;
					//EN DADO CASO DE QUE EL INSUMO SEAN LAS SERVILLETAS
					if ($insumo_id == 56) {
						//LAS SERVILLETAS SE INVENTARIAN POR PIEZAS POR ELLO SE CONVIERTE A PAQUETES DE 200 PIEZAS
						$valorEstimado = ($valorEstimado / 200);
						//GENERAMOS EL QUEBRANTO ENTRE LO QUE SE CAPTURO EN EL INVENTARIO FISICO: $resultado[$i]->Total
						//Y LO QUE HAY EN EL INVENTARIO DE PRODUCCIÓN: $valorEstimado y después
						$quebranto = round($resultado[$i]->Total - $valorEstimado, 2);
					} //EN DADO CASO DE QUE SEA OTRO INSUMO DESCONTAMOS LO QUE SE CAPTURO EN EL INVENTARIO FISICO DEL VALOR ESTIMADO EN LA PRODUCCIÓN
					else {
						$quebranto = round($resultado[$i]->Total - $valorEstimado, 2);
					}

					//EN ESTA PARTE CREAMOS EL ARREGLO PARA ACTUALIZAR LA CANTIDAD DEL INVENTARIO DE PRODUCCIÓN
					//A LA CAPTURA QUE SE LLEVO A CABO EN EL INVENTARIO FISICO
					//EN DADO CASO DE QUE SEAN LAS SERVILLETAS LO MULTIPLICAMOS POR 200 DEBIDO  A QUE ESTA GUARDADO
					//EN PAQUETES PERO SE DEBE DE INVENTARIAR DE UNO POR UNO
					if ($insumo_id == 56) {
						$data = array('Cantidad' => $resultado[$i]->Total * 200);
					} //EN DADO CASO DE QUE SEA OTRO INSUMO SIMPLEMENTE ACTUALIZAMOS LA CANTIDAD
					else {
						$data = array('Cantidad' => $resultado[$i]->Total);
					}

					//ESTE ARREGLO VA GUARDANDO LOS QUEBRANTOS DE CADA UNO DE LOS INSUMOS
					$data2 = array('Fecha' => $fecha, 'insumo_id' => $insumo_id, 'plaza_id' => $plaza_id, 'Cantidad' => $quebranto);
					//$arregloResumen[$i]=$data;

					//FUNCÍÓN PARA ACTUALIZAR LA CANTIDAD DEL INVENTARIO FISICO AL DE PRODUCCIÓN
					$this->Mdl_inventario->actualizarCantidad($insumo_id, $plaza_id, $data);

					//VAMOS CONCATENANDO LOS QUEBRANTOS EN UN ARREGLO DE ARREGLOS
					$arregloResumen2[$i] = $data2;
				}
			}
			//EN ESTA PARTE SE TERMINA DE RECORRER LA CAPTURA DEL INVENTARIO FISICO Y YA SE ACTUALIZO EL INVENTARIO
			//DE PRODUCCIÓN AÚN FALTA GUARDAR LOS QUEBRANTOS

			//EN UNA INSERCIÓN POR LOTES SE GUARDAN LOS QUEBRANTOS DE LA PLAZA ENTRE
			//EL INVENTARIO FISICO Y DE PRODUCCCIÓN
			if ($this->Mdl_inventario->saveQuebrantos($arregloResumen2)) {
				//GUARDAMOS EL ARREGLO QUE CONTIENE LOS DATOS DE LA CAPTURA DEL INVENTARIO FISICO
				//SE GUARDA PARA POSTERIORMENTE PORDERSE CONSULTAR EN EL HISTORIAL
				if ($this->Mdl_inventario->saveHistorialInventarioFisico($arregloResumen3)) {
					//ARREGLO PARA RESETEAR LA CAPTURA DE INVENTARIO FISICO DE LA PLAZA UNA VEZ QUE HA SIDO LIBERADA
					$data = array(
						'Bodega' => 0, 'Piso' => 0, 'Total' => 0, 'Bandera' => 0
					);
					if ($this->Mdl_inventario->liberarCaptura($plaza_id, $data)) {
						//UNA VEZ QUE SE LIBERA LA CAPTURA EL CAMPO INVENTARIO SE DEBE DE VOLVER 1 EN CASO DE QUE SEA CORRECTO RETORNAMOS UN 1
						$data = array("Inventario" => 1);
						if ($this->Mdl_inventario->updateDetallesInventarioFisicoSemana($FirstDay, $LastDay, $plaza_id, $data)) {
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

	//CARGA DEL ARCHIVO DLC PLATILLOS VENDIDOS
	public function addDLC()
	{
		$plaza_id = $this->session->userdata("plaza");
		$data = array(
			'platillos' => $this->Mdl_inventario->getPlatillosPlaza($plaza_id)
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("manager/reportes/inventario/list", $data);
		$this->load->view("layouts/footer");
	}

	//RETORNO DE LA TABLA DE CAPTURA INVENTARIA MAQUETADA PARA ACCIÓN CON AJAX
	private function ajax()
	{
		$plaza_id = $this->session->userdata("plaza");
		$valor = $this->Mdl_inventario->getCapturaInventario2($plaza_id);
		return $valor;
	}

	//MÉTODO PARA ACTUALIZAR LA CANTIDAD DE UN INSUMO EN EL INVENTARIO DE PRODUCCIÓN
	public function actualizarCantidadProduccion()
	{
		if ($this->input->is_ajax_request()) {
			$plaza_id = $this->input->post("plaza_id_modal");
			$insumo_id = $this->input->post("insumo_id_modal");
			$cantidad = $this->input->post("cantidad_modal");

			if (is_numeric($cantidad)) {
				$data = array("Cantidad" => $cantidad);
				if ($this->Mdl_inventario->actualizarCantidad($insumo_id, $plaza_id, $data)) {
					echo 1;
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

	//MÉTODO QUE SE EJECUTA CADA VEZ QUE COLOCAMOS PISO Y BODEGA EN EL INVENTARIO DE PRODUCCIÓN
	public function captura()
	{
		if (!$this->input->is_ajax_request()) {
			redirect(base_url() . "Inicio");
		}

		$insumoId = $this->input->post("insumo_id");
		$bodega   = $this->input->post("bodega");
		$piso     = $this->input->post("piso");
		$plazaId  = $this->input->post("plaza_id");

		$valorBandera = $this->consultarBandera($insumoId, $plazaId);

		// Caso 1: Mezclas estándar de café (117 y 118)
		if ($insumoId == 117 || $insumoId == 118) {
			$this->_procesarMezclaSimple($insumoId, $plazaId, $bodega, $piso, $valorBandera);
			return;
		}

		// Caso 2: Mezclas complejas por mililitros (119 y 120)
		if ($insumoId == 119 || $insumoId == 120) {
			$this->_procesarMezclaMililitros($insumoId, $plazaId, $bodega, $piso, $valorBandera);
			return;
		}

		// Caso 3: Insumos estándar
		$this->_procesarInsumoEstandar($insumoId, $plazaId, $bodega, $piso);
	}

	//MÉTODO PARA VERIFICAR QUE UN INSUMO YA HA SIDO MARCADO EN EL INVENTARIO FÍSICO
	private function consultarBandera($insumo_id, $plaza_id)
	{
		$reportes = $this->Mdl_inventario->getBandera($insumo_id, $plaza_id);
		if ($reportes != false) {
			return $reportes->Bandera;
		}
	}

	//MÉTODO PARA OBTENER LA CANTIDAD DE UN INSUMO EN EL INVENTARIO DE PRODUCCCIÓN
	private function consultarCantidad($insumo_id, $plaza_id)
	{
		$reportes = $this->Mdl_inventario->getCantidad($insumo_id, $plaza_id);
		if ($reportes != false) {
			return $reportes->Cantidad;
		}
	}

	//MÉTODO PARA OBTENER LAS OPERACIONES DLC
	private function consultarDLC($insumo_id, $cantidad)
	{
		$operacion = $this->Mdl_inventario->getOperacionDLC($insumo_id);
		return ($operacion != false) ? $this->_calcularFormula($cantidad, $operacion->DLC) : 0;
	}

	private function consultarBodega($insumo_id, $cantidad)
	{
		$operacion = $this->Mdl_inventario->getOperacionBodega($insumo_id);
		return ($operacion != false) ? $this->_calcularFormula($cantidad, $operacion->Bodega) : 0;
	}

	private function consultarPiso($insumo_id, $cantidad)
	{
		$operacion = $this->Mdl_inventario->getOperacionPiso($insumo_id);
		return ($operacion != false) ? $this->_calcularFormula($cantidad, $operacion->Piso) : 0;
	}

	private function consultarTotal($insumo_id, $cantidad)
	{
		$operacion = $this->Mdl_inventario->getOperacionTotal($insumo_id);
		return ($operacion != false) ? $this->_calcularFormula($cantidad, $operacion->Total) : 0;
	}

	private function consultarCantidadCapturaPiso($id, $plaza_id, $campo)
	{
		$reportes = $this->Mdl_inventario->getCantidadCaptura($id, $plaza_id, $campo);
		if ($reportes != false) {
			return $reportes->Piso;
		}
	}

	private function consultarCantidadCapturaBodega($id, $plaza_id, $campo)
	{
		$reportes = $this->Mdl_inventario->getCantidadCaptura($id, $plaza_id, $campo);
		if ($reportes != false) {
			return $reportes->Bodega;
		}
	}

	public function consultarIF()
	{
		if ($this->input->is_ajax_request()) {
			$plaza_id = $this->input->post('plaza_id');
			echo json_encode($this->Mdl_inventario->getCapturaInventario($plaza_id));
		} else {
			redirect(base_url() . "Inicio");
		}
	}

	public function edicionIF()
	{
		if ($this->input->is_ajax_request()) {
			$fecha = $this->input->post("fecha");
			$plaza_id = $this->input->post("plaza_id");

			$data = array('Correcto' => 0);
			if ($this->Mdl_inventario->permitirEdicion($fecha, $plaza_id, $data)) {
				echo 1;
			} else {
				echo 0;
			}
		} else {
			redirect(base_url() . "Inicio");
		}
	}

	public function estatusInventarioFisico()
	{
		if ($this->input->is_ajax_request()) {
			$plaza_id = $this->input->post("plaza_id");

			$fechas = $this->_obtenerRangoFechasInventario();
			$FirstDay = $fechas['FirstDay'];
			$LastDay = $fechas['LastDay'];

			$enviado = $this->Mdl_inventario->getExistenciaSemana($FirstDay, $LastDay, $plaza_id);
			if ($enviado != null) {
				if ($enviado->Correcto == 1) {
					$return_arr[] = array
					(
						"valor" => 1
					);
					echo json_encode($return_arr);
				} else {
					$return_arr[] = array
					(
						"valor" => 0
					);
					echo json_encode($return_arr);
				}
			} else {
				$return_arr[] = array
				(
					"valor" => 0
				);
				echo json_encode($return_arr);
			}
		} else {
			redirect(base_url() . "Inicio");
		}
	}

	public function fechaCorrectaT()
	{
		require_once './assets/Classes/PHPExcel/IOFactory.php';

		$nombreArchivo = FCPATH . 'assets/filesPlatillos/' . 'TEZIUTLAN' . "/" . 'prueba.xlsx';
		$plaza_id = 7;
		$exists = file_exists($nombreArchivo);
		if ($exists == true) {
			$oBjPHPExcel = PHPEXCEL_IOFactory::load($nombreArchivo);
			$oBjPHPExcel->setActiveSheetIndex(0);
			$numRows = $oBjPHPExcel->setActiveSheetIndex(0)->getHighestRow();
			$myArray = array();
			for ($i = 2; $i < 3; $i++) {
				$tpv_1F = $oBjPHPExcel->getActiveSheet()->getCell('C' . $i)->getCalculatedValue();
				$tpv_1F = preg_replace('/\s+/', ',', $tpv_1F);
				$myArray = explode(',', $tpv_1F);
			}

			$yesterday = date('d/m/Y', strtotime("-1 days"));
			$now = date('d/m/Y');


			if ($this->Mdl_ventas->getExistencia($myArray[0], $plaza_id) == 1) {
				if (!$this->Mdl_inventario->consultarFechaDLC($myArray[0], $plaza_id)) {
					if (($yesterday == $myArray[0] && $yesterday == $myArray[2]) || ($now == $myArray[0] && $now == $myArray[2])) {
						echo "Fecha Correcta";
					} else {
						echo "Fecha Incorrecta";

					}
				} else {
					echo "Esta en la base";
				}
			} else {
				echo "Primero suba el corte";
			}
		} else {
			echo "No existe";
		}


	}

	private function getWeeks($date, $rollover)
	{

		$cut = substr($date, 0, 8);
		$daylen = 86400;

		$timestamp = strtotime($date);
		$first = strtotime($cut . "00");
		$elapsed = ($timestamp - $first) / $daylen;

		$weeks = 1;

		for ($i = 1; $i <= $elapsed; $i++) {
			$dayfind = $cut . (strlen($i) < 2 ? '0' . $i : $i);
			$daytimestamp = strtotime($dayfind);

			$day = strtolower(date("l", $daytimestamp));

			if ($day == strtolower($rollover)) $weeks++;
		}

		return $weeks;
	}

	public function historialIF()
	{
		$plaza_id = $this->input->post("plaza_id");
		$fecha = $this->input->post("fecha");

		if ($this->input->post("buscar")) {
			$data = array(
				'miCaptura' => $this->Mdl_inventario->getCapturaInventarioFechaPlaza($fecha, $plaza_id),
				'plazas' => $this->Mdl_plazas->getPlazas(),
				'capturas' => $this->Mdl_inventario->getCapturasAdministrador(),
				'fecha' => $fecha,
				'id' => $plaza_id
			);
		} else {
			$data = array(
				'miCaptura' => null,
				'plazas' => $this->Mdl_plazas->getPlazas(),
				'capturas' => $this->Mdl_inventario->getCapturasAdministrador(),
				'fecha' => $fecha,
				'id' => 1
			);
		}
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("administrador/inventario/ifisico/list_historial_if", $data);
		$this->load->view("layouts/footer");
	}

	private function probarDLC()
	{
		$ultimaCantidad = $this->Mdl_inventario->getUltimaCantidad(1, 78);
		echo $ultimaCantidad->Nueva_Cantidad;
		echo "<br>";
		$cantidad = $this->consultarCantidad(78, 1);
		echo $cantidad;
	}

	public function liberarPedidoInventario()
	{
		if ($this->input->is_ajax_request()) {

			$plaza_id = $this->input->post("plaza_id");
			$fecha = $this->input->post("fecha");
			$usuario_id = $this->session->userdata("id");

			//LO PRIMERO PARA AGREGAR EL PEDIDO AL INVENTARIO ES OBTENER EL INVENTARIO DE LA PLAZA
			$inventarios = $this->Mdl_inventario->getInventarioPlaza($plaza_id);

			//DESPUES OBTENEMOS EL PEDIDO EL CUAL QUEREMOS AGREGAR
			$miPedido = $this->Mdl_pedidos->getPedidoPlaza($fecha, $plaza_id);


			$arregloU = array();
			$arregloM = array();

			$i = 0;
			//POR MEDIO DE ESTA CONDICIÓN VERIFICAMOS QUE EL PEDIDO SE HAYA COMPLETADO
			//ES DECIR EL MANAGER YA MARCO TODOS LOS INSUMOS DEPENDIENDO DEL ESTADO DE LLEGADA DE LA MERCANCIA
			//SI LA BANDERA SE VUELVE FALSA SIGNIFICA QUE AÚN FALTAN INSUMOS POR CHECAR POR TANTO NO SE PROCEDE CON
			//LA LIBERACIÓN
			$bandera = true;
			foreach ($miPedido as $key) {
				if ($key->Bandera == 0) {
					$bandera = false;
				}
			}

			//EN DADO CASO DE QUE LA BANDERA SEA VERDADERA
			if ($bandera) {
				//POR MEDIO DE UN CICLO FOR RECORREMOS EL PRESENTE PEDIDO
				foreach ($miPedido as $pedido) {
					//CONSULTAMOS LA CANTIDAD DE CADA INSUMO DEL PEDIDO EN EL INVENTARIO DE PRODUCCIÓN
					$cantidadRealInventario = $this->consultarCantidad($pedido->insumo_id, $plaza_id);

					if ($cantidadRealInventario != null) {
						$nuevaCantidad = $cantidadRealInventario + $pedido->Cantidad_Final;

						$arregloU[$i] =
							array(
								'Cantidad' => $nuevaCantidad,
								'insumo_id' => $pedido->insumo_id
							);

						$arregloM[$i] = array(
							'usuario_id' => $usuario_id,
							'plaza_id' => $plaza_id,
							'Tipo_Movimiento' => "PEDIDO",
							'insumo_id' => $pedido->insumo_id,
							"Nueva_Cantidad" => $nuevaCantidad,
							"Antigua_Cantidad" => $cantidadRealInventario,
							"Fecha" => date("Y-m-d")
						);

						$i++;
					}
				}


				if (sizeof($arregloU) > 0) {
					if ($this->Mdl_inventario->actualizarCantidadInventario($plaza_id, $arregloU)) {
						$data = array('Estatus' => 1, "Liberado" => 1);
						if ($this->Mdl_pedidos->actualizarEstatusLiberacionPedido($fecha, $plaza_id, $data)) {
							if ($this->Mdl_inventario->actualizarMovimientos($arregloM)) {
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
					$data = array('Estatus' => 1, "Liberado" => 1);
					if ($this->Mdl_pedidos->actualizarEstatusLiberacionPedido($fecha, $plaza_id, $data)) {
						echo 1;
					} else {
						echo 0;
					}
				}
			} else {
				echo 2;
			}
		} else {
			redirect(base_url() . "Inicio");
		}
	}

	public function liberarPedidoPasteleriaInventario()
	{
		if ($this->input->is_ajax_request()) {

			$plaza_id = $this->input->post("plaza_id");
			$fecha = $this->input->post("fecha");
			$inventarios = $this->Mdl_inventario->getInventarioPlaza($plaza_id);
			$miPedido = $this->Mdl_pedidos->getPedidoPasteleriaPlaza($fecha, $plaza_id);
			$bandera = true;
			foreach ($miPedido as $key) {
				if ($key->Bandera == 0) {
					$bandera = false;
				}
			}
			$arregloU = array();
			$i = 0;

			if ($bandera == true) {
				foreach ($miPedido as $pedido) {
					$cantidadRealInventario = $this->consultarCantidad($pedido->insumo_id, $plaza_id);
					$nuevaCantidad = $cantidadRealInventario + $pedido->Cantidad_Final;
					$arregloU[$i] =
						array(
							'Cantidad' => $nuevaCantidad,
							'insumo_id' => $pedido->insumo_id
						);
					$i++;
				}

				if ($this->Mdl_inventario->actualizarCantidadInventario($plaza_id, $arregloU)) {
					$data = array('Estatus' => 1);
					if ($this->Mdl_pedidos->actualizarEstatusLiberacionPedidoPasteleria($fecha, $plaza_id, $data)) {
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

	public function listDLC()
	{

		$data = array(
			'platillos' => $this->Mdl_inventario->getPlatillos()
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("administrador/archivos/dlc/list", $data);
		$this->load->view("layouts/footer");
	}

	public function panelConfiguraciones()
	{
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("administrador/inventario/configuraciones/panel_configuraciones");
		$this->load->view("layouts/footer");
	}

	private function procesarT($datos, $id_usuario, $id_plaza, $nombreArchivoF)
	{
	}

	public function panelInventarioFisico()
	{
		$data = array(
			'capturas' => $this->Mdl_inventario->getCapturasAdministrador()
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("administrador/inventario/ifisico/inventario_fisico", $data);
		$this->load->view("layouts/footer");
	}

	public function quebrantos()
	{
		$data = array(
			'categoria_quebranto_id' => $this->input->post("categoria_id_filtrar"),
			'categorias_quebrantos'  => $this->Mdl_inventario->getCategoriasQuebrantos(),
			'plazas'                 => $this->Mdl_plazas->getPlazas(),
			'insumos'                => $this->Mdl_productos->getInsumosInventario(),
			'fechas'                 => $this->Mdl_inventario->getFechasQuebrantos(),
			'insumo1'                => $this->input->post("insumo_gasto_remesa_id") ?: 0,
			'id'                     => $this->input->post("plaza_id") ?: 0,
			'inventario_productos'   => [], // El cuerpo lo gestiona DataTables vía AJAX
			'notificaciones'         => []  // El cuerpo lo gestiona DataTables vía AJAX
		);

		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("administrador/inventario/quebrantos/list_quebrantos2", $data);
		$this->load->view("layouts/footer");
	}

	public function store()
	{
		if ($this->input->is_ajax_request()) {
			$carpeta = "";
			$platillosV = "";
			$platillosV = array();
			$id_usuario = $this->input->post("usuario_id");
			$id_plaza = $this->input->post("plaza_id");
			$platillosFile = $_FILES["platillosFile"];
			$nombreArchivo = trim(str_replace(" ", "_", $_FILES['platillosFile']['name']));

			#region  SWITCH DE LAS PLAZAS
			switch ($id_plaza) {
				case 1:
					$carpeta = "CASITAS";
					break;
				case 2:
					$carpeta = "MATAMOROS";
					break;
				case 3:
					$carpeta = "OAXACA";
					break;
				case 4:
					$carpeta = "POZA RICA";
					break;
				case 5:
					$carpeta = "REYNOSA I";
					break;
				case 6:
					$carpeta = "REYNOSA II";
					break;
				case 7:
					$carpeta = "TEZIUTLAN";
					break;
				default:
			}
			#endregion

			#region CONFIGURACIÓN DE LAS VARIABLES PARA SUBIR EL ARHCIVO
			$config["upload_path"] = "./assets/filesPlatillos/" . $carpeta;
			$config["max_size"] = 2048;
			$config["allowed_types"] = "*";
			$config['overwrite'] = TRUE;
			$this->load->library("upload", $config);
			#endregion

			$datos = array('carpeta' => $carpeta);
			if (!$this->upload->do_upload('platillosFile')) {
				echo $this->upload->display_errors();
			} else {
				// Integración Telnet
				$platillosV = $this->procesarT($datos, $id_usuario, $id_plaza, $nombreArchivo);
				echo json_encode($platillosV);
			}
		} else {
			redirect(base_url() . "Inicio");
		}
	}


	private function fechaCorrecta($nombreArchivo, $plaza_id)
	{
		require_once './assets/Classes/PHPExcel/IOFactory.php';

		$exists = file_exists($nombreArchivo);
		if ($exists == true) {
			$oBjPHPExcel = PHPEXCEL_IOFactory::load($nombreArchivo);
			$oBjPHPExcel->setActiveSheetIndex(0);
			$numRows = $oBjPHPExcel->setActiveSheetIndex(0)->getHighestRow();

			$tpv_1F = $oBjPHPExcel->getActiveSheet()->getCell('A5')->getCalculatedValue();
			$myArray = explode('-', $tpv_1F);
			$myArray2 = explode('/', current($myArray));
			$myArray3 = explode('/', next($myArray));
			//$now=date('d/m/Y',strtotime("-8 days"));
			$yesterday = date('d/m/Y', strtotime("-1 days"));

			$diasT = $this->Mdl_opciones->getNumeroDias();
			if ($diasT != null) {
				$diasT = $diasT->Dias;
				//$diasT=3;
			} else {
				$diasT = 1;
			}

			$yesterday2 = date('d/m/Y', strtotime("-" . $diasT . " days"));
			$now = date('d/m/Y');

			$pieces = explode("/", $now);
			$d = $pieces[1];
			$m = $pieces[0];
			$y = $pieces[2];
			$pieces = $m . "/" . $d . "/" . $y;

			$pieces2 = explode("/", $yesterday);
			$d2 = $pieces2[1];
			$m2 = $pieces2[0];
			$y2 = $pieces2[2];
			$pieces2 = $m2 . "/" . $d2 . "/" . $y2;

			$dia1 = str_pad($myArray2[0], 2, 0, STR_PAD_LEFT);
			$mes1 = str_pad($myArray2[1], 2, 0, STR_PAD_LEFT);
			$year1 = str_pad($myArray2[2], 2, 0, STR_PAD_LEFT);
			$fecha1 = $dia1 . "/" . $mes1 . "/" . $year1;

			$dia11 = $myArray2[0];
			$mes11 = $myArray2[1];
			$year11 = $myArray2[2];
			$fecha11 = $dia11 . "/" . $mes11 . "/" . $year11;

			$dia2 = str_pad($myArray3[0], 3, 0, STR_PAD_LEFT);
			$dia2 = str_replace(" ", "", $dia2);
			$mes2 = str_pad($myArray3[1], 2, 0, STR_PAD_LEFT);
			$year2 = str_pad($myArray3[2], 2, 0, STR_PAD_LEFT);

			$fecha2 = $dia2 . "/" . $mes2 . "/" . $year2;
			$dia22 = $myArray3[0];
			$mes22 = $myArray3[1];
			$year22 = $myArray3[2];

			$fecha22 = $dia22 . "/" . $mes22 . "/" . $year22;
			$fecha1 = str_replace(" ", "", $fecha1);
			$fecha2 = str_replace(" ", "", $fecha2);
			$fecha2 = trim($fecha2, " \t.");
			$fecha11 = str_replace(" ", "", $fecha11);
			$fecha22 = str_replace(" ", "", $fecha22);
			$fecha22 = trim($fecha22, " \t.");
			$pieces = str_replace(" ", "", $pieces);
			$pieces2 = str_replace(" ", "", $pieces2);

			$fechaConsulta = $year1 . "-" . $mes1 . "-" . $dia1;
			$fechaConsulta = str_replace(" ", "", $fechaConsulta);

			if ($this->Mdl_ventas->getExistencia($fechaConsulta, $plaza_id) == 1) {
				if (!$this->Mdl_inventario->consultarFechaDLC($fechaConsulta, $plaza_id)) {
					$return_arr[] = array
					("valor" => 1,
						"fecha" => $fechaConsulta
					);
					return ($return_arr);

				} else {
					$return_arr[] = array
					("valor" => 2,
						"fecha" => $fechaConsulta
					);
					return ($return_arr);
				}
			} else {

				$return_arr[] = array
				("valor" => 4,
					"fecha" => $fechaConsulta
				);
				return ($return_arr);

			}
		}
	}

	public function listAdmin()
	{
		$plaza_id = $this->input->post("plaza_id");
		$insumo_gasto_remesa_id = $this->input->post("insumo_gasto_remesa_id");

		// Construimos el arreglo de datos UNA sola vez usando nuestro método dinámico
		$data = array(
			'inventario_productos' => $this->Mdl_inventario->getInventarioFiltrado($plaza_id, $insumo_gasto_remesa_id),
			'plazas'               => $this->Mdl_plazas->getPlazas(),
			'insumos'              => $this->Mdl_productos->getInsumosInventario(),
			'notificaciones'       => $this->Mdl_inventario->getNotificaciones(),
			'id'                   => $plaza_id,
			'insumo1'              => $insumo_gasto_remesa_id
		);

		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("administrador/inventario/produccion/list", $data);
		$this->load->view("layouts/footer");
	}

	public function modificarInventario()
	{
		$plaza_id = $this->input->post("plaza_id");
		$insumo_gasto_remesa_id = $this->input->post("insumo_gasto_remesa_id");

		// Mismo caso, un solo arreglo limpio
		$data = array(
			'inventario_productos' => $this->Mdl_inventario->getInventarioFiltrado($plaza_id, $insumo_gasto_remesa_id),
			'plazas'               => $this->Mdl_plazas->getPlazas(),
			'insumos'              => $this->Mdl_productos->getInsumos(),
			'notificaciones'       => $this->Mdl_inventario->getNotificaciones(),
			'id'                   => $plaza_id,
			'insumo1'              => $insumo_gasto_remesa_id
		);

		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("administrador/inventario/produccion/edit", $data);
		$this->load->view("layouts/footer");
	}

	public function seguimientoInventario()
	{
		$plaza_id    = $this->input->post("plaza_id");
		$insumo_id   = $this->input->post("insumo_id_seguimiento");
		$fechaInicio = $this->input->post("fechaInicio");
		$fechaFin    = $this->input->post("fechaFin");

		$fechas   = $this->_obtenerRangoFechasInventario();
		$FirstDay = $fechas['FirstDay'];
		$LastDay  = $fechas['LastDay'];

		// Lógica limpia para establecer las fechas de búsqueda
		if ($this->input->post("buscar")) {
			// Búsqueda simple: un solo día
			$fechaFin = $fechaInicio;
		} else if (!$this->input->post("buscarRango")) {
			// Por defecto: Si no se presionó ningún botón, cargamos los datos de ayer
			$fechaInicio = date('Y-m-d', strtotime("-1 days"));
			$fechaFin    = $fechaInicio;
		}

		// Construimos el arreglo con todas las dependencias
		$data = array(
			'inventario_productos' => "", // Se mantiene vacío por retrocompatibilidad de tu vista
			'plazas'               => $this->Mdl_plazas->getPlazas(),
			'insumos'              => $this->Mdl_productos->getInsumosInventario(),
			'notificaciones'       => $this->Mdl_inventario->getNotificaciones(),
			'mensajes'             => $this->Mdl_inventario->getMensajes2($FirstDay, $LastDay),
			'movimientos'          => $this->Mdl_inventario->getMovimientosFiltrados($fechaInicio, $fechaFin, $plaza_id, $insumo_id),
			'id'                   => $plaza_id,
			'insumo1'              => $insumo_id,
			'fechaInicio'          => $fechaInicio,
			'fechaFin'             => $fechaFin
		);

		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("administrador/inventario/configuraciones/seguimiento_inventario", $data);
		$this->load->view("layouts/footer");
	}

	public function unidadesVendidas()
	{
		$fechainicio = $this->input->post("fechaInicioD");
		$fechafin    = $this->input->post("fechaFinD");
		$id_plaza    = $this->input->post("plaza_idP");
		$buscarRango = $this->input->post("buscarRango");
		$buscar      = $this->input->post("buscar");
		$menu        = 0;

		// 1. Configuración de fechas y bandera por defecto
		if (!$buscar && !$buscarRango) {
			// Por defecto: mostrar lo del día de ayer
			$fechainicio = date('Y-m-d', strtotime("-1 days"));
			$fechafin    = $fechainicio;
		} elseif ($buscar) {
			// Búsqueda simple: limitamos el fin a la fecha de inicio
			$fechafin = $fechainicio;
		} elseif ($buscarRango) {
			// Búsqueda por rango: Activa la variable $menu de la vista
			$menu = 1;
		}

		// 2. Consulta dinámica
		$reportes = $this->Mdl_depositos->getDepositosDinamic($fechainicio, $fechafin, $id_plaza, $buscarRango);

		// 3. Preparación de datos para la vista
		$data = array(
			'reportes'    => $reportes,
			'fechainicio' => $fechainicio,
			'fechafin'    => $fechafin,
			'plazas'      => $this->Mdl_plazas->getPlazas(),
			'menu'        => $menu,
			'id'          => $id_plaza
		);

		// 4. Cargar la vista
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("administrador/unidades/list", $data);
		$this->load->view("layouts/footer");
	}

	public function stocks()
	{
		$plaza_id = $this->input->post("plaza_id");
		$insumo_gasto_remesa_id = $this->input->post("insumo_gasto_remesa_id");

		$data = array(
			// Reutilizamos nuestra función dinámica pasándole solo la plaza
			'inventario_productos' => $this->Mdl_inventario->getInventarioFiltrado($plaza_id, null),
			'plazas'               => $this->Mdl_plazas->getPlazas(),
			'insumos'              => $this->Mdl_productos->getInsumos(),
			'notificaciones'       => $this->Mdl_inventario->getNotificaciones(),
			'id'                   => $plaza_id,
			'insumo1'              => $insumo_gasto_remesa_id,
			'bandera'              => empty($plaza_id) ? 0 : 1
		);

		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("administrador/inventario/configuraciones/stocks", $data);
		$this->load->view("layouts/footer");
	}

	public function respaldarInventario()
	{
		$plaza_id_buscar = $this->input->post("plaza_id_buscar");

		// Condicional corto para saber qué respaldos traer
		$respaldos = empty($plaza_id_buscar)
			? $this->Mdl_inventario->getFechasRespaldos()
			: $this->Mdl_inventario->getFechasRespaldosPlaza($plaza_id_buscar);

		$data = array(
			'respaldos' => $respaldos,
			'plazas'    => $this->Mdl_plazas->getPlazas(),
			'buscar_id' => $plaza_id_buscar
		);

		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("administrador/inventario/configuraciones/respaldar_inventario", $data);
		$this->load->view("layouts/footer");
	}

	public function respaldoPlaza()
	{
		if ($this->input->is_ajax_request()) {
			$plaza_id = $this->input->post("plaza_id");
			$usuario_id = $this->session->userdata("id");
			$arregloRespaldo = array();

			$respaldoInventarioPlaza = $this->Mdl_inventario->getInventarioPlaza($plaza_id);
			for ($i = 0; $i < sizeof($respaldoInventarioPlaza); $i++) {
				$insumo_id_respaldo = $respaldoInventarioPlaza[$i]->insumo_id;
				$cantidad_respaldo = $respaldoInventarioPlaza[$i]->Cantidad;
				$data = array("plaza_id" => $plaza_id,
					"usuario_id" => $usuario_id,
					"Fecha" => date("Y-m-d"),
					"Hora" => date('H:i:s'),
					"insumo_id" => $insumo_id_respaldo,
					"Cantidad" => $cantidad_respaldo);
				$arregloRespaldo[$i] = $data;
			}

			if ($this->Mdl_inventario->saveRespaldo($arregloRespaldo)) {
				echo 1;
			} else {
				echo 0;
			}

		} else {
			redirect(base_url() . "Inicio");
		}
	}

	public function consultarRespaldoPlaza()
	{
		if ($this->input->is_ajax_request()) {
			$fecha = $this->input->post('fecha');
			$hora = $this->input->post('hora');
			$plaza_id = $this->input->post('plaza_id');
			echo json_encode($this->Mdl_inventario->getRespaldoInventario($fecha, $hora, $plaza_id));
		} else {
			redirect(base_url() . "Inicio");
		}
	}

	public function eliminarRespaldoPlaza()
	{
		if ($this->input->is_ajax_request()) {
			$fecha = $this->input->post('fecha');
			$hora = $this->input->post('hora');
			$plaza_id = $this->input->post('plaza_id');

			if ($this->Mdl_inventario->eliminarRespaldoInventarioPlaza($fecha, $hora, $plaza_id)) {
				echo 1;
			} else {
				echo 0;
			}
		} else {
			redirect(base_url() . "Inicio");
		}
	}


	/**
	 * NUEVA MANERA DE CAPTURAR EL INVENTARIO FISICO
	 */
	//CAPTURA DEL INVENTARIO FÍSICO PARA MANAGERS
	public function nuevaCaptura()
	{
		$plaza_id = $this->session->userdata("plaza");
		$puedeCapturar = false;
		$yaFueEnviado = false;
		$yaFueLiberado = false;
		$notas = "";

		$fechas = $this->_obtenerRangoFechasInventario();
		$FirstDay = $fechas['FirstDay'];
		$LastDay = $fechas['LastDay'];

		if ($FirstDay == "" || $LastDay == "") {
			$data = array(
				'capturaActualInventario' => null,
				'capturaLiberadaInventario' => null,
				'numeroInsumosRestantes' => null,
				'puedeCapturar' => $puedeCapturar,
				'yaFueEnviado' => $yaFueEnviado,
				'yaFueLiberado' => $yaFueLiberado,
				'notas' => $notas
			);

			$this->load->view("layouts/header");
			$this->load->view("layouts/aside");
			$this->load->view("manager/reportes/inventario/nueva_captura", $data);
			$this->load->view("layouts/footer");
		} else {
			//CONSULTAMOS SI ENTRE DOMINGO Y LUNES YA FUE ENVIADO EL INVENTARIO
			$estatusEnvio = $this->Mdl_inventario->getExistencia($plaza_id, $FirstDay, $LastDay);

			//VERIFICAMOS SI ES DOMINGO O LUNES EN CASO QUE SI
			if (date('D') == 'Sun' || date('D') == 'Mon') {
				if ($estatusEnvio != null) {
					if ($estatusEnvio->Correcto == 1) {
						$notas = $estatusEnvio->Notas;
						$yaFueEnviado = true;
						$puedeCapturar = false;
						$yaFueLiberado = $this->Mdl_inventario->getEstatusCIF2($FirstDay, $LastDay, $plaza_id);

						if ($yaFueLiberado != null) {
							$yaFueLiberado = $yaFueLiberado->Inventario;
							if ($yaFueLiberado == 1) {
								$yaFueLiberado = true;
							} else {
								$yaFueLiberado = false;
							}
							$notas = $estatusEnvio->Notas;
						} else {
							$yaFueLiberado = false;
							$notas = $estatusEnvio->Notas;
						}
					} else {
						$puedeCapturar = true;
						$yaFueEnviado = false;
						$notas = $estatusEnvio->Notas;
					}
				} else {
					$puedeCapturar = true;
				}
			} else {
				$puedeCapturar = false;
			}

			$data = array(
				'capturaActualInventario' => $this->Mdl_inventario->getCapturaInventarioPruebaOrden($plaza_id),
				'capturaLiberadaInventario' => $this->Mdl_inventario->getCapturaInventarioPlaza2($FirstDay, $LastDay, $plaza_id),
				'numeroInsumosRestantes' => $this->Mdl_backend->rowCount("tbl_captura_inventario", $plaza_id),
				'puedeCapturar' => $puedeCapturar,
				'yaFueEnviado' => $yaFueEnviado,
				'yaFueLiberado' => $yaFueLiberado,
				'notas' => $notas
			);

			$this->load->view("layouts/header");
			$this->load->view("layouts/aside");
			$this->load->view("manager/reportes/inventario/nueva_captura", $data);
			$this->load->view("layouts/footer");
		}
	}

	public function getInsumoSiguienteIF()
	{
		if ($this->input->is_ajax_request()) {
			$insumo_id = $this->input->post("insumo_id");
			$plaza_id = $this->session->userdata("plaza");
			$valorMaximoOrdenInventario = $this->Mdl_inventario->get_max_value_with_alias("Orden_Captura_Inventario", "ValorMaximoOrdenInventario", "tbl_insumos");

			$insumo_id++;
			$valorMaximoOrdenInventario = intval($valorMaximoOrdenInventario);
			if ($insumo_id >= $valorMaximoOrdenInventario) {
				$insumo_id = $valorMaximoOrdenInventario;
			}
			$resultado = $this->Mdl_inventario->getInsumoSiguienteIF($insumo_id, $plaza_id);

			echo json_encode($resultado);
		} else {
			redirect(base_url() . "Inicio");
		}
	}

	//MÉTODO QUE SE EJECUTA CADA VEZ QUE COLOCAMOS PISO Y BODEGA EN EL INVENTARIO DE PRODUCCIÓN
	public function capturaPrueba()
	{
		if ($this->input->is_ajax_request()) {
			$insumo_id = $this->input->post("insumo_id");
			$bodega = $this->input->post("bodega");
			$piso = $this->input->post("piso");
			$plaza_id = $this->session->userdata("plaza");
			$insumoMezcla = $insumo_id;
			$return_arr = array();
			$this->form_validation->set_rules("bodega", "bodega", "required");
			$this->form_validation->set_rules("piso", "piso", "required");


			if ($this->form_validation->run()) {
				$valorBodega = 0;
				$valorPiso = 0;
				$total = 0;

				if (!$bodega == 0) {
					$valorBodega = $this->consultarBodega($insumo_id, $bodega);
				} else {
					$valorBodega = 0;
				}

				if (!$piso == 0) {
					$valorPiso = $this->consultarPiso($insumo_id, $piso);
				} else {
					$valorPiso = 0;
				}

				$suma = floatval($valorPiso) + floatval($valorBodega);
				if ($suma != 0) {
					$total = $this->consultarTotal($insumo_id, $suma);
				} else {
					$total = 0;
				}

				$data =
					array(
						"Bodega" => $bodega,
						'Piso' => $piso,
						"Total" => $total,
						"Bandera" => 1
					);

				if ($this->Mdl_inventario->updateCaptura($insumo_id, $plaza_id, $data)) {
					$corte = $this->ajaxPrueba();
					$numero = $this->Mdl_backend->rowCount("tbl_captura_inventario", $plaza_id);
					$valorMaximoOrdenInventario = $this->Mdl_inventario->get_max_value_with_alias("Orden_Captura_Inventario", "ValorMaximoOrdenInventario", "tbl_insumos");

					$return_arr[] = array
					("corte" => $corte,
						"numero" => $numero,
						"valorMaximoOrdenInventario" => intval($valorMaximoOrdenInventario)
					);
					echo json_encode($return_arr);
				} else {
					$this->session->set_flashdata("error", "No se pudo guardar la información");
					echo 0;
				}
			} else {
				echo 0;
			}
		} else {
			redirect(base_url() . "Inicio");
		}
	}

	private function ajaxPrueba()
	{
		$plaza_id = $this->session->userdata("plaza");
		$valor = $this->Mdl_inventario->getCapturaInventarioPrueba($plaza_id);
		return $valor;
	}

	public function consultarIFPrueba()
	{
		if ($this->input->is_ajax_request()) {
			$plaza_id = $this->session->userdata("plaza");
			echo json_encode($this->Mdl_inventario->getCapturaInventarioPruebaOrden($plaza_id));
		} else {
			redirect(base_url() . "Inicio");
		}
	}

	public function getInsumoAnteriorIF()
	{
		if ($this->input->is_ajax_request()) {
			$insumo_id = $this->input->post("insumo_id");
			$plaza_id = $this->session->userdata("plaza");

			$insumo_id--;
			if ($insumo_id <= 0) {
				$insumo_id = 1;
			}

			$resultado = $this->Mdl_inventario->getInsumoSiguienteIF($insumo_id, $plaza_id);

			echo json_encode($resultado);
		} else {
			redirect(base_url() . "Inicio");
		}
	}

	public function liberarInventarioFisicoPrueba()
	{
		if ($this->input->is_ajax_request()) {

			$plaza_id = $this->session->userdata("plaza");
			$usuario_id = $this->session->userdata("id");
			$notas = $this->input->post("notas");

			$fechas = $this->_obtenerRangoFechasInventario();
			$FirstDay = $fechas['FirstDay'];
			$LastDay = $fechas['LastDay'];

			$enviado = $this->Mdl_inventario->getExistenciaSemana($FirstDay, $LastDay, $plaza_id);
			if ($enviado != null) {
				//EL REGISTRO YA EXISTE
				//echo "El registro ya existe Acción: ACTUALIZAR";
				echo 2;
			} else {
				//PROCEDEMOS A INSERTAR UN NUEVO REGISTRO
				//echo "El registro no existe. Acción: INSERTAR";
				$data = array(
					'Fecha' => date("Y-m-d"),
					'Semana' => $this->getWeeks(date("Y-m-d"), "sunday"),
					'Hora' => date('H:i:s'),
					'plaza_id' => $plaza_id,
					'usuario_id' => $usuario_id,
					'Insumos' => 118,
					'Correcto' => 1,
					"Notas" => $notas
				);

				if ($this->Mdl_inventario->saveDetallesInventarioFisico($data)) {
					echo 1;
				} else {
					echo 0;
				}
			}
		} else {
			redirect(base_url() . "Inicio");
		}
	}

	/**
	 * NUEVA MANERA DE CAPTURAR EL INVENTARIO FISICO
	 */

	//Area de pruebas para el costo de venta experimental-quebrantos
	public function quebrantosExperimental()
	{
		$arregloExperimental = $this->Mdl_inventario->getQuebrantoExperimental();
		for ($i = 0; $i < sizeof($arregloExperimental); $i++) {
			echo $arregloExperimental[$i]->Insumo;
			echo "<br>";
		}
		var_dump($arregloExperimental);
	}

	/**
	 * Obtiene el rango de fechas (Domingo y Lunes) para los cálculos de inventario físico.
	 * Retorna un arreglo asociativo con las claves 'FirstDay' y 'LastDay'.
	 */
	private function _obtenerRangoFechasInventario()
	{
		if (date('D') == 'Sun') {
			$FirstDay = date("Y-m-d");
			$LastDay  = date('Y-m-d', strtotime("+1 days"));
		} else if (date('D') == 'Mon') {
			$FirstDay = date('Y-m-d', strtotime("-1 days"));
			$LastDay  = date("Y-m-d");
		} else {
			$datePrueba = date("Y-m-d");
			$FirstDay   = date('Y-m-d', strtotime($datePrueba . ' this sunday'));
			$LastDay    = date('Y-m-d', strtotime($datePrueba . ' this monday'));
		}

		return [
			'FirstDay' => $FirstDay,
			'LastDay'  => $LastDay,
			0          => $FirstDay,
			1          => $LastDay
		];
	}

	private function _obtenerDatosInventarioListF($fechaInicio, $fechaFin, $todasLiberadas, $plazaId, $insumoId)
	{
		$tienePlaza = !empty($plazaId);
		$tieneInsumo = !empty($insumoId);

		// Caso 1: Sin plaza y sin insumo (General)
		if (!$tienePlaza && !$tieneInsumo) {
			return $todasLiberadas
				? $this->Mdl_inventario->getCapturaInventarioGeneralHistorico2($fechaInicio, $fechaFin)
				: $this->Mdl_inventario->getCapturaInventarioGeneral();
		}

		// Caso 2: Solo Insumo (General Insumo)
		if (!$tienePlaza && $tieneInsumo) {
			return $todasLiberadas
				? $this->Mdl_inventario->getCapturaInventarioGeneralInsumoHistorico2($fechaInicio, $fechaFin, $insumoId)
				: $this->Mdl_inventario->getCapturaInventarioGeneralInsumo($insumoId);
		}

		// Caso 3: Solo Plaza (General Plaza)
		if ($tienePlaza && !$tieneInsumo) {
			return $todasLiberadas
				? $this->Mdl_inventario->getCapturaInventarioGeneralPlazaHistorico2($fechaInicio, $fechaFin, $plazaId)
				: $this->Mdl_inventario->getCapturaInventarioGeneralPlaza($plazaId);
		}

		// Caso 4: Con Plaza y Con Insumo (General Plaza Insumo)
		return $todasLiberadas
			? $this->Mdl_inventario->getCapturaInventarioGeneralPlazaInsumoHistorico2($fechaInicio, $fechaFin, $plazaId, $insumoId)
			: $this->Mdl_inventario->getCapturaInventarioGeneralPlazaInsumo($plazaId, $insumoId);
	}

	/**
	 * PROCESADOR MATEMÁTICO CENTRALIZADO
	 */
	private function _calcularFormula($cantidad, $formulaStr)
	{
		$myArray = explode(',', $formulaStr);
		$tamaño = sizeof($myArray);
		$resultado = $cantidad;

		// Operación 1 (Ej: *, 5)
		if ($tamaño >= 2) {
			$resultado = $this->_aplicarOperador($resultado, $myArray[0], $myArray[1]);
		}
		// Operación 2 (Ej: +, 10)
		if ($tamaño >= 4) {
			$resultado = $this->_aplicarOperador($resultado, $myArray[2], $myArray[3]);
		}
		// Operación 3 (Preparado por si el tamaño llega a 6 en el futuro)
		if ($tamaño >= 6) {
			$resultado = $this->_aplicarOperador($resultado, $myArray[4], $myArray[5]);
		}

		return $resultado;
	}

	private function _aplicarOperador($valorActual, $operador, $valorExtra)
	{
		switch ($operador) {
			case "*": return $valorActual * $valorExtra;
			case "+": return $valorActual + $valorExtra;
			case "-": return $valorActual - $valorExtra;
			case "/": return ($valorExtra != 0) ? $valorActual / $valorExtra : 0;
			default:  return $valorActual;
		}
	}

	public function notificacionesQuebrantosAjax()
	{
		if (!$this->input->is_ajax_request()) {
			redirect(base_url() . "Inicio");
		}

		$start  = intval($this->input->post('start'));
		$length = intval($this->input->post('length'));
		$search = $this->input->post('search')['value'] ?? null;
		$draw   = intval($this->input->post('draw'));

		$totalRecords    = $this->Mdl_inventario->countTotalNotificacionesDT();
		$filteredRecords = $this->Mdl_inventario->countFilteredNotificacionesDT($search);
		$registros       = $this->Mdl_inventario->getNotificacionesDT($start, $length, $search);

		$data = [];
		foreach ($registros as $row) {
			$data[] = [
				$row->Plaza,
				$row->Insumo,
				$row->Cantidad
			];
		}

		echo json_encode([
			"draw"            => $draw,
			"recordsTotal"    => $totalRecords,
			"recordsFiltered" => $filteredRecords,
			"data"            => $data
		]);
	}

	public function quebrantosServerSideAjax()
	{
		if (!$this->input->is_ajax_request()) {
			redirect(base_url() . "Inicio");
		}

		$start       = intval($this->input->post('start'));
		$length      = intval($this->input->post('length'));
		$search      = $this->input->post('search')['value'] ?? null;
		$draw        = intval($this->input->post('draw'));
		$plazaId     = $this->input->post('plaza_id');
		$categoriaId = $this->input->post('categoria_id_filtrar');
		$insumoId    = $this->input->post('insumo_gasto_remesa_id');

		$coloresPlaza = [
			1 => '#bae6ff', 2 => '#FA8072', 3 => '#8cedbc',
			4 => '#ecccbb', 5 => '#ffd682', 6 => '#e7bbec', 7 => '#e7bbec'
		];
		$nombresCat = [
			1 => 'R2', 2 => 'R3', 3 => 'RP', 4 => 'RS', 5 => 'SC',
			6 => 'U',  7 => 'UD', 8 => 'UR', 10 => 'UP'
		];

		$totalRecords = $this->Mdl_inventario->countTotalQuebrantosDT($plazaId, $categoriaId, $insumoId, $search);
		$registros    = $this->Mdl_inventario->getQuebrantosDT($start, $length, $search, $plazaId, $categoriaId, $insumoId);

		$data = [];
		foreach ($registros as $row) {
			$color = $coloresPlaza[$row->plaza_id] ?? '#ffffff';
			$cat   = $nombresCat[$row->categoria_quebranto_id] ?? 'OTRO';
			$suma  = ($row->Tres ?? 0) + ($row->Cuatro ?? 0);
			$bgSuma = ($suma < 0) ? '#ffacac' : '#d1ffaf';

			$data[] = [
				'<span style="background-color:'.$color.'; display:block; padding:3px 5px; border-radius:3px;">'.$row->Plaza.'</span>',
				$cat,
				$row->Insumo,
				round($row->Uno ?? 0, 2),
				round($row->Dos ?? 0, 2),
				round($row->Tres ?? 0, 2),
				round($row->Cuatro ?? 0, 2),
				'<span style="background-color:'.$bgSuma.'; display:block; padding:3px 5px; font-weight:bold;">'.round($suma, 2).'</span>',
				$row->Unidad
			];
		}

		echo json_encode([
			"draw"            => $draw,
			"recordsTotal"    => $totalRecords,
			"recordsFiltered" => $totalRecords,
			"data"            => $data
		]);
	}

	/**
	 * Respuesta centralizada en formato JSON para las peticiones de captura
	 */
	private function _responderCapturaAjax($plazaId)
	{
		$return_arr = array(
			array(
				"corte"  => $this->ajax(),
				"numero" => $this->Mdl_backend->rowCount("tbl_captura_inventario", $plazaId)
			)
		);
		echo json_encode($return_arr);
	}

	/**
	 * Procesa insumos de mezclas proporcionales 5 a 1 (117 = Regular, 118 = Descafeinado)
	 */
	private function _procesarMezclaSimple($insumoMezcla, $plazaId, $bodega, $piso, $valorBandera)
	{
		$insumoConcentrado = ($insumoMezcla == 117) ? 3 : 4;
		$totalLecheB       = $bodega * 5;
		$totalLecheP       = $piso * 5;
		$totalConcentradoB = $bodega * 1;
		$totalConcentradoP = $piso * 1;

		if ($valorBandera == 1) {
			$mezclaPiso    = $this->consultarCantidadCapturaPiso($insumoMezcla, $plazaId, "Piso");
			$mezclaBodega  = $this->consultarCantidadCapturaBodega($insumoMezcla, $plazaId, "Bodega");

			$totalLecheB       -= ($mezclaBodega * 5);
			$totalLecheP       -= ($mezclaPiso * 5);
			$totalConcentradoB -= ($mezclaBodega * 1);
			$totalConcentradoP -= ($mezclaPiso * 1);
		}

		// Insumo 78: Leche
		$totalLecheB += $this->consultarCantidadCapturaBodega(78, $plazaId, "Bodega");
		$totalLecheP += $this->consultarCantidadCapturaPiso(78, $plazaId, "Piso");
		$this->Mdl_inventario->updateCaptura(78, $plazaId, array(
			"Bodega"  => $totalLecheB,
			"Piso"    => $totalLecheP,
			"Total"   => $totalLecheB + $totalLecheP,
			"Bandera" => 1
		));

		// Insumo 3 o 4: Concentrado
		$totalConcentradoB += $this->consultarCantidadCapturaBodega($insumoConcentrado, $plazaId, "Bodega");
		$totalConcentradoP += $this->consultarCantidadCapturaPiso($insumoConcentrado, $plazaId, "Piso");
		$this->Mdl_inventario->updateCaptura($insumoConcentrado, $plazaId, array(
			"Bodega"  => $totalConcentradoB,
			"Piso"    => $totalConcentradoP,
			"Total"   => $totalConcentradoB + $totalConcentradoP,
			"Bandera" => 1
		));

		// Actualizar la mezcla principal
		$dataMezcla = array(
			"Bodega"  => $bodega,
			"Piso"    => $piso,
			"Total"   => $bodega + $piso,
			"Bandera" => 1
		);

		if ($this->Mdl_inventario->updateCaptura($insumoMezcla, $plazaId, $dataMezcla)) {
			$this->_responderCapturaAjax($plazaId);
		} else {
			$this->session->set_flashdata("error", "No se pudo guardar la información");
			echo 0;
		}
	}

	/**
	 * Procesa insumos de mezclas por densidad / mililitros (119 y 120)
	 */
	private function _procesarMezclaMililitros($insumoMezcla, $plazaId, $bodega, $piso, $valorBandera)
	{
		$es119              = ($insumoMezcla == 119);
		$insumoConcentrado = $es119 ? 3 : 4;
		$densidadProducto  = $es119 ? 0.9629 : 0.9609;
		$factorLeche       = $es119 ? 0.90909 : 0.90910;
		$factorConcentrado = 0.09091;

		$mlB = $bodega * $densidadProducto;
		$mlP = $piso * $densidadProducto;

		$totalLecheB       = $mlB * $factorLeche;
		$totalLecheP       = $mlP * $factorLeche;
		$totalConcentradoB = $mlB * $factorConcentrado;
		$totalConcentradoP = $mlP * $factorConcentrado;

		if ($valorBandera == 1) {
			$mezclaPiso   = $this->consultarCantidadCapturaPiso($insumoMezcla, $plazaId, "Piso");
			$mezclaBodega = $this->consultarCantidadCapturaBodega($insumoMezcla, $plazaId, "Bodega");

			$lechePiso = ($this->consultarCantidadCapturaPiso(78, $plazaId, "Piso") * 1000) - (($mezclaPiso * $densidadProducto) * $factorLeche);
			$lecheBodega = ($this->consultarCantidadCapturaBodega(78, $plazaId, "Bodega") * 1000) - (($mezclaBodega * $densidadProducto) * $factorLeche);

			$concPiso = ($this->consultarCantidadCapturaPiso($insumoConcentrado, $plazaId, "Piso") * 500) - (($mezclaPiso * $densidadProducto) * $factorConcentrado);
			$concBodega = ($this->consultarCantidadCapturaBodega($insumoConcentrado, $plazaId, "Bodega") * 500) - (($mezclaBodega * $densidadProducto) * $factorConcentrado);

			$lechePiso   = max(0, round($lechePiso, 0));
			$lecheBodega = max(0, round($lecheBodega, 0));
			$concPiso    = max(0, round($concPiso, 0));
			$concBodega  = max(0, ceil($concBodega));

			$this->Mdl_inventario->updateCaptura(78, $plazaId, array(
				"Bodega"  => $lecheBodega / 1000,
				"Piso"    => $lechePiso / 1000,
				"Total"   => ($lecheBodega + $lechePiso) / 1000,
				"Bandera" => 1
			));

			$this->Mdl_inventario->updateCaptura($insumoConcentrado, $plazaId, array(
				"Bodega"  => $concBodega / 500,
				"Piso"    => $concPiso / 500,
				"Total"   => ($concBodega + $concPiso) / 500,
				"Bandera" => 1
			));
		}

		// Sumar cantidades y persistir
		$lecheBodegaFinal = $totalLecheB + ($this->consultarCantidadCapturaBodega(78, $plazaId, "Bodega") * 1000);
		$lechePisoFinal   = $totalLecheP + ($this->consultarCantidadCapturaPiso(78, $plazaId, "Piso") * 1000);

		$this->Mdl_inventario->updateCaptura(78, $plazaId, array(
			"Bodega"  => $lecheBodegaFinal / 1000,
			"Piso"    => $lechePisoFinal / 1000,
			"Total"   => ($lecheBodegaFinal + $lechePisoFinal) / 1000,
			"Bandera" => 1
		));

		$concBodegaFinal = $totalConcentradoB + ($this->consultarCantidadCapturaBodega($insumoConcentrado, $plazaId, "Bodega") * 500);
		$concPisoFinal   = $totalConcentradoP + ($this->consultarCantidadCapturaPiso($insumoConcentrado, $plazaId, "Piso") * 500);

		$this->Mdl_inventario->updateCaptura($insumoConcentrado, $plazaId, array(
			"Bodega"  => $concBodegaFinal / 500,
			"Piso"    => $concPisoFinal / 500,
			"Total"   => ($concBodegaFinal + $concPisoFinal) / 500,
			"Bandera" => 1
		));

		$dataMezcla = array(
			"Bodega"  => $bodega,
			"Piso"    => $piso,
			"Total"   => ($mlB + $mlP) / 1000,
			"Bandera" => 1
		);

		if ($this->Mdl_inventario->updateCaptura($insumoMezcla, $plazaId, $dataMezcla)) {
			$this->_responderCapturaAjax($plazaId);
		} else {
			$this->session->set_flashdata("error", "No se pudo guardar la información");
			echo 0;
		}
	}

	/**
	 * Procesa insumos estándar ejecutando las fórmulas de bodega, piso y total
	 */
	private function _procesarInsumoEstandar($insumoId, $plazaId, $bodega, $piso)
	{
		$this->form_validation->set_rules("bodega", "bodega", "required");
		$this->form_validation->set_rules("piso", "piso", "required");

		if (!$this->form_validation->run()) {
			echo 0;
			return;
		}

		$valorBodega = ($bodega != 0) ? $this->consultarBodega($insumoId, $bodega) : 0;
		$valorPiso   = ($piso != 0) ? $this->consultarPiso($insumoId, $piso) : 0;
		$suma        = floatval($valorPiso) + floatval($valorBodega);
		$total       = ($suma != 0) ? $this->consultarTotal($insumoId, $suma) : 0;

		// Si se modifica leche o concentrados primarios, se invalidan las mezclas calculadas
		$esInsumoBase = in_array($insumoId, array(3, 4, 78));
		if ($esInsumoBase && $this->consultarBandera($insumoId, $plazaId) == 1) {
			$reset = array("Bodega" => 0, "Piso" => 0, "Total" => 0, "Bandera" => 0);
			foreach (array(117, 118, 119, 120) as $idMezcla) {
				$this->Mdl_inventario->updateCaptura($idMezcla, $plazaId, $reset);
			}
		}

		$data = array(
			"Bodega"  => $bodega,
			"Piso"    => $piso,
			"Total"   => $total,
			"Bandera" => 1
		);

		if ($this->Mdl_inventario->updateCaptura($insumoId, $plazaId, $data)) {
			$this->_responderCapturaAjax($plazaId);
		} else {
			$this->session->set_flashdata("error", "No se pudo guardar la información");
			echo 0;
		}
	}
}
