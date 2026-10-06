<!-- =============================================== -->
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                Refacciones
                <small>Listado</small>
                </h1>
                <a href="<?php echo base_url();?>Inventario/administrarMaquinaria" class="small-box-footer">Volver al Panel de Administracón <i class="fa fa-arrow-circle-right"></i></a>
            </section>
            <!-- Main content -->
            <section class="content">
                <!-- Default box -->
                <div class="box box-solid">
                    <div class="box-body">
                      <div class="row">           
                          <div class="form-group">
                            <div class="col-md-12">
                            <form action="<?php echo current_url();?>" method="POST" class="form-horizontal">
                                <label for="" class="col-md-1 control-label">Máquina</label>
                                <div class="col-md-3">                                                                                                                   
                                    <select name="maquina_id" id="maquina_id" class="form-control" required>
                                    <?php foreach ($maquinas as $maquina):?>  
                                            <?php if($maquina->id==1):?>
                                            <option value="" selected>
                                                Todas las máquinas
                                            </option>
                                            <?php endif;?>
                                            <?php if($maquina->id==$id):?>
                                            <option value="<?php echo $maquina->id?>" selected>
                                            <?php echo $maquina->Nombre;?>
                                            </option>
                                            <?php else:?>
                                            <option value="<?php echo $maquina->id?>">
                                            <?php echo $maquina->Nombre;?>
                                            </option>
                                            <?php endif;?>
                                            <?php endforeach;?>
                                    </select>                                    
                                </div>         
                                
                                <div class="col-md-1">                                                                                                                   
                                    <input type="submit" name="buscar" value="Buscar" class="btn btn-primary">
                                </div>
                                
                                <div class="col-md-3">                                                                                                                   
                                    <button type='button' class="btn btn-success btn-flag" data-toggle="modal" data-target="#agregarRefaccion"><span class="fa fa-plus"></span>Agregar Refacción</button>
                                </div>
                                
                            </form>                      
                            </div>
                            </div>

                        </div>
                         <div class="row">                          
                            <div class="col-md-12">
                            <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_unidades">
                            <thead>
                                <tr>          
                                    <th>Máquina</th>                                             
                                    <th>Nombre</th>   
                                    <th>Editar</th>  
                                    <th>Eliminar</th>                                                                                                     
                                </tr>
                            </thead>
                            
                            <tbody>
                                <?php if(!empty($refacciones)):?>
                                <?php foreach ($refacciones as $refaccion):?>
                                   <tr>         
                                    
                                    <td><?=$refaccion->Maquina;?></td>                                                                                                                                                                       
                                    <td><?=$refaccion->Nombre;?></td>                                                                                                         
                                    <td>
                                        <button type="button" class="btn btn-success" onclick="consultarRefaccion(<?php echo $refaccion->id;?>,'<?php echo $refaccion->Nombre;?>',<?php echo $refaccion->maquina_id;?>)" data-toggle="modal" data-target="#consultarRefaccionModal" value="">
                                            <span class="fa fa-edit"></span>
                                        </button>  
                                    </td>

                                    <td>
                                        <button type="button" class="btn btn-danger" onclick="eliminarRefaccion(<?php echo $refaccion->id;?>)" data-toggle="modal" data-target="#modal-default" value="">
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


<!--modal -->
<div class="modal fade" id="agregarRefaccion">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Nueva Refaccion</h4>
                </div>            
                <div class="modal-body">                
                <form class="form-horizontal" method="post" id="guardarRefaccion" name="guardarRefaccion">
                
                <div class="form-group">
				<label for="maquina_id" class="col-sm-3 control-label">Máquina:</label>
				<div class="col-sm-8">	
                    <select name="maquina_id" id="maquina_id" class="form-control" required>
                        <option value="">Seleccionar Máquina</option>
                            <?php foreach ($maquinas as $maquina):?>                                            
                                <option value="<?php echo $maquina->id?>">
                                    <?php echo $maquina->Nombre;?>
                                </option>
                            <?php endforeach;?>
                    </select>
				    </div>
			    </div>

                <div class="form-group" required>
                    <label for="nombre_refaccion" class="col-sm-3 control-label">Refacción: </label>
                    <div class="col-sm-8">     
                        <input type="text" class="form-control"step="0.001" id="nombre_refaccion" placeholder="" name="nombre_refaccion" value="" required>                                                                          
                    </div>				
                </div>
                                
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" id="guardar_nueva_refaccion">Guardar datos</button>
                </div>
                </form>
            
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->


<!--modal -->
<div class="modal fade" id="consultarRefaccionModal">
        <div class="modal-dialog ">
            <div class="modal-content">                
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Editar Refacción</h4>
                </div>            

                <div class="modal-body">                
                <form class="form-horizontal" method="post" id="editarRefaccion" name="editarRefaccion">
                <input type="hidden" name="id_editar_refaccion" id="id_editar_refaccion">


                <div class="form-group">
				<label for="maquina_id_editar" class="col-sm-3 control-label">Máquina:</label>
				<div class="col-sm-8">	
                    <select name="maquina_id_editar" id="maquina_id_editar" class="form-control" required>
                        <option value="">Seleccionar Máquina</option>
                            <?php foreach ($maquinas as $maquina):?>                                            
                                <option value="<?php echo $maquina->id?>">
                                    <?php echo $maquina->Nombre;?>
                                </option>
                            <?php endforeach;?>
                    </select>
				    </div>
			    </div>
                
                <div class="form-group" required>
                    <label for="nombre_editar_refaccion" class="col-sm-3 control-label">Nombre: </label>
                    <div class="col-sm-8">     
                        <input type="text" class="form-control" id="nombre_editar_refaccion" placeholder="" name="nombre_editar_refaccion" value="" required>                                                                          
                    </div>				
                </div>
                                
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" id="editar_refaccion">Guardar datos</button>
                </div>
                </form>            
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


   <script type="text/javascript">

    function consultarRefaccion(id,nombre,maquina_id){      
      $("#id_editar_refaccion").val(id);
      $("#nombre_editar_refaccion").val(nombre);
      $("#maquina_id_editar option[value='"+maquina_id+"']").attr('selected', 'selected');
    }

    //#region ACTUALIZACIÓN DE UNIDADES
        $( "#guardarRefaccion" ).submit(function( event ) {                       
            var parametros = $(this).serialize();   
            alert(parametros);                                                              
                $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>Inventario/guardarRefaccion",
                data: parametros,                      
                success: function(response){                                                     
                    if(response==0){                        
                        swal({
                        position: 'top-end',
                        type: 'error',
                        title: 'Ha ocurrido un error, Refacción NO registrada!!',
                        showConfirmButton: false,
                        timer: 1500
                        });
                    }  
                    else if(response==1){                    
                        swal({
                            position: 'top-end',
                            type: 'success',
                            title: 'Refacción correctamente registrada!!',
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
                        title: 'Ha ocurrido un error FEED, Refacción no registrada!!',
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
      $( "#editarRefaccion" ).submit(function( event ) {                       
            var parametros = $(this).serialize();  
            alert(parametros);                                                                                                                               
                $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>Inventario/actualizarRefaccion",
                data: parametros,                      
                success: function(response){                                                     
                    if(response==0){                        
                        swal({
                        position: 'top-end',
                        type: 'error',
                        title: 'Ha ocurrido un error, Refacción NO actualizada!!',
                        showConfirmButton: false,
                        timer: 1500
                        });
                    }  
                    else if(response==1){                    
                        swal({
                            position: 'top-end',
                            type: 'success',
                            title: 'Refacción correctamente actualizada!!',
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
                        title: 'Ha ocurrido un error FEED, Refacción no actualizada!!',
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

