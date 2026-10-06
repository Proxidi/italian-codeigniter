        <!-- =============================================== -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">                
                <h1>
                Panel de Reportes de Ventas
                <small>Ventas </small>
                </h1>
                <a href="<?php echo base_url();?>Inicio" class="small-box-footer">Volver al Panel de Inicio<i class="fa fa-arrow-circle-right"></i></a>
            </section>
            <!-- Main content -->
            <section class="content">
                <div class="row">


                   <div class="col-lg-4 col-xs-6">
                            <!-- Widget: user widget style 1 -->
                            <?php if($this->session->userdata("plaza")==7):?>                                                                
                            <div class="box box-widget widget-user-2" onclick="window.location = '<?php echo base_url();?>Ventas/list2';">
                            <?php else:?>
                            <div class="box box-widget widget-user-2" onclick="window.location = '<?php echo base_url();?>Ventas/list';">
                            <?php endif;?>

                                <!-- Add the bg color to the header using any of the bg-* classes -->
                                <div class="widget-user-header bg-green">
                                <div class="widget-user-image">
                                    <img class="img-circle" src="<?php echo base_url();?>assets/images/report6.png" alt="User Avatar">
                                </div>
                                <!-- /.widget-user-image -->
                                <span class="hidden-xs">
                                <h3 class="widget-user-username">Consultar Ventas</h3>
                                <h5 class="widget-user-desc">Consultar Ventas</h5>
                                <span>
                                </div>
                                <div class="box-footer no-padding">
                                <ul class="nav nav-stacked">
                                    <li>
                                    <?php if($this->session->userdata("plaza")==7):?>   
                                    <a href="<?php echo base_url();?>Ventas/list2">Consultar <span class="pull-right badge bg-blue">Click Here</span></a>
                                    <?php else:?>
                                    <a href="<?php echo base_url();?>Ventas/list">Consultar <span class="pull-right badge bg-blue">Click Here</span></a>
                                     <?php endif;?>
                                    </li>
                                </ul>
                                </div>
                            </div>
                            <!-- /.widget-user -->
                            </div>
                            <!-- /.col -->

             <div class="col-lg-4 col-xs-6">
                            <!-- Widget: user widget style 1 -->
																<div class="box box-widget widget-user-2" onclick="window.location = '<?php echo base_url();?>Ventas/add2';">
                                <!-- Add the bg color to the header using any of the bg-* classes -->
                                <div class="widget-user-header bg-aqua">
                                <div class="widget-user-image">
                                    <img class="img-circle" src="<?php echo base_url();?>assets/images/report2.png" alt="User Avatar">
                                </div>
                                <!-- /.widget-user-image -->
                                <span class="hidden-xs">
                                <h3 class="widget-user-username">Agregar Ventas</h3>
                                <h5 class="widget-user-desc">Agregar Ventas</h5>
                                <span>
                                </div>
                                <div class="box-footer no-padding">
                                <ul class="nav nav-stacked">
																	<li>
																		<a href="<?php echo base_url();?>Ventas/add2">Agregar <span class="pull-right badge bg-blue">Click Here</span></a>
																	</li>
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
