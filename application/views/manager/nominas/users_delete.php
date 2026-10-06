<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Tabla de Usuarios Eliminados en Nomina <?php echo $this->session->userdata("plaza_nombre")?>                                        
                <small></small>
                </h1>                
                <a href="<?php echo base_url(); ?>Nominas/manager" class="small-box-footer">Volver al Panel de Nominas <i class="fa fa-arrow-circle-right"></i></a>
            </section>

            <!-- Main content -->
            <section class="content">
            <!-- Default box -->
                <div class="box box-solid">
                    <div class="box-body">
                            <div class="row">
                            <div class="col-md-12">  
                            <div class="form-group">
                            <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_usuarios">
                                <thead>
                                    <tr>                                    
                                        <th>Nombre</th> 
                                        <th>Ap. Paterno</th>
                                        <th>Ap. Materno</th>
                                        <th>Edad</th>
                                        <th>Telefono</th>
                                        <th>CURP</th>
                                        <th>Rol</th>         
                                        <th>Sueldo</th>
                                        <th>Plaza</th>    
                                        <th>Eventos</th>                                                                                                                                                              
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if(!empty($usuarios)):?>                           
                                    <?php foreach ($usuarios as $usuario):?>
                                    <tr>                                                                        
                                        <td><?=$usuario->Nombre;?></td>   
                                        <td><?=$usuario->Apellido_Paterno;?></td> 
                                        <td><?=$usuario->Apellido_Materno;?></td> 
                                        <td><?=$usuario->Fecha_Nacimiento;?></td>
                                        <td><?=$usuario->Telefono;?></td> 
                                        <td><?=$usuario->CURP;?></td> 
                                        <td><?=$usuario->Rol;?></td>  
                                        <td>$<?=$usuario->Sueldo;?></td>                                          
                                        <td><?=$usuario->Plaza;?></td>                                                                                        
                                        <td>
                                            <button type="button" class="btn btn-info"  onclick="verEventos(<?php echo $usuario->id;?>)"  data-toggle="modal" data-target="#eventosUsuario" value="">
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
                                        <th>Usuario</th>                                                                                 
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
                        var concepto=response[i].Concepto; 
                        var extra=response[i].Importe;                        
                        var nota=response[i].Nota;          
                        var turno=response[i].turno_id;                                                      
                        pruebaAPI.row.add([fecha,usuario,concepto,"$"+extra,nota]);                    
                    }                                                
                    pruebaAPI.draw();                                                
                },
                error: function() { 
                    alert("Error posting feed.");
                }
            });
    }
            
</script>

    
