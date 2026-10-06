        <!-- =============================================== -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                Panel de Administración
                <small>Panel de  Control </small>
                </h1>
                <a href="<?php echo base_url();?>Inicio" class="small-box-footer">Volver al Panel de Inicio <i class="fa fa-arrow-circle-right"></i></a>
            </section>
            <!-- Main content -->
            <section class="content">
                <div class="row">



                   <!--VISTA DOS (DUEÑO)--> 
                    <?php if($this->session->userdata("rol_id")==1):?>

                          <!-- /.col -->
                          <div class="col-lg-4 col-xs-6 noselect">
                        <!-- Widget: user widget style 1 -->
                        <div class="box box-widget widget-user-2" onclick="window.location = '<?php echo base_url();?>Inventario/listAdmin';">
                            <!-- Add the bg color to the header using any of the bg-* classes -->
                            <div class="widget-user-header bg-white-active">
                            <div class="widget-user-image">
                                <img class="img-circle" src="<?php echo base_url();?>assets/images/inventory.png" alt="Usuarios">
                            </div>
                            <!-- /.widget-user-image -->
                            <span class="hidden-xs">
                            <h3 class="widget-user-username">Inv. Producción</h3>
                            <h5 class="widget-user-desc">Inv. Producción</h5>
                            </span>
                            </div>
                            <div class="box-footer no-padding">
                            <ul class="nav nav-stacked">
                                <li><a href="<?php echo base_url();?>Inventario/listAdmin">Inv. Producción<span class="pull-right badge bg-blue">Click here</span></a></li>
                            </ul>
                            </div>
                        </div>
                        <!-- /.widget-user -->
                        </div>
                        <!-- /.col -->

                           
                        <div class="col-lg-4 col-xs-6 noselect">                        
                            <div class="box box-widget widget-user-2" onclick="window.location = '<?php echo base_url();?>Inventario/listAdminF';">                            
                                <div class="widget-user-header bg-white-active">
                                <div class="widget-user-image">
                                    <img class="img-circle" src="<?php echo base_url();?>assets/images/inventory.png" alt="Usuarios">
                                </div>                            
                                <span class="hidden-xs">
                                <h3 class="widget-user-username">Inventarios F.G.F</h3>
                                <h5 class="widget-user-desc">Inventarios F.G.F</h5>
                                </span>
                                </div>
                                <div class="box-footer no-padding">
                                <ul class="nav nav-stacked">
                                    <li><a href="<?php echo base_url();?>Inventario/listAdminF">Inv. F.G.F<span class="pull-right badge bg-blue">Click here</span></a></li>
                                </ul>
                                </div>
                            </div>                        
                        </div>

                        <div class="col-lg-4 col-xs-6 noselect">                        
                            <div class="box box-widget widget-user-2" onclick="window.location = '<?php echo base_url();?>Inventario/historialIF';">                            
                                <div class="widget-user-header bg-white-active">
                                <div class="widget-user-image">
                                    <img class="img-circle" src="<?php echo base_url();?>assets/images/inventory.png" alt="Usuarios">
                                </div>                            
                                <span class="hidden-xs">
                                <h3 class="widget-user-username">Historial I.F</h3>
                                <h5 class="widget-user-desc">Historial I.F</h5>
                                </span>
                                </div>
                                <div class="box-footer no-padding">
                                <ul class="nav nav-stacked">
                                    <li><a href="<?php echo base_url();?>Inventario/historialIF">Historial<span class="pull-right badge bg-blue">Click here</span></a></li>
                                </ul>
                                </div>
                            </div>                        
                        </div>

                        <!-- /.col -->
                    
                    <?php elseif($this->session->userdata("rol_id")==3):?>
                       
                        <!-- /.col -->
                        <div class="col-lg-4 col-xs-6 noselect">
                        <!-- Widget: user widget style 1 -->
                        <div class="box box-widget widget-user-2" onclick="window.location = '<?php echo base_url();?>Inventario/listAdmin';">
                            <!-- Add the bg color to the header using any of the bg-* classes -->
                            <div class="widget-user-header bg-white-active">
                            <div class="widget-user-image">
                                <img class="img-circle" src="<?php echo base_url();?>assets/images/inventory.png" alt="Usuarios">
                            </div>
                            <!-- /.widget-user-image -->
                            <span class="hidden-xs">
                            <h3 class="widget-user-username">Inv. Producción</h3>
                            <h5 class="widget-user-desc">Inv. Producción</h5>
                            </span>
                            </div>
                            <div class="box-footer no-padding">
                            <ul class="nav nav-stacked">
                                <li><a href="<?php echo base_url();?>Inventario/listAdmin">Inv. Producción<span class="pull-right badge bg-blue">Click here</span></a></li>
                            </ul>
                            </div>
                        </div>
                        <!-- /.widget-user -->
                        </div>
                        <!-- /.col -->


                           <!-- /.col -->
                           <div class="col-lg-4 col-xs-6 noselect">
                        <!-- Widget: user widget style 1 -->
                        <div class="box box-widget widget-user-2" onclick="window.location = '<?php echo base_url();?>Inventario/listAdminF';">
                            <!-- Add the bg color to the header using any of the bg-* classes -->
                            <div class="widget-user-header bg-white-active">
                            <div class="widget-user-image">
                                <img class="img-circle" src="<?php echo base_url();?>assets/images/inventory.png" alt="Usuarios">
                            </div>
                            <!-- /.widget-user-image -->
                            <span class="hidden-xs">
                            <h3 class="widget-user-username">Inventarios F.G.F</h3>
                            <h5 class="widget-user-desc">Inventarios F.G.F</h5>
                            </span>
                            </div>
                            <div class="box-footer no-padding">
                            <ul class="nav nav-stacked">
                                <li><a href="<?php echo base_url();?>Inventario/listAdminF">Inv. F.G.F<span class="pull-right badge bg-blue">Click here</span></a></li>
                            </ul>
                            </div>
                        </div>
                        <!-- /.widget-user -->
                        </div>
                        <!-- /.col -->

                         <!-- /.col -->
                         <div class="col-lg-4 col-xs-6 noselect">
                        <!-- Widget: user widget style 1 -->
                        <div class="box box-widget widget-user-2" onclick="window.location = '<?php echo base_url();?>Inventario/panelConfiguraciones';">
                            <!-- Add the bg color to the header using any of the bg-* classes -->
                            <div class="widget-user-header bg-white-active">
                            <div class="widget-user-image">
                                <img class="img-circle" src="<?php echo base_url();?>assets/images/stock2.png" alt="Usuarios">
                            </div>
                            <!-- /.widget-user-image -->
                            <span class="hidden-xs">
                            <h3 class="widget-user-username">Configuraciones</h3>
                            <h5 class="widget-user-desc">Configuraciones</h5>
                            </span>
                            </div>
                            <div class="box-footer no-padding">
                            <ul class="nav nav-stacked">
                                <li><a href="<?php echo base_url();?>Inventario/panelConfiguraciones">Configuraciones<span class="pull-right badge bg-blue">Click here</span></a></li>
                            </ul>
                            </div>
                        </div>
                        <!-- /.widget-user -->
                        </div>
                        <!-- /.col -->

                           
                        <!-- /.col -->
                        <div class="col-lg-4 col-xs-6 noselect">
                        <!-- Widget: user widget style 1 -->
                        <div class="box box-widget widget-user-2" onclick="window.location = '<?php echo base_url();?>Inventario/seguimientoInventario';">
                            <!-- Add the bg color to the header using any of the bg-* classes -->
                            <div class="widget-user-header bg-white-active">
                            <div class="widget-user-image">
                                <img class="img-circle" src="<?php echo base_url();?>assets/images/managment.png" alt="Usuarios">
                            </div>
                            <!-- /.widget-user-image -->
                            <span class="hidden-xs">
                            <h3 class="widget-user-username">Seguimiento Inv.</h3>
                            <h5 class="widget-user-desc">Seguimiento Inv.</h5>
                            </span>
                            </div>
                            <div class="box-footer no-padding">
                            <ul class="nav nav-stacked">
                                <li><a href="<?php echo base_url();?>Inventario/seguimientoInventario">Seguimiento<span class="pull-right badge bg-blue">Click here</span></a></li>
                            </ul>
                            </div>
                        </div>
                        <!-- /.widget-user -->
                        </div>
                        <!-- /.col -->  

                          <!-- /.col -->
                          <div class="col-lg-4 col-xs-6 noselect">
                        <!-- Widget: user widget style 1 -->
                        <div class="box box-widget widget-user-2" onclick="window.location ='<?php echo base_url();?>Inventario/panelMaquinaria';">
                            <!-- Add the bg color to the header using any of the bg-* classes -->
                            <div class="widget-user-header bg-white-active">
                            <div class="widget-user-image">
                                <img class="img-circle" src="<?php echo base_url();?>assets/images/machine.png" alt="Usuarios">
                            </div>
                            <!-- /.widget-user-image -->
                            <span class="hidden-xs">
                            <h3 class="widget-user-username">Inv. Máquinas</h3>
                            <h5 class="widget-user-desc">Inv. Máquinas</h5>
                            </span>
                            </div>
                            <div class="box-footer no-padding">
                            <ul class="nav nav-stacked">
                                <li><a href="<?php echo base_url();?>Inventario/panelMaquinaria">I.Máquinas<span class="pull-right badge bg-blue">Click here</span></a></li>
                            </ul>
                            </div>
                        </div>
                        <!-- /.widget-user -->
                        </div>
                        <!-- /.col -->  


                        <!-- /.col -->
                        <div class="col-lg-4 col-xs-6 noselect">
                        <!-- Widget: user widget style 1 -->
                        <div class="box box-widget widget-user-2" onclick="window.location = '#';">
                            <!-- Add the bg color to the header using any of the bg-* classes -->
                            <div class="widget-user-header bg-white-active">
                            <div class="widget-user-image">
                                <img class="img-circle" src="<?php echo base_url();?>assets/images/analysis.png" alt="Usuarios">
                            </div>
                            <!-- /.widget-user-image -->
                            <span class="hidden-xs">
                            <h3 class="widget-user-username">Análisis Inventario</h3>
                            <h5 class="widget-user-desc">Análisis Inventario</h5>
                            </span>
                            </div>
                            <div class="box-footer no-padding">
                            <ul class="nav nav-stacked">
                                <li><a href="#">Análisis<span class="pull-right badge bg-blue">Click here</span></a></li>
                            </ul>
                            </div>
                        </div>
                        <!-- /.widget-user -->
                        </div>
                        <!-- /.col -->  
                
                

                    <?php endif;?>                                                                                 
                </div>
                <!-- /.row -->                
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
