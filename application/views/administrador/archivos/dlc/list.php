<!-- DIV Content-Wrapper -->
<div class="content-wrapper">

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Archivos DLC enviados<small>Listado</small></h1>
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
                            <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_inventario" >
                            <thead>
                                <tr>
                                    <th>Archivo</th>   
                                    <th>Plaza</th>
                                    <th>Usuario</th>
                                    <th>Fecha</th>                                                                 
                                    <th>Estatus</th>                                        
                                    <th>Eliminar</th>     
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($platillos)):?>                                
                                <?php foreach ($platillos as $platillo):?>                            
                            <tr>                                          
                                <td><h4>DLC</h4></td>                                                                                                 
                                <td><h4><?=$platillo->Plaza;?></h4></td>  
                                <td><h4><?=$platillo->Usuario;?></h4></td>  
                                <td><h4><?=$platillo->Fecha;?></h4></td>                                  
                                <?php if($platillo->Estatus==1):?>                                
                                <td><h4>Correcto</h4></td>   
                                <?php else:?>                                                                                                                                                                                                                                               
                                <td><h4>Error en DLC</h4></td>   
                                <?php endif;?>                                    
                                <td>
                                    <button class="btn btn-danger btn-remove" onclick="eliminarDLC('<?php echo $platillo->Fecha;?>',<?php echo $platillo->plaza_id;?>,'DLC')">
                                            <span class="fa fa-remove">
                                            </span>
                                    </button>
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



<script type="text/javascript">  
    //AJAX REQUEST
    function eliminarDLC(fecha,plaza_id,concepto){
        alert("Restaurando");
    }
</script>






