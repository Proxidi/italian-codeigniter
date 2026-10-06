
        <!-- =============================================== -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                Reportes Telnet
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
                                <a href="<?php echo base_url();?>Ventas/add2" class="btn btn-primary btn-flag"><span class="fa fa-plus"></span>
                                Agregar Reporte
                                </a>
                            </div>
                         </div>
                         <hr>
                         <div class="row">
                            <div class="col-md-12">
                            <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_datos">
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
                                    <td><?=$reporte->Usuario;?></td>
                                    <td><?=$reporte->Plaza;?></td>
                                    <td><?=$reporte->Fecha;?></td>                                    
                                    <td><?=$reporte->Total_Ingresos;?></td>
                                    <td><?=$reporte->Total_Ventas;?></td>                                                                        
                                    <td><?=$reporte->TPV;?></td>
                                    <td><?=$reporte->Gastos;?></td>                                                                                                      
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

<div class="modal fade" id="modal-default">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Informacion del Usuario</h4>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

