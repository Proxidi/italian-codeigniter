        <!-- =============================================== -->

        <!-- Left side column. contains the sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- sidebar menu: : style can be found in sidebar.less -->
                <ul class="sidebar-menu" data-widget="tree">
                    
                    <li>
                        <a href="#" id="notificaciones">
                            <i class="fa fa-exclamation-circle"></i> <span>Mis Notificaciones</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url();?>Inicio">
                            <i class="fa fa-home"></i> <span>Inicio</span>
                        </a>
                    </li>                   

                    <!--VISTA UNO (MANAGER-SUBMANAGER)-->
                    <?php if($this->session->userdata("rol_id")==2 || $this->session->userdata("rol_id")==4):?>                                                                     										
												<!-- Integración Telnet -->
												<li>
														<a href="<?php echo base_url();?>Ventas/add2">
																<i class="fa fa-money"></i> <span style="font-size: 130%">Ventas</span>
														</a>
												</li>                            
                        <li>
                            <a href="<?php echo base_url();?>Remesas/indexManager">
                                <i class="fa fa-shopping-cart"></i> <span style="font-size: 130%">Gastos</span>
                            </a>
                        </li>  

                        <li>
                            <a href="<?php echo base_url();?>Inventario/nuevaCaptura">
                                <i class="fa fa-cubes"></i><span style="font-size: 130%"> Inventario Físico</span>
                            </a>
                        </li>  

                        <li>
                            <a href="<?php echo base_url();?>Inventario/addDLC">
                                <i class="fa fa-plus"></i><span style="font-size: 130%"> Agregar DLC</span>
                            </a>
                        </li> 
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-cart-plus"></i> <span style="font-size: 130%">Pedidos</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?php echo base_url();?>Pedidos/recepcionPedido"><i class="fa fa-circle-o"></i>Pedidos Franquicia</a></li>
                                <li><a href="<?php echo base_url();?>Pedidos/listManagerPasteleria"><i class="fa fa-circle-o"></i>Pedidos Pasteleria</a></li>
                                <li><a href="<?php echo base_url();?>Pedidos/historialManager"><i class="fa fa-circle-o"></i>H. Facturas</a></li>                                
                            </ul>
                        </li>

                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-money"></i> <span style="font-size: 130%">Nominas</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>

                            <ul class="treeview-menu">
                                <li><a href="<?php echo base_url();?>Nominas/rolManager"><i class="fa fa-circle-o"></i>Rol semanal</a></li>
                                <li><a href="<?php echo base_url();?>Nominas/usuariosManager"><i class="fa fa-circle-o"></i>Usuarios</a></li>   
                                <li><a href="<?php echo base_url();?>Nominas/usuariosEliminadosManager"><i class="fa fa-circle-o"></i>Usuarios Eliminados</a></li>                               
                            </ul>

                        </li>                                                                
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-user-circle-o"></i> <span style="font-size: 130%">Configuración</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?php echo base_url();?>Seguridad/logout"><i class="fa fa-circle-o"></i>Cerrar Sesión</a></li>                            
                            </ul>
                        </li>

                    <?php endif;?>
                    <!--./ VISTA UNO-->

                    <!--VISTA DOS (DUEÑO) -->
                    <?php if($this->session->userdata("rol_id")==1):?>
                    <li class="treeview">
                            <a href="#">
                                <i class="fa fa-money" aria-hidden="true"></i> <span >Ventas</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?php echo base_url();?>Depositos"><i class="fa fa-circle-o"></i>Depositos</a></li>
                                <li><a href="<?php echo base_url();?>Depositos/analisisVentas"><i class="fa fa-circle-o"></i>Análisis Ventas</a></li>
                                <li><a href="<?php echo base_url();?>Depositos/tablaDepositos"><i class="fa fa-circle-o"></i>Tabla Depósitos</a></li>
                                <li><a href="<?php echo base_url();?>Depositos/comparar"><i class="fa fa-circle-o"></i>Ventas x Mes</a></li>
                                <li><a href="<?php echo base_url();?>Depositos/tickets"><i class="fa fa-circle-o"></i>Ticket Promedio - UT</a></li>                                                       
                            </ul>
                        </li>   


                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-shopping-cart"></i> <span >Remesas</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?php echo base_url();?>Remesas/addRemesasAdministrador"><i class="fa fa-circle-o"></i>Remesas F.G.F</a></li>
                                <li><a href="<?php echo base_url();?>Remesas/analisisRemesas"><i class="fa fa-circle-o"></i>Análisis Remesas</a></li>
                                <li><a href="<?php echo base_url();?>Remesas/listRemesasGenerales"><i class="fa fa-circle-o"></i>Remesas Generales</a></li>
                                
                            </ul>
                        </li>  
                        <li>
                            <a href="<?php echo base_url();?>Unidades">
                                <i class="fa fa-cutlery"></i> <span >Unidades</span>
                            </a>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-cubes"></i> <span >Inventario</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?php echo base_url();?>Inventario/listAdmin"><i class="fa fa-circle-o"></i>Inventarios Producción</a></li>
                                <li><a href="<?php echo base_url();?>Inventario/listAdminF"><i class="fa fa-circle-o"></i>Inventarios F.G.F</a></li>                                                                                                
                                <li><a href="<?php echo base_url();?>Inventario/historialIF"><i class="fa fa-circle-o"></i>Historial I.F</a></li>                                
                            </ul>
                        </li>     
                        
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-car"></i> <span >Pedidos</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?php echo base_url();?>Pedidos/add"><i class="fa fa-circle-o"></i>Pedidos</a></li>
                                <li><a href="<?php echo base_url();?>Pedidos/addPasteleria"><i class="fa fa-circle-o"></i>Pedidos Pasteleria</a></li>
                                <li><a href="<?php echo base_url();?>Pedidos/historialAdmin"><i class="fa fa-circle-o"></i>Liberados Franquicia</a></li>                                
                                <li><a href="<?php echo base_url();?>Pedidos/historialPasteleria"><i class="fa fa-circle-o"></i>Liberados Pasteleria</a></li>                                
                            </ul>
                        </li>
                        <li class="treeview">
                                <a href="#">
                                    <i class="fa fa-users" aria-hidden="true"></i> <span >Usuarios</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">                                    
                                    <li><a href="<?php echo base_url();?>Usuarios/listaAccesos"><i class="fa fa-circle-o"></i>Bítacora de Accesos</a></li>                                  
                                </ul>
                            </li>                          
                                                   
                        
                        
                        
                        <li>
                            <a href="<?php echo base_url(); ?>Seguridad/logout">
                                <i class="fa fa-sign-out"></i> <span>Cerrar Sesión</span>
                            </a>
                        </li>                            
                    <?php endif;?>
                    <!--./ VISTA DOS-->

                    <!--VISTA TRES (GERENTE) -->                    
                    <?php if($this->session->userdata("rol_id")==3):?>                                                                                                                      
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-money" aria-hidden="true"></i> <span >Ventas</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?php echo base_url();?>Depositos"><i class="fa fa-circle-o"></i>Depositos</a></li>
                                <li><a href="<?php echo base_url();?>Depositos/analisisVentas"><i class="fa fa-circle-o"></i>Análisis Ventas</a></li>
                                <li><a href="<?php echo base_url();?>Depositos/tablaDepositos"><i class="fa fa-circle-o"></i>Tabla Depósitos</a></li>
                                <li><a href="<?php echo base_url();?>Depositos/comparar"><i class="fa fa-circle-o"></i>Ventas x Mes</a></li>
                                <li><a href="<?php echo base_url();?>Depositos/tickets"><i class="fa fa-circle-o"></i>Ticket Promedio - UT</a></li>                                                       
                                <li><a href="<?php echo base_url();?>Depositos/liberarDepositos"><i class="fa fa-circle-o"></i>Liberar Depositos</a></li>                                                       
                                <li><a href="<?php echo base_url();?>Ventas/tablaCostoVenta"><i class="fa fa-circle-o"></i>Costo de venta</a></li>
                            </ul>
                        </li>   


                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-shopping-cart"></i> <span >Remesas</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?php echo base_url();?>Remesas/addRemesasAdministrador"><i class="fa fa-circle-o"></i>Remesas F.G.F</a></li>
                                <li><a href="<?php echo base_url();?>Remesas/analisisRemesas"><i class="fa fa-circle-o"></i>Análisis Remesas</a></li>
                                <li><a href="<?php echo base_url();?>Remesas/listRemesasGenerales"><i class="fa fa-circle-o"></i>Remesas Generales</a></li>
                                <li><a href="<?php echo base_url();?>Remesas/stocks"><i class="fa fa-circle-o"></i>Stocks</a></li>                                
                            </ul>
                        </li>  
                        <li>
                            <a href="<?php echo base_url();?>Unidades">
                                <i class="fa fa-cutlery"></i> <span >Unidades</span>
                            </a>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-cubes"></i> <span >Inventario</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?php echo base_url();?>Inventario/listAdmin"><i class="fa fa-circle-o"></i>Inventarios Producción</a></li>
                                <li><a href="<?php echo base_url();?>Inventario/listAdminF"><i class="fa fa-circle-o"></i>Inventarios F.G.F</a></li>                                                                
                                <li><a href="<?php echo base_url();?>Inventario/panelConfiguraciones"><i class="fa fa-circle-o"></i>Configuraciones</a></li>                                                                
                                <li><a href="<?php echo base_url();?>Inventario/seguimientoInventario"><i class="fa fa-circle-o"></i>Seguimiento Inv.</a></li>  
                                <li><a href="#"><i class="fa fa-circle-o"></i>Inventario Máquinas.</a></li>  
                            </ul>
                        </li>     
                        
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-car"></i> <span >Pedidos</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?php echo base_url();?>Pedidos/add"><i class="fa fa-circle-o"></i>Pedidos</a></li>
                                <li><a href="<?php echo base_url();?>Pedidos/addPasteleria"><i class="fa fa-circle-o"></i>Pedidos Pasteleria</a></li>                                
                                <li><a href="<?php echo base_url();?>Pedidos/historialAdmin"><i class="fa fa-circle-o"></i>Liberados Franquicia</a></li>                                
                                <li><a href="<?php echo base_url();?>Pedidos/historialPasteleria"><i class="fa fa-circle-o"></i>Liberados Pasteleria</a></li>                                
                                <li><a href="<?php echo base_url();?>Pedidos/faltantesPedido"><i class="fa fa-circle-o"></i>Faltantes Pedido</a></li>
                            </ul>
                        </li>

                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-money"></i> <span >Nominas</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?php echo base_url();?>Nominas/roles"><i class="fa fa-circle-o"></i>Tabla Roles</a></li>
                                <li><a href="<?php echo base_url();?>Nominas/tabla"><i class="fa fa-circle-o"></i>Tabla Nominas</a></li>
                                <li><a href="<?php echo base_url();?>Nominas/analisisNominas"><i class="fa fa-circle-o"></i>Análisis Nominas</a></li>  
                                <li><a href="<?php echo base_url();?>Nominas/correccionRoles"><i class="fa fa-circle-o"></i>Corrección de Roles</a></li>                                  
                                <li><a href="<?php echo base_url();?>Nominas/usuariosAdministrador"><i class="fa fa-circle-o"></i>Usuarios</a></li>                                
                                <li><a href="<?php echo base_url();?>Nominas/usuariosEliminadosAdministrador"><i class="fa fa-circle-o"></i>Usuarios Eliminados</a></li>                                
                            </ul>
                        </li>



                        <li class="treeview">
                                <a href="#">
                                    <i class="fa fa-users" aria-hidden="true"></i> <span >Usuarios</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="<?php echo base_url();?>Usuarios"><i class="fa fa-circle-o"></i>Listado de Usuarios</a></li>
                                    <li><a href="<?php echo base_url();?>Usuarios/listaAccesos"><i class="fa fa-circle-o"></i>Bítacora de Accesos</a></li>                                  
                                </ul>
                            </li>                          
                        <li class="treeview">
                                <a href="#">
                                    <i class="fa fa-coffee" aria-hidden="true"></i> <span >Productos</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="<?php echo base_url();?>Productos/list"><i class="fa fa-circle-o"></i>Productos</a></li>
                                    <li><a href="<?php echo base_url();?>Insumos"><i class="fa fa-circle-o"></i>Insumos</a></li>
                                    <li><a href="<?php echo base_url();?>Medidas"><i class="fa fa-circle-o"></i>Unidades</a></li>                        
                                    <li><a href="<?php echo base_url();?>Insumos/getInsumosCostoVenta"><i class="fa fa-circle-o"></i>Costo de Venta</a></li>                        
                                </ul>
                            </li>                                                      
                        <li>
                            <a href="<?php echo base_url();?>Permisos">
                                <i class="fa fa-lock"></i> <span >Permisos</span>
                            </a>
                        </li> 
                        
                        <li class="treeview">
                                <a href="#">
                                    <i class="fa fa-cogs" aria-hidden="true"></i><span>Configurar</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="<?php echo base_url();?>Opciones/fechas"><i class="fa fa-circle-o"></i>Corte && DLC</a></li>
                                    <li><a href="<?php echo base_url();?>Usuarios/notificaciones"><i class="fa fa-circle-o"></i>Notificaciones</a></li>                                    
                                </ul>
                        </li>      

                        
                        <li>
                            <a href="<?php echo base_url(); ?>Seguridad/logout">
                                <i class="fa fa-sign-out"></i> <span>Cerrar Sesión</span>
                            </a>
                        </li>                     
                    <?php endif;?>
                    <!--./VISTA TRES (GERENTE) -->
                                         
                    <!--VISTA TRES (SOCIO) -->
                    <?php if($this->session->userdata("rol_id")==5):?>                                                                                                                      
                       
                         <li>
                            <a href="<?php echo base_url(); ?>Depositos/ventasOaxaca">
                                <i class="fa fa-money"></i> <span>Ventas</span>
                            </a>
                        </li>   

                        <li>
                            <a href="<?php echo base_url(); ?>Remesas/listRemesasOaxaca">
                                <i class="fa fa-shopping-cart"></i> <span>Gastos</span>
                            </a>
                        </li>   


                        <li>
                            <a href="<?php echo base_url(); ?>Unidades/listUnidadesOaxaca">
                                <i class="fa fa-cutlery"></i> <span>Unidades</span>
                            </a>
                        </li>   


                        <li>
                            <a href="<?php echo base_url(); ?>Seguridad/logout">
                                <i class="fa fa-sign-out"></i> <span>Cerrar Sesión</span>
                            </a>
                        </li>                     
                    <?php endif;?>
                    <!--./VISTA TRES (SOCIO) -->
                </ul>
            </section>
            <!-- /.sidebar -->
        </aside>

        <!-- =============================================== -->
