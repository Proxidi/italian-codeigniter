
        <!-- =============================================== -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                Análisis de Ticket Promedio && Unidad Promedio
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
                            <label for="" class="col-md-1 control-label">Plaza:</label>
                            <div class="col-md-3">
                            <select name="plaza_idP" id="plaza_idP" class="form-control">                                                  
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
                            <div class="form-group">
                            </div> 
                            <label for="" class="col-md-1 control-label">Options:  </label>                           
                            <div class="col-md-10">
                                <input type="submit" name="buscar" value="Buscar" class="btn btn-primary">
                                <input type="submit" name="buscarRango" value="Buscar Rango" class="btn btn-danger">                                
                                <input type="submit" name="buscarRangoDesglose" value="Buscar Rango Desglose" class="btn btn-danger">  
                              
                                <a href="<?php echo base_url(); ?>Depositos/tickets" class="btn btn-success">Restablecer</a>
                            </div>
                        </div>
                        </form>                       
                        
                            </div>
                         </div>
                         
                         <div class="row">
                            <div class="col-md-12">
                            <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_UT" >
                            <thead>
                                <tr>                                                   
                                    <th>Plaza</th>
                                    <th>Fecha</th>
                                    <th>Tickets</th>
                                    <th>T. Comedor</th>
                                    <th>P. Comedor</th>
                                    <th>T. Llevar</th>
                                    <th>P. Llevar</th>
                                    <th>TP</th>
                                    <th>Unidades</th>                                    
                                    <th>UT</th>        
                                    <th>DLC</th>                                                                                                             
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($tickets)):?>    
                                <?php 
                                $acTickets=0;
                                $acComedor=0;
                                $acPComedor=0;
                                $acLlevar=0;
                                $acPLlevar=0;                            
                                $acTP=0;
                                $acUnidades=0;
                                $acUT=0;
                                $contador=0;
                                ?>
                                

                                <?php foreach ($tickets as $ticket):?>
                                <?php 
                                $acTickets+=$ticket->Tickets;                                
                                $acComedor+=$ticket->Tickets_Comedor;
                                $acPComedor+=round($ticket->Porcentaje_Comedor,2);                                
                                $acLlevar+=$ticket->Tickets_Llevar;
                                $acPLlevar+=round($ticket->Porcentaje_Llevar,2);
                                $acTP+=round($ticket->TP,2);
                                $acUnidades+=$ticket->Unidades;
                                $acUT+=round($ticket->UT,2);
                                $contador++;
                                ?>

                                <tr>
                                <?php switch($ticket->plaza_id): 
                                    case 1: ?>                                    
                                    <td bgcolor="#bae6ff"><?=$ticket->Plaza?></td>
                                    <?php break; ?>

                                    <?php case 2: ?>
                                    
                                    <td bgcolor="#FA8072"><?=$ticket->Plaza?></td>
                                    <?php break; ?>
                                    
                                    <?php case 3: ?>
                                    
                                    <td bgcolor="#8cedbc"><?=$ticket->Plaza?></td>
                                    <?php break; ?>

                                    <?php case 4: ?>
                                    
                                    <td bgcolor="#ecccbb"><?=$ticket->Plaza?></td>
                                    <?php break; ?>

                                    <?php case 5: ?>
                                    
                                    <td bgcolor="#ffd682"><?=$ticket->Plaza?></td>
                                    <?php break; ?>

                                    <?php case 6: ?>
                                    
                                    <td bgcolor="#e7bbec"><?=$ticket->Plaza?></td>
                                    <?php break; ?>
                                    
                                    <?php case 7: ?>
                                    
                                    <td bgcolor="#e7bbec"><?=$ticket->Plaza?></td>
                                    <?php break; ?>
                                    
                                    <?php endswitch; ?>
                                                                                 
                                    <?php if(isset($desglose)):?>
                                    <?php if(!empty($desglose)):?>                                    
                                    <?php if($desglose==1):?>
                                    <td><?=$fechaConsulta?></td>
                                    <?php elseif($desglose==0):?>  
                                    <td><?=$ticket->Fecha?></td>
                                    <?php endif;?> 
                                    <?php else:?>  
                                    <td><?=$ticket->Fecha?></td>
                                    <?php endif;?> 
                                    <?php else:?>  
                                    <td><?=$ticket->Fecha?></td>
                                    <?php endif;?>     

                                    <td><?=$ticket->Tickets?></td>
                                    <td><?=$ticket->Tickets_Comedor?></td>
                                    <td><?=round($ticket->Porcentaje_Comedor,2)?>%</td>
                                    <td><?=$ticket->Tickets_Llevar?></td>
                                    <td><?=round($ticket->Porcentaje_Llevar,2)?>%</td>
                                    <td><?=round($ticket->TP,2)?></td>
                                    <td><?=$ticket->Unidades?></td>
                                    <td><?=round(floatval($ticket->UT),2)?></td>   
                                    <?php if($ticket->Unidades==0 && $ticket->UT==0):?>                      
                                    <td>FALTANTE</td>
                                    <?php else:?>  
                                    <td>AGREGADO</td>
                                    <?php endif;?>                                     
                                </tr>
                                <?php endforeach;?>  
                                <tr>                                                                   
                                    <td>Totales</td>
                                    <td></td>
                                    <td><b><?=number_format($acTickets);?></b></td>
                                    <td><b><?=number_format($acComedor);?></b></td>
                                    <td><b><?=round(($acPComedor/$contador),2);?>%</b></td>
                                    <td><b><?=number_format($acLlevar);?></b></td>
                                    <td><b><?=round(($acPLlevar/$contador),2);?>%</b></td>
                                    <td><b><?=round(($acTP/$contador),2);?></b></td>
                                    <td><b><?=number_format($acUnidades);?></b></td>
                                    <td><b><?=round(($acUT/$contador),2);?></b></td>
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

