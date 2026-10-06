<!-- =============================================== -->
        <?php if($banderaCorte==0):?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                Remesas
                <small>Listado</small>
                </h1>
                <a href="<?php echo base_url(); ?>Inicio" class="small-box-footer">Volver al Panel de Inicio <i class="fa fa-arrow-circle-right"></i></a>                                
            </section>
            <!-- Main content -->
            <section class="content">
                <!-- Default box -->
                <div class="box box-solid">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">                                                            
                                <button type='button' class="btn btn-primary btn-flag" data-toggle="modal" data-target="#nuevoGasto"><span class="glyphicon glyphicon-plus" ></span> Agregar Gasto</button>                                                                
                                <button type='button' class="btn btn-success btn-flag" data-toggle="modal" data-target="#verGastos"><span class="" ></span> Ver Gastos</button>                  
                            </div>
                         </div>
                         <hr>                         
                         <div class="row">
                            <div class="col-md-12">
                            <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_remesas">
                            <thead>
                                <tr>                                                                        
                                    <th>Usuario</th>
                                    <th>Gasto</th> 
                                    <th>Pago</th> 
                                    <th>Cantidad</th>
                                    <th>Unidad</th>
                                    <th>Importe</th>      
                                    <th>Notas</th>                                                                                                   
                                    <th>Fecha</th>  
                                    <th>Eliminar</th>  
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($gastos)):?>
                                
                                <?php
                                $acImporte=0;                                
                                ?>

                                <?php foreach ($gastos as $gasto):?>
                                
                                <?php
                                $acImporte+=$gasto->Importe;                                
                                ?>
                                
                                <tr>                                   
                                    <td><?=$gasto->Usuario;?></td>
                                    <td><?=$gasto->Insumo;?></td>       
                                    <td><?=$gasto->Pago;?></td> 
                                    <td><?=$gasto->Cantidad;?></td>
                                    <td><?=$gasto->Unidad;?></td>
                                    <td>$<?=$gasto->Importe;?></td>   
                                    <?php $mensaje=preg_replace("/[\n]/","<br>",$gasto->Notas);?>
                                    <td><?=$mensaje;?></td>                                                                     
                                    <td><?=$gasto->Fecha;?></td>                                                                                                                                                                                                            
                                    <td>
                                        <button onclick="eliminarGastoManager('<?php echo $gasto->Fecha;?>',<?php echo $gasto->plaza_id;?>,<?php echo $gasto->id;?>,<?php echo $gasto->usuario_id;?>,<?php echo $gasto->Cantidad;?>,<?php echo $gasto->insumo_gasto_id;?>)" class="btn btn-danger btn-remove">
                                                <span class="fa fa-remove"></span>
                                        </button>
                                    </td>
                                </tr>   
                                <?php endforeach;?> 
                                <tr>                                
                                    <td>Totales</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><b>Total:</b></td>
                                    <td><b>$ <?=$acImporte;?></b></td>   
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
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

<!-- Modal -->
<div class="modal fade" id="nuevoGasto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  
          <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Agregar nuevo gasto</h4>
		  </div>

		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="guardarGasto" name="guardarGasto">
			<input type="hidden" value="<?php echo $this->session->userdata("id")?>" name="usuario_id">
            <input type="hidden" value="<?php echo $this->session->userdata("plaza")?>" name="plaza_id">
			

               <div class="form-group">
				<label for="grupo_id" class="col-sm-3 control-label">Grupo:</label>
				<div class="col-sm-8">	
                        <select name="grupo_id" id="grupo_id" class="form-control" required>
                        <option value="">Seleccionar Grupo</option>
                            <?php foreach ($grupos as $grupo):?>                                            
                            <option value="<?php echo $grupo->id?>">
                            <?php
                                echo $grupo->Nombre;?>
                            </option>
                            <?php endforeach;?>
                        </select>
				</div>
			  </div>

                <div class="form-group">
				<label for="insumo_gasto_id" class="col-sm-3 control-label">Insumos:</label>
				<div class="col-sm-8">	
                        <select name="insumo_gasto_id" id="insumo_gasto_id" class="form-control" required>
                        <option value="">Seleccionar Insumo</option>                          
                        </select>
				</div>
			  </div>

			
              <div class="form-group" required>
				<label for="cantidad" class="col-sm-3 control-label">Cantidad: </label>
                <div class="col-sm-8">     
                    <input type="number" class="form-control"step=".001" min=0 id="cantidad" placeholder="Kilogramos,Litros,Piezas,Frascos,Botellas" name="cantidad" value="" required>                            
                           
                   
                </div>				
              </div>

              <div class="form-group" required>
				<label for="unidad_id" class="col-sm-3 control-label">Unidad: </label>
                <div class="col-sm-8">     
                    <select name="unidad_id" id="unidad_id" class="form-control" >
                        <option value="">Sin Unidad</option>   
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
				<label for="importe" class="col-sm-3 control-label">Notas: </label>
                <div class="col-sm-8">     
                <textarea rows="4" cols="50" id="notas" name="notas"></textarea>                                        
                </div>				
			  </div>

              
		  </div>

		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" id="guardar_gasto">Guardar datos</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>


    <div class="modal fade" id="verGastos">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Mis Gastos</h4>
            </div>
            <div class="modal-body">
            <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_gastos_manager">
                            <thead>
                                <tr>                                    
                                    <th>Usuario</th>                                    
                                    <th>Gasto</th>                                   
                               
                                   <th>Cantidad</th>  
                                   <th>Unidad</th>                                                                  
                                   <th>Importe</th>   
                                   <th>Notas</th>                                                                                                  
                                    <th>Fecha</th>  
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($gastosT)):?>
                                <?php foreach ($gastosT as $gastoT):?>
                                   <tr>                                    
                                    <td><?=$gastoT->Usuario;?></td>
                                    <td><?=$gastoT->Insumo;?></td>       
                                 
                                    <td><?=$gastoT->Cantidad;?></td>
                                    <td><?=$gastoT->Unidad;?></td>
                                    <td><?=number_format($gastoT->Importe);?></td>  
                                    <td>
                                    <?php $mensaje=preg_replace("/[\n]/","<br>",$gastoT->Notas);
                                        echo $mensaje;
                                    ?>
                                    </td>                                  
                                    <td><?=$gastoT->Fecha;?></td>                                                                                                   
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
<?php endif;?>  


<?php if($banderaCorte==1):?>
<div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                Remesas                
                </h1>
                <a href="<?php echo base_url(); ?>Inicio" class="small-box-footer">Volver al Panel de Inicio <i class="fa fa-arrow-circle-right"></i></a>                                
                <h2>Después de enviar el archivo de Corte no se permite el registro de más gastos</h2>                
            </section>

            <section class="content">
                <!-- Default box -->
                <div class="box box-solid">
                    <div class="box-body">                                       
                         <div class="row">
                            <div class="col-md-12">
                            <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_remesas">
                            <thead>
                                <tr>                                                                        
                                    <th>Usuario</th>
                                    <th>Gasto</th> 
                                    <th>Pago</th> 
                                    <th>Cantidad</th>
                                    <th>Importe</th> 
                                    <th>Notas</th>                                                                                                        
                                    <th>Fecha</th> 
                                                                            
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($gastos)):?>
                                <?php
                                $acImporte=0;                                
                                ?>
                                <?php foreach ($gastos as $gasto):?>
                                <?php
                                $acImporte+=$gasto->Importe;                                
                                ?>
                                <tr>                                   
                                    <td><?=$gasto->Usuario;?></td>
                                    <td><?=$gasto->Insumo;?></td>       
                                    <td><?=$gasto->Pago;?></td> 
                                    <td><?=$gasto->Cantidad;?></td>
                                    <td>$<?=$gasto->Importe;?></td>    
                                    <td>
                                    <?php $mensaje=preg_replace("/[\n]/","<br>",$gasto->Notas);
                                        echo $mensaje;
                                    ?>
                                    </td>                            
                                    <td><?=$gasto->Fecha;?></td>                                                                                                                                                                                                            
                                </tr>   
                                <?php endforeach;?> 
                                <tr>                                
                                    <td>Totales</td>
                                    <td></td>
                                    <td></td>
                                    <td><b>Total:</b></td>
                                    <td><b>$ <?=$acImporte;?></b></td>  
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
            <!-- /.content -->




</div>            
<?php endif;?>  


<script type="text/javascript">  
    //#region REGISTRANDO GASTOS EN EL SISTEMA  PARA MANAGERS  
    $( "#guardarGasto").submit(function( event ) {
            $('#guardar_gasto').attr("disabled", true);  
                
                var parametros = $(this).serialize();
                

                $.ajax({
                        type: "POST",
                        url: "<?php echo base_url();?>Remesas/store",
                        data: parametros,
                        beforeSend: function(objeto){                 				
                        },
                        success: function(datos){                                
                            if(datos==1){                                
                                swal({
                                title: "Gasto Registrado!",
                                text: "Registro Exitoso!",
                                showConfirmButton: false,
                                type: "success",
                                timer: 800
                                }).then(function() {                        
                                    $('#guardar_usuario').attr("disabled", false);
                                    window.location= "<?php echo base_url();?>Remesas/indexManager";                                               
                                });
                            }                            
                            else if(datos==2){                                
                                swal({
                                title: "La cantidad y el importe deben ser valores positivos!",
                                text: "No se registro el gasto!",                                
                                type: "info"            
                                }).then(function() {  
                                    $('#guardar_gasto').attr("disabled",false);                       
                                    //$('#guardar_usuario').attr("disabled", false);                                    
                                });
                            }
                            else if(datos==3){                                
                                swal({
                                title: "La cantidad y el importe superan los rangos aceptables!",
                                text: "Verifique que la cantidad sea correcta!",                                
                                type: "info"            
                                }).then(function() {  
                                    $('#guardar_gasto').attr("disabled",false);                       
                                    //$('#guardar_usuario').attr("disabled", false);                                    
                                });
                            }                            
                            else if(datos==4){                                
                                swal({
                                title: "No se encontro la bandera del insumo!",
                                text: "Contacte al administrador",                                
                                type: "error"            
                                }).then(function() {  
                                    $('#guardar_gasto').attr("disabled",false);                       
                                    //$('#guardar_usuario').attr("disabled", false);                                    
                                });
                            }
                                else if(datos==0){
                                    swal({
                                type: 'error',
                                title: 'Error en el registro',
                                text: 'Ocurrio un error al registrar el gasto'                    
                                }).then(function() {                        
                                    window.location= "<?php echo base_url();?>Remesas/indexManager";                  		                                                                                                     
                                });
                                }                                          
                    },
                    error: function() { 
                            swal({
                            type: 'error',
                            title: 'Error desconocido',
                            text: 'Contacte al administrador'                    
                            }).then(function() {                        
                                window.location= "<?php echo base_url();?>Remesas";                                                                   
                            });                        
                        }
                });
                event.preventDefault();
        });
//#endregion 

    //#region AL CAMBIAR EL GRUPO DE GASTOS SE ACTUALIZAN LOS INSUMOS DE CADA GRUPO
    $('#grupo_id').change(function(){            
            $('#unidad_id').html('<option value="">Unidad</option>');                
            var grupo_id = $('#grupo_id').val();       
            if(grupo_id != ''){
                $.ajax({
                    url:"<?php echo base_url(); ?>Remesas/consultarInsumo",
                    method:"POST",
                    data:{grupo_id:grupo_id},
                    success:function(data)
                    {
                    $('#insumo_gasto_id').html(data);                                          
                    }
                });
            }
            else{
            //$('#grupo_id').html('<option value="">Seleccionar Grupo</option>');
            $('#insumo_gasto_id').html('<option value="">Seleccionar Insumo</option>');
            }
            
        });
    //#endregion

    //#region AL CAMBIAR EL INSUMO DE LOS GRUPOS DE GASTOS SE ACTUALIZA LA UNIDAD
    $('#insumo_gasto_id').change(function(){
            $('#unidad_id').html('<option value="">Unidad</option>');
                var insumo_gasto_id = $('#insumo_gasto_id').val();                                 
                if(insumo_gasto_id != ''){
                    $.ajax({
                        url:"<?php echo base_url(); ?>Remesas/consultarUnidad",
                        method:"POST",
                        data:{insumo_gasto_id:insumo_gasto_id},
                        success:function(data){
                        $('#unidad_id').html(data);                                                          
                        }
                    });        
                }
                else{
            // $('#grupo_id').html('<option value="">Seleccionar Grupo</option>');
            // $('#insumo_gasto_id').html('<option value="">Seleccionar Insumo</option>');   
                }
        });
    //#endregion        

    //MODULO PARA ELIMINAR UN GASTO DEL DÍA      
      function eliminarGastoManager(fecha,plaza_id,id,usuario_id,cantidad,insumo_gasto_id){                                             
        swal({
            title: '¿Está seguro que desea eliminar el gasto?',
            text: 'Una vez eliminado no puede restaurarse',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, eliminar',
            cancelButtonText: 'No',
            allowOutsideClick: false
            }).then((result) => {
            if (result.value) {
            ///////////////////////////////////////////////////////////// 
                var parametros = {
                    "id" : id,    
                    "usuario_id" : usuario_id,
                    "plaza_id" : plaza_id,
                    "cantidad" : cantidad,
                    "insumo_gasto_id":insumo_gasto_id,
                };
                    $.ajax({
                            type: "POST",
                            url: "<?php echo base_url();?>Remesas/deleteAdminManager",
                            data: parametros,
                            beforeSend: function(objeto){                                                                                      
                            },
                            success: function(datos){                                
                                if(datos==1){                                
                                swal({
                                    title: "Eliminado!",
                                    text: "Gasto Eliminado.",
                                    showConfirmButton: false,
                                    type: "success",
                                    timer: 1000
                                }).then(function() {                                                            
                                    location.reload();                       
                                });  
                                }          
                                else if(datos==0){                                    
                                    swal({
                                        type: 'error',
                                        title: 'Oops...',
                                        text: 'Ha ocurrido un error al tratar de eliminar el gasto',                                
                                    });
                                }
                                else if(datos==2){
                                    swal({
                                        type: 'info',
                                        title: 'Oops...',
                                        text: 'Solo es posible eliminar gastos del día actual',                                
                                    });
                                }else if(datos==3){
                                    swal({
                                        type: 'info',
                                        title: 'Oops...',
                                        text: 'Ha ocurrido un error en la eliminación en la plaza seleccionada',                                
                                    });
                                }                 
                                else{
                                    swal({
                                        type: 'error',
                                        title: 'Oops...',
                                        text: 'Ha ocurrido un error  de autorización al tratar de eliminar el gasto',                                
                                    });
                                }                  
                        },error: function(xhr, desc, e) {
                            //alert(xhr.responseText);
                            //console.log(xhr.responseText);
                            swal({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Ha ocurrido un error desconocido al tratar de eliminar el gasto por favor contacte al administrador',                                
                            });
                            //alert("Error posting feed."); 
                        }
                    }); 
            /////////////////////////////////////////////////////////////////////////// 
            }                
            });            
        } 
    //MODULO PARA ELIMINAR UN GASTO DEL DÍA
</script>

