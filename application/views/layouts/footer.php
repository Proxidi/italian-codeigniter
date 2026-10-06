<footer class="main-footer">
            <div class="pull-right hidden-xs">
                <b>Version</b> 1.0
            </div>
            <strong>Copyright &copy; 2018 <a href="#">The Italian Coffee Company</a>.</strong> All rights
            reserved.
        </footer>
    </div>
    <!-- ./wrapper -->
    
    <!-- SweetAlert2-->
<script src="<?php echo base_url();?>assets/js/footer/sweetalert2.js"></script>
    <!-- SweetAlert2-->
<script src="<?php echo base_url();?>assets/js/footer/sweetalert2.all.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url();?>assets/js/footer/bootstrap/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="<?php echo base_url();?>assets/js/footer/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo base_url();?>assets/js/footer/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url();?>assets/js/footer/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url();?>assets/js/footer/dist/js/demo.js"></script> 
<!-- Users -->
<script src="<?php echo base_url();?>assets/js/tables.js"></script>
<!-- Ordering DropDowns -->
<script src="<?php echo base_url();?>assets/js/order.js"></script>
<!-- Frases -->
<script src="<?php echo base_url();?>assets/js/frases.js"></script>
<script src="<?php echo base_url();?>assets/js/fecha.js"></script>




<script type="text/javascript">    
// /.document.Ready()--BEGIN -->
$(document).ready(function () {
    //#region  VARIABLES INICIALES DEL PROYECTO
        
        //VARIABLE DIRECCIÓN DEL PROYECTO
            var base_url= "<?php echo base_url();?>";
            var bandera=0;
        //VARIABLE DIRECCIÓN DEL PROYECTO
        
        //VARIABLE MODAL DE INICIO
            var modal= "<?php echo $this->session->userdata("modal") ;?>";
            var user= "<?php echo $this->session->userdata("nombre") ;?>";  
        //VARIABLE MODAL DE INICIO    
            
        //APLICANDO LA FUNCIONALIDAD DE ARBOL AL SIDEBAR
            $('.sidebar-menu').tree();
            $("#tbl_pedidos_manager_hide").hide();
            $("#tbl_todas_formulas_ajax").hide(); 
            $('#tbl_inventario_fisico_2').hide();      
            $('#tbl_permisos_2').hide();              
            $("#tbl_stocks_2").hide();     
            $("#liberar").hide();
        //APLICANDO LA FUNCIONALIDAD DE ARBOL AL SIDEBAR

        //VARIABLES CUANDO SE AGREGA UN NUEVO INSUMO
            $('#unit_id_bodega').hide();
            $('#unit_id_piso').hide();
            $('#unit_id_total').hide();
            $('#unit_prod').hide();
            $('#unit_remesa').hide();
            $('#unit_grupos_remesa').hide();            
            $('#unit_pedido').hide();
            $('#unit_clave_pedido').hide();  

            $("#unidad_id_produccion").removeAttr('required');
            $("#unidad_id_piso").removeAttr('required');
            $("#formula_piso").removeAttr('required');
            $("#unidad_id_bodega").removeAttr('required');
            $("#formula_bodega").removeAttr('required');
            $("#unidad_id_total").removeAttr('required');
            $("#formula_total").removeAttr('required');
            $("#categoria_id_remesa").removeAttr('required');
            $("#unidad_id_remesa").removeAttr('required');
            $("#limite_captura_remesa").removeAttr('required');
            $("#clave_pedido").removeAttr('required');
            $("#unidad_id_pedido").removeAttr('required');
            $("#formula_pedido").removeAttr('required');
        //.VARIABLES CUANDO SE AGREGA UN NUEVO INSUMO   

    //#endregion

    //#region MÉTODO PARA LAS NOTIFICACIONES
        document.getElementById("notificaciones").addEventListener("click", function(){        
        
            var parametros = {                
                };  
        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>Inicio/reasignar",
            data: parametros,
            dataType: "JSON",
            success: function(response){
                var len = response.length;
                    
                    for(var i=0; i<len; i++){
                        var cadena = response[i].cadena;
                        var cadena2 = response[i].cadena2;
                        var cadena3 = response[i].cadena3; 
                        var cadena4 = response[i].cadena4;    
                        var cadena5 = response[i].cadena5;    

                        }                        
                swal({                                                                              
                    width:500,
                    html:cadena+cadena2+cadena3+cadena4+cadena5,  
                    confirmButtonText: "Aceptar",
                    animation: true,
                    allowOutsideClick: false                   
            });	                                
            },
            error: function() { alert("Error posting feed."); }
        }); 
            
        });
    //#endregion            


    //#region  MODAL FRASES AL INICIO        
        var randomFrase = frases[Math.floor(Math.random()*frases.length)];
        if(modal==1){
            var modals=[];
            var parametros = {};  
            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>Inicio/reasignar",
                data: parametros,
                dataType: "JSON",
                success: function(response){      
                    
                        var len = response.length;                    
                        for(var i=0; i<len; i++){
                            var cadena = response[i].cadena;
                            var cadena2 = response[i].cadena2;
                            var cadena3 = response[i].cadena3;   
                            var cadena4= response[i].cadena4;   
                            var cadena5= response[i].cadena5;         
                            }     

                modals.push({                                                                              
                        width:500,                
                        html: cadena+cadena2+cadena3+cadena4+cadena5,  
                        confirmButtonText: "Aceptar",
                        animation: true,
                        allowOutsideClick: false                    
                });	
                                                                    
                },
                error: function() { alert("Error posting feed."); }
            });

            modals.push({
                    title: 'Bienvenido(a): '+user,
                    text: randomFrase,
                    imageWidth: 400,
                    imageHeight: 300,
                    imageAlt: 'Custom image',
                    animation: true,
                    allowOutsideClick: false
            });        
            swal.queue(modals);
                        
            <?php $this->session->set_userdata('modal', 0);?>                
        }        
    //#endregion 
        
    //#region VERIFICAR CONTRASEÑA, ACTUALIZAR PERFIL    
        if( window.location.href === 'https://sistemastez.com/Perfiles' || window.location.href === 'https://sistemastez.com/Usuarios' || window.location.href === 'https://sistemastez.com/Inventario/add2') {
            (async function getPassword () {
            const {value: password} = await swal({
            title: 'Confirma que no eres un robot',
            input: 'password',
            inputPlaceholder: 'Ingrese Password , Después presione ENTER',
            inputAttributes: {
                maxlength: 15,
                autocapitalize: 'off',
                autocorrect: 'off'
            },
            allowOutsideClick: false,
            showCancelButton: false,
            showConfirmButton: false  
            })
            if (password) {
            /////////////////////////////////////////////////////////
            var parametros = {                            
                                "pwd":password
                            };                      
                        ///*//////////////////////*//////////////////////////////////////////////////////*///////////////////
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url();?>Usuarios/verificarPWD",
                            data: parametros,                                               
                            success: function(response){  
                                if(response==1){
                                swal(
                                    'Acceso Autorizado!',
                                    'Editar Perfil.',
                                    'success'
                                );    
                                Swal({
                                type: 'success',
                                title: 'Acceso Autorizado',
                                text: 'Bienvenido',
                                allowOutsideClick: false,                            
                                });                       
                                }          
                                else if(response==0){                                                                    
                                    Swal({
                                    type: 'error',
                                    title: 'Acceso Denegado',
                                    text: 'Redireccionando',
                                    allowOutsideClick: false,
                                    }).then(function(){
                                        window.location= "<?php echo base_url();?>Inicio";   
                                    });   
                                }  
                            },
                            error: function() { 
                                alert("Error posting feed.");
                            }
                        });
            //////////////////////////////////////////////////////
            }
            })()
        }
    //#endregion    

});
// /.document.Ready()--END -->

</script>
</body>
</html>
