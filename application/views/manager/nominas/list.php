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
			<small>Listado del <?php echo $lunes?> al <?php echo $domingo?></small>
		</h1>
		<h4>Estado: En captura</h4>
		<a href="<?php echo base_url(); ?>Nominas/manager" class="small-box-footer">Volver al Panel de Nominas<i class="fa fa-arrow-circle-right"></i></a>
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

								<label for="" class="col-md-1 control-label">Desde:</label>
								<div class="col-md-3">
									<input type="date" class="form-control" name="fechaInicioD" id="fechaInicioD" value="<?php echo !empty($fechaInicio) ? $fechaInicio:'';?>">
								</div>

								<label for="" class="col-md-1 control-label">Hasta:</label>
								<div class="col-md-3">
									<input type="date" class="form-control" name="fechaFinD" id="fechaFinD" value="<?php  echo !empty($fechaFin) ? $fechaFin:'';?>">
								</div>


								<div class="col-md-3">
									<input type="submit" name="buscar" value="Buscar" class="btn btn-primary">

								</div>
							</div>
							<div class="form-group">
								<label for="" class="col-md-1 control-label">Options:</label>
								<div class="col-md-11">
									<button type='button' class="btn btn-primary btn-flag" data-toggle="modal" data-target="#modal-default"><span class="fa fa-search" ></span> Ver Usuarios</button>
									<button type='button' class="btn btn-warning btn-flag" data-toggle="modal" data-target="#agregarDia"><span class="fa fa-plus" ></span> Agregar a Rol</button>
									<button type='button' class="btn btn-success btn-flag" onclick="liberarNominaManager('<?php echo $fechaInicio; ?>','<?php echo $fechaFin; ?>')"><span class="fa fa-check" ></span> Liberar Nomina</button>
								</div>
							</div>
						</form>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_usuarios">
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
									$i=0;
									$acTotal=0;
									$acTurnos=0;
									?>
									<th>Nombre</th>
									<th>Lun <?php echo $diasE[1] ?? '';?></th>
									<th>Mar <?php echo $diasE[2] ?? '';?></th>
									<th>Mier <?php echo $diasE[3] ?? '';?></th>
									<th>Jue <?php echo $diasE[4] ?? '';?></th>
									<th>Vie <?php echo $diasE[5] ?? '';?></th>
									<th>Sab <?php echo $diasE[6] ?? '';?></th>
									<th>Dom <?php echo $diasE[7] ?? '';?></th>
									<th>Turnos</th>

									<?php if($estado==0):?>
										<th>Editar</th>
									<?php elseif($estado==1):?>
										<th>Sueldo</th>
										<th>Extra</th>
										<th>Total</th>
									<?php elseif($estado==2):?>
										<th>Sueldo</th>
										<th>Extra</th>
										<th>Total</th>
										<th>Ver</th>
									<?php endif;?>

								</tr>
								</thead>
								<tbody>
								<?php if(!empty($semanas)):?>
									<?php
									$acLunes=0;
									$acMartes=0;
									$acMiercoles=0;
									$acJueves=0;
									$acViernes=0;
									$acSabado=0;
									$acDomingo=0;
									$acSueldo=0;
									$acExtra=0;
									?>
									<?php foreach ($semanas as $semana):
										$acFila=$semana->Lunes
											+$semana->Martes
											+$semana->Miercoles
											+$semana->Jueves
											+$semana->Viernes
											+$semana->Sabado
											+$semana->Domingo;

										$acLunes+=$semana->Lunes;
										$acMartes+=$semana->Martes;
										$acMiercoles+=$semana->Miercoles;
										$acJueves+=$semana->Jueves;
										$acViernes+=$semana->Viernes;
										$acSabado+=$semana->Sabado;
										$acDomingo+=$semana->Domingo;

										$acTotal+=$semana->Total+$semana->Extra;

										$acSueldo+=$semana->Total;
										$acExtra+=$semana->Extra;

										$acTurnos+=$acFila;

										?>

										<?php if($semana->Estado==1):?>
										<tr bgcolor="#ffbeb0">
									<?php elseif($semana->Estado==2):?>
										<tr bgcolor="#d1ffaf">
									<?php else:?>
										<tr>
									<?php endif; ?>

										<td><b><?=$semana->Nombre;?></b></td>
										<td><?=$semana->Lunes;?></td>
										<td><?=$semana->Martes;?></td>
										<td><?=$semana->Miercoles;?></td>
										<td><?=$semana->Jueves;?></td>
										<td><?=$semana->Viernes;?></td>
										<td><?=$semana->Sabado;?></td>
										<td><?=$semana->Domingo;?></td>
										<td><b><?=$acFila;?></b></td>
										<?php if($estado==0):?>
										<td>
											<button type="button" class="btn btn-success" onclick="editarUsuarioRol('<?php echo $semana->Nombre;?>',<?php echo $semana->usuario_nomina_id;?>,'<?php echo date('Y-m-d');?>')"   data-toggle="modal" data-target="#editarRolSemanalUsuario" value="">
												<span class="fa fa-edit"></span>
											</button>

										</td>
									<?php elseif($estado==1):?>
										<td>$<?=$semana->Total;?></td>
										<td>$<?=$semana->Extra;?></td>
										<td>$<?=$semana->Total+$semana->Extra;?></td>
									<?php elseif($estado==2):?>
										<td>$<?=$semana->Total;?></td>
										<td>$<?=$semana->Extra;?></td>
										<td>$<?=$semana->Total+$semana->Extra;?></td>
										<td>
											<button type="button" class="btn btn-info" onclick="verEventos('<?php echo $fechaInicio;?>','<?php echo $fechaFin;?>',<?php echo $semana->usuario_nomina_id;?>)" value="">
												<span class="fa fa-search"></span>
											</button>
										</td>
									<?php endif;?>
										</tr>
									<?php endforeach;?>
									<tr>
										<td bgcolor="#76c5ff">TOTALES</td>
										<td bgcolor="#c2f998" ><b><?=$acLunes;?></b></td>
										<td bgcolor="#c2f998" ><b><?=$acMartes;?></b></td>
										<td bgcolor="#c2f998" ><b><?=$acMiercoles;?></b></td>
										<td bgcolor="#c2f998" ><b><?=$acJueves;?></b></td>
										<td bgcolor="#c2f998" ><b><?=$acViernes;?></b></td>
										<td bgcolor="#c2f998" ><b><?=$acSabado;?></b></td>
										<td bgcolor="#c2f998" ><b><?=$acDomingo;?></b></td>
										<td bgcolor="#c2f998" ><b><?=$acTurnos;?></b></td>
										<?php if($estado==0):?>
											<td bgcolor="#c2f998"></td>
										<?php elseif($estado==1):?>
											<td bgcolor="#c2f998"><b>$<?=$acSueldo;?></b></td>
											<td bgcolor="#c2f998"><b>$<?=$acExtra;?></b></td>
											<td bgcolor="#c2f998"><b>$<?=$acTotal;?></b></td>
										<?php elseif($estado==2):?>
											<td bgcolor="#c2f998"><b>$<?=$acExtra;?></b></td>
											<td bgcolor="#c2f998"><b>$<?=$acSueldo;?></b></td>
											<td bgcolor="#c2f998"><b>$<?=$acTotal;?></b></td>
											<td bgcolor="#c2f998"></td>
										<?php endif;?>
									</tr>
								<?php endif;?>
								</tbody>
							</table>
						</div>

						<div class="form-group">
							<table class="display responsive table table-bordered btn-hover nowrap" style="width:100%" id="tbl_rol_nominas_2">
								<thead>
								<tr>
									<th>LUGAR / TURNO</th>
									<th colspan="2">Lun <?php echo $diasE[1] ?? '';?></th>
									<th colspan="2">Mar <?php echo $diasE[2] ?? '';?></th>
									<th colspan="2">Mier <?php echo $diasE[3] ?? '';?></th>
									<th colspan="2">Jue <?php echo $diasE[4] ?? '';?></th>
									<th colspan="2">Vie <?php echo $diasE[5] ?? '';?></th>
									<th colspan="2">Sab <?php echo $diasE[6] ?? '';?></th>
									<th colspan="2">Dom <?php echo $diasE[7] ?? '';?></th>
									<th colspan="2">Turnos</th>
								</tr>
								</thead>
								<tbody>
								<?php
								$totalesLugar = 0;
								$granTotalGral = 0;
								$subtotalesMat = array_fill(1, 7, 0);
								$subtotalesVesp = array_fill(1, 7, 0);

								foreach ($lugares as $lugar):
									$l_id = $lugar->id;
									$totalesLugar = 0;
									?>
									<!-- Color de fondo según el estado de liberación -->
									<tr <?php echo ($estado==1) ? 'bgcolor="ffbeb0"' : (($estado==2) ? 'bgcolor="#d1ffaf"' : ''); ?>>
										<td><b><?php echo strtoupper($lugar->Nombre); ?></b></td>

										<?php for ($dia = 1; $dia <= 7; $dia++):
											// MATUTINO (Turno 1)
											$celdaMat = isset($matrizAsignaciones[$l_id][1][$dia]) ? $matrizAsignaciones[$l_id][1][$dia] : [];
											$countMat = count($celdaMat);
											$subtotalesMat[$dia] += $countMat;
											$totalesLugar += $countMat;
											$granTotalGral += $countMat;
											?>
											<td rowspan="1"><?php echo empty($celdaMat) ? '' : implode("<br>", $celdaMat); ?></td>

											<?php
											// VESPERTINO (Turno 2)
											$celdaVesp = isset($matrizAsignaciones[$l_id][2][$dia]) ? $matrizAsignaciones[$l_id][2][$dia] : [];
											$countVesp = count($celdaVesp);
											$subtotalesVesp[$dia] += $countVesp;
											$totalesLugar += $countVesp;
											$granTotalGral += $countVesp;
											?>
											<td rowspan="1"><?php echo empty($celdaVesp) ? '' : implode("<br>", $celdaVesp); ?></td>
										<?php endfor; ?>

										<td bgcolor="#c2f998" colspan="2" style="text-align: center;"><b><?php echo $totalesLugar; ?></b></td>
									</tr>
								<?php endforeach; ?>

								<!-- Fila TOTAL -->
								<tr <?php echo ($estado==1) ? 'bgcolor="ffbeb0"' : (($estado==2) ? 'bgcolor="#d1ffaf"' : ''); ?>>
									<td bgcolor="#76c5ff"><b>TOTAL</b></td>
									<?php for ($dia = 1; $dia <= 7; $dia++): ?>
										<td bgcolor="#c2f998" colspan="2" style="text-align: center;">
											<b><?php echo $subtotalesMat[$dia] + $subtotalesVesp[$dia]; ?></b>
										</td>
									<?php endfor; ?>
									<td bgcolor="#c2f998" colspan="2" style="text-align: center;"><b><?php echo $granTotalGral; ?></b></td>
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
<!-- /.content-wrapper -->


<!--AGREGADO A ROL SEMANAL-->
<!--/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
<!-- Modal -->
<div class="modal fade" id="agregarDia" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Agregar Usuarios a rol semanal</h4>
			</div>

			<div class="modal-body">
				<form class="form-horizontal" method="post" id="guardarRolN" name="guardarRolN">
					<div class="form-group">
						<label for="usuario_agregar_id" class="col-sm-3 control-label">Usuario:</label>
						<div class="col-sm-8">
							<select name="usuario_agregar_id" id="usuario_agregar_id" class="form-control" required>
								<option value="">Seleccionar Usuario</option>
								<?php foreach ($usuarios as $usuario):?>
									<option value="<?php echo $usuario->id?>">
										<?php
										echo $usuario->Nombre." ".$usuario->Apellido_Paterno;?>
									</option>
								<?php endforeach;?>
							</select>
						</div>
					</div>


					<div class="form-group">
						<label for="dia_id" class="col-sm-3 control-label">Día:</label>
						<div class="col-sm-8">
							<select name="dia_id" id="dia_id" class="form-control" required>
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
						<label for="lugar_id" class="col-sm-3 control-label">Lugar:</label>
						<div class="col-sm-8">
							<select name="lugar_id" id="lugar_id" class="form-control" required>
								<option value="">Seleccionar Lugar</option>
								<?php foreach ($lugares as $lugar):?>
									<option value="<?php echo $lugar->id?>">
										<?php
										echo $lugar->Nombre;?>
									</option>
								<?php endforeach;?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label for="turno_id" class="col-sm-3 control-label">Turno:</label>
						<div class="col-sm-8">
							<select name="turno_id" id="turno_id" class="form-control" required>
								<option value="">Seleccionar Turno</option>
								<?php foreach ($turnos as $turno):?>
									<option value="<?php echo $turno->id?>">
										<?php
										echo $turno->Nombre;?>
									</option>
								<?php endforeach;?>
							</select>
						</div>
					</div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="submit" class="btn btn-primary" id="guardar_rolN">Guardar datos</button>
			</div>
			</form>
		</div>
	</div>
</div>
<!--/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
<!--LISTADO DE USUARIOS-->
<!--/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->


<!--EDICIÓN DEL ROL SEMANAL POR USUARIO-->
<!--/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
<!-- Modal -->
<div class="modal fade" id="editarRolSemanalUsuario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Edición del rol semanal</h4>
			</div>
			<div class="modal-body">

				<form class="form-horizontal" method="post" id="editarRolN" name="editarRolN">
					<input type="hidden" name="id_editarN" id="id_editarN">

					<div class="form-group">
						<label for="nombre_editarN" class="col-sm-3 control-label">Usuario:</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="nombre_editarN" placeholder="" name="nombre_editarN" value="" required readonly>
						</div>
					</div>

					<div class="form-group">
						<label for="dia_editarN" class="col-sm-3 control-label">Día:</label>
						<div class="col-sm-8">
							<select name="dia_editarN" id="dia_editarN" class="form-control" required>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label for="lunes" class="col-sm-3 control-label">T. Matutino:</label>
						<div class="col-sm-8">
							<label class="radio-inline">
								<input type="radio" name="matutino_editar" id="matutino_editar" value="1" onclick="" >Barra
							</label>
							<label class="radio-inline">
								<input type="radio" name="matutino_editar" id="matutino_editar" value="2" onclick="">Mesas
							</label>
							<label class="radio-inline">
								<input type="radio" name="matutino_editar" id="matutino_editar" value="3" onclick="">Cocina
							</label>

							<label class="radio-inline">
								<input type="radio" name="matutino_editar" id="matutino_editar" value="4" onclick="">Apoyo
							</label>

							<label class="radio-inline">
								<input type="radio" name="matutino_editar" id="matutino_editar" value="5" onclick="" checked>No
							</label>
						</div>
					</div>

					<div class="form-group">
						<label for="lunes" class="col-sm-3 control-label">T. Vespertino:</label>
						<div class="col-sm-8">
							<label class="radio-inline">
								<input type="radio" name="vespertino_editar" id="vespertino_editar" value="1" onclick="" >Barra
							</label>
							<label class="radio-inline">
								<input type="radio" name="vespertino_editar" id="vespertino_editar" value="2" onclick="">Mesas
							</label>
							<label class="radio-inline">
								<input type="radio" name="vespertino_editar" id="vespertino_editar" value="3" onclick="">Cocina
							</label>
							<label class="radio-inline">
								<input type="radio" name="vespertino_editar" id="vespertino_editar" value="4" onclick="">Apoyo
							</label>
							<label class="radio-inline">
								<input type="radio" name="vespertino_editar" id="vespertino_editar" value="5" onclick="" checked>No
							</label>
						</div>
					</div>


			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="submit" class="btn btn-primary" id="editar_rolN">Actualizar datos</button>
			</div>
			</form>
		</div>
	</div>
</div>
<!--/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
<!--EDICIÓN DEL ROL SEMANAL POR USUARIO-->
<!--/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->


<!--EDICIÓN DE DATOS DE USUARIO-->
<!--/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
<!-- Modal -->
<div class="modal fade" id="editarUsuario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i>Edición de Usuarios</h4>
			</div>

			<div class="modal-body">
				<form class="form-horizontal" method="post" id="editarUsuarioN" name="editarUsuarioN">

					<input type="hidden" name="usuario_id_editar" id="usuario_id_editar">

					<div class="form-group" >
						<label for="nombre_editar" class="col-sm-3 control-label">Nombre: </label>
						<div class="col-sm-8">
							<input type="text"  class="form-control" id="nombre_editar" name="nombre_editar" value="" required>
						</div>
					</div>

					<div class="form-group" >
						<label for="apellido_paterno_editar" class="col-sm-3 control-label">Ap. Paterno: </label>
						<div class="col-sm-8">
							<input type="text"  class="form-control" id="apellido_paterno_editar" name="apellido_paterno_editar" value="" required>
						</div>
					</div>

					<div class="form-group" >
						<label for="fecha_ingreso_editar" class="col-sm-3 control-label">Fecha Ingreso: </label>
						<div class="col-sm-8">
							<input type="date" class="form-control" name="fecha_ingreso_editar" id="fecha_ingreso_editar" value="">
						</div>
					</div>

					<div class="form-group">
						<label for="rol_id_editar" class="col-sm-3 control-label">Rol:</label>
						<div class="col-sm-8">
							<select name="rol_id_editar" id="rol_id_editar" class="form-control">
								<?php foreach ($roles as $rol):?>
									<option value="<?php echo $rol->id?>">
										<?php
										echo $rol->Nombre;?>
									</option>
								<?php endforeach;?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label for="sueldo_editar" class="col-sm-3 control-label">Sueldo: </label>
						<div class="col-sm-8">
							<input type="number" placeholder="$" step="0.01" class="form-control" id="sueldo_editar" name="sueldo_editar" value=""" required>
						</div>
					</div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="submit" class="btn btn-primary" id="editar_usuarioN">Guardar datos</button>
			</div>
			</form>
		</div>
	</div>
</div>
<!--/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
<!--EDICIÓN DE DATOS POR USUARIO-->
<!--/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->


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


<!--LISTADO DE USUARIOS-->
<!--/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
<!--/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
<div class="modal fade" id="modal-default">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Listado de trabajadores en nomina</h4>
			</div>
			<div class="modal-body">
				<table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_usuarios" >
					<thead>
					<tr>
						<th>Nombre</th>
						<th>Ap. Paterno</th>
						<th>Nombre Rol</th>
						<th>Rol</th>
						<th>Sueldo</th>
						<th>Plaza</th>
					</tr>
					</thead>
					<tbody>
					<?php if(!empty($usuarios)):?>
						<?php foreach ($usuarios as $usuario):?>
							<tr>
								<td><?=$usuario->Nombre;?></td>
								<td><?=$usuario->Apellido_Paterno;?></td>
								<td><?=$usuario->Nombre_Rol;?></td>
								<td><?=$usuario->Rol;?></td>
								<td>$<?=$usuario->Sueldo;?></td>
								<td><?=$usuario->Plaza;?></td>
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
<!--/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
<!--LISTADO DE USUARIOS-->
<!--/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->



<script type="text/javascript">

	//#region EDITANDO EL ROL DE USUARIOS
	$( "#editarRolN" ).submit(function( event ) {
		var parametros = $(this).serialize();
		//alert(parametros);
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>Nominas/actualizarRolSemanal",
			data: parametros,
			success: function(response){
				// alert(response);
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

	//#region AGREGANDO USUARIOS AL ROL SEMANAL
	$( "#guardarRolN" ).submit(function( event ) {
		var parametros = $(this).serialize();
		//alert(parametros);
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>Nominas/agregarRolSemanal",
			data: parametros,
			success: function(response){
				if(response==0){
					swal({
						position: 'top-end',
						type: 'error',
						title: 'Ocurrio un error al registrar el usuario',
						showConfirmButton: false,
						timer: 1500
					}).then(function() {
					});
				}
				else if(response==1){
					swal({
						position: 'top-end',
						type: 'success',
						title: 'Usuario agreado al rol correctamente!!',
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
				else if(response==3){
					swal({
						position: 'top-end',
						type: 'info',
						title: 'No puede agregar al rol días anteriores al actual',
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

	//#region NO SE QUE HACE
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
					//alert(data);
					$('#turno_editar_id').html(data);
				}
			});
		}
		else{
		}
	});
	//#endregion

	//#region ACTUALIZANDO USUARIOS
	$( "#editarUsuarioN" ).submit(function( event ) {
		var parametros = $(this).serialize();
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>Nominas/actualizarUsuario",
			data: parametros,
			success: function(response){
				if(response==1){
					swal({
						position: 'top-end',
						type: 'success',
						title: 'Usuario correctamente actualizado!!',
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

	//#region AL CAMBIAR EL COMBOBOX DE LAS FECHAS CONSULTAMOS Y TRAEMOS LOS DATOS ASOCIADOS AL DÍA
	$('#dia_editarN').change(function(){

		var fecha_id = $('#dia_editarN').val();
		var usuario_id=$('#id_editarN').val();

		var parametros = {
			'usuario_id': usuario_id,
			'fecha_id': fecha_id
		};

		$("input[name=matutino_editar][value=" + 5 + "]").prop('checked', true);
		$("input[name=vespertino_editar][value=" + 5 + "]").prop('checked', true);
		//alert(fecha_id);

		if(fecha_id != ''){
			$.ajax({
				url:"<?php echo base_url(); ?>Nominas/consultarDetallesRol2",
				method:"POST",
				data: parametros,
				dataType: "JSON",
				success:function(response){
					var len = response.length;
					//alert(len);

					if(len!=0){
						for(var i=0; i<len; i++){
							var dia = response[i].dia_id;
							var editar= response[i].turno_id_editar;
							var rol_cafeteria= response[i].rol_cafeteria_id;
							var rol_turno_id=response[i].turno_id;

							if(rol_turno_id==1){
								if(rol_cafeteria==1){
									$("input[name=matutino_editar][value=" + 1 + "]").prop('checked', true);
								}
								else if(rol_cafeteria==2){
									$("input[name=matutino_editar][value=" + 2 + "]").prop('checked', true);
								}
								else if(rol_cafeteria==3){
									$("input[name=matutino_editar][value=" + 3 + "]").prop('checked', true);
								}
								else if(rol_cafeteria==4){
									$("input[name=matutino_editar][value=" + 4 + "]").prop('checked', true);
								}
								else{
									$("input[name=matutino_editar][value=" + 5 + "]").prop('checked', true);
								}
							}
							else if(rol_turno_id==2){
								if(rol_cafeteria==1){
									$("input[name=vespertino_editar][value=" + 1 + "]").prop('checked', true);
								}
								else if(rol_cafeteria==2){
									$("input[name=vespertino_editar][value=" + 2 + "]").prop('checked', true);
								}
								else if(rol_cafeteria==3){
									$("input[name=vespertino_editar][value=" + 3 + "]").prop('checked', true);
								}
								else if(rol_cafeteria==4){
									$("input[name=vespertino_editar][value=" + 4 + "]").prop('checked', true);
								}
								else{
									$("input[name=vespertino_editar][value=" + 5 + "]").prop('checked', true);
								}
							}
							else{

							}
						}
					}else{
						$("input[name=matutino_editar][value=" + 5 + "]").prop('checked', true);
						$("input[name=vespertino_editar][value=" + 5 + "]").prop('checked', true);
					}
				}
			});
		}
	});
	//#endregion


	function eliminarUsuario(id){
		var parametros = {
			"usuario_id" : id
		};

		//alert(parametros);

		swal({
			title: '¿Está seguro?',
			text: "Desea eliminar el usuario",
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
					url: "<?php echo base_url();?>Nominas/eliminarUsuario",
					data: parametros,
					success: function(data){
						if(data==1){
							swal({
								title: "Usuario correctamente eliminado!",
								text: "Usuario eliminado",
								type: "success"
							}).then(function() {
								location.reload();
							});
						}else if(data==0){
							swal({
								type: 'error',
								title: 'No se pudo eliminar el usuario',
								text: 'Usuario no eliminado'
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

	function asignarUsuarioRol(nombre,id){
		$('#nombre_agregar_rol').val(nombre);
		$('#id_agregar_rol').val(id);
	}

	function liberarNominaManager(fechaInicio,fechaFin){
		var parametros =
			{
				'fechaInicio':fechaInicio,
				'fechaFin':fechaFin
			};
		swal({
			title: '¿Está seguro?',
			text: "Desea liberar el rol para revisión",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Si, liberar',
			cancelButtonText: 'No'
		}).then((result) => {
			if (result.value) {
				$.ajax({
					type: "POST",
					url: "<?php echo base_url();?>Nominas/liberarNominaManagerC",
					data: parametros,
					success: function(data){
						if(data==1){
							swal({
								title: "Nomina en proceso de revisión!",
								text: "EN REVISIÓN",
								type: "success"
							}).then(function() {
								location.reload();
							});
						}
						else if(data==2){
							swal({
								type: 'info',
								title: 'No se pudo liberar la nomina',
								text: 'La nomina esta vacia'
							});
						}
						else if(data==3){
							swal({
								type: 'info',
								title: 'La nomina ya fue liberada',
								text: 'Se encuentra en proceso de revisión'
							});
						}
						else if(data==4){
							swal({
								type: 'info',
								title: 'La nomina ya fue liberada por el administrador',
								text: 'No se permite la edición'
							});
						}
						else if(data==0){
							swal({
								type: 'error',
								title: 'No se pudo liberar la nomina',
								text: 'Error al tratar de liberar la nomina'
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

	function asignarValoresUsuario(usuario_id,nombre,apellido,rol,sueldo,fechaIngreso){
		//alert(usuario_id);
		$('#usuario_id_editar').val(usuario_id);
		$('#nombre_editar').val(nombre);
		$('#apellido_paterno_editar').val(apellido);
		$('#sueldo_editar').val(sueldo);
		$('#fecha_ingreso_editar').val(fechaIngreso);
		$("#rol_id_editar").prop('selectedIndex',rol-1);
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
				var acImporte=0;
				for(var i=0; i<len; i++){
					var id=response[i].usuario_nomina_id;
					var fecha = response[i].Fecha;
					var usuario=response[i].Usuario;
					var concepto=response[i].Concepto;
					var importe=response[i].Importe;
					var nota=response[i].Nota;
					var turno=response[i].turno_id;
					acImporte=parseFloat(acImporte)+parseFloat(importe);
					pruebaAPI.row.add([fecha,usuario,concepto,"$"+importe,nota]);
				}


				pruebaAPI.row.add(["Totales","","",("$ "+acImporte).bold(),""]);
				pruebaAPI.draw();
			},
			error: function() {
				alert("Error posting feed.");
			}
		});
	}

	function asignarDias(fechaInicio){

		var parametros = {
			'fechaInicio': fechaInicio
		};

		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>Nominas/asignarDiasManager",
			data: parametros,
			success: function(response){
				$('#dia_editarN').html(response);
			},
			error: function() {
				alert("Error posting feed.");
			}
		});
	}

	function editarUsuarioRol(nombre,id,fechaInicio){
		$('#nombre_editarN').val(nombre);
		$('#id_editarN').val(id);
		asignarDias(fechaInicio);
		var usuario_id=$('#id_editarN').val();

		var parametros = {
			'usuario_id': usuario_id
		};

		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>Nominas/consultarDetallesRol",
			data: parametros,
			dataType: "JSON",
			success: function(response){
				var len = response.length;
				//alert(len);
				for(var i=0; i<len; i++){

					var dia = response[i].dia_id;
					var editar= response[i].turno_id_editar;
					var rol_cafeteria= response[i].rol_cafeteria_id;
					var rol_turno_id=response[i].turno_id;



					if(rol_turno_id==1){
						if(rol_cafeteria==1){
							$("input[name=matutino_editar][value=" + 1 + "]").prop('checked', true);
						}
						else if(rol_cafeteria==2){
							$("input[name=matutino_editar][value=" + 2 + "]").prop('checked', true);
						}
						else if(rol_cafeteria==3){
							$("input[name=matutino_editar][value=" + 3 + "]").prop('checked', true);
						}
						else if(rol_cafeteria==4){
							$("input[name=matutino_editar][value=" + 4 + "]").prop('checked', true);
						}
						else{
							$("input[name=matutino_editar][value=" + 5 + "]").prop('checked', true);
						}
					}
					else if(rol_turno_id==2){
						if(rol_cafeteria==1){
							$("input[name=vespertino_editar][value=" + 1 + "]").prop('checked', true);
						}
						else if(rol_cafeteria==2){
							$("input[name=vespertino_editar][value=" + 2 + "]").prop('checked', true);
						}
						else if(rol_cafeteria==3){
							$("input[name=vespertino_editar][value=" + 3 + "]").prop('checked', true);
						}
						else if(rol_cafeteria==4){
							$("input[name=vespertino_editar][value=" + 4 + "]").prop('checked', true);
						}
						else{
							$("input[name=vespertino_editar][value=" + 5 + "]").prop('checked', true);
						}
					}
				}
			},
			error: function() {
				alert("Error posting feed.");
			}
		});
	}

	function eliminarEvento(fecha,usuario_id,turno_id){
		var parametros = {
			"fecha":fecha,
			"usuario_id":usuario_id,
			"turno_id":turno_id
		};

		alert(fecha+" "+usuario_id+" "+turno_id);

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
