<!-- =============================================== -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Panel de Ventas
        <small>Ventas </small>
        </h1>
        <a href="<?php echo base_url();?>Inicio" class="small-box-footer">Volver al Panel de Inicio <i class="fa fa-arrow-circle-right"></i></a>
    </section>
    
    <section class="content">
        <div class="row">
            <!--ROL DUEÑO-->
            <?php if($this->session->userdata("rol_id")==1):?>                                                
                <div class="col-lg-4 col-xs-6 noselect">                    
                    <div class="box box-widget widget-user-2" onclick="window.location = '<?php echo base_url();?>Depositos';">                        
                        <div class="widget-user-header bg-white-active">
                            <div class="widget-user-image">
                                <img class="img-circle" src="<?php echo base_url();?>assets/images/cash.png" alt="Usuarios">
                            </div>                        
                            <span class="hidden-xs">
                                <h3 class="widget-user-username">Depósitos</h3>
                                <h5 class="widget-user-desc"> Depósitos</h5>
                            </span>
                        </div>
                        <div class="box-footer no-padding">
                            <ul class="nav nav-stacked">
                                <li><a href="<?php echo base_url();?>Depositos"> Depósitos <span class="pull-right badge bg-blue">Click here</span></a></li>
                            </ul>
                        </div>
                    </div>                    
                </div>
                                                
                <div class="col-lg-4 col-xs-6 noselect">                    
                    <div class="box box-widget widget-user-2" onclick="window.location = '<?php echo base_url();?>Depositos/analisisVentas';">                        
                        <div class="widget-user-header bg-white-active">
                            <div class="widget-user-image">
                                <img class="img-circle" src="<?php echo base_url();?>assets/images/lupa.png" alt="Usuarios">
                            </div>                        
                            <span class="hidden-xs">
                                <h3 class="widget-user-username">Análisis </h3>
                                <h5 class="widget-user-desc">Análisis </h5>
                            </span>
                        </div>

                        <div class="box-footer no-padding">
                            <ul class="nav nav-stacked">
                                <li><a href="<?php echo base_url();?>Depositos/analisisVentas"> Análisis <span class="pull-right badge bg-blue">Click here</span></a></li>
                            </ul>
                        </div>
                    </div>                        
                </div>                                            
                
                <div class="col-lg-4 col-xs-6 noselect">                
                    <div class="box box-widget widget-user-2" onclick="window.location = '<?php echo base_url();?>Depositos/tablaDepositos';">                    
                        <div class="widget-user-header bg-white-active">
                            <div class="widget-user-image">
                                <img class="img-circle" src="<?php echo base_url();?>assets/images/bank.png" alt="Usuarios">
                            </div>
                        
                            <span class="hidden-xs">
                                <h3 class="widget-user-username">Tabla Depósitos  </h3>
                                <h5 class="widget-user-desc">Tabla Depósitos  </h5>
                            </span>
                        </div>
                        <div class="box-footer no-padding">
                            <ul class="nav nav-stacked">
                                <li><a href="<?php echo base_url();?>Depositos/tablaDepositos">Tabla Depósitos<span class="pull-right badge bg-blue">Click here</span></a></li>
                            </ul>
                        </div>
                    </div>                        
                </div>                        
                
                <div class="col-lg-4 col-xs-6 noselect">                    
                    <div class="box box-widget widget-user-2" onclick="window.location = '<?php echo base_url();?>Depositos/comparar';">                        
                        <div class="widget-user-header bg-white-active">
                            <div class="widget-user-image">
                                <img class="img-circle" src="<?php echo base_url();?>assets/images/report5.png" alt="Usuarios">
                            </div>                        
                            <span class="hidden-xs">
                                <h3 class="widget-user-username">V.Mensuales</h3>
                                <h5 class="widget-user-desc"> V.Mensuales</h5>
                            </span>
                        </div>
                        <div class="box-footer no-padding">
                            <ul class="nav nav-stacked">
                                <li><a href="<?php echo base_url();?>Depositos/comparar"> V.Mensuales <span class="pull-right badge bg-blue">Click here</span></a></li>
                            </ul>
                        </div>
                    </div>                    
                </div>

                <div class="col-lg-4 col-xs-6 noselect">                
                    <div class="box box-widget widget-user-2" onclick="window.location = '<?php echo base_url();?>Depositos/tickets';">                        
                        <div class="widget-user-header bg-white-active">
                            <div class="widget-user-image">
                                <img class="img-circle" src="<?php echo base_url();?>assets/images/ticket.png" alt="Usuarios">
                            </div>                        
                            <span class="hidden-xs">
                                <h3 class="widget-user-username">TP-UT</h3>
                                <h5 class="widget-user-desc"> TP-UT</h5>
                            </span>
                        </div>
                        <div class="box-footer no-padding">
                            <ul class="nav nav-stacked">
                                <li><a href="<?php echo base_url();?>Depositos/tickets"> TP-UT <span class="pull-right badge bg-blue">Click here</span></a></li>
                            </ul>
                        </div>
                    </div>                
                </div>                                                                    
            <!--ROL GERENTE-->
            <?php elseif($this->session->userdata("rol_id")==3):?>                                        
                <div class="col-lg-4 col-xs-6 noselect">                        
                    <div class="box box-widget widget-user-2" onclick="window.location = '<?php echo base_url();?>Depositos';">
                        <!-- Add the bg color to the header using any of the bg-* classes -->
                        <div class="widget-user-header bg-white-active">
                        <div class="widget-user-image">
                            <img class="img-circle" src="<?php echo base_url();?>assets/images/cash.png" alt="Usuarios">
                        </div>
                        <!-- /.widget-user-image -->
                        <span class="hidden-xs">
                        <h3 class="widget-user-username">Depósitos</h3>
                        <h5 class="widget-user-desc"> Depósitos</h5>
                        </span>
                        </div>
                        <div class="box-footer no-padding">
                        <ul class="nav nav-stacked">
                            <li><a href="<?php echo base_url();?>Depositos"> Depósitos <span class="pull-right badge bg-blue">Click here</span></a></li>
                        </ul>
                        </div>
                    </div>                        
                </div>
                                        
                <div class="col-lg-4 col-xs-6 noselect">                
                    <div class="box box-widget widget-user-2" onclick="window.location = '<?php echo base_url();?>Depositos/analisisVentas';">                    
                        <div class="widget-user-header bg-white-active">
                            <div class="widget-user-image">
                                <img class="img-circle" src="<?php echo base_url();?>assets/images/lupa.png" alt="Usuarios">
                            </div>                    
                            <span class="hidden-xs">
                                <h3 class="widget-user-username">Análisis </h3>
                                <h5 class="widget-user-desc">Análisis </h5>
                            </span>
                        </div>
                        <div class="box-footer no-padding">
                            <ul class="nav nav-stacked">
                                <li><a href="<?php echo base_url();?>Depositos/analisisVentas"> Análisis <span class="pull-right badge bg-blue">Click here</span></a></li>
                            </ul>
                        </div>
                    </div>                
                </div>                
                
                <div class="col-lg-4 col-xs-6 noselect">                
                    <div class="box box-widget widget-user-2" onclick="window.location = '<?php echo base_url();?>Depositos/tablaDepositos';">                    
                        <div class="widget-user-header bg-white-active">
                            <div class="widget-user-image">
                                <img class="img-circle" src="<?php echo base_url();?>assets/images/bank.png" alt="Usuarios">
                            </div>  

                            <span class="hidden-xs">
                                <h3 class="widget-user-username">Tabla Depósitos  </h3>
                                <h5 class="widget-user-desc">Tabla Depósitos  </h5>
                            </span>
                        </div>

                        <div class="box-footer no-padding">
                            <ul class="nav nav-stacked">
                                <li><a href="<?php echo base_url();?>Depositos/tablaDepositos">Tabla Depósitos<span class="pull-right badge bg-blue">Click here</span></a></li>
                            </ul>
                        </div>
                    </div>                
                </div>                
                                
                <div class="col-lg-4 col-xs-6 noselect">                
                    <div class="box box-widget widget-user-2" onclick="window.location = '<?php echo base_url();?>Depositos/comparar';">                    
                        <div class="widget-user-header bg-white-active">
                            <div class="widget-user-image">
                                <img class="img-circle" src="<?php echo base_url();?>assets/images/report5.png" alt="Usuarios">
                            </div>                    

                            <span class="hidden-xs">
                                <h3 class="widget-user-username">V.Mensuales</h3>
                                <h5 class="widget-user-desc"> V.Mensuales</h5>
                            </span>
                        </div>

                        <div class="box-footer no-padding">
                            <ul class="nav nav-stacked">
                                <li><a href="<?php echo base_url();?>Depositos/comparar"> V.Mensuales <span class="pull-right badge bg-blue">Click here</span></a></li>
                            </ul>
                        </div>
                    </div>                
                </div>
                                        
                <div class="col-lg-4 col-xs-6 noselect">                        
                    <div class="box box-widget widget-user-2" onclick="window.location = '<?php echo base_url();?>Depositos/tickets';">                            
                        <div class="widget-user-header bg-white-active">
                            <div class="widget-user-image">
                                <img class="img-circle" src="<?php echo base_url();?>assets/images/ticket.png" alt="Usuarios">
                            </div>    

                            <span class="hidden-xs">
                                <h3 class="widget-user-username">TP-UT</h3>
                                <h5 class="widget-user-desc"> TP-UT</h5>
                            </span>
                        </div>

                        <div class="box-footer no-padding">
                            <ul class="nav nav-stacked">
                                <li><a href="<?php echo base_url();?>Depositos/tickets"> TP-UT <span class="pull-right badge bg-blue">Click here</span></a></li>
                            </ul>
                        </div>
                    </div>                        
                </div>                        

                <div class="col-lg-4 col-xs-6 noselect">                        
                    <div class="box box-widget widget-user-2" onclick="window.location = '<?php echo base_url();?>Depositos/liberarDepositos';">                            
                        <div class="widget-user-header bg-white-active">                                
                            <div class="widget-user-image">
                                <img class="img-circle" src="<?php echo base_url();?>assets/images/managment.png" alt="Usuarios">
                            </div>                            

                            <span class="hidden-xs">
                                <h3 class="widget-user-username">Liberar Depósitos</h3>
                                <h5 class="widget-user-desc"> Liberar Depósitos</h5>
                            </span>                                
                        </div>

                        <div class="box-footer no-padding">
                            <ul class="nav nav-stacked">
                                <li><a href="<?php echo base_url();?>Depositos/liberarDepositos"> Liberar Depósitos <span class="pull-right badge bg-blue">Click here</span></a></li>
                            </ul>
                        </div>
                    </div>                        
                </div>                        

                <div class="col-lg-4 col-xs-6 noselect">                        
                    <div class="box box-widget widget-user-2" onclick="window.location = '<?php echo base_url();?>Ventas/tablaCostoVenta';">                        
                        <div class="widget-user-header bg-white-active">
                            <div class="widget-user-image">
                                <img class="img-circle" src="<?php echo base_url();?>assets/images/managment.png" alt="Usuarios">
                            </div>
                    
                            <span class="hidden-xs">
                                <h3 class="widget-user-username">Costo de venta</h3>
                                <h5 class="widget-user-desc"> Costo de venta</h5>
                            </span>
                        </div>

                        <div class="box-footer no-padding">
                            <ul class="nav nav-stacked">
                                <li><a href="<?php echo base_url();?>Ventas/tablaCostoVenta"> Costo de venta <span class="pull-right badge bg-blue">Click here</span></a></li>
                            </ul>
                        </div>
                    </div>                        
                </div>                        
                            
            <?php endif;?>
        </div>                
    </section>            
</div>
<!-- /.content-wrapper -->
