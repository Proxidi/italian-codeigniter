
        <!-- =============================================== -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                Modificación del Inventario en Producción
                <small>Listado</small>
                </h1>
                <a href="<?php echo base_url(); ?>Inventario" class="small-box-footer">Volver al Panel del Inventario <i class="fa fa-arrow-circle-right"></i></a>
                 
            </section>
            <!-- Main content -->
            <section class="content">
                <!-- Default box -->
                <div class="box box-solid">
                    <div class="box-body">
                    <!-- DIV.ROW -->
                        <div class="row">
                        <!-- COL-MD--12 -->
                            <div class="col-md-12">                                                                                                                                                                                                                                                               
                            <!--FORMULARIO-->
                                <form action="<?php echo current_url();?>" method="POST" class="form-horizontal">                                                            
                                    <!--FORM-GROUP-->
                                    <div class="form-group">
                                        <!--COMBOBOX PLAZAS-->
                                        <label for="plaza_id" class="col-md-1 control-label">Plaza:</label>
                                            <div class="col-md-3">
                                                <select name="plaza_id" id="plaza_id" class="form-control">                                                  
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
                                                    <?php endforeach;?>?>
                                                </select>                                    
                                                <input type="hidden" name="hidden_country" id="hidden_country" />
                                            </div> 
                                        <!--./ COMBOBOX PLAZAS-->
                                        

                                        <!--COMBOBOX INSUMOS-->
                                        <label for="grupo_id" class="col-md-1 control-label">Insumos:  </label>                           
                                            <div class="col-md-3">
                                                <select name="insumo_gasto_remesa_id" id="insumo_gasto_remesa_id" class="form-control" >
                                                    <option value="">Todos los insumos</option>  
                                                    <?php if(isset($insumos)):?> 
                                                    <?php foreach ($insumos as $insumo):?>  
                                                    <?php if($insumo->id==$insumo1):?>
                                                    <option value="<?php echo $insumo->id?>" selected>
                                                    <?php echo $insumo->Nombre;?>
                                                    </option>
                                                    <?php else:?>
                                                    <option value="<?php echo $insumo->id?>">
                                                    <?php echo $insumo->Nombre;?>
                                                    </option>
                                                    <?php endif;?>
                                                    <?php endforeach;?>?>
                                                    <?php endif;?>  
                                                </select> 
                                            </div>
                                        <!--./ COMBOBOX INSUMOS-->

                                        <!--BOTON BUSCAR-->
                                            <div class="col-md-1">
                                                <input type="submit" name="buscar" value="Buscar" class="btn btn-primary">                                                                                       
                                            </div>   
                                        <!--./BOTON BUSCAR-->  

                                       

                                    </div>
                                    <!--./FORM-GROUP-->
                                </form>
                                <!--./FORMULARIO-->
                            </div>      
                            <!--./ COL-MD--12 -->                      
                        </div>
                        <!--./ DIV.ROW -->

                         <div class="row">
                         <div class="col-md-12"> 
                         <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_inventario">
                            <thead>
                                <tr>
                                    <th>Plaza</th>
                                    <th>Nombre</th>
                                    <th>Cantidad</th>
                                    <th>Unidad</th>   
                                    <th>Editar</th>                                                                                                                                                  
                                </tr>
                            </thead>
                            <tbody>                                
                                <?php if(!empty($inventario_productos)):?>                                
                                <?php foreach ($inventario_productos as $inventario):?>                            
                                   <tr>                                    
                                    <td><?=$inventario->Plaza;?></td>                                          
                                    <td><?=$inventario->Nombre;?></td>
                                    <?php if($inventario->Cantidad>=$inventario->stock_medio ):?>                                    
                                    <td bgcolor="#6fff2f"><?=round($inventario->Cantidad,2);?></td>                                    
                                    <?php elseif($inventario->Cantidad>=$inventario->stock_minimo):?>                                    
                                    <td bgcolor="#ff9828"><?=round($inventario->Cantidad,2);?></td> 
                                    <?php else:?>
                                    <td bgcolor="#ff5c59"><?=round($inventario->Cantidad,2);?></td>
                                    <?php endif;?>                                                                        
                                    <td><?=$inventario->Unidad;?></td>     
                                    <td>
                                    <button type="button" class="btn btn-info" onclick="asignarValoresModalInventario(<?php echo $inventario->plaza_id;?>,<?php echo $inventario->insumo_id;?>,'<?php echo $inventario->Plaza;?>','<?php echo $inventario->Nombre;?>',<?php echo $inventario->Cantidad;?>,'<?php echo $inventario->Unidad;?>')"  data-toggle="modal" data-target="#editarCantidadInventario" value="">
                                        <span class="fa fa-edit"></span>
                                    </button>
                                    </td>                                                                 
                                                                                                      
                                </tr>                                   
                                <?php endforeach;?>                                                              
                                <?php endif;?>                                
                                
                            </tbody>                            
                            </table>                                                            
                         </div>
                          <!-- /.row -->    
                    </div>                    
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->



    

    
    <div class="modal fade" id="editarCantidadInventario">
    <div class="modal-dialog ">
        <div class="modal-content">
            
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Modificación del inventario</h4>
            </div>   

            <div class="modal-body">
            <form class="form-horizontal" method="post" id="guardarCapturaInventarioProduccion" name="guardarCapturaInventarioProduccion">
            
            <input type="hidden" value="" name="plaza_id_modal" id="plaza_id_modal">
            <input type="hidden" value="" name="insumo_id_modal" id="insumo_id_modal">

              <div class="form-group" required>
				<label for="producto" class="col-sm-3 control-label">Plaza: </label>
                <div class="col-sm-8">     
                    <input type="text" class="form-control"step="" id="plaza_modal" placeholder="" name="plaza_modal" value="" required readonly>                                                                          
                </div>				
              </div>

              <div class="form-group" required>
				<label for="insumo" class="col-sm-3 control-label">Insumo: </label>
                <div class="col-sm-8">     
                    <input type="text" class="form-control"step="0.001" id="insumo_modal" placeholder="" name="insumo_modal" value="" required readonly>                                                                          
                </div>				
              </div>


              <div class="form-group" required>
				<label for="cantidadFormula" class="col-sm-3 control-label">Cantidad: </label>
                <div class="col-sm-8">     
                    <input type="number" class="form-control" min="0" step="0.0001" lang="en"  id="cantidad_modal" placeholder="" name="cantidad_modal" value="" required >                                                                          
                </div>				
              </div>

              
              <div class="form-group" required>
				<label for="insumo" class="col-sm-3 control-label">Unidad: </label>
                <div class="col-sm-8">     
                    <input type="text" class="form-control" id="unidad_modal" placeholder="" name="unidad_modal" value="" required readonly>                                                                          
                </div>				
              </div>

                                 
            </div>
            <div class="modal-footer">
			    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			    <button type="submit" class="btn btn-primary" id="guardar_captura_inventario_produccion">Guardar datos</button>
		    </div>
            </form>
        
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
	
<script type="text/javascript">  
    //#region ACTUALIZACIÓN DEL INVENTARIO PRODUCCIÓN
    $( "#guardarCapturaInventarioProduccion" ).submit(function( event ) {
        $('#guardar_captura_inventario_produccion').attr("disabled", true);            
        var parametros = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>Inventario/actualizarCantidadProduccion",
            data: parametros,                
            success: function(response){ 
                if(response==0){
                    swal({
                        position: 'top-end',
                        type: 'error',
                        title: 'Insumo no actualizado!!',
                        showConfirmButton: false,
                        timer: 1500
                        }).then(function() {});
                }else{                      
                    swal({
                        position: 'top-end',
                        type: 'success',
                        title: 'Inventario correctamente actualizado!!',
                        showConfirmButton: false,
                        timer: 1000
                        }).then(function() {                                                            
                            window.location= "<?php echo base_url();?>Inventario/modificarInventario";
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

    function asignarValoresModalInventario(plaza_id,insumo_id,plaza,insumo,cantidad,unidad){
        $('#plaza_id_modal').val(plaza_id);
        $('#insumo_id_modal').val(insumo_id);          
        $('#plaza_modal').val(plaza);          
        $('#insumo_modal').val(insumo);          
        $('#cantidad_modal').val(cantidad);  
        $('#unidad_modal').val(unidad);  
    }




</script>    

    


