<!-- =============================================== -->
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                Usuarios
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
                            <div class="col-md-12">                               
                            <!-- ERROR EN EL PROCESAMIENTO DEL ARCHIVO -->
                            <?php if($this->session->flashdata("error")):?>                                  
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h4><i class="icon fa fa-ban"></i> Alerta!</h4>
                                    <?php echo $this->session->flashdata("error");?>
                                </div>
                                <?php endif; ?>
                            <!-- /. ERROR EN EL PROCESAMIENTO DEL ARCHIVO -->

                             <!-- ERROR EN EL PROCESAMIENTO DEL ARCHIVO -->
                                <?php if($this->session->flashdata("message")):?>                                  
                                <div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h4><i class="icon fa fa-check"></i>Peril Actualizado</h4>            
                                </div>
                                <?php endif; ?>
                            <!-- /. ERROR EN EL PROCESAMIENTO DEL ARCHIVO -->

                            <div class="form-group">                                                         
                                <button type='button' class="btn btn-primary btn-flag" data-toggle="modal" data-target="#nuevoUsuario"><span class="glyphicon glyphicon-plus" ></span> Agregar Usuario</button>                                                                
                            </div>
                            
                            <div class="form-group">
                            <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_usuarios">
                            <thead>
                                <tr>                                    
                                    <th>Nombre</th>                                    
                                    <th>Edad</th>  
                                    <th>Email</th>                     
                                    <th>User Name</th>                                    
                                    <th>Plaza</th>                                                                        
                                    <th>Editar</th>
                                    <th>Eliminar</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($usuarios)):?>
                                <?php foreach ($usuarios as $usuario):?>
                                   <tr>                                    
                                    <td><?=$usuario->Nombre;?></td>                                  
                                    <td><?=$usuario->Edad;?></td>
                                    <td><?=$usuario->Email;?></td>
                                    <td><?=$usuario->Usuario;?></td>                                    
                                    <td><?=$usuario->Plaza;?></td>                                        

                                    <td>
                                    <a href="<?php echo base_url();?>Usuarios/editAdmin/<?php echo $usuario->sha1_id;?>" class="btn btn-warning">
                                            <span class="fa fa-pencil">
                                            </span></a>  
                                    </td>    

                                    <td>
                                    <button onclick="eliminarUsuario('<?php echo $usuario->Hash;?>')" class="btn btn-danger btn-remove">
                                            <span class="fa fa-remove">
                                            </span></button>                                                                        
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





<!-- Modal -->
<div class="modal fade" id="nuevoUsuario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Agregar nuevo usuario</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="guardarUsuario" name="guardar_producto">
			<input type="hidden" value="<?php echo $this->session->userdata("plaza")?>" name="usuario_id">

			<div id="resultados_ajax_productos"></div>
			
              <div class="form-group <?php echo !empty(form_error("nombre"))? 'has-error':'' ?>" required>
				<label for="nombre" class="col-sm-3 control-label">Nombre: </label>
                <div class="col-sm-8">     
                    <input type="text" pattern="[a-zA-Z]*" class="form-control" id="nombre" name="nombre" value="<?php echo set_value("nombre");?>" required>                            
                    <?php echo form_error("nombre","<span class='help-lock'>","</span>")?>          
                   
                </div>				
			  </div>
			  
			  <div class="form-group <?php echo !empty(form_error("apepat"))? 'has-error':'' ?>" required>
				<label for="apepat" class="col-sm-3 control-label">Apellido Paterno:</label>
				<div class="col-sm-8">	
                        <input type="text" pattern="[a-zA-Z]*" class="form-control" id="apepat" name="apepat" value="<?php echo set_value("apepat");?>" required>                            
                        <?php echo form_error("apepat","<span class='help-lock'>","</span>")?>					  
				</div>
			  </div>

              <div class="form-group <?php echo !empty(form_error("apemat"))? 'has-error':'' ?>">
				<label for="apemat" class="col-sm-3 control-label">Apellido Materno:</label>
				<div class="col-sm-8">	
                        <input type="text" pattern="[a-zA-Z]*" class="form-control" id="apemat" name="apemat" value="<?php echo set_value("apemat");?>" required>                            
                        <?php echo form_error("apemat","<span class='help-lock'>","</span>")?>				  
				</div>
			  </div>

              <div class="form-group <?php echo !empty(form_error("edad"))? 'has-error':'' ?>">
				<label for="edad" class="col-sm-3 control-label">Edad:</label>
				<div class="col-sm-8">	
                        <input type="number" min="0" class="form-control" id="edad" name="edad" value="<?php echo set_value("edad");?>" required>                            
                        <?php echo form_error("edad","<span class='help-lock'>","</span>")?>
				</div>
			  </div>

              <div class="form-group">        
              <label for="permiso" class="col-sm-3 control-label">Sexo:</label>
                        <div class="col-sm-8">                        
                                <label class="radio-inline">
                                    <input type="radio" name="sexo" value="H" checked="checked">Hombre
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="sexo" value="M" >Mujer
                                </label>
                        </div>                                                                             				                                                                
                    </div> 

                <div class="form-group <?php echo !empty(form_error("email"))? 'has-error':'' ?>">
				<label for="email" class="col-sm-3 control-label">Email:</label>
				<div class="col-sm-8">	
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo set_value("email");?>" required>                            
                        <?php echo form_error("email","<span class='help-lock'>","</span>")?>
				</div>
			  </div>

                 <div class="form-group">
				<label for="plaza_id" class="col-sm-3 control-label">Plaza:</label>
				<div class="col-sm-8">	
                        <select name="plaza_id" id="plaza_id" class="form-control">
                            <?php foreach ($plazas as $plaza):?>                                            
                            <option value="<?php echo $plaza->id?>">
                            <?php
                                echo $plaza->Nombre;?>
                            </option>
                            <?php endforeach;?>
                        </select>
				</div>
			  </div>

                <div class="form-group">
				<label for="rol_id" class="col-sm-3 control-label">Rol:</label>
				<div class="col-sm-8">	
                        <select name="rol_id" id="rol_id" class="form-control">
                            <?php foreach ($roles as $rol):?>                                            
                            <option value="<?php echo $rol->id?>">
                            <?php
                                echo $rol->Nombre;?>
                            </option>
                            <?php endforeach;?>
                        </select>
				</div>
			  </div>

               <div class="form-group <?php echo !empty(form_error("usuario"))? 'has-error':'' ?>">
				<label for="usuario" class="col-sm-3 control-label">User Name:</label>
				<div class="col-sm-8">	
                        <input type="text"  class="form-control" id="usuario" name="usuario" value="<?php echo set_value("usuario");?>" required>                            
                        <?php echo form_error("usuario","<span class='help-lock'>","</span>")?>
				</div>
			  </div>

               <div class="form-group <?php echo !empty(form_error("password"))? 'has-error':'' ?>">
				<label for="password" class="col-sm-3 control-label">Password:</label>
				<div class="col-sm-8">	
                        <input type="password" class="form-control" id="password" name="password" value="<?php echo set_value("password");?>" required>                            
                        <?php echo form_error("password","<span class='help-lock'>","</span>")?>
				</div>
			  </div>


		  </div>

		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" id="guardar_usuario">Guardar datos</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>

    <script type="text/javascript">  
        
//#region REGISTRANDO USUARIOS EN EL SISTEMA 
    $( "#guardarUsuario" ).submit(function( event ) {
        $('#guardar_usuario').attr("disabled", true);  
        var parametros = $(this).serialize();        
            $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>Usuarios/store",
                    data: parametros,
                    beforeSend: function(objeto){                 				
                    },
                    success: function(datos){                                
                        if(datos==0){
                            swal({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Ocurrio un error al registrar. Los campos Email y Usuario deben de ser unicos. Ya se registro algún campo en base de datos',
                            
                            }).then(function() {                        
                                $('#guardar_usuario').attr("disabled", false);
                                //window.location= "<?php echo base_url();?>Usuarios";                                               
                            });
                        }
                        else if(datos==1){
                            swal({
                                title: "Usuario Ingresado!",
                                text: "Registro Exitoso!",
                                type: "success"
                            }).then(function() {                        
                                $('#guardar_usuario').attr("disabled", false);
                                window.location= "<?php echo base_url();?>Usuarios";                                               
                            });	
                        }                                  		                                   
                },
                error: function() { alert("Error al insertar."); }
            });
            event.preventDefault();
    });
//#endregion

 //AJAX REQUEST
 function eliminarUsuario(FFfR8){            
        var parametros = {
                "FFfR8" : FFfR8                            
                };       

                swal({
                title: '¿Está seguro?',
                text: "El usuario se eliminará permanentemente",
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
                        url: "<?php echo base_url();?>Usuarios/delete2",
                        data: parametros,                                          
                        success: function(data)
                        {     
                            if(data==1)
                            {
                                swal({
                                    position: 'top-end',
                                    type: 'success',
                                    title: 'Usuario Eliminado',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(function() {                                                            
                                    window.location= "<?php echo base_url();?>Usuarios";                                               
                                });	                                    
                            }
                            else if(data==0){
                                swal({
                                    position: 'top-end',
                                    type: 'error',
                                    title: 'Error. Ups. Usuario NO Eliminado!!',
                                    showConfirmButton: false,
                                    timer: 1500
                                    }).then(function() {                                                            
                                    window.location= "<?php echo base_url();?>Usuarios";                                               
                                });	
                            }               
                            else{
                                alert("Error desconocido");
                            }                                                                            
                        },
                        error: function() { alert("Error posting feed."); }
                    });                    
                }                
                });  
    }




</script>
