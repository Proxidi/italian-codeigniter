
        <!-- =============================================== -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                Inventario Físico. F.G.F
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
                                                    <?php if(isset($id) && $plaza->id == $id):?>
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

                                        <!--COMBOBOX PLAZAS-->
                                        <label for="plaza_id" class="col-md-1 control-label">Insumos:</label>
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
                                        <!--./ COMBOBOX PLAZAS-->
                                                                        
                                        <!--BOTON BUSCAR-->
                                            <div class="col-md-4">
                                                <input type="submit" name="buscar" value="Buscar Inventario" class="btn btn-primary">                                                                                       
                                                <button type='button' class="btn btn-success btn-flag" data-toggle="modal" data-target="#notificacionesFechasDisponibles"><span class="fa fa-envelope" ></span> Mensajes Managers</button>                                         
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
                         <?php 
                         $CA=0;
                         $MA=0;
                         $OA=0;
                         $PZ=0;
                         $R1=0;
                         $R2=0;
                         $TZ=0;
                         ?>
                         <?php foreach ($mensajes as $mensaje):?> 
                            <?php switch($mensaje->plaza_id): 
                                
                                case 1: ?>
                                   <?php if($mensaje->Correcto==1):?> 
                                        <?php $CA=1;?>                                                                      
                                   <?php endif;?>                                      
                                <?php break; ?>
                                
                                <?php case 2: ?>
                                    <?php if($mensaje->Correcto==1):?> 
                                        <?php $MA=1;?>                                                                      
                                   <?php endif;?>                                  
                                <?php break; ?>
                                
                                <?php case 3: ?>
                                    <?php if($mensaje->Correcto==1):?> 
                                        <?php $OA=1;?>                                                                      
                                   <?php endif;?>   
                                <?php break; ?>

                                <?php case 4: ?>
                                   <?php if($mensaje->Correcto==1):?> 
                                        <?php $PZ=1;?>                                                                      
                                   <?php endif;?>                                   
                                <?php break; ?>

                                <?php case 5: ?>
                                    <?php if($mensaje->Correcto==1):?> 
                                        <?php $R1=1;?>                                                                      
                                   <?php endif;?>                                   
                                <?php break; ?>
                                
                                <?php case 6: ?>
                                    <?php if($mensaje->Correcto==1):?> 
                                        <?php $R2=1;?>                                                                      
                                   <?php endif;?>                                   
                                <?php break; ?>

                                <?php case 7: ?>
                                    <?php if($mensaje->Correcto==1):?> 
                                        <?php $TZ=1;?>                                                                      
                                   <?php endif;?>   
                                <?php break; ?>


                            <?php endswitch; ?>
                         <?php endforeach;?>                                                       
                         <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_inventario">
                            <thead>
                                <tr>                                    
                                    <th>Plaza</th>
                                    <th>Nombre</th>
                                    <th>Total</th>
                                    <th>Unidad</th>                                                                                                                                                     
                                </tr>
                            </thead>
                            <tbody>                                
                                <?php if(!empty($inventario_productos)):?>                                
                                <?php foreach ($inventario_productos as $inventario):?>                                  
                                <?php switch($inventario->plaza_id):                                 
                                case 1: ?>
                                   <?php if($CA==1):?> 
                                   <tr bgcolor="#9BFD6A">       
                                   <?php else:?>                    
                                        <tr>        
                                   <?php endif;?>                                      
                                <?php break; ?>
                                
                                <?php case 2: ?>
                                    <?php if($MA==1):?> 
                                    <tr bgcolor="#9BFD6A"> 
                                    <?php else:?>                    
                                        <tr>        
                                   <?php endif;?>                                  
                                <?php break; ?>
                                
                                <?php case 3: ?>
                                    <?php if($OA==1):?> 
                                    <tr bgcolor="#9BFD6A"> 
                                    <?php else:?>                    
                                        <tr>        
                                   <?php endif;?>   
                                <?php break; ?>

                                <?php case 4: ?>
                                   <?php if($PZ==1):?> 
                                   <tr bgcolor="#9BFD6A"> 
                                   <?php else:?>                    
                                        <tr>        
                                   <?php endif;?>                                   
                                <?php break; ?>

                                <?php case 5: ?>
                                    <?php if($R1==1):?> 
                                    <tr bgcolor="#9BFD6A"> 
                                    <?php else:?>                    
                                        <tr>         
                                   <?php endif;?>                                   
                                <?php break; ?>
                                
                                <?php case 6: ?>
                                    <?php if($R2==1):?> 
                                        <tr bgcolor="#9BFD6A"> 
                                    <?php else:?>                    
                                        <tr>        
                                   <?php endif;?>                                   
                                <?php break; ?>

                                <?php case 7: ?>
                                    <?php if($TZ==1):?> 
                                    <tr bgcolor="#9BFD6A"> 
                                    <?php else:?>                    
                                        <tr>        
                                   <?php endif;?>   
                                <?php break; ?>


                            <?php endswitch; ?>                                                                                                                                                                                                   
                                    <td><?=$inventario->Plaza;?></td>                                          
                                    <td><?=$inventario->Insumo;?></td>                                                                                                                                                                                                         
                                    <td><?=round($inventario->Total,2);?></td>                                                                                                                                                                              
                                    <td><?=$inventario->UnidadT;?></td>       
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

    <div class="modal fade" id="notificacionesFechasDisponibles" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Fechas Disponibles</h4>
		  </div>
		  <div class="modal-body">                
                <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_fechas_quebrantos">
                    <thead>
                        <tr>
                            
                            <th>Plaza</th>                             
                            <th>Mensaje</th>                                                                                                                                                                                                                                                                                                                                                   
                        </tr>
                    </thead>
                <tbody>
                <?php if(!empty($mensajes)):?>                               
                    <?php foreach ($mensajes as $mensaje):?>                         
                        <tr>                                   
                            
                            <td><?=$mensaje->Plaza;?></td>                                                        
                            <td style="text-align: left"><?php $mensaje2=preg_replace("/[\n]/","<br>",$mensaje->Notas);
                            echo $mensaje2;
                            ?>
                            </td>                                                                                                                                                                                                             
                        </tr>                                                                                                
                    <?php endforeach;?>                                                                                           
                <?php endif;?>                                                          
                </tbody>
                </table>                                                                                      
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>			
		  </div>		  
		</div>
	  </div>
	</div>





