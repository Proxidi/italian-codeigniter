<!-- DIV Content-Wrapper -->
<div class="content-wrapper">

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Agregar Pedidos
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


        <!-- PEDIDO CORRECTAMENTE REGISTRADO -->
             <?php if($this->session->flashdata("message")):?>                                  
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i>Pedido Registrado Correctamente</h4>            
        </div>
        <?php endif; ?>
        <!-- /. PEDIDO CORRECTAMENTE REGISTRADO -->


        <!-- FORMULARIO -->
            <form action="<?php echo base_url();?>Pedidos/store" method="POST" enctype="multipart/form-data" class="form-horizontal">
                  
                  <!-- DIV FORM GROUP -->
                <div class="form-group" required>
                        <!-- DIV COL-MD-4 -->
                          <!--COMBOBOX PLAZAS-->                    
                                            <div class="col-md-3">
                                            <label for="plaza_id">Plaza:</label>
                                                <select name="plaza_id" id="plaza_id" class="form-control" required>                                                  
                                                    <?php foreach ($plazas as $plaza):?>  
                                                    <?php if($plaza->id==1):?>
                                                    <option value="" selected>
                                                        Seleccionar Plaza
                                                    </option>
                                                    <?php endif;?>
                                                    <?php if($plaza->id==1):?>
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
                                        <!--./ COMBOBOX PLAZAS-->
                        <!-- /. DIV COL-MD-4 -->

                       
                        <!-- DIV COL-MD-4 -->    
                        <div class="col-md-6">
                            <label for="pedido_file">Archivo de Pedido:</label>
                            <input type="file" class="form-control" id="pedido_file" name="pedido_file" value="<?php echo set_value("pedido_file");?>" required>                            
                            <?php echo form_error("pedido_file","<span class='help-lock'>","</span>")?>
                        </div>
                        <!-- /. DIV COL-MD-4 --> 


                 <!-- /. DIV FORM GROUP -->                      
                </div>                                         
                
                <!-- DIV FORM GROUP -->              
                <div class="form-group">
                        <!-- DIV COL-MD-12 --> 
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success btn-flat">Guardar</button>                                                                                                                                                          
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
                            <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_inventario">
                            <thead>
                                <tr>                                                                        
                                    <th>F. Ingreso</th>
                                    <th>F. Recepción</th>
                                    <th>Plaza</th>                                                                         
                                    <th>Insumos</th> 
                                    <th>Estatus</th>                                                                                                                         
                                    <th>Detalles</th>                                    
                                    <th>Eliminar</th>                                                                      
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($detalles)):?>                           
                                <?php foreach ($detalles as $detalle):?>
                                <tr>                                                                        
                                    <td><?=$detalle->Fecha;?></td> 
                                    <td><?=$detalle->Fecha_Recepcion;?></td>  
                                    <td><?=$detalle->Plaza;?></td>                                                                        
                                    <td><?=$detalle->Cantidad;?></td>                                    
                                    
                                    <?php if($detalle->Estatus==0):?>
                                    <td>Pendiente</td> 
                                    <?php elseif($detalle->Estatus==1):?>
                                    <td>Agregado</td>                                                                         
                                    <?php endif;?>                                                                                                                                                                                   
                                    <td> 
                                        <button type="button" class="btn btn-info" onclick="hola('<?php echo $detalle->Fecha;?>',<?php echo $detalle->plaza_id;?>)" data-toggle="modal" data-target="#modal-default" value="">
                                            <span class="fa fa-search"></span>
                                        </button>
                                    </td>                                                                                                                                     
                                    <td> 
                                    <?php if($detalle->Estatus==0):?>
                                        <a href="javascript:void(0);" onclick="eliminarPedido('<?php echo $detalle->Fecha;?>',<?php echo $detalle->plaza_id;?>,<?php echo $detalle->id;?>)" class="btn btn-danger btn-remove">
                                            <span class="fa fa-remove">
                                        </span></a>                                    
                                    <?php endif;?>    

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
            <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" >
                            <thead>
                                <tr>                                    
                                    <th>Estado</th> 
                                    <th>Anotación</th>                                                                                                                                                 
                                    <th>Plaza</th>                                                                                                                                        
                                    <th>Nombre</th>    
                                    <th>Cantidad</th>
                                    <th>Manager</th>
                                    <th>Conversión</th>                                                                                                     
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
 
    function hola(fecha,plaza_id){
        
        var parametros = {
                "fecha" : fecha,    
                "plaza_id" : plaza_id                
                };               

                $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>Pedidos/consultarPedido",
                data: parametros,                                               
                success: function(response){  
                   // alert(response);                   
                    $('#pedido').html(response);                                                                                                                     
                },
                error: function() { 
                    alert("Error posting feed.");
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
</script>








