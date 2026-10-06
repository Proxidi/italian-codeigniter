<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Tabla de Usuarios en Nomina                                       
                <small></small>
                </h1>                
                <a href="<?php echo base_url(); ?>Nominas" class="small-box-footer">Volver al Panel de Nominas <i class="fa fa-arrow-circle-right"></i></a>
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
                                <label for="plaza_id" class="col-md-1 control-label">Plaza:</label>                                        
                                    <div class="col-md-3">
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

                                    <div class="col-md-3">
                                        <input type="submit" name="buscar" value="Buscar" class="btn btn-primary">
                                    </div>                                    
                                </div>
                            </form>                        
                            </div>
                            </div>

                            <div class="row">
                            <div class="col-md-12">  
                            <div class="form-group">
                            <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_usuarios">
                                <thead>
                                    <tr>               
                                        <th>Plaza</th>                         
                                        <th>Nombre</th> 
                                        <th>Ap. Paterno</th>
                                        <th>Ap. Materno</th>
                                        <th>Nombre Rol</th>
                                        <th>F. Nacimiento</th>
                                        <th>F. Ingreso</th>                                                                                                                      
                                        <th>F. Egreso</th>                                                                                
                                        <th>Telefono</th>
                                        <th>CURP</th>
                                        <th>Rol</th>         
                                        <th>Sueldo</th>  
                                        <th>Eventos</th>
                                        <th>Editar</th>
                                        <th>Eliminar</th>

                                                                             
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if(!empty($usuarios)):?>                           
                                    <?php foreach ($usuarios as $usuario):?>
                                    <tr>   


                                    <?php switch($usuario->plaza_id): 
                                    case 1: ?>                                    
                                    <td bgcolor="#bae6ff"><?=$usuario->Plaza;?></td>     
                                    <?php break; ?>

                                    <?php case 2: ?>
                                    <td bgcolor="#FA8072"><?=$usuario->Plaza;?></td>                                    
                                    <?php break; ?>
                                    
                                    <?php case 3: ?>
                                    <td bgcolor="#8cedbc"><?=$usuario->Plaza;?></td>
                                    <?php break; ?>

                                    <?php case 4: ?>
                                    <td bgcolor="#ecccbb"><?=$usuario->Plaza;?></td>
                                    <?php break; ?>

                                    <?php case 5: ?>
                                    <td bgcolor="#ffd682"><?=$usuario->Plaza;?></td>
                                    <?php break; ?>

                                    <?php case 6: ?>
                                    <td bgcolor="#e7bbec"><?=$usuario->Plaza;?></td>
                                    <?php break; ?>
                                    
                                    <?php case 7: ?>
                                    <td bgcolor="#c7d5d8"><?=$usuario->Plaza;?></td>
                                    <?php break; ?>
                                    
                                    <?php endswitch; ?>
                                        
                                        <td><?=$usuario->Nombre;?></td>   
                                        <td><?=$usuario->Apellido_Paterno;?></td> 
                                        <td><?=$usuario->Apellido_Materno;?></td> 
                                        <td><?=$usuario->Nombre_Rol;?></td>
                                        <td><?=$usuario->Fecha_Nacimiento;?></td>
                                        <td><?=$usuario->Fecha_Ingreso;?></td>
                                        <td><?=$usuario->Fecha_Egreso;?></td>
                                        <td><?=$usuario->Telefono;?></td> 
                                        <td><?=$usuario->CURP;?></td> 
                                        <td><?=$usuario->Rol;?></td>  
                                        <td>$<?=$usuario->Sueldo;?></td>   
                                        <td>
                                            <button type="button" class="btn btn-info"  onclick="verEventos(<?php echo $usuario->id;?>)"  data-toggle="modal" data-target="#eventosUsuario" value="">
                                                <span class="fa fa-search"></span>
                                            </button>
                                        </td>

                                        <td>
                                            <button type="button" class="btn btn-success"  onclick="asignarValoresUsuario(<?php echo $usuario->id;?>,'<?php echo $usuario->Nombre;?>','<?php echo $usuario->Apellido_Paterno;?>','<?php echo $usuario->Apellido_Materno;?>','<?php echo $usuario->Nombre_Rol;?>','<?php echo $usuario->Fecha_Nacimiento;?>','<?php echo $usuario->Fecha_Ingreso;?>','<?php echo $usuario->Telefono;?>','<?php echo $usuario->CURP;?>','<?php echo $usuario->rolID;?>',<?php echo $usuario->Sueldo;?>)"  data-toggle="modal" data-target="#editarUsuario" value="">
                                                <span class="fa fa-edit"></span>
                                            </button>
                                        </td>
                                                                        
                                        <td>
                                            <button type="button" class="btn btn-danger" onclick="eliminarUsuario(<?php echo $usuario->id;?>)"  value="">
                                                <span class="fa fa-remove"></span>
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
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </section>
            <!-- /.content -->
        </div>
    <!-- /.content-wrapper -->


<!--EDICIÓN DE DATOS DE USUARIO-->
<!--/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->   
    <!-- Modal -->
    <div class="modal fade" id="editarUsuario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i>Edición de Usuarios</h4>
            </div>

            <div class="modal-body">
            <form class="form-horizontal" method="post" id="editarUsuarioN" name="editarUsuarioN">

            <input type="hidden" name="usuario_id_editar" id="usuario_id_editar">            
                    
                <div class="form-group" >
                    <label for="nombre_editar" class="col-sm-3 control-label">Nombre: </label>
                    <div class="col-sm-8">     
                        <input type="text"  class="form-control" id="nombre_editar" name="nombre_editar" value="" required>                                                                           
                    </div>              
                </div>

                <div class="form-group" >
                    <label for="apellido_paterno_editar" class="col-sm-3 control-label">Ap. Paterno: </label>
                    <div class="col-sm-8">     
                        <input type="text"  class="form-control" id="apellido_paterno_editar" name="apellido_paterno_editar" value="" required>                                                                           
                    </div>              
                </div>

                <div class="form-group" >
                    <label for="apellido_materno_editar" class="col-sm-3 control-label">Ap. Materno: </label>
                    <div class="col-sm-8">     
                        <input type="text"  class="form-control" id="apellido_materno_editar" name="apellido_materno_editar" value="" required>                                                                           
                    </div>              
                </div>

                <div class="form-group" >
                    <label for="nombre_rol_editar" class="col-sm-3 control-label">Nombre para rol: </label>
                    <div class="col-sm-8">     
                        <input type="text"  class="form-control" id="nombre_rol_editar" name="nombre_rol_editar" value="" required>                                                                           
                    </div>              
                </div>

                <div class="form-group">
                    <label for="fecha_nacimiento_editar" class="col-sm-3 control-label">Fecha Nacimiento: </label>
                    <div class="col-sm-8">     
                    <input type="date" class="form-control" name="fecha_nacimiento_editar" id="fecha_nacimiento_editar" value="" required>                                                                                                   
                    </div>              
                </div>  

                <div class="form-group">
                    <label for="telefono_editar" class="col-sm-3 control-label">Teléfono: </label>
                    <div class="col-sm-8">     
                    <input type="text" class="form-control" name="telefono_editar" id="telefono_editar" value="" required>                                                                                                   
                    </div>              
                </div>
                                                                                    
                <div class="form-group" >
                    <label for="CURP_editar" class="col-sm-3 control-label">CURP: </label>
                    <div class="col-sm-8">     
                    <input type="text" class="form-control" name="CURP_editar" id="CURP_editar" value="" required>                                                                                                   
                    </div>              
                </div>  

                <div class="form-group">
                    <label for="fecha_ingreso_editar" class="col-sm-3 control-label">Fecha Ingreso: </label>
                    <div class="col-sm-8">     
                    <input type="date" class="form-control" name="fecha_ingreso_editar" id="fecha_ingreso_editar" value="">                                                                                                   
                    </div>              
                </div>  

                <div class="form-group">
                    <label for="rol_id_editar" class="col-sm-3 control-label">Rol:</label>
                    <div class="col-sm-8">  
                            
                            <select name="rol_id_editar" id="rol_id_editar" class="form-control" required>
                                <?php foreach ($roles as $rol):?>                                            
                                <option value="<?php echo $rol->id?>">
                                <?php
                                    echo $rol->Nombre;?>
                                </option>
                                <?php endforeach;?>
                            </select>

                    </div>
                </div>
             
                <div class="form-group">
                    <label for="sueldo_editar" class="col-sm-3 control-label">Sueldo: </label>
                    <div class="col-sm-8">     
                        <input type="number" placeholder="$" step="0.01" class="form-control" id="sueldo_editar" name="sueldo_editar" value="">                                                                   
                    </div>              
                </div> 
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary" id="editar_usuarioN">Actualizar datos</button>
            </div>
            </form>
            </div>
    </div>
    </div>
    <!--/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
    <!--EDICIÓN DE DATOS POR USUARIO-->
<!--/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

<!--TABLA PARA MOSTRAR EL HISTORIAL DE EVENTOS DE UN USUARIO-->    
    <div class="modal fade" id="historialUsuarioModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Historial de Usuario</h4>
            </div>
            <div class="modal-body">
                <div class="responsive-table">
                    <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_prueba_API" >
                                    <thead>
                                        <tr>                                    
                                            <th>Fecha</th>                                                                                                                 
                                            <th>Nombre</th>                                                                                 
                                            <th>Ap. Paterno</th>
                                            <th>Concepto</th>  
                                            <th>Importe</th>  
                                            <th>Nota</th>  
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
<!--TABLA PARA MOSTRAR EL HISTORIAL DE EVENTOS DE UN USUARIO-->

<script type="text/javascript">  

    //#region ACTUALIZANDO USUARIOS
        $( "#editarUsuarioN" ).submit(function( event ) {                        
            var parametros = $(this).serialize();     
            //alert(parametros);      
                        $.ajax({
                        type: "POST",
                        url: "<?php echo base_url();?>Nominas/actualizarUsuario",
                        data: parametros,                  
                        success: function(response){
                            //alert(response);                                      
                            if(response==1){
                                swal({
                                    position: 'top-end',
                                    type: 'success',
                                    title: 'Usuario correctamente actualizado!!',
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
                                    title: 'Ocurrio un error al registrar el usuario',
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

    function eliminarUsuario(id){    
        var parametros = {
                        "usuario_id" : id                                   
                        };  
            
            //alert(parametros);

        swal({
            title: '¿Está seguro?',
            text: "Desea eliminar el usuario",
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
                    url: "<?php echo base_url();?>Nominas/eliminarUsuario",    
                    data: parametros,                     
                    success: function(data){                                                         
                    if(data==0){                            
                        swal({
                        type: 'error',
                        title: 'No se pudo eliminar el usuario',
                        text: 'Usuario no eliminado'                    
                        }).then(function() {                        
                            //location.reload();
                        });                            
                    }else if(data==1){                                                                        
                        swal({
                            title: "Usuario correctamente eliminado!",
                            text: "Usuario eliminado",
                            type: "success"
                        }).then(function() {                                                           
                            location.reload();                                               
                        }); 
                    }
                    else if(data==2){
                        swal({
                        type: 'error',
                        title: 'No se pudo eliminar el usuario pues se encuentra rolado',
                        text: 'Después de liberar la nomina semanal trate de eliminar el usuario'                    
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

    function asignarValoresUsuario(usuario_id,nombre,apellidoPaterno,apellidoMaterno,nombreRol,fechaNacimiento,fechaIngreso,telefono,curp,rol,sueldo){            
        $('#usuario_id_editar').val(usuario_id);
        $('#nombre_editar').val(nombre);
        $('#apellido_paterno_editar').val(apellidoPaterno);
        $('#apellido_materno_editar').val(apellidoMaterno);
        $('#nombre_rol_editar').val(nombreRol);
        $('#fecha_nacimiento_editar').val(fechaNacimiento);
        $('#telefono_editar').val(telefono);
        $('#CURP_editar').val(curp);
        $('#sueldo_editar').val(sueldo);  
        $('#fecha_ingreso_editar').val(fechaIngreso);
        $("#rol_id_editar option[value='"+rol+"']").attr('selected', 'selected');
    }

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


    function verEventos(usuario_id){    
        $('#historialUsuarioModal').modal('show');
        var parametros = {                
                "usuario_id" : usuario_id            
                };

                $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>Nominas/consultarHistorialUsuariosAdministrador",
                data: parametros,              
                dataType: "JSON",                                 
                success: function(response){  
                    pruebaAPI.clear();   
                    var len = response.length;                                           
                    for(var i=0; i<len; i++){                        
                        var id=response[i].usuario_nomina_id;
                        var fecha = response[i].Fecha;
                        var usuario=response[i].Usuario;                        
                        var apPaterno=response[i].Paterno;
                        var concepto=response[i].Concepto; 
                        var extra=response[i].Importe;                        
                        var nota=response[i].Nota;          
                        var turno=response[i].turno_id;                                                      
                        pruebaAPI.row.add([fecha,usuario,apPaterno,concepto,"$"+extra,nota]);                    
                    }                                                
                    pruebaAPI.draw();                                                
                },
                error: function() { 
                    alert("Error posting feed.");
                }
            });
    }

    function eliminarEvento(fecha,usuario_id,turno_id){                    
        var parametros = {
            "fecha":fecha,
            "usuario_id":usuario_id,
            "turno_id":turno_id                                   
        };  

        alert(fecha+" "+usuario_id+" "+turno_id);

        swal({
            title: '¿Está seguro?',
            text: "Desea eliminar el evento",
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
                    url: "<?php echo base_url();?>Nominas/eliminarEventoC",    
                    data: parametros,                     
                    success: function(data){                                                         
                    if(data==0){                            
                        swal({
                            position: 'top-end',
                            type: 'error',
                            title: 'Ha ocurrido un error al tratar de eliminar el evento',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                    else if(data==1){
                        swal({
                            position: 'top-end',
                            type: 'success',
                            title: 'Evento correctamente eliminado !!',
                            showConfirmButton: false,
                            timer: 1000
                            }).then(function() {                                                            
                                location.reload(); 
                        });
                    }                        
                    else if(data==2)
                    {                        
                        swal({
                            position: 'top-end',
                            type: 'error',
                            title: 'No se encontro el evento. No se pudo eliminar',
                            showConfirmButton: false,
                            timer: 1500
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

    
