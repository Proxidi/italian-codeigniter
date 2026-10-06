
                <!-- Content Wrapper. Contains page content -->
                <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                Revisión de inventarios físicos semanales
                <small>Listado de Capturas</small>
                </h1>
                <a href="<?php echo base_url(); ?>Inventario" class="small-box-footer">Volver al Panel de Inventario <i class="fa fa-arrow-circle-right"></i></a>
            </section>
            <!-- Main content -->
            <section class="content">
                <!-- Default box -->
                <div class="box box-solid">
                    <div class="box-body">
                      
                                                
                         <div class="row">
                            <div class="col-md-12">
                            <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_gastos_admin">
                            <thead>
                                <tr>                                                                        
                                    <th>Fecha</th>
                                    <th>Hora</th>   
                                    <th>Plaza</th> 
                                    <th>Usuario</th> 
                                    <th>Insumos</th>                                    
                                    <th>Estatus</th>
                                    <th>Liberar</th>                                                                                                                 
                                    <th>Ver</th>                                                                                                                 
                                    <th>Root</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($capturas)):?>                               
                                    <?php foreach ($capturas as $captura):?>    
                                    <?php if($captura->Inventario==0):?>
                                    <tr>                                   
                                            <td><?=$captura->Fecha;?></td>
                                            <td><?=$captura->Hora;?></td>
                                            <td><?=$captura->Plaza;?></td>
                                            <td><?=$captura->Usuario;?></td>       
                                            <td><?=$captura->Insumos;?></td>                                                
                                            <?php if($captura->Correcto==0):?>
                                            <td>Pendiente</td> 
                                            <?php elseif($captura->Correcto==1):?>
                                            <td>Listo</td>                                                                         
                                            <?php endif;?>   
                                            <?php if($captura->Inventario==0):?>                                            
                                            <td> 
                                                <button type="button" class="btn btn-success" onclick="liberarInventarioFisicoAdmin(<?php echo $captura->plaza_id;?>)" data-toggle="modal" data-target="#modal-default" value="">
                                                    <span class="fa fa-check"></span>
                                                </button>
                                            </td>  
                                            <?php else:?>      
                                            <td></td>
                                            <?php endif;?>      
                                            <td> 
                                                <button type="button" class="btn btn-info" onclick="consultarIF(<?php echo $captura->plaza_id;?>)" data-toggle="modal" data-target="#mdl_CIF" value="">
                                                    <span class="fa fa-search"></span>
                                                </button>
                                            </td>                                              
                                            <td> 
                                                <button type="button" class="btn btn-warning" onclick="otorgarPermisosIF('<?php echo $captura->Fecha;?>',<?php echo $captura->plaza_id;?>)" value="">
                                                    <span class="fa fa-refresh"></span>
                                                </button>
                                            </td>                                           
                                        </tr> 
                                    <?php endif;?>                                             
                                    <?php endforeach;?>                                                                                           
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
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

         <!-- Modal -->
    <div class="modal fade" id="notificacionesFechasDisponibles" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Fechas Disponibles</h4>
		  </div>
		  <div class="modal-body">
                <?php if(!empty($capturas)):?>                                
                <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_fechas_quebrantos">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Hora</th>   
                            <th>Plaza</th> 
                            <th>Usuario</th> 
                            <th>Insumos</th>                                                                                                                                                                              
                                                                                                                                                                     
                        </tr>
                    </thead>
                <tbody>
                <?php if(!empty($capturas)):?>                               
                    <?php foreach ($capturas as $captura):?>     
                    <?php if($captura->Inventario==1):?>
                        <tr>                                   
                            <td><?=$captura->Fecha;?></td>
                            <td><?=$captura->Hora;?></td>
                            <td><?=$captura->Plaza;?></td>
                            <td><?=$captura->Usuario;?></td>       
                            <td><?=$captura->Insumos;?></td>                                                                                                          
                                                                                                   
                        </tr>                                                          
                    <?php endif;?>                                                 
                    <?php endforeach;?>                                                                                           
                <?php endif;?>                                                          
                </tbody>
                </table>                                                                      
                <?php endif;?>     
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>			
		  </div>
		  
		</div>
	  </div>
	</div>


    <div class="modal fade" id="mdl_CIF">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Listado de Ventas</h4>
            </div>
            <div class="modal-body">
            <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_CIF">
                    <thead>
                        <tr>
													<th>#</th>
													<th>Nombre</th> 
													<th>Bodega</th>
													<th>Piso</th>
													<th>Total</th> 
													<th>Unidad</th>                                                                                                                                         
                        </tr>
                    </thead>                
                    <tbody> 

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


<script type="text/javascript">  

    function otorgarPermisosIF(fecha,plaza_id){        
        var parametros = {
                "fecha" : fecha,    
                "plaza_id" : plaza_id                           
                };  

        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>Inventario/edicionIF",
            data: parametros, 
            dataType: "JSON",
            success: function(data){
                
                if(data==1){
                    swal({
                        position: 'top-end',
                        type: 'success',
                        title: 'Otorgando permisos!!',
                        showConfirmButton: false,
                        timer: 1500
                        }).then(function() {                                                            
                        window.location= "<?php echo base_url();?>Inventario/panelInventarioFisico";                                               
                    });	
                    
                }else if(data==0){
                    swal({
                        position: 'top-end',
                        type: 'error',
                        title: 'Ha ocurrido un error !!',
                        showConfirmButton: false,
                        timer: 1500
                        }).then(function() {                                                            
                        window.location= "<?php echo base_url();?>Inventario/panelInventarioFisico";                                               
                    });	
                }               
                else{
                    alert("Error desconocido");
                } 
                
            },
            error: function() { alert("Error posting feed."); }
        }); 
    }


    function liberarInventarioFisicoAdmin(plaza_id) {        
        var fecha = "";
        var valor = 0;
        var parametros = {              
          "plaza_id" : plaza_id         
        };          

				$.ajax({
					type: "POST",
					url: "<?php echo base_url();?>Inventario/estatusInventarioFisico",
					data: parametros,
					dataType: "JSON",
					success: function(response){   
							var len = response.length;                
							for(var i=0; i<len; i++){                    
											valor = response[i].valor;            
							}                                                 
							if(valor==0){
									Swal(
											'Captura aún no liberada por el manager',
											'Comuniquese con el manager para terminar la captura del inventario',
											'question'
									);
							}
							else if(valor==1){
							swal({
							title: '¿Está seguro que desea liberar la captua del inventario',
							text: "Una vez liberado el inventario será afectado",
							type: 'warning',
							showCancelButton: true,
							confirmButtonColor: '#3085d6',
							cancelButtonColor: '#d33',
							confirmButtonText: 'Si, liberar',
							cancelButtonText: 'No, mantener'
							}).then((result) => {
							if (result.value) {
									var parametros = {                        
											"plaza_id" : plaza_id                      
									};               
									$.ajax({
											type: "POST",
											url: "<?php echo base_url();?>Inventario/liberarInventarioFisicoAdmin",
											data: parametros,  
											beforeSend: function(objeto){   
													swal({                                
											title: 'Espere por favor !!!',
											width: 600,
											padding: '2em',
											background: '#fff url(<?php echo base_url();?>assets/images/trees.png)',
											backdrop: `
													rgba(0,0,123,0.4)
													url("<?php echo base_url();?>assets/images/loading.gif")
													center left
													no-repeat
											`,
											allowOutsideClick: false,
											showCancelButton: false,
											showConfirmButton: false
													});                                                    
											},
											success: function(data){                                               
													if(data==1){
													swal({
															position: 'top-end',
															type: 'success',
															title: 'Inventario actualizado, Captura agregada!!',
															showConfirmButton: false,
															timer: 1500
															}).then(function() {                                                            
															window.location= "<?php echo base_url();?>Inventario/panelInventarioFisico";                                               
													});	
													}
													else if(data==0){
													swal({
															position: 'top-end',
															type: 'error',
															title: 'Ha ocurrido un error al actualizar el inventario!!',
															showConfirmButton: false,
															timer: 1500
															}).then(function() {                                                            
															window.location= "<?php echo base_url();?>Inventario/panelInventarioFisico";                                               
													});	
													}               
													else{
															alert("Error desconocido");
													} 
											},
											error: function() { alert("No quedo 4."); }
									});                    
							}                
							}); 
						///////////////////////////////////////////////////////////////////////////////////////////////////
						}
						
					},
					error: function() { alert("No quedo afuera."); }
				}); 
    }

    
    
    var tbl_CIF= $('#tbl_CIF').DataTable({
        "aaSorting": [],
        dom: 'Bfrtip',
        "pageLength": 150,
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

    function consultarIF(plaza_id){
        var parametros = {                
                "plaza_id" : plaza_id,        
                };                            
                $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>Inventario/consultarIF",
                data: parametros,              
                dataType: "JSON",                                 
                success: function(response){  
                   
                    tbl_CIF.clear();                       
                    var len = response.length;                            
										var contador = 1;
                    for(var i=0; i<len; i++){							
											var insumo = response[i].Insumo;
											var bodega = response[i].Bodega;            
											var piso=response[i].Piso;  
											var total=response[i].Total;

											var unidadT=response[i].UnidadT;                        
											tbl_CIF.row.add([contador, insumo,bodega,piso,total,unidadT]);
											contador++;
                    }
                    //tbl_CIF.row.add(["Totales","","","","","","","$"+Math.round(acImporte)]);   
                    tbl_CIF.draw();                                                
                },
                error: function() { 
                    alert("Error posting feed.");
                }
            });    
    }


</script>





	



