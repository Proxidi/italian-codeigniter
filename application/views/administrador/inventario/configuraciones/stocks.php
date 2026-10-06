
        <!-- =============================================== -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                 Stocks Minimos de Inventario
                <small>Stocks</small>
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
                         <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_stocks_1" >
                            <thead>
                                <tr>
                                    <th>Plaza</th>
                                    <th>Nombre</th>
                                    <th>Stock Mínimo</th>
                                    <th>Stock Medio</th>
                                    <th>Unidad</th>      
                                    <th>Editar</th>      

                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($inventario_productos)):?>                                
                                <?php foreach ($inventario_productos as $inventario):?>                            
                            <tr>       

                            <?php switch($inventario->plaza_id): 
                                    case 1: ?>
                                    <td bgcolor="#bae6ff"><h4><?=$inventario->Plaza;?></h4></td>
                                    <?php break; ?>

                                    <?php case 2: ?>
                                    <td bgcolor="#FA8072"><h4><?=$inventario->Plaza;?></h4></td>
                                    <?php break; ?>
                                    
                                    <?php case 3: ?>
                                    <td bgcolor="#8cedbc"><h4><?=$inventario->Plaza;?></h4></td>
                                    <?php break; ?>

                                    <?php case 4: ?>
                                    <td bgcolor="#ecccbb"><h4><?=$inventario->Plaza;?></h4></td>
                                    <?php break; ?>

                                    <?php case 5: ?>
                                    <td bgcolor="#ffd682"><h4><?=$inventario->Plaza;?></h4></td>
                                    <?php break; ?>

                                    <?php case 6: ?>
                                    <td bgcolor="#e7bbec"><h4><?=$inventario->Plaza;?></h4></td>
                                    <?php break; ?>

                                    <?php case 7: ?>
                                    <td bgcolor="#3396ff"><h4><?=$inventario->Plaza;?></h4></td>
                                    <?php break; ?>
                                <?php endswitch; ?>
                                                                                                         
                                <td><h4><?=$inventario->Nombre;?></h4></td>  
                                <td><h4><?=$inventario->stock_minimo;?></h4></td>  
                                <td><h4><?=$inventario->stock_medio;?></h4></td>                                                                                                                                            
                                <td><h4><?=$inventario->Unidad;?></h4></td>      
                                <td> 
                                    <button type="button" class="btn btn-info" onclick="asignarValoresModalStock('<?php echo $inventario->Nombre;?>',<?php echo $inventario->stock_minimo;?>,<?php echo $inventario->stock_medio;?>,'<?php echo $inventario->Unidad;?>',<?php echo $inventario->plaza_id;?>,<?php echo $inventario->insumo_id;?>)"  data-toggle="modal" data-target="#editarStock" value="">
                                        <span class="fa fa-edit"></span>
                                    </button>
                                </td>   
                            </tr>                                   
                                <?php endforeach;?>                                                              
                                <?php endif;?>                                
                            </tbody>                            
                            </table> 

                            <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_stocks_2" >
                            <thead>
                                <tr>
                                    <th>Plaza</th>
                                    <th>Nombre</th>
                                    <th>Stock Minimo</th>
                                    <th>Stock Medio</th>
                                    <th>Unidad</th>      
                                    <th>Editar</th>      

                                </tr>
                            </thead>
                            <tbody id="tbodyStocks">
                                                              
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



  
        <div class="modal fade" id="editarStock">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Establecimiento de Stocks Mínimos</h4>
            </div>            
            <div class="modal-body">
            <form class="form-horizontal" method="post" id="guardarCapturaStock" name="guardarCapturaStock">
            
            <input type="hidden" value="" name="plaza_id_stock" id="plaza_id_stock">            
            <input type="hidden" value="" name="insumo_id" id="insumo_id">
            <input type="hidden" value="<?php echo $bandera; ?>" name="bandera" id="bandera">
               

              <div class="form-group" required>
				<label for="nombre" class="col-sm-3 control-label">Nombre: </label>
                <div class="col-sm-8">     
                    <input type="text" class="form-control"step="0.001" id="nombre" placeholder="" name="nombre" value="" required readonly>                                                                          
                </div>				
              </div>


              <div class="form-group" required>
				<label for="stockMinimo" class="col-sm-3 control-label">Stock Minimo: </label>
                <div class="col-sm-8">     
                    <input type="number" class="form-control" min="0" step="0.001" lang="en"  id="stockMinimo" placeholder="" name="stockMinimo" value="" >                                                                          
                </div>				
              </div>


              <div class="form-group" required>
				<label for="stockMedio" class="col-sm-3 control-label">Stock Medio: </label>
                <div class="col-sm-8">     
                    <input type="number" class="form-control" min="0" step="0.001" lang="en"  id="stockMedio" placeholder="" name="stockMedio" value="" >                                                                          
                </div>				
              </div>

              <div class="form-group" required>
				<label for="unidadInventario" class="col-sm-3 control-label">Unidad: </label>
                <div class="col-sm-8">     
                    <input type="text" class="form-control" id="unidadInventario"  name="unidadInventario" value="" required readonly>                                                                          
                </div>				
              </div>
      
                                
            </div>
            <div class="modal-footer">
			    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			    <button type="submit" class="btn btn-primary" id="guardar_captura_stock">Guardar datos</button>
		    </div>
            </form>
        
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script type="text/javascript">  
    //#region ACTUALIZACIÓN DE  STOCKS
    $( "#guardarCapturaStock" ).submit(function( event ) {
                    
                    var parametros = $(this).serialize();
                    //alert(parametros); 
                    //alert("Actualización de Stocks");
                                
                        $.ajax({
                        type: "POST",
                        url: "<?php echo base_url();?>Inventario/actualizarStock",
                        data: parametros,                
                        success: function(response){ 
                            //alert(response);
                            $('#editarStock').modal('hide');
                            $('#tbl_stocks_1').remove();
                            $("#tbl_stocks_2").show();                
                            $('#tbodyStocks').html(response);  
                        },
                        error: function() { 
                            alert("Error posting feed.");
                        }
                    });
                    event.preventDefault();
                });
        //#endregion

    function asignarValoresModalStock(nombre,stock_minimo,stock_medio,unidad,plaza_id,insumo_id){
        $('#nombre').val(nombre);
        $('#stockMinimo').val(stock_minimo);
        $('#stockMedio').val(stock_medio);
        $('#unidadInventario').val(unidad);        
        $('#plaza_id_stock').val(plaza_id);            
        $('#insumo_id').val(insumo_id);        
    }


</script>

