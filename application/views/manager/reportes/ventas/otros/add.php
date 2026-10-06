<!-- DIV Content-Wrapper -->
<div class="content-wrapper">

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Reporte de Ventas<small>Nueva Venta</small></h1>
    <a href="<?php echo base_url();?>Inicio" class="small-box-footer">Volver al Panel de Inicio<i class="fa fa-arrow-circle-right"></i></a>                
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
            <h4><i class="icon fa fa-check"></i>Venta Registrada Correctamente</h4>            
        </div>
        <?php endif; ?>
        <!-- /. ERROR EN EL PROCESAMIENTO DEL ARCHIVO -->

            <!-- FORMULARIO -->
            <form action="<?php echo base_url();?>Ventas/store" method="POST" enctype="multipart/form-data" class="form-horizontal">
                  
                  <!-- DIV FORM GROUP -->
                <div class="form-group <?php echo !empty(form_error("fecha"))? 'has-error':'' ?>" value="<?php echo set_value("fecha");?>" required>

                        <!-- DIV COL-MD-4 -->
                        <div class="col-md-4">
                            <label for="">Fecha:</label>
                            <input type="date" class="form-control" id="theDate"  name="fecha">
                            <?php echo form_error("fecha","<span class='help-lock'>","</span>")?>
                        </div>
                        <!-- /. DIV COL-MD-4 -->

                        <!-- DIV COL-MD-4 -->
                        <div class="col-md-4">
                            <label for="tpv">TPV:</label>
                            <input type="number" step="any" class="form-control" id="tpv" name="tpv" min="0" value="<?php echo set_value("tpv");?>" required>
                            <?php echo form_error("tpv","<span class='help-lock'>","</span>")?>
                        </div> 
                        <!-- /. DIV COL-MD-4 -->
                       

                        <!-- DIV COL-MD-4 -->    
                        <div class="col-md-4">
                            <label for="excel_file">Archivo de Corte:</label>
                            <input type="file" class="form-control" id="excel_file" name="excel_file" value="<?php echo set_value("excel_file");?>" required>                            
                            <?php echo form_error("excel_file","<span class='help-lock'>","</span>")?>
                        </div>
                        <!-- /. DIV COL-MD-4 --> 

                 <!-- /. DIV FORM GROUP -->                      
                </div>                                         
                
                <!-- DIV FORM GROUP -->              
                <div class="form-group">
                        <!-- DIV COL-MD-12 --> 
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success btn-flat"><span class="fa fa-save"></span> Guardar Datos</button>                                                                                                                                                                                                                                                                                                                                                                        
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
                            <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_ventas_otros">
                            <thead>
                                <tr>                                    
                                    <th>Nombre</th>
                                    <th>Plaza</th>
                                    <th>Fecha</th>                                   
                                   <th>Ingresos</th>                                                                                                     
                                   <th>TPV</th>
                                    <th>Gastos</th>
                                    <th>Efectivo</th>
                                    <th>Gastos</th>                                                                      
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($reportes)):?>
                                <?php foreach ($reportes as $reporteD):?>
                                   <tr>                                    
                                    <td><?=$reporteD->Usuario;?></td>
                                    <td><?=$reporteD->Plaza;?></td>
                                    <td><?=$reporteD->Fecha;?></td>                                    
                                    <td>$ <?=number_format($reporteD->Total_Ingresos);?></td>                                                                                                        
                                    <td>$ <?=number_format($reporteD->TPV);?></td>
                                    <td>$ <?=number_format($reporteD->Gastos);?></td>      
                                    <td>$ <?=number_format($reporteD->Efectivo_Real);?></td>      
                                    <td>
                                        <button type="button" class="btn btn-info btn-view" onclick="consultarGastos('<?php echo $reporteD->Fecha;?>',<?php echo $reporteD->plaza_id;?>)" data-toggle="modal" data-target="#modal-default" value="">
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
        <h4 class="modal-title">Gastos Asociados al día</h4>
      </div>
      <div class="modal-body">
        <div class="responsive-table">
            <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_prueba_API" >
                            <thead>
                                <tr>                                    
                                    <th>Fecha</th> 
                                    <th>Usuario</th>                                                                             
                                    <th>Plaza</th>                                                                                 
                                    <th>Gasto</th>  
                                    <th>Cantidad</th>  
                                    <th>Unidad</th>
                                    <th>P. Unitario</th>
                                    <th>Importe</th>                                    
                                </tr>
                            </thead>
                            <tbody>                                                            
                            </tbody>                            
            </table> 
        </div>
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


    var pruebaAPI= $('#tbl_prueba_API').DataTable({
            "aaSorting": [],
            dom: 'Bfrtip',
            "pageLength": 30,
            buttons: [
                {
                    extend: 'excelHtml5',
                    title: "Listado de Ventas",
                    exportOptions: {
                        columns: ':visible'
                    },
                },
                {
                    extend: 'pdfHtml5',
                    title: "Listado de Ventas",
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

    function numberWithCommas(x) {
        var parts = x.toString().split(".");
        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        return parts.join(".");
    }


    //AJAX REQUEST
    function consultarGastos(fecha,plaza_id){        
        var parametros = {
                "fecha" : fecha,
                "plaza_id" : plaza_id,        
                };              

                $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>Remesas/consultarGastoModal",
                data: parametros,              
                dataType: "JSON",                                 
                success: function(response){  
                    pruebaAPI.clear();   
                    
                    var len = response.length;    
                      var acImporte=0;  
                    for(var i=0; i<len; i++){
                        var fecha = response[i].Fecha;
                        var  id=response[i].id;
                        var usuario_id = response[i].usuario_id;  
                        var plaza_id = response[i].plaza_id;   
                        var insumo_gasto_id = response[i].insumo_gasto_id;   
                        var plaza=response[i].Plaza;  
                        var insumo=response[i].Insumo;
                        var pago=response[i].Pago;
                        var cantidad=response[i].Cantidad;
                        var unidad=response[i].Unidad;
                        var unidad2=response[i].Unidad;
                        var importe=response[i].Importe;
                        var importe2=numberWithCommas(importe);  
                        var editar='<a href="#" onclick="asignarValoresTablaGastosDeposito(\''+fecha+'\',\''+plaza+'\',\''+insumo+'\','+cantidad+','+importe+','+id+','+plaza_id+','+cantidad+','+insumo_gasto_id+')" data-toggle="modal" data-target="#editarGastoDeposito" class="btn btn-info"><span class="fa fa-edit"></span></a></td>';	
                        var eliminar='<a href="#" onclick="eliminarGastoDeposito(\''+fecha+'\','+plaza_id+','+id+','+usuario_id+','+insumo_gasto_id+','+cantidad+')" data-toggle="modal" data-target="#eliminarGastoDeposito" class="btn btn-danger"><span class="fa fa-remove"></span></a></td>';	
                        acImporte=parseFloat(acImporte)+parseFloat(importe);   
                        pruebaAPI.row.add([fecha,plaza,insumo,cantidad,unidad,"$ "+importe2,"$ "+Math.round((importe/cantidad)*100)/100,editar,eliminar]);                    
                    }
                    acImporte=Math.round(acImporte);
                    acImporte=numberWithCommas(acImporte);
                    
                    pruebaAPI.row.add(["Totales","","","","",("$ "+acImporte).bold(),"","",""]);   
                    pruebaAPI.draw();                                                
                },
                error: function() { 
                    alert("Error posting feed.");
                }
            });
                
    }


    function asignarValoresTablaGastosDeposito(fecha,plaza,gasto,cantidad,importe,id,plaza_id,antCantidad,insumo_gasto_id){                                            
        $('#id_gasto_deposito').val(id);     
        $('#plaza_id_gasto_deposito').val(plaza_id);             
        $('#fecha_editar_gasto').val(fecha);
        $('#plaza').val(plaza);
        $('#gasto').val(gasto); 
        $('#cantidad').val(cantidad);
        $('#importe').val(importe);   
        $('#antigua_cantidad_gasto_deposito').val(antCantidad);    
        $('#insumo_id_gasto_deposito').val(insumo_gasto_id);            
    }

    function eliminarGastoDeposito(fecha,plaza_id,id,usuario_id,insumo_gasto_id,cantidad){
        //alert(cantidad);

        var parametros = 
                {
                "fecha" : fecha,
                "plaza_id":plaza_id,
                "id":id,
                "usuario_id":usuario_id,
                "cantidad":cantidad,
                "insumo_gasto_id":insumo_gasto_id                            
                }; 

            //alert(parametros);                 

            swal({
            title: '¿Está seguro?',
            text: "Desea eliminar el gasto",
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
                    url: "<?php echo base_url();?>Remesas/delete",
                    data: parametros, 
                    success: function(data){   
                            //alert(datos);                             
                            if(data==1){
                            
                            swal({
                            title: "Gasto eliminado correctamente!",
                            text: "Gasto eliminado",
                            type: "success"
                        }).then(function() {                                                           
                            location.reload();                                               
                        });	
                        
                    }else if(data==0){                        
                        swal({
                        type: 'error',
                        title: 'Error al eliminar el gasto',
                        text: 'No se pudo eliminar el gasto'                    
                        }).then(function() {                        
                            //location.reload();
                        });

                        }
                    },
                    error: function() { 
                        swal({
                        type: 'error',
                        title: 'Error FEED desconocido',
                        text: 'Error desconocido por favor contacte al administrador'                    
                        }).then(function() {                        
                            //location.reload();
                        });
                    
                    }
                });                    
            }                
            });         
    }
</script>