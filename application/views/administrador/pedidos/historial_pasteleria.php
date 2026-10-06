<!-- DIV Content-Wrapper -->
<div class="content-wrapper">

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Historial de Pedidos Pasteleria
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

    <!-- DIV ROW -->                         
    <div class="row">

        <!-- DIV COL-MD-12 -->
        <div class="col-md-12">
        <form action="<?php echo current_url();?>" method="POST" class="form-horizontal">
                                <div class="form-group">                                                                                                        
                                    <label for="plaza_id" class="col-md-1 control-label">Plaza:</label>
                                        <div class="col-md-2">
                                            <select name="plaza_id" id="plaza_id" class="form-control">                                                  
                                            <?php foreach ($plazas as $plaza):?>  
                                            <?php if($plaza->id==1):?>
                                            <option value="" selected>
                                                Todas las Plazas
                                            </option>
                                            <?php endif;?>
                                            <?php if($plaza->id==$id):?>
                                            <option value="<?php echo $plaza->id?>" selected>
                                            <?php echo $plaza->Nombre;?>
                                            </option>
                                            <?php else:?>
                                            <option value="<?php echo $plaza->id?>">
                                            <?php echo $plaza->Nombre;?>
                                            </option>
                                            <?php endif;?>
                                            <?php endforeach;?>?>
                                            </select>                                                                                
                                        </div>     
                                        
                                        <!--COMBOBOX AÑOS-->
                                            <label for="anio_id" class="col-md-1 control-label">Año:</label>
                                            <div class="col-md-2">
                                            <select name="anio_id" id="anio_id" class="form-control" required>                                                  
                                            <option value="" selected>Seleccionar Año</option>
                                                    <?php foreach ($years as $year):?>                                                                                                                                                                  
                                                        <?php if($year->Nombre==$year_id):?>
                                                        <option value="<?php echo $year->Nombre?>" selected>
                                                        <?php echo $year->Nombre;?>
                                                        </option>
                                                    <?php else:?>
                                                    <option value="<?php echo $year->Nombre?>">
                                                        <?php echo $year->Nombre;?>
                                                    </option>
                                                    <?php endif;?>
                                                        <?php endforeach;?>
                                                    </select>                                    
                                            </div>
                                        <!--./ COMBOBOX AÑOS-->

                                        <!--COMBOBOX MESES-->
                                        <label for="" class="col-md-1 control-label">Mes:</label>
                                        <div class="col-md-2">
                                        <select name="mes_id" id="mes_id" class="form-control" >                                                  
                                                <?php foreach ($meses as $mes):?>  
                                                <?php if($mes->id==1):?>
                                                <option value="" selected>
                                                    Seleccionar Mes
                                                    </option>
                                                <?php endif;?>
                                                    <?php if($mes->id==$mes_id):?>
                                                    <option value="<?php echo $mes->id?>" selected>
                                                    <?php echo $mes->Nombre;?>
                                                    </option>
                                                <?php else:?>
                                                <option value="<?php echo $mes->id?>">
                                                    <?php echo $mes->Nombre;?>
                                                </option>
                                                <?php endif;?>
                                                    <?php endforeach;?>?>
                                                </select>                                    
                                        </div>
                                        <!--./ COMBOBOX MESES-->    
                                                                    
                                    <label for="" class="col-md-1 control-label">Opciones:</label>                                       
                                    <div class="col-md-2">                                        
                                        <input type="submit" name="buscar" value="Buscar" class="btn btn-primary">                                                                                                                                                             
                                    </div>                                                                                            
                                </div>                
                                
                            </form>             
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
                                    <th>Fecha Recepción</th>                                                                                                                                                 
                                    <th>Plaza</th>                                                                                                                                        
                                    <th>Insumos</th>    
                                    <th>Factura</th>
                                    <th>Importe</th>                                    
                                    <th>Ver</th>    
                                    <th>Eliminar</th>                                                                                                 
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($detalles)):
                                $acImporte1=0;                         
                                $acFila=0;
                                ?>  

                                <?php foreach ($detalles as $detalle):
                                $acImporte1=$acImporte1+$detalle->Importe;             
                                $acFila=
                                        $detalle->Importe;                                                         
                                ?>
                                <tr>                                                                        
                                    <td><?=$detalle->Fecha;?></td>     
                                    <td><?=$detalle->Fecha_Recepcion;?></td>                                 
                                    <td><?=$detalle->Acronimo;?></td>  
                                    <td><?=$detalle->Insumos;?></td> 
                                    <td><?=$detalle->Factura;?></td>  
                                    
                                    <td>$<?=number_format($detalle->Importe,2);?></td>                                    
                                    
                                    <td>
                                        <button type="button" class="btn btn-info" onclick="verPedidoPasteleria('<?php echo $detalle->Fecha;?>',<?php echo $detalle->plaza_id;?>)" data-toggle="modal" data-target="#modal-default2" value="">
                                            <span class="fa fa-search"></span>
                                        </button>
                                    </td>       
                                    <td>
                                        <button type="button" class="btn btn-danger" onclick="borrarPasteleria2('<?php echo $detalle->Fecha;?>',<?php echo $detalle->plaza_id;?>)" >
                                            <span class="fa fa-remove"></span>
                                        </button>
                                    </td>                         
                                </tr>   
                                <?php endforeach;?>       
                                <?php $acFila=$acImporte1?>
                                <tr>
                                <td bgcolor="#76c5ff"><b>TOTALES</b></td>
                                <td bgcolor="#76c5ff"></td>
                                <td bgcolor="#76c5ff"></td>
                                <td bgcolor="#76c5ff"></td>                                
                                <td bgcolor="#76c5ff"></td>                                
                                <td bgcolor="#d1ffaf"><b>$<?php echo number_format($acFila,2);?></b></td>
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

<div class="modal fade" id="modal-default2">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Pedido de Pasteleria</h4>
            </div>
            <div class="modal-body">
            <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_pedido_pasteleria">
                            <thead>
                                <tr>                                                                                                                                                                                                                
                                    <th>Fecha</th> 
                                    <th>Plaza</th>   
                                    <th>Anotación</th>                                                                                                                                              
                                    <th>Insumo</th>                                                                                                                                                                            
                                    <th>Cantidad</th>
                                    <th>Manager</th>                                                                                                                     
                                    <th>Final</th>                                    
                                </tr>
                            </thead>
                            <tbody>                     
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
     //NO REQUEST
    function borrarPasteleria2(fecha,plaza_id)
    {
        var url="<?php echo base_url();?>";              
        swal({
                    title: '¿Está seguro?',
                    text: "Desea elminar el pedido!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si , eliminalo!',
                    cancelButtonText: 'No, aún no!',
                    }).then((result) => {
                    if (result.value) {
                        window.location = url+"Pedidos/deletePasteleria2/"+fecha+"/"+plaza_id;                          
                    }
                    });         
    }

     var consultarPedidoPasteleria= $('#tbl_pedido_pasteleria').DataTable({
        "aaSorting": [],
        dom: 'Bfrtip',
        "pageLength": 30,
        buttons: [
            {
                extend: 'excelHtml5',
                title: "Pedido Pasteleria",
                exportOptions: {
                    columns: ':visible'
                },
            },
            {
                extend: 'pdfHtml5',
                title: "Pedido Pasteleria",
                exportOptions: {
                    columns: ':visible'
                }
                
            }
        ],
        "language": {
            "lengthMenu": "Mostrar _MENU_ registros por pagina",
            "zeroRecords": "No se encontraron resultados en su busqueda",
            "searchPlaceholder": "Buscar registros",
            "info": "Mostrando registros de _START_ al _END_ de un total de  _TOTAL_ registros",
            "infoEmpty": "No existen registros",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "search": "Buscar:",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            },
        },
        responsive: true
    });

     //AJAX REQUEST
     function verPedidoPasteleria(fecha,plaza_id){
        
        var parametros = {
                "fecha" : fecha,    
                "plaza_id" : plaza_id                
                };             

                $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>Pedidos/consultarPedidoPasteleria",
                data: parametros,              
                dataType: "JSON",                                 
                success: function(response){  
                    
                    consultarPedidoPasteleria.clear();                       
                    var len = response.length;     
                    var nota="";                   
                    for(var i=0; i<len; i++){

                        var fecha = response[i].Fecha;                        
                        var plaza=response[i].Plaza;  
                        var insumo=response[i].Insumo;                        
                        var cantidad=response[i].Cantidad;
                        var cantidad_recibida=response[i].Cantidad_Recibida;
                        var cantidad_final=response[i].Cantidad_Final;    
                        var bandera=response[i].Bandera;    
                        
                        
                        if(bandera==1){
                            if(cantidad==cantidad_recibida){
                                nota="MISMA CANTIDAD";
                            }
                            else if(cantidad>cantidad_recibida)
                            {
                                    nota="CAPTURA MENOR A PEDIDO";
                            }else if(cantidad<cantidad_recibida)
                            {
                                    nota="CAPTURA MENOR A PEDIDO";
                            }
                        }
                        else if(bandera==2){   
                                nota="NO LLEGO";

                        }
                        else{
                                nota="NO REVISADO";
                        }                          
                        consultarPedidoPasteleria.row.add([fecha,plaza,nota,insumo,cantidad,cantidad_recibida,cantidad_final]);                    
                    }                    
                    consultarPedidoPasteleria.draw();                                                
                },
                error: function() { 
                    alert("Error posting feed.");
                }
            });          
    } 
</script>



