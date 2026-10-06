<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
            Panel de Administración <!--VISTA GERENTE VIC-->
            <small>Panel de  Control </small>               
            </h1>
            <a href="<?php echo base_url();?>Inicio" class="small-box-footer">Volver al Panel de Inicio <i class="fa fa-arrow-circle-right"></i></a>
            
            <ol class="breadcrumb">
                <li style="font-size: 22px;"><a href="<?php echo base_url();?>Pedidos/faltantesPedido"><i class="fa fa-coffee"></i>Insumos Faltantes Pedidos: <span id="lblInsumosFaltantes"></span></a></li>                    
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">                                                 
                        <!-- /.col -->
                        <div class="col-lg-4 col-xs-6 noselect">
                    <!-- Widget: user widget style 1 -->
                    <div class="box box-widget widget-user-2" onclick="window.location = '<?php echo base_url();?>Depositos/panel';">
                        <!-- Add the bg color to the header using any of the bg-* classes -->
                        <div class="widget-user-header bg-white-active">
                        <div class="widget-user-image">
                            <img class="img-circle" src="<?php echo base_url();?>assets/images/cash.png" alt="Usuarios">
                        </div>
                        <!-- /.widget-user-image -->
                        <span class="hidden-xs">
                        <h3 class="widget-user-username">Ventas</h3>
                        <h5 class="widget-user-desc"> Ventas</h5>
                        </span>
                        </div>
                        <div class="box-footer no-padding">
                        <ul class="nav nav-stacked">
                            <li><a href="<?php echo base_url();?>Depositos/panel"> Ventas <span class="pull-right badge bg-blue">Click here</span></a></li>
                        </ul>
                        </div>
                    </div>
                    <!-- /.widget-user -->
                    </div>
                    <!-- /.col -->

                        <!-- /.col -->
                        <div class="col-lg-4 col-xs-6 noselect">
                    <!-- Widget: user widget style 1 -->
                    <div class="box box-widget widget-user-2" onclick="window.location = '<?php echo base_url();?>Remesas';">
                        <!-- Add the bg color to the header using any of the bg-* classes -->
                        <div class="widget-user-header bg-white-active">
                        <div class="widget-user-image">
                            <img class="img-circle" src="<?php echo base_url();?>assets/images/shopping.jpg" alt="Usuarios">
                        </div>
                        <!-- /.widget-user-image -->
                        <span class="hidden-xs">
                        <h3 class="widget-user-username">Remesas</h3>
                        <h5 class="widget-user-desc"> Remesas</h5>
                        </span>
                        </div>
                        <div class="box-footer no-padding">
                        <ul class="nav nav-stacked">
                            <li><a href="<?php echo base_url();?>Remesas"> Remesas <span class="pull-right badge bg-blue">Click here</span></a></li>
                        </ul>
                        </div>
                    </div>
                    <!-- /.widget-user -->
                    </div>
                    <!-- /.col -->

                        <!-- /.col -->
                        <div class="col-lg-4 col-xs-6 noselect">
                    <!-- Widget: user widget style 1 -->
                    <div class="box box-widget widget-user-2" onclick="window.location = '<?php echo base_url();?>Unidades';">
                        <!-- Add the bg color to the header using any of the bg-* classes -->
                        <div class="widget-user-header bg-white-active">
                        <div class="widget-user-image">
                            <img class="img-circle" src="<?php echo base_url();?>assets/images/tea.png" alt="Usuarios">
                        </div>
                        <!-- /.widget-user-image -->
                        <span class="hidden-xs">
                        <h3 class="widget-user-username"> Unidades</h3>
                        <h5 class="widget-user-desc">  Unidades</h5>
                        </span>
                        </div>
                        <div class="box-footer no-padding">
                        <ul class="nav nav-stacked">
                            <li><a href="<?php echo base_url();?>Unidades"> Unidades <span class="pull-right badge bg-blue">Click here</span></a></li>
                        </ul>
                        </div>
                    </div>
                    <!-- /.widget-user -->
                    </div>
                    <!-- /.col -->

                        <!-- /.col -->
                        <div class="col-lg-4 col-xs-6 noselect">
                    <!-- Widget: user widget style 1 -->
                    <div class="box box-widget widget-user-2" onclick="window.location = '<?php echo base_url();?>Inventario';">
                        <!-- Add the bg color to the header using any of the bg-* classes -->
                        <div class="widget-user-header bg-white-active">
                        <div class="widget-user-image">
                            <img class="img-circle" src="<?php echo base_url();?>assets/images/inventory.png" alt="Usuarios">
                        </div>
                        <!-- /.widget-user-image -->
                        <span class="hidden-xs">
                        <h3 class="widget-user-username">Inventarios</h3>
                        <h5 class="widget-user-desc"> Inventarios</h5>
                        </span>
                        </div>
                        <div class="box-footer no-padding">
                        <ul class="nav nav-stacked">
                            <li><a href="<?php echo base_url();?>Inventario">Inventarios <span class="pull-right badge bg-blue">Click here</span></a></li>
                        </ul>
                        </div>
                    </div>
                    <!-- /.widget-user -->
                    </div>
                    <!-- /.col -->


                        <!-- /.col -->
                        <div class="col-lg-4 col-xs-6 noselect">
                    <!-- Widget: user widget style 1 -->
                    <div class="box box-widget widget-user-2" onclick="window.location = '<?php echo base_url();?>Pedidos';">
                        <!-- Add the bg color to the header using any of the bg-* classes -->
                        <div class="widget-user-header bg-white-active">
                        <div class="widget-user-image">
                            <img class="img-circle" src="<?php echo base_url();?>assets/images/order.png" alt="Usuarios">
                        </div>
                        <!-- /.widget-user-image -->
                        <span class="hidden-xs">
                        <h3 class="widget-user-username">Pedidos</h3>
                        <h5 class="widget-user-desc">Pedidos</h5>
                        </span>
                        </div>
                        <div class="box-footer no-padding">
                        <ul class="nav nav-stacked">
                            <li><a href="<?php echo base_url();?>Pedidos"> Pedidos <span class="pull-right badge bg-blue">Click here</span></a></li>
                        </ul>
                        </div>
                    </div>
                    <!-- /.widget-user -->
                    </div>
                    <!-- /.col -->

                        <!-- /.col -->
                        <div class="col-lg-4 col-xs-6 noselect">
                    <!-- Widget: user widget style 1 -->
                    <div class="box box-widget widget-user-2" onclick="window.location = '<?php echo base_url();?>Nominas';">
                        <!-- Add the bg color to the header using any of the bg-* classes -->
                        <div class="widget-user-header bg-white-active">
                        <div class="widget-user-image">
                            <img class="img-circle" src="<?php echo base_url();?>assets/images/nomina.png" alt="Nominas">
                        </div>
                        <!-- /.widget-user-image -->
                        <span class="hidden-xs">
                        <h3 class="widget-user-username">Nominas</h3>
                        <h5 class="widget-user-desc">Nominas</h5>
                        </span>
                        </div>
                        <div class="box-footer no-padding">
                        <ul class="nav nav-stacked">
                            <li><a href="<?php echo base_url();?>Nominas">Nominas<span class="pull-right badge bg-blue">Click here</span></a></li>
                        </ul>
                        </div>
                    </div>
                    <!-- /.widget-user -->
                    </div>
                    <!-- /.col -->

                        <!-- /.col -->
                        <div class="col-lg-4 col-xs-6 noselect">
                    <!-- Widget: user widget style 1 -->
                    <div class="box box-widget widget-user-2" onclick="window.location = '<?php echo base_url();?>Usuarios';">
                        <!-- Add the bg color to the header using any of the bg-* classes -->
                        <div class="widget-user-header bg-white-active">
                        <div class="widget-user-image">
                            <img class="img-circle" src="<?php echo base_url();?>assets/images/users.png" alt="Usuarios">
                        </div>
                        <!-- /.widget-user-image -->
                        <span class="hidden-xs">
                        <h3 class="widget-user-username">Usuarios</h3>
                        <h5 class="widget-user-desc"> Usuarios</h5>
                        </span>
                        </div>
                        <div class="box-footer no-padding">
                        <ul class="nav nav-stacked">
                            <li><a href="<?php echo base_url();?>Usuarios"> Usuarios <span class="pull-right badge bg-blue">Click here</span></a></li>
                        </ul>
                        </div>
                    </div>
                    <!-- /.widget-user -->
                    </div>
                    <!-- /.col -->

                        <!-- /.col -->
                        <div class="col-lg-4 col-xs-6 noselect">
                    <!-- Widget: user widget style 1 -->
                    <div class="box box-widget widget-user-2" onclick="window.location = '<?php echo base_url();?>Permisos';">
                        <!-- Add the bg color to the header using any of the bg-* classes -->
                        <div class="widget-user-header bg-white-active">
                        <div class="widget-user-image">
                            <img class="img-circle" src="<?php echo base_url();?>assets/images/secure.png" alt="Usuarios">
                        </div>
                        <!-- /.widget-user-image -->
                        <span class="hidden-xs">
                        <h3 class="widget-user-username">Permisos</h3>
                        <h5 class="widget-user-desc">Permisos</h5>
                        </span>
                        </div>
                        <div class="box-footer no-padding">
                        <ul class="nav nav-stacked">
                            <li><a href="<?php echo base_url();?>Permisos">Permisos<span class="pull-right badge bg-blue">Click here</span></a></li>
                        </ul>
                        </div>
                    </div>
                    <!-- /.widget-user -->
                    </div>
                    <!-- /.col -->

                        <!-- /.col -->
                        <div class="col-lg-4 col-xs-6 noselect">
                    <!-- Widget: user widget style 1 -->
                    <div class="box box-widget widget-user-2" onclick="window.location = '<?php echo base_url();?>Productos';">
                        <!-- Add the bg color to the header using any of the bg-* classes -->
                        <div class="widget-user-header bg-white-active">
                        <div class="widget-user-image">
                            <img class="img-circle" src="<?php echo base_url();?>assets/images/coffe2.png" alt="Usuarios">
                        </div>
                        <!-- /.widget-user-image -->
                        <span class="hidden-xs">
                        <h3 class="widget-user-username">Productos</h3>
                        <h5 class="widget-user-desc"> Productos</h5>
                        </span>
                        </div>
                        <div class="box-footer no-padding">
                        <ul class="nav nav-stacked">
                            <li><a href="<?php echo base_url();?>Productos"> Productos <span class="pull-right badge bg-blue">Click here</span></a></li>
                        </ul>
                        </div>
                    </div>
                    <!-- /.widget-user -->
                    </div>
                    <!-- /.col -->

                        <!-- /.col -->
                        <div class="col-lg-4 col-xs-6 noselect">
                    <!-- Widget: user widget style 1 -->
                    <div class="box box-widget widget-user-2" onclick="window.location = '<?php echo base_url();?>Opciones';">
                        <!-- Add the bg color to the header using any of the bg-* classes -->
                        <div class="widget-user-header bg-white-active">
                        <div class="widget-user-image">
                            <img class="img-circle" src="<?php echo base_url();?>assets/images/tool.png" alt="Usuarios">
                        </div>
                        <!-- /.widget-user-image -->
                        <span class="hidden-xs">
                        <h3 class="widget-user-username">Configurar</h3>
                        <h5 class="widget-user-desc">Configurar</h5>
                        </span>
                        </div>
                        <div class="box-footer no-padding">
                        <ul class="nav nav-stacked">
                            <li><a href="<?php echo base_url();?>Opciones">Configurar<span class="pull-right badge bg-blue">Click here</span></a></li>
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

<script type="text/javascript">        
     
    consultarInsumosFaltantes();

    function consultarInsumosFaltantes(){        
        $.ajax({
            type: "GET",
            url: "<?php echo base_url();?>Pedidos/faltantesPedidoCount",            
            dataType: "JSON",            
            success: function(response){                                                           
                let data=response[0].data;                                                                
                $("#lblInsumosFaltantes").text(data.Total);
            },
            error: function(xhr, desc, e) {                                 
                alert("Error posting feed.");                
            }
        });                
    }
</script>    
