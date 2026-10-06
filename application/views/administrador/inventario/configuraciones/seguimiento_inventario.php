
        <!-- =============================================== -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
              Seguimiento de Inventario
                <small>Listado</small>
                </h1>
                <a href="<?php echo base_url(); ?>Inventario" class="small-box-footer">Volver al Panel del Inventario <i class="fa fa-arrow-circle-right"></i></a>
                 
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
                                                                    
                                    <label for="" class="col-md-1 control-label">Desde:</label>
                                        <div class="col-md-3">
                                            <input type="date" class="form-control" name="fechaInicio" id="fechaInicio" value="<?php echo !empty($fechaInicio) ? $fechaInicio:'';?>" required>
                                        </div>

                                    <label for="" class="col-md-1 control-label">Hasta:</label>
                                        <div class="col-md-3">
                                            <input type="date" class="form-control" name="fechaFin" id="fechaFin" value="<?php  echo !empty($fechaFin) ? $fechaFin:'';?>">
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
                                </div>                
                                <div class="form-group">                                                                                                   
                                        <label for="insumo_id_seguimiento" class="col-md-1 control-label">Insumos:  </label>                           
                                        <div class="col-md-3">
                                        <select name="insumo_id_seguimiento" id="insumo_id_seguimiento" class="form-control" >
                                            <option value="">Seleccionar Insumo</option>  
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
                                        <div class="col-md-6">                                        
                                            <input type="submit" name="buscar" value="Buscar" class="btn btn-primary">
                                            <input type="submit" name="buscarRango" value="B. Rango" class="btn btn-danger">                                                                                                                        
                                            <a href="<?php echo current_url();?>" class="btn btn-success">Reestablecer</a>
                                        </div>
                                </div>
                            </form>                                               
                            </div>
                    </div>
                        <!--./ DIV.ROW -->
                         <div class="row">
                            <div class="col-md-12">                                                                             
                            <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_gastos_admin">
                            <thead>
                                <tr>                                                                                                            
                                    <th>Plz</th>  
                                    <th>Concepto</th>                                     
                                    <th>Insumo</th>                                    
                                    <th>A.Cantidad</th>
                                    <th>N.Cantidad</th>    
                                    <th>Diferencia</th>  
                                    <th>Cantidad</th>                              
                                    <th>Fecha</th>                                                                             
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($movimientos)):?>                               
                                <?php foreach ($movimientos as $movimiento):?>                               
                                <tr>
                                    <td><?=$movimiento->Acronimo;?></td>                                    
                                    <td><?=$movimiento->Tipo_Movimiento;?></td>                                    
                                    <td><?=$movimiento->Insumo;?></td> 
                                    <td><?=$movimiento->Antigua_Cantidad;?></td>
                                    <td><?=$movimiento->Nueva_Cantidad;?></td>   
                                    
                                    <?php $resultado=$movimiento->Nueva_Cantidad-$movimiento->Antigua_Cantidad; ?>
                                    <?php if($resultado>0):?>
                                    <td bgcolor="#d1ffaf"><?= $resultado?></td>                                 
                                    <?php elseif($resultado==0):?>
                                    <td bgcolor=""><?= $resultado?></td>             
                                    <?php else:?>
                                    <td bgcolor="#ffacac"><?= $resultado?></td>             
                                    <?php endif;?>                                    
                                    <td><?=$movimiento->Unidad;?></td>                                                                                                       
                                    <td><?=$movimiento->Fecha;?></td>                                                                                                                                                                    
                                </tr>   
                                <?php endforeach;?>                                                                                           
                                <?php endif;?>                                
                            </tbody>                            
                            </table>                                                                                         
                            </div>
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

  