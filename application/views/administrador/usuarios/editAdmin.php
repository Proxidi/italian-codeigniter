<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
<h1>
Usuarios
<small>Nuevo</small>
</h1>
<a href="<?php echo base_url();?>Usuarios" class="small-box-footer">Volver a la lista de Usuarios<i class="fa fa-arrow-circle-right"></i></a>                
</section>
<!-- Main content -->
<section class="content">
<!-- Default box -->
<div class="box box-solid">
<div class="box-body">        
        <div class="row">
        <div class="col-md-12">
        <?php if($this->session->flashdata("error")):?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-ban"></i> Error al actualizar !</h4>
            <?php
            echo $this->session->flashdata("error");
            ?>
        </div>
        <?php endif; ?>
            <form action="<?php echo base_url();?>Usuarios/update" method="POST">
            <input type="hidden" value="<?php echo $usuario->sha1_id?>" name="FFfR8">
        
            <div class="form-group <?php echo !empty(form_error("nombre"))? 'has-error':'' ?>" required>
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo !empty(form_error('nombre')) ? set_value('nombre'): $usuario->Nombre?>" required>                            
                <?php echo form_error("nombre","<span class='help-lock'>","</span>")?>
            </div>

            <div class="form-group <?php echo !empty(form_error("apepat"))? 'has-error':'' ?>" required>
                <label for="apepat">Apellido Paterno:</label>
                <input type="text" class="form-control" id="apepat" name="apepat" value="<?php echo !empty(form_error('apepat')) ? set_value('apepat'): $usuario->Apepat?>" required>                            
                <?php echo form_error("apepat","<span class='help-lock'>","</span>")?>
            </div>

            <div class="form-group <?php echo !empty(form_error("apemat"))? 'has-error':'' ?>">
                <label for="apemat">Apellido Materno:</label>
                <input type="text" class="form-control" id="apemat" name="apemat" value="<?php echo !empty(form_error('apemat')) ? set_value('apemat'): $usuario->Apemat?>" required>                            
                <?php echo form_error("apemat","<span class='help-lock'>","</span>")?>
            </div>

            <div class="form-group <?php echo !empty(form_error("edad"))? 'has-error':'' ?>">
                <label for="edad">Edad:</label>
                <input type="number" class="form-control" id="edad" name="edad" value="<?php echo !empty(form_error('edad')) ? set_value('edad'): $usuario->Edad?>" required>                            
                <?php echo form_error("edad","<span class='help-lock'>","</span>")?>
            </div>

            <div class="form-group <?php echo !empty(form_error("email"))? 'has-error':'' ?>">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo !empty(form_error('email')) ? set_value('email'): $usuario->Email?>" required>                            
                <?php echo form_error("email","<span class='help-lock'>","</span>")?>
            </div>


                <div class="form-group ">
                    <label for="plaza_id">Plaza:</label>
                    <select name="plaza_id" id="plaza_id" class="form-control">
                    <?php foreach ($plazas as $plaza):?>
                        <?php if($plaza->id==$usuario->plaza_id):?>
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

            

            <div class="form-group ">
                    <label for="rol_id">Rol:</label>
                    <select name="rol_id" id="rol_id" class="form-control">
                    <?php foreach ($roles as $rol):?>
                        <?php if($rol->id==$usuario->rol_id):?>
                        <option value="<?php echo $rol->id?>" selected>
                        <?php echo $rol->Nombre;?>
                        </option>
                    <?php else:?>
                    <option value="<?php echo $rol->id?>">
                        <?php echo $rol->Nombre;?>
                    </option>
                    <?php endif;?>
                        <?php endforeach;?>?>
                    </select>
                </div>  

                <div class="form-group <?php echo !empty(form_error("usuario"))? 'has-error':'' ?>">
                <label for="usuario">User Name:</label>
                <input type="text" class="form-control" id="usuario" name="usuario" value="<?php echo !empty(form_error('usuario')) ? set_value('usuario'): $usuario->Usuario?>" required>                            
                <?php echo form_error("usuario","<span class='help-lock'>","</span>")?>
            </div>

            

            <div class="form-group <?php echo !empty(form_error("password"))? 'has-error':'' ?>">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" value="<?php echo !empty(form_error('password')) ? set_value('password'): $usuario->Password?>" required>                            
                <?php echo form_error("password","<span class='help-lock'>","</span>")?>
            </div>


                                                                            
            
            <div class="form-group">
                <button type="submit" class="btn btn-success btn-flat">Guardar</button>
            </div>

            </form>

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
