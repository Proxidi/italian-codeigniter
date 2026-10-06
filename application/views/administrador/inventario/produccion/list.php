
        <!-- =============================================== -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                Inventarios en Producción
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
																											<?php if($plaza->id == 1):?>
																												<option value="" selected>
																														Todas las plazas
																												</option>
																											<?php endif;?>
																											<?php if(isset($id) && $plaza->id==$id):?>
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
																												<?php if(isset($insumo1) && $insumo->id == $insumo1):?>
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

                                        <!--BOTON BUSCAR-->
                                            <div class="col-md-3">
                                            <button type='button' class="btn btn-success btn-flag" data-toggle="modal" data-target="#notificacionesInventario"><span class="glyphicon glyphicon-search" ></span> Ver Notificaciones</button>                                      
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



    <!-- Modal -->
    <div class="modal fade" id="notificacionesInventario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Notificaciones de Inventario</h4>            
            </div>
		  <div class="modal-body">
			
                <?php if(!empty($inventario_productos)):?>                                
                <table class="table" style="width:100%">
                    <thead>
                        <tr>
                            <th>Plaza</th>
                            <th>Nombre</th>
                            <th>Cantidad</th>                                                                                                                                                                                
                        </tr>
                    </thead>
                <tbody>
                <?php foreach ($inventario_productos as $inventario):?> 
                    <tr>                           
                    <?php if($inventario->Cantidad<=$inventario->stock_medio ):?> 


                    <?php switch($inventario->plaza_id): 
                        case 1: ?>
                        <td bgcolor="#bae6ff"><?=$inventario->Plaza;?></td>
                        <?php break; ?>

                        <?php case 2: ?>
                        <td bgcolor="#FA8072"><?=$inventario->Plaza;?></td>
                        <?php break; ?>
                        
                        <?php case 3: ?>
                        <td bgcolor="#8cedbc"><?=$inventario->Plaza;?></td>
                        <?php break; ?>

                        <?php case 4: ?>
                        <td bgcolor="#ecccbb"><?=$inventario->Plaza;?></td>
                        <?php break; ?>

                        <?php case 5: ?>
                        <td bgcolor="#ffd682"><?=$inventario->Plaza;?></td>
                        <?php break; ?>

                        <?php case 6: ?>
                        <td bgcolor="#e7bbec"><?=$inventario->Plaza;?></td>
                        <?php break; ?>

                        <?php case 7: ?>
                        <td bgcolor="#a7bbec"><?=$inventario->Plaza;?></td>
                        <?php break; ?>
                    <?php endswitch; ?>
                                                            

                    <td><?=$inventario->Nombre?></td>                    
                    <?php if($inventario->Cantidad<=$inventario->stock_minimo ):?> 
                    <td bgcolor="#ff6d4e"><h4><?=round($inventario->Cantidad,2);?></h4></td> 
                    <?php else:?> 
                    <td bgcolor="#ff9828"><h4><?=round($inventario->Cantidad,2);?></h4></td>  
                    <?php endif;?>
                    <?php else:?>                     
                    <?php endif;?>                                                     
                    </tr>     
                    <?php endforeach;?>                                
                </tbody>

                </table>                              
                    
                                                                           
                <?php endif;?>     


              
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>			
		  </div>
		  
		</div>
	  </div>
	</div>
	

    


