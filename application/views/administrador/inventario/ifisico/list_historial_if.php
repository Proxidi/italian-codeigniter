    <!-- =============================================== -->
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                Historial de Inventarios Físicos
                <small>Historial</small>
                </h1>
                <a href="<?php echo base_url(); ?>Inventario" class="small-box-footer">Volver al Panel de Inventario <i class="fa fa-arrow-circle-right"></i></a>
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

                                        <label for="" class="col-md-1 control-label">Fecha:</label>
                                            <div class="col-md-3">
                                                <input type="date" class="form-control" name="fecha" id="fecha" value="<?php echo !empty($fecha) ? $fecha:'';?>" required>
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
                                            </div>                                                 
                                        <div class="col-md-4">
                                            <input type="submit" name="buscar" value="Buscar" class="btn btn-primary">                                                                                                                                       
                                        </div>              
                                    </div>
                                </form>   
                            </div>                            
                         </div>  
                                                
                         <div class="row">
                            <div class="col-md-12">
                            <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_gastos_admin">
                            <thead>
                                <tr>                                                                        
                                    <th>Fecha</th>                                                                                                                              
                                    <th>Nombre</th> 
                                    <th>Bodega</th>
                                    <th>Piso</th>
                                    <th>Total</th> 
                                    <th>Unidad</th>                                                                         
                                </tr>
                            </thead>
                            <tbody>
                            <?php if(!empty($miCaptura)):?>
                                <?php foreach ($miCaptura as $captura):?>
                                   <tr>
                                    <td><?=$captura->Fecha;?></td>
                                    <td><?=$captura->Insumo;?></td>
                                    <td><?=$captura->Bodega;?></td>       
                                    <td><?=$captura->Piso;?></td>
                                    <td><?=$captura->Total;?></td>                                                                                                                                                                         
                                    <td><?=$captura->UnidadT;?></td>                                                                                                                                                                         
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

     