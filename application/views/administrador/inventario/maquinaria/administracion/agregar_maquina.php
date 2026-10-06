<!-- =============================================== -->
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                Máquinas
                <small>Listado</small>
                </h1>
                <a href="<?php echo base_url();?>Inventario/administrarMaquinaria" class="small-box-footer">Volver al Panel de Administración <i class="fa fa-arrow-circle-right"></i></a>
            </section>
            <!-- Main content -->
            <section class="content">
                <!-- Default box -->
                <div class="box box-solid">
                    <div class="box-body">
                      <div class="row">                          
                          <div class="col-md-12">
                            <label for="" class="col-md-1 control-label">Opciones:</label>
                            <div class="col-md-6">                                                                                                                   
                                <button type='button' class="btn btn-success btn-flag" data-toggle="modal" data-target="#agregarMaquina"><span class="fa fa-plus"></span> Agregar Máquina</button>
                            </div>
                          </div>
                        </div>

                         <div class="row">                          
                            <div class="col-md-12">
                            <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_unidades">
                            <thead>
                                <tr>
                                                           
                                    <th>Nombre</th>   
                                    <th>Editar</th>                                                                                                       
                                </tr>
                            </thead>
                            
                            <tbody>
                                <?php if(!empty($maquinas)):?>
                                <?php foreach ($maquinas as $maquina):?>
                                   <tr>                                    
                                    <td><?=$maquina->Nombre;?></td>                                                                                                         
                                    <td>
                                        <button type="button" class="btn btn-success" onclick="consultarMaquina(<?php echo $maquina->id;?>,'<?php echo $maquina->Nombre;?>')" data-toggle="modal" data-target="#consultarMaquinaModal" value="">
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

<div class="modal fade" id="modal-default">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Informacion de la Unidad</h4>
      </div>
      <div class="modal-body">
        
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

<!--modal -->
<div class="modal fade" id="agregarMaquina">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Nueva Máquina</h4>
                </div>            
                <div class="modal-body">                
                <form class="form-horizontal" method="post" id="guardarMaquina" name="guardarMaquina">
                
                <div class="form-group" required>
                    <label for="nombre_maquina" class="col-sm-3 control-label">Nombre: </label>
                    <div class="col-sm-8">     
                        <input type="text" class="form-control"step="0.001" id="nombre_maquina" placeholder="" name="nombre_maquina" value="" required>                                                                          
                    </div>				
                </div>
                                
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" id="guardar_nueva_maquina">Guardar datos</button>
                </div>
                </form>
            
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->


<!--modal -->
<div class="modal fade" id="consultarMaquinaModal">
        <div class="modal-dialog ">
            <div class="modal-content">                
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Editar Máquina</h4>
                </div>            

                <div class="modal-body">                
                <form class="form-horizontal" method="post" id="editarMaquina" name="editarMaquina">
                <input type="hidden" name="id_editar_maquina" id="id_editar_maquina">
                
                <div class="form-group" required>
                    <label for="nombre_editar_maquina" class="col-sm-3 control-label">Nombre: </label>
                    <div class="col-sm-8">     
                        <input type="text" class="form-control" id="nombre_editar_maquina" placeholder="" name="nombre_editar_maquina" value="" required>                                                                          
                    </div>				
                </div>
                                
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" id="editar_unidad">Guardar datos</button>
                </div>
                </form>            
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


   <script type="text/javascript">

    function consultarMaquina(id,nombre){      
      $("#id_editar_maquina").val(id);
      $("#nombre_editar_maquina").val(nombre);
    }

    //#region ACTUALIZACIÓN DE UNIDADES
        $( "#guardarMaquina" ).submit(function( event ) {                       
            var parametros = $(this).serialize();                                                                 
                $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>Inventario/guardarMaquina",
                data: parametros,                      
                success: function(response){                                                     
                    if(response==0){                        
                        swal({
                        position: 'top-end',
                        type: 'error',
                        title: 'Ha ocurrido un error, Máquina NO registrada!!',
                        showConfirmButton: false,
                        timer: 1500
                        });
                    }  
                    else if(response==1){                    
                        swal({
                            position: 'top-end',
                            type: 'success',
                            title: 'Máquina correctamente registrada!!',
                            showConfirmButton: false,
                            timer: 1000
                            }).then(function() {                                                            
                                location.reload();
                        });	
                    }
                    else{
                        swal({
                        position: 'top-end',
                        type: 'error',
                        title: 'Ha ocurrido un error FEED, Máquina no registrada!!',
                        showConfirmButton: false,
                        timer: 1500
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

    //#region ACTUALIZACIÓN DE UNIDADES
      $( "#editarMaquina" ).submit(function( event ) {                       
            var parametros = $(this).serialize();                                                                   
                $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>Inventario/actualizarMaquina",
                data: parametros,                      
                success: function(response){                                                     
                    if(response==0){                        
                        swal({
                        position: 'top-end',
                        type: 'error',
                        title: 'Ha ocurrido un error, Máquina NO actualizada!!',
                        showConfirmButton: false,
                        timer: 1500
                        });
                    }  
                    else if(response==1){                    
                        swal({
                            position: 'top-end',
                            type: 'success',
                            title: 'Maquina correctamente actualizada!!',
                            showConfirmButton: false,
                            timer: 1000
                            }).then(function() {                                                            
                                location.reload();
                        });	
                    }
                    else{
                        swal({
                        position: 'top-end',
                        type: 'error',
                        title: 'Ha ocurrido un error FEED, Máquina no actualizada!!',
                        showConfirmButton: false,
                        timer: 1500
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
   </script>

