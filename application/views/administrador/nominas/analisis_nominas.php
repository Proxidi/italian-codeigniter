<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Tabla de Nominas
			<small>Listado del</small>
		</h1>
		<a href="<?php echo base_url(); ?>Nominas" class="small-box-footer">Volver al Panel de Inicio <i class="fa fa-arrow-circle-right"></i></a>
	</section>

	<!-- Main content -->
	<section class="content">
		<!-- Default box -->
		<div class="box box-solid">
			<div class="box-body">
				<!-- FORMULARIO DE BÚSQUEDA -->
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

								<label for="plaza_id" class="col-md-1 control-label">Plaza:</label>
								<div class="col-md-3">
									<select name="plaza_id" id="plaza_id" class="form-control">
										<?php foreach ($plazas as $plaza):?>
											<?php if($plaza->id==1):?><option value="" selected>Todas las Plazas</option><?php endif;?>
											<option value="<?php echo $plaza->id?>" <?php echo ($plaza->id == $id) ? 'selected' : ''; ?>><?php echo $plaza->Nombre;?></option>
										<?php endforeach;?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="" class="col-md-1 control-label">Options:</label>
								<div class="col-md-4">
									<input type="submit" name="buscar" value="Buscar" class="btn btn-primary">
									<input type="submit" name="buscarRango" value="Buscar Rango" class="btn btn-danger">
								</div>
							</div>
						</form>
					</div>
				</div>

				<!-- TABLA DE ANÁLISIS DINÁMICA -->
				<div class="row">
					<div class="col-md-12">
						<div class="form-group table-responsive">
							<table class="display responsive table table-bordered btn-hover nowrap" style="width:100%" id="tbl_usuarios">
								<thead>
								<tr>
									<th>Plaza</th>
									<th>Turnos</th>
									<th>Horas Hombre</th>
									<th>Unidades</th>
									<th>Ventas</th>
									<th>Unidades/Turno</th>
									<th>Ventas/Turno</th>
									<th>HH/Unidades</th>
									<th>HH/Ingresos</th>
								</tr>
								</thead>
								<tbody>
								<?php
								// Filtrar plazas a mostrar
								$plazasAMostrar = empty($id) ? $plazas : array_filter($plazas, function($p) use($id) { return $p->id == $id; });

								// Colores corporativos originales por Plaza ID
								$colores = [1 => '#bae6ff', 2 => '#FA8072', 3 => '#8cedbc', 4 => '#ecccbb', 5 => '#ffd682', 6 => '#e7bbec', 7 => '#c7d5d8'];

								// Acumuladores globales
								$totalTurnos = 0;
								$totalUnidades = 0;
								$totalIngresos = 0;

								foreach ($plazasAMostrar as $plaza):
									$p_id = $plaza->id;
									$t = isset($turnosData[$p_id]) ? $turnosData[$p_id] : 0;
									$u = isset($unidadesData[$p_id]) ? $unidadesData[$p_id] : 0;
									$i = isset($ingresosData[$p_id]) ? $ingresosData[$p_id] : 0;

									$hh = $t * 6.5;

									$totalTurnos += $t;
									$totalUnidades += $u;
									$totalIngresos += $i;
									?>
									<tr>
										<td bgcolor="<?php echo $colores[$p_id] ?? '#ffffff'; ?>"><?php echo strtoupper($plaza->Nombre); ?></td>
										<td><?php echo number_format($t); ?></td>
										<td><?php echo round($hh, 2); ?></td>
										<td><?php echo number_format($u); ?></td>
										<td>$<?php echo number_format($i); ?></td>

										<!-- Matemáticas Seguras (Prevención de División por cero) -->
										<td><?php echo ($t > 0 && $u > 0) ? number_format($u / $t) : '0'; ?></td>
										<td>$<?php echo ($t > 0 && $i > 0) ? number_format($i / $t) : '0'; ?></td>
										<td><?php echo ($u > 0 && $t > 0) ? round($u / $hh, 3) : '0'; ?></td>
										<td>$<?php echo ($i > 0 && $t > 0) ? number_format($i / $hh) : '0'; ?></td>
									</tr>
								<?php endforeach; ?>

								<!-- Fila de Totales -->
								<tr>
									<td><?php echo $fechaInicio . "<br>" . $fechaFin; ?></td>
									<td bgcolor="#d1ffaf"><?php echo number_format($totalTurnos); ?></td>
									<td bgcolor="#d1ffaf"><?php echo round($totalTurnos * 6.5, 2); ?></td>
									<td bgcolor="#d1ffaf"><?php echo number_format($totalUnidades); ?></td>
									<td bgcolor="#d1ffaf">$<?php echo number_format($totalIngresos); ?></td>
									<td bgcolor="#d1ffaf"></td>
									<td bgcolor="#d1ffaf"></td>
									<td bgcolor="#d1ffaf"></td>
									<td bgcolor="#d1ffaf"></td>
								</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
