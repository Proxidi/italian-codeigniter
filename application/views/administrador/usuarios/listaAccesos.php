
        <!-- =============================================== -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                Listado de Acessos
                <small>Listado</small>
                </h1>
                <a href="<?php echo base_url(); ?>Inicio" class="small-box-footer">Volver al Panel de Inicio <i class="fa fa-arrow-circle-right"></i></a>
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
                                    <div class="col-md-6">
                                            <input type="submit" name="buscar" value="Buscar" class="btn btn-success">                                            
                                            <a href="<?php echo base_url(); ?>Usuarios/listaAccesos" class="btn btn-warning">Restablecer</a>
                                        </div>
                                </div>                                
                            </form>
                        </div>
                    </div>
                         <div class="row">
                            <div class="col-md-12">
                            <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_notificaciones">
                            <thead>
                                <tr>                                    
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Plaza</th>        
                                    <th>Usuario</th>      
                                    <th>Rol</th>                                     
                                                                                                                 
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($accesos)):?>
                                <?php foreach ($accesos as $acceso):?>
                                   <tr>                                    
                                    <td><?=$acceso->Fecha;?></td>
                                    <td><?=$acceso->Hora;?></td>                                                                    
                                    <td><?=$acceso->Plaza;?></td>
                                    <td><?=$acceso->Usuario;?></td>                                                                            
                                    <td><?=$acceso->Rol;?></td>                                                                        
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

