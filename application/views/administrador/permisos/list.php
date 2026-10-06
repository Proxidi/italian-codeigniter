
        <!-- =============================================== -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                Permisos
                <small>Listado</small>
                </h1>
                <a href="<?php echo base_url(); ?>Inicio" class="small-box-footer">Volver al Panel de Inicio <i class="fa fa-arrow-circle-right"></i></a>
            </section>
            <!-- Main content -->
            <section class="content">
                <!-- Default box -->
                <div class="box box-solid">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <button  class="btn btn-primary btn-flag" data-toggle="modal" data-target="#agregarMenu"><span class="fa fa-plus"></span>
                                Agregar Menu
                                </button>
                                <button  class="btn btn-success btn-flag" data-toggle="modal" data-target="#agregarPermiso"><span class="fa fa-plus"></span>
                                Agregar Permiso
                                </button>
                            </div>
                         </div>
                         <hr>
                         <div class="row">
                            <div class="col-md-12">
                            <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_permisos">
                            <thead>
                                <tr>
                                    <th>Tipo Usuario</th>                                
                                    <th>Menu</th>
                                    <th>Link</th>                                                                                                                 
                                    <th>Permiso</th>    
                                    <th>Permitir</th>                                
                                    <th>Denegar</th>                                
                                    
                                </tr>
                            </thead>
                            <tbody>
                            <?php if(!empty($menus)):?>
                                <?php foreach ($menus as $menu):?>
                                <tr>
                                    <td><?=$menu->Nombre;?></td>
                                    <td><?=$menu->Menu;?></td>
                                    <td><?=$menu->Link;?></td>
                                    <td><?=$menu->Permiso;?></td>                                                                                                                                                                  
                                   
                                    <td> 
                                        <button type="button" class="btn btn-success" onclick="otorgarPermiso(<?php echo $menu->rol_id;?>,<?php echo $menu->menu_id;?>)"  data-toggle="modal" data-target="#editarValorPermiso" value="">
                                            <span class="fa fa-check"></span>
                                        </button>
                                    </td>                                       
                                    <td>                                                                        
                                        <button class="btn btn-danger btn-remove" onclick="denegarPermiso()">
                                        <span class="fa fa-remove">
                                        </span></button>
                                    </td>
                                </tr>   
                                <?php endforeach;?>                                                              
                                <?php endif;?>                                 
                            </tbody>                            
                            </table>


                            <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_permisos_2">
                            <thead>
                                <tr>                                    
                                    <th>Tipo Usuario</th>                                
                                    <th>Menu</th>
                                    <th>Link</th>                                                                                                                 
                                    <th>Permiso</th>    
                                    <th>Editar</th>                                
                                    <th>Eliminar</th>                                                                                                                                                            
                                </tr>
                            </thead>
                            <tbody id="tbodyPermisosAjax">    

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

   


<div class="modal fade" id="agregarMenu">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Nuevo Menu</h4>
            </div>            
            <div class="modal-body">
            <form class="form-horizontal" method="post" id="guardarMenu" name="guardarMenu">
                <div class="form-group">                                    
                    <div class="col-md-6">
                            <label for="cantidad">Nombre:</label>
                            <input type="text" step="any" class="form-control" name="nombre" id="nombre" value="" required>                                                                
                        </div>                                                  
                        <div class="col-md-6">
                            <label for="cantidad">Link:</label>
                            <input type="text" step="any" class="form-control" name="link" id="link" value="" required>                                                                                                             
                        </div>				                                                                
                    </div>                                                                                                         
            </div>
            <div class="modal-footer">
			    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			    <button type="submit" class="btn btn-primary" id="guardar_menu">Guardar datos</button>
		    </div>
            </form>
        
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<div class="modal fade" id="agregarPermiso">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Nuevo Permiso</h4>
            </div>            
            <div class="modal-body">
            <form class="form-horizontal" method="post" id="guardarPermiso" name="guardarPermiso">   
            <div class="form-group">                           
                           <div class="col-md-6">
                               <label for="producto_id">Rol:</label>
                                   <select name="rol_id" id="rol_id" class="form-control" required>
                                   <option value="">Seleccionar Rol</option>
                                       <?php foreach ($roles as $rol):?>                        
                                       <option value="<?php echo $rol->id?>">
                                       <?php
                                           echo $rol->Nombre;?>
                                       </option>
                                       <?php endforeach;?>
                                   </select>
                           </div>        

                              <div class="col-md-6">
                                <label for="insumo_id_formulas">Menus:</label>                                
                                    <select name="menu_id" id="menu_id" class="form-control" required>
                                    <option value="">Seleccionar Menu</option>
                                        <?php foreach ($menus_list as $menu):?>                                            
                                        <option value="<?php echo $menu->id?>">
                                        <?php
                                            echo $menu->Nombre;?>
                                        </option>
                                        <?php endforeach;?>
                                    </select>
                            </div>                                                                   
                   </div>    

                   <div class="form-group">                
                        <div class="col-md-6">
                        <label for="read">Permiso:</label>
                                <label class="radio-inline">
                                    <input type="radio" name="permiso" value="1" checked="checked">Si
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="permiso" value="0" >No
                                </label>
                        </div>                                                                             				                                                                
                    </div>                        
            </div>
            <div class="modal-footer">
			    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			    <button type="submit" class="btn btn-primary" id="guardar_permiso">Guardar datos</button>
		    </div>
            </form>
        
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<script type="text/javascript">  

//#region GUARDADO DE PERMISO POR AJAX
$( "#guardarPermiso" ).submit(function( event ) {                                
                var parametros = $(this).serialize();                               
                    $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>Permisos/storePermiso",
                    data: parametros,     
                    dataType: 'JSON',           
                    success: function(response){                                          
                        var len = response.length;                
                        for(var i=0; i<len; i++){
                            var tabla = response[i].tabla;
                            var valor = response[i].valor;            
                        }                        
                        if(valor==1){
                            swal({
                            position: 'top-end',
                            type: 'success',
                            title: 'Menu registrado correctamente!!',
                            showConfirmButton: false,
                            timer: 1000
                            });
                        }  
                        else{
                            swal({
                            position: 'top-end',
                            type: 'error',
                            title: 'Ha ocurrido un error, Men no registrado!!',
                            showConfirmButton: false,
                            timer: 1500
                            });
                        }

                    $('#tbl_permisos').hide(); 
                    $('#tbl_permisos_2').show();  
                    $('#tbodyPermisosAjax').html(tabla); 
                    //$('#agregarPermiso').modal('hide');                    

                    },
                    error: function() { 
                        alert("Error posting feed.");
                    }
                });
                event.preventDefault();
            });
//#endregion 


//#region GUARDADO DE MENU POR AJAX
$( "#guardarMenu" ).submit(function( event ) {                            
            var parametros = $(this).serialize();               
                $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>Permisos/storeMenu",
                data: parametros,                
                success: function(response){ 
                    if(response==1){
                        swal({
                        position: 'top-end',
                        type: 'success',
                        title: 'Menu registrado correctamente!!',
                        showConfirmButton: false,
                        timer: 1000
                        }).then(function() {                                                            
                            //window.location= "<?php echo base_url();?>Permisos";                                      
                        });
                    }  
                    else{
                        swal({
                        position: 'top-end',
                        type: 'error',
                        title: 'Ha ocurrido un error, Menu no registrado!!',
                        showConfirmButton: false,
                        timer: 1500
                        }).then(function() {                                                            
                            //window.location= "<?php echo base_url();?>Permisos";                                      
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


function otorgarPermiso(rol_id,menu_id){                
        var parametros = {
                "rol_id" : rol_id,    
                "menu_id" : menu_id                           
        };  

        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>Permisos/otorgarPermisos",
            data: parametros, 
            dataType: "JSON",
            success: function(response){                         
                    var len = response.length;                
                        
                    for(var i=0; i<len; i++){
                            var tabla = response[i].tabla;
                            var valor = response[i].valor;            
                    }    
                        if(valor==1){
                            swal({
                            position: 'top-end',
                            type: 'success',
                            title: 'Permiso OTORGADO correctamente!!',
                            showConfirmButton: false,
                            timer: 1000
                            });
                        }  
                        else{
                            swal({
                            position: 'top-end',
                            type: 'error',
                            title: 'Ha ocurrido un error, Permiso no OTORGADO!!',
                            showConfirmButton: false,
                            timer: 1500
                            });
                        }

                    $('#tbl_permisos').hide(); 
                    $('#tbl_permisos_2').show();  
                    $('#tbodyPermisosAjax').html(tabla); 
                    $('#agregarPermiso').modal('hide');    
                
            },
            error: function() { alert("Error posting feed."); }
        }); 
    }

    function denegarPermiso(rol_id,menu_id){        
        var parametros = {
                "rol_id" : rol_id,    
                "menu_id" : menu_id                           
        };  

        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>Permisos/denegarPermisos",
            data: parametros, 
            dataType: "JSON",
            success: function(response){                         
                    var len = response.length;                
                        for(var i=0; i<len; i++){
                            var tabla = response[i].tabla;
                            var valor = response[i].valor;            
                        }    

                        if(valor==1){
                            swal({
                            position: 'top-end',
                            type: 'success',
                            title: 'Permiso DENEGADO correctamente!!',
                            showConfirmButton: false,
                            timer: 1000
                            });
                        }  
                        else{
                            swal({
                            position: 'top-end',
                            type: 'error',
                            title: 'Ha ocurrido un error, Permiso no DENEGADO!!',
                            showConfirmButton: false,
                            timer: 1500
                            });
                        }

                    $('#tbl_permisos').hide(); 
                    $('#tbl_permisos_2').show();  
                    $('#tbodyPermisosAjax').html(tabla); 
                    $('#agregarPermiso').modal('hide');    
                
            },
            error: function() { alert("Error posting feed."); }
        }); 
    }
</script>





