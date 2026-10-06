

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
                                                                                 
                                            <div class="col-md-3">
                                            <input type="submit" name="buscar" value="Buscar" class="btn btn-primary">
                                            <a href="<?php echo base_url(); ?>Remesas/listRemesasOaxaca" class="btn btn-success">Reset</a>
                                           
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

