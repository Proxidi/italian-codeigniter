
        <!-- =============================================== -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                Ventas Generales
                <small>Listado</small>
                </h1>
                <a href="<?php echo base_url(); ?>Depositos/panel" class="small-box-footer">Volver al Panel de Ventas <i class="fa fa-arrow-circle-right"></i></a>
            </section>
            <!-- Main content -->
            <section class="content">
                <!-- Default box -->
                <div class="box box-solid">
                    <div class="box-body">
                        <div class="row"> 
                        <div class="col-md-12">                           
                            <form action="<?php echo current_url();?>" method="POST" class="form-horizontal">
                        <div class="form-group">
                            <label for="" class="col-md-1 control-label">Desde:</label>
                            <div class="col-md-3">
                                <input type="date" class="form-control" name="fechaInicioD" id="fechaInicioD" value="<?php echo !empty($fechainicio) ? $fechainicio:'';?>" required>
                            </div>
                            <label for="" class="col-md-1 control-label">Hasta:</label>
                            <div class="col-md-3">
                                <input type="date" class="form-control" name="fechaFinD" id="fechaFinD" value="<?php  echo !empty($fechafin) ? $fechafin:'';?>">
                            </div>

                           

                            <div class="form-group">
                            </div> 
                            <label for="" class="col-md-1 control-label">Options:  </label>                           
                            <div class="col-md-10">
                                <input type="submit" name="buscar" value="Buscar" class="btn btn-primary">
                                <input type="submit" name="buscarRango" value="Buscar Rango" class="btn btn-danger" id="buscar_rango_depositos_list">    
                                <input type="submit" name="buscarRangoDesglose" value="Buscar Rango Desglose" class="btn btn-danger" id="buscar_rango_depositos_list">                                      
                                <a href="<?php echo base_url(); ?>Depositos/ventasOaxaca" class="btn btn-success">Restablecer</a>
                            </div>
                        </div>
                        </form>                                               
                            </div>
                         </div>
                         
                         <div class="row">
                            <div class="col-md-12">
                            <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_depositos">
                            <thead>
                                <tr>
                                                   
                                    <th>Plaza</th>
                                    <th>Fecha</th>
                                    <th>Total V</th>
                                    <th>Ventas C</th>
                                    <th>TPV</th>                                    
                                    <th>Gastos</th>   
                                    <th>% Gastos</th>   
                                    <th>Depósito</th>
                                    <th>Efectivo</th>   
                                    <th>V. Gastos</th>                                
                                  
                                    

                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($reportes)):?>
                                <?php
                                $acVentas=0;
                                $acIngresos=0;
                                $acTPV=0;
                                $acGastos=0;
                                $acDeposito=0;
                                $acEfectivo=0;?>

                                <?php foreach ($reportes as $reporte):?>
                                <?php if($menu==0):?>
                                <?php
                                $acVentas+=$reporte->Total_Ventas;
                                $acIngresos+=$reporte->Total_Ingresos;
                                $acTPV+=$reporte->TPV;
                                $acGastos+=$reporte->Gastos;
                                $acDeposito+=$reporte->Deposito;
                                $acEfectivo+=$reporte->Efectivo_Real;?>
                                   <tr>              
                                   <?php switch($reporte->plaza_id): 
                                    case 1: ?>
                                    <td bgcolor="#bae6ff"><?=$reporte->Plaza;?></td>
                                    <?php break; ?>

                                    <?php case 2: ?>
                                    <td bgcolor="#FA8072"><?=$reporte->Plaza;?></td>
                                    <?php break; ?>
                                    
                                    <?php case 3: ?>
                                    <td bgcolor="#8cedbc"><?=$reporte->Plaza;?></td>
                                    <?php break; ?>

                                    <?php case 4: ?>
                                    <td bgcolor="#ecccbb"><?=$reporte->Plaza;?></td>
                                    <?php break; ?>

                                    <?php case 5: ?>
                                    <td bgcolor="#ffd682"><?=$reporte->Plaza;?></td>
                                    <?php break; ?>

                                    <?php case 6: ?>
                                    <td bgcolor="#e7bbec"><?=$reporte->Plaza;?></td>
                                    <?php break; ?>
                                    
                                    <?php case 7: ?>
                                    <td bgcolor="#e7bbec"><?=$reporte->Plaza;?></td>
                                    <?php break; ?>
                                    
                                    <?php endswitch; ?>

                                    <td><?=$reporte->Fecha;?></td>
                                    <td> $ <?=number_format($reporte->Total_Ingresos);?></td>
                                    <td> $ <?=number_format($reporte->Total_Ventas);?></td>
                                    <td> $ <?=number_format($reporte->TPV);?></td>                                    
                                    <td> $ <?=number_format($reporte->Gastos);?></td>
                                    <td><?=round($reporte->Gastos/$reporte->Total_Ingresos,4)*100;?>%</td>
                                    <td> $ <?=number_format($reporte->Deposito);?></td>
                                    <td> $ <?=number_format($reporte->Efectivo_Real);?></td> 
                                    <td>                                        
                                            <button type="button" class="btn btn-info btn-view" onclick="consultarGastos('<?php echo $reporte->Fecha;?>',<?php echo $reporte->plaza_id;?>)" data-toggle="modal" data-target="#modal-default" value="">
                                                <span class="fa fa-search"></span>
                                            </button>                                                                                   
                                    </td>  
                                                                                                
                                </tr>   
                                <?php endif;?> 
                                <?php if($menu==1):?>
                                <?php
                                $acVentas+=$reporte->SumaVentasC;
                                $acIngresos+=$reporte->SumaTotalV;
                                $acTPV+=$reporte->SumaTPV;
                                $acGastos+=$reporte->SumaGastos;
                                $acDeposito+=$reporte->SumaDeposito;
                                $acEfectivo+=$reporte->SumaEfectivo;?>
                                      <tr>                                                                     
                                      <?php switch($reporte->plaza_id): 
                                    case 1: ?>
                                    <td bgcolor="#bae6ff"><?=$reporte->Plaza;?></td>
                                    <?php break; ?>

                                    <?php case 2: ?>
                                    <td bgcolor="#FA8072"><?=$reporte->Plaza;?></td>
                                    <?php break; ?>
                                    
                                    <?php case 3: ?>
                                    <td bgcolor="#8cedbc"><?=$reporte->Plaza;?></td>
                                    <?php break; ?>

                                    <?php case 4: ?>
                                    <td bgcolor="#ecccbb"><?=$reporte->Plaza;?></td>
                                    <?php break; ?>

                                    <?php case 5: ?>
                                    <td bgcolor="#ffd682"><?=$reporte->Plaza;?></td>
                                    <?php break; ?>

                                    <?php case 6: ?>
                                    <td bgcolor="#e7bbec"><?=$reporte->Plaza;?></td>
                                    <?php break; ?>
                                    
                                    <?php case 7: ?>
                                    <td bgcolor="#e7bbec"><?=$reporte->Plaza;?></td>
                                    <?php break; ?>
                                    
                                    <?php endswitch; ?>
                                        <td><?=$fechaConsulta?></td>                          
                                        <td> $ <?=number_format($reporte->SumaTotalV);?></td>   
                                        <td> $ <?=number_format($reporte->SumaVentasC);?></td>
                                        <td> $ <?=number_format($reporte->SumaTPV);?></td>                                        
                                        <td> $ <?=number_format($reporte->SumaGastos);?></td>
                                        <td><?=round($reporte->SumaGastos/$reporte->SumaTotalV,4)*100;?>%</td>       
                                        <td> $ <?=number_format($reporte->SumaDeposito);?></td>
                                        <td> $ <?=number_format($reporte->SumaEfectivo);?></td>   
                                        <td>                                        
                                            <button type="button" class="btn btn-info btn-view" onclick="consultarGastosRango('<?php echo $fechainicio;?>','<?php echo $fechafin;?>',<?php echo $reporte->plaza_id;?>)" data-toggle="modal" data-target="#modal-default" value="">
                                                <span class="fa fa-search"></span>
                                            </button>                                                                                   
                                        </td>  
                                        </tr>    
                                <?php endif;?> 
                                <?php endforeach;?>                                                                                                            
                                <tr>                                    
                                    <td><b><h4>Totales</h4></b></td>
                                    <td></td>
                                    <td><b>$ <?=number_format($acIngresos);?></b></td>
                                    <td><b>$ <?=number_format($acVentas);?></b></td>
                                    <td><b>$ <?=number_format($acTPV);?></b></td>                                    
                                    <td><b>$ <?=number_format($acGastos);?></b></td>
                                    <td><b><?=round($acGastos/$acIngresos,4)*100;?>%</b></td>
                                    <td><b>$ <?=number_format($acDeposito);?></b></td>
                                    <td><b>$ <?=number_format($acEfectivo);?></b></td>
                                    <td></td>                                                                  
                                </tr>  
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
                                                                                                              
                                    <th>Plaza</th>                                                                                 
                                    <th>Gasto</th>  
                                    <th>Cantidad</th>  
                                    <th>Unidad</th>
                                    <th>Importe</th>      
                                    <th>P. Unitario</th>                                                                 
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
            <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_prueba_API2" >
                            <thead>
                                <tr>                                    
                                    <th>Fecha</th>                                                                          
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

     //AJAX REQUEST
     function consultarGastosRango(fechainicio,fechafin,plaza_id){                           
        var parametros = {
                "fechainicio" : fechainicio,
                "fechafin" : fechafin,
                "plaza_id" : plaza_id,        
                };                             
                
                $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>Remesas/consultarGastoModalRango",
                data: parametros,    
                dataType: "JSON",                                                
                success: function(response){             
                    pruebaAPI.clear();   
                    
                    var len = response.length;    
                      var acImporte=0;  
                    for(var i=0; i<len; i++){
                        var fecha = response[i].Fecha;
                        var usuario = response[i].Usuario;            
                        var plaza=response[i].Plaza;  
                        var insumo=response[i].Insumo;
                        var pago=response[i].Pago;
                        var cantidad=response[i].Cantidad;
                        var unidad=response[i].Unidad;
                        var unidad2=response[i].Unidad;
                        var importe=response[i].Importe;  
                         acImporte=parseFloat(acImporte)+parseFloat(importe);   
                    pruebaAPI.row.add([fecha,usuario,plaza,insumo,cantidad,unidad,Math.round((importe/cantidad)*100)/100,importe]);                    
                    }
                    pruebaAPI.row.add(["Totales","","","","","","",Math.round(acImporte)]);   
                    pruebaAPI.draw();                                                                                                          
                },
                error: function() { 
                    alert("Error posting feed.");
                }
            });
                
    }
    
</script>





