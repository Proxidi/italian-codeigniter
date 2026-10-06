<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Tabla de colaboradores eliminados <?php echo $nombrePlaza; ?>                                        
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
                                        <th>F. Nacimiento</th>
                                        <th>F. Ingreso</th>                                                                                                                      
                                        <th>F. Egreso</th>                                                                                
                                        <th>Telefono</th>
                                        <th>CURP</th>
                                        <th>Rol</th>         
                                        <th>Sueldo</th>  
                                        <th>Eventos</th>
                                       

                                                                             
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
                                        <td><?=$usuario->Fecha_Nacimiento;?></td>
                                        <td><?=$usuario->Fecha_Ingreso;?></td>
                                        <td><?=$usuario->Fecha_Egreso;?></td>
                                        <td><?=$usuario->Telefono;?></td> 
                                        <td><?=$usuario->CURP;?></td> 
                                        <td><?=$usuario->Rol;?></td>  
                                        <td>$<?=$usuario->Sueldo;?></td>   
                                        <td>
                                            <button type="button" class="btn btn-info"  onclick="verEventos(<?php echo $usuario->id;?>)" value="">
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

                    </div>                    
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </section>
            <!-- /.content -->
        </div>
    <!-- /.content-wrapper -->



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

</script>

    
