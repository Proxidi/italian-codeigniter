<!-- DIV Content-Wrapper -->
<div class="content-wrapper">

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Historial de Pedidos
    <small>Nuevo Pedido</small></h1>
    <a href="<?php echo base_url();?>Pedidos/manager" class="small-box-footer">Volver al Panel de Pedidos <i class="fa fa-arrow-circle-right"></i></a>                
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
                            <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_inventario">
                            <thead>
                                <tr>                                                                        
                                    <th>Fecha</th>
                                    <th>Plaza</th> 
                                    <th>1°Fact</th>
                                    <th>1°Imp</th>
                                    <th>2°Fact</th>
                                    <th>2°Imp</th>
                                    <th>3°Fact</th>
                                    <th>3°Imp</th>
                                    <th>4°Fact</th>
                                    <th>4°Imp</th>
                                    <th># Insumos</th> 
                                    <th>Detalles</th>                                                                     
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($detalles)):?>                           
                                <?php foreach ($detalles as $detalle):?>
                                <tr>                                                                        
                                    <td><?=$detalle->Fecha;?></td>                                 
                                    <td><?=$detalle->Plaza;?></td>   
                                    <td><?=$detalle->Factura;?></td>  
                                    <td>$<?=number_format($detalle->Importe,2);?></td>                                    
                                    <td><?php                                    
                                    if($detalle->Factura2==null || $detalle->Factura2==0){
                                        echo "NO";
                                    }else{
                                        echo $detalle->Factura2;
                                    }
                                    ?>
                                    </td>                                      
                                    <td>                                    
                                    <?php
                                        if($detalle->Importe2==null || $detalle->Importe2==0){
                                            echo "NO";
                                        }else{
                                            echo "$".number_format($detalle->Importe2,2);
                                        }                                        
                                        ?>
                                    
                                    </td>
                                    
                                    <td><?php
                                    if($detalle->Factura3==null || $detalle->Factura3==0){
                                        echo "NO";
                                    }else{
                                        echo $detalle->Factura3;
                                    }                                                                        
                                    ?></td>  
                                    <td><?php
                                        if($detalle->Importe3==null || $detalle->Importe3==0){
                                            echo "NO";
                                        }else{
                                            echo "$".number_format($detalle->Importe3,2);
                                        }                                        
                                        ?>
                                    </td>
                                    <td><?php
                                     if($detalle->Factura4==null || $detalle->Factura4==0){
                                        echo "NO";
                                    }else{
                                        echo $detalle->Factura4;
                                    }                                                                          
                                    ?></td>  
                                    <td>
                                    <?php
                                        if($detalle->Importe4==null || $detalle->Importe4==0){
                                            echo "NO";
                                        }else{
                                            echo "$".number_format($detalle->Importe4,2);
                                        }                                        
                                        ?>
                                    
                                    </td>                                                                   
                                    <td><?=$detalle->Cantidad;?></td>                                   
                                    <td> 
                                        <button type="button" class="btn btn-info" onclick="hola2('<?php echo $detalle->Fecha;?>',<?php echo $detalle->plaza_id;?>)" data-toggle="modal" data-target="#modal-default" value="">
                                            <span class="fa fa-search"></span>
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


<div class="modal fade" id="modal-default">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Pedido #: 454563234</h4>
            </div>
            <div class="modal-body">
            <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" >
                            <thead>
                                <tr>                                                                                                                                                                                                                
                                    <th>Plaza</th>                                                                                                                                        
                                    <th>Nombre</th>    
                                    <th>Cantidad Ordenada</th>
                                    <th>Cantidad Recibida</th>                                                                                      
                                </tr>
                            </thead>
                            <tbody id="pedido">                     
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
    function hola2(fecha,plaza_id){
        
        var parametros = {
                "fecha" : fecha,    
                "plaza_id" : plaza_id                
                };    

                $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>Pedidos/consultarPedidoManager",
                data: parametros,                                               
                success: function(response){                 
                    $('#pedido').html(response);                                                                                                                     
                },
                error: function() { 
                    alert("Error posting feed.");
                }
            });
                
    }
</script>





