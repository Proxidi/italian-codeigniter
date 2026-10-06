<!-- DIV Content-Wrapper -->
<div class="content-wrapper">

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Historial de Insumos Faltantes en Pedidos Realizados
    <small>Pedidos</small></h1>
    <a href="<?php echo base_url();?>Pedidos" class="small-box-footer">Volver al Panel de Pedidos <i class="fa fa-arrow-circle-right"></i></a>                
</section>
<!-- /.Content Header (Page header) -->
<!-- Main content -->
<section class="content">
<!-- Default box box-solid -->
<div class="box box-solid">
<!-- Default box box-body -->
<div class="box-body">       
    <div class="row">
                            <div class="col-md-12">
                            <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_inventario">
                            <thead>
                                <tr>                                                                        
                                    <th>Fecha</th>
                                    <th>Plaza</th>
                                    <th>Insumo</th>                                     
                                    <th>C.Recibida</th>                                                                                                                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($faltantes)):?>  
                                <?php foreach ($faltantes as $faltante):?>                                
                                <tr>                                                                        
                                    <td><?=$faltante->Fecha;?></td>     
                                    <td><?=$faltante->Plaza;?></td>                                 
                                    <td><?=$faltante->Nombre;?></td>                                       
                                    <td><?=$faltante->Unidad;?></td>  
                                </tr>   
                                <?php endforeach;?>       
                                <tr>
                                <td bgcolor="#76c5ff"><b>TOTALES</b></td>
                                <td bgcolor="#76c5ff"></td>
                                <td bgcolor="#76c5ff"></td>                                                               
                                <td bgcolor="#76c5ff"></td>  
                                </tr>                                                       
                                <?php endif;?>                                
                            </tbody>                            
                            </table>
                            </div>
                         </div>      
</div>
<!-- /. Default box box-body -->

</div>
<!-- /. Default box box-solid -->

</section>
<!-- /.content -->

</div>
<!-- /.content-wrapper -->




