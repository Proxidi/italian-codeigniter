

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

		<section class="content-header">
			<h1>
			Remesas F.G.F
			<small>Listado</small>
			</h1>
			<a href="<?php echo base_url(); ?>Remesas" class="small-box-footer">Volver al Panel de Administración <i class="fa fa-arrow-circle-right"></i></a>
		</section>

		<section class="content">
			<!-- Default box -->
			<div class="box box-solid">
				<div class="box-body">
					<!-- SEARCH OPTIONS -->
					<div class="row"> 
						<!--COL-MD-12-->
						<div class="col-md-12">
							<div class="form-group">
								<form action="<?php echo current_url();?>" method="GET" class="form-horizontal">
									<div class="form-group">                                                                   
											<label for="" class="col-md-1 control-label">Desde:</label>
											<div class="col-md-3">
													<input type="date" class="form-control" name="fechaInicio" id="fechaInicio" value="<?php echo !empty($fechaInicio) ? $fechaInicio:'';?>" required>
											</div>

											<label for="" class="col-md-1 control-label">Hasta:</label>
											<div class="col-md-3">
													<input type="date" class="form-control" name="fechaFin" id="fechaFin" value="<?php  echo !empty($fechaFin) ? $fechaFin:'';?>">
											</div>

											<label for="plaza_id" class="col-md-1 control-label">Plaza:</label>
											<div class="col-md-3">
												<select name="plaza_id" id="plaza_id" class="form-control">                                                  
												<?php foreach ($plazas as $plaza):?>  
													<?php if($plaza->id == 1):?>
													<option value="" selected>
															Todas las Plazas
													</option>
													<?php endif;?>
													<?php if($plaza->id == $plaza_id):?>
														<option value="<?php echo $plaza->id?>" selected>
													<?php echo $plaza->Nombre;?>
														</option>
													<?php else:?>
														<option value="<?php echo $plaza->id?>">
													<?php echo $plaza->Nombre;?>
														</option>
													<?php endif;?>
												<?php endforeach;?>?>
												</select>                                    
											</div>                                                                                                       
									</div>
									                
									<div class="form-group">
										<label for="" class="col-md-1 control-label">Opciones:  </label>                           
										<div class="col-md-10">
												<input type="submit" name="buscar" value="Buscar" class="btn btn-primary">
												<input type="submit" name="buscarRango" value="Buscar Rango" class="btn btn-danger">
												<a href="<?php echo current_url();?>" class="btn btn-success">Restablecer</a>
										</div>                                        
									</div>
								</form>                                               
							</div>                           
						</div>
					</div>

					<!-- ADD OPTIONS -->
					<div class="row">
						<div class="col-md-12">
							<div class="form-horizontal">
							<div class="form-group">
								<label for="" class="col-md-1 control-label">Opciones:  </label>                           
								<div class="col-md-11">       													
									<button type='button' class="btn btn-primary btn-flag" data-toggle="modal" data-target="#nuevoGastoAdmin"><span class="glyphicon glyphicon-plus" ></span> Agregar Gasto</button>                                                                														             														
								</div>
							</div>
							</div>
						</div>
					</div>

					<hr>         

					<div class="row">
						<div class="col-md-12">
						<table class="display responsive table table-bordered btn-hover" style="width:100%" id="tbl_gastos_admin_fgf">
							<thead>
								<tr>                                                                        
									<th>Fecha</th>
									<th>Usuario</th>
									<th>Plaza</th>   
									<th>Gasto</th> 
									<th>Pago</th> 
									<th>Cantidad</th>
									<th>Importe</th>                                                                                                                                        
									<th>Notas</th>
									<th>Archivos</th>
									<th>Opciones</th>                                           
								</tr>
							</thead>
							<tbody>
								<?php if(!empty($gastos)):?>
									<?php $acImporte = 0; ?>
									<?php foreach ($gastos as $gasto): ?>
										<?php $acImporte += $gasto->Importe; ?>
										<tr>
											<td><?=$gasto->Fecha;?></td>
											<td><?=$gasto->Usuario;?></td>
											<td><?=$gasto->Plaza;?></td>
											<td><?=$gasto->Insumo;?></td>       
											<td><?=$gasto->Pago;?></td> 
											<td><?=$gasto->Cantidad;?></td>
											<td><b>$<?=number_format($gasto->Importe, 2);?></b></td>  
											<td><?=$gasto->Notas;?></td>    
											<td>
												<?php 	                                    
													$arrayArchivos=explode(",",$gasto->Archivos);
													$link="";
													foreach ($arrayArchivos  as $key) {
															$link.='<a href="javascript:void(0);" onclick="verImagen('.$gasto->Folio.',\''.$key.'\')" >'.$key.'</a><br>';
													}
													echo $link;
												?>       
											</td>                                                                               															                                                                                                                                                                                                                                                                                                        
											<td>    
											<?php if($gasto->Fecha == date("Y-m-d")): ?>
												<button type="button" class="btn btn-danger" onclick="eliminarGastoAdministrador(<?php echo $gasto->id;?>, <?php echo $this->session->userdata('id')?>,<?php echo $this->session->userdata('plaza')?>,<?php echo $gasto->Cantidad;?>,<?php echo $gasto->insumo_gasto_id;?>)" data-toggle="modal" data-target="#modal-default" value="">
														<span class="fa fa-remove"></span>
												</button>											
											<?php endif;?>
											</td>
										</tr>   
									<?php endforeach;?>  
									<tr>                                    
										<td>Totales</td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td><b>Total:</b></td>
										<td><b>$ <?=number_format($acImporte);?></b></td>                                    
										<td></td>
										<td></td>      
										<td></td>                                                                                               
									</tr>                                                             
								<?php endif;?>                                
							</tbody>											
						</table>											
						</div>
					</div>                
				</div>                    
					<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</section>
</div>
<!-- /.content-wrapper -->

<!-- Modal -->
<div class="modal fade" id="nuevoGastoAdmin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
			<div class="modal-content">		
				<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Agregar nuevo gasto</h4>
				</div>

				<form class="form-horizontal" method="post" id="guardarGastoAdmin" name="guardarGastoAdmin" enctype="multipart/form-data">
					<div class="modal-body">					
							<input type="hidden" value="<?php echo $this->session->userdata("id")?>" name="usuario_id">
																			
							<div class="form-group">
								<label for="plaza_id_gastos" class="col-sm-3 control-label">Plaza:</label>
								<div class="col-sm-8">	
										<select name="plaza_id_gastos" id="plaza_id_gastos" class="form-control" required>                                                  
												<option value="" selected>
																		Seleccionar plaza
												</option>  
												<?php foreach ($plazas as $plaza):?>                          
																<option value="<?php echo $plaza->id?>">
																		<?php echo $plaza->Nombre;?>
																</option>                            
												<?php endforeach;?>?>
										</select>            
								</div>
							</div>

							<div class="form-group">
								<label for="insumo_gasto_id" class="col-sm-3 control-label">Insumos:</label>
								<div class="col-sm-8">	
										<select name="insumo_gasto_id" id="insumo_gasto_id" class="form-control" required>
												<option value="">Seleccionar Insumo</option>
														<?php foreach ($insumos as $insumo):?>                                            
																<option value="<?php echo $insumo->id?>">
																		<?php echo $insumo->Nombre;?>
																</option>
														<?php endforeach;?>
										</select>
								</div>
							</div>
					
							<div class="form-group">
								<label for="unidad_pago_id" class="col-sm-3 control-label">Grupo:</label>
								<div class="col-sm-8">	
										<select name="unidad_pago_id" id="unidad_pago_id" class="form-control" required>
												<option value="">Seleccionar Forma de Pago</option>
														<?php foreach ($pagos as $pago):?>                                            
																<option value="<?php echo $pago->id?>">
																		<?php echo $pago->Nombre;?>
																</option>
														<?php endforeach;?>
										</select>
								</div>
							</div>
							
							<div class="form-group" required>
								<label for="importe" class="col-sm-3 control-label">Costo: </label>
								<div class="col-sm-8">     
										<input type="number" placeholder="$" step="0.01" class="form-control" id="importe" name="importe" value=""" required>                                                                   
								</div>				
							</div>

							<div class="form-group" required>
								<label for="notas" class="col-sm-3 control-label">Notas: </label>
								<div class="col-sm-8">     
										<textarea rows="4" cols="50" id="notas" name="notas"></textarea>                                       
								</div>				
							</div>

							<div class="form-group">                
								<label for="archivosRemesa" class="col-sm-3 control-label">Files:</label>
								<div class="col-sm-8">                
										<input id="archivosRemesa" size="100" name="archivosRemesa[]" type="file" class="file" data-browse-on-zone-click="true"  multiple>                                            
								</div>				
							</div>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
						<button type="submit" class="btn btn-primary" id="guardar_gasto_admin">Guardar datos</button>
					</div>
				</form>
			</div>
	</div>
</div>

<!-- Modal para ver una imagen -->         
<div class="modal fade" id="modalImagen">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Imagen adjuntada: <span id="tituloArchivosTarea"></span></h4>
			</div>
			<div class="modal-body">                            
					<img class="img-responsive" id="imagenModal" src=""  alt="">
			</div>
			<div class="modal-footer">
					<button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cerrar</button>
			</div>
		</div>                    
	</div>                
</div>    
<!-- Modal para ver una imagen -->

<script type="text/javascript">  
	$("#archivosRemesa").fileinput({showCaption: false, dropZoneEnabled: false});

	$( "#guardarGastoAdmin" ).submit(function( event ) {
		$('#guardar_gasto_admin').attr("disabled", true);  
			var parametros = $(this).serialize();			
			$.ajax({                    					
							type: "POST",
							url: "<?php echo base_url();?>Remesas/storeAdmin",                    
							data: new FormData(this), 
							processData:false,
							contentType:false,
							cache:false,
							async:true, 							
							success: function(datos){ 								                        
								if(datos == 1){
										swal({
										title: "Gasto Registrado!",
										text: "Registro Exitoso!",
										type: "success",
										timer:1000
								}).then(function() {                        
										$('#guardar_usuario').attr("disabled", false);											
										window.location= "<?php echo base_url();?>Remesas/addRemesasAdministrador";										
								});	
								}else if(datos == 0){
									swal({
											type: 'error',
											title: 'Error en el registro',
											text: 'Ocurrio un error al registrar el gasto'                    
									}).then(function() {                        
											$('#guardar_usuario').attr("disabled", false);                                    
									});
								}                                          
					},
					error: function(xhr, desc, e) { 
						swal({
							type: 'error',
							title: 'Error desconocido',
							text: 'Contacte al administrador '                    
						}).then(function() {                        
							window.location= "<?php echo base_url();?>Remesas";                                                                   
						});
					}
			});
			event.preventDefault();
	});

	function eliminarGastoAdministrador(id, usuario_id, plaza_id, cantidad, insumo_gasto_id){                 
			var parametros = 
									{
									"id" : id,    
									"usuario_id" : usuario_id,
									"plaza_id" : plaza_id,
									"cantidad" : cantidad,
									"insumo_gasto_id":insumo_gasto_id
									};
									
							swal({
									title: '¿Está seguro?',
									text: "El registro se eliminará para siempre",
									type: 'warning',
									showCancelButton: true,
									confirmButtonColor: '#3085d6',
									cancelButtonColor: '#d33',
									confirmButtonText: 'Si, eliminar!',
									cancelButtonText: 'Cancelar'
									}).then((result) => {
									if (result.value) {
											$.ajax({
													type: "POST",
													url: "<?php echo base_url();?>Remesas/deleteAdmin",
													data: parametros,
													beforeSend: function(objeto){                                                      
													},
													success: function(datos){                            
															console.log(datos);
															if(datos==1){
															swal(
																	'Eliminado!',
																	'Gasto Eliminado.',
																	'success'
															).then(function() {                                                        
																	window.location= "<?php echo base_url();?>Remesas/addRemesasAdministrador";                       
															});                            
															}          
															else if(datos==0){
																	swal({
																	type: 'error',
																	title: 'Error en el registro',
																	text: 'Ocurrio un error al registrar el gasto'                    
																	});
															}                                  
											},error: function(xhr, desc, e) { 
													alert(xhr.responseText);
													console.log(xhr.responseText);                        
											}
									});                    
									}
									else{
									
									}});                               
	}

	$('#insumo_gasto_id').change(function() {
		$('#unidad_id').html('<option value="">Unidad</option>');
			var insumo_gasto_id = $('#insumo_gasto_id').val();                                 
			if(insumo_gasto_id != '') {
				$.ajax({
						url:"<?php echo base_url(); ?>Remesas/consultarUnidad",
						method:"POST",
						data:{insumo_gasto_id:insumo_gasto_id},
						success:function(data){
							$('#unidad_id').html(data);                                                          
						}
				});        
			}
	});

	function verImagen(folio, imagen){        
		var base_url= "<?php echo base_url();?>"+"Remesas/verArchivo/"+folio+"/";     
		var terminacion=imagen.split(".");                                                       
		var png="png";
		var jpg="jpg";
		var jpeg="jpeg";
		var terminacion=terminacion.pop();
		
		if(terminacion.localeCompare(png) && terminacion.localeCompare(jpg) && terminacion.localeCompare(jpeg)){
				swal({
						position: 'top-end',
						type: 'success',
						title: 'Descargando Archivo!!',
						showConfirmButton: false,
						timer: 1000
				}).then(function() {                   
						window.location= "<?php echo base_url();?>Remesas/verArchivo/"+folio+"/"+imagen;                                                                                                                                 
				});                        
		}else{
				$('#imagenModal').attr('src',base_url+imagen);        
				$('#modalImagen').modal('show');
		}
	}

	$('#tbl_gastos_admin_fgf').DataTable({
    "aaSorting": [],
    dom: 'Bfrtip',
    "pageLength": 15,
    buttons: [
        {
            extend: 'excelHtml5',
            title: "Remesas FGF"            
        },
        {
            extend: 'pdfHtml5',
            title: "Remesas FGF"                       
        },{
            title: "Remesas FGF"   ,
            extend:'copy'  
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


</script>


