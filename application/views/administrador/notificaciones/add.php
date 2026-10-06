
        <!-- =============================================== -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                Sistema de Notificaciones
                <small>Notificaciones</small>
                </h1>
                <a href="<?php echo base_url(); ?>Opciones" class="small-box-footer">Volver al Panel de Configuración<i class="fa fa-arrow-circle-right"></i></a>
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
                                <input type="date" class="form-control" name="fecha" id="fecha" value="" required>
                            </div>
                        
                            <label for="" class="col-md-3 control-label">Actualizar Fecha:</label>                           
                            <div class="col-md-3">
                                <input type="submit" name="actualizar" value="Actualizar" class="btn btn-success">                                
                            </div>                            
                        </div>
                        </form> 

                        </div>
                        </div>
                         
                         <div class="row">
                            <div class="col-md-12">
                            <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_datos">
                            <thead>
                                <tr>       
                                    <th>#</th>                                            
                                    <th>Fecha Inicio</th>
                                    <th>Descripción</th>                                                                
                                </tr>
                            </thead>
                            <tbody>

                            <?php if(!empty($notificaciones)):?>                                
                            <?php foreach ($notificaciones as $notificacion):?>                            
                                <tr>                                    
                                    <td><?=$notificacion->id;?></td>                                                                                                                     
                                    <td><?=$notificacion->Fecha;?></td>                                                                                                                                                                            
                                    <td><?=$notificacion->Descripcion;?></td>                                                                                                                                                                            
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

