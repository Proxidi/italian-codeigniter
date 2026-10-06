<!-- =============================================== -->
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                Ventas Generales2
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
                            <form action="<?php echo current_url();?>" method="GET" class="form-horizontal">
                        <div class="form-group">
                            <label for="" class="col-md-1 control-label">Desde:</label>
                            <div class="col-md-3">
                                <input type="date" class="form-control" name="fechaInicioD" id="fechaInicioD" value="<?php echo !empty($fechainicio) ? $fechainicio:'';?>" required>
                            </div>
                            <label for="" class="col-md-1 control-label">Hasta:</label>
                            <div class="col-md-3">
                                <input type="date" class="form-control" name="fechaFinD" id="fechaFinD" value="<?php  echo !empty($fechafin) ? $fechafin:'';?>">
                            </div>
                            <label for="" class="col-md-1 control-label">Plaza:</label>
                            <div class="col-md-3">
                            <select name="plaza_idP" id="plaza_idP" class="form-control">                                                  
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
                                    <input type="hidden" name="hidden_country" id="hidden_country" />
                        </div>
                            <div class="form-group">
                            </div> 
                            <label for="" class="col-md-1 control-label">Options:  </label>                           
                            <div class="col-md-10">
                                <input type="submit" name="buscar" value="Buscar" class="btn btn-primary">                                
                                <input type="submit" name="buscarRangoDesglose" value="Buscar Rango Desglose" class="btn btn-danger" id="buscar_rango_depositos_list">                                      
                                <a href="<?php echo base_url(); ?>Depositos" class="btn btn-success">Restablecer</a>
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
                                                   
                                    <th>Plz</th>
                                    <th>Fecha</th>
                                    <th>T.V</th>
                                    <th>V.C</th>
                                    <th>TPV</th>     
                                    <th>Edit</th>                               
                                    <th>Gastos</th>     
                                    <th>Edit</th>                                      
                                    <th>G. Admin</th>     
                                    <th>Edit</th>  
                                    <th>T.Gastos</th>  
                                    <th>Deposito</th>
                                    <th>Efectivo</th>                                                                                                       
                                    <th>Liberar</th>                                                                                                      
                                    <th>Desliberar</th>  

                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($reportes)):?>
                                <?php
                                $acVentas=0;
                                $acIngresos=0;
                                $acTPV=0;
                                $acGastos=0;
                                $acGastosAdmin=0;
                                $acDeposito=0;
                                $acEfectivo=0;?>

                                <?php foreach ($reportes as $reporte):?>
                                <?php if($menu==0):?>
                                <?php
                                $acVentas+=$reporte->Total_Ventas;
                                $acIngresos+=$reporte->Total_Ingresos;
                                $acTPV+=$reporte->TPV;
                                $acGastos+=$reporte->Gastos;
                                $acGastosAdmin+=$reporte->Gastos_Admin;
                                $acDeposito+=$reporte->Deposito;
                                $acEfectivo+=$reporte->Efectivo_Real;?>
                                   <tr>              
                                   <?php switch($reporte->plaza_id): 
                                    case 1: ?>
                                    <td bgcolor="#bae6ff"><?=$reporte->Acronimo;?></td>
                                    <?php break; ?>

                                    <?php case 2: ?>
                                    <td bgcolor="#FA8072"><?=$reporte->Acronimo;?></td>
                                    <?php break; ?>
                                    
                                    <?php case 3: ?>
                                    <td bgcolor="#8cedbc"><?=$reporte->Acronimo;?></td>
                                    <?php break; ?>

                                    <?php case 4: ?>
                                    <td bgcolor="#ecccbb"><?=$reporte->Acronimo;?></td>
                                    <?php break; ?>

                                    <?php case 5: ?>
                                    <td bgcolor="#ffd682"><?=$reporte->Acronimo;?></td>
                                    <?php break; ?>

                                    <?php case 6: ?>
                                    <td bgcolor="#e7bbec"><?=$reporte->Acronimo;?></td>
                                    <?php break; ?>
                                    
                                    <?php case 7: ?>
                                    <td bgcolor="#c7d5d8"><?=$reporte->Acronimo;?></td>
                                    <?php break; ?>
                                    
                                    <?php endswitch; ?>

                                    <td><?=$reporte->Fecha;?></td>
                                    <td> $ <?=number_format($reporte->Total_Ingresos);?></td>
                                    <td> $ <?=number_format($reporte->Total_Ventas);?></td>
                                    <td> $ <?=number_format($reporte->TPV);?></td>    
                                    <td>                                        
                                            <button type="button" class="btn btn-info btn-view" onclick="asignarValoresTPVDeposito('<?php echo $reporte->Fecha;?>',<?php echo $reporte->plaza_id;?>,<?php echo $reporte->TPV;?>)"  data-toggle="modal" data-target="#editarTPV" value="">
                                                <span class="fa fa-edit"></span>
                                            </button>                                                                                   
                                    </td>                                 
                                    <td> $ <?=number_format($reporte->Gastos);?></td>    
                                    <td>                                        
                                            <button type="button" class="btn btn-info btn-view" onclick="consultarGastos('<?php echo $reporte->Fecha;?>',<?php echo $reporte->plaza_id;?>)" data-toggle="modal" data-target="#modal-default" value="">
                                                <span class="fa fa-edit"></span>
                                            </button>                                                                                   
                                    </td> 
                                    <td> $ <?=number_format($reporte->Gastos_Admin);?></td>    
                                    <td>                                        
                                            <button type="button" class="btn btn-info btn-view" onclick="consultarGastosAdmin('<?php echo $reporte->Fecha;?>',<?php echo $reporte->plaza_id;?>)" data-toggle="modal" data-target="#modal-default2" value="">
                                                <span class="fa fa-edit"></span>
                                            </button>                                                                                   
                                    </td>  
                                    <td> $ <?=number_format($reporte->Total_Gastos);?></td>                                        
                                   <?php if($reporte->Bandera==0):?>
                                      <td bgcolor="#ff8f77"> $ <?=number_format($reporte->Deposito);?></td>
                                   <?php else:?>
                                      <td bgcolor="#8cedbc"> $ <?=number_format($reporte->Deposito);?></td>
                                   <?php endif;?>
                                    <td> $ <?=number_format($reporte->Efectivo_Real);?></td> 
                                    
                                  
                                                                                                           
                                    <td>
                                        <button type="button" class="btn btn-success btn-view" onclick="liberarDepositoAjax('<?php echo $reporte->Fecha;?>',<?php echo $reporte->plaza_id;?>)">
                                                <span class="fa fa-check"></span>
                                        </button>                                      
                                    </td>
                                    
                                    <td>
                                        <button type="button" class="btn btn-danger btn-view" onclick="desliberarDepositoAjax('<?php echo $reporte->Fecha;?>',<?php echo $reporte->plaza_id;?>)">
                                                <span class="fa fa-remove"></span>
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
                                    <td></td>                                 
                                    <td><b>$ <?=number_format($acGastos);?></b></td>  
                                    <td></td>  
                                    <td><b>$ <?=number_format($acGastosAdmin);?></b></td>  
                                    <td></td>     
                                    <td></td>                             
                                    <td><b>$ <?=number_format($acDeposito);?></b></td>
                                    <td><b>$ <?=number_format($acEfectivo);?></b></td>
                                    <td></td>  
                                    <td></td>  
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
                        <!--<th>Usuario</th>-->
                        <th>Plaza</th>                                                                                 
                        <th>Gasto</th>  
                        <th>Cantidad</th>  
                        <th>Unidad</th>
                        <th>Importe</th>      
                        <th>P. Unitario</th>    
                        <th>Editar</th>  
                        <th>Borrar</th>                        
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



<div class="modal fade" id="modal-default2">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Gastos Administrativos Asociados al día</h4>
      </div>
      <div class="modal-body">
        <div class="responsive-table">
            <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_prueba_API_admin" >
                <thead>
                    <tr>                                    
                        <th>Fecha</th> 
                        <!--<th>Usuario</th>-->
                        <th>Plaza</th>                                                                                 
                        <th>Gasto</th>  
                        <th>Cantidad</th>  
                        <th>Unidad</th>
                        <th>Importe</th>      
                        <th>P. Unitario</th>    
                        <th>Editar</th>  
                        <th>Borrar</th>                        
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


<div class="modal fade" id="editarTPV" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  
          <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i>Editar TPV</h4>
		  </div>
		  
          <div class="modal-body">
			<form class="form-horizontal" method="post" id="editarTPVDeposito" name="editarTPVDeposito">						            
            
            <input type="hidden" name="plaza_id_TPV_deposito" id="plaza_id_TPV_deposito">            

            <div class="form-group">
				<label for="fecha_deposito_tpv" class="col-sm-3 control-label">Fecha:</label>
				<div class="col-sm-8">	
                <input type="date" class="form-control" name="fecha_deposito_tpv" id="fecha_deposito_tpv" value="" required readonly>
				</div>
			</div>

            <div class="form-group">
                <label for="TPV" class="col-sm-3 control-label">TPV:</label>
                <div class="col-sm-8">	
                    <input type="number" class="form-control"step="0.001" id="TPV" placeholder="" name="TPV" value="0" required>                            
                </div>
                </div>                                                                
		    </div>

		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" id="editar_TPV_deposito">Guardar datos</button>
		  </div>
		  </form>
		</div>
	  </div>
</div>


<!--MODAL QUE HACE REFERENCIA A LOS GASTOS DE LOS MANAGERS-->
<div class="modal fade" id="editarGastoDeposito" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  
          <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i>Editar GASTO</h4>
		  </div>
		  
          <div class="modal-body">
			<form class="form-horizontal" method="post" id="editarGastosDeposito" name="editarGastosDeposito">						            
            <input type="hidden" name="plaza_id_gasto_deposito" id="plaza_id_gasto_deposito">            
            <input type="hidden" name="id_gasto_deposito" id="id_gasto_deposito">
            <input type="hidden" name="antigua_cantidad_gasto_deposito" id="antigua_cantidad_gasto_deposito">
            <input type="hidden" name="insumo_id_gasto_deposito" id="insumo_id_gasto_deposito">

            <div class="form-group">
				<label for="fecha_editar_gasto" class="col-sm-3 control-label">Fecha:</label>
				<div class="col-sm-8">	
                <input type="date" class="form-control" name="fecha_editar_gasto" id="fecha_editar_gasto" value="" required readonly>
				</div>
			</div>

            <div class="form-group">
                <label for="plaza" class="col-sm-3 control-label">Plaza:</label>
                <div class="col-sm-8">	
                    <input type="text" class="form-control"step="0.001" id="plaza" placeholder="" name="plaza" value="" readonly>                            
                </div>
            </div>

            <div class="form-group">
                <label for="gasto" class="col-sm-3 control-label">Gasto:</label>
                <div class="col-sm-8">	
                    <input type="text" class="form-control"step="0.001" id="gasto" placeholder="" name="gasto" value="" required>                            
                </div>
            </div>                                                                		    

            <div class="form-group">
                    <label for="cantidad" class="col-sm-3 control-label">Cantidad:</label>
                    <div class="col-sm-8">	
                        <input type="number" class="form-control"step="0.001" id="cantidad" placeholder="" name="cantidad" value="0" required>                            
                    </div>
            </div>

            <div class="form-group">
                    <label for="importe" class="col-sm-3 control-label">Importe:</label>
                    <div class="col-sm-8">	
                        <input type="number" class="form-control"step="0.001" id="importe" placeholder="" name="importe" value="" required>                            
                    </div>
            </div>

            </div>           
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" id="editar_gastos_deposito">Guardar datos</button>
		  </div>
		  </form>
		</div>
	  </div>
</div>

<!--MODAL QUE HACE REFERENCIA A LOS GASTOS DE LOS MANAGERS-->


<!--MODAL QUE HACE REFERENCIA A LOS GASTOS ADMINISTRATIVOS-->
<div class="modal fade" id="editarGastoAdminDeposito" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  
          <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i>Editar GASTO</h4>
		  </div>
		  
          <div class="modal-body">
			<form class="form-horizontal" method="post" id="editarGastosAdminDeposito" name="editarGastosAdminDeposito">						            
            <input type="hidden" name="plaza_id_admin_gasto_deposito" id="plaza_id_admin_gasto_deposito">            
            <input type="hidden" name="id_admin_gasto_deposito" id="id_admin_gasto_deposito">
          

            <div class="form-group">
				<label for="fecha_editar_gasto" class="col-sm-3 control-label">Fecha:</label>
				<div class="col-sm-8">	
                <input type="date" class="form-control" name="fecha_editar_gasto_admin" id="fecha_editar_gasto_admin" value="" required readonly>
				</div>
			</div>

            <div class="form-group">
                <label for="plaza_admin" class="col-sm-3 control-label">Plaza:</label>
                <div class="col-sm-8">	
                    <input type="text" class="form-control"step="0.001" id="plaza_admin" placeholder="" name="plaza_admin" value="" readonly>                            
                </div>
            </div>

            <div class="form-group">
                <label for="gasto_admin" class="col-sm-3 control-label">Gasto:</label>
                <div class="col-sm-8">	
                    <input type="text" class="form-control"step="0.001" id="gasto_admin" placeholder="" name="gasto_admin" value="" required readonly>                            
                </div>
            </div>                                                                		    

            <div class="form-group">
                    <label for="cantidad_admin" class="col-sm-3 control-label">Cantidad:</label>
                    <div class="col-sm-8">	
                        <input type="number" class="form-control"step="0.001" id="cantidad_admin" placeholder="" name="cantidad_admin" value="0" required readonly>                            
                    </div>
            </div>

            <div class="form-group">
                    <label for="importe_admin" class="col-sm-3 control-label">Importe:</label>
                    <div class="col-sm-8">	
                        <input type="number" class="form-control"step="0.001" id="importe_admin" placeholder="" name="importe_admin" value="" required>                            
                    </div>
            </div>

            </div>           
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" id="editar_gastos_admin_deposito">Guardar datos</button>
		  </div>
		  </form>
		</div>
	  </div>
</div>
<!--MODAL QUE HACE REFERENCIA A LOS GASTOS ADMINISTRATIVOS-->

<script type="text/javascript">  

    var pruebaAPIAdmin= $('#tbl_prueba_API_admin').DataTable({
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
                                    
    //#region EDITANDO TPV DESDE LA TABLA DE DEPÓSITOS 
     $( "#editarTPVDeposito" ).submit(function( event ) {
            //$('#editar_gastos_deposito').attr("disabled", true);  
                var parametros = $(this).serialize();                
                //alert(parametros);
                //alert("Actualizando la TPV desde la tabla de depósitos");                
                $.ajax({
                        type: "POST",
                        url: "<?php echo base_url();?>Depositos/consultarLiberacionDeposito",
                        data: parametros,
                        success: function(datos){                                                                
                            if(datos==1)
                            {
                            swal({
                            title: '¿LA TPV AFECTARÁ EL DEPÓSITO DE LA TABLA DE DEPÓSITOS?',
                            text: '¿Desea proceder con la actualización?',
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Si,proceder',
                            cancelButtonText: 'No',
                            allowOutsideClick: false
                            }).then((result) => {
                            if (result.value) {                                                  
                                $.ajax({
                                    type: "POST",
                                    url: "<?php echo base_url();?>Ventas/actualizarTPV",
                                    data: parametros,                                    
                                    success: function(datos){                                                                        
                                    if(datos==1){                            
                                        swal({
                                            position: 'top-end',
                                            type: 'success',
                                            title: 'TPV actualizada!!!',
                                            showConfirmButton: false,
                                            timer: 1500
                                            }).then(function() {                                                            
                                                location.reload();
                                        });	                                
                                    }
                                    else if(datos==0){                                 
                                            swal({
                                            type: 'error',
                                            title: 'Error al actualizar TPV',
                                            text: 'No se pudo actualizar la TPV'                    
                                            }).then(function() {                                                                        
                                            });
                                    }                                                                     
                                },
                                error: function() {                                         
                                swal({                                                                        
                                    type: 'error',
                                    title: 'Error desconocido',
                                    text: 'Contacte al administrador '                    
                                    }).then(function() {                        
                                            //location.reload();
                                    });
                                }
                                });                             
                            }                
                            });
                            }          
                            else if(datos==0)
                            {
                                $.ajax({
                                    type: "POST",
                                    url: "<?php echo base_url();?>Ventas/actualizarTPV",
                                    data: parametros,                                    
                                    success: function(datos){                                                                        
                                    if(datos==1){                            
                                        swal({
                                            position: 'top-end',
                                            type: 'success',
                                            title: 'TPV actualizada!!!',
                                            showConfirmButton: false,
                                            timer: 1500
                                            }).then(function() {                                                            
                                                location.reload();
                                        });	                                
                                    }
                                    else if(datos==0){                                 
                                            swal({
                                            type: 'error',
                                            title: 'Error al actualizar TPV',
                                            text: 'No se pudo actualizar la TPV'                    
                                            }).then(function() {                                                                        
                                            });
                                    }                                                                     
                                },
                                error: function() {                                         
                                swal({                                                                        
                                    type: 'error',
                                    title: 'Error desconocido',
                                    text: 'Contacte al administrador '                    
                                    }).then(function() {                        
                                            //location.reload();
                                    });
                                }
                                });
                            }                                
                    },
                    error: function() { 
                        swal({
                            type: 'error',
                                title: 'Error desconocido',
                            text: 'Contacte al administrador '                    
                            }).then(function() {                        
                                    //location.reload();
                            });                        
                        }
                });
                event.preventDefault();
        });
    //#endregion  

    //#region EDITANDO GASTOS DESDE LA TABLA DE DEPÓSITOS 
        $( "#editarGastosAdminDeposito" ).submit(function( event ) {              
                var parametros = $(this).serialize();                                                   
                $.ajax({
                        type: "POST",
                        url: "<?php echo base_url();?>Remesas/actualizarGastoAdmin",
                        data: parametros,
                        success: function(datos){   
                                //alert(datos);                             
                                if(datos==1){
                            
                                    swal({
                                position: 'top-end',
                                type: 'success',
                                title: 'Gasto correctamente actualizado!!!',
                                showConfirmButton: false,
                                timer: 1500
                                }).then(function() {                                                            
                                    location.reload();
                            });		
                                
                            }else if(datos==0){
                                 
                                    swal({
                                type: 'error',
                                title: 'Error al actualizar el gasto',
                                text: 'No se pudo actualizar el gasto'                    
                                }).then(function() {                        
                                    //location.reload();
                                });

                                }                                          
                    },
                    error: function() { 
                        swal({
                                type: 'error',
                                title: 'Error desconocido',
                                text: 'Contacte al administrador '                    
                                }).then(function() {                        
                                    //location.reload();
                                });                        
                        }
                });
                event.preventDefault();
        });
    //#endregion  

    //#region EDITANDO GASTOS DESDE LA TABLA DE DEPÓSITOS 
        $( "#editarGastosDeposito" ).submit(function( event ) {
            //$('#editar_gastos_deposito').attr("disabled", true);  
                var parametros = $(this).serialize();                                              
                $.ajax({
                        type: "POST",
                        url: "<?php echo base_url();?>Remesas/actualizarGasto",
                        data: parametros,
                        success: function(datos){   
                                //alert(datos);                             
                                if(datos==1){
                            
                                    swal({
                                position: 'top-end',
                                type: 'success',
                                title: 'Gasto correctamente actualizado!!!',
                                showConfirmButton: false,
                                timer: 1500
                                }).then(function() {                                                            
                                    location.reload();
                            });	
                                
                            }else if(datos==0){
                                 
                                    swal({
                                type: 'error',
                                title: 'Error al actualizar el gasto',
                                text: 'No se pudo actualizar el gasto'                    
                                }).then(function() {                        
                                    //location.reload();
                                });

                                }                                          
                    },
                    error: function() { 
                        swal({
                                type: 'error',
                                title: 'Error desconocido',
                                text: 'Contacte al administrador '                    
                                }).then(function() {                        
                                    //location.reload();
                                });                        
                        }
                });
                event.preventDefault();
        });
    //#endregion  

    function asignarValoresTPVDeposito(fecha,plaza,tpv){            
            $('#fecha_deposito_tpv').val(fecha);
            $('#plaza_id_TPV_deposito').val(plaza);
            $('#TPV').val(tpv);         
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

    function asignarValoresTablaGastosDepositoAdmin(fecha,plaza,gasto,cantidad,importe,id,plaza_id){                            
        $('#id_admin_gasto_deposito').val(id);     
        $('#plaza_id_admin_gasto_deposito').val(plaza_id);             
        $('#fecha_editar_gasto_admin').val(fecha);
        $('#plaza_admin').val(plaza);
        $('#gasto_admin').val(gasto); 
        $('#cantidad_admin').val(cantidad);
        $('#importe_admin').val(importe);                
    }
    
    function liberarDepositoAjax(fecha,plaza_id){                        
        var parametros = {
                "fecha" : fecha,
                'plaza_id':plaza_id                          
                }; 

                swal({
                title: '¿Está seguro?',
                text: "Liberación de depósito",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, liberar',
                cancelButtonText: 'No'
                }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url();?>Depositos/liberarDeposito",
                        data: parametros,                         
                        success: function(data){
                            //alert(data);                                  
                            if(data==1){                                
                                swal({
                                    position: 'top-end',
                                    type: 'success',
                                    title: 'Deposito liberado correctamente!!',
                                    showConfirmButton: false,
                                    timer: 1500
                                    }).then(function() {                                                            
                                        location.reload();                                                   
                                });	  
                            }else if(data==0){
                                swal({
                                    position: 'top-end',
                                    type: 'error',
                                    title: 'Ha ocurrido un error al liberar el deposito!!',
                                    showConfirmButton: false,
                                    timer: 1500
                                    }).then(function() {                                                            
                                        //location.reload();     
                                });	
                            }
                            else if (data==2){                                
                                swal({
                                    position: 'top-end',
                                    type: 'info',
                                    title: 'El depósito ya fue liberado!!',
                                    showConfirmButton: false,
                                    timer: 1500
                                    }).then(function() {                                                            
                                        //location.reload();     
                                });	  
                            }else{
                                swal({
                                    position: 'top-end',
                                    type: 'info',
                                    title: 'Error desconocido,contacte al administraador!!',
                                    showConfirmButton: false,
                                    timer: 1500
                                    }).then(function() {                                                            
                                        //location.reload();     
                                });	  
                            }                                                    
                        },
                        error: function() { 
                            
                            swal({
                                    position: 'top-end',
                                    type: 'info',
                                    title: 'Error FEED desconocido,contacte al administraador!!',
                                    showConfirmButton: false,
                                    timer: 1500
                                    }).then(function() {                                                            
                                        //location.reload();     
                                });	 
                        
                        }
                    });                    
                }                
                });         
    }

    function desliberarDepositoAjax(fecha,plaza_id){                
        
        var parametros = {
            "fecha" : fecha,
            'plaza_id':plaza_id                          
            }; 

            swal({
            title: '¿Está seguro?',
            text: "Se eliminara el depósito de la tabla de depósitos",
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
                    url: "<?php echo base_url();?>Depositos/desliberarDeposito",
                    data: parametros,                         
                    success: function(data){
                        //alert(data);                             
                        if(data==1){                                
                            swal({
                                position: 'top-end',
                                type: 'success',
                                title: 'Deposito eliminado correctamente!!',
                                showConfirmButton: false,
                                timer: 1500
                                }).then(function() {                                                            
                                    location.reload();                                                   
                            });	  
                        }else if(data==0){
                            swal({
                                position: 'top-end',
                                type: 'error',
                                title: 'Ha ocurrido un error al eliminar el deposito!!',
                                showConfirmButton: false,
                                timer: 1500
                                }).then(function() {                                                            
                                    //location.reload();     
                            });	
                        }
                        else if (data==2){                                
                            swal({
                                position: 'top-end',
                                type: 'error',
                                title: 'El depósito a eliminar no fue realizado hoy!!',
                                showConfirmButton: false,
                                timer: 1500
                                }).then(function() {                                                            
                                    //location.reload();     
                            });	  
                        }  else if (data==3){                                
                            swal({
                                position: 'top-end',
                                type: 'error',
                                title: 'Depósito aun no liberado!!',
                                showConfirmButton: false,
                                timer: 1500
                                }).then(function() {                                                            
                                    //location.reload();     
                            });	  
                        }else{
                            swal({
                                position: 'top-end',
                                type: 'info',
                                title: 'Error desconocido,contacte al administraador!!',
                                showConfirmButton: false,
                                timer: 1500
                                }).then(function() {                                                            
                                    //location.reload();     
                            });	  
                        }                                                                           
                    },
                    error: function() { 
                        swal({
                                position: 'top-end',
                                type: 'info',
                                title: 'Error FEED desconocido,contacte al administraador!!',
                                showConfirmButton: false,
                                timer: 1500
                                }).then(function() {                                                            
                                    //location.reload();     
                            });	                         
                    }
                });                    
            }                
            });         
    }

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

    function consultarGastosAdmin(fecha,plaza_id){        
            var parametros = {
                "fecha" : fecha,
                "plaza_id" : plaza_id,        
                };              

            $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>Remesas/consultarGastoModalAdmin",
            data: parametros,              
            dataType: "JSON",                                 
            success: function(response){  
                pruebaAPIAdmin.clear();   
                var len = response.length;    
                var acImporte=0;  
                for(var i=0; i<len; i++){
                    var fecha = response[i].Fecha;
                    var  id=response[i].id;
                    //var usuario = response[i].Usuario;        
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
                    var editar='<a href="#" onclick="asignarValoresTablaGastosDepositoAdmin(\''+fecha+'\',\''+plaza+'\',\''+insumo+'\','+cantidad+','+importe+','+id+','+plaza_id+')" data-toggle="modal" data-target="#editarGastoAdminDeposito" class="btn btn-info"><span class="fa fa-edit"></span></a></td>';	
                    var eliminar='<a href="#" onclick="eliminarGastoDeposito(\''+fecha+'\','+plaza_id+','+id+','+usuario_id+','+insumo_gasto_id+','+cantidad+')" data-toggle="modal" data-target="#eliminarGastoDeposito" class="btn btn-danger"><span class="fa fa-remove"></span></a></td>';	
                    acImporte=parseFloat(acImporte)+parseFloat(importe);   
                    pruebaAPIAdmin.row.add([fecha,plaza,insumo,cantidad,unidad,"$ "+importe2,"$ "+Math.round((importe/cantidad)*100)/100,editar,eliminar]);                    
                }
                acImporte=Math.round(acImporte);
                acImporte=numberWithCommas(acImporte);
                
                pruebaAPIAdmin.row.add(["Totales","","","","",("$ "+acImporte).bold(),"","",""]);   
                pruebaAPIAdmin.draw();                                                
            },
            error: function() { 
                alert("Error posting feed.");
            }
        });        
    }   

   </script>

    



