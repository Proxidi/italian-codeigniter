<!-- =============================================== -->
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                Remesas Admistrador
                <small>Listado</small>
                </h1>
                <a href="<?php echo base_url(); ?>Remesas" class="small-box-footer">Volver al Panel de Administración <i class="fa fa-arrow-circle-right"></i></a>

            </section>
            <!-- Main content -->
            <section class="content">
                <!-- Default box -->
                <div class="box box-solid">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12"> 
                            <h3><?php echo $mensaje; ?></h3>                                                         
                                <form action="<?php echo current_url();?>" method="POST" class="form-horizontal">
                                    <div class="form-group">     

                                        <label for="" class="col-md-1 control-label">Fecha:</label>
                                            <div class="col-md-3">
                                                <input type="date" class="form-control" name="fechaInicioD" id="fechaInicioD" value="<?php echo !empty($fechainicio) ? $fechainicio:'';?>" required>
                                            </div>

                                        <label for="plaza_id" class="col-md-1 control-label">Plaza:</label>
                                            <div class="col-md-3">
                                                <select name="plaza_id" id="plaza_id" class="form-control">                                                  
                                                <?php foreach ($plazas as $plaza):?>  
                                                <?php if($plaza->id==1):?>
                                                <option value="" selected>
                                                    Todas las Plazas
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
                                            <label for="plaza_id" class="col-md-1 control-label"></label>                                         
                                        <div class="col-md-3">
                                            <input type="submit" name="buscar" value="Buscar" class="btn btn-primary">
                                            <a href="<?php echo base_url(); ?>Remesas/listRemesasGenerales" class="btn btn-success">Reset</a>
                                           
                                        </div>              
                                    </div>
                                </form>   
                            </div>                            
                         </div>  
                                                
                         <div class="row">
                            <div class="col-md-12">

                            <?php if(isset($gastosPasados)):?>                            
                            <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_gastos_admin">
                                <thead>
                                    <tr>                                    
                                        
                                        <th>Usuario</th>
                                        <th>Plaza</th>   
                                        <th>Gasto</th> 
                                        <th>Pago</th> 
                                        <th>Cantidad</th>
                                        <th>Importe</th>
                                        <th>Notas</th>                                                                                                    
                                        <th>Fecha</th>                                                                                 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(!empty($gastosPasados)):?>
                                    <?php
                                    $acImporte=0;                                
                                    ?>
                                    <?php foreach ($gastosPasados as $gasto):?>
                                    <?php
                                    $acImporte+=$gasto->Importe;                                
                                    ?>

                                    <?php if($gasto->Rol==1 || $gasto->Rol==3):?>
                                    <tr bgcolor="#bae6ff">
                                    <?php else:?>
                                    <tr>
                                    <?php endif;?>                                  
                                        <td><?=$gasto->Usuario;?></td>
                                        <td><?=$gasto->Plaza;?></td>
                                        <td><?=$gasto->Insumo;?></td>       
                                        <td><?=$gasto->Pago;?></td> 
                                        <td><?=$gasto->Cantidad;?></td>
                                        <td><b>$<?=number_format($gasto->Importe);?></b></td>     
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
                                        <td></td>
                                        <td><b>Total:</b></td>
                                        <td><b>$ <?=number_format($acImporte);?></b></td>                                    
                                        <td></td>     
                                        <td></td>                                                                                                                                   
                                    </tr>   
                                                                                          
                                    <?php endif;?>                                
                                </tbody>
                                
                                </table>                     

                            <?php endif;?>  

                            <?php if(isset($gastos)):?>                            
                                <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_gastos_admin">
                                <thead>
                                    <tr>                                    
                                        <th>Usuario</th>
                                        <th>Plaza</th>   
                                        <th>Gasto</th> 
                                        <th>Pago</th> 
                                        <th>Cantidad</th>
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

                                    <?php if($gasto->Rol==1 || $gasto->Rol==3):?>
                                    <tr bgcolor="#bae6ff">
                                    <?php else:?>
                                    <tr>
                                    <?php endif;?>                                  
                                        <td><?=$gasto->Usuario;?></td>
                                        <td><?=$gasto->Plaza;?></td>
                                        <td><?=$gasto->Insumo;?></td>       
                                        <td><?=$gasto->Pago;?></td> 
                                        <td><?=$gasto->Cantidad;?></td>
                                        <td><b>$ <?=number_format($gasto->Importe);?></b></td>  
                                        <td>                                        
                                        <?php $mensaje=preg_replace("/[\n]/","<br>",$gasto->Notas);
                                        echo $mensaje;
                                        ?>
                                        </td>                                    
                                        <td><?=$gasto->Fecha;?></td>     

                                        <td>
                                        <button onclick="eliminarGastoManagerAdministrador('<?php echo $gasto->Fecha;?>',<?php echo $gasto->plaza_id;?>,<?php echo $gasto->id;?>,<?php echo $gasto->usuario_id;?>,<?php echo $gasto->Cantidad;?>,<?php echo $gasto->insumo_gasto_id;?>)" class="btn btn-danger btn-remove">
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
                                        <td><b>$ <?=number_format($acImporte);?></b></td>                                    
                                        <td></td>
                                        <td></td>  
                                        <td></td>                                                                                                    
                                    </tr>   
                                                                                           
                                    <?php endif;?>                                
                                </tbody>
                                
                                </table>
                            <?php endif;?>                             
                            
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

    <script type="text/javascript">  
    
    //AJAX REQUEST
    function eliminarGastoManagerAdministrador(fecha,plaza_id,id,usuario_id,cantidad,insumo_gasto_id){                
        
        var parametros = {
            "fecha" : fecha,    
            "plaza_id" : plaza_id         
        };             

        $.ajax({
        type: "POST",
        url: "<?php echo base_url();?>Ventas/consultarEstadoVenta",
        data: parametros,
        success: function(data){  
              
            if(data==1){                    
                    swal({                            
                        type: 'question',
                        title: 'El archivo de ventas ya fue enviado y los gastos cargados',
                        text: 'Para eliminar un gasto elimine la venta primero y después prosiga con el gasto',
                        allowOutsideClick: false
                        });
            }else if(data==0){                    
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
                            url: "<?php echo base_url();?>Remesas/deleteAdmin",
                            data: parametros,
                            beforeSend: function(objeto){                                                      
                            },
                            success: function(datos){
                                if(datos==1){
                                swal(
                                    'Eliminado!',
                                    'Gasto Eliminado.',
                                    'success'
                                ).then(function() {                                                        
                                    window.location= "<?php echo base_url();?>Remesas/listRemesasGenerales";                       
                                });                            
                                }          
                                else if(datos==0){
                                    alert("No eliminado");
                                }                                  
                        },error: function() { alert("Error posting feed."); }
                    }); 

            /////////////////////////////////////////////////////////////////////////// 
            }                
            }); 
            }  
            else if(data==2){
                swal({                            
                        type: 'error',
                        title: 'Error en la consulta',
                        text: 'Eror en la consulta de la bandera',
                        allowOutsideClick: false
                        });
            }
        },
        error: function() { alert("Error posting feed."); }
        });    
}
    </script>


