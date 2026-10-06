<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Tabla de Nominas F.G.F
			<small>Listado </small>
		</h1>
		<a href="<?php echo base_url(); ?>Nominas" class="small-box-footer">Volver al Panel de Inicio <i class="fa fa-arrow-circle-right"></i></a>
	</section>
	<!-- Main content -->
	<section class="content">
		<!-- Default box -->
		<div class="box box-solid">
			<div class="box-body">
				<div class="row">
					<div class="col-md-12">
						<form action="<?php echo current_url();?>" method="POST" class="form-horizontal">
							<div class="form-group">
								<label for="fechaInicioD" class="col-md-1 control-label">Desde:</label>
								<div class="col-md-2">
									<input type="date" class="form-control" name="fechaInicioD" id="fechaInicioD" value="<?php echo !empty($fechainicio) ? $fechainicio:'';?>">
								</div>

								<label for="fechaFinD" class="col-md-1 control-label">Hasta:</label>
								<div class="col-md-2">
									<input type="date" class="form-control" name="fechaFinD" id="fechaFinD" value="<?php  echo !empty($fechafin) ? $fechafin:'';?>">
								</div>

								<label for="plaza_id" class="col-md-1 control-label">Plaza:</label>
								<div class="col-md-2">
									<select name="plaza_id" id="plaza_id" class="form-control">
										<?php foreach ($plazas as $plaza):?>
											<?php if($plaza->id==1):?>
												<option value="" selected>
													Todas las Plazas
												</option>
											<?php endif;?>
											<?php if($plaza->id==$id_plaza):?>
												<option value="<?php echo $plaza->id?>" selected>
													<?php echo $plaza->Nombre;?>
												</option>
											<?php else:?>
												<option value="<?php echo $plaza->id?>">
													<?php echo $plaza->Nombre;?>
												</option>
											<?php endif;?>
										<?php endforeach;?>
									</select>
								</div>

								<div class="col-md-3">
									<input type="submit" name="buscar" value="Buscar" class="btn btn-primary">
									<button type='button' class="btn btn-warning btn-flag" onclick="autorizarNomina(<?php echo $id_plaza;?>,'<?php echo $fechainicio;?>','<?php echo $fechafin;?>')"><span class="fa fa-check" ></span> Autorizar</button>
									<button type='button' class="btn btn-success btn-flag" onclick="modificarNomina(<?php echo $id_plaza;?>,'<?php echo $fechainicio;?>','<?php echo $fechafin;?>')"><span class="fa fa-refresh"></span></button>
								</div>
							</div>

							<div class="form-group">
								<label for="usuario_id" class="col-md-1 control-label">Usuario:</label>
								<div class="col-md-2">
									<select name="usuario_id" id="usuario_id" class="form-control">
										<option value="">Seleccionar Usuario</option>
										<?php if(isset($usuarios)):?>
											<?php foreach ($usuarios as $usuario):?>
												<?php if($usuario->id==$id_usuario):?>
													<option value="<?php echo $usuario->id?>" selected>
														<?php echo $usuario->Nombre." ".$usuario->Apellido_Paterno; ?>
													</option>
												<?php else:?>
													<option value="<?php echo $usuario->id?>">
														<?php echo $usuario->Nombre." ".$usuario->Apellido_Paterno; ?>
													</option>
												<?php endif;?>
											<?php endforeach;?>
										<?php endif;?>
									</select>
								</div>
								<div class="col-md-9">
									<button type='button' class="btn btn-primary btn-flag" onclick="historialUsuario()" ><span class="fa fa-search" ></span> Historial Usuario</button>
									<button type='button' class="btn btn-primary btn-flag" onclick="modalDiaFestivo(<?php echo $id_plaza;?>,'<?php echo $fechainicio;?>','<?php echo $fechafin;?>')"><span class="fa fa-plus" ></span> Día Feriado</button>
									<button type='button' class="btn btn-success btn-flag" onclick="modalAumentoSueldo()"><span class="fa fa-plus" ></span> Aumento de Sueldo</button>
								</div>
							</div>
						</form>

						<div class="form-group">
							<table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_usuarios_6">
								<thead>
								<tr>
									<?php
									$lunes = date( 'd', strtotime( 'monday this week' ));
									$martes = date( 'd', strtotime( 'tuesday this week' ));
									$miercoles = date( 'd', strtotime( 'wednesday this week' ));
									$jueves = date( 'd', strtotime( 'thursday this week' ));
									$viernes = date( 'd', strtotime( 'friday this week' ));
									$sabado = date( 'd', strtotime( 'saturday this week' ));
									$domingo = date( 'd', strtotime( 'sunday this week' ));
									$lunes2 = date( 'Y-m-d', strtotime( 'monday this week' ));
									$domingo2 = date( 'Y-m-d', strtotime( 'sunday this week' ));
									$acImporte=0;
									$acTotal=0;
									$acTurnos=0;
									$acExtra=0;

									?>
									<th>Estado</th>
									<th>Plaza</th>
									<th>Nombre</th>
									<th>Lun <?php echo $diasE[1] ?? '';?></th>
									<th>Mar <?php echo $diasE[2] ?? '';?></th>
									<th>Mier <?php echo $diasE[3] ?? '';?></th>
									<th>Jue <?php echo $diasE[4] ?? '';?></th>
									<th>Vie <?php echo $diasE[5] ?? '';?></th>
									<th>Sab <?php echo $diasE[6] ?? '';?></th>
									<th>Dom <?php echo $diasE[7] ?? '';?></th>
									<th>Total</th>
									<th>Sueldo</th>
									<th>Extra</th>
									<th>Total</th>
									<th>Detalles</th>
								</tr>
								</thead>
								<tbody>
								<?php if(!empty($semanas)):?>
									<?php foreach ($semanas as $semana):
										$acFila=+$semana->Lunes
											+$semana->Martes
											+$semana->Miercoles
											+$semana->Jueves
											+$semana->Viernes
											+$semana->Sabado
											+$semana->Domingo;

										$acImporte+=$acFila*$semana->Sueldo;
										$acTotal+=$semana->Total+$semana->Extra;
										$acTurnos+=$acFila;
										$acExtra+=$semana->Extra;
										?>

										<?php if($semana->Estado==0):?>
										<tr bgcolor="#ffbeb0">
										<td><b>CAPTURA</b></td>
									<?php elseif($semana->Estado==1):?>
										<tr>
										<td><b>REVISIÓN</b></td>
									<?php elseif($semana->Estado==2):?>
										<tr bgcolor="#d1ffaf">
										<td><b>LIBERADA</b></td>
									<?php endif; ?>

										<td><?=$semana->Plaza;?></td>
										<td><?=$semana->Nombre;?></td>
										<td><?=$semana->Lunes;?></td>
										<td><?=$semana->Martes;?></td>
										<td><?=$semana->Miercoles;?></td>
										<td><?=$semana->Jueves;?></td>
										<td><?=$semana->Viernes;?></td>
										<td><?=$semana->Sabado;?></td>
										<td><?=$semana->Domingo;?></td>
										<td bgcolor="#d1ffaf"><b><?=$acFila;?></b></td>
										<td bgcolor="#d1ffaf"><b>$<?=$semana->Sueldo;?></b></td>
										<td bgcolor="#d1ffaf"><b>$<?=$semana->Extra;?></b></td>
										<td bgcolor="#d1ffaf"><b>$<?=($semana->Total+$semana->Extra)?></b></td>
										<td>
											<button type="button" class="btn btn-info" onclick="verEventos('<?php echo $fechainicio;?>','<?php echo $fechafin;?>',<?php echo $semana->usuario_nomina_id;?>)" value="">
												<span class="fa fa-search"></span>
											</button>
										</td>
										</tr>
									<?php endforeach;?>
								<?php endif;?>
								<tr>
									<td bgcolor="#76c5ff"><b>TOTAL</b></td>
									<td bgcolor="#76c5ff"></td>
									<td bgcolor="#76c5ff"></td>
									<td bgcolor="#76c5ff"></td>
									<td bgcolor="#76c5ff"></td>
									<td bgcolor="#76c5ff"></td>
									<td bgcolor="#76c5ff"></td>
									<td bgcolor="#76c5ff"></td>
									<td bgcolor="#76c5ff"></td>
									<td bgcolor="#76c5ff"></td>
									<td bgcolor="#ffe9b5"><b><?=$acTurnos;?></b></td>
									<td bgcolor="#ffe9b5"><b>$<?=$acImporte;?></b></td>
									<td bgcolor="#ffe9b5"><b>$<?=$acExtra;?></b></td>
									<td bgcolor="#ffe9b5"><b>$<?=$acTotal;?></b></td>
									<td bgcolor="#76c5ff"></td>
								</tr>
								</tbody>
							</table>
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
<!-- /.Content-wrapper -->

<!--LISTADO DE USUARIOS EN NOMINA-->
<div class="modal fade" id="modal-default">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Listado de Usuarios en nomina</h4>
			</div>
			<div class="modal-body">
				<table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" >
					<thead>
					<tr>
						<th>Nombre</th>
						<th>Rol</th>
						<th>Plaza</th>
						<th>Editar</th>
						<th>Eliminar</th>
					</tr>
					</thead>
					<tbody>
					<?php if(!empty($usuarios)):?>
						<?php foreach ($usuarios as $usuario):?>
							<tr>
								<td><?=$usuario->Nombre;?></td>
								<td><?=$usuario->Rol;?></td>
								<td><?=$usuario->Plaza;?></td>
								<td>
									<button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-default" value="">
										<span class="fa fa-edit"></span>
									</button>
								</td>
								<td>
									<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-default" value="">
										<span class="fa fa-remove"></span>
									</button>
								</td>
							</tr>
						<?php endforeach;?>
					<?php endif;?>
					</tbody>
				</table>
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
<!--LISTADO DE USUARIOS EN NOMINA-->

<!--TABLA PARA MOSTRAR EL HISTORIAL DE EVENTOS DE UN USUARIO EN UN RANGO DE FECHAS-->
<div class="modal fade" id="historialUsuarioModal2">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Historial de Usuario del <?php echo $fechainicio." - ".$fechafin;?></h4>
			</div>
			<div class="modal-body">
				<div class="responsive-table">
					<table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_prueba_API2" >
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
<!--TABLA PARA MOSTRAR EL HISTORIAL DE EVENTOS DE UN USUARIO EN UN RANGO DE FECHAS-->

<!--TABLA PARA MOSTRAR EL HISTORIAL COMPLETO DE EVENTOS DE UN USUARIO-->
<div class="modal fade" id="historialUsuarioModal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Historial Completo del Usuario</h4>
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
<!--TABLA PARA MOSTRAR EL HISTORIAL COMPLETO DE EVENTOS DE UN USUARIO-->

<!--MODAL DIA FESTIVO-->
<!-- Modal -->
<div class="modal fade" id="diaFestivo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Dia Feriado</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" method="post" id="diaFeriado" name="diaFeriado">
					<input type="hidden" name="usuario_id_DF" id="usuario_id_DF">

					<div class="form-group">
						<label for="usuario_DF" class="col-sm-3 control-label">Usuario:</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="usuario_DF" name="usuario_DF" readonly>
						</div>
					</div>

					<div class="form-group">
						<label for="dia_editar_DF" class="col-sm-3 control-label">Día:</label>
						<div class="col-sm-8">
							<select name="dia_editar_DF" id="dia_editar_DF" class="form-control" required>
								<option value="">Seleccionar Día</option>
								<?php foreach ($dias as $dia):?>
									<option value="<?php echo $dia->id?>">
										<?php
										echo $dia->Nombre;?>
									</option>
								<?php endforeach;?>
							</select>
						</div>
					</div>


					<div class="form-group">
						<label for="concepto_id_DF" class="col-sm-3 control-label">Concepto:</label>
						<div class="col-sm-8">
							<select name="concepto_id_DF" id="concepto_id_DF" class="form-control" required>
								<option value="">Seleccionar Concepto</option>
								<?php foreach ($conceptos as $concepto):?>
									<option value="<?php echo $concepto->id?>">
										<?php
										echo $concepto->Nombre;?>
									</option>
								<?php endforeach;?>
							</select>
						</div>
					</div>



					<div class="form-group">
						<label for="importe_DF" class="col-sm-3 control-label">Importe:</label>
						<div class="col-sm-8">
							<input type="number" class="form-control" id="importe_DF" placeholder="" name="importe_DF" value="" required>
						</div>
					</div>

					<div class="form-group" >
						<label for="nota_nota_DF" class="col-sm-3 control-label">Notas: </label>
						<div class="col-sm-8">
							<textarea rows="4" cols="53" id="nota_nota_DF" name="nota_nota_DF" required></textarea>
						</div>
					</div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="submit" class="btn btn-primary" id="btn_dia_feriado">Actualizar datos</button>
			</div>
			</form>
		</div>
	</div>
</div>
<!--MODAL DIA FESTIVO-->

<!--MODAL AUMENTO SUELDO-->
<!-- Modal -->
<div class="modal fade" id="aumentoSueldo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i>Aumento Sueldo</h4>
			</div>
			<div class="modal-body">

				<form class="form-horizontal" method="post" id="aumentoSueldoF" name="aumentoSueldoF">
					<input type="hidden" name="usuario_id" id="usuario_id_sueldo">
					<div class="form-group">
						<label for="usuario_sueldo" class="col-sm-3 control-label">Usuario:</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="usuario_sueldo" name="usuario_sueldo" readonly>
						</div>
					</div>

					<div class="form-group">
						<label for="antiguo_sueldo" class="col-sm-3 control-label">Antiguo Sueldo:</label>
						<div class="col-sm-8">
							<input type="number" class="form-control" id="antiguo_sueldo" placeholder="" name="antiguo_sueldo" value="" readonly>
						</div>
					</div>

					<div class="form-group">
						<label for="importe_sueldo" class="col-sm-3 control-label">Nuevo Sueldo:</label>
						<div class="col-sm-8">
							<input type="number" class="form-control" id="importe_sueldo" placeholder="" name="nuevo_sueldo" value="" required>
						</div>
					</div>

					<div class="form-group" >
						<label for="nota_nota_sueldo" class="col-sm-3 control-label">Notas: </label>
						<div class="col-sm-8">
							<textarea rows="4" cols="53" id="nota_nota_sueldo" name="nota_nota_sueldo" required></textarea>
						</div>
					</div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="submit" class="btn btn-primary" id="btn_aumento_sueldo">Actualizar datos</button>
			</div>
			</form>
		</div>
	</div>
</div>

<!--MODAL AUMENTO SUELDO-->

<script type="text/javascript">

	//#region AGREGAR USUARIOS N
	$( "#asignarSueldoC" ).submit(function( event ) {
		var parametros = $(this).serialize();
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>Nominas/asignarSueldo",
			data: parametros,
			success: function(response){
				if(response==1){
					swal({
						position: 'top-end',
						type: 'success',
						title: 'Sueldo asignado correctamente!!',
						showConfirmButton: false,
						timer: 1000
					}).then(function() {
						location.reload();
					});
				}
				else if(response==0){
					swal({
						position: 'top-end',
						type: 'error',
						title: 'Ocurrio un error al registrar el sueldo',
						showConfirmButton: false,
						timer: 1500
					}).then(function() {
					});
				}
			},
			error: function() {
				alert("Error posting feed.");
			}
		});
		event.preventDefault();
	});
	//#endregion

	//#region AGREGAR USUARIOS N
	$( "#aumentoSueldoF" ).submit(function( event ) {
		var parametros = $(this).serialize();

		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>Nominas/aumentarSueldo",
			data: parametros,
			success: function(response){
				if(response==1){
					swal({
						position: 'top-end',
						type: 'success',
						title: 'Sueldo asignado correctamente!!',
						showConfirmButton: false,
						timer: 1000
					}).then(function() {
						location.reload();
					});
				}
				else if(response==0){
					swal({
						position: 'top-end',
						type: 'error',
						title: 'Ocurrio un error al registrar el sueldo',
						showConfirmButton: false,
						timer: 1500
					}).then(function() {
					});
				}
			},
			error: function() {
				alert("Error posting feed.");
			}
		});
		event.preventDefault();
	});
	//#endregion

	//#region EDITANDO EL ROL DE USUARIOS
	$( "#editarRolN" ).submit(function( event ) {
		var parametros = $(this).serialize();
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>Nominas/actualizarRolSemanal",
			data: parametros,
			success: function(response){
				if(response==1){
					swal({
						position: 'top-end',
						type: 'success',
						title: 'Usuario registrado correctamente!!',
						showConfirmButton: false,
						timer: 1000
					}).then(function() {
						location.reload();
					});
				}
				else if(response==2){
					swal({
						position: 'top-end',
						type: 'info',
						title: 'Número de turnos sobrepasado',
						showConfirmButton: false,
						timer: 1500
					}).then(function() {
					});
				}
				else if(response==0){
					swal({
						position: 'top-end',
						type: 'error',
						title: 'Ocurrio un error al registrar el usuario',
						showConfirmButton: false,
						timer: 1500
					}).then(function() {
					});
				}
			},
			error: function() {
				alert("Error posting feed.");
			}
		});
		event.preventDefault();
	});
	//#endregion

	//#region AL CAMBIAR EL INSUMO DE LOS GRUPOS DE GASTOS SE ACTUALIZA LA UNIDAD
	$('#dia_editar_id').change(function(){
		var dia_editar_id = $('#dia_editar_id').val();
		var id=$('#id_editarN').val();
		var fechaInicio=$('#fecha_inicio_editarN').val();
		var fechaFin=$('#fecha_fin_editarN').val();

		var parametros =
			{
				"usuario_id" : id,
				"fecha_inicio" : fechaInicio,
				"fecha_fin" : fechaFin,
				"dia_id": dia_editar_id
			};

		if(dia_editar_id != ''){
			$.ajax({
				url:"<?php echo base_url(); ?>Nominas/consultarTurno",
				method:"POST",
				data: parametros,
				success:function(data){
					$('#turno_editar_id').html(data);
				}
			});
		}
		else{
			// ...
		}
	});
	//#endregion

	//#region AL CAMBIAR EL GRUPO DE GASTOS DE REMESAS SE ACTUALIZAN LOS INSUMOS DE CADA GRUPO
	$('#plaza_id').change(function(){
		$('#usuario_id').html('<option value="">Seleccionar Usuario</option>');
		var plaza_id = $('#plaza_id').val();
		if(plaza_id != ''){
			$.ajax({
				url:"<?php echo base_url(); ?>Nominas/consultarUsuarios",
				method:"POST",
				data:{plaza_id:plaza_id},
				success:function(data)
				{
					$('#usuario_id').html(data);
				}
			});
		}
		else{
			$('#usuario_id').html('<option value="">Seleccionar Usuario</option>');
		}
	});
	//#endregion

	//#region DIA FERIADO
	$( "#diaFeriado" ).submit(function( event ) {
		var parametros = $(this).serialize() + '&fechaInicio=' + $('#fechaInicioD').val() + '&fechaFin=' + $('#fechaFinD').val();
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>Nominas/diaFeriadoC",
			data: parametros,
			success: function(response){
				if(response==0){
					swal({
						position: 'top-end',
						type: 'error',
						title: 'Ocurrio un error al actualizar el rol semanal',
						showConfirmButton: false,
						timer: 1500
					});
				}
				else if(response==1){
					swal({
						position: 'top-end',
						type: 'success',
						title: 'Rol semanal actualizado correctamente!!',
						showConfirmButton: false,
						timer: 1000
					}).then(function() {
						location.reload();
					});
				}
				else if(response==2){
					swal({
						position: 'top-end',
						type: 'info',
						title: 'El usuario seleccionado no se encuentra rolado en la semana actual',
						showConfirmButton: false,
						timer: 1500
					});
				}
			},
			error: function() {
				swal({
					position: 'top-end',
					type: 'error',
					title: 'Error FEED al actualizar el rol semanal',
					showConfirmButton: false,
					timer: 1500
				});
			}
		});
		event.preventDefault();
	});
	//#endregion

	function agregarUsuarioRol(nombre,id){
		var parametros = {
			"id" : id
		};
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>Nominas/agregarUsuarioRol",
			data: parametros,
			success: function(response){
				if(response==1){
					alert("Usuario agregado al rol correctamente");
				}else{
					alert("Ocurrio un errror al agregar el usuario");
				}
			},
			error: function() { alert("Error posting feed3."); }
		});
	}

	function autorizarNomina(plaza_id,fechaInicio,fechaFin){
		var parametros =
			{
				"plaza_id" : plaza_id,
				"fechaInicio":fechaInicio,
				"fechaFin":fechaFin
			};

		swal({
			title: '¿Está seguro?',
			text: "Desea autorizar el rol semanal",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Si, autorizar',
			cancelButtonText: 'No'
		}).then((result) => {
			if (result.value) {
				$.ajax({
					type: "POST",
					url: "<?php echo base_url();?>Nominas/liberarNominaAdmin",
					data: parametros,
					success: function(data){
						if(data==1){
							swal({
								title: "Nomina correctamente liberada!",
								text: "Nomina liberada",
								type: "success"
							}).then(function() {
								location.reload();
							});
						}
						else if(data==0){
							swal({
								type: 'error',
								title: 'Ha ocurrido un error al liberar la nomina',
								text: 'No se pudo liberar la nomina'
							}).then(function() {
								//location.reload();
							});
						}
						else if(data==2){
							swal({
								type: 'error',
								title: 'Debe de seleccionar una plaza para poder autorizar',
								text: 'No hay nomina seleccionada'
							}).then(function() {
								//location.reload();
							});
						}
						else if(data==3){
							swal({
								type: 'info',
								title: 'La nomina de la plaza esta vacia',
								text: 'No se puede liberar'
							}).then(function() {
								//location.reload();
							});
						}
						else if(data==4){
							swal({
								type: 'info',
								title: 'La nomina aún no ha sido liberada por el manager',
								showConfirmButton: false,
								timer: 1500
							});
						}
					},
					error: function() {
						swal({
							type: 'error',
							title: 'Error FEED desconocido',
							text: 'Error desconocido por favor contacte al administrador'
						}).then(function() {
							//location.reload();
						});
					}
				});
			}
		});
	}

	function modificarNomina(plaza_id,fechaInicio,fechaFin){
		var parametros =
			{
				"plaza_id" : plaza_id,
				"fechaInicio":fechaInicio,
				"fechaFin":fechaFin
			};

		swal({
			title: '¿Está seguro?',
			text: "Desea otorgar permisos de edición",
			type: 'info',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Si,otorgar',
			cancelButtonText: 'No'
		}).then((result) => {
			if (result.value) {
				$.ajax({
					type: "POST",
					url: "<?php echo base_url();?>Nominas/otorgarPermiso",
					data: parametros,
					success: function(data){
						if(data==1){
							swal({
								title: "Permiso Correctamente otorgado!",
								text: "Permiso otorgado",
								type: "success"
							}).then(function() {
								location.reload();
							});
						}else if(data==0){
							swal({
								type: 'error',
								title: 'Ha ocurrido un error al otorgar el permiso',
								text: 'No se pudo otorgar el permiso'
							}).then(function() {
								//location.reload();
							});
						}
					},
					error: function() {
						swal({
							type: 'error',
							title: 'Error FEED desconocido',
							text: 'Error desconocido por favor contacte al administrador'
						}).then(function() {
							//location.reload();
						});
					}
				});
			}
		});
	}

	function editarUsuarioRol(nombre,id,fechaInicio,fechaFin){
		$('#nombre_editarN').val(nombre);
		$('#id_editarN').val(id);
		$('#fecha_inicio_editarN').val(fechaInicio);
		$('#fecha_fin_editarN').val(fechaFin);

		var usuario_id=$('#id_editarN').val();
		var fecha_inicio=$('#fecha_inicio_editarN').val();
		var fecha_fin=$('#fecha_fin_editarN').val();
	}

	function asignarUsuarioRol(nombre,id){
		$('#nombre_agregar_rol').val(nombre);
		$('#id_agregar_rol').val(id);
	}

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

	var pruebaAPI2= $('#tbl_prueba_API2').DataTable({
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

	function modalDiaFestivo(plaza_id,fechaInicio,fechaFin){

		var usuario_id = $('#usuario_id').val();
		var nombreUsuario=$("#usuario_id option:selected" ).text();
		nombreUsuario=nombreUsuario.replace(/\s/g,'');
		$('#usuario_DF').val(nombreUsuario);

		if(usuario_id!=""){

			var parametros =
				{
					"plaza_id" : plaza_id,
					"fechaInicio" : fechaInicio,
					"fechaFin" : fechaFin
				};
			$.ajax({
				type: "POST",
				url: "<?php echo base_url();?>Nominas/consultarEstado",
				data: parametros,
				success: function(data){
					if(data==0){
						swal({
							type: 'info',
							title: 'Nomina no liberada aún por el manager',
							text: 'La nomina aún  esta siendo capturada'
						});
					}else if(data==1){
						$('#usuario_id_DF').val(usuario_id);
						$('#diaFestivo').modal('show');
					}
					else if(data==2){
						swal({
							type: 'info',
							title: 'No se pueden agregar extras',
							text: 'La nomina ya fue liberada por el administrador'
						});
					}
				},
				error: function() {

				}
			});
		}else{
			swal
			({
				type: 'info',
				title: 'Seleccione un usuario para agregar un evento',
				showConfirmButton: false,
				timer: 1000
			});
		}
	}

	function modalAumentoSueldo(){
		var usuario_id = $('#usuario_id').val();
		var nombreUsuario=$("#usuario_id option:selected" ).text();
		nombreUsuario=nombreUsuario.replace(/\s/g,'');
		$('#usuario_sueldo').val(nombreUsuario);

		if(usuario_id!=""){
			$('#usuario_id_sueldo').val(usuario_id);
			var parametros =
				{
					"usuario_id" : usuario_id
				};
			$.ajax({
				type: "POST",
				url: "<?php echo base_url();?>Nominas/consultarSueldoID",
				data: parametros,
				success: function(data){
					$('#antiguo_sueldo').val(data);
					$('#aumentoSueldo').modal('show');
				},
				error: function() {

				}
			});
		}else{
			swal
			({
				type: 'info',
				title: 'Seleccione un usuario para agregar el aumento de sueldo',
				showConfirmButton: false,
				timer: 1000
			});
		}
	}

	function eliminarEventoUsuario(id){
		var parametros =
			{
				"id" : id
			};
		swal({
			title: '¿Está seguro?',
			text: "Desea eliminar el evento",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Si, eliminar',
			cancelButtonText: 'No'
		}).then((result) => {
			if (result.value) {
				$.ajax({
					type: "POST",
					url: "<?php echo base_url();?>Nominas/eliminarEventoUsuario",
					data: parametros,
					success: function(data){
						if(data==1){
							swal({
								title: "Evento correctamente eliminado!",
								text: "Evento eliminado!",
								showConfirmButton: false,
								type: "success",
								timer: 800
							}).then(function() {
								location.reload();
							});
						}else if(data==0){
							swal({
								title: "Ocurrio un error al eliminar el evento!",
								text: "Evento NO eliminado!",
								showConfirmButton: false,
								type: "error",
								timer: 800
							});
						}
					},
					error: function() {
						swal({
							type: 'error',
							title: 'Error FEED desconocido',
							text: 'Error desconocido por favor contacte al administrador',
							timer: 800,
							showConfirmButton: false
						});
					}
				});
			}
		});
	}

	function verEventos(fechaInicio,fechaFin,usuario_id){
		$('#historialUsuarioModal2').modal('show');
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
				pruebaAPI2.clear();
				var len = response.length;
				var acImporte=0;

				for(var i=0; i<len; i++){
					var code=response[i].id;
					var id=response[i].usuario_nomina_id;
					var fecha = response[i].Fecha;
					var usuario=response[i].Usuario;
					var concepto=response[i].Concepto;
					var importe=response[i].Importe;
					var nota=response[i].Nota;
					acImporte=parseFloat(acImporte)+parseFloat(importe);
					var eliminar='<a href="#" onclick="eliminarEvento(\''+fecha+'\',\''+id+'\','+code+')" class="btn btn-danger"><span class="fa fa-remove"></span></a></td>';
					pruebaAPI2.row.add([fecha,usuario,concepto,"$"+importe,nota,eliminar]);
				}

				pruebaAPI2.row.add(["Totales","","",("$ "+acImporte).bold(),"",""]);
				pruebaAPI2.draw();
			},
			error: function() {
				alert("Error posting feed.");
			}
		});
	}

	function historialUsuario(){

		var usuario_id = $('#usuario_id').val();
		if(usuario_id!=""){
			$('#historialUsuarioModal').modal('show');

			var parametros = {
				"usuario_id" : usuario_id
			};

			$.ajax({
				type: "POST",
				url: "<?php echo base_url();?>Nominas/consultarHistorialUsuariosAdministrador",
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
						var extra=response[i].Importe;
						var nota=response[i].Nota;
						var turno=response[i].turno_id;
						pruebaAPI.row.add([fecha,usuario,concepto,"$"+extra,nota]);
					}
					pruebaAPI.draw();
				},
				error: function() {
					alert("Error posting feed.");
				}
			});
		}
		else{
			swal({
				type: 'info',
				title: 'Seleccione un usuario para mostrar el historial',
				showConfirmButton: false,
				timer: 1000
			});
		}

	}

	function eliminarEvento(fecha,usuario_id,code){

		var parametros = {
			"fecha":fecha,
			"usuario_id":usuario_id,
			"code":code
		};

		swal({
			title: '¿Está seguro?',
			text: "Desea eliminar el evento",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Si, eliminar',
			cancelButtonText: 'No'
		}).then((result) => {
			if (result.value) {
				$.ajax({
					type: "POST",
					url: "<?php echo base_url();?>Nominas/eliminarEventoC",
					data: parametros,
					success: function(data){
						if(data==0){
							swal({
								position: 'top-end',
								type: 'error',
								title: 'Ha ocurrido un error al tratar de eliminar el evento',
								showConfirmButton: false,
								timer: 1500
							});
						}
						else if(data==1){
							swal({
								position: 'top-end',
								type: 'success',
								title: 'Evento correctamente eliminado !!',
								showConfirmButton: false,
								timer: 1000
							}).then(function() {
								location.reload();
							});
						}
						else if(data==2)
						{
							swal({
								position: 'top-end',
								type: 'error',
								title: 'No se encontro el evento. No se pudo eliminar',
								showConfirmButton: false,
								timer: 1500
							});
						}
					},
					error: function() {
						swal({
							type: 'error',
							title: 'Error FEED desconocido',
							text: 'Error desconocido por favor contacte al administrador'
						}).then(function() {
							//location.reload();
						});

					}
				});
			}
		});
	}

</script>
