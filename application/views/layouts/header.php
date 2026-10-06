<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Italian Coffee Company</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/header/css/bootstrap/css/bootstrap.min.css">
    <!-- JQuery-UI -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/header/css/jquery-ui/jquery-ui.min.css">
     <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/header/css/responsive/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/header/css/responsive/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/header/css/responsive/css/responsive.bootstrap.min.css">    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/header/css/font-awesome/css/font-awesome.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/header/css/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
    folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/header/css/dist/css/skins/_all-skins.min.css">
    <!-- SweetAlert2-->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/header/css/sweetalert2.css">
     <!-- IOnicoons-->
     <link rel="stylesheet" href="<?php echo base_url();?>assets/css/header/css/Ionicons/css/ionicons.min.css">
     <link rel="stylesheet" href="<?php echo base_url();?>assets/css/estilo.css">     
    
    <!-- jQuery 3 -->
    <script src="<?php echo base_url();?>assets/js/footer/jquery/jquery.min.js"></script> 
    <script src="<?php echo base_url();?>assets/js/footer/ploty/plotly-latest.min.js"></script>

     <!-- DataTables -->
    <script src="<?php echo base_url();?>assets/js/footer/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/footer/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>    

    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
    
    <!-- JQuery-UI --> 
    <script src="<?php echo base_url();?>assets/js/footer/datatables.net-bs/responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/footer/datatables.net-bs/responsive/js/responsive.bootstrap.min.js"></script>

    <!-- File input --> 
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/header/css/fileinput.min.css">     
                    
    <script src="<?php echo base_url();?>assets/js/footer/piexif.min.js"></script>     
    <script src="<?php echo base_url();?>assets/js/footer/sortable.min.js"></script> 
    <script src="<?php echo base_url();?>assets/js/footer/purify.min.js"></script> 
    <script src="<?php echo base_url();?>assets/js/footer/popper.min.js"></script> 
    <script src="<?php echo base_url();?>assets/js/footer/fileinput.min.js"></script> 
            
  <style>
            .swal2-popup {
        font-size: 1.6rem !important;
        }
        .noselect {
        -webkit-touch-callout: none; /* iOS Safari */
        -webkit-user-select: none; /* Safari */
        -khtml-user-select: none; /* Konqueror HTML */
         -moz-user-select: none; /* Firefox */
        -ms-user-select: none; /* Internet Explorer/Edge */
        user-select: none; /* Non-prefixed version, currently
                                  supported by Chrome and Opera */
}





.table td {
   text-align: center;   
}

.table_morecondensed>thead>tr>th, 
.table_morecondensed>tbody>tr>th, 
.table_morecondensed>tfoot>tr>th, 
.table_morecondensed>thead>tr>td, 
.table_morecondensed>tbody>tr>td, 
.table_morecondensed>tfoot>tr>td{ padding: 2px; }






a:hover
{   
  text-decoration: none;
  color: black;
}

a.hover:hover
{   text-decoration: none;
color: black;}

.good:hover{
    color:inherit;
}

.modal-body {
  overflow-x: auto;
}

.modal {
  overflow-y:auto;
}


.table thead,
.table th {text-align: center;}

@media (min-width: 768px) {
  .modal-xl {
    width: 100%;
    max-width:1100px;
  }
}

#modalNuevaCapturaDatos {
  z-index: 1050; 
}

#modalNuevaCapturaResumen{
  z-index: 1051; 
}

                  
</style>

</head>
<body class="sidebar-mini fixed  skin-blue hold-transition">
    <!-- Site wrapper -->
    <div class="wrapper">
        <header class="main-header">
            <!-- Logo -->
            <a href="<?php echo base_url();?>" class="logo">
       
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><b>AN</b>FU</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg">     <img src="<?php echo base_url()?>assets/images/coffe.png" class="user-image" alt="User Image"><b> <?php echo $this->session->userdata('plaza_nombre') ?></b></span>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">                                
                                <?php if($this->session->userdata("sexo")=='H'):?>  
                                    <img src="<?php echo base_url()?>assets/images/man.png" class="user-image" alt="User Image">
                                <?php else:?>    
                                    <img src="<?php echo base_url()?>assets/images/woman.png" class="user-image" alt="User Image">
                                <?php endif;?>  
                               
                                <span class="hidden-xs">
                                <?php echo $this->session->userdata("nombre")?>
                                </span>
                            </a>
                            <ul class="dropdown-menu">

                                <li class="user-header">
                                <?php if($this->session->userdata("sexo")=='H'):?>  
                                    <img src="<?php echo base_url()?>assets/images/man.png" class="img-circle" alt="User Image">
                                <?php else:?>    
                                    <img src="<?php echo base_url()?>assets/images/woman.png" class="img-circle" alt="User Image">
                                <?php endif;?>  
                                        <p>
                                        <?php echo $this->session->userdata("nombre")?>
                                        <?php echo $this->session->userdata("apepat")?>
                                        <?php echo $this->session->userdata("apemat")?>                                   
                                        <small>Sesión: Activa</small>
                                        </p>
                                </li>
                                <li class="user-body">
                                    <div class="row">
                                        <div class="col-xs-12 text-center">
                                            <a href="<?php echo base_url(); ?>Seguridad/logout"> <?php echo $this->session->userdata("plaza_nombre")?></a>                                            
                                        </div>
                                        <div class="col-xs-12 text-center">
                                            <a href=""></a>                                            
                                        </div>
                                    </div>
                                    <!-- /.row -->
                                </li>
                                <li class="user-footer">
                                    <div class="pull-left">                                
                                    <a href="<?php echo base_url(); ?>Perfiles" class="btn btn-default btn-flat">Perfil</a>
                                    </div>
                                    <div class="pull-right">
                                    <a href="<?php echo base_url(); ?>Seguridad/logout" class="btn btn-default btn-flat">Cerrar Sesión</a>
                                    </div>
                            </li>
                            </ul>
                        </li>
                           
                    </ul>
                </div>
            </nav>
        </header>