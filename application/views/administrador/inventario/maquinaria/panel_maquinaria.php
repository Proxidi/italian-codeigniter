<!-- =============================================== -->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                Panel de Nominas
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
                    <div class="box box-widget widget-user-2" onclick="window.location = '<?php echo base_url();?>Inventario/vistaPlazas';">
                        <!-- Add the bg color to the header using any of the bg-* classes -->
                        <div class="widget-user-header bg-white-active">
                        <div class="widget-user-image">
                            <img class="img-circle" src="<?php echo base_url();?>assets/images/mapa.png" alt="Usuarios">
                        </div>
                        <!-- /.widget-user-image -->
                        <span class="hidden-xs">
                        <h3 class="widget-user-username">Vista Plazas</h3>
                        <h5 class="widget-user-desc">Vista Plazas</h5>
                        </span>
                        </div>
                        <div class="box-footer no-padding">
                        <ul class="nav nav-stacked">
                            <li><a href="<?php echo base_url();?>Inventario/vistaPlazas">Plazas<span class="pull-right badge bg-blue">Click here</span></a></li>
                        </ul>
                        </div>
                    </div>
                    <!-- /.widget-user -->
                    </div>
                    <!-- /.col -->

                    <div class="col-lg-4 col-xs-6 noselect">
                    <!-- Widget: user widget style 1 -->
                    <div class="box box-widget widget-user-2" onclick="window.location = '<?php echo base_url();?>Inventario/vistaMaquinaria';">
                        <!-- Add the bg color to the header using any of the bg-* classes -->
                        <div class="widget-user-header bg-white-active">
                        <div class="widget-user-image">
                            <img class="img-circle" src="<?php echo base_url();?>assets/images/coffee_machine.png" alt="Usuarios">
                        </div>
                        <!-- /.widget-user-image -->
                        <span class="hidden-xs">
                        <h3 class="widget-user-username">Vista Máquinas</h3>
                        <h5 class="widget-user-desc">Vista Máquinas</h5>
                        </span>
                        </div>
                        <div class="box-footer no-padding">
                        <ul class="nav nav-stacked">
                        <li><a href="<?php echo base_url();?>Inventario/vistaMaquinaria">Máquinas<span class="pull-right badge bg-blue">Click here</span></a></li>
                        </ul>
                        </div>
                    </div>
                    <!-- /.widget-user -->
                    </div>
                    <!-- /.col -->     

                    
                    <div class="col-lg-4 col-xs-6 noselect">
                    <!-- Widget: user widget style 1 -->
                    <div class="box box-widget widget-user-2" onclick="window.location = '<?php echo base_url();?>Inventario/administrarMaquinaria';">
                        <!-- Add the bg color to the header using any of the bg-* classes -->
                        <div class="widget-user-header bg-white-active">
                        <div class="widget-user-image">
                            <img class="img-circle" src="<?php echo base_url();?>assets/images/tool.png" alt="Usuarios">
                        </div>
                        <!-- /.widget-user-image -->
                        <span class="hidden-xs">
                        <h3 class="widget-user-username">Administrar</h3>
                        <h5 class="widget-user-desc">Administrar</h5>
                        </span>
                        </div>
                        <div class="box-footer no-padding">
                        <ul class="nav nav-stacked">
                        <li><a href="<?php echo base_url();?>Inventario/administrarMaquinaria">Administrar<span class="pull-right badge bg-blue">Click here</span></a></li>
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



