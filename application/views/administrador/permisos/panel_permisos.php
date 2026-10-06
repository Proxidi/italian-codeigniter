        <!-- =============================================== -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                Panel de Permisos
                <small>Permisos </small>
                </h1>
                <a href="<?php echo base_url();?>Inicio" class="small-box-footer">Volver al Panel de Inicio <i class="fa fa-arrow-circle-right"></i></a>
            </section>
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <!-- /.col -->
                    <div class="col-lg-4 col-xs-6">
                        <!-- Widget: user widget style 1 -->
                        <div class="box box-widget widget-user-2" onclick="window.location = '<?php echo base_url();?>Productos/list';">
                            <!-- Add the bg color to the header using any of the bg-* classes -->
                            <div class="widget-user-header bg-yellow">
                            <div class="widget-user-image">
                                <img class="img-circle" src="<?php echo base_url();?>assets/images/secure.png" alt="Productos">
                            </div>
                            <!-- /.widget-user-image -->
                            <span class="hidden-xs">
                            <h3 class="widget-user-username">Agregar Menus</h3>
                            <h5 class="widget-user-desc">Agregar Menus</h5>
                            </span>
                            </div>
                            <div class="box-footer no-padding">
                            <ul class="nav nav-stacked">
                                <li><a href="<?php echo base_url();?>Permisos/add"> Agregar Menus <span class="pull-right badge bg-blue">Click here</span></a></li>
                            </ul>
                            </div>
                        </div>
                        <!-- /.widget-user -->
                        </div>
                        <!-- /.col -->  


 
                          <!-- /.col -->
                          <div class="col-lg-4 col-xs-6">
                        <!-- Widget: user widget style 1 -->
                        <div class="box box-widget widget-user-2" onclick="window.location = '<?php echo base_url();?>Insumos';">
                            <!-- Add the bg color to the header using any of the bg-* classes -->
                            <div class="widget-user-header bg-green">
                            <div class="widget-user-image">
                                <img class="img-circle" src="<?php echo base_url();?>assets/images/secure.png" alt="Insumos">
                            </div>
                            <!-- /.widget-user-image -->
                            <span class="hidden-xs">
                            <h3 class="widget-user-username">Editar Permisos</h3>
                            <h5 class="widget-user-desc">Editar Permisos</h5>
                            <span>
                            </div>
                            <div class="box-footer no-padding">
                            <ul class="nav nav-stacked">
                                <li><a href="<?php echo base_url();?>Permisos/edit"> Editar Permisos <span class="pull-right badge bg-blue">Click here</span></a></li>
                            </ul>
                            </div>
                        </div>
                        <!-- /.widget-user -->
                        </div>
                        <!-- /.col -->  

                </div>
                <!-- /.row -->

                
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
