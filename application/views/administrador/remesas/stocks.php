<!-- =============================================== -->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
                <h1>Stocks Para la captura de la remesa<small>Stocks</small></h1>
                <a href="<?php echo base_url(); ?>Inventario" class="small-box-footer">Volver al Panel del Inventario <i class="fa fa-arrow-circle-right"></i></a>                 
        </section>
            <!-- Main content -->
            <section class="content">
                <!-- Default box -->
                <div class="box box-solid">
                    <div class="box-body">                                                
                        <div class="row">
                            <div class="col-md-12"> 
                                <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_stocks_1" >
                                    <thead>
                                        <tr>
                                            <th>Grupo</th>
                                            <th>Insumo</th>
                                            <th>Stock Mínimo</th>
                                            <th>Stock Maximo</th>
                                            <th>Unidad</th>
                                            <th>Bandera</th>        
                                            <th>Editar</th>
                                            <th>Habilitar</th>
                                            <th>Deshabilitar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(!empty($insumos_remesa)):?>                                
                                        <?php foreach ($insumos_remesa as $remesa):?>                                                               
                                    <tr>                              
                                        <?php switch($remesa->grupo_id%2): 
                                                case 0: ?>                                            
                                                    <td bgcolor="#bae6ff"><?=$remesa->Grupo;?></td>                               
                                                <?php break; ?>

                                                <?php case 1: ?>                                            
                                                    <td bgcolor="#b7e188"><?=$remesa->Grupo;?></td>                               
                                                <?php break; ?>

                                        <?php endswitch; ?>                                                                                                                                        
                                        <td><?=$remesa->Nombre;?></td>  
                                        <td><?=$remesa->stock_minimo;?></td>  
                                        <td><?=$remesa->stock_maximo;?></td>                                                                                                                                            
                                        <td><?=$remesa->Unidad;?></td>                                                                                                                                            
                                        <td><?=$remesa->bandera_stocks;?></td>      
                                        <td> 
                                            <button type="button" class="btn btn-info" onclick="asignarValoresModalStock(<?php echo $remesa->id;?>,'<?php echo $remesa->Grupo;?>','<?php echo $remesa->Nombre;?>',<?php echo $remesa->stock_minimo;?>,<?php echo $remesa->stock_maximo;?>,<?php echo $remesa->bandera_stocks;?>,'<?php echo $remesa->Unidad;?>')"  data-toggle="modal" data-target="#editarStock" value="">
                                                <span class="fa fa-edit"></span>
                                            </button>
                                        </td>   
                                        <td> 
                                            <button type="button" class="btn btn-success" onclick="habilitarBandera(<?php echo $remesa->id;?>)" value="">
                                                <span class="fa fa-check"></span>
                                            </button>
                                        </td>
                                        <td> 
                                            <button type="button" class="btn btn-danger" onclick="deshabilitarBandera(<?php echo $remesa->id;?>)" value="">
                                                <span class="fa fa-remove"></span>
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
                                            <th>Grupo</th>
                                            <th>Insumo</th>
                                            <th>Stock Mínimo</th>
                                            <th>Stock Maximo</th>
                                            <th>Unidad</th>
                                            <th>Bandera</th>        
                                            <th>Editar</th>   
                                            <th>Habilitar</th>
                                            <th>Deshabilitar</th>                                           
                                        </tr>
                                    </thead>
                                    <tbody id="tbodyStocks">                                                              

                                    </tbody>                            
                                </table> 
                            </div>
                            <!-- /.COL-MD-12 -->                    
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


<!--AQUI IBA EL FRAGMENTO DE CÓDIGO FUENTE QUE QUITE-->
    <div class="modal fade" id="editarStock">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Establecimiento de Stocks Mínimos</h4>
                </div>            
                <div class="modal-body">

                <form class="form-horizontal" method="post" id="guardarCapturaStockRemesa" name="guardarCapturaStockRemesa">
                <input type="hidden" name="id_stock_remesa" id="id_stock_remesa">

                <div class="form-group" required>
                    <label for="nombreRemesa" class="col-sm-3 control-label">Nombre: </label>
                    <div class="col-sm-8">     
                        <input type="text" class="form-control" step="0.001" id="nombreRemesa" placeholder="" name="nombreRemesa" value="" required readonly>                                                                          
                    </div>				
                </div>

                <div class="form-group" required>
                    <label for="stockMinimo" class="col-sm-3 control-label">Stock Minimo: </label>
                    <div class="col-sm-8">     
                        <input type="number" class="form-control" min="0" step="0.001" lang="en"  id="stockMinimo" placeholder="" name="stockMinimo" value="" >                                                                          
                    </div>				
                </div>


                <div class="form-group" required>
                    <label for="stockMaximo" class="col-sm-3 control-label">Stock Máximo: </label>
                    <div class="col-sm-8">     
                        <input type="number" class="form-control" min="0" step="0.001" lang="en"  id="stockMaximo" placeholder="" name="stockMaximo" value="" >                                                                          
                    </div>				
                </div>

                <div class="form-group" required>
                    <label for="unidadRemesa" class="col-sm-3 control-label">Unidad: </label>
                    <div class="col-sm-8">     
                        <input type="text" class="form-control" id="unidadRemesa"  name="unidadRemesa" value="" required readonly>                                                                          
                    </div>				
                </div>
                                        
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" id="guardar_captura_stock_remesa">Guardar datos</button>
                </div>
                
                </form>        
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->                                            
<!--AQUI IBA EL FRAGMENTO DE CÓDIGO FUENTE QUE QUITE-->


<script type="text/javascript">  
    //#region ACTUALIZACIÓN DE  STOCKS
    $( "#guardarCapturaStockRemesa" ).submit(function( event ) {
                    
                    var parametros = $(this).serialize();
                    //alert(parametros); 
                    //alert("Actualización de Stocks de la remesa");                                
                        $.ajax({
                        type: "POST",
                        url: "<?php echo base_url();?>Remesas/actualizarStockRemesa",
                        data: parametros,                
                        dataType: "JSON",                       
                        success: function(response){                         
                        var len = response.length;
                        for(var i=0; i<len; i++){
                            var tabla = response[i].tabla;
                            var valor = response[i].valor;            
                        }  
                        if(valor==1){
                            swal({
                            position: 'top-end',
                            type: 'success',
                            title: 'STOCK correctamente actualualizado!!',
                            showConfirmButton: false,
                            timer: 1000
                            });
                        }  
                        else{
                            swal({
                            position: 'top-end',
                            type: 'error',
                            title: 'Ha ocurrido un error al tratar de actualizar el STOCK del insumo!!',
                            showConfirmButton: false,
                            timer: 1500
                            });
                        }                             
                            $('#editarStock').modal('hide');
                            $('#tbl_stocks_1').remove();
                            $("#tbl_stocks_2").show();                
                            $('#tbodyStocks').html(tabla);  
                        },
                        error: function() { 
                            alert("Error posting feed.");
                        }
                    });
                    event.preventDefault();
    });
    //#endregion

    function asignarValoresModalStock(id,grupo,nombre,stock_minimo,stock_maximo,bandera_stocks,unidad){
         $('#id_stock_remesa').val(id);
         $('#nombreRemesa').val(nombre);
         $('#stockMinimo').val(stock_minimo);
         $('#stockMaximo').val(stock_maximo);
         $('#unidadRemesa').val(unidad);         
    }


    function habilitarBandera(id)
    {
        var parametros = {
                "insumo_gasto_id" : id,
                "valor" : 1
        };

                                          

            $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>Remesas/actualizarBandera",
            data: parametros,
            dataType: "JSON",                                                    
            success: function(response){  

                var len = response.length;
                for(var i=0; i<len; i++){
                    var tabla = response[i].tabla;
                    var valor = response[i].valor;            
                }  
                
                if(valor==1){
                    swal({
                    position: 'top-end',
                    type: 'success',
                    title: 'Insumo HABILITADO para para el rango de STOCKS!!',
                    showConfirmButton: false,
                    timer: 1000
                    });
                }  
                else{
                    swal({
                    position: 'top-end',
                    type: 'error',
                    title: 'Ha ocurrido un error al tratar de deshabilitar el insumo!!',
                    showConfirmButton: false,
                    timer: 1500
                    });
                } 
                
                $('#tbl_stocks_1').remove();
                $("#tbl_stocks_2").show();                
                $('#tbodyStocks').html(tabla);                                                                                                                                 
            },
            error: function() { 
                alert("Error posting feed.");
            }
        });
    }

    function deshabilitarBandera(id)
    {
        var parametros = {
                "insumo_gasto_id" : id,
                "valor" : 0
        }; 

        

            $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>Remesas/actualizarBandera",
            data: parametros,
            dataType: "JSON",                                                    
            success: function(response){ 
                
                var len = response.length;
                for(var i=0; i<len; i++){
                    var tabla = response[i].tabla;
                    var valor = response[i].valor;            
                }

                if(valor==1){
                    swal({
                    position: 'top-end',
                    type: 'success',
                    title: 'Insumo DESHABILITADO para el rango de STOCKS!!',
                    showConfirmButton: false,
                    timer: 1000
                    });
                }  
                else{
                    swal({
                    position: 'top-end',
                    type: 'error',
                    title: 'Ha ocurrido un error al tratar de deshabilitar el insumo!!',
                    showConfirmButton: false,
                    timer: 1500
                    });
                }

                $('#tbl_stocks_1').remove();
                $("#tbl_stocks_2").show();                
                $('#tbodyStocks').html(tabla);  
            },
            error: function() { 
                alert("Error posting feed.");
            }
        });
    }

</script>

