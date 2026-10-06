<!-- DIV Content-Wrapper -->
<div class="content-wrapper">

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Historial de Pedidos
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
                                
                                    
                                    <div class="col-md-3">                                        
                                        <input type="submit" name="buscar" value="Buscar" class="btn btn-primary">                                                                                                                                                             
                                        <button type='button' class="btn btn-primary btn-flag" data-toggle="modal" data-target="#agregarFactura"><span class="glyphicon glyphicon-plus" ></span>Add Factura</button>     
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
                                    <th>F.E</th>
                                    <th>F.R</th>
                                    <th>Plz</th>                                     
                                    <th>1°F</th>
                                    <th>1°Imp</th> 
                                    <th>2°F</th>
                                    <th>2°Imp</th>
                                    <th>3°F</th>
                                    <th>3°Imp</th>
                                    <th>4°F</th>
                                    <th>4°Imp</th>  
                                    <th>TOTALES</th>
                                    <th>Ver</th>    
                                    <th>Editar</th>    
                                    <th>Eliminar</th>                                                                                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($detalles)):
                                $acImporte1=0;    
                                $acImporte2=0;
                                $acImporte3=0;
                                $acImporte4=0;
                                $acFila=0;
                                ?>  

                                <?php foreach ($detalles as $detalle):
                                $acImporte1=$acImporte1+$detalle->Importe;
                                $acImporte2=$acImporte2+$detalle->Importe2;
                                $acImporte3=$acImporte3+$detalle->Importe3;
                                $acImporte4=$acImporte4+$detalle->Importe4;
                                $acFila=
                                        $detalle->Importe+
                                        $detalle->Importe2+
                                        $detalle->Importe3+
                                        $detalle->Importe4;                                
                                ?>
                                <tr>                                                                        
                                    <td><?=$detalle->Fecha;?></td>     
                                    <td><?=$detalle->Fecha_Recepcion;?></td>                                 
                                    <td><?=$detalle->Acronimo;?></td>                                       
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
                                    <td bgcolor="#76c5ff"><b>$<?=number_format($acFila,2);?></b></td>  

                                    <td> 
                                        <button type="button" class="btn btn-info" onclick="hola('<?php echo $detalle->Fecha;?>',<?php echo $detalle->plaza_id;?>)" data-toggle="modal" data-target="#modal-default" value="">
                                            <span class="fa fa-search"></span>
                                        </button>
                                    </td>      
                                    
                                    <td> 
                                        <button type="button" class="btn btn-success" onclick="asignarValoresModalFactura('<?php echo $detalle->Fecha;?>','<?php echo $detalle->Fecha_Recepcion;?>','<?php echo $detalle->Plaza;?>','<?php echo $detalle->Factura;?>','<?php echo $detalle->Factura2;?>','<?php echo $detalle->Factura3;?>','<?php echo $detalle->Factura4;?>',<?php echo $detalle->Importe;?>,<?php echo $detalle->Importe2;?>,<?php echo $detalle->Importe3;?>,<?php echo $detalle->Importe4;?>,<?php echo $detalle->id;?>)" data-toggle="modal" data-target="#editarFactura" value="">
                                            <span class="fa fa-edit"></span>
                                        </button>
                                    </td> 
                                    
                                    <td>
                                        <button type="button" class="btn btn-danger" onclick="eliminarPedido('<?php echo $detalle->Fecha;?>',<?php echo $detalle->plaza_id;?>,<?php echo $detalle->id;?>)" >
                                            <span class="fa fa-remove"></span>
                                        </button>
                                    </td>   

                                </tr>   
                                <?php endforeach;?>       
                                <?php $acFila=$acImporte1+$acImporte2+$acImporte3+$acImporte4?>
                                <tr>
                                <td bgcolor="#76c5ff"><b>TOTALES</b></td>
                                <td bgcolor="#76c5ff"></td>
                                <td bgcolor="#76c5ff"></td>                                
                                <td bgcolor="#76c5ff"></td>
                                <td bgcolor="#76c5ff"><b>$<?php echo number_format($acImporte1,2);?></b></td>
                                <td bgcolor="#76c5ff"></td>
                                <td bgcolor="#76c5ff"><b>$<?php echo number_format($acImporte2,2);?></b></td>
                                <td bgcolor="#76c5ff"></td>
                                <td bgcolor="#76c5ff"><b>$<?php echo number_format($acImporte3,2);?></b></td>
                                <td bgcolor="#76c5ff"></td>
                                <td bgcolor="#76c5ff"><b>$<?php echo number_format($acImporte4,2);?></b></td>                                
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


<div class="modal fade" id="modal-default">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Pedido de Franquicia</h4>
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


<div class="modal fade" id="agregarFactura" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  
          <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i>Agregado de Facturas Manual</h4>
		  </div>
		  
          <div class="modal-body">
			<form class="form-horizontal" method="post" id="agregarNuevaFactura" name="agregarNuevaFactura">						                                              
            <div class="form-group">
				<label for="fecha_emision_factura_guardar" class="col-sm-3 control-label">F. Emisión:</label>
				<div class="col-sm-8">	
                <input type="date" class="form-control" name="fecha_emision_factura_guardar" id="fecha_emision_factura_guardar" value="<?php echo $fechaHoy;?>" required >
				</div>
			</div>

            <div class="form-group">
				<label for="fecha_recepcion_factura_guardar" class="col-sm-3 control-label">F. Recepción:</label>
				<div class="col-sm-8">	
                <input type="date" class="form-control" name="fecha_recepcion_factura_guardar" id="fecha_recepcion_factura_guardar" value="<?php echo $fechaHoy;?>" required>
				</div>
			</div>

            <div class="form-group">
				<label for="plaza_id_factura" class="col-sm-3 control-label">Plaza:</label>
				<div class="col-sm-8">	
                    <select name="plaza_id_factura_guardar" id="plaza_id_factura_guardar" class="form-control" required>                                                  
                        <?php foreach ($plazas as $plaza):?>  
                        <?php if($plaza->id==1):?>
                        <option value="" selected>
                            Seleccionar Plaza
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
                        <?php endforeach;?>
                    </select>  
				</div>
			</div>

            <div class="form-group">
                <label for="factura_guardar_uno" class="col-sm-3 control-label">1° Fac:</label>
                <div class="col-sm-3">	
                    <input type="number" class="form-control"step="0.001" id="factura_guardar_uno" placeholder="" name="factura_guardar_uno" value="0" required>                            
                </div>

                <label for="importe_guardar_uno" class="col-sm-2 control-label">1° Impte:</label>
                <div class="col-sm-3">	
                    <input type="number" class="form-control"step="0.001" id="importe_guardar_uno" placeholder="" name="importe_guardar_uno" value="0" required>                            
                </div>
            </div>     

            <div class="form-group">
                <label for="factura_guardar_dos" class="col-sm-3 control-label">2° Fac:</label>
                <div class="col-sm-3">	
                    <input type="number" class="form-control"step="0.001" id="factura_guardar_dos" placeholder="" name="factura_guardar_dos" value="0" required>                            
                </div>

                <label for="importe_guardar_dos" class="col-sm-2 control-label">2° Impte:</label>
                <div class="col-sm-3">	
                    <input type="number" class="form-control"step="0.001" id="importe_guardar_dos" placeholder="" name="importe_guardar_dos" value="0" required>                            
                </div>
            </div> 

            <div class="form-group">
                <label for="factura_guardar_tres" class="col-sm-3 control-label">3° Fac:</label>
                <div class="col-sm-3">	
                    <input type="number" class="form-control"step="0.001" id="factura_guardar_tres" placeholder="" name="factura_guardar_tres" value="0" required>                            
                </div>

                <label for="importe_guardar_tres" class="col-sm-2 control-label">3° Impte:</label>
                <div class="col-sm-3">	
                    <input type="number" class="form-control"step="0.001" id="importe_guardar_tres" placeholder="" name="importe_guardar_tres" value="0" required>                            
                </div>
            </div> 

            <div class="form-group">
                <label for="factura_guardar_cuatro" class="col-sm-3 control-label">4° Fac:</label>
                <div class="col-sm-3">	
                    <input type="number" class="form-control"step="0.001" id="factura_guardar_cuatro" placeholder="" name="factura_guardar_cuatro" value="0" required>                            
                </div>

                <label for="importe_guardar_cuatro" class="col-sm-2 control-label">4° Impte:</label>
                <div class="col-sm-3">	
                    <input type="number" class="form-control"step="0.001" id="importe_guardar_cuatro" placeholder="" name="importe_guardar_cuatro" value="0" required>                            
                </div>
            </div> 



		    </div>    
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" id="agregar_nueva_factura">Guardar datos</button>
		  </div>
		  </form>
		</div>
	  </div>
</div>


<div class="modal fade" id="editarFactura" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  
          <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i>Edición Manual de Facturas</h4>
		  </div>
		  
          <div class="modal-body">
			<form class="form-horizontal" method="post" id="editarFacturaCapturada" name="editarFacturaCapturada">						                        
            <input type="hidden" name="code_factura" id="code_factura">            

            <div class="form-group">
				<label for="fecha_emision_factura_editar" class="col-sm-3 control-label">F. Emisión:</label>
				<div class="col-sm-8">	
                <input type="date" class="form-control" name="fecha_emision_factura_editar" id="fecha_emision_factura_editar" value="" required >
				</div>
			</div>

            <div class="form-group">
				<label for="fecha_recepcion_factura_editar" class="col-sm-3 control-label">F. Recepción:</label>
				<div class="col-sm-8">	
                <input type="date" class="form-control" name="fecha_recepcion_factura_editar" id="fecha_recepcion_factura_editar" value="" required>
				</div>
			</div>

            <div class="form-group">
				<label for="plaza_factura_editar" class="col-sm-3 control-label">Plaza:</label>
				<div class="col-sm-8">	
                    <input type="text" class="form-control" name="plaza_factura_editar" id="plaza_factura_editar" value="" required readonly>
				</div>
			</div>

            <div class="form-group">
                <label for="factura_editar_uno" class="col-sm-3 control-label">1° Fac:</label>
                <div class="col-sm-3">	
                    <input type="number" class="form-control"step="0.001" id="factura_editar_uno" placeholder="" name="factura_editar_uno" value="0" required>                            
                </div>

                <label for="importe_editar_uno" class="col-sm-2 control-label">1° Impte:</label>
                <div class="col-sm-3">	
                    <input type="number" class="form-control"step="0.001" id="importe_editar_uno" placeholder="" name="importe_editar_uno" value="0" required>                            
                </div>
            </div>     

            <div class="form-group">
                <label for="factura_editar_dos" class="col-sm-3 control-label">2° Fac:</label>
                <div class="col-sm-3">	
                    <input type="number" class="form-control"step="0.001" id="factura_editar_dos" placeholder="" name="factura_editar_dos" value="0" required>                            
                </div>

                <label for="importe_editar_dos" class="col-sm-2 control-label">2° Impte:</label>
                <div class="col-sm-3">	
                    <input type="number" class="form-control"step="0.001" id="importe_editar_dos" placeholder="" name="importe_editar_dos" value="0" required>                            
                </div>
            </div> 

            <div class="form-group">
                <label for="factura_editar_tres" class="col-sm-3 control-label">3° Fac:</label>
                <div class="col-sm-3">	
                    <input type="number" class="form-control"step="0.001" id="factura_editar_tres" placeholder="" name="factura_editar_tres" value="0" required>                            
                </div>

                <label for="importe_editar_tres" class="col-sm-2 control-label">3° Impte:</label>
                <div class="col-sm-3">	
                    <input type="number" class="form-control"step="0.001" id="importe_editar_tres" placeholder="" name="importe_editar_tres" value="0" required>                            
                </div>
            </div> 

            <div class="form-group">
                <label for="factura_editar_cuatro" class="col-sm-3 control-label">4° Fac:</label>
                <div class="col-sm-3">	
                    <input type="number" class="form-control"step="0.001" id="factura_editar_cuatro" placeholder="" name="factura_editar_cuatro" value="0" required>                            
                </div>

                <label for="importe_editar_cuatro" class="col-sm-2 control-label">4° Impte:</label>
                <div class="col-sm-3">	
                    <input type="number" class="form-control"step="0.001" id="importe_editar_cuatro" placeholder="" name="importe_editar_cuatro" value="0" required>                            
                </div>
            </div> 


		    </div>    
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" id="agregar_nueva_factura">Guardar datos</button>
		  </div>
		  </form>
		</div>
	  </div>
</div>



<script type="text/javascript">  

//#region REGISTRAR FACTURA 
$( "#agregarNuevaFactura" ).submit(function( event ) {
            //$('#guardar_fila2').attr("disabled", true);  
                var parametros = $(this).serialize();
                //alert(parametros);
                //alert("Agregando Fila a la tabla de depósitos 2DA Versión");
                $.ajax({
                        type: "POST",
                        url: "<?php echo base_url();?>Pedidos/storeFacturaAjax",
                        data: parametros,
                        success: function(datos){                                                                
                                if(datos==1){                                
                                swal({
                                position: 'top-end',
                                type: 'success',
                                title: 'Factura guardada!!!',
                                showConfirmButton: false,
                                timer: 500
                                }).then(function() {                                                            
                                    location.reload();
                            });	
                                
                                }else if(datos==0){
                                    swal({
                                type: 'error',
                                title: 'Error al guardar factura',
                                text: 'Ocurrio un error al registrar la factura'                    
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


//#region ACTUALIZAR FACTURA
$( "#editarFacturaCapturada" ).submit(function( event ) {
            //$('#actualizar_fila2').attr("disabled", true);  
                var parametros = $(this).serialize();                                    
                //alert(parametros);                    

                $.ajax({
                        type: "POST",
                        url: "<?php echo base_url();?>Pedidos/actualizarFacturaAjax",
                        data: parametros,
                        success: function(datos){   
                           //alert(datos);                             
                                if(datos==1){

                                swal({
                                position: 'top-end',
                                type: 'success',
                                title: 'Registro actualizado!!!',
                                showConfirmButton: false,
                                timer: 1500
                                }).then(function() {                                                            
                                    location.reload();
                            });	
                            
                                }else if(datos==0){
                                    swal({
                                type: 'error',
                                title: 'Error en el registro',
                                text: 'Ocurrio un error al actualizar el depósito'                    
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

function asignarValoresModalFactura(fechaEmision,fechaRecepcion,plaza,unoF,dosF,tresF,cuatroF,unoI,dosI,tresI,cuatroI,code){                                                          
        $('#plaza_factura_editar').val(plaza);  
        $('#fecha_recepcion_factura_editar').val(fechaRecepcion);  
        $('#fecha_emision_factura_editar').val(fechaEmision);  
        $('#importe_editar_uno').val(unoI);
        $('#factura_editar_uno').val(unoF);    
        $('#importe_editar_dos').val(dosI);
        $('#factura_editar_dos').val(dosF);
        $('#importe_editar_tres').val(tresI);
        $('#factura_editar_tres').val(tresF);
        $('#importe_editar_cuatro').val(cuatroI);
        $('#factura_editar_cuatro').val(cuatroF);  
        $('#code_factura').val(code);  

    }


</script>

    





