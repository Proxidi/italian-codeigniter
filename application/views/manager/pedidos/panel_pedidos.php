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

                    <!-- /.col -->
                         <div class="col-lg-4 col-xs-6 noselect">
                        <!-- Widget: user widget style 1 -->
                        <div class="box box-widget widget-user-2" onclick="window.location = '<?php echo base_url();?>Pedidos/recepcionPedido';">
                            <!-- Add the bg color to the header using any of the bg-* classes -->
                            <div class="widget-user-header bg-white-active">
                            <div class="widget-user-image">
                                <img class="img-circle" src="<?php echo base_url();?>assets/images/italiancoffee.png" alt="Usuarios">
                            </div>
                            <!-- /.widget-user-image -->
                            <span class="hidden-xs">
                            <h3 class="widget-user-username">Pedidos Franquicia</h3>
                            <h5 class="widget-user-desc">Pedidos Franquicia</h5>
                            </span>
                            </div>
                            <div class="box-footer no-padding">
                            <ul class="nav nav-stacked">
                                <li><a href="<?php echo base_url();?>Pedidos/recepcionPedido">P. Franquicia<span class="pull-right badge bg-blue">Click here</span></a></li>
                            </ul>
                            </div>
                        </div>
                        <!-- /.widget-user -->
                        </div>
                        <!-- /.col -->

                         <!-- /.col -->
                         <div class="col-lg-4 col-xs-6 noselect">
                        <!-- Widget: user widget style 1 -->
                        <div class="box box-widget widget-user-2" onclick="window.location = '<?php echo base_url();?>Pedidos/listManagerPasteleria';">
                            <!-- Add the bg color to the header using any of the bg-* classes -->
                            <div class="widget-user-header bg-white-active">
                            <div class="widget-user-image">
                                <img class="img-circle" src="<?php echo base_url();?>assets/images/cake.png" alt="Usuarios">
                            </div>
                            <!-- /.widget-user-image -->
                            <span class="hidden-xs">
                            <h3 class="widget-user-username">Pedidos Pasteleria</h3>
                            <h5 class="widget-user-desc">Pedidos Pasteleria</h5>
                            </span>
                            </div>
                            <div class="box-footer no-padding">
                            <ul class="nav nav-stacked">
                                <li><a href="<?php echo base_url();?>Pedidos/listManagerPasteleria">P. Pasteleria<span class="pull-right badge bg-blue">Click here</span></a></li>
                            </ul>
                            </div>
                        </div>
                        <!-- /.widget-user -->
                        </div>
                        <!-- /.col -->

                        <!-- /.col -->
                        <div class="col-lg-4 col-xs-6 noselect">
                        <!-- Widget: user widget style 1 -->
                        <div class="box box-widget widget-user-2" onclick="window.location = '<?php echo base_url();?>Pedidos/historialManager';">
                            <!-- Add the bg color to the header using any of the bg-* classes -->
                            <div class="widget-user-header bg-white-active">
                            <div class="widget-user-image">
                                <img class="img-circle" src="<?php echo base_url();?>assets/images/report5.png" alt="Usuarios">
                            </div>
                            <!-- /.widget-user-image -->
                            <span class="hidden-xs">
                            <h3 class="widget-user-username">H. Facturas</h3>
                            <h5 class="widget-user-desc">H. Facturas</h5>
                            </span>
                            </div>
                            <div class="box-footer no-padding">
                            <ul class="nav nav-stacked">
                                <li><a href="<?php echo base_url();?>Pedidos/historialManager"> H. Facturas<span class="pull-right badge bg-blue">Click here</span></a></li>
                            </ul>
                            </div>
                        </div>
                        <!-- /.widget-user -->
                        </div>
                        <!-- /.col -->


                        <!-- /.col -->
                        <div class="col-lg-4 col-xs-6 noselect">
                        <!-- Widget: user widget style 1 -->
                        <div class="box box-widget widget-user-2" onclick="window.location = '<?php echo base_url();?>Pedidos/faltantesPedidoManager';">
                            <!-- Add the bg color to the header using any of the bg-* classes -->
                            <div class="widget-user-header bg-white-active">
                            <div class="widget-user-image">
                                <img class="img-circle" src="<?php echo base_url();?>assets/images/not_found.png" alt="Usuarios">
                            </div>
                            <!-- /.widget-user-image -->
                            <span class="hidden-xs">
                            <h3 class="widget-user-username">Faltantes Pedido</h3>
                            <h5 class="widget-user-desc">Faltantes Pedido</h5>
                            </span>
                            </div>
                            <div class="box-footer no-padding">
                            <ul class="nav nav-stacked">
                                <li><a href="<?php echo base_url();?>Pedidos/faltantesPedidoManager">Faltantes Pedido<span class="pull-right badge bg-blue">Click here</span></a></li>
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
