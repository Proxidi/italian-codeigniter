
        <!-- =============================================== -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                Agregar Platillos Vendidos
                <small>Platillos</small>
                </h1>
                <a href="<?php echo base_url(); ?>Inventario" class="small-box-footer">Volver al Panel del Inventario <i class="fa fa-arrow-circle-right"></i></a>
                 
            </section>
            <!-- Main content -->
            <section class="content">
                <!-- Default box -->
                <div class="box box-solid">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                            <button type='button' class="btn btn-primary btn-flag" data-toggle="modal" data-target="#nuevoReporte"><span class="glyphicon glyphicon-plus" ></span> Agregar DLC</button>                                                                                                                                                                                                                                    
                            </div>
                         </div>
                         <hr>                         
                         <div class="row">
                         <div class="col-md-12">                          
                         <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_archivos_dlc" >
                            <thead>
                                <tr>
                                    <th>Plaza</th>
                                    <th>Usuario</th>
                                    <th>Fecha</th>    
                                    <th>Archivo</th>                                 
                                    <th>Estatus</th>                                        
                                     
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($platillos)):?>                                
                                <?php foreach ($platillos as $platillo):?>                            
                            <tr>                                                                                                                                           
                                <td><?=$platillo->Plaza;?></td>  
                                <td><?=$platillo->Usuario;?></td>  
                                <td><?=$platillo->Fecha;?></td>  
                                <td>DLC</td>
                                <?php if($platillo->Estatus==1):?>                                
                                <td>Correcto</td>   
                                <?php else:?>                                                                                                                                                                                                                                               
                                <td>Error en DLC</td>   
                                <?php endif;?>                                    
                                
                            </tr>                                   
                                <?php endforeach;?>                                                              
                                <?php endif;?>                                
                            </tbody>                            
                            </table>                                            
                         </div>
                          <!-- /.row -->    
                        </div>                    
                        <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->



    <!-- Modal -->
<div class="modal fade" id="nuevoReporte" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Agregar Platillos Vendidos</h4>
		  </div>
		  <div class="modal-body">

			<form class="form-horizontal" method="POST" id="guardar_platillos" name="guardar_platillos" enctype="multipart/form-data">
			<input type="hidden" value="<?php echo $this->session->userdata("id")?>" name="usuario_id">
            <input type="hidden" value="<?php echo $this->session->userdata("plaza")?>" name="plaza_id">

              <div class="form-group">				
                <div class="col-sm-8">               
                            <label for="platillosFile">Platillos Vendidos :</label>
                            <input type="file" class="form-control" id="platillosFile" name="platillosFile" value="" required>                                                        
                </div>				
			  </div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" id="guardar_platillo">Guardar datos</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>


  <script type="text/javascript">  
    //#region RESETEANDO EL MODAL DE LOS PLATILLOS
    $('#nuevoReporte').on('hidden.bs.modal', function(e) {
      $(this).find('#guardar_platillos')[0].reset();
      });
    //#endregion


    
//#region MÉTODO PARA REGISTRAR DLC, CON GATO INCLUIDO    
$("#guardar_platillos").submit(function( event ) {
    $('#guardar_platillo').attr("disabled", true);  
    var parametros = $(this).serialize();    
        $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>Inventario/store",
                data: new FormData(this),
                processData:false,
                contentType:false,
                cache:false,
                async:true,
                beforeSend: function(objeto){
                    swal({
                    title: 'Registrando Platillos. Espere por favor !!!',
                    width: 600,
                    padding: '3em',
                    background: '#fff url(<?php echo base_url();?>assets/images/trees.png)',
                    backdrop: `
                        rgba(0,0,123,0.4)
                        url("<?php echo base_url();?>assets/images/coffe.gif")
                        center left
                        repeat
                    `,
                    allowOutsideClick: false,
                    showCancelButton: false,
                    showConfirmButton: false
                    });                          				
                },
                    success: function(datos){                                              
                        if(datos==0){
                            swal({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Ha ocurrido un error!',
                                footer: '<a href>Why do I have this issue?</a>'
                            });
                        }
                        else if(datos==1){                        
                            swal({
                                position: 'top-end',
                                type: 'success',
                                title: 'Registro Exitoso !!',
                                showConfirmButton: false,
                                timer: 1500
                                }).then(function() {                                                            
                                window.location= "<?php echo base_url();?>Inventario/addDLC";                                               
                            });	
                        }
                        else if(datos==2){
                            swal({
                            type: 'error',
                            title: 'Oops...',
                            text: 'El archivo ya esta en base de datos!',
                            footer: '<a href>Why do I have this issue?</a>'
                            });
                        }  else if(datos==3){
                            swal({
                            type: 'error',
                            title: 'Oops...',
                            text: 'El archivo no existe!',
                            footer: '<a href>Why do I have this issue?</a>'
                            });
                        } else if(datos==4){
                            swal({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Asegúrece de subir el archivo de corte primero!',
                            footer: '<a href>Why do I have this issue?</a>'
                            });
                        } 
                        else if(datos==5){                        
                            swal({
                                type: 'error',
                                title: 'Oops...',
                                text: 'La fecha supera el limite permitido de dias atrasados!',
                                footer: '<a href>Why do I have this issue?</a>'
                            });
                        }
                        else if(datos==6){                        
                            swal({
                                type: 'error',
                                title: 'Oops...',
                                text: 'La fecha tiene un formato no valido para lectura!',
                                footer: '<a href>Why do I have this issue?</a>'
                            });
                        }                                                                                                   
                        else{
                            swal({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Error Desconocido BANDERA 7!',
                            footer: '<a href>Why do I have this issue?</a>'
                            });
                        }      			
                $('#guardar_platillo').attr("disabled", false);            		            
                $("#nuevoReporte").modal('hide');                                                
            }
        });
        event.preventDefault();
    });
//#endregion





  
  </script>

	



