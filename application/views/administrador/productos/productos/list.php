
        <!-- =============================================== -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                Productos
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
                                <form action="<?php echo current_url();?>" method="POST" class="form-horizontal">
                                    <div class="form-group">                                                                                                                                                                                        
                                        <label for="familia_id_busqueda" class="col-md-1 control-label">Familias:</label>
                                            <div class="col-md-3">
                                            <select name="familia_id_busqueda" id="familia_id_busqueda" class="form-control">                                                  
                                            <?php foreach ($familias as $familia):?>  
                                            <?php if($familia->id==1):?>
                                            <option value="" selected>
                                                Todas las familias
                                            </option>
                                            <?php endif;?>
                                            <?php if($familia->id==$id_familia):?>
                                            <option value="<?php echo $familia->id?>" selected>
                                            <?php echo $familia->Nombre;?>
                                            </option>
                                            <?php else:?>
                                            <option value="<?php echo $familia->id?>">
                                            <?php echo $familia->Nombre;?>
                                            </option>
                                            <?php endif;?>
                                            <?php endforeach;?>
                                            </select>                                                                                
                                        </div>  

                                        <label for="" class="col-md-2 control-label">Opciones:</label>
                                        <div class="col-md-6">                                        
                                            <input type="submit" name="buscar" value="Buscar" class="btn btn-primary">                                            
                                            <button type='button' class="btn btn-primary btn-flag" data-toggle="modal" data-target="#agregarProducto"><span class="fa fa-plus"></span> Agregar Producto</button>
                                        </div>
                                                                                
                                    </div>
                                </form>       
                            </div>
                         </div>
                                                  
                         <div class="row">
                            <div class="col-md-12">
                            <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_datos">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Clave</th>
                                    <th>Nombre</th>
                                    <th>Familia</th>
                                    <th>Fórmula</th>                                                                     
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($productos)):?>
                                <?php foreach ($productos as $producto):?>
                                   
                                   <?php if($producto->Estado==1): ?>
                                        <tr>
                                    <?php else:?>
                                        <tr bgcolor="ff785b">
                                    <?php endif;?>
                                  

                                    <td><?=$producto->id;?></td>
                                    <td><?=$producto->Clave;?></td>
                                    <td><?=$producto->Nombre;?></td>
                                    <td><?=$producto->Familia;?></td>                                   
                                    
                                    <td>                                        
                                        <button type="button" class="btn btn-info" onclick="consultarFormula(<?php echo $producto->id;?>)" data-toggle="modal" data-target="#modal-default" value="">
                                            <span class="fa fa-plus"></span>
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
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->


    <!--modal -->
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Fórmula del Producto</h4>
                <button  class="btn btn-primary btn-flag" data-toggle="modal" data-target="#agregarFormula"><span class="fa fa-plus"></span>
                    Agregar Formula
                </button>
            </div>
            <div class="modal-body">                    
            <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" >
                                    <thead>
                                        <tr>                                    
                                            <th>Nombre</th> 
                                            <th>Insumo</th>                                                                                                                                                 
                                            <th>Cantidad</th>                                                                                                                                                                                                                                                                      
                                            <th>Unidad</th>  
                                            <th>Editar</th> 
                                            <th>Eliminar</th>   
                                            
                                        </tr>
                                    </thead>
                                    <tbody id="tbl_modal_formula">

                                                                    
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

    <!--modal -->
        <div class="modal fade" id="agregarProducto">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Nuevo Producto</h4>
                    </div>            
                    <div class="modal-body">
                    <form class="form-horizontal" method="post" id="guardarNuevoProducto" name="guardarNuevoProducto">
                    <div class="form-group" required>
                        <label for="nombre" class="col-sm-3 control-label">Nombre: </label>
                        <div class="col-sm-8">     
                            <input type="text" class="form-control"step="0.001" id="nombre" placeholder="" name="nombre" value="" required>                                                                          
                        </div>				
                    </div>

                    <div class="form-group" required>
                        <label for="clave" class="col-sm-3 control-label">Clave: </label>
                        <div class="col-sm-8">     
                            <input type="text" class="form-control"step="0.001" id="clave" placeholder="" name="clave" value="" required>                                                                          
                        </div>				
                    </div>

                    <div class="form-group">
                        <label for="familia_id" class="col-sm-3 control-label">Familia:</label>
                        <div class="col-sm-8">	
                            <select name="familia_id" id="familia_id" class="form-control" required>
                                <option value="">Seleccionar Familia</option>
                                    <?php foreach ($familias as $familia):?>                                            
                                        <option value="<?php echo $familia->id?>">
                                            <?php echo $familia->Nombre;?>
                                        </option>
                                    <?php endforeach;?>
                            </select>
                        </div>
                    </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" id="guardar_captura_producto">Guardar datos</button>
                    </div>
                    </form>
                
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    <!-- /.modal -->

    <!--modal -->
    <div class="modal fade" id="agregarFormula">
        <div class="modal-dialog  ">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Nueva Fórmula</h4>
                </div>            
                <div class="modal-body">
                <form class="form-horizontal" method="post" id="guardarFormula" name="guardarFormula">
                <input type="hidden" value="" name="producto_id_nueva_formula" id="producto_id_nueva_formula">
                        <div class="form-group">                           
                            <div class="col-md-6">
                                <label for="producto_formula">Producto:</label>                                
                                        <input type="text" class="form-control"step="0.001" id="producto_formula" placeholder="" name="producto_formula" value="" required readonly>                                                                                                         
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

    <!--modal -->
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
                
                <input type="hidden" value="" name="id_modificar" id="id_modificar">
                <input type="hidden" value="" name="insumo_id_modificar" id="insumo_id_modificar">
                <input type="hidden" value="" name="producto_id_modificar" id="producto_id_modificar">

                <div class="form-group" required>
                    <label for="producto_modificar" class="col-sm-3 control-label">Producto: </label>
                    <div class="col-sm-8">     
                        <input type="text" class="form-control"step="0.001" id="producto_modificar" placeholder="" name="producto_modificar" value="" required readonly>                                                                          
                    </div>				
                </div>

                <div class="form-group" required>
                    <label for="insumo_modificar" class="col-sm-3 control-label">Insumo: </label>
                    <div class="col-sm-8">     
                        <input type="text" class="form-control"step="0.001" id="insumo_modificar" placeholder="" name="insumo_modificar" value="" required readonly>                                                                          
                    </div>				
                </div>


                <div class="form-group" required>
                    <label for="cantidadFormula_modificar" class="col-sm-3 control-label">Cantidad: </label>
                    <div class="col-sm-8">     
                        <input type="number" class="form-control" min="0" step="0.001" lang="en"  id="cantidadFormula_modificar" placeholder="" name="cantidadFormula_modificar" value="" required >                                                                          
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

    //MANTENER SCROLL CON MULTIPLES MODALS
        $('.modal').on('hidden.bs.modal', function (e) {
            $('body').addClass('modal-open');
        });
    //MANTENER SCROLL CON MULTIPLES MODALS

    //#region GUARDADO DE LAS FÓRMULAS POR AJAX NUEVO
        $( "#guardarFormula" ).submit(function( event ) {                        
                var parametros = $(this).serialize();    
                //alert(parametros);           
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

                        if(correcto==0){

                            swal({
                            position: 'top-end',
                            type: 'error',
                            title: 'Ha ocurrido un error, Fórmula no registrada!!',
                            showConfirmButton: false,
                            timer: 1500
                            });                        
                        }  
                        else if(correcto==1){                        
                                swal({
                                position: 'top-end',
                                type: 'success',
                                title: 'Fórmula  registrada correctamente!!',
                                showConfirmButton: false,
                                timer: 1000
                                });
                        }
                        else if(correcto==2){                        
                                swal({
                                position: 'top-end',
                                type: 'info',
                                title: 'Inusmo duplicado. No se pudo agregar!!',
                                showConfirmButton: false,
                                timer: 1000
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

    //#region AGREGAR PRODUCTOS
        $( "#guardarNuevoProducto" ).submit(function( event ) {                        
                var parametros = $(this).serialize();             
                    $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>Productos/save",
                    data: parametros,                
                    success: function(response){                    
                        if(response==1){
                            swal({
                                position: 'top-end',
                                type: 'success',
                                title: 'Producto registrado correctamente!!',
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
                                title: 'Producto NO registrado,error al registrar!!',
                                showConfirmButton: false,
                                timer: 1500
                                });

                                
                        }
                        else if(response==2){                                      
                            swal({
                                position: 'top-end',
                                type: 'error',
                                title: 'Producto NO registrado, verifique que el nombre y clave no se encuentren previamente registrados!!',
                                showConfirmButton: false,
                                timer: 1500
                                });
                        }                                 
                    },
                    error: function() { 
                        swal({
                                position: 'top-end',
                                type: 'error',
                                title: 'Error FEED al registrar el producto!!',
                                showConfirmButton: false,
                                timer: 1500
                                });                    
                    }
                });
                event.preventDefault();
            });
    //#endregion

    //#region ACTUALIZACIÓN DE FORMULAS
        $( "#guardarCapturaFormula" ).submit(function( event ) {                       
            var parametros = $(this).serialize();
                
                $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>Formulas/actualizarFormula",
                data: parametros,      
                dataType:"JSON",          
                success: function(response){ 

                    var len = response.length;
                    for(var i=0; i<len; i++){
                            var formula  = response[i].formula;
                            var correcto = response[i].correcto;            
                    }      


                    if(correcto==1){
                        swal({
                        position: 'top-end',
                        type: 'success',
                        title: 'Fórmula  actualizada correctamente!!',
                        showConfirmButton: false,
                        timer: 1000
                        });
                    }  
                    else if(correcto==0){
                        swal({
                        position: 'top-end',
                        type: 'error',
                        title: 'Ha ocurrido un error, Fórmula NO actualizada!!',
                        showConfirmButton: false,
                        timer: 1500
                        });
                    }
                    else{
                        swal({
                        position: 'top-end',
                        type: 'error',
                        title: 'Ha ocurrido un error FEED, Fórmula no actualizada!!',
                        showConfirmButton: false,
                        timer: 1500
                        });
                    }                                                                        
                    $('#editarCantidadFormula').modal('hide');             
                    $('#tbl_modal_formula').html(formula);                                         
                },
                error: function() { 
                    alert("Error posting feed.");
                }
            });
            event.preventDefault();
        });
    //#endregion 

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

    function consultarFormula(producto_id){        

        var e = document.getElementById("insumo_id_formulas");
        var insumo_id = e.options[e.selectedIndex].value;
        var parametros = {
                "producto_id" : producto_id,
                "insumo_id":insumo_id                           
                };
                                                                
            $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>Formulas/consultarFormulaModal",
            data: parametros,
            dataType: "JSON",                                               
            success: function(response){ 
                var len = response.length;
                for(var i=0; i<len; i++){
                        var formula  = response[i].formula;
                        var nombre = response[i].nombre; 
                        var unidad = response[i].unidad; 

                }                  
                $('#tbl_modal_formula').html(formula);
                $('#producto_formula').val(nombre);
                $('#producto_id_nueva_formula').val(producto_id);    
                $('#unidad_id_formulas').html(unidad);                        
            },
            error: function() { 
                alert("Error posting feed.");
            }
        });    
    }

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

    function asignarValoresModalFormula(id,producto_id,insumo_id,producto,insumo,cantidad){
        $('#id_modificar').val(id);
        $('#insumo_id_modificar').val(insumo_id);          
        $('#producto_id_modificar').val(producto_id);  
        $('#producto_modificar').val(producto);  
        $('#insumo_modificar').val(insumo);          
        $('#cantidadFormula_modificar').val(cantidad);  
    }

</script>





