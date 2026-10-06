<!-- =============================================== -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Insumos
        <small>Listado</small>
        </h1>
        <a href="<?php echo base_url(); ?>Productos" class="small-box-footer">Volver al Panel de Productos <i class="fa fa-arrow-circle-right"></i></a>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box box-solid">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <a href="#" class="btn btn-primary btn-flag" data-toggle="modal" data-target="#agregarInsumo"><span class="fa fa-plus"></span>
                        Agregar Insumo
                        </a>
                    </div>
                    </div>
                    <hr>
                    <div class="row">
                    <div class="col-md-12">
                    <table class="display responsive table table-bordered  btn-hover" style="width:100%" id="tbl_configuracion_insumos">
                    <thead>
                        <tr>
                            <th>#</th>                                    
                            <th>Nombre</th>                                                                                                                                                                                 
                            <th>Clave Ped</th> 
                            <th>U Ini</th> 
                            <th>U Fin</th> 
                            <th>U Ped</th> 
                            <!-- <th>InvP</th>
                            <th>InvF</th> -->
                            <th>Operaciones</th>                                  
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($insumos)):?>
                        <?php foreach ($insumos as $insumo):?>
                            <tr>                                    
                            <td><?=$insumo->id;?></td>                                    
                            <td><?=$insumo->Nombre;?></td>                                                                               
                            <td><?=$insumo->clave_pedido;?></td>
                            <td><?=$insumo->Unidad;?></td>   
                            <td><?=$insumo->UnidadPedido;?></td>   
                            <td><?=$insumo->UnidadFinal;?></td>                                                                         
                            <!-- <td></td> -->   
                            <!-- <td></td> -->   
                            <td>
                                <button href="#" class="btn btn-success" onclick="configurarInsumo(<?php echo $insumo->id;?>)" data-toggle="modal" data-target="#modalConfiguracionInsumo">
                                    <span class="fa fa-edit"></span>
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
        </div>                
    </section>            
</div>        

<!--No terminado aún-->
<div class="modal fade" id="agregarInsumo">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Nuevo Insumo</h4>
            </div>            
            <div class="modal-body">
            <form class="form-horizontal" method="post" id="guardarNuevoInsumo" name="guardarNuevoInsumo">
                
            <div class="form-group">
                <label for="categoria_id" class="col-sm-3 control-label">Categoria:</label>
                <div class="col-sm-8">	
                    <select name="categoria_id" id="categoria_id" class="form-control" required>
                        <option value="">Seleccionar Categoria</option>
                            <?php foreach ($categorias as $categoria):?>                                            
                                <option value="<?php echo $categoria->id?>">
                                    <?php echo $categoria->Nombre;?>
                                </option>
                            <?php endforeach;?>
                    </select>
                </div>
            </div>

            <div class="form-group" required>
                <label for="nombre" class="col-sm-3 control-label">Nombre:</label>
                <div class="col-sm-8">     
                    <input type="text" class="form-control"step="0.001" id="nombre" placeholder="" name="nombre" value="" required>                                                                          
                </div>				
            </div>
        
            <div class="form-group">
                <label for="inventario" class="col-sm-3 control-label">Inventariado:</label>
                <div class="col-sm-8">  
                <label class="radio-inline">
                    <input type="radio" name="inventario" id="inventario" value="1" onclick="checarInventario(1)" >Si
                </label>
                <label class="radio-inline">
                    <input type="radio" name="inventario" id="inventario" value="0" checked="checked" onclick="checarInventario(0)" >No
                </label>
                </div>
            </div>

            <div class="form-group" id="unit_prod">
                <label for="unidad_id_produccion" class="col-sm-3 control-label">Unidad Inv Prod:</label>
                <div class="col-sm-8">	
                    <select name="unidad_id_produccion" id="unidad_id_produccion" class="form-control" required>
                        <option value="">Seleccionar Unidad</option>
                            <?php foreach ($unidades as $unidad):?>                                            
                                <option value="<?php echo $unidad->id?>">
                                    <?php echo $unidad->Nombre;?>
                                </option>
                            <?php endforeach;?>
                    </select>
                </div>
            </div>


            <div class="form-group">
                <label for="inventario_fisico" class="col-sm-3 control-label">Inv.Físico:</label>
                <div class="col-sm-8">  
                <label class="radio-inline">
                    <input type="radio" name="inventario_fisico" id="inventario_fisico" value="1" onclick="checarInventarioFisico(1)" >Si
                </label>
                <label class="radio-inline">
                    <input type="radio" name="inventario_fisico" id="inventario_fisico" value="0" onclick="checarInventarioFisico(0)" checked="checked">No
                </label>
                </div>
            </div>

            <div class="form-group" id="unit_id_piso">
                <label for="unidad_id_piso" class="col-sm-3 control-label">Unidad Piso:</label>
                <div class="col-sm-3">	
                    <select name="unidad_id_piso" id="unidad_id_piso" class="form-control" required>
                        <option value="">Seleccionar Unidad</option>
                            <?php foreach ($unidades as $unidad):?>                                            
                                <option value="<?php echo $unidad->id?>">
                                    <?php echo $unidad->Nombre;?>
                                </option>
                            <?php endforeach;?>
                    </select>
                </div>

            <label for="formula_piso" class="col-sm-2   control-label">Formula Piso</label>
            <div class="col-sm-3">	
                <input type="text" class="form-control"step="0.001" id="formula_piso" placeholder="" name="formula_piso" value="*,1" required>                            
            </div>

            </div>


            <div class="form-group" id="unit_id_bodega">
                <label for="unidad_id_bodega" class="col-sm-3 control-label">Unidad Bodega:</label>
                
                <div class="col-sm-3">	
                    <select name="unidad_id_bodega" id="unidad_id_bodega" class="form-control" required>
                        <option value="">Seleccionar Unidad</option>
                            <?php foreach ($unidades as $unidad):?>                                            
                                <option value="<?php echo $unidad->id?>">
                                    <?php echo $unidad->Nombre;?>
                                </option>
                            <?php endforeach;?>
                    </select>
                </div>

            <label for="formula_bodega" class="col-sm-2   control-label">Formula Bodega</label>
            <div class="col-sm-3">	
                <input type="text" class="form-control"step="0.001" id="formula_bodega" placeholder="" name="formula_bodega" value="*,1" required>                            
            </div>

            </div>


            <div class="form-group" id="unit_id_total">
                <label for="unidad_id_total" class="col-sm-3 control-label">Unidad Total:</label>
                <div class="col-sm-3">	
                    <select name="unidad_id_total" id="unidad_id_total" class="form-control" required>
                        <option value="">Seleccionar Unidad</option>
                            <?php foreach ($unidades as $unidad):?>                                            
                                <option value="<?php echo $unidad->id?>">
                                    <?php echo $unidad->Nombre;?>
                                </option>
                            <?php endforeach;?>
                    </select>
                </div>

                <label for="formula_total" class="col-sm-2   control-label">Formula Total</label>
                <div class="col-sm-3">	
                    <input type="text" class="form-control"step="0.001" id="formula_total" placeholder="" name="formula_total" value="*,1" required>                            
                </div>
            </div>
        
            <div class="form-group">
                <label for="remesa" class="col-sm-3 control-label">Remesa:</label>
                <div class="col-sm-8">  
                <label class="radio-inline">
                    <input type="radio" name="remesa" id="remesa" value="1" onclick="checarRemesa(1)" >Si
                </label>
                <label class="radio-inline">
                    <input type="radio" name="remesa" id="remesa" value="0" checked="checked" onclick="checarRemesa(0)">No
                </label>
                </div>
            </div>

            <div class="form-group" id="unit_grupos_remesa">
                <label for="categoria_id_remesa" class="col-sm-3 control-label">Grupo Remesa:</label>
                <div class="col-sm-8">	
                    <select name="categoria_id_remesa" id="categoria_id_remesa" class="form-control" required>
                        <option value="">Seleccionar Categoria</option>
                            <?php foreach ($gruposRemesa as $grupoRemesa):?>                                            
                                <option value="<?php echo $grupoRemesa->id?>">
                                    <?php echo $grupoRemesa->Nombre;?>
                                </option>
                            <?php endforeach;?>
                    </select>
                </div>
            </div>

            <div class="form-group" id="unit_remesa">
                <label for="unidad_id_remesa" class="col-sm-3 control-label">Unidad Remesa:</label>
                <div class="col-sm-3">	
                    <select name="unidad_id_remesa" id="unidad_id_remesa" class="form-control" required>
                        <option value="">Seleccionar Unidad</option>
                            <?php foreach ($unidades as $unidad):?>                                            
                                <option value="<?php echo $unidad->id?>">
                                    <?php echo $unidad->Nombre;?>
                                </option>
                            <?php endforeach;?>
                    </select>
                </div>

            <label for="limite_captura_remesa" class="col-sm-2   control-label">Limite Captura</label>
                <div class="col-sm-3">	
                    <input type="number" min="0" class="form-control"step="0.001" id="limite_captura_remesa" placeholder="" name="limite_captura_remesa" value="*,1" required>                            
                </div>                	
            </div>

            <div class="form-group">
                <label for="pedido" class="col-sm-3 control-label">Pedido:</label>
                <div class="col-sm-8">  
                <label class="radio-inline">
                    <input type="radio" name="pedido" id="pedido" value="1" onclick="checarPedido(1)"  >Si
                </label>
                <label class="radio-inline">
                    <input type="radio" name="pedido" id="pedido" value="0" checked="checked" onclick="checarPedido(0)">No
                </label>
                </div>
            </div>

            <div class="form-group" id="unit_clave_pedido" required>
            <label for="clave_pedido" class="col-sm-3 control-label">Clave Pedido:</label>
            <div class="col-sm-8">     
                <input type="text" class="form-control" id="clave_pedido" placeholder="" name="clave_pedido" value="" required>                                                                          
            </div>				

            </div>

            <div class="form-group" id="unit_pedido">				
                <label for="unidad_id_pedido" class="col-sm-3 control-label">Unidad Pedido:</label>
                <div class="col-sm-3">	
                    <select name="unidad_id_pedido" id="unidad_id_pedido" class="form-control" required>
                        <option value="">Seleccionar Unidad</option>
                            <?php foreach ($unidades as $unidad):?>                                            
                                <option value="<?php echo $unidad->id?>">
                                    <?php echo $unidad->Nombre;?>
                                </option>
                            <?php endforeach;?>
                    </select>
                </div>

                <label for="formula_pedido" class="col-sm-2   control-label">Formula Pedido</label>
                    <div class="col-sm-3">	
                        <input type="text" class="form-control"step="0.001" id="formula_pedido" placeholder="" name="formula_pedido" value="*,1" required>                            
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <!-- <button type="submit" class="btn btn-primary" id="guardar_captura_insumo">Guardar datos</button> -->
            </div>
            </form>
        
        </div>        
    </div>    
</div>

<div class="modal fade" id="modalConfiguracionInsumo">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Configurando Insumo</h4>        
      </div>
      
      <div class="modal-body">                    
      <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" >
            <thead>
                <tr>                                    
                    <th>Bodega</th>                                                                                                                                                                                      
                    <!-- <th>Piso</th>     
                    <th>Total</th>     
                    <th>DLC</th>  -->    
                    <th>Pedido</th>    
                    <th>Editar</th>     
                </tr>
            </thead>
            <tbody id="tbl_modal_insumo">                
            </tbody>                            
        </table> 
      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cerrar</button>
      </div>
    </div>    
  </div>  
</div>

<div class="modal fade" id="editarOperacionInsumo">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Modificación de operaciones</h4>
            </div>            
            <div class="modal-body">
            <form class="form-horizontal" method="post" id="guardarOperacionInsumo" name="guardarOperacionInsumo">            
            <input type="hidden" value="" name="id_operacion_insumo" id="id_operacion_insumo">
            
              <div class="form-group" required>
				<label for="bodega_operacion_insumo" class="col-sm-3 control-label">Bodega: </label>
                <div class="col-sm-8">     
                    <input type="text" class="form-control"  id="bodega_operacion_insumo" placeholder="" name="bodega_operacion_insumo" value="" required>                                                                          
                </div>				
              </div>

              <!-- <div class="form-group" required>
				<label for="piso_operacion_insumo" class="col-sm-3 control-label">Piso: </label>
                <div class="col-sm-8">     
                    <input type="text" class="form-control" id="piso_operacion_insumo" placeholder="" name="piso_operacion_insumo" value="" required>                                                                          
                </div>				
              </div> -->


              <!-- <div class="form-group" required>
				<label for="total_operacion_insumo" class="col-sm-3 control-label">Total: </label>
                <div class="col-sm-8">     
                    <input type="text" class="form-control"     id="total_operacion_insumo" placeholder="" name="total_operacion_insumo" value="" required >                                                                          
                </div>				
              </div> -->

              <!-- <div class="form-group" required>
				<label for="dlc_operacion_insumo" class="col-sm-3 control-label">DLC: </label>
                <div class="col-sm-8">     
                    <input type="text" class="form-control"     id="dlc_operacion_insumo" placeholder="" name="dlc_operacion_insumo" value="" required >                                                                          
                </div>				
              </div> -->

              <div class="form-group" required>
				<label for="pedido_operacion_insumo" class="col-sm-3 control-label">Pedido: </label>
                <div class="col-sm-8">     
                    <input type="text" class="form-control" id="pedido_operacion_insumo" placeholder="" name="pedido_operacion_insumo" value="" required >                                                                          
                </div>				
              </div>

                                 
            </div>
            <div class="modal-footer">
			    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			    <button type="submit" class="btn btn-primary" id="guardar_operacion_insumo">Guardar datos</button>
		    </div>
            </form>
        
        </div>
        <!-- /.modal-content -->
    </div>    
</div>

<script type="text/javascript">  
//#region ACTUALIZACIÓN DE FORMULAS
$( "#guardarOperacionInsumo" ).submit(function( event ) {
        //$('#guardar_operacion_insumo').attr("disabled", true);                   
        var parametros = $(this).serialize();                
        
            $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>Insumos/actualizarOperaciones",
            data: parametros,            
            dataType:'JSON',
            success: function(response){                
                if(response[0].value){                                                                                        
                    swal({
                        position: 'top-end',
                        type: 'success',
                        title: 'Insumo actualizado!!',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {      
                        $('#editarOperacionInsumo').modal('hide');
                        $('#modalConfiguracionInsumo').modal('hide');                            
                    });	  
                }else{                    
                    swal({
                        position: 'top-end',
                        type: 'info',
                        title: 'Oops ha ocurrido un error',
                        text: response[0].data,
                        showConfirmButton: false,
                        timer: 1500
                    });
                }                             
            },
            error: function() { 
                alert("Error posting feed");
            }
        });
        event.preventDefault();
    });
//#endregion 

//#region AGREGAR INSUMOS
$( "#guardarNuevoInsumo" ).submit(function( event ) {                        
        var parametros = $(this).serialize();  
        alert(parametros);             
                    $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>Insumos/saveDontExist",
                    data: parametros,                
                    success: function(response){ 
                        alert(response);
                        if(response==1){
                            swal({
                                position: 'top-end',
                                type: 'success',
                                title: 'Insumo registrado correctamente!!',
                                showConfirmButton: false,
                                timer: 1000
                                }).then(function() {                                                            
                                    location.reload(); 
                            });	
                        }
                        else if(response==0){                                      
                            swal({
                                position: 'top-end',
                                type: 'error',
                                title: 'El insumo debe agregarse en al menos una opción',
                                showConfirmButton: false,
                                timer: 1500
                                }).then(function() {                                                                                                                                      
                            });
                        }                                     
                    },
                    error: function() { 
                        alert("Error posting feed.");
                    }
                });
                event.preventDefault();
            });
//#endregion

function checarInventario(valor){        
        if(valor==0){            
            $('#unit_prod').hide(); 
            $("#unidad_id_produccion").removeAttr('required');
        }else if(valor==1){
            $('#unit_prod').show();
            $("#unidad_id_produccion").attr('required', ''); 
        }
}

function checarInventarioFisico(valor){        
        if(valor==0){    
            $('#unit_id_bodega').hide();
            $('#unit_id_piso').hide();
            $('#unit_id_total').hide();

            $("#unidad_id_piso").removeAttr('required');
            $("#formula_piso").removeAttr('required');
            $("#unidad_id_bodega").removeAttr('required');
            $("#formula_bodega").removeAttr('required');
            $("#unidad_id_total").removeAttr('required');
            $("#formula_total").removeAttr('required');

        }else if(valor==1){
            $('#unit_id_bodega').show();
            $('#unit_id_piso').show();
            $('#unit_id_total').show();

            $("#unidad_id_piso").attr('required', ''); 
            $("#formula_piso").attr('required', ''); 
            $("#unidad_id_bodega").attr('required', ''); 
            $("#formula_bodega").attr('required', ''); 
            $("#unidad_id_total").attr('required', ''); 
            $("#formula_total").attr('required', ''); 
        }
}

function checarRemesa(valor){        
        if(valor==0){            
            $('#unit_remesa').hide();
            $('#unit_grupos_remesa').hide();

            $("#categoria_id_remesa").removeAttr('required');
            $("#unidad_id_remesa").removeAttr('required');
            $("#limite_captura_remesa").removeAttr('required');            
        }else if(valor==1){
            $('#unit_remesa').show();
            $('#unit_grupos_remesa').show();    

            $("#categoria_id_remesa").attr('required', ''); 
            $("#unidad_id_remesa").attr('required', ''); 
            $("#limite_captura_remesa").attr('required', '');         
        }
}

function checarPedido(valor){        
        if(valor==0){            
            $('#unit_pedido').hide();
            $('#unit_clave_pedido').hide();

            $("#clave_pedido").removeAttr('required');
            $("#unidad_id_pedido").removeAttr('required');
            $("#formula_pedido").removeAttr('required');  
        }else if(valor==1){
            $('#unit_pedido').show();
            $('#unit_clave_pedido').show();

            $("#clave_pedido").attr('required', ''); 
            $("#unidad_id_pedido").attr('required', ''); 
            $("#formula_pedido").attr('required', ''); 
        }
}

function configurarInsumo(insumo_id){     
    //var e = document.getElementById("insumo_id_formulas");
    //var insumo_id = e.options[e.selectedIndex].value;
    var parametros = {                
            "insumo_id":insumo_id                           
            };                         
            $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>Insumos/consultarOperacionesInsumo",
            data: parametros,
            dataType: "JSON",                                               
            success: function(response){ 
                var len = response.length;
                for(var i=0; i<len; i++){
                        var tabla  = response[i].tabla;                                                        
                }                  
                $('#tbl_modal_insumo').html(tabla);                                                            
            },
            error: function() { 
                alert("Error posting feed.");
            }
        });      
}

function asignarValoresModalOperacionesInsumo(id,bodega,pedido){
    $('#id_operacion_insumo').val(id);
    $('#bodega_operacion_insumo').val(bodega);        
    $('#pedido_operacion_insumo').val(pedido);      
}

/* function asignarValoresModalOperacionesInsumo(id,bodega,piso,total,dlc,pedido){
    $('#id_operacion_insumo').val(id);
    $('#bodega_operacion_insumo').val(bodega);
    $('#piso_operacion_insumo').val(piso);
    $('#total_operacion_insumo').val(total);
    $('#dlc_operacion_insumo').val(dlc);
    $('#pedido_operacion_insumo').val(pedido);      
} */

//Configuración de el datatable
$('#tbl_configuracion_insumos').DataTable({
    dom: 'Bfrtip',
    "pageLength": 300,         
    buttons: [
        {
            extend: 'excelHtml5',
            title: "Datos Insumos"            
        },
        {
            extend: 'pdfHtml5',
            title: "Datos Insumos"          
        },{
            title: "Datos Insumos"   ,
            extend:'copy'              
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

