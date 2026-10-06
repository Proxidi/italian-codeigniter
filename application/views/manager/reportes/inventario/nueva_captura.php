<?php if($puedeCapturar==true):?>
         <!--$puedeCapturar=true y $yaFueEnviado=false $yaFueLiberado=false--> 
        <!--============================================================================================-->
        <!--INVENTARIO FISICO MÓDULO PARA REALIZAR LA CAPTURA TABLA REAL Y TABLA AJAX-->
        <!--============================================================================================-->
            <div class="content-wrapper">            
                <section class="content-header">
                    <h1>Inventario Físico<small>Inventario Físico</small></h1>
                    <a href="<?php echo base_url(); ?>Inventario" class="small-box-footer">Volver al Panel de Inventario <i class="fa fa-arrow-circle-right"></i></a>               
                </section>
                            
                <section class="content">                
                    <div class="box box-solid">
                        <div class="box-body">                            
                            <!--============================================================================================-->
                            <!--TABLA REAL-->
                            <!--============================================================================================-->
                                <div class="row">
                                    <div class="col-md-12">
                                        <?php if($numeroInsumosRestantes==0):?>  
                                            <button id="btnLiberarInventario" type='button' class="btn btn-success btn-flag" onclick="liberarInventario(<?php echo $this->session->userdata('plaza')?>)"><span class="glyphicon glyphicon-ok" ></span> Liberar Inventario</button>                                                                              
                                        <?php endif;?>                                                                                                                                                                                                                                                                                                              
                                        <h3>Productos Restantes: <span id="restantes"><?php echo $numeroInsumosRestantes ?></span></h3>      
                                        <input type="hidden" name="" id="elementosRestantesHidden">                                                                     
                                        <?php if($numeroInsumosRestantes==0):?>  
                                            <h3>Notas</h3>
                                            <textarea rows="8" cols="170" id="notas"><?php echo $notas;?></textarea>                                  
                                        <?php endif;?>                                   
                                    </div>
                                </div>   
                                                        
                                <div class="row">
                                    <div class="col-md-12">                            
                                        <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_captura">
                                            <thead>
                                                <tr>
																										<th>#</th>                                                                                                    
                                                    <th>Nombre</th> 
                                                    <th>Bodega</th>
                                                    <th>Piso</th>
                                                    <th>Total</th> 
                                                    <th>Unidad</th> 
                                                    <th>Editar</th>                                                                                                                                                
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if(!empty($capturaActualInventario)):?>																									
																									<?php $contador = 1; ?>
                                                    <?php foreach ($capturaActualInventario as $capturaActual):?>                                                                    
                                                        <?php if($capturaActual->Bandera==1):?>
                                                            <tr bgcolor="#99ddff">  
                                                        <?php else:?>
                                                            <tr>  
                                                        <?php endif;?>                                                                                                           
																														<td><h4><?=$contador;?></h4></td>
                                                            <td><h4><?=$capturaActual->Insumo;?></h4></td>
                                                            <td><h4><?=$capturaActual->Bodega;?></h4></td>  
                                                            <td><h4><?=$capturaActual->Piso;?></h4></td> 
                                                            <?php if($capturaActual->Bandera==1):?>
                                                            <td bgcolor="#ffb380"><h4><?=$capturaActual->Total;?></h4></td> 
                                                            <?php else:?>
                                                            <td><h4><?=$capturaActual->Total;?></h4></td> 
                                                            <?php endif;?>                                     
                                                            <td><h4><?=$capturaActual->UnidadT;?></h4></td>                                                                       
                                                            <td>
                                                                <a href="#"  onclick="asignarValoresModal(<?php echo $capturaActual->id;?>,<?php echo $capturaActual->insumo_id;?>,<?php echo $capturaActual->Bodega;?>,<?php echo $capturaActual->Piso;?>,<?php echo $capturaActual->Total;?>,'<?php echo $capturaActual->UnidadB;?>','<?php echo $capturaActual->UnidadP;?>','<?php echo $capturaActual->UnidadT;?>','<?php echo $capturaActual->Insumo;?>','<?php echo $capturaActual->Bandera;?>',<?php echo $capturaActual->OrdenCapturaInventario;?>)" data-toggle="modal" data-target="#modalNuevaCapturaDatos" class="btn btn-warning">
                                                                <span class="fa fa-pencil"></span></a>
                                                            </td>  
                                                        </tr>   																												
																												<?php $contador++; ?>
                                                    <?php endforeach;?>                                                              																										
                                                <?php endif;?>                                
                                            </tbody>                            
                                        </table>
                            <!--============================================================================================-->
                            <!--TABLA REAL-->
                            <!--============================================================================================-->
                            <!--============================================================================================-->
                            <!--TABLA AJAX-->
                            <!--============================================================================================-->                                                
                                        <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_captura_ajax">
                                            <thead>
                                                <tr>
																										<th>#</th>                                                                                                                                               
                                                    <th>Nombre</th> 
                                                    <th>Bodega</th>
                                                    <th>Piso</th>
                                                    <th>Total</th> 
                                                    <th>Unidad</th>
                                                    <th>Editar</th>                                                                                                                                                
                                                </tr>
                                            </thead>

                                            <tbody id="bodyCapturaAjax">                                                            
                                            </tbody>                            
                                        </table>                            
                                    </div>
                                </div>
                            <!--============================================================================================-->
                            <!--TABLA AJAX-->
                            <!--============================================================================================-->                                            
                        </div>                                        
                    </div>                
                </section>            
            </div>        
        <!--============================================================================================-->
        <!--INVENTARIO FISICO MÓDULO PARA REALIZAR LA CAPTURA TABLA REAL Y TABLA AJAX-->
        <!--============================================================================================-->
<?php else:?>    
    <?php if($yaFueEnviado==true):?>
        <?php if($yaFueLiberado==true):?>
            <!--$puedeCapturar=false y $yaFueEnviado=true $yaFueLiberado=true-->           
            <!--============================================================================================-->
            <!--INVENTARIO FISICO APROBADO Y LIBERADO POR EL ADMINISTRADOR-->
            <!--============================================================================================-->
                <div class="content-wrapper">                                        
                    <section class="content-header">
                        <h1>Inventario Físico<small>Inventario Físico</small></h1>
                        <a href="<?php echo base_url(); ?>Inventario" class="small-box-footer">Volver al Panel de Inventario <i class="fa fa-arrow-circle-right"></i></a>
                    </section>                    
                    
                    <section class="content">            
                        <div class="box box-solid">
                            <div class="box-body">                     
                                <div class="row">
                                    <div class="col-md-12">                          
                                        <h1>Inventario Físico Completado</h1>   
                                        <h3>Notas</h3>
                                        <textarea rows="8" cols="170" id="notas" readonly><?php echo $notas;?></textarea>                                                                          
                                        <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_captura">
                                            <thead>
                                                <tr>            
																										<th>#</th>
                                                    <th>Fecha</th>                                                                                                                              
                                                    <th>Nombre</th> 
                                                    <th>Bodega</th>
                                                    <th>Piso</th>
                                                    <th>Total</th> 
                                                    <th>Unidad</th>                                                                                                                                                                           
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if(!empty($capturaLiberadaInventario)):?>
																									<?php $contador = 1; ?>
                                                    <?php foreach ($capturaLiberadaInventario as $capturaLiberada):?>
                                                        <tr>
																														<td><?=$contador;?></td>
                                                            <td><?=$capturaLiberada->Fecha;?></td>
                                                            <td><?=$capturaLiberada->Insumo;?></td>
                                                            <td><?=$capturaLiberada->Bodega;?></td>       
                                                            <td><?=$capturaLiberada->Piso;?></td>
                                                            <td><?=$capturaLiberada->Total;?></td>                                                                                                                                                                         
                                                            <td><?=$capturaLiberada->UnidadT;?></td>                                                                                                                                                                         
                                                        </tr>   
																												<?php $contador++; ?>
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
            <!--============================================================================================-->
            <!--INVENTARIO FISICO APROBADO Y LIBERADO POR EL ADMINISTRADOR-->
            <!--============================================================================================-->                        
        <?php else:?> 
            <!--$puedeCapturar=false y $yaFueEnviado=true $yaFueLiberado=false-->   
            <!--============================================================================================-->
            <!--INVENTARIO FISICO EN PROCESO DE REVISIÓN-->
            <!--============================================================================================-->
                <div class="content-wrapper">                
                    <section class="content-header">
                        <h1>Inventario Físico<small>Inventario Físico</small></h1>
                        <a href="<?php echo base_url(); ?>Inventario" class="small-box-footer">Volver al Panel de Inventario <i class="fa fa-arrow-circle-right"></i></a>
                    </section>            
                    <section class="content">                    
                        <div class="box box-solid">
                            <div class="box-body">                     
                                <div class="row">
                                    <div class="col-md-12">                          
                                        <h1>Inventario en Proceso de Revisión</h1> 
                                        <h3>Notas</h3>
                                        <textarea rows="8" cols="170" id="notas" readonly><?php echo $notas;?></textarea> 
                                        <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_captura">
                                            <thead>
                                                <tr>          
																										<th>#</th>                                      
                                                    <th>Nombre</th> 
                                                    <th>Bodega</th>
                                                    <th>Piso</th>
                                                    <th>Total</th> 
                                                    <th>Unidad</th>                                                                                                                                                                           
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if(!empty($capturaActualInventario)):?>
																									<?php $contador = 1; ?>
                                                    <?php foreach ($capturaActualInventario as $capturaActual):?>
                                                        <tr>          
																													  <td><?=$contador;?></td>
                                                            <td><?=$capturaActual->Insumo;?></td>
                                                            <td><?=$capturaActual->Bodega;?></td>       
                                                            <td><?=$capturaActual->Piso;?></td>
                                                            <td><?=$capturaActual->Total;?></td>                                                                                                                                                                         
                                                            <td><?=$capturaActual->UnidadT;?></td>                                                                                                                                                                         
                                                        </tr>   
																												<?php $contador++; ?>
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
            <!--============================================================================================-->
            <!--INVENTARIO FISICO EN PROCESO DE REVISIÓN-->
            <!--============================================================================================-->
        <?php endif;?>    
    <?php else:?>        
        <!--$puedeCapturar=false y $yaFueEnviado=false $yaFueLiberado=false-->
        <!--============================================================================================-->
        <!--EL INVENTARIO FISICO SOLO PUEDE SER LIBERADO LOS DÍAS DOMINGO Y LUNES-->
        <!--============================================================================================-->
            <div class="content-wrapper">                                
                <section class="content-header">
                    <h1>Inventario Físico<small>Inventario Físico</small></h1>
                    <a href="<?php echo base_url(); ?>Inventario" class="small-box-footer">Volver al Panel de Inventario <i class="fa fa-arrow-circle-right"></i></a>
                </section>           
                    
                <section class="content">                    
                    <div class="box box-solid">
                        <div class="box-body">                     
                            <div class="row">
                                <div class="col-md-12">                          
                                    <h1>El Inventario Físico solo puede ser revisado los días Domingo y Lunes</h1>                            
                                </div>
                            </div>                
                        </div>                                            
                    </div>                    
                </section>                
            </div>            
        <!--============================================================================================-->
        <!--EL INVENTARIO FISICO SOLO PUEDE SER LIBERADO LOS DÍAS DOMINGO Y LUNES-->
        <!--============================================================================================-->        
    <?php endif;?>  
<?php endif;?>   


<!--==========================MODALES=============================================-->
<!--=====================================================================================================================-->
<!--MODAL PARA VER LA CAPTURA TEMPORAL DEL INVENTARIO FISICO DESDE EL MODAL-->
    <div class="modal fade" id="modalNuevaCapturaResumen" >
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Captura de Inventario al momento</h4>
                </div>
                <div class="modal-body">
                    <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_CIF">
                        <thead>
                            <tr>
                                <th>Estado</th>
                                <th>Nombre</th> 
                                <th>Bodega</th>
                                <th>Piso</th>
                                <th>Total</th> 
                                <th>Unidad</th>                                                                                                                                         
                            </tr>
                        </thead>                
                        <tbody> 
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
<!--MODAL PARA VER LA CAPTURA TEMPORAL DEL INVENTARIO FISICO DESDE EL MODAL-->
<!--=====================================================================================================================-->

<!--==========================================================================================================================-->
<!--NUEVA MANERA DE REALIZAR LA CAPTURA DEL INVENTARIO-->
    <div class="modal fade" id="modalNuevaCapturaDatos" >
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Captura de Inventario Fisico</h4>
                </div>                        
                <div class="modal-body">
                    <form class="form-horizontal" method="post" id="guardarCapturaInventario" name="guardarCapturaInventario">
                        <input type="hidden" value="" name="id" id="id">
                        <input type="hidden" value="<?php echo $this->session->userdata("plaza")?>" name="plaza_id"> 
                        <input type="hidden" value="" name="insumo_id" id="insumo_id">

                        <div class="form-group">				
                            <div class="col-md-9">                         
                            <h5><b>Insumos Restantes: <span id="insumosRestantesModal"></b></span></h5>                
                            </div>				
                            <div class="col-md-3">
                                <button type="button" onClick="verCaptura()"  class="btn btn-primary"><i class="fa fa-search"></i> Ver Captura</button>
                            </div>
                        </div>
                        
                        <div class="form-group" required>
                            <label for="nombre" class="col-sm-3 control-label">Nombre: </label>
                            <div class="col-sm-8">                                                                             
                                <b><input type="text" style="text-align:center;" class="form-control"step="0.001" id="nombre" placeholder="" name="nombre" value="Mezcla Espresso" required readonly></b>                                                                          
                            </div>				
                        </div>

                        <div class="form-group" required>
                            <label for="bodega" class="col-sm-3 control-label">Bodega: </label>
                            <div class="col-sm-8">                                         
                                <input type="number" class="form-control"step="any" lang="en"  id="bodega" placeholder="" name="bodega" value="" required>  
                            </div>				
                        </div>

                        <div class="form-group" required>
                            <label for="unidadBodega" class="col-sm-3 control-label">Unidad: </label>
                            <div class="col-sm-8">                                                                             
                                <input tabIndex="-1" type="text" class="form-control" name="unidadBodega" id="unidadBodega" readonly> 
                            </div>				
                        </div>

                        <div class="form-group" required>
                            <label for="piso" class="col-sm-3 control-label">Piso: </label>
                            <div class="col-sm-8">                                         
                                <input type="number" class="form-control"step="any" lang="en"  id="piso" placeholder="" name="piso" value="" required>  
                            </div>				
                        </div>


                        <div class="form-group" required>
                            <label for="unidadPiso" class="col-sm-3 control-label">Unidad: </label>
                            <div class="col-sm-8">                                                                             
                                <input tabIndex="-1" type="text" class="form-control" name="unidadPiso" id="unidadPiso" readonly> 
                            </div>				
                        </div>
                                                                                                        
                </div>
                <div class="modal-footer">			    
                    <button type="button" class="btn btn-warning" onclick="consultandoInsumoAnterior()" id="insumo_anterior">Anterior</button>
                    <button type="submit" class="btn btn-success" id="guardar_captura_inventario">Siguiente</button>
                </div>
                    </form>        
            </div>        
        </div>    
    </div>        
<!--NUEVA MANERA DE REALIZAR LA CAPTURA DEL INVENTARIO-->        
<!--==========================================================================================================================-->
<!--==========================MODALES=============================================-->

<script type="text/javascript">  

    var valorOrdenCaptura=1;   
    var numeroInsumosRestantes= "<?php echo $numeroInsumosRestantes;?>";
    $('#elementosRestantesHidden').val(numeroInsumosRestantes);
    $('#tbl_captura_ajax').hide();  

    //DATATABLES
        var tbl_CIF= $('#tbl_CIF').DataTable({
            ////////////////////////////////////////////////////////////
                "fnRowCallback": function( nRow, aData, iDisplayIndex ) {                
                //PREGUNTAMOS SI LA VARIABLE DEL TEMPORAL ES IGUAL AL VALOR DE LA CELDA   
                if ( aData[0] == "LISTO" ){                       
                    $('td', nRow).eq(0).css('background-color','#99ddff');    
                    $('td', nRow).eq(1).css('background-color','#99ddff');    
                    $('td', nRow).eq(2).css('background-color','#99ddff');    
                    $('td', nRow).eq(3).css('background-color','#99ddff');    
                    $('td', nRow).eq(4).css('background-color','#ffb380');   
                    $('td', nRow).eq(5).css('background-color','#99ddff');     
                    //$('td', nRow).css('background-color', '#99ddff' );                                                                                                                            
                }                                           
            },  
            ////////////////////////////////////////////////////////////
            "aaSorting": [],
            dom: 'Bfrtip',
            "pageLength": 150,
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
    //DATATABLES

    
		//MÉTODO PARA ASIGNAR LOS VALORES AL MODAL
    function asignarValoresModal(id, insumo_id, bodega, piso, total, unidadB, unidadP, unidadT, insumo, bandera, ordenCapturaInventario){
			
			
        //ASIGNANDO LOS DATOS DEL INSUMO AL MODAL
            $('#bodega').focus();            
            $("#unidadBodega").empty();
            $("#unidadPiso").empty();            
            $('#id').val(id);
            $('#nombre').val(insumo);  
            $('#insumo_id').val(insumo_id);  
            $('#bodega').val(bodega);  
            $('#piso').val(piso);  
            $('#unidadBodega').val(unidadB);  
            $('#unidadPiso').val(unidadP);  
            $('#insumosRestantesModal').text($('#restantes').text());         
        //ASIGNANDO LOS DATOS DEL INSUMO AL MODAL               
        
        //DEFINIENDO LOS COLORES QUE SE MOSTRARAN EN EL INSUMO PARA VER SI YA FUE REVISADO O NO
            if(bandera==1){
                $('#nombre').css('background', '#C2FF6F');                
            }else{
                $('#nombre').css('background', '#ff7a7a');
                if(bodega==0){                    
                    $('#bodega').val("");                                         
                }
                if(piso==0){                    
                    $('#piso').val("");  
                }
            }                                
        //DEFINIENDO LOS COLORES QUE SE MOSTRARAN EN EL INSUMO PARA VER SI YA FUE REVISADO O NO                                                        
        
        //ASIGNANDO A LA VARIABLE COMPARTIDA EL NÚMERO DEL INSUMO ACTUAL
        valorOrdenCaptura = ordenCapturaInventario;         
    }
    
    //=====================================================================================
    //=================================MÉTODOS PARA ADELANTE===============================
    
    //#region DANDO CLIC PARA GUARDAR LOS DATOS
        $("#guardarCapturaInventario" ).submit(function( event ) {                    
            var parametros = $(this).serialize();
            $('#restantes').html("");            
            var jsonData="";                        
                $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>Inventario/capturaPrueba",
                data: parametros,
                dataType: 'JSON',                      
                success: function(response){   										
                    var len = response.length;  
                                  
                    for(var i=0; i<len; i++){
                        var numero = response[i].numero;
                        var corte = response[i].corte;            
												var valorMaximoOrdenInventario = response[i].valorMaximoOrdenInventario;
                    }
																				

										// La variable numero y la variable numeros restantes hacen lo mismo
                    
										// numero lleva el contador de forma actualizada cuando sea 0
										// numeros restantes no será 0 por ello recargará la página
										// y sincronizará ambas variables
                        if(numero == 0){                                               
                            if (numeroInsumosRestantes != 0) {
                                window.location = "<?php echo base_url();?>Inventario/nuevaCaptura";                       
                            } else {
                                //alert("Ahora puede proceder con la liberación");
                            }                         
                        }

                    //EN DADO CASO DE QUE EL NUMERO SEA CERO REGARGAMOS LA PÁGINA
										

                    //VERIFICAMOS EL INSUMO EN EL QUE NOS ENCONTRAMOS PARA NO SOBREPASAR EL TOTAL 260                                            
                    if(valorOrdenCaptura <= valorMaximoOrdenInventario){                                                                   
                        var idSiguiente = consultarInsumoSiguienteDB(valorOrdenCaptura);                                                
                        var json = JSON.parse(idSiguiente);   												                 

                        //ACTUALIZANDO LOS ELEMENTOS DE LAS VARIABLES DEL MODAL
                            $('#nombre').val(json["NombreInsumo"]);
                            $('#bodega').val(json["Bodega"]);
                            $('#unidadBodega').val(json["UnidadBodega"]);
                            $('#piso').val(json["Piso"]);
                            $('#unidadPiso').val(json["UnidadPiso"]);
                            $('#insumo_id').val(json["insumo_id"]);
                            $('#id').val(json["id"]);
                            valorOrdenCaptura = json["OrdenCapturaInventario"];
                        //ACTUALIZANDO LOS ELEMENTOS DE LAS VARIABLES DEL MODAL

                        //DEFINIENDO LOS COLORES QUE SE MOSTRARAN EN EL INSUMO PARA VER SI YA FUE REVISADO O NO
                            if(json["Bandera"] == 1) {
                                $('#nombre').css('background', '#C2FF6F');
                            }
														else {                        
                                if(json["Bodega"] == 0) {                                    
                                    $('#bodega').val("");                                           
                                }
                                if(json["Piso"] == 0) {                                    
                                    $('#piso').val("");  
                                }                        
                                $('#nombre').css('background', '#ff7a7a');
                            }   
                        //DEFINIENDO LOS COLORES QUE SE MOSTRARAN EN EL INSUMO PARA VER SI YA FUE REVISADO O NO
                                                                                                        
                        //CREANDO NUEVO DIBUJO DE LA TABLA Y ACTUALIZACIÓN DE ELEMENTOS RESTANTES
                            $('#tbl_captura').remove();
                            $('#tbl_captura_ajax').show();                
                            $('#bodyCapturaAjax').html(corte);
                            $('#restantes').html(numero);                        
                            $('#elementosRestantesHidden').val(numero);                                     
                            $('#insumosRestantesModal').text(numero); 
                            $('#bodega').focus();
                        //CREANDO NUEVO DIBUJO DE LA TABLA Y ACTUALIZACIÓN DE ELEMENTOS RESTANTES                                              
                    }                                                                                                              
                },
                error: function() { 
                    alert("Error posting feed.");
                }
            });
            event.preventDefault();
        });
    //#endregion   
    
    //RETORNA LOS DATOS ASOCIADOS AL INSUMO SIGUIENTE CONSULTANDOLOS EN BD
        function consultarInsumoSiguienteDB(insumo_id){                 
            var valor = "";
            var parametros = {                                
                'insumo_id': insumo_id            
            };          
            $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>Inventario/getInsumoSiguienteIF",
                    data: parametros,        
                    async: false,                          
                    success: function(response){                         
                        valor = response;                                                                                                 
                    },
                    error: function() {                         
                    }
                });

            return valor;
        }
    //RETORNA LOS DATOS ASOCIADOS AL INSUMO SIGUIENTE CONSULTANDOLOS EN BD    
    
    //=====================================================================================
    //=====================================================================================


    //=====================================================================================
    //=================================MÉTODOS PARA ATRÁS===============================
        //MÉTODO LLAMADO DIRECTAMENTE POR EL BOTÓN
        function consultandoInsumoAnterior() {
            var nuevoValor = parseFloat(valorOrdenCaptura) - 1;          
            if (nuevoValor > 0) {   
                dibujarInsumoAnterior(valorOrdenCaptura);
            } 
						else {
                swal({
                    position: 'top-end',
                    type: 'info',
                    title: 'Ha llegado al primer insumo !',
                    text: 'No hay mas insumos,puede volver con el botón siguiente ',
                    showConfirmButton: true                            
                });
            }                
        }
    
        //MÉTODO LLAMADO DENTRO DE LA FUNCIÓN DEL DE ARRIBA
        function dibujarInsumoAnterior(insumo_id) {            
        
            var idSiguiente = consultarInsumoAnterior(insumo_id);
            var json = JSON.parse(idSiguiente);						
            $('#nombre').val(json["NombreInsumo"]);
            $('#bodega').val(json["Bodega"]);
            $('#unidadBodega').val(json["UnidadBodega"]);
            $('#piso').val(json["Piso"]);
            $('#unidadPiso').val(json["UnidadPiso"]);
            $('#insumo_id').val(json["insumo_id"]);
            $('#id').val(json["id"]);
            valorOrdenCaptura = json["OrdenCapturaInventario"];
						
            if (json["Bandera"] == 1) {
            	$('#nombre').css('background', '#C2FF6F');
            } 
						else 
						{            
							if(json["Bodega"]==0){
									$('#bodega').val("");                                          
							}
							if(json["Piso"]==0){
									$('#piso').val("");
							}
							$('#nombre').css('background', '#ff7a7a');
            }   
        }

        //MÉTODO LLAMADO DENTRO DE LA FUNCIÓN DEL DE ARRIBA
        function consultarInsumoAnterior(insumo_id){    
            var valor = "";
            var parametros = {
                'insumo_id': insumo_id
            };            

            $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>Inventario/getInsumoAnteriorIF",
                    data: parametros,        
                    async: false,                          
                    success: function(response){ 
                        valor = response;                                                                                                 
                    },
                    error: function() { 
                        //alert("Error posting feed.");
                    }
                });

            return valor;
        }
    //=====================================================================================
    //=====================================================================================


    //=====================================================================================
    //=================================MÉTODOS ADICIONALES===============================
        function liberarInventario(plaza_id) {                                     
            var insumosRestantes=$("#elementosRestantesHidden").val();
            if (insumosRestantes == 0) {
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
                            url: "<?php echo base_url();?>Inventario/liberarInventarioFisicoPrueba",
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
                                        window.location= "<?php echo base_url();?>Inventario/nuevaCaptura";                       
                                    });
                                }
                                else if(datos == 2){
                                    alert("El inventario físico ya fue liberado");
                                }                         


                        },error: function() { alert("Error posting feed."); }
                    });                    
                    }
                    else{
                        
                    }
                });
            }else{
                //alert("Aun hay elementos pendientes por marcar en la captura");
                swal({
                    position: 'top-end',
                    type: 'warning',
                    title: 'Elementos pendientes por capturar',
                    text: 'Aún hay elementos pendientes por marcar en la captura',
                    showConfirmButton: true                            
                });	
            }                                     
        }

        function verCaptura(){        
            var parametros = {};                            
                    $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>Inventario/consultarIFPrueba",
                    data: parametros,              
                    dataType: "JSON",                                 
                    success: function(response){                                                                             
                        tbl_CIF.clear();                       
                        var len = response.length;                            
                        for(var i=0; i<len; i++){
                            var insumo = response[i].Insumo;
                            var bodega = response[i].Bodega;            
                            var piso=response[i].Piso;  
                            var total=response[i].Total;
                            var unidadT=response[i].UnidadT;    
                            var bandera=response[i].Bandera;    
                            var estado="";
                            if(bandera==1){
                                estado="LISTO";
                            }else{
                                estado="PENDIENTE";
                            }
                            tbl_CIF.row.add([estado,insumo,bodega,piso,total,unidadT]);    
                            $('#modalNuevaCapturaResumen').modal('show');                
                        }                    
                        tbl_CIF.draw();                                                
                    },
                    error: function() { 
                        alert("Error posting feed.");
                    }
                });               
        }
    //=====================================================================================
    //=====================================================================================

</script>

