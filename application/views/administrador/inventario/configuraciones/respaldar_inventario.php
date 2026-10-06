<!-- =============================================== -->
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                Historial de Respaldo de inventarios
                <small>Historial</small>
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
                                <form action="<?php echo current_url();?>" method="POST" class="form-horizontal">
                                    <div class="form-group">                                             
                                        <label for="plaza_id_buscar" class="col-md-1 control-label">Plaza:</label>
                                            <div class="col-md-3">
                                                <select name="plaza_id_buscar" id="plaza_id_buscar" class="form-control">                                                  
                                                <?php foreach ($plazas as $plaza):?>  
                                                <?php if($plaza->id==1):?>
                                                <option value="" selected>
                                                    Todas las plazas
                                                </option>
                                                <?php endif;?>
                                                <?php if($plaza->id==$buscar_id):?>
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
                                        
                                        <div class="col-md-6">
                                            <input type="submit" name="buscar" value="Buscar" class="btn btn-primary">                                                                                                                                                                                                                          
                                            <button type="button" class="btn btn-success" onclick="respaldarInventario()"  value="">Respaldar</button>                                                                                                                                                                                                                                                                         
                                        </div>        

                                    </div>
                                </form>   
                            </div>                            
                        </div>  

                                               
                         <div class="row">
                            <div class="col-md-12">
                            <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_gastos_admin">
                            <thead>
                                <tr>                                                                        
                                    <th>Fecha</th>                                                                                                                              
                                    <th>Hora</th>                                                                                                                                                                  
                                    <th>Plaza</th>
                                    <th>Usuario</th> 
                                    <th>Ver</th>      
                                    <th>Eliminar</th>                                                                        
                                </tr>
                            </thead>
                            <tbody>
                            <?php if(!empty($respaldos)):?>
                                <?php foreach ($respaldos as $respaldo):?>
                                   <tr>
                                    <td><?=$respaldo->Fecha;?></td>
                                    <td><?=$respaldo->Hora;?></td>
                                    <td><?=$respaldo->Plaza;?></td>       
                                    <td><?=$respaldo->Usuario;?></td>                                                                        
                                    <td>
                                        <button type="button" class="btn btn-info" onclick="verRespaldo('<?php echo $respaldo->Fecha;?>','<?php echo $respaldo->Hora;?>',<?php echo $respaldo->plaza_id;?>)" data-toggle="modal" data-target="#modalRespaldo" value="">
                                            <span class="fa fa-search"></span>
                                        </button>                                    
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger" onclick="eliminarRespaldo('<?php echo $respaldo->Fecha;?>','<?php echo $respaldo->Hora;?>',<?php echo $respaldo->plaza_id;?>)"  value="">
                                            <span class="fa fa-remove"></span>
                                        </button>                                    
                                    </td>
                                </tr>   
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
                <?php if(!empty($fechas)):?>                                
                <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_fechas_quebrantos">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Plaza</th>      
                            <th>Usuario</th>                                                                                                                                                                                                                              
                        </tr>
                    </thead>
                <tbody>
                <?php if(!empty($fechas)):?>                               
                    <?php foreach ($fechas as $fecha):?>                               
                        <tr>
                            <td><?=$fecha->Fecha;?></td>
                            <td><?=$fecha->Hora;?></td>
                            <td><?=$fecha->Plaza;?></td>
                            <td><?=$fecha->Usuario;?></td>                                                                                                                                                                                                                 
                        </tr>   
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


<!-- Modal -->
<div class="modal fade" id="modalRespaldo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i>Respaldo de Inventario</h4>
		  </div>
		  <div class="modal-body">                                                
                <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_prueba_API">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Plaza</th>      
                            <th>Insumo</th>
                            <th>Cantidad</th>
                        </tr>
                    </thead>
                <tbody>                                             
                </tbody>
                </table>                                                                                           
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>			
		  </div>		  
		</div>
	</div>
</div>

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
            ,{
            title: "Análisis de Remesas"   ,
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

    function verRespaldo(fecha,hora,plaza_id)
    {        
        var parametros = {
                "fecha" : fecha,
                "hora" : hora,
                "plaza_id" : plaza_id 
        };                      
                $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>Inventario/consultarRespaldoPlaza",
                data: parametros,              
                dataType: "JSON",                                 
                success: function(response){  
                    pruebaAPI.clear();                       
                    var len = response.length;   
                    for(var i=0; i<len; i++){
                        var fecha = response[i].Fecha;
                        var hora=response[i].Hora;                        
                        var plaza= response[i].Plaza;   
                        var insumo= response[i].Insumo;   
                        var cantidad=response[i].Cantidad;                          
                        pruebaAPI.row.add([fecha,hora,plaza,insumo,cantidad]);                    
                    }                                                                        
                    pruebaAPI.draw();                                                
                },
                error: function() { 
                    alert("Error posting feed.");
                }
            });
    }

    function eliminarRespaldo(fecha,hora,plaza_id)
    {                     
          var parametros = 
            {
                "fecha" : fecha,
                "hora" : hora,
                "plaza_id":plaza_id                                         
            };             

            swal({
            title: '¿Está seguro?',
            text: "Desea eliminar el respaldo",
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
                    url: "<?php echo base_url();?>Inventario/eliminarRespaldoPlaza",
                    data: parametros, 
                    success: function(data){                                                
                    if(data==1){                                                
                        swal({
                            position: 'top-end',
                            type: 'success',
                            title: 'Respaldo correctamente eliminado!!',
                            showConfirmButton: false,
                            timer: 1500
                            }).then(function() {                                                            
                            location.reload();
                        });	
                    }else if(data==0){                        
                        swal({
                            position: 'top-end',
                            type: 'error',
                            title: 'Ha ocurrido un error al eliminar el respaldo!!',
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

    function respaldarInventario(){    
         var plaza_id = $('#plaza_id_buscar').val();    
            if(plaza_id!=""){                                                                        
           
            var parametros = {                
                    "plaza_id" : plaza_id            
                };

                swal({
                title: '¿Está seguro?',
                text: "Desea realizar un respaldo de la plazas",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, respaldar',
                cancelButtonText: 'No'
                }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url();?>Inventario/respaldoPlaza",
                        data: parametros, 
                        success: function(response){ 
                            if(response==1){
                                swal({
                                    position: 'top-end',
                                    type: 'success',
                                    title: 'Respaldo correctamente realizado!!',
                                    showConfirmButton: false,
                                    timer: 1500
                                    }).then(function() {                                                                                                
                                    window.location= "<?php echo base_url();?>Inventario/respaldarInventario"; 
                                });	
                            }else{
                                swal({
                                    position: 'top-end',
                                    type: 'error',
                                    title: 'Ha ocurrido un error,respaldo NO realizado!!',
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
            else{        
                swal({            
                    type: 'info',
                    title: 'Seleccione una plaza para realizar el respaldo',
                    showConfirmButton: false,
                    timer: 1300
                });
            } 
    }

</script>