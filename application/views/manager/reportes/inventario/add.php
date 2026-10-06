<?php if($bandera==1):?>
<!-- =============================================== -->
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                Inventario Físico
                <small>Inventario Físico</small>
                </h1>
                <a href="<?php echo base_url(); ?>Inventario" class="small-box-footer">Volver al Panel de Inventario <i class="fa fa-arrow-circle-right"></i></a>
               
            </section>
            <!-- Main content -->
            <section class="content">
                <!-- Default box -->
                <div class="box box-solid">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                    <?php if($numero==0):?>  
                                    <button type='button' class="btn btn-success btn-flag" onclick="liberarInventario(<?php echo $this->session->userdata('plaza')?>)"><span class="glyphicon glyphicon-ok" ></span> Liberar Inventario</button>                                                                              
                                    <?php endif;?>                                                                                                                                                                                                                                                                                                              
                                <h3>Productos Restantes: <span id="restantes"><?php echo $numero ?></span></h3>                                                                           
                                <?php if($numero==0):?>  
                                        <h3>Notas</h3>
                                        <textarea rows="8" cols="170" id="notas"><?php echo $notas;?></textarea>                                  
                                <?php endif;?>                                   
  
                            </div>
                         </div>                         
                         <div class="row">
                            <div class="col-md-12">
                            <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_gastos">
                            <thead>
                                <tr>                                                                                                    
                                    <th>Nombre</th> 
                                    <th>Bodega</th>
                                    <th>Piso</th>
                                    <th>Total</th> 
                                    <th>Unidad</th> 
                                    <th>Editar</th>                                                                                                                                                
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($capturas)):?>
                                <?php foreach ($capturas as $captura):?>
                                
                                <?php if($captura->Bandera==1):?>
                                <tr bgcolor="#99ddff">  
                                <?php else:?>
                                <tr>  
                                <?php endif;?> 
                                                                                                          
                                    <td><h4><?=$captura->Insumo;?></h4></td>       
                                    <td><h4><?=$captura->Bodega;?></h4></td>  
                                    <td><h4><?=$captura->Piso;?></h4></td> 
                                    <?php if($captura->Bandera==1):?>
                                    <td bgcolor="#ffb380"><h4><?=$captura->Total;?></h4></td> 
                                    <?php else:?>
                                    <td><h4><?=$captura->Total;?></h4></td> 
                                    <?php endif;?>                                     
                                    <td><h4><?=$captura->UnidadT;?></h4></td>                                                                       
                                    <td>
                                    <a href="#"  onclick="asignarValoresModal(<?php echo $captura->id;?>,<?php echo $captura->insumo_id;?>,<?php echo $captura->Bodega;?>,<?php echo $captura->Piso;?>,<?php echo $captura->Total;?>,'<?php echo $captura->UnidadB;?>','<?php echo $captura->UnidadP;?>','<?php echo $captura->UnidadT;?>','<?php echo $captura->Insumo;?>')" data-toggle="modal" data-target="#editarInventario" class="btn btn-warning">
                                    <span class="fa fa-pencil">
                                            </span></a>
                                    </td>  
                                </tr>   
                                <?php endforeach;?>                                                              
                                <?php endif;?>                                
                            </tbody>                            
                            </table>

                            <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_inventario_fisico_2">
                            <thead>
                                <tr>                                    
                                                                                                           
                                    <th>Nombre</th> 
                                    <th>Bodega</th>
                                    <th>Piso</th>
                                    <th>Total</th> 
                                    <th>Unidad</th>
                                    <th>Editar</th>                                                                                                                                                
                                </tr>
                            </thead>
                            <tbody id="pruebaAjax">
                                                            
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


    <div class="modal fade" id="editarInventario">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Mi Inventario</h4>
            </div>            
            <div class="modal-body">
            <form class="form-horizontal" method="post" id="guardarCapturaInventario" name="guardarCapturaInventario">
            <input type="hidden" value="" name="id" id="id">
            <input type="hidden" value="<?php echo $this->session->userdata("plaza")?>" name="plaza_id"> 
            <input type="hidden" value="" name="insumo_id" id="insumo_id">
               

              <div class="form-group" required>
				<label for="nombre" class="col-sm-3 control-label">Nombre: </label>
                <div class="col-sm-8">     
                    <input type="text" class="form-control"step="0.001" id="nombre" placeholder="" name="nombre" value="Mezcla Espresso" required readonly>                                                                          
                </div>				
              </div>


              <div class="form-group" required>
				<label for="bodega" class="col-sm-3 control-label">Bodega: </label>
                <div class="col-sm-8">     
                    <input type="number" class="form-control"step="0.001" lang="en"  id="bodega" placeholder="" name="bodega" value="" required>                                                                          
                </div>				
              </div>

               <div class="form-group" required>
				<label for="unidadBodega" class="col-sm-3 control-label">Unidad Bodega: </label>
                <div class="col-sm-8">     
                    <select name="unidadBodega" id="unidadBodega" class="form-control" readonly>                    
                        </select>
                                              
                </div>				
              </div>


              <div class="form-group" required>
				<label for="piso" class="col-sm-3 control-label">Piso: </label>
                <div class="col-sm-8">     
                    <input type="number" class="form-control"step="0.001" id="piso" lang="en" placeholder="" name="piso" value="" required>                                                                          
                </div>				
              </div>


               <div class="form-group" required>
				<label for="unidadPiso" class="col-sm-3 control-label">Unidad Piso: </label>
                <div class="col-sm-8">     
                    <select name="unidadPiso" id="unidadPiso" class="form-control" readonly>                       
                        </select>                                              
                </div>				
              </div>

                   
            </div>
            <div class="modal-footer">
			    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			    <button type="submit" class="btn btn-primary" id="guardar_captura_inventario">Guardar datos</button>
		    </div>
            </form>
        
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<?php else:?>
<!-- =============================================== -->
<?php if($envio==1):?>

<?php if($inventario==0):?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                Inventario Físico
                <small>Inventario Físico</small>
                </h1>
                <a href="<?php echo base_url(); ?>Inventario" class="small-box-footer">Volver al Panel de Inventario <i class="fa fa-arrow-circle-right"></i></a>
            </section>
            <!-- Main content -->
            <section class="content">
                <!-- Default box -->
                <div class="box box-solid">
                    <div class="box-body">                     
                         <div class="row">
                            <div class="col-md-12">                          
                                 <h1>Inventario en Proceso de Revisión</h1> 
                                 <h3>Notas</h3>
                                <textarea rows="8" cols="170" id="notas" readonly><?php echo $notas;?></textarea> 

                                <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_gastos">
                            <thead>
                                <tr>                                                
                                    <th>Nombre</th> 
                                    <th>Bodega</th>
                                    <th>Piso</th>
                                    <th>Total</th> 
                                    <th>Unidad</th>                                                                                                                                                                           
                                </tr>
                            </thead>
                            <tbody>
                            <?php if(!empty($capturas)):?>
                                <?php foreach ($capturas as $captura):?>
                                   <tr>                                    
                                    <td><?=$captura->Insumo;?></td>
                                    <td><?=$captura->Bodega;?></td>       
                                    <td><?=$captura->Piso;?></td>
                                    <td><?=$captura->Total;?></td>                                                                                                                                                                         
                                    <td><?=$captura->UnidadT;?></td>                                                                                                                                                                         
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
<?php else:?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                Inventario Físico
                <small>Inventario Físico</small>
                </h1>
                <a href="<?php echo base_url(); ?>Inventario" class="small-box-footer">Volver al Panel de Inventario <i class="fa fa-arrow-circle-right"></i></a>
            </section>
            <!-- Main content -->
            <section class="content">
                <!-- Default box -->
                <div class="box box-solid">
                    <div class="box-body">                     
                         <div class="row">
                            <div class="col-md-12">                          
                                <h1>Inventario Físico Completado</h1>   
                                <h3>Notas</h3>
                                <textarea rows="8" cols="170" id="notas" readonly><?php echo $notas;?></textarea>                                  
                                <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_gastos">
                            <thead>
                                <tr>            
                                    <th>Fecha</th>                                                                                                                              
                                    <th>Nombre</th> 
                                    <th>Bodega</th>
                                    <th>Piso</th>
                                    <th>Total</th> 
                                    <th>Unidad</th>                                                                                                                                                                           
                                </tr>
                            </thead>
                            <tbody>
                            <?php if(!empty($miCaptura)):?>
                                <?php foreach ($miCaptura as $captura):?>
                                   <tr>
                                    <td><?=$captura->Fecha;?></td>
                                    <td><?=$captura->Insumo;?></td>
                                    <td><?=$captura->Bodega;?></td>       
                                    <td><?=$captura->Piso;?></td>
                                    <td><?=$captura->Total;?></td>                                                                                                                                                                         
                                    <td><?=$captura->UnidadT;?></td>                                                                                                                                                                         
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
<?php endif;?>    
<?php else:?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                Inventario Físico
                <small>Inventario Físico</small>
                </h1>
                <a href="<?php echo base_url(); ?>Inventario" class="small-box-footer">Volver al Panel de Inventario <i class="fa fa-arrow-circle-right"></i></a>
            </section>
            <!-- Main content -->
            <section class="content">
                <!-- Default box -->
                <div class="box box-solid">
                    <div class="box-body">                     
                         <div class="row">
                            <div class="col-md-12">                          
                                <h1>El Inventario Físico solo puede ser revisado los días Domingo y Lunes</h1>                            
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
<?php endif;?>  
<?php endif;?>    


<script type="text/javascript">  
    //#region CAPTURA DE INVENTARIO FÍSICO
    $( "#guardarCapturaInventario" ).submit(function( event ) {                    
        var parametros = $(this).serialize();
        $('#restantes').html("");           
            $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>Inventario/captura",
            data: parametros,
            dataType: 'JSON',
            beforeSend: function(objeto){                 				                        
            },            
            success: function(response){ 
                var len = response.length;                
                for(var i=0; i<len; i++){
                    var numero = response[i].numero;
                    var corte = response[i].corte;            
                    }
                    if(numero==0){
                        window.location= "<?php echo base_url();?>Inventario/add";                       
                    }
                                                        
                $('#tbl_gastos').remove();
                $('#tbl_inventario_fisico_2').show();                
                $('#pruebaAjax').html(corte);
                $('#restantes').html(numero); 
                $('#editarInventario').modal('hide');
               
                $(this).next(".btn btn-warning btnCI").focus();
                                                                                        
            },
            error: function() { 
                alert("Error posting feed.");
            }
        });
        event.preventDefault();
    });
//#endregion   

function asignarValoresModal(id,insumo_id,bodega,piso,total,unidadB,unidadP,unidadT,insumo){            
        $("#unidadBodega").empty();
        $("#unidadPiso").empty();            
        $('#id').val(id);
        $('#nombre').val(insumo);  
        $('#insumo_id').val(insumo_id);  
        $('#bodega').val(bodega);  
        $('#piso').val(piso);  
        var option = new Option(unidadB, unidadB); 
        $('#unidadBodega').append($(option));
        var option = new Option(unidadP, unidadP); 
        $('#unidadPiso').append($(option));         
    }


     //AJAX REQUEST
     function liberarInventario(plaza_id){             
        
        var notas = $('#notas').val();               
        var parametros = {
                "plaza_id" : plaza_id,
                "notas":notas
        };

        

            swal({
                title: '¿Estás seguro?',
                text: "Una vez liberado el inventario no puede ser modificado!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Enviar ahora!',
                cancelButtonText: 'No, aún no',
                }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url();?>Inventario/liberarInventarioFisico",
                        data: parametros,
                        beforeSend: function(objeto){   
                            swal({                                
                        title: 'Espere por favor !!!',
                        width: 600,
                        padding: '2em',
                        background: '#fff url(<?php echo base_url();?>assets/images/trees.png)',
                        backdrop: `
                            rgba(0,0,123,0.4)
                            url("<?php echo base_url();?>assets/images/loading.gif")
                            center left
                            no-repeat
                        `,
                        allowOutsideClick: false,
                        showCancelButton: false,
                        showConfirmButton: false
                            });                                                    
                        },
                        success: function(datos){
                            if(datos==0){
                                alert("Ha ocurrido un error al tratar de liberar el inventario");                                                            
                            }          
                            else if(datos==1){                                
                                swal(
                                    'Correcto!',
                                    'Datos guardados correctamente.',
                                    'success'
                                ).then(function() {                                                        
                                    window.location= "<?php echo base_url();?>Inventario/add";                       
                                });
                            }
                            else if(datos==2){
                                alert("El inventario físico ya fue liberado");
                            }                         


                    },error: function() { alert("Error posting feed."); }
                });                    
                }
                else{
                   
                }

                });                 
    }





</script>
        