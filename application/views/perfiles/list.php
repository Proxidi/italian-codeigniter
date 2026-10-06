
        <!-- =============================================== -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
               Mi Perfil
                <small>Listado</small>
                </h1>
                <a href="<?php echo base_url(); ?>Inicio" class="small-box-footer">Volver al Panel de Inicio <i class="fa fa-arrow-circle-right"></i></a>
            </section>
           
            <!-- Main content -->
            <section class="content">
                <!-- Default box -->
                <div class="box box-solid">
                    <div class="box-body">
                <!-- ERROR EN EL PROCESAMIENTO DEL ARCHIVO -->
                    <?php if($this->session->flashdata("message")):?>                                  
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i>Peril Actualizado</h4>            
                    </div>
                    <?php endif; ?>
                <!-- /. ERROR EN EL PROCESAMIENTO DEL ARCHIVO -->
                        <div class="row">
                            <div class="col-md-12">
                            
                            </div>
                         </div>                         
                         <div class="row">
                            <div class="col-md-12">
                            <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_perfil">
                            <thead>
                                <tr>
                                    
                                    <th>Nombre</th>
                                    <th>ApPat</th>
                                    <th>ApMat</th>
                                    <th>Edad</th>
                                    <th>E-mail</th>
                                    <th>Username</th>                                    
                                    <th>Plaza</th>                                    
                                    
                                    <th>Editar</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($usuarios)):?>
                                <?php foreach ($usuarios as $usuario):?>
                                   <tr>                                    
                                    <td><?=$usuario->Nombre;?></td>
                                    <td><?=$usuario->Apepat;?></td>
                                    <td><?=$usuario->Apemat;?></td>
                                    <td><?=$usuario->Edad;?></td>
                                    <td><?=$usuario->Email;?></td>
                                    <td><?=$usuario->Usuario;?></td>                                    
                                    <td><?=$usuario->Plaza;?></td>                                                                        
                                   
                                    <td>
                                    <?php if($this->session->userdata("rol_id")==2 || $this->session->userdata("rol_id")==4 ||$this->session->userdata("rol_id")==5):?>
                                    <a href="<?php echo base_url();?>Usuarios/editManager/<?php echo $usuario->sha1_id;?>" class="btn btn-warning">
                                            <span class="fa fa-pencil">
                                            </span></a>
                                    <?php elseif($this->session->userdata("rol_id")==3):?>     
                                    <a href="<?php echo base_url();?>Usuarios/editAdmin/<?php echo $usuario->sha1_id;?>" class="btn btn-warning">
                                            <span class="fa fa-pencil">
                                            </span></a>
                                     <?php endif;?>    
                                          
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


