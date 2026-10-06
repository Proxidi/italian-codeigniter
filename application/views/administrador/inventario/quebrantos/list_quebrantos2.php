<!-- =============================================== -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Listado de los quebrantos
			<small>Listado</small>
		</h1>
		<a href="<?php echo base_url(); ?>Inventario" class="small-box-footer">Volver al Panel del Inventario <i class="fa fa-arrow-circle-right"></i></a>
	</section>

	<!-- Main content -->
	<section class="content">
		<!-- Default box -->
		<div class="box box-solid">
			<div class="box-body">
				<!-- FILTROS -->
				<div class="row">
					<div class="col-md-12">
						<form action="<?php echo current_url();?>" method="POST" class="form-horizontal" id="form-filtros-quebrantos">
							<div class="form-group">
								<!-- COMBOBOX PLAZAS -->
								<label for="plaza_id" class="col-md-1 control-label">Plaza:</label>
								<div class="col-md-3">
									<select name="plaza_id" id="plaza_id" class="form-control">
										<option value="">Todas las plazas</option>
										<?php if (!empty($plazas)): ?>
											<?php foreach ($plazas as $plaza): ?>
												<option value="<?php echo $plaza->id; ?>" <?php echo ($plaza->id == $id) ? 'selected' : ''; ?>>
													<?php echo $plaza->Nombre; ?>
												</option>
											<?php endforeach; ?>
										<?php endif; ?>
									</select>
								</div>

								<!-- COMBOBOX CATEGORÍAS -->
								<label for="categoria_id_filtrar" class="col-md-1 control-label">Categorias:</label>
								<div class="col-md-3">
									<select class="form-control" name="categoria_id_filtrar" id="categoria_id_filtrar">
										<option value="">Todas las categorías</option>
										<?php if (!empty($categorias_quebrantos)): ?>
											<?php foreach ($categorias_quebrantos as $categoria_quebranto): ?>
												<option value="<?php echo $categoria_quebranto->id; ?>" <?php echo ($categoria_quebranto->id == $categoria_quebranto_id) ? 'selected' : ''; ?>>
													<?php echo $categoria_quebranto->Nombre; ?>
												</option>
											<?php endforeach; ?>
										<?php endif; ?>
									</select>
								</div>

								<!-- COMBOBOX INSUMOS -->
								<label for="insumo_gasto_remesa_id" class="col-md-1 control-label">Insumos:</label>
								<div class="col-md-3">
									<select name="insumo_gasto_remesa_id" id="insumo_gasto_remesa_id" class="form-control">
										<option value="">Todos los insumos</option>
										<?php if (!empty($insumos)): ?>
											<?php foreach ($insumos as $insumo): ?>
												<option value="<?php echo $insumo->id; ?>" <?php echo ($insumo->id == $insumo1) ? 'selected' : ''; ?>>
													<?php echo $insumo->Nombre; ?>
												</option>
											<?php endforeach; ?>
										<?php endif; ?>
									</select>
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-12">
									<button type="submit" class="btn btn-primary"><span class="fa fa-search"></span> Buscar</button>
									<button type="button" class="btn btn-danger btn-flag" data-toggle="modal" data-target="#notificacionesQuebrantos"><span class="fa fa-exclamation-triangle"></span> Ver Notificaciones</button>
									<button type="button" class="btn btn-success btn-flag" data-toggle="modal" data-target="#notificacionesFechasDisponibles"><span class="fa fa-calendar"></span> Fechas Disponibles</button>
								</div>
							</div>
						</form>
					</div>
				</div>

				<!-- TABLA PRINCIPAL (SERVER-SIDE) -->
				<div class="row">
					<div class="col-md-12">
						<table class="display responsive table table-bordered btn-hover nowrap" style="width:100%" id="tbl_quebrantos_server">
							<thead>
							<tr>
								<th>Plaza</th>
								<th>Cat</th>
								<th>Insumo</th>
								<th>2026-01-02</th>
								<th>2026-01-09</th>
								<th>2026-01-12</th>
								<th>2026-01-23</th>
								<th>TOTAL</th>
								<th>Unidad</th>
							</tr>
							</thead>
							<tbody>
							<!-- Se llena automáticamente vía AJAX -->
							</tbody>
						</table>
					</div>
				</div>

			</div>
		</div>
	</section>
</div>

<!-- MODAL NOTIFICACIONES DE FALTANTES (SERVER-SIDE) -->
<div class="modal fade" id="notificacionesQuebrantos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-edit"></i> Notificaciones de Faltantes</h4>
			</div>
			<div class="modal-body">
				<table class="display responsive table table-bordered btn-hover nowrap" style="width:100%" id="tbl_notificaciones_server">
					<thead>
					<tr>
						<th>Plaza</th>
						<th>Nombre</th>
						<th>Cantidad</th>
					</tr>
					</thead>
					<tbody>
					<!-- Se llena automáticamente vía AJAX al abrir el modal -->
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>

<!-- MODAL FECHAS DISPONIBLES (CLIENT-SIDE TRADICIONAL PORQUE SON POCOS REGISTROS) -->
<div class="modal fade" id="notificacionesFechasDisponibles" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel2"><i class="glyphicon glyphicon-edit"></i> Fechas Disponibles</h4>
			</div>
			<div class="modal-body">
				<?php if (!empty($fechas)): ?>
					<table class="display responsive table table-bordered btn-hover nowrap" style="width:100%" id="tbl_fechas_quebrantos">
						<thead>
						<tr>
							<th>Fecha</th>
							<th>Plaza</th>
						</tr>
						</thead>
						<tbody>
						<?php foreach ($fechas as $fecha): ?>
							<tr>
								<td><?php echo $fecha->Fecha; ?></td>
								<td><?php echo $fecha->Plaza; ?></td>
							</tr>
						<?php endforeach; ?>
						</tbody>
					</table>
				<?php endif; ?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>

<!-- SCRIPTS DATATABLES SERVER-SIDE -->
<script>
	$(document).ready(function() {
		// 1. Tabla Principal Server-Side (Nuevo ID)
		// 1. Tabla Principal Server-Side con Botones y Selector de Longitud
		var tablaInventario = $('#tbl_quebrantos_server').DataTable({
			"destroy": true,
			"processing": true,
			"serverSide": true,
			"pageLength": 25,
			"lengthMenu": [
				[10, 25, 50, 100],
				[10, 25, 50, 100] // Etiquetas visibles en el selector
			],
			"dom": 'Blfrtip',
			"buttons": [
				{
					extend: 'excelHtml5',
					text: '<i class="fa fa-file-excel-o"></i> Excel',
					className: 'btn btn-default btn-sm'
				},
				{
					extend: 'pdfHtml5',
					text: '<i class="fa fa-file-pdf-o"></i> PDF',
					className: 'btn btn-default btn-sm'
				},
				{
					extend: 'copyHtml5',
					text: '<i class="fa fa-copy"></i> Copiar',
					className: 'btn btn-default btn-sm'
				}
			],
			"responsive": true,
			"ajax": {
				"url": "<?php echo base_url('Inventario/quebrantosServerSideAjax'); ?>",
				"type": "POST",
				"data": function(d) {
					d.plaza_id = $('#plaza_id').val();
					d.categoria_id_filtrar = $('#categoria_id_filtrar').val();
					d.insumo_gasto_remesa_id = $('#insumo_gasto_remesa_id').val();
				}
			}
		});

		// Filtros al hacer submit
		$('#form-filtros-quebrantos').on('submit', function(e) {
			e.preventDefault();
			tablaInventario.ajax.reload();
		});

		// 2. Tabla Notificaciones Server-Side (Nuevo ID, solo al abrir modal)
		var modalNotificacionesIniciado = false;
		$('#notificacionesQuebrantos').on('shown.bs.modal', function() {
			if (!modalNotificacionesIniciado) {
				$('#tbl_notificaciones_server').DataTable({
					"destroy": true,
					"processing": true,
					"serverSide": true,
					"pageLength": 100,
					"responsive": true,
					"scrollY": "450px",      // Altura fija: activa la barra vertical
					"scrollCollapse": true,  // Se ajusta si hay pocos registros
					"lengthMenu": [
						[10, 25, 50, 100],
						[10, 25, 50, 100] // Etiquetas visibles en el selector
					],
					"dom": 'Blfrtip',
					"buttons": [
						{
							extend: 'excelHtml5',
							text: '<i class="fa fa-file-excel-o"></i> Excel',
							className: 'btn btn-default btn-sm'
						},
						{
							extend: 'pdfHtml5',
							text: '<i class="fa fa-file-pdf-o"></i> PDF',
							className: 'btn btn-default btn-sm'
						},
						{
							extend: 'copyHtml5',
							text: '<i class="fa fa-copy"></i> Copiar',
							className: 'btn btn-default btn-sm'
						}
					],
					"ajax": {
						"url": "<?php echo base_url('Inventario/notificacionesQuebrantosAjax'); ?>",
						"type": "POST"
					}
				});
				modalNotificacionesIniciado = true;
			}
		});
	});

</script>
