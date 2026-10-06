<!-- =============================================== -->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Vista del Inventario de Maquinaria por Plazas
            <small>Listado</small>
            </h1>
                <a href="<?php echo base_url();?>Inventario/panelMaquinaria" class="small-box-footer">Volver al Panel de Máquinaria<i class="fa fa-arrow-circle-right"></i></a>
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
                                
                                <!--INPUTS DATE PARA LAS BUSQUEDAS-->
                                    <label for="" class="col-md-1 control-label">Desde:</label>
                                        <div class="col-md-2">
                                            <input type="date" class="form-control" name="fechaInicioD" id="fechaInicioD" value="<?php echo !empty($fechainicio) ? $fechainicio:'';?>" required>
                                        </div>

                                    <label for="" class="col-md-1 control-label">Hasta:</label>
                                        <div class="col-md-2">
                                            <input type="date" class="form-control" name="fechaFinD" id="fechaFinD" value="<?php  echo !empty($fechafin) ? $fechafin:'';?>">
                                        </div>
                                <!--INPUTS DATE PARA LAS BUSQUEDAS-->

                                <!--SELECTS PLAZAS,FAMILIAS-->
                                    <label for="plaza_id" class="col-md-1 control-label">Plaza:</label>
                                        <div class="col-md-2">
                                            <select name="plaza_id" id="plaza_id" class="form-control">                                                  
                                            <?php foreach ($plazas as $plaza):?>  
                                            <?php if($plaza->id==1):?>
                                            <option value="" selected>
                                                Todas las Plazas
                                            </option>
                                            <?php endif;?>
                                            <?php if($plaza->id==$id_plaza):?>
                                            <option value="<?php echo $plaza->id?>" selected>
                                            <?php echo $plaza->Nombre;?>
                                            </option>
                                            <?php else:?>
                                            <option value="<?php echo $plaza->id?>">
                                            <?php echo $plaza->Nombre;?>
                                            </option>
                                            <?php endif;?>
                                            <?php endforeach;?>
                                            </select>                                    
                                            <input type="hidden" name="hidden_country" id="hidden_country" />
                                        </div>             

                                    <label for="grupo_remesa_id" class="col-md-1 control-label">Familias:  </label>                           
                                        <div class="col-md-2">
                                            <select name="grupo_remesa_id" id="grupo_remesa_id" class="form-control">                                                                                              
                                            </select>  
                                        </div>
                                <!--SELECTS PLAZAS,FAMILIAS-->         

                                </div>        

                                <div class="form-group">

                                <!--SELECTS INSUMOS,GRAFICOS-->                                                                                                         
                                    <label for="grupo_id" class="col-md-1 control-label">Insumos:  </label>                           
                                        <div class="col-md-2">
                                        <select name="insumo_gasto_remesa_id" id="insumo_gasto_remesa_id" class="form-control" >
                                            <option value="">Seleccionar Insumo</option>  
                                            <?php if(isset($insumos)):?> 
                                                <?php foreach ($insumos as $insumo):?>  
                                                    <?php if($insumo->id==$id_insumo):?>                                                    
                                                        <option value="<?php echo $insumo->id?>" selected>
                                                            <?php echo $insumo->Nombre;?>
                                                        </option>                                                    
                                                        <?php else:?>
                                                            <option value="<?php echo $insumo->id?>">
                                                        <?php echo $insumo->Nombre;?>
                                                        </option>
                                                    <?php endif;?>
                                                <?php endforeach;?>
                                            <?php endif;?>  
                                        </select> 
                                        </div>

                                    
                                <!--SELECTS INSUMOS,GRAFICOS-->          

                                <!--BOTONES DE BUSQUEDA-->
                                    <div class="col-md-6">                                        
                                        <input type="submit" name="buscar" value="Buscar" class="btn btn-primary">
                                        <input type="submit" name="buscarRango" value="B. Rango" class="btn btn-success">                                        
                                    </div>
                                <!--BOTONES DE BUSQUEDA-->

                                </div>
                            </form>                                               
                            </div>
                    </div>
                         <div class="row">
                            <div class="col-md-12">                                                                   
                            <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_inventario">
                            <thead>
                                <tr>                                   
                                    <th>Plaza</th>
                                    <th>Máquina</th>                                                                                                            
                                    <th>#Serie</th>     
                                    <th>Estatus</th>                                
                                    <th>Observaciones</th>                                                                                                                                                                                     
                                </tr>
                            </thead>
                            <tbody>                                
                                <?php if(!empty($inventario_productos)):?>                                
                                <?php foreach ($inventario_productos as $inventario):?>                            
                                   <tr>                                                                                 
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
                                    <td bgcolor="#e7bbec"><?=$inventario->Plaza;?></td>
                                    <?php break; ?>                                    
                                    <?php endswitch; ?>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>                                                                   
                                </tr>                                   
                                <?php endforeach;?>                                                              
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


<!--MODAL VER LOS GASTOS-DESGLOSES POR FAMILIA-->
    <div class="modal fade" id="modal-default">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Desglose de gastos por familia</h4>
        </div>
        <div class="modal-body">
            <div class="responsive-table">
                <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_consulta_gastos_familia" >
                                <thead>
                                    <tr>                                                                                                                                                         
                                        <th>Plaza</th>                                                                                 
                                        <th>Gasto</th>  
                                        <th>Cantidad</th>  
                                        <th>Unidad</th>
                                        <th>Importe</th>
                                        <th>P. Unitario</th>   
                                        <th>Ver</th>                                                                                                            
                                    </tr>
                                </thead>
                                <tbody>                            
                                </tbody>                            
                </table> 
            </div>
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
<!--MODAL VER LOS GASTOS-DESGLOSES POR FAMILIA-->





















