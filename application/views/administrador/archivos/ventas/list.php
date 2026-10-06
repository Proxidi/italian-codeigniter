<!-- DIV Content-Wrapper -->
<div class="content-wrapper">

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Archivos de Corte enviados<small>Listado</small></h1>
    <a href="<?php echo base_url();?>Archivos" class="small-box-footer">Volver al Panel de Archivos <i class="fa fa-arrow-circle-right"></i></a>                
</section>
<!-- /.Content Header (Page header) -->

<!-- Main content -->
<section class="content">

<!-- Default box box-solid -->
<div class="box box-solid">

<!-- Default box box-body -->
<div class="box-body">       

    <!-- DIV ROW -->                         
    <div class="row">

        <!-- DIV COL-MD-12 -->
        <div class="col-md-12">                  
        </div>   
        <!-- /.DIV COL-MD-12 -->       
    </div>                    
    <!-- /.DIV ROW --> 
    <div class="row">
                            <div class="col-md-12">
                            <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_ventas2">
                            <thead>
                                <tr>      
                                    <th>Archivo</th>                              
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
                                    <td><h4>CORTE</h4></td>                                  
                                    <td><h4><?=$reporte->Usuario;?></h4></td>
                                    <td><h4><?=$reporte->Plaza;?></h4></td>
                                    <td><h4><?=$reporte->Fecha;?></td>                                    
                                    <td><h4>$ <?=$reporte->Total_Ingresos;?></h4></td>
                                    <td><h4>$ <?=$reporte->Total_Ventas;?></h4></td>                                                                        
                                    <td><h4>$ <?=$reporte->TPV;?></h4></td>
                                    <td><h4>$ <?=$reporte->Gastos;?></h4></td>                                                                                                      
                                    <td>
                                    <button type="button" onclick="eliminarVenta('<?php echo $reporte->Fecha;?>',<?php echo $reporte->plaza_id;?>)" class="btn btn-danger btn-remove">
                                            <span class="fa fa-remove">
                                            </span></button>
                                    </td>
                                </tr>   
                                <?php endforeach;?>                                                              
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


<div class="modal fade" id="modal-default">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Listado de Ventas</h4>
            </div>
            <div class="modal-body">
            <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_ventas">
                            <thead>
                                <tr>                                    
                                    <th>Nombre</th>                                    
                                    <th>Fecha</th>                                   
                                    <th>Ingresos</th>  
                                    <th>Ventas</th>                                                                    
                                    <th>TPV</th>
                                    <th>Gastos</th>                                                                      
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($reportes)):?>
                                <?php foreach ($reportes as $reporte):?>
                                   <tr>                                    
                                    <td><h4><?=$reporte->Usuario;?></h4></td>                                    
                                    <td><h4><?=$reporte->Fecha;?></h4></td>                                    
                                    <td><h4>$ <?=$reporte->Total_Ingresos;?></h4></td>
                                    <td><h4>$ <?=$reporte->Total_Ventas;?></h4></td>                                                                        
                                    <td><h4>$ <?=$reporte->TPV;?></h4></td>
                                    <td><h4>$ <?=$reporte->Gastos;?></h4></td>                                                                                                 
                                </tr>   
                                <?php endforeach;?>                                                              
                                <?php endif;?>                                
                            </tbody>                            
            </table>                            
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

<script type="text/javascript">  
    //AJAX REQUEST
    function eliminarVenta(fecha,plaza_id){
        
        var parametros = {
                "fecha" : fecha                            
                };  

                swal({
                title: '¿Está seguro?',
                text: "Eliminar Venta del Día",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar',
                cancelButtonText: 'No'
                }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url();?>Ventas/delete",
                        data: parametros, 
                        dataType: "JSON",
                        success: function(data){
                            
                            if(data==1){                                
                                swal({
                                    position: 'top-end',
                                    type: 'success',
                                    title: 'Venta eliminada correctamente!!',
                                    showConfirmButton: false,
                                    timer: 1500
                                    }).then(function() {                                                            
                                    window.location= "<?php echo base_url();?>Ventas/add2";                                               
                                });	  
                            }else if(data==0){
                                swal({
                                    position: 'top-end',
                                    type: 'error',
                                    title: 'Ha ocurrido un error !!',
                                    showConfirmButton: false,
                                    timer: 1500
                                    }).then(function() {                                                            
                                    window.location= "<?php echo base_url();?>Ventas/add2";                                               
                                });	
                            }
                            else if(data==11){                                
                                swal({
                                    position: 'top-end',
                                    type: 'success',
                                    title: 'Venta eliminada correctamente!!',
                                    showConfirmButton: false,
                                    timer: 1500
                                    }).then(function() {                                                            
                                    window.location= "<?php echo base_url();?>Ventas/add2";                                               
                                });	  
                            }else if(data==00){
                                swal({
                                    position: 'top-end',
                                    type: 'error',
                                    title: 'Ha ocurrido un error !!',
                                    showConfirmButton: false,
                                    timer: 1500
                                    }).then(function() {                                                            
                                    window.location= "<?php echo base_url();?>Ventas/add2";                                               
                                });	
                            }
                            else if(data==-1){
                                Swal({
                                type: 'error',
                                title: 'Elimine primeramente el archivo DLC. Después prosiga con la venta',
                                text: 'No se puede eliminar la venta',
                                allowOutsideClick: false,
                                });
                            }
                            
                        },
                        error: function() { alert("Error posting feed."); }
                    });                    
                }                
                });         
    }
</script>







