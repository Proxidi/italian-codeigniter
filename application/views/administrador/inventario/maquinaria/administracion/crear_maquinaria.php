<!-- =============================================== -->
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Administración de Maquinaría
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
                            <div class="col-md-12">
                                                        
                                <form action="<?php echo current_url();?>" method="POST" class="form-horizontal">
                                    <div class="form-group">    
                                    <label for="plaza_id" class="col-md-1 control-label">Plazas</label>
                                    <div class="col-md-3">                                                                                                                   
                                        <select name="plaza_id" id="plaza_id" class="form-control" required>
                                        <?php foreach ($plazas as $plaza):?>  
                                                <?php if($plaza->id==1):?>
                                                <option value="" selected>
                                                    Todas las plazas
                                                </option>
                                                <?php endif;?>
                                                <?php if($plaza->id==$id):?>
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
                                    </div>

                                    <div class="form-group"> 
                                    <label for="" class="col-md-1 control-label">Opciones: </label>   
                                        <div class="col-md-3">                                                                                                                   
                                            <button type='button' class="btn btn-success btn-flag" data-toggle="modal" data-target="#agregarMaquinaria"><span class="fa fa-plus"></span> Nueva Máquina</button>
                                        </div>
                                    </div>                      

                                </form>       
                                </div>                            
                        </div>                        
                         <div class="row">                          
                            <div class="col-md-12">
                            <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_unidades">
                            <thead>
                                <tr>          
                                    <th>Plaza</th>   
                                    <th>Máquina</th>                                                                                 
                                    <th>Numero Serie</th>  
                                    <th>Estatus</th>      
                                    <th>Reporte</th>
                                    <th>Corrección</th>
                                    <th>Historial</th>
                                    <th>Eliminar</th>
                                </tr>
                            </thead>                            
                            <tbody>
                                <?php if(!empty($maquinarias)):?>
                                <?php foreach ($maquinarias as $maquinaria):?>
                                   <tr>                                 
                                   
                                   <?php switch($maquinaria->plaza_maquinaria_id): 
                                    case 1: ?>
                                    <td bgcolor="#bae6ff"><?=$maquinaria->Plaza;?></td>
                                    <?php break; ?>

                                    <?php case 2: ?>
                                    <td bgcolor="#FA8072"><?=$maquinaria->Plaza;?></td>
                                    <?php break; ?>
                                    
                                    <?php case 3: ?>
                                    <td bgcolor="#8cedbc"><?=$maquinaria->Plaza;?></td>
                                    <?php break; ?>

                                    <?php case 4: ?>
                                    <td bgcolor="#ecccbb"><?=$maquinaria->Plaza;?></td>
                                    <?php break; ?>

                                    <?php case 5: ?>
                                    <td bgcolor="#ffd682"><?=$maquinaria->Plaza;?></td>
                                    <?php break; ?>

                                    <?php case 6: ?>
                                    <td bgcolor="#e7bbec"><?=$maquinaria->Plaza;?></td>
                                    <?php break; ?>
                                    
                                    <?php case 7: ?>
                                    <td bgcolor="#c7d5d8"><?=$maquinaria->Plaza;?></td>
                                    <?php break; ?>

                                    <?php case 8: ?>
                                    <td ><?=$maquinaria->Plaza;?></td>
                                    <?php break; ?>
                                    
                                    <?php endswitch; ?>




                                    <td><?=$maquinaria->Maquina;?></td>                                     
                                    <td><?=$maquinaria->Numero_Serie;?></td>                                                                                                                                                                                 
                                    <?php if($maquinaria->Estatus==0):?>
                                    <td bgcolor="#ff175f">DESCOMPUESTA </td>
                                    <?php elseif($maquinaria->Estatus==1):?>
                                    <td bgcolor="#b2fe82">FUNCIONANDO </td>
                                    <?php elseif($maquinaria->Estatus==2):?>
                                    <td bgcolor="#f0c022">FALLOS AL FUNCIONAR</td>
                                    <?php endif;?>                                    
                                    
                                    <td>
                                        <button type="button" class="btn btn-success" onclick="crearReporte(<?php echo $maquinaria->id;?>,'<?php echo $maquinaria->Maquina;?>','<?php echo $maquinaria->Numero_Serie;?>','<?php echo $maquinaria->Plaza;?>')" data-toggle="modal" data-target="#modalReporte" value="">
                                            <span class="fa fa-edit"></span>
                                        </button>
                                    </td>
                                    
                                    <td>
                                        <button type="button" class="btn btn-warning" onclick="agregarCorreccion(<?php echo $maquinaria->id;?>)" data-toggle="modal" data-target="#modalCorreccion" value="">
                                            <span class="fa fa-cog"></span>
                                        </button>
                                    </td>

                                    <td>
                                        <button type="button" class="btn btn-info" onclick="verHistorial(<?php echo $maquinaria->id;?>)" data-toggle="modal" data-target="#modalHistorial" value="">
                                            <span class="fa fa-search"></span>
                                        </button>                                    
                                    </td>
                                    
                                    <td>
                                        <button type="button" class="btn btn-danger" onclick="eliminarMaqina(<?php echo $maquinaria->id;?>)" data-toggle="modal" data-target="#modalEliminar" value="">
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

    <!--modal Agregar Maquina -->
        <div class="modal fade" id="agregarMaquinaria">
                <div class="modal-dialog ">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Nueva Máquina</h4>
                        </div>            
                        <div class="modal-body">                
                        <form class="form-horizontal" method="post" id="agregarNuevaMaquina" name="agregarNuevaMaquina">

                        <div class="form-group">
                        <label for="plaza_maquinaria_id" class="col-sm-3 control-label">Plaza:</label>
                        <div class="col-sm-8">	
                            <select name="plaza_maquinaria_id" id="plaza_maquinaria_id" class="form-control" required>
                                <option value="">Seleccionar Plaza</option>
                                    <?php foreach ($plazas as $plaza):?>                                            
                                        <option value="<?php echo $plaza->id?>">
                                            <?php echo $plaza->Nombre;?>
                                        </option>
                                    <?php endforeach;?>
                            </select>
                            </div>
                        </div>

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
                            <label for="numero_serie" class="col-sm-3 control-label">Número Serie: </label>
                            <div class="col-sm-8">     
                                <input type="number" class="form-control" id="numero_serie" placeholder="" name="numero_serie" value="" required>                                                                          
                            </div>				
                        </div>

                        <div class="form-group">
                            <label for="estatus_maquinaria" class="col-sm-3 control-label">Estatus</label>
                            <div class="col-sm-8">                      
                                <label class="radio-inline">
                                    <input type="radio" name="estatus_maquinaria" id="estatus_maquinaria" value="1" onclick="" checked>Funciona
                                </label>
                                
                                <label class="radio-inline">
                                    <input type="radio" name="estatus_maquinaria" id="estatus_maquinaria" value="0" onclick="">No Funciona
                                </label>                                        
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

    <!--modal Editar Maquina -->
        <div class="modal fade" id="consultarMaquina">
                <div class="modal-dialog ">
                    <div class="modal-content">                
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Editar Máquina</h4>
                        </div>            

                        <div class="modal-body">                
                        <form class="form-horizontal" method="post" id="actualizarNuevaMaquina" name="actualizarNuevaMaquina">
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
    
    <!--modal Reporte -->
        <div class="modal fade" id="modalReporte">
                <div class="modal-dialog ">
                    <div class="modal-content">                
                        
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Creación de Reporte</h4>
                        </div>            

                        <div class="modal-body">                
                        <form class="form-horizontal" method="POST" id="generarReporte" name="generarReporte" enctype="multipart/form-data">
                        <input type="hidden" name="maquina_id_reporte" id="maquina_id_reporte">


                        <div class="form-group" required>
                            <label for="plaza_reporte" class="col-sm-3 control-label">Plaza: </label>
                            <div class="col-sm-8">     
                                <input type="text" class="form-control" id="plaza_reporte" placeholder="" name="plaza_reporte" value="" readonly>                                                                          
                            </div>				
                        </div>

                        <div class="form-group" required>
                            <label for="maquina_reporte" class="col-sm-3 control-label">Máquina</label>
                            <div class="col-sm-8">     
                                <input type="text" class="form-control" id="maquina_reporte" placeholder="" name="maquina_reporte" value="" readonly>                                                                          
                            </div>				
                        </div>

                        <div class="form-group" required>
                            <label for="numero_serie_reporte" class="col-sm-3 control-label">Número Serie: </label>
                            <div class="col-sm-8">     
                                <input type="text" class="form-control" id="numero_serie_reporte" placeholder="" name="numero_serie_reporte" value="" readonly>                                                                          
                            </div>				
                        </div>

                        <div class="form-group">
                            <label for="estatus_maquinaria" class="col-sm-3 control-label">Estatus</label>
                            <div class="col-sm-8">                      
                                <label class="radio-inline">
                                    <input type="radio" name="estatus_maquinaria_reporte" id="estatus_maquinaria_reporte" value="2" onclick="" checked>Funciona Parcialmente
                                </label>                                
                                <label class="radio-inline">
                                    <input type="radio" name="estatus_maquinaria_reporte" id="estatus_maquinaria_reporte" value="0" onclick="">No Funciona
                                </label>                                        
                            </div>
                        </div>

                        <div class="form-group">				
                        <label for="archivo_reporte" class="col-sm-3 control-label">Adjuntar Imagen: </label>
                            <div class="col-sm-8">                                               
                                <input type="file" class="form-control" id="archivo_reporte" name="archivo_reporte" value="" >                                                        
                            </div>				
                        </div>


                        <div class="form-group" required>
                            <label for="notas_reporte" class="col-sm-3 control-label">Notas: </label>
                            <div class="col-sm-8">     
                                <textarea rows="6" cols="50" id="notas_reporte" name="notas_reporte"></textarea>                                       
                            </div>				
                        </div>

                   
                                                                                 
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary" id="generar_reporte">Guardar datos</button>
                        </div>
                        </form>            
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
        </div>
    <!-- /.modal -->

     <!--modal Correccion -->
        <div class="modal fade" id="modalCorreccion">
                <div class="modal-dialog ">
                    <div class="modal-content">                
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Editar Máquina</h4>
                        </div>            

                        <div class="modal-body">                
                        <form class="form-horizontal" method="post" id="actualizarNuevaMaquina" name="actualizarNuevaMaquina">
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

    <!--modal Historial -->
     <div class="modal fade" id="modalHistorial">
            <div class="modal-dialog ">
                <div class="modal-content">                
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Editar Máquina</h4>
                    </div>            

                    <div class="modal-body">                
                    <form class="form-horizontal" method="post" id="actualizarNuevaMaquina" name="actualizarNuevaMaquina">
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

    <!--modal Eliminar -->
        <div class="modal fade" id="modalEliminar">
            <div class="modal-dialog ">
                <div class="modal-content">                
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Editar Máquina</h4>
                    </div>            

                    <div class="modal-body">                
                    <form class="form-horizontal" method="post" id="actualizarNuevaMaquina" name="actualizarNuevaMaquina">
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
    function crearReporte(id,nombre,numero_serie,plaza){      
      $("#maquina_id_reporte").val(id);                  
      $("#maquina_reporte").val(nombre);      
      $("#numero_serie_reporte").val(numero_serie);      
      $("#plaza_reporte").val(plaza);      
    }

    function verHistorial(id,nombre,maquina_id){      
      $("#id_editar_refaccion").val(id);
      $("#nombre_editar_refaccion").val(nombre);      
    }

    function eliminarMaquina(id){      
      $("#id_editar_refaccion").val(id);
      $("#nombre_editar_refaccion").val(nombre);      
    }

    //#region AGREGAR NUEVA MÁQUINA
        $( "#agregarNuevaMaquina" ).submit(function( event ) {                       
            var parametros = $(this).serialize();   
            alert(parametros);                                                              
                $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>Inventario/agregarNuevaMaquina",
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

    //#region ACTUALIZACIÓN DE MÁQUINA
      $( "#actualizarNuevaMaquina" ).submit(function( event ) {                       
            var parametros = $(this).serialize();  
            alert(parametros);                                                                                                                               
                $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>Inventario/actualizarNuevaMaquina",
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
                            title: 'Máquina correctamente actualizada!!',
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

    //#region AGREGAR NUEVA MÁQUINA
    $( "#generarReporte" ).submit(function( event ) {                       
            var parametros = $(this).serialize();   
            alert(parametros);                                                              
                $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>Inventario/generarReporte",
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



   </script>

