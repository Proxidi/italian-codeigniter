
        <!-- =============================================== -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                Reportes
                <small>Listado</small>
                </h1>
                <a href="<?php echo base_url(); ?>Ventas" class="small-box-footer">Volver al Panel de Ventas <i class="fa fa-arrow-circle-right"></i></a>
            </section>
            <!-- Main content -->
            <section class="content">
                <!-- Default box -->
                <div class="box box-solid">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <a href="<?php echo base_url();?>Ventas/add" class="btn btn-primary btn-flag"><span class="fa fa-plus"></span>
                                Agregar Reporte
                                </a>
                            </div>
                         </div>
                         <hr>
                         <div class="row">
                            <div class="col-md-12">
                            <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_ventas">
                            <thead>
                                <tr>                                    
                                    <th>Nombre</th>
                                    <th>Plaza</th>
                                    <th>Fecha</th>                                   
                                   <th>Ingresos</th>  
                                   <th>Ventas</th>                                                                    
                                   <th>TPV</th>
                                    <th>Gastos</th>
                                    <th>Eliminar</th>                                                                      
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($reportes)):?>
                                <?php foreach ($reportes as $reporte):?>
                                   <tr>                                    
                                    <td><h4><?=$reporte->Usuario;?></h4></td>
                                    <td><h4><?=$reporte->Plaza;?></h4></td>
                                    <td><h4><?=$reporte->Fecha;?></h4></td>                                    
                                    <td><h4><?=$reporte->Total_Ingresos;?></h4></td>
                                    <td><h4><?=$reporte->Total_Ventas;?></h4></td>                                                                        
                                    <td><h4><?=$reporte->TPV;?></h4></td>
                                    <td><h4><?=$reporte->Gastos;?></h4></td>                                                                                                      
                                    <td>
                                    <a href="<?php echo base_url();?>Ventas/delete/<?php echo $reporte->id;?>" class="btn btn-danger btn-remove">
                                            <span class="fa fa-remove">
                                            </span></a>
                                    </td>
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

