    <!-- =============================================== -->
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                Análisis Ventas
                <small>Listado</small>
                </h1>
                <a href="<?php echo base_url(); ?>Depositos/panel" class="small-box-footer">Volver al Panel de Ventas <i class="fa fa-arrow-circle-right"></i></a>
            </section>
            <!-- Main content -->
            <section class="content">
                <!-- Default box -->
                <div class="box box-solid">
                    <div class="box-body">
                    <!--ROW-->
                    <div class="row"> 
                        <!--COL-MD-12-->
                        <div class="col-md-12">                           
                        <form action="<?php echo current_url();?>" method="POST" class="form-horizontal">
                                <div class="form-group">
                                                                    
                                    <label for="" class="col-md-1 control-label">Desde:</label>
                                        <div class="col-md-3">
                                            <input type="date" class="form-control" name="fechaInicioD" id="fechaInicioD" value="<?php echo !empty($fechainicio) ? $fechainicio:'';?>" required>
                                        </div>

                                    <label for="" class="col-md-1 control-label">Hasta:</label>
                                        <div class="col-md-3">
                                            <input type="date" class="form-control" name="fechaFinD" id="fechaFinD" value="<?php  echo !empty($fechafin) ? $fechafin:'';?>">
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
                                    <label for="" class="col-md-1 control-label">Options:  </label>                           
                                        <div class="col-md-10">
                                            <input type="submit" name="buscar" value="Buscar" class="btn btn-primary">
                                            <input type="submit" name="buscarRango" value="Buscar Rango" class="btn btn-danger">                                
                                            <input type="submit" name="buscarRangoDesglose" value="Buscar Rango Desglose" class="btn btn-danger" id="buscar_rango_depositos_list">                                      
                                            <a href="<?php echo current_url();?>" class="btn btn-success">Restablecer</a>
                                        </div>
                                        
                                </div>
                            </form>                                               
                            </div>
                    </div>
                    
                         
                         <div class="row">
                            <div class="col-md-12">
                            <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_depositos">
                            <thead>
                                <tr>       
                                    <th>Plaza</th>
                                    <th>Fecha</th>
                                    <th>Total V</th>                                                                                                        
                                    <th>G. Manager</th>
                                    <th>% G.Manager</th>       
                                    <th>G. Admin</th>   
                                    <th>% G.Admin</th>     
                                    <th>T. Gastos</th>     
                                    <th>% T. Gastos</th>                                                                        
                                    <th>Efectivo</th>                                            
                                </tr>
                            </thead>
                            <tbody>
                        <?php if(!empty($reportes)):?>
                                <?php
                                $acVentas=0;
                                $acIngresos=0;
                                $acTPV=0;
                                $acGastos=0;
                                $acGastosA=0;
                                $acGastosT=0;
                                $acDeposito=0;
                                $acEfectivo=0;
                                $color="";
                                ?>
                            
                            <?php if($menu==0):?>
                                <?php foreach ($reportes as $reporte):?>
                                    <?php                                    
                                    $acIngresos+=$reporte->Total_Ingresos;                                    
                                    $acGastos+=$reporte->Gastos;     
                                    $acGastosA+=$reporte->Gastos_Admin;
                                    $acGastosT+=$reporte->Total_Gastos;                                                                   
                                    $acEfectivo+=$reporte->Efectivo_Real;?>
                                    <tr>              
                                        <?php switch($reporte->plaza_id): 
                                            case 1: ?>
                                            <td bgcolor="#bae6ff"><?=$reporte->Plaza;?></td>
                                            
                                            <?php break; ?>

                                            <?php case 2: ?>
                                            <td bgcolor="#FA8072"><?=$reporte->Plaza;?></td>
                                            <?php break; ?>
                                            
                                            <?php case 3: ?>
                                            <td bgcolor="#8cedbc"><?=$reporte->Plaza;?></td>
                                            <?php break; ?>

                                            <?php case 4: ?>
                                            <td bgcolor="#ecccbb"><?=$reporte->Plaza;?></td>
                                            <?php break; ?>

                                            <?php case 5: ?>
                                            <td bgcolor="#ffd682"><?=$reporte->Plaza;?></td>
                                            <?php break; ?>

                                            <?php case 6: ?>
                                            <td bgcolor="#e7bbec"><?=$reporte->Plaza;?></td>
                                            <?php break; ?>
                                            
                                            <?php case 7: ?>
                                            <td bgcolor="#c7d5d8"><?=$reporte->Plaza;?></td>
                                            <?php break; ?>
                                            
                                        <?php endswitch; ?>

                                            <td bgcolor="<?php echo $color;?>"><?=$reporte->Fecha;?></td>
                                            <td bgcolor="<?php echo $color;?>"> $ <?=number_format($reporte->Total_Ingresos);?></td>                                                                        
                                            <td bgcolor="<?php echo $color;?>"> $ <?=number_format($reporte->Gastos);?></td>
                                            <td bgcolor="<?php echo $color;?>"><?=round($reporte->Gastos/$reporte->Total_Ingresos,4)*100;?>%</td>    
                                            <td bgcolor="<?php echo $color;?>"> $ <?=number_format($reporte->Gastos_Admin);?></td>
                                            <td bgcolor="<?php echo $color;?>"><?=round($reporte->Gastos_Admin/$reporte->Total_Ingresos,4)*100;?>%</td>    
                                            <td bgcolor="<?php echo $color;?>"> $ <?=number_format($reporte->Total_Gastos);?></td>                   
                                            <td bgcolor="<?php echo $color;?>"><?=round($reporte->Total_Gastos/$reporte->Total_Ingresos,4)*100;?>%</td>                                                             
                                            <td bgcolor="<?php echo $color;?>"> $ <?=number_format($reporte->Efectivo_Real);?></td>                                                                                                                                                                         
                                    </tr>   
                                <?php endforeach;?> 
                                    <tr>                                    
                                        <td><b><h4>Totales</h4></b></td>
                                        <td></td>
                                        <td><b>$ <?=number_format($acIngresos);?></b></td>  
                                        <td><b>$ <?=number_format($acGastos);?></b></td> 
                                        <td><b> <?=round($acGastos/$acIngresos,4)*100;?>%</b></td>       
                                        <td><b>$ <?=number_format($acGastosA);?></b></td>                
                                        <td><b> <?=round($acGastosA/$acIngresos,4)*100;?>%</b></td>                                                            
                                        <td><b>$ <?=number_format($acGastosT);?></b></td>                
                                        <td><b> <?=round($acGastosT/$acIngresos,4)*100;?>%</b></td>                                                                                                   
                                        <td><b>$ <?=number_format($acEfectivo);?></b></td>                                                                                                
                                    </tr>  
                            <?php endif;?> 

                                
                                
                            <?php if($menu==1):?>
                                <?php foreach ($reportes as $reporte):?>
                                    <?php
                                    $acVentas+=$reporte->SumaVentasC;
                                    $acIngresos+=$reporte->SumaTotalV;
                                    $acTPV+=$reporte->SumaTPV;
                                    $acGastos+=$reporte->SumaGastos;                                
                                    $acGastosA+=$reporte->SumaGastosAdmin;
                                    $acGastosT+=$reporte->SumaGastosTodos;
                                    $acDeposito+=$reporte->SumaDeposito;
                                    $acEfectivo+=$reporte->SumaEfectivo;                                
                                    ?>
                                    <tr>                                                                     
                                        <?php switch($reporte->plaza_id): 
                                            case 1: ?>
                                            <td bgcolor="#bae6ff"><?=$reporte->Plaza;?></td>
                                            <?php break; ?>

                                            <?php case 2: ?>
                                            <td bgcolor="#FA8072"><?=$reporte->Plaza;?></td>
                                            <?php break; ?>
                                            
                                            <?php case 3: ?>
                                            <td bgcolor="#8cedbc"><?=$reporte->Plaza;?></td>
                                            <?php break; ?>

                                            <?php case 4: ?>
                                            <td bgcolor="#ecccbb"><?=$reporte->Plaza;?></td>
                                            <?php break; ?>

                                            <?php case 5: ?>
                                            <td bgcolor="#ffd682"><?=$reporte->Plaza;?></td>
                                            <?php break; ?>

                                            <?php case 6: ?>
                                            <td bgcolor="#e7bbec"><?=$reporte->Plaza;?></td>
                                            <?php break; ?>
                                            
                                            <?php case 7: ?>
                                            <td bgcolor="#c7d5d8"><?=$reporte->Plaza;?></td>
                                            <?php break; ?>                                        
                                        <?php endswitch; ?>
                                        <td><?=$fechaConsulta?></td>                          
                                        <td> $ <?=number_format($reporte->SumaTotalV);?></td>                                                                                   
                                        <td> $ <?=number_format($reporte->SumaGastos);?></td>
                                        <td> <?=round($reporte->SumaGastos/$reporte->SumaTotalV,4)*100;?>%</td>    
                                        <td> $ <?=number_format($reporte->SumaGastosAdmin);?></td>
                                        <td> <?=round($reporte->SumaGastosAdmin/$reporte->SumaTotalV,4)*100;?>%</td>    
                                        <td> $ <?=number_format($reporte->SumaGastosTodos);?></td>                 
                                        <td> <?=round($reporte->SumaGastosTodos/$reporte->SumaTotalV,4)*100;?>%</td>                                                                      
                                        <td> $ <?=number_format($reporte->SumaEfectivo);?></td>                                           
                                    </tr>                                    
                                <?php endforeach;?>     
                                    <tr>                                    
                                        <td><b><h4>Totales</h4></b></td>
                                        <td></td>
                                        <td><b>$ <?=number_format($acIngresos);?></b></td>  
                                        <td><b>$ <?=number_format($acGastos);?></b></td> 
                                        <td><b> <?=round($acGastos/$acIngresos,4)*100;?>%</b></td>     
                                        <td><b>$ <?=number_format($acGastosA);?></b></td>              
                                        <td><b> <?=round($acGastosA/$acIngresos,4)*100;?>%</b></td>                                                            
                                        <td><b>$ <?=number_format($acGastosT);?></b></td>              
                                        <td><b> <?=round($acGastosT/$acIngresos,4)*100;?>%</b></td>                                                                                                     
                                        <td><b>$ <?=number_format($acEfectivo);?></b></td>                                                                                                
                                    </tr>  
                            <?php endif;?>                                                                                                                                            

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

