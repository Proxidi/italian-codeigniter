<!-- =============================================== -->
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                Subida de archivos Corte && DLC
                <small>Corte && DLC</small>
                </h1>
                <a href="<?php echo base_url(); ?>Opciones" class="small-box-footer">Volver al Panel de Configuración <i class="fa fa-arrow-circle-right"></i></a>
            </section>
            <!-- Main content -->
            <section class="content">
                <!-- Default box -->
                <div class="box box-solid">
                    <div class="box-body">    
                         <div class="row">
                            <div class="col-md-12">
                            <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_datos">
                            <thead>
                                <tr>       
                                    <th>Días</th>                                                                                
                                    <th>Descripción</th>                                     
                                    <th>Editar</th>                                     
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($dias)):?>                                
                                <?php foreach ($dias as $dia):?>                            
                                    <tr>                                    
                                        <td><?=$dia->Numero_Dias;?></td>                                                                                                                     
                                        <td><?=$dia->Descripcion;?></td>                                                                                                                                                                            
                                        <td>
                                            <button type="button" class="btn btn-success" onclick="editarDias(<?php echo $dia->id;?>,<?php echo $dia->Numero_Dias;?>)" data-toggle="modal" data-target="#modalNumeroDias" value="">
                                                <span class="fa fa-edit"></span>
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



    <div class="modal fade" id="modalNumeroDias" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  
          <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i>Edición del rango de días para la subida de Corte & DLC</h4>
		  </div>
		  
          <div class="modal-body">
			<form class="form-horizontal" method="post" id="editarNumeroDias" name="editarNumeroDias">						                        
            <input type="hidden" name="code_dias" id="code_dias">            

            <div class="form-group">
				<label for="numero_dias_valor" class="col-sm-3 control-label">Días:</label>
				<div class="col-sm-8">	
                <input type="number" class="form-control" name="numero_dias_valor" id="numero_dias_valor" value="" min="1" required >
				</div>
			</div>

		  </div>    
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" id="editar_numero_dias">Guardar datos</button>
		  </div>
		  </form>
		</div>
	  </div>
</div>



<script type="text/javascript">

function editarDias(id,dias){    
    $('#numero_dias_valor').val(dias);
}

  //#region EDITANDO EL NUMERO DE DIAS 
  $( "#editarNumeroDias" ).submit(function( event ) {
            //$('#editar_gastos_deposito').attr("disabled", true);  
                var parametros = $(this).serialize();                                              
                //alert(parametros);
                $.ajax({
                        type: "POST",
                        url: "<?php echo base_url();?>Opciones/actualizarRangoDias",
                        data: parametros,
                        success: function(datos){   
                                //alert(datos);                             
                                if(datos==1){                            
                                    swal({
                                    position: 'top-end',
                                    type: 'success',
                                    title: 'Rango correctamente actualizado!!!',
                                    showConfirmButton: false,
                                    timer: 1500
                                    }).then(function() {                                                            
                                        location.reload();
                                });	
                                
                            }else if(datos==0){                                 
                                swal({
                                type: 'error',
                                title: 'Error al actualizar el rango',
                                text: 'No se pudo actualizar el rango'                    
                                }).then(function() {                        
                                    //location.reload();
                                });
                            }
                            else if(datos==2){
                                swal({
                                type: 'error',
                                title: 'Debe de seleccionar un valor positivo',
                                text: 'No se aceptan valores menores a 1'                    
                                }).then(function() {                        
                                    //location.reload();
                                });
                            }                                          
                    },
                    error: function() { 
                        swal({
                                type: 'error',
                                title: 'Error desconocido',
                                text: 'Contacte al administrador '                    
                                }).then(function() {                        
                                    //location.reload();
                                });                        
                        }
                });
                event.preventDefault();
        });
    //#endregion  

</script>







