
        <!-- =============================================== -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                Formulas
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
                            <div class="col-md-6">
                                <button  class="btn btn-primary btn-flag" data-toggle="modal" data-target="#agregarFormula"><span class="fa fa-plus"></span>
                                Agregar Formula
                                </button>
                            </div>
                            <div class="col-md-6">
                                <label for="producto_idF">Producto:</label>
                                    <select name="producto_idF" id="producto_idF" class="form-control">
                                    <option value="" selected>
                                                        Todos los productos
                                    </option>
                                        <?php foreach ($productos as $producto):?>                                                                                  
                                        <option value="<?php echo $producto->id?>">
                                        <?php
                                            echo $producto->Nombre;?>
                                        </option>                                       
                                        <?php endforeach;?>
                                    </select>
                                    <input type="hidden" name="hidden_country" id="hidden_country" />
                            </div>
                         </div>
                         <hr>
                         <div class="row">
                            <div class="col-md-12">
                            <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_todas_formulas">
                            <thead>
                                <tr>
                                    
                                    <th>Nombre</th>
                                    <th>Insumo</th>
                                    <th>Cantidad</th>                                                                                                            
                                    <th>Editar</th>
                                    <th>Eliminar</th>                                            
                                </tr>
                            </thead>
                            <tbody>
                            <?php if(!empty($formulas)):?>
                                <?php foreach ($formulas as $formula):?>
                                   <tr>
                                    <td><?=$formula->Nombre;?></td>
                                    <td><?=$formula->Insumo;?></td>
                                    <td><?=$formula->Cantidad;?></td>  
                                                                                                                               
                                    
                                    <td> 
                                    <button type="button" class="btn btn-info" onclick="asignarValoresModalFormula(<?php echo $formula->id;?>,<?php echo $formula->insumo_id;?>,'<?php echo $formula->Nombre;?>','<?php echo $formula->Insumo;?>',<?php echo $formula->Cantidad;?>)"  data-toggle="modal" data-target="#editarCantidadFormula" value="">
                                        <span class="fa fa-edit"></span>
                                    </button>
                                    </td>   
                                    
                                    <td>                                    
                                    
                                    <button class="btn btn-danger btn-remove" onclick="eliminarFormula(<?php echo $formula->id;?>)">
                                            <span class="fa fa-remove">
                                            </span></button>
                                    </td>
                                </tr>   
                                <?php endforeach;?>                                                              
                                <?php endif;?>     
                            
                            </tbody>                            
                            </table>


                            <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_todas_formulas_ajax">
                            <thead>
                                <tr>
                                    
                                    <th>Nombre</th>
                                    <th>Insumo</th>
                                    <th>Cantidad</th>  
                                    <th>Editar</th>
                                    <th>Eliminar</th>                                                                                                                                                            
                                </tr>
                            </thead>
                            <tbody id="tbodyFormulasAjax">                                                       
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

        <div class="modal fade" id="editarCantidadFormula">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Modificación de fórmulas</h4>
            </div>            
            <div class="modal-body">
            <form class="form-horizontal" method="post" id="guardarCapturaFormula" name="guardarCapturaFormula">
            <input type="hidden" value="" name="id" id="id">
            <input type="hidden" value="" name="insumo_id" id="insumo_id">

              <div class="form-group" required>
				<label for="producto" class="col-sm-3 control-label">Producto: </label>
                <div class="col-sm-8">     
                    <input type="text" class="form-control"step="0.001" id="producto" placeholder="" name="producto" value="" required readonly>                                                                          
                </div>				
              </div>

              <div class="form-group" required>
				<label for="insumo" class="col-sm-3 control-label">Insumo: </label>
                <div class="col-sm-8">     
                    <input type="text" class="form-control"step="0.001" id="insumo" placeholder="" name="insumo" value="" required readonly>                                                                          
                </div>				
              </div>


              <div class="form-group" required>
				<label for="cantidadFormula" class="col-sm-3 control-label">Cantidad: </label>
                <div class="col-sm-8">     
                    <input type="number" class="form-control" min="0" step="0.001" lang="en"  id="cantidadFormula" placeholder="" name="cantidadFormula" value="" required >                                                                          
                </div>				
              </div>

                                 
            </div>
            <div class="modal-footer">
			    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			    <button type="submit" class="btn btn-primary" id="guardar_captura_formula">Guardar datos</button>
		    </div>
            </form>
        
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<div class="modal fade" id="agregarFormula">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Nueva Fórmula</h4>
            </div>            
            <div class="modal-body">
            <form class="form-horizontal" method="post" id="guardarFormula" name="guardarFormula">

                    <div class="form-group">                           
                           <div class="col-md-6">
                               <label for="producto_id">Producto:</label>
                                   <select name="producto_id" id="producto_id" class="form-control">
                                       <?php foreach ($productos as $producto):?>                        
                                       <option value="<?php echo $producto->id?>">
                                       <?php
                                           echo $producto->Nombre;?>
                                       </option>
                                       <?php endforeach;?>
                                   </select>
                           </div>        

                              <div class="col-md-6">
                                <label for="insumo_id_formulas">Insumo:</label>
                                    <select name="insumo_id_formulas" id="insumo_id_formulas" class="form-control">
                                        <?php foreach ($insumos as $insumo):?>                                            
                                        <option value="<?php echo $insumo->id?>">
                                        <?php
                                            echo $insumo->Nombre;?>
                                        </option>
                                        <?php endforeach;?>
                                    </select>
                            </div>
                                                                   
                   </div>

                   
                   <div class="form-group">                
                        <div class="col-md-6">
                                <label for="cantidad">Cantidad:</label>
                                <input type="number" step="any" class="form-control" name="cantidad" id="cantidad" value="" required>                                                                
                        </div>
                                                  
                            <div class="col-md-6">
                            <label for="unidad_id_formulas">Unidad: </label>     
                                <select name="unidad_id_formulas" id="unidad_id_formulas" class="form-control" >
                                    <option value="">Sin Unidad</option>   
                                </select>                                              
                            </div>				                                                
                
                    </div>                                                                     
            </div>
            <div class="modal-footer">
			    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			    <button type="submit" class="btn btn-primary" id="guardar_captura_formula">Guardar datos</button>
		    </div>
            </form>
        
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<script type="text/javascript">  

//#region CONSULTA DE LAS FORMULAS POR COMBOBOX   
$('#producto_idF').change(function(e){
        
        $('#hidden_country').val($('#producto_idF').val());        
        var query = $('#hidden_country').val();   
        bandera=1;          
        if(query==""){
            bandera=0;              
        }
            
        var parametros = {
            "producto_id" : query,
            "bandera" : bandera                              
            };  
    $.ajax({
        type: "POST",
        url: "<?php echo base_url();?>Formulas/consultarFormula",
        data: parametros,             
        success: function(response){                                        
            $('#tbl_todas_formulas').remove();
            $("#tbl_todas_formulas_ajax").show();                
            $('#tbodyFormulasAjax').html(response);                 
        },
        error: function() { alert("Error posting feed."); }
    }); 
        //window.location= "<?php echo base_url();?>Formulas/list2/"+query 
    });
//#endregion

//#region GUARDADO DE LAS FÓRMULAS POR AJAX NUEVO
$( "#guardarFormula" ).submit(function( event ) {                        
            var parametros = $(this).serialize();    
            alert(parametros);           
                $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>Formulas/store",
                data: parametros,      
                dataType: "JSON", 
                success: function(response){ 
                    var len = response.length;                    
                    for(var i=0; i<len; i++){
                        var correcto  = response[i].correcto;
                        var formula = response[i].formula;            
                    }

                    if(correcto==1){
                        swal({
                        position: 'top-end',
                        type: 'success',
                        title: 'Fórmula  registrada correctamente!!',
                        showConfirmButton: false,
                        timer: 1000
                        });
                    }  
                    else if(correcto==0){
                        swal({
                        position: 'top-end',
                        type: 'error',
                        title: 'Ha ocurrido un error, Fórmula no registrada!!',
                        showConfirmButton: false,
                        timer: 1500
                        });

                    }
                    else{
                        swal({
                        position: 'top-end',
                        type: 'error',
                        title: 'Ha ocurrido un error FEED, Fórmula no registrada!!',
                        showConfirmButton: false,
                        timer: 1500
                        });
                    } 

                    $('#tbl_modal_formula').html(formula);

                    $('input[type="number"],cantidad').val('');                                        
                },
                error: function() { 
                    alert("Error posting feed.");
                }
            });
            event.preventDefault();
        });
//#endregion 

//#region ACTUALIZACIÓN DE FORMULAS
$( "#guardarCapturaFormula" ).submit(function( event ) {
        //$('#guardar_captura_inventario').attr("disabled", true);   
        $('#hidden_country').val($('#producto_idF').val());        
        var producto_id = $('#hidden_country').val();   
        var parametros = $(this).serialize();
            
            $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>Formulas/actualizarFormula",
            data: parametros+"&producto_id="+producto_id+"&bandera="+bandera,                
            success: function(response){ 
              //  alert(response);
                if(response==0){
                    swal({
                        position: 'top-end',
                        type: 'error',
                        title: 'Ha ocurrido un error, fórmula no actualizada!!',
                        showConfirmButton: false,
                        timer: 1500
                        }).then(function() {                                                            
                            $('#editarCantidadFormula').modal('hide');                                       
                    });

                }else{                      
                    swal({
                        position: 'top-end',
                        type: 'success',
                        title: 'Formula actualizada correctamente!!',
                        showConfirmButton: false,
                        timer: 1000
                        }).then(function() {                                                            
                            $('#editarCantidadFormula').modal('hide');
                            $('#tbl_todas_formulas').remove();
                            $("#tbl_todas_formulas_ajax").show();                
                            $('#tbodyFormulasAjax').html(response);                                         
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

function asignarValoresModalFormula(id,insumo_id,producto,insumo,cantidad){
        $('#id').val(id);
        $('#insumo_id').val(insumo_id);          
        $('#producto').val(producto);          
        $('#insumo').val(insumo);          
        $('#cantidadFormula').val(cantidad);  
    }


    //AJAX REQUEST
    function eliminarFormula(producto_id,id){                           
    var parametros = {
            "producto_id":producto_id,
            "id" : id                            
            };     
            swal({
            title: '¿Está seguro?',
            text: "Eliminación de fórmula asociada",
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
                    url: "<?php echo base_url();?>Formulas/delete",
                    data: parametros,    
                    dataType: "JSON",                                      
                    success: function(response)
                    {     
                        var len = response.length;
                        for(var i=0; i<len; i++){
                                var formula  = response[i].formula;
                                var correcto = response[i].correcto;            
                        }        
                        
                    if(correcto==1){
                    swal({
                    position: 'top-end',
                    type: 'success',
                    title: 'Fórmula  eliminada correctamente!!',
                    showConfirmButton: false,
                    timer: 1000
                    });
                }  
                else if(correcto==0){
                    swal({
                    position: 'top-end',
                    type: 'error',
                    title: 'Ha ocurrido un error, Fórmula no eliminada!!',
                    showConfirmButton: false,
                    timer: 1500
                    });
                }
                else{
                    swal({
                    position: 'top-end',
                    type: 'error',
                    title: 'Ha ocurrido un error FEED, Fórmula no eliminada!!',
                    showConfirmButton: false,
                    timer: 1500
                    });
                }                                                        
                        $('#tbl_modal_formula').html(formula);

                    },
                    error: function() { alert("Error posting feed."); }
                });                    
            }                
            });  
    }


    //#region AL CAMBIAR EL INSUMO DE LA FORMULA SE ACTUALIZA LA UNIDAD
    $('#insumo_id_formulas').change(function(){
            $('#unidad_id_formulas').html('<option value="">Unidad</option>');
                var insumo_id_formulas = $('#insumo_id_formulas').val();   
                //alert(insumo_id_formulas);                              
                if(insumo_id_formulas != ''){
                    $.ajax({
                        url:"<?php echo base_url(); ?>Formulas/consultarUnidad",
                        method:"POST",
                        data:{insumo_id_formulas:insumo_id_formulas},
                        success:function(data){ 
                            //alert(data);
                        $('#unidad_id_formulas').html(data);                                                          
                        }
                    });        
                }
        });
    //#endregion



</script>

