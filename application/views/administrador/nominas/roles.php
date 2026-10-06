<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Tabla de Nominas <?php echo $this->session->userdata("plaza_nombre")?>
			<?php
			$lunes = date( 'Y-m-d', strtotime( 'monday this week' ));
			$domingo = date( 'Y-m-d', strtotime( 'sunday this week' ));
			?>
			<small>Listado del <?php echo $lunes?> al <?php echo $domingo?> </small>
		</h1>
		<h4>Estado: En captura</h4>
		<a href="<?php echo base_url(); ?>Nominas" class="small-box-footer">Volver al Panel de Inicio <i class="fa fa-arrow-circle-right"></i></a>
	</section>

	<!-- Main content -->
	<section class="content">
		<!-- Default box -->
		<div class="box box-solid">
			<div class="box-body">

				<!-- 1. FORMULARIO DE BÚSQUEDA -->
				<div class="row">
					<div class="col-md-12">
						<form action="<?php echo current_url();?>" method="POST" class="form-horizontal">
							<div class="form-group">
								<label for="" class="col-md-1 control-label">Desde:</label>
								<div class="col-md-2">
									<input type="date" class="form-control" name="fechaInicioD" id="fechaInicioD" value="<?php echo !empty($fechaInicio) ? $fechaInicio:'';?>">
								</div>

								<label for="" class="col-md-1 control-label">Hasta:</label>
								<div class="col-md-2">
									<input type="date" class="form-control" name="fechaFinD" id="fechaFinD" value="<?php  echo !empty($fechaFin) ? $fechaFin:'';?>">
								</div>

								<label for="plaza_id" class="col-md-1 control-label">Plaza:</label>
								<div class="col-md-2">
									<select name="plaza_id" id="plaza_id" class="form-control">
										<?php foreach ($plazas as $plaza):?>
											<?php if($plaza->id==1):?><option value="" selected>Todas las Plazas</option><?php endif;?>
											<option value="<?php echo $plaza->id?>" <?php echo ($plaza->id == $id) ? 'selected' : ''; ?>><?php echo $plaza->Nombre;?></option>
										<?php endforeach;?>
									</select>
								</div>

								<label for="lugar_id_busqueda" class="col-md-1 control-label">Lugar:</label>
								<div class="col-md-2">
									<select name="lugar_id_busqueda" id="lugar_id_busqueda" class="form-control">
										<?php foreach ($lugares as $lugar):?>
											<?php if($lugar->id==1):?><option value="" selected>Seleccionar Lugar</option><?php endif;?>
											<option value="<?php echo $lugar->id?>" <?php echo ($lugar->id == $id_lugar) ? 'selected' : ''; ?>><?php echo $lugar->Nombre;?></option>
										<?php endforeach;?>
									</select>
								</div>
							</div>

							<div class="form-group">
								<label for="turno_id_busqueda" class="col-md-1 control-label">Turno:</label>
								<div class="col-md-2">
									<select name="turno_id_busqueda" id="turno_id_busqueda" class="form-control">
										<?php foreach ($turnos as $turno):?>
											<?php if($turno->id==1):?><option value="" selected>Seleccionar Turno</option><?php endif;?>
											<option value="<?php echo $turno->id?>" <?php echo ($turno->id == $id_turno) ? 'selected' : ''; ?>><?php echo $turno->Nombre;?></option>
										<?php endforeach;?>
									</select>
								</div>

								<label for="" class="col-md-1 control-label">Options:</label>
								<div class="col-md-4">
									<input type="submit" name="buscar" value="Buscar" class="btn btn-primary">
									<input type="submit" name="buscarRango" value="Buscar Rango" class="btn btn-danger">
								</div>
							</div>
						</form>
					</div>
				</div>

				<!-- 2. TABLAS DINÁMICAS OPTIMIZADAS -->
				<div class="row">
					<div class="col-md-12">
						<div class="form-group table-responsive">
							<?php
							// Filtrar las plazas y lugares a mostrar según los combos de búsqueda
							$plazasAMostrar = empty($id) ? $plazas : array_filter($plazas, function($p) use($id) { return $p->id == $id; });
							$lugaresAMostrar = empty($id_lugar) ? $lugares : array_filter($lugares, function($l) use($id_lugar) { return $l->id == $id_lugar; });
							?>

							<?php foreach ($plazasAMostrar as $plaza): ?>
								<table class="display responsive table table-bordered btn-hover nowrap" style="width:100%" id="tbl_usuarios_<?php echo $plaza->id; ?>">
									<thead>
									<tr>
										<th>PLAZA</th>
										<th>TURNO</th>
										<th colspan="2">Lun <?php echo $diasE[1] ?? '';?></th>
										<th colspan="2">Mar <?php echo $diasE[2] ?? '';?></th>
										<th colspan="2">Mier <?php echo $diasE[3] ?? '';?></th>
										<th colspan="2">Jue <?php echo $diasE[4] ?? '';?></th>
										<th colspan="2">Vie <?php echo $diasE[5] ?? '';?></th>
										<th colspan="2">Sab <?php echo $diasE[6] ?? '';?></th>
										<th colspan="2">Dom <?php echo $diasE[7] ?? '';?></th>
										<th>Totales</th>
									</tr>
									</thead>
									<tbody>
									<?php
									$totalPlaza = 0;
									foreach ($lugaresAMostrar as $lugar):
										$totalFila = isset($totalesFila[$plaza->id][$lugar->id]) ? $totalesFila[$plaza->id][$lugar->id] : 0;
										$totalPlaza += $totalFila;
										?>
										<tr>
											<td><b><?php echo strtoupper(substr($plaza->Nombre, 0, 3)); ?></b></td>
											<td><b><?php echo $lugar->Nombre; ?></b></td>

											<?php for ($dia = 1; $dia <= 7; $dia++): ?>
												<!-- Celda Matutino -->
												<td rowspan="1">
													<?php
													if (isset($matriz[$plaza->id][$lugar->id][1][$dia])) {
														echo implode("<br>", $matriz[$plaza->id][$lugar->id][1][$dia]);
													}
													?>
												</td>
												<!-- Celda Vespertino -->
												<td rowspan="1">
													<?php
													if (isset($matriz[$plaza->id][$lugar->id][2][$dia])) {
														echo implode("<br>", $matriz[$plaza->id][$lugar->id][2][$dia]);
													}
													?>
												</td>
											<?php endfor; ?>

											<td bgcolor="#d1ffaf"><b><?php echo $totalFila; ?></b></td>
										</tr>
									<?php endforeach; ?>

									<!-- Fila de Totales por Plaza -->
									<tr>
										<td bgcolor="#76c5ff"><b>TOTALES</b></td>
										<td bgcolor="#76c5ff"></td>
										<?php for ($dia = 1; $dia <= 7; $dia++): ?>
											<td bgcolor="#d1ffaf" colspan="2"></td>
										<?php endfor; ?>
										<td bgcolor="#d1ffaf"><b><?php echo $totalPlaza; ?></b></td>
									</tr>
									</tbody>
								</table>
								<br>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</div>
			<!-- /.box-body -->
		</div>
		<!-- /.box -->
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->


<!--TABLA PARA MOSTRAR EL HISTORIAL DE EVENTOS DE UN USUARIO-->
 <div class="modal fade" id="historialUsuarioModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Historial de Usuario</h4>
        </div>
        <div class="modal-body">
            <div class="responsive-table">
                <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_prueba_API" >
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Usuario</th>
                                        <th>Concepto</th>
                                        <th>Importe</th>
                                        <th>Nota</th>
                                        <th>Eliminar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cerrar</button>
        </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
<!--TABLA PARA MOSTRAR EL HISTORIAL DE EVENTOS DE UN USUARIO-->



<script type="text/javascript">
    var pruebaAPI= $('#tbl_prueba_API').DataTable({
            "aaSorting": [],
            dom: 'Bfrtip',
            "pageLength": 30,
            buttons: [
                {
                    extend: 'excelHtml5',
                    title: "Listado de Ventas",
                    exportOptions: {
                        columns: ':visible'
                    },
                },
                {
                    extend: 'pdfHtml5',
                    title: "Listado de Ventas",
                    exportOptions: {
                        columns: ':visible'
                    }

                }
            ],
            "language": {
                "lengthMenu": "Mostrar _MENU_ registros por pagina",
                "zeroRecords": "No se encontraron resultados en su busqueda",
                "searchPlaceholder": "Buscar registros",
                "info": "Mostrando registros de _START_ al _END_ de un total de  _TOTAL_ registros",
                "infoEmpty": "No existen registros",
                "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                "search": "Buscar:",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
            },
            responsive: true
    });


    function verEventos(fechaInicio,fechaFin,usuario_id){
        $('#historialUsuarioModal').modal('show');
        var parametros = {
                "fechaInicio" : fechaInicio,
                "fechaFin" : fechaFin,
                "usuario_id" : usuario_id
                };

                $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>Nominas/consultarHistorialUsuarios",
                data: parametros,
                dataType: "JSON",
                success: function(response){
                    pruebaAPI.clear();
                    var len = response.length;
                    for(var i=0; i<len; i++){
                        var id=response[i].usuario_nomina_id;
                        var fecha = response[i].Fecha;
                        var usuario=response[i].Usuario;
                        var concepto=response[i].Concepto;
                        var extra=response[i].Extra;
                        var nota=response[i].Nota;
                        var turno=response[i].turno_id;
                        var eliminar='<a href="#" onclick="eliminarEvento(\''+fecha+'\',\''+id+'\','+turno+')" class="btn btn-danger"><span class="fa fa-remove"></span></a></td>';
                        pruebaAPI.row.add([fecha,usuario,concepto,"$"+extra,nota,eliminar]);
                    }
                    pruebaAPI.draw();
                },
                error: function() {
                    alert("Error posting feed.");
                }
            });
    }
</script>
