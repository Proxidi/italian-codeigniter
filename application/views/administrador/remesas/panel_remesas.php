        <!-- =============================================== -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                Panel de Remesas
                <small>Remesas </small>
                </h1>
                <a href="<?php echo base_url();?>Inicio" class="small-box-footer">Volver al Panel de Inicio <i class="fa fa-arrow-circle-right"></i></a>
            </section>
            <!-- Main content -->
            <section class="content">
                <div class="row">
                        <!-- /.col -->
                        <div class="col-lg-4 col-xs-6 noselect">
                        <!-- Widget: user widget style 1 -->
                        <div class="box box-widget widget-user-2" onclick="window.location = '<?php echo base_url();?>Remesas/addRemesasAdministrador';">
                            <!-- Add the bg color to the header using any of the bg-* classes -->
                            <div class="widget-user-header bg-white-active">
                            <div class="widget-user-image">
                                <img class="img-circle" src="<?php echo base_url();?>assets/images/add.png" alt="Usuarios">
                            </div>
                            <!-- /.widget-user-image -->
                            <span class="hidden-xs">
                            <h3 class="widget-user-username">Remesas F.G.F</h3>
                            <h5 class="widget-user-desc">Remesas F.G.F</h5>
                            </span>
                            </div>
                            <div class="box-footer no-padding">
                            <ul class="nav nav-stacked">
                                <li><a href="<?php echo base_url();?>Remesas/addRemesasAdministrador"> F.G.F <span class="pull-right badge bg-blue">Click here</span></a></li>
                            </ul>
                            </div>
                        </div>
                        <!-- /.widget-user -->
                        </div>
                        <!-- /.col -->

                         <!-- /.col -->
                        <div class="col-lg-4 col-xs-6 noselect">
                        <!-- Widget: user widget style 1 -->
                        <div class="box box-widget widget-user-2" onclick="window.location = '<?php echo base_url();?>Remesas/analisisRemesas';">
                            <!-- Add the bg color to the header using any of the bg-* classes -->
                            <div class="widget-user-header bg-white-active">
                            <div class="widget-user-image">
                                <img class="img-circle" src="<?php echo base_url();?>assets/images/report2.png" alt="Permisos">
                            </div>
                            <!-- /.widget-user-image -->
                            <span class="hidden-xs">
                            <h3 class="widget-user-username"> Análisis Remesas</h3>
                            <h5 class="widget-user-desc">Análisis Remesas</h5>
                            </span>
                            </div>
                            <div class="box-footer no-padding">
                            <ul class="nav nav-stacked">
                                <li><a href="<?php echo base_url();?>Remesas/analisisRemesas"> Análisis<span class="pull-right badge bg-blue">Click here</span></a></li>
                            </ul>
                            </div>
                        </div>
                        <!-- /.widget-user -->
                        </div>
                        <!-- /.col -->                                     
                    
                    <div class="col-lg-4 col-xs-6 noselect">
                        <!-- Widget: user widget style 1 -->
                        <div class="box box-widget widget-user-2" onclick="window.location = '<?php echo base_url();?>Remesas/listRemesasGenerales';">
                            <!-- Add the bg color to the header using any of the bg-* classes -->
                            <div class="widget-user-header bg-white-active">
                            <div class="widget-user-image">
                                <img class="img-circle" src="<?php echo base_url();?>assets/images/see.png" alt="Usuarios">
                            </div>
                            <!-- /.widget-user-image -->
                            <span class="hidden-xs">
                            <h3 class="widget-user-username">Remesas Generales</h3>
                            <h5 class="widget-user-desc">Remesas Generales</h5>
                            </span>
                            </div>
                            <div class="box-footer no-padding">
                            <ul class="nav nav-stacked">
                                <li><a href="<?php echo base_url();?>Remesas/listRemesasGenerales"> Remesas Generales <span class="pull-right badge bg-blue">Click here</span></a></li>
                            </ul>
                            </div>
                        </div>
                        <!-- /.widget-user -->
                    </div>
                    <!-- /.col -->


                    <div class="col-lg-4 col-xs-6 noselect">
                        <!-- Widget: user widget style 1 -->
                        <div class="box box-widget widget-user-2" onclick="window.location = '<?php echo base_url();?>Remesas/stocks';">
                            <!-- Add the bg color to the header using any of the bg-* classes -->
                            <div class="widget-user-header bg-white-active">
                            <div class="widget-user-image">
                                <img class="img-circle" src="<?php echo base_url();?>assets/images/stock2.png" alt="Usuarios">
                            </div>
                            <!-- /.widget-user-image -->
                            <span class="hidden-xs">
                            <h3 class="widget-user-username">Stocks</h3>
                            <h5 class="widget-user-desc">Stocks</h5>
                            </span>
                            </div>
                            <div class="box-footer no-padding">
                            <ul class="nav nav-stacked">
                                <li><a href="<?php echo base_url();?>Remesas/stocks">Stocks Remesas<span class="pull-right badge bg-blue">Click here</span></a></li>
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
