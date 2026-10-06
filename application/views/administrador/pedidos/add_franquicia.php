<!-- DIV Content-Wrapper -->
<div class="content-wrapper">

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Pedido Franquicia
    <small>Nuevo Pedido</small></h1>
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

         <!-- ERROR EN EL PROCESAMIENTO DEL ARCHIVO -->
         <?php if($this->session->flashdata("error")):?>                                  
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-ban"></i> Alerta!</h4>
            <?php echo $this->session->flashdata("error");?>
        </div>
        <?php endif; ?>
        <!-- /. ERROR EN EL PROCESAMIENTO DEL ARCHIVO -->

        <!-- ERROR EN EL PROCESAMIENTO DEL ARCHIVO -->
        <?php if($this->session->flashdata("message")):?>                                  
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i>Correcto</h4>
            <?php echo $this->session->flashdata("message");?>            
        </div>
        <?php endif; ?>
        
        <!-- /. ERROR EN EL PROCESAMIENTO DEL ARCHIVO -->
        <form action="<?php echo base_url(); ?>Pedidos/storeFranquicia" method="POST" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group">                                                                                                        
                                    <label for="" class="col-md-1 control-label">Fecha:</label>
                                        <div class="col-md-2">
                                            <input type="date" class="form-control" name="fecha" id="fecha" value="<?php echo !empty($fecha) ? $fecha:'';?>">
                                        </div>
                                     
                                        <label for="plaza_id" class="col-md-1 control-label">Plaza:  </label>                           
                                        <div class="col-md-2">
                                        <select name="plaza_id" id="plaza_id" class="form-control" required>                                                  
                                                    <option value="">Seleccionar</option>  
                                                    <?php foreach ($plazas as $plaza):?>                                                      
                                                    <?php if($plaza->id==$plaza_id):?>
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

                                        <label for="categoria_id" class="col-md-1 control-label">Categoría:  </label>                           
                                        <div class="col-md-2">
                                        <select name="categoria_id" id="categoria_id" class="form-control" required >
                                            <option value="">Seleccionar</option>  
                                            <?php if(isset($categorias)):?> 
                                            <?php foreach ($categorias as $categoria):?>  
                                            <?php if($categoria->id==$categoria1):?>
                                            <option value="<?php echo $categoria->id?>" selected>
                                            <?php echo $categoria->Nombre;?>
                                            </option>
                                            <?php else:?>
                                            <option value="<?php echo $categoria->id?>">
                                            <?php echo $categoria->Nombre;?>
                                            </option>
                                            <?php endif;?>
                                            <?php endforeach;?>?>
                                            <?php endif;?>  
                                        </select> 
                                        </div>    

                                        <label for="grupo_id" class="col-md-1 control-label">Insumos:  </label>                           
                                        <div class="col-md-2">
                                        <select name="insumo_id" id="insumo_id" class="form-control" required >
                                            <option value="">Seleccionar</option>  
                                            <?php if(isset($insumos)):?> 
                                            <?php foreach ($insumos as $insumo):?>  
                                            <?php if($insumo->id==$insumo1):?>
                                            <option value="<?php echo $insumo->id?>" selected>
                                            <?php echo $insumo->Nombre;?>
                                            </option>
                                            <?php else:?>
                                            <option value="<?php echo $insumo->id?>">
                                            <?php echo $insumo->Nombre;?>
                                            </option>
                                            <?php endif;?>
                                            <?php endforeach;?>?>
                                            <?php endif;?>  
                                        </select> 
                                        </div>     








                                </div>                
                                <div class="form-group">
                                    <label for="" class="col-md-1 control-label">Cantidad:</label>
                                        <div class="col-md-3">
                                            <input type="number" class="form-control" name="cantidad" id="cantidad" value="" required>                                
                                        </div>                                                                                                                                                                                                                               
                                        <div class="col-md-8">                                                                                
                                        <input type="submit" name="agregar" value="Agregar" class="btn btn-primary">                                                                                        
                                        <button type="button" class="btn btn-danger" onclick="terminarPedidoFranquiciaAdmin()"value=""><span class="fa fa-check"></span> Terminar Pedido</button>   
                                        <button type='button' class="btn btn-success btn-flag" data-toggle="modal" data-target="#modal-default"><span class="glyphicon glyphicon-search" ></span> En curso</button>      
                                        <button type='button' class="btn btn-warning btn-flag" data-toggle="modal" data-target="#modal-default3"><span class="glyphicon glyphicon-search" ></span> Liberados</button>      
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
                                    <th>Plaza</th>
                                    <th>Insumo</th>                                                                         
                                    <th>Cantidad</th> 
                                    <th>Eliminar</th>                                                                                                      
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($pedidos)):?>                           
                                <?php foreach ($pedidos as $pedido):?>
                                <tr>                                                                        
                                    <td><?=$pedido->Fecha;?></td>                                     
                                    <td><?=$pedido->Plaza;?></td>                                                                        
                                    <td><?=$pedido->Insumo;?></td>                                    
                                    <td><?=$pedido->Cantidad;?></td>     
                                    <td>
                                    <button href="javascript:void(0);" onclick="borrarInsumoPedidoPasteleria(<?php echo $pedido->id;?>)" class="btn btn-danger btn-remove">
                                            <span class="fa fa-remove"></span></button>   
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
                <h4 class="modal-title">Listado de Pedidos Franquicia</h4>
            </div>
            <div class="modal-body">
            <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" >
                            <thead>
                                <tr>                                    
                                    <th>Fecha</th> 
                                    <th>Fecha Recepción</th>                                                                                                                                                 
                                    <th>Plaza</th>                                                                                                                                        
                                    <th>Insumos</th>    
                                    <th>Factura</th>
                                    <th>Importe</th>
                                    <th>Estatus</th>   
                                    <th>Ver</th>       
                                    <th>Eliminar</th>                                                                                           
                                </tr>
                            </thead>
                            <tbody>
                            <?php if(!empty($misPedidos)):?>                           
                                <?php foreach ($misPedidos as $pedido):?>
                                <tr>                                                                        
                                    <td><?=$pedido->Fecha;?></td>                                     
                                    <td><?=$pedido->Fecha_Recepcion;?></td>                                                                        
                                    <td><?=$pedido->Plaza;?></td>                                    
                                    <td><?=$pedido->Cantidad;?></td>
                                    <td><?=$pedido->Factura;?></td>                                                                        
                                    <td>$<?=number_format($pedido->Importe);?></td>                                          
                                    <?php if($pedido->Estatus==0):?>     
                                        <td>Pendiente</td>                                                                                                                                                                                                                
                                    <?php else:?>     
                                        <td>Listo</td>                                                                                                                                                                                                                
                                    <?php endif;?>                                                              
                                    <th>
                                    <button type="button" class="btn btn-info" onclick="verPedidoPasteleria('<?php echo $pedido->Fecha;?>',<?php echo $pedido->plaza_id;?>)" data-toggle="modal" data-target="#modal-default2" value="">
                                            <span class="fa fa-search"></span>
                                        </button>
                                    </th>
                                    <th>                                    
                                    <?php if($pedido->Estatus==0):?>
                                        <a href="javascript:void(0);" onclick="borrarPasteleria('<?php echo $pedido->Fecha;?>',<?php echo $pedido->plaza_id;?>)" class="btn btn-danger btn-remove">
                                            <span class="fa fa-remove">
                                        </span></a>                                    
                                    <?php endif;?>                                                                           
                                    </th>
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

<div class="modal fade" id="modal-default3">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Listado de Pedidos Liberados</h4>
            </div>
            <div class="modal-body">
            <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" >
                            <thead>
                                <tr>                                    
                                    <th>Fecha</th> 
                                    <th>Fecha Recepción</th>                                                                                                                                                 
                                    <th>Plaza</th>                                                                                                                                        
                                    <th>Insumos</th>    
                                    <th>Factura</th>
                                    <th>Importe</th>                                    
                                    <th>Ver</th>                                        
                                </tr>
                            </thead>
                            <tbody>
                            <?php if(!empty($liberados)):?>                           
                                <?php foreach ($liberados as $pedido):?>
                                <tr>                                                                        
                                    <td><?=$pedido->Fecha;?></td>                                     
                                    <td><?=$pedido->Fecha_Recepcion;?></td>                                                                        
                                    <td><?=$pedido->Plaza;?></td>                                    
                                    <td><?=$pedido->Insumos;?></td>
                                    <td><?=$pedido->Factura;?></td>                                                                        
                                    <td>$<?=number_format($pedido->Importe);?></td>                                                                                                                                        
                                    <th>
                                    <button type="button" class="btn btn-info" onclick="verPedidoPasteleria('<?php echo $pedido->Fecha;?>',<?php echo $pedido->plaza_id;?>)" data-toggle="modal" data-target="#modal-default2" value="">
                                            <span class="fa fa-search"></span>
                                        </button>
                                    </th>                                   
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

<div class="modal fade" id="modal-default2">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Pedido #: 454563234</h4>
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
    function borrarPasteleria(fecha,plaza_id){
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
                        window.location = url+"Pedidos/deletePasteleria/"+fecha+"/"+plaza_id;                          
                    }
                    });         
    }

    //NO REQUEST
    function eliminarPedido(fecha,plaza_id,id){    
    
        var parametros = {
        "fecha" : fecha,
        "plaza_id" : plaza_id,
        "id_pedido" : id                
        };
                    

        swal({
            title: '¿Está Seguro?',
            text: "Desea elminar el pedido!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si,eliminar !'
            }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>Pedidos/eliminarPedidoAjax",
                    data: parametros,
                    success: function(data){                            
                     //alert(data);
                    if(data==1)
                    {
                        swal({
                            position: 'top-end',
                            type: 'success',
                            title: 'Pedido eliminado!!!',
                            showConfirmButton: false,
                            timer: 1500
                            }).then(function() {                                                            
                                location.reload();
                        });		                        
                    }
                    else if(data==0)
                    {
                       swal({
                                position: 'top-end',
                                type: 'error',
                                title: 'Pedido no eliminado!!',
                                showConfirmButton: false,
                                timer: 1500
                                }).then(function() {                                                            
                                //location.reload();                                             
                        });	
                    }               
                    else
                    {
                        swal({
                                position: 'top-end',
                                type: 'error',
                                title: 'Error desconocido. Contacte al administrador!!',
                                showConfirmButton: false,
                                timer: 1500
                                }).then(function() {                                                            
                                //location.reload();                                             
                            });	
                    }                                 
                },error: function() {                         
                    
                    swal({
                    position: 'top-end',
                    type: 'error',
                    title: 'Error FEED desconocido !!!',
                    showConfirmButton: false,
                    timer: 1500
                    }).then(function() {                                                            
                    //location.reload();                                             
                    });  
                    
                    }
            });                    
            }
            else{                                     
            }
            });                  
    } 

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

    function borrarInsumoPedidoPasteleria(code){
        swal({
                title: '¿Está seguro que desea eliminar el insumo',
                text: "Confirmar eliminación",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar',
                cancelButtonText: 'No, mantener'
                }).then((result) => {
                if (result.value) {                    
                    var parametros = {                        
                        "code" : code                      
                    };                                                       
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url();?>Pedidos/eliminarInsumoFranquicia",
                        data: parametros,                          
                        success: function(data){                                                                         
                        if(data==1)
                        {
                            swal({
                                position: 'top-end',
                                type: 'success',
                                title: 'Insumo Eliminado!!',
                                showConfirmButton: false,
                                timer: 1500
                                }).then(function() {                                                            
                                window.location= "<?php echo base_url();?>Pedidos/addFranquicia";                                               
                            });	                        
                        }
                        else if(data==0)
                        {
                            swal({
                                    position: 'top-end',
                                    type: 'error',
                                    title: 'Insumo no eliminado!!',
                                    showConfirmButton: false,
                                    timer: 1500
                                    }).then(function() {                                                            
                                    window.location= "<?php echo base_url();?>Pedidos/addFranquicia";                                               
                                });	
                        }               
                        else
                        {
                            alert("Error desconocido");
                        } 
                        },
                        error: function() { alert("No quedo 4."); }
                    });                    
                }                
                }); 
    }

    function terminarPedidoFranquiciaAdmin(){
        swal({
                title: '¿Está seguro que desea terminar el pedido?',
                text: "Pedido para franquicia",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, liberar',
                cancelButtonText: 'No, mantener'
                }).then((result) => {
                if (result.value) {                             
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url();?>Pedidos/terminarPedidoFranquicia",                                                                
                        success: function(data){  
                                                       
                            if(data==1){
                            swal({
                                position: 'top-end',
                                type: 'success',
                                title: 'Pedido Franquicia agregado!!',
                                showConfirmButton: false,
                                timer: 1500
                                }).then(function() {                                                            
                                window.location= "<?php echo base_url();?>Pedidos/addFranquicia";                                               
                            });	
                            }
                            else if(data==0){
                            swal({
                                position: 'top-end',
                                type: 'error',
                                title: 'Ha ocurrido un error al liberar el pedido!!',
                                showConfirmButton: false,
                                timer: 1500
                                }).then(function() {                                                            
                                window.location= "<?php echo base_url();?>Pedidos/addFranquicia";                                               
                            });	
                            }
                            else if(data==2){
                            swal({
                                position: 'top-end',
                                type: 'error',
                                title: 'El pedido esta vacio!!',
                                showConfirmButton: false,
                                timer: 1500
                                });
                            }
                            else{
                                alert("Error desconocido");
                            }                                                                   
                        },
                        error: function() { alert("Error posting feed"); }
                    });                    
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

</script>











