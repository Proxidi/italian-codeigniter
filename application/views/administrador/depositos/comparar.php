
        <!-- =============================================== -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                Comparar Ventas Plazas
                <small>Listado</small>
                </h1>
                <a href="<?php echo base_url(); ?>Depositos/panel" class="small-box-footer">Volver al Panel de Ventas <i class="fa fa-arrow-circle-right"></i></a>
            </section>
            <!-- Main content -->
            <section class="content">
                <!-- Default box -->
                <div class="box box-solid">
                    <div class="box-body">
                        <div class="row"> 
                        <div class="col-md-12">    

                        <!-- ERROR EN EL PROCESAMIENTO DEL ARCHIVO -->
                        <?php if($this->session->flashdata("error")):?>                                  
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4><i class="icon fa fa-ban"></i> Alerta</h4>
                            <?php echo $this->session->flashdata("error");?>
                        </div>
                        <?php endif; ?>
                        <!-- /. ERROR EN EL PROCESAMIENTO DEL ARCHIVO -->                       
                        
                        <form action="<?php echo current_url();?>" method="POST" class="form-horizontal">
                        <div class="form-group">    
                        
                         <!--COMBOBOX AÑOS-->
                         <label for="" class="col-md-1 control-label">Año:</label>
                            <div class="col-md-3">
                            <select name="year_id" id="year_id" class="form-control" required>                                                  
                                    <?php foreach ($years as $year):?>  
                                    <?php if($year->id==1):?>
                                    <option value="" selected>
                                        Seleccionar Año
                                        </option>
                                    <?php endif;?>
                                        <?php if($year->id==$year_id):?>
                                        <option value="<?php echo $year->id?>" selected>
                                        <?php echo $year->Nombre;?>
                                        </option>
                                    <?php else:?>
                                    <option value="<?php echo $year->id?>">
                                        <?php echo $year->Nombre;?>
                                    </option>
                                    <?php endif;?>
                                        <?php endforeach;?>?>
                                    </select>                                    
                            </div>
                        <!--./ COMBOBOX AÑOS-->



                        <!--COMBOBOX MESES-->
                            <label for="" class="col-md-1 control-label">Mes:</label>
                            <div class="col-md-3">
                            <select name="mes_id" id="mes_id" class="form-control" required>                                                  
                                    <?php foreach ($meses as $mes):?>  
                                    <?php if($mes->id==1):?>
                                    <option value="" selected>
                                        Seleccionar Mes
                                        </option>
                                    <?php endif;?>
                                        <?php if($mes->id==$mes_id):?>
                                        <option value="<?php echo $mes->id?>" selected>
                                        <?php echo $mes->Nombre;?>
                                        </option>
                                    <?php else:?>
                                    <option value="<?php echo $mes->id?>">
                                        <?php echo $mes->Nombre;?>
                                    </option>
                                    <?php endif;?>
                                        <?php endforeach;?>?>
                                    </select>                                    
                            </div>
                        <!--./ COMBOBOX MESES-->

                            <!--COMBOBOX PLAZAS-->
                            <label for="" class="col-md-1 control-label">Plaza:</label>
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
                            </div>
                            <!--./ COMBOBOX PLAZAS-->                                                   
                        </div>

                        <div class="form-group">
                        
                            <label for="" class="col-md-1 control-label">Options:  </label>                           
                            <div class="col-md-3">
                                <input type="submit" name="buscar" value="Buscar" class="btn btn-primary">                                
                            </div>    
                        
                        </div>
                        </form> 

                           </div>
                           </div>
                         
                         <div class="row">
                            <div class="col-md-12">
                            <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_comparar_ventas">
                            <thead>
                                <tr>                                                   
                                    <th>Plaza</th>
                                    <th>Mes</th>
                                    <th>Semana</th>                                
                                    <th>Domingo</th>
                                    <th>Lunes</th>
                                    <th>Martes</th>
                                    <th>Miercoles</th>                                    
                                    <th>Jueves</th>   
                                    <th>Viernes</th>
                                    <th>Sabado</th>                                
                                    <th>Totales</th>
                                  

                                </tr>
                            </thead>
                            <tbody>
                            <?php if(!empty($reportes)):?> 

                            <?php
                                $acLunes=0;
                                $acMartes=0;
                                $acMiercoles=0;
                                $acJueves=0;
                                $acViernes=0;
                                $acSabado=0;
                                $acDomingo=0;
                                $acFila=0;                                                                
                            ?>       

                            <?php foreach ($reportes as $reporte):?>

                            <?php 
                                    
                                    $acLunes+=$reporte->Venta_Lunes;                                    
                                    $acMartes+=$reporte->Venta_Martes;
                                    $acMiercoles+=$reporte->Venta_Miercoles;
                                    $acJueves+=$reporte->Venta_Jueves;
                                    $acViernes+=$reporte->Venta_Viernes;
                                    $acSabado+=$reporte->Venta_Sabado;
                                    $acDomingo+=$reporte->Venta_Domingo;

                                    
                                    $acFila=
                                    $reporte->Venta_Lunes+
                                    $reporte->Venta_Martes+
                                    $reporte->Venta_Miercoles+
                                    $reporte->Venta_Jueves+
                                    $reporte->Venta_Viernes+
                                    $reporte->Venta_Sabado+
                                    $reporte->Venta_Domingo;
                                    ?>

                               <tr>                                

                                    

                                <?php switch($reporte->plaza_id): 
                                    case 1: ?>
                                    <td bgcolor="#bae6ff"><?= $reporte->Plaza ?></td>
                                    <?php break; ?>

                                    <?php case 2: ?>
                                    <td bgcolor="#FA8072"><?= $reporte->Plaza ?></td>
                                    <?php break; ?>
                                    
                                    <?php case 3: ?>
                                    <td bgcolor="#8cedbc"><?= $reporte->Plaza ?></td>
                                    <?php break; ?>

                                    <?php case 4: ?>
                                    <td bgcolor="#ecccbb"><?= $reporte->Plaza ?></td>
                                    <?php break; ?>

                                    <?php case 5: ?>
                                    <td bgcolor="#ffd682"><?= $reporte->Plaza ?></td>
                                    <?php break; ?>

                                    <?php case 6: ?>
                                    <td bgcolor="#e7bbec"><?= $reporte->Plaza ?></td>
                                    <?php break; ?>

                                    <?php case 7: ?>
                                    <td bgcolor="#c7d5d8"><?= $reporte->Plaza ?></td>
                                    <?php break; ?> 

                                <?php endswitch; ?> 
                                    <?php switch($reporte->Mes): 
                                    case 1: ?>
                                    <td>Enero</td>
                                    <?php break; ?>

                                    <?php case 2: ?>
                                    <td>Febrero</td>
                                    <?php break; ?>
                                    
                                    <?php case 3: ?>
                                    <td>Marzo</td>
                                    <?php break; ?>

                                    <?php case 4: ?>
                                    <td>Abril</td>
                                    <?php break; ?>

                                    <?php case 5: ?>
                                    <td>Mayo</td>
                                    <?php break; ?>

                                    <?php case 6: ?>
                                    <td>Junio</td>
                                    <?php break; ?>

                                    <?php case 7: ?>
                                    <td>Julio</td>
                                    <?php break; ?>

                                    <?php case 8: ?>
                                    <td>Agosto</td>
                                    <?php break; ?>

                                    <?php case 9: ?>
                                    <td>Septiembre</td>
                                    <?php break; ?>

                                    <?php case 10: ?>
                                    <td>Octubre</td>
                                    <?php break; ?>

                                    <?php case 11: ?>
                                    <td>Noviembre</td>
                                    <?php break; ?>

                                    <?php case 12: ?>
                                    <td>Diciembre</td>
                                    <?php break; ?>
                                <?php endswitch; ?> 


                                    <td> <?=$reporte->N_Semana?> </td>
                                    <td> $<?=number_format($reporte->Venta_Domingo);?> </td>  
                                    <td> $<?=number_format($reporte->Venta_Lunes);?> </td>
                                    <td> $<?=number_format($reporte->Venta_Martes);?> </td>
                                    <td> $<?=number_format($reporte->Venta_Miercoles);?> </td>  
                                    <td> $<?=number_format($reporte->Venta_Jueves);?> </td>  
                                    <td> $<?=number_format($reporte->Venta_Viernes);?> </td>  
                                    <td> $<?=number_format($reporte->Venta_Sabado);?> </td>  
                                    <td> $<?=number_format($acFila);?></td>
                                </tr>                    
                            <?php endforeach;?>  
                                <tr >
                                         <td><b><h4>Totales</h4></b></td>                                        
                                        <td></td>  
                                        <td></td>                                      
                                        <td><b>$<?=number_format($acDomingo);?></b></td>
                                        <td><b>$<?=number_format($acLunes);?></b></td>
                                        <td><b>$<?=number_format($acMartes);?></b></td>
                                        <td><b>$<?=number_format($acMiercoles);?></b></td>
                                        <td><b>$<?=number_format($acJueves);?></b></td>
                                        <td><b>$<?=number_format($acViernes);?></b></td>
                                        <td><b>$<?=number_format($acSabado);?></b></td>
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

<div class="modal fade" id="modal-default">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Informacion del Usuario</h4>
      </div>
      <div class="modal-body">
      <div class="row">
                    <div class="col-md-12">
                        <div class="box">
                        <div class="box-header with-border">
                        
                                <h3 class="box-title">Grafico estadistico</h3>
                                

                            <div class="box-tools pull-right">
                                                                                                                                          
                                </div>
                            </div>

                          
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        
                                        <div id="grafico" style="min-width: 310px; height: 400px;margin: 0 auto"></div>
                                    </div>
                                </div>
                                <!-- /.row -->

                            </div>
                            <!-- ./box-body -->

                        </div>
                        <!-- /.box -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

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

