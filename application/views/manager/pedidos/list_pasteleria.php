<!-- DIV Content-Wrapper -->
<div class="content-wrapper">

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Pedidos de Pasteleria Plaza <?php echo $this->session->userdata('plaza_nombre')?>
    <small>Pedidos de Pasteleria</small></h1>
    <a href="<?php echo base_url();?>Pedidos/manager" class="small-box-footer">Volver al Panel de Pedidos <i class="fa fa-arrow-circle-right"></i></a>                
</section>
<!-- /.Content Header (Page header) -->

<!-- Main content -->
<section class="content">

<!-- Default box box-solid -->
<div class="box box-solid">

<!-- Default box box-body -->
<?php if($estado==0):?>                           
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

        <!-- FORMULARIO -->
        <form action="<?php echo base_url();?>Pedidos/storeFacturaPasteleria" method="POST" enctype="multipart/form-data" class="form-horizontal">        

        <input type="hidden" value="<?php echo $fecha ?>" name="fechaIngreso">                          
        <?php if($capturar==0):?>  
        <h3>Usted tiene un nuevo pedido de pasteleria el día: <?php echo $fecha?></h3>
        <h5>Capture los datos requeridos y posteriormente verifique que los datos del pedido sean correctos</h5>        

              <!-- DIV FORM GROUP -->
            <div class="form-group <?php echo !empty(form_error("fecha"))? 'has-error':'' ?>" value="<?php echo set_value("fecha");?>" required>
                <!-- DIV COL-MD-4 -->
                        <div class="col-md-4">
                                <label for="fechaRecepcion">Fecha de Recepción:</label>
                                <input type="date" class="form-control" id="fechaRecepcion"  name="fechaRecepcion" required>
                                <?php echo form_error("fecha","<span class='help-lock'>","</span>")?>
                            </div>
                            <!-- /. DIV COL-MD-4 -->                                                                                   
                <!-- /. DIV FORM GROUP -->                      
            </div>  

            <div class="form-group">            
                <!-- DIV COL-MD-4 -->
                <div class="col-md-4">
                    <label for="factura">Factura: </label>
                    <input type="number" step="any" min="0" class="form-control" id="factura" name="factura" value="<?php echo set_value("factura");?>" required>
                    <?php echo form_error("factura","<span class='help-lock'>","</span>")?>
                </div> 
                <!-- /. DIV COL-MD-4 -->

                <!-- DIV COL-MD-4 -->
                <div class="col-md-4">
                    <label for="importe">Importe: </label>
                    <input type="number" step="any" min="0" class="form-control" id="importe" name="importe" value="<?php echo set_value("importe");?>" required>
                    <?php echo form_error("importe","<span class='help-lock'>","</span>")?>
                </div> 
                <!-- /. DIV COL-MD-4 -->  
            </div>
                              
            <?php endif;?>                    
            
            <!-- DIV FORM GROUP -->              
            <div class="form-group">
                <!-- DIV COL-MD-12 --> 
                <div class="col-md-12">
                    
                    <?php if($capturar==0):?>                          
                        <input type="submit" name="guardar" value="Guardar" class="btn btn-success">
                    <?php endif;?> 

                    <?php if($capturar==1):?>  
                            <button class="btn btn-warning" type="button" data-toggle="modal" data-target="#modal-default" >Datos de la factura <span class="fa fa-search"></span></button>                                                
                            <input type="submit" name="editar" value="Editar Datos" class="btn btn-primary">                                                                            
                            <button type='button' class="btn btn-success btn-flag" onclick="liberarPedidoManagerPasteleria('<?php echo $fecha?>',<?php echo $this->session->userdata('plaza')?>)"><span class="glyphicon glyphicon-ok"></span> Liberar Pedido</button>                                                                                                          
                        <h3>Insumos restantes por checar: <span id="restantes"><?php echo $numero ?></span></h3>                          
                    <?php endif;?>        

                </div> 
                <!-- /.DIV COL-MD-12 -->    
            </div>
            <!-- /. DIV FORM GROUP -->  
        </form>
        <!-- FORMULARIO -->

    </div>   
    <!-- /.DIV COL-MD-12 -->       
</div>                    
<!-- /.DIV ROW --> 
<div class="row">
                        <div class="col-md-12">
                        <?php if($capturar==1):?>  
                        <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_pedidos_manager" >
                        <thead>
                            <tr>                                                                        
                                <th>Fecha</th>
                                <th>Plaza</th>                                     
                                <th>Nombre</th>
                                <th>Unidad</th>                                                                     
                                <th>C. Ordenada</th>                                 
                                <th>C. Recibida</th>  
                                <th>Correcto</th>                                 
                                <th>Cambiar</th>                                 
                                <th>No Recibido</th>                                 
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($pedidos)):?>                           
                            <?php foreach ($pedidos as $pedido):?>
                            <?php if($pedido->Bandera==1):?>
                            <tr bgcolor="#99ddff">  
                            <?php elseif($pedido->Bandera==2):?>
                            <tr bgcolor="#ff0000">  
                            <?php else:?>
                            <tr>  
                            <?php endif;?>                                                                                              
                                <td><?=$pedido->Fecha;?></td>                                 
                                <td><?=$pedido->Plaza;?></td>                                                                                                            
                                <td><?=$pedido->Nombre;?></td>
                                <td><?=$pedido->Unidad;?></td>
                                <td><?=$pedido->Cantidad;?></td>                                   
                                <td><?=$pedido->Cantidad_Final;?></td>
                                <td> 
                                    <button type="button" class="btn btn-success " onclick="cuadrarPedidoPasteleria('<?php echo $pedido->Fecha;?>',<?php echo $pedido->plaza_id;?>,<?php echo $pedido->insumo_id;?>,<?php echo $pedido->Cantidad;?>)" >
                                        <span class="fa fa-check"></span>
                                    </button>
                                </td>                                    
                                <td> 
                                    <button type="button" class="btn btn-info" onclick="asignarValoresModalPedidoPasteleria('<?php echo $pedido->Nombre;?>',<?php echo $pedido->Cantidad;?>,<?php echo $pedido->Cantidad_Final;?>,'<?php echo $pedido->Unidad;?>',<?php echo $pedido->insumo_id;?>,'<?php echo $pedido->Fecha;?>',<?php echo $pedido->plaza_id;?>)"  data-toggle="modal" data-target="#editarCantidadRecibida" value="">
                                        <span class="fa fa-edit"></span>
                                    </button>
                                </td>                                                                                                     
                                <td> <button type="button" class="btn btn-danger" onclick="noRecibidoPasteleria('<?php echo $pedido->Fecha;?>',<?php echo $pedido->plaza_id;?>,<?php echo $pedido->insumo_id;?>)">
                                        <span class="fa fa-remove">
                                        </span></button>
                                </td>

                            </tr>   
                            <?php endforeach;?>                                                              
                            <?php endif;?>                                
                        </tbody>                            
                        </table>
                        <?php endif;?> 
                        
                        <?php if($capturar==1):?>  
                         <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_pedidos_manager_hide" >
                        <thead>
                            <tr>                                    
                                <th>Fecha</th>
                                <th>Plaza</th>                                     
                                <th>Nombre</th>
                                <th>Unidad</th>                                                                     
                                <th>C. Ordenada</th>                                 
                                <th>C. Recibida</th>  
                                <th>Correcto</th>                                 
                                <th>Cambiar</th>                                 
                                <th>No Recibido</th>                                                                                                                                                                                                                                                        
                            </tr>
                        </thead>
                        <tbody id="tbodyPedidoManager">
                                                        
                        </tbody>
                        
                        </table>
                        <?php endif;?> 
                        </div>
                     </div>      
                        </div>
                                <?php elseif($estado==1):?>
                                <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                            <h1>No hay pedidos por el momento</h1>
                            </div>
                         </div>
                         <hr>
                         <div class="row">
                         <div class="col-md-12"> 
                                                                        
                         </div>
                          <!-- /.row -->    
                    </div>      
                                <?php else:?>  
                                                              
                                <?php endif;?>


<!-- /. Default box box-body -->

</div>
<!-- /. Default box box-solid -->

</section>
<!-- /.content -->

</div>
<!-- /.content-wrapper -->

<div class="modal fade" id="editarCantidadRecibida">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Mi Inventario</h4>
            </div>            
            <div class="modal-body">
            <form class="form-horizontal" method="post" id="guardarCapturaPedidoPasteleria" name="guardarCapturaPedidoPasteleria">
            
            <input type="hidden" value="" name="fecha" id="fecha">

            <input type="hidden" value="" name="plaza_id" id="plaza_id"> 
           
            <input type="hidden" value="" name="insumo_id" id="insumo_id">
               

              <div class="form-group" required>
				<label for="nombre" class="col-sm-3 control-label">Nombre: </label>
                <div class="col-sm-8">     
                    <input type="text" class="form-control"step="0.001" id="nombre" placeholder="" name="nombre" value="Mezcla Espresso" required readonly>                                                                          
                </div>				
              </div>


              <div class="form-group" required>
				<label for="cantidadOrdenada" class="col-sm-3 control-label">Cantidad Ordenada: </label>
                <div class="col-sm-8">     
                    <input type="text" class="form-control"step="0.001" lang="en"  id="cantidadOrdenada" placeholder="" name="cantidadOrdenada" value="" readonly>                                                                          
                </div>				
              </div>

               <div class="form-group" required>
				<label for="unidadOrdenada" class="col-sm-3 control-label">Unidad: </label>
                <div class="col-sm-8">     
                    <select name="unidadBodega" id="unidadOrdenada" class="form-control" readonly>                    
                        </select>
                                              
                </div>				
              </div>


              <div class="form-group" required>
				<label for="cantidadRecibida" class="col-sm-3 control-label">Cantidad Recibida: </label>
                <div class="col-sm-8">     
                    <input type="number" class="form-control"step="0.001" id="cantidadRecibida" lang="en" placeholder="" name="cantidadRecibida" value="" required>                                                                          
                </div>				
              </div>


               <div class="form-group" required>
				<label for="unidadRecibida" class="col-sm-3 control-label">Unidad:</label>
                <div class="col-sm-8">     
                    <select name="unidadRecibida" id="unidadRecibida" class="form-control" readonly>                       
                        </select>                                              
                </div>				
              </div>

                   
            </div>
            <div class="modal-footer">
			    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			    <button type="submit" class="btn btn-primary" id="guardar_captura_pedido">Guardar datos</button>
		    </div>
            </form>
        
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

   
<div class="modal fade" id="modal-default">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Mi Pedido</h4>
            </div>
            <div class="modal-body">
            <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_ventas">
                            <thead>
                                <tr>                                                                                                       
                                    <th>Fecha de Recepción</th>         
                                    <th>Plaza</th>                          
                                    <th>Factura</th>                                                                                                               
                                    <th>Importe</th>                                       
                                    <th># Insumos</th>                                                                                                                                                                                                          
                                </tr>
                            </thead>
                            <tbody>
                            <?php if(!empty($miPedido)):?>
                                <?php foreach ($miPedido as $pedido):?>
                                   <tr>                                    
                                    <td><h4><?=$pedido->Fecha_Recepcion;?></h4></td>                                                                                         
                                    <td><h4><?=$pedido->Plaza;?></h4></td>
                                    <td><h4><?=$pedido->Factura;?></h4></td>                                         
                                    <td><h4><?=$pedido->Importe;?></h4></td>                                      
                                    <td><h4><?=$pedido->Insumos;?></h4></td>                                                                                                                                                   
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



//#region ACTUALIZACIÓN DEL PEDIDO
    $( "#guardarCapturaPedidoPasteleria" ).submit(function( event ) {
            //$('#guardar_captura_inventario').attr("disabled", true);               
            var parametros = $(this).serialize();
            $('#restantes').html("");
                //alert(parametros);
                $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>Pedidos/actualizarPedidoPasteleria",
                data: parametros,
                dataType: 'JSON',
                success: function(response){ 
                    var len = response.length;
                for(var i=0; i<len; i++){
                        var numero  = response[i].numero;
                        var tabla = response[i].tabla;            
                        }

                        if(numero==0){
                            $("#liberar").show();                      
                        }
                
                $('#tbl_pedidos_manager').remove();
                $("#tbl_pedidos_manager_hide").show();                
                $('#tbodyPedidoManager').html(tabla); 
                $('#restantes').html(numero); 
                $('#editarCantidadRecibida').modal('hide');
                                                                                            
                },
                error: function() { 
                    alert("Error posting feed.");
                }
            });
            event.preventDefault();
        });
//#endregion


  //AJAX REQUEST
  function cuadrarPedidoPasteleria(fecha,plaza_id,insumo_id,cantidad){   
        var parametros = {
                "fecha" : fecha,    
                "plaza_id" : plaza_id,
                "insumo_id" : insumo_id,
                "cantidad" : cantidad                
                };  

        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>Pedidos/cuadrarPedidoPasteleria",
            data: parametros, 
            dataType: "JSON",
            success: function(response){
                var len = response.length;
                for(var i=0; i<len; i++){
                        var numero  = response[i].numero;
                        var tabla = response[i].tabla;            
                        }

                        if(numero==0){
                            $("#liberar").show();                      
                        }
                
                $('#tbl_pedidos_manager').remove();
                $("#tbl_pedidos_manager_hide").show();                
                $('#tbodyPedidoManager').html(tabla); 
                $('#restantes').html(numero); 
            },
            error: function() { alert("Error posting feed3."); }
        });                    
    }

    //AJAX REQUEST
    function noRecibidoPasteleria(fecha,plaza_id,insumo_id){
        var parametros = {
                "fecha" : fecha,    
                "plaza_id" : plaza_id,
                "insumo_id" : insumo_id          
                };  

        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>Pedidos/noRecibidoPasteleria",
            data: parametros, 
            dataType: "JSON",
            success: function(response){
                var len = response.length;
                for(var i=0; i<len; i++){
                        var numero  = response[i].numero;
                        var tabla = response[i].tabla;            
                        }

                        if(numero==0){
                            $("#liberar").show();                      
                        }
                
                $('#tbl_pedidos_manager').remove();
                $("#tbl_pedidos_manager_hide").show();                
                $('#tbodyPedidoManager').html(tabla); 
                $('#restantes').html(numero); 
            },
            error: function() { alert("Error posting feed."); }
        });     
    }


    function asignarValoresModalPedidoPasteleria(nombre,cantidad_pedido,cantidad_inventario,unidad,insumo_id,fecha,plaza_id){            
        $("#unidadOrdenada").empty();
        $("#unidadRecibida").empty();                    
        $('#nombre').val(nombre);          
        $('#cantidadOrdenada').val(cantidad_pedido);  
        $('#cantidadRecibida').val(cantidad_inventario); 
        $('#insumo_id').val(insumo_id);
        $('#fecha').val(fecha);   
        $('#plaza_id').val(plaza_id);

        var option = new Option(unidad, unidad); 
        $('#unidadOrdenada').append($(option));
        var option = new Option(unidad, unidad); 
        $('#unidadRecibida').append($(option));                          
    }


      //AJAX REQUEST
      function liberarPedidoManagerPasteleria(fecha,plaza_id){
        var parametros = {
                "fecha" : fecha,    
                "plaza_id" : plaza_id         
                };  
         swal({
            title: '¿Está seguro que desea liberar el pedido?',
            text: "Recomendamos un ultimo análisis para detectar errores!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'No'
            }).then((result) => {
            if (result.value) {
            $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>Inventario/liberarPedidoPasteleriaInventario",
            data: parametros,
            success: function(data){                
                if(data==1){
                    swal({
                        position: 'top-end',
                        type: 'success',
                        title: 'Pedido de Pasteleria liberado correctamente. Inventario Actualizado!!',
                        showConfirmButton: false,
                        timer: 1500
                        }).then(function() {                                                            
                        window.location= "<?php echo base_url();?>Pedidos/listManagerPasteleria";                                               
                    });	  
                }
                else if(data==2){
                    swal({
                        position: 'top-end',
                        type: 'info',
                        title: 'Por favor marque todos los insumos para liberar el pedido !!',
                        showConfirmButton: false,
                        timer: 1500
                        }).then(function() {                                                            
                        window.location= "<?php echo base_url();?>Pedidos/listManagerPasteleria";                                               
                    });	
                }                                              
                else if(data==0){
                    swal({
                        position: 'top-end',
                        type: 'error',
                        title: 'Ha ocurrido un error !!',
                        showConfirmButton: false,
                        timer: 1500
                        }).then(function() {                                                            
                        window.location= "<?php echo base_url();?>Pedidos/listManagerPasteleria";                                               
                    });	
                }               
                else{
                    alert("Error desconocido");
                } 
                
            },
            error: function() { alert("Error posting feed."); }
            });                  
                }                
        });                         
       
    }
</script>










