        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                Análisis de Unidades Vendidas
                <small>Listado</small>
                </h1>
                <a href="<?php echo base_url(); ?>Inicio" class="small-box-footer">Volver al Panel de Administración <i class="fa fa-arrow-circle-right"></i></a>
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
                                                                    
                                    <label for="" class="col-md-1 control-label">Desde:</label>
                                        <div class="col-md-3">
                                            <input type="date" class="form-control" name="fechaInicioD" id="fechaInicioD" value="<?php echo !empty($fechainicio) ? $fechainicio:'';?>" required>
                                        </div>

                                    <label for="" class="col-md-1 control-label">Hasta:</label>
                                        <div class="col-md-3">
                                            <input type="date" class="form-control" name="fechaFinD" id="fechaFinD" value="<?php  echo !empty($fechafin) ? $fechafin:'';?>">
                                        </div>

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
                                            <input type="hidden" name="hidden_country" id="hidden_country" />
                                        </div>                                                                                                       
                                </div>                
                                <div class="form-group">
                                    <label for="" class="col-md-1 control-label">Options:  </label>                           
                                        <div class="col-md-6">
                                            <input type="submit" name="buscar" value="Buscar" class="btn btn-primary">
                                            <input type="submit" name="buscarRango" value="Buscar Rango" class="btn btn-danger">                                                                            
                                            <a href="<?php echo base_url(); ?>Unidades" class="btn btn-success">Reset</a>
                                            <button type='button' class="btn btn-info btn-flag" data-toggle="modal" data-target="#modal-default"><span class="fa fa-search" ></span> Ver Gráfico</button>  
                                        </div>

                                        <label for="grupo_id" class="col-md-1 control-label">Familias:  </label>                           
                                        <div class="col-md-4">
                                        <select name="grupo_id" id="grupo_id" class="form-control">                                                  
                                            <?php foreach ($grupos as $grupo):?>  
                                            <?php if($grupo->id==1):?>
                                            <option value="" selected>
                                                Todas las familias
                                            </option>
                                            <?php endif;?>
                                            <?php if($grupo->id==$id_familia):?>
                                            <option value="<?php echo $grupo->id?>" selected>
                                            <?php echo $grupo->Nombre;?>
                                            </option>
                                            <?php else:?>
                                            <option value="<?php echo $grupo->id?>">
                                            <?php echo $grupo->Nombre;?>
                                            </option>
                                            <?php endif;?>
                                            <?php endforeach;?>?>
                                        </select>  
                                        </div>
                                </div>
                            </form>                                               
                            </div>
                    </div>                        
                         <div class="row">
                            <div class="col-md-12">     

                            <?php if(isset($unidades)):?>                            
                            <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_unidades_general">
                            <thead>
                                <tr>
                                    <th>Categoria</th>
                                    <th >Casitas</th>                                                                                                                                                                                
                                    <th>Matamoros</th>                                         
                                    <th>Oaxaca</th>                                
                                    <th>Poza Rica</th>
                                    <th>Reynosa I</th>
                                    <th>Reynosa II</th>
                                    <th>Teziutlán</th>
                                    <th>Totales</th>                                                                                                                                                                                                                                                                                                                                   
                                </tr>
                            </thead>
                            <tbody>    
                                <?php if(!empty($unidades)):?>  
                                <?php
                                $acCasitas=0;
                                $acMatamoros=0;
                                $acOaxaca=0;
                                $acPoza_Rica=0;
                                $acReynosa_I=0;
                                $acReynosa_II=0;
                                $acTeziutlan=0;
                                $acFila=0;
                                $fecha="";
                                
                                ?>                          
                                <?php foreach ($unidades as $unidad):?>
                                    <?php                                     
                                    $acCasitas+=$unidad->Casitas;                                    
                                    $acMatamoros+=$unidad->Matamoros;
                                    $acOaxaca+=$unidad->Oaxaca;
                                    $acPoza_Rica+=$unidad->Poza_Rica;
                                    $acReynosa_I+=$unidad->Reynosa_I;
                                    $acReynosa_II+=$unidad->Reynosa_II;
                                    $acTeziutlan+=$unidad->Teziutlan;
                                    $acFila=
                                    $unidad->Casitas+
                                    $unidad->Matamoros+
                                    $unidad->Oaxaca+
                                    $unidad->Poza_Rica+
                                    $unidad->Reynosa_I+
                                    $unidad->Reynosa_II+
                                    $unidad->Teziutlan;
                                    ?>
                                   <tr>
                                   <td><?=$unidad->Categoria;?></td>                                                                                                                                                                                                                                                                                                                                 
                                    <td bgcolor="#bae6ff"><?php 
                                    if($unidad->Casitas==null){
                                        echo 0;
                                    }else{
                                        echo $unidad->Casitas;
                                    }                                    
                                    ?></td>                                                                                                           
                                    <td bgcolor="#FA8072"><?php 
                                    if($unidad->Matamoros==null){
                                        echo 0;
                                    }else{
                                        echo $unidad->Matamoros;
                                    }                                    
                                    ?></td>
                                    <td bgcolor="#8cedbc"><?php 
                                    if($unidad->Oaxaca==null){
                                        echo 0;
                                    }else{
                                        echo $unidad->Oaxaca;
                                    }                                    
                                    ?></td>
                                    <td bgcolor="#ecccbb"><?php 
                                    if($unidad->Poza_Rica==null){
                                        echo 0;
                                    }else{
                                        echo $unidad->Poza_Rica;
                                    }                                    
                                    ?></td>
                                    
                                    <td bgcolor="#ffd682"><?php 
                                    if($unidad->Reynosa_I==null){
                                        echo 0;
                                    }else{
                                        echo $unidad->Reynosa_I;
                                    }                                    
                                    ?></td>
                                    
                                    <td bgcolor="#e7bbec"><?php 
                                    if($unidad->Reynosa_II==null){
                                        echo 0;
                                    }else{
                                        echo $unidad->Reynosa_II;
                                    }                                    
                                    ?></td>

                                    <td bgcolor="#c7d5d8"><?php 
                                    if($unidad->Teziutlan==null){
                                        echo 0;
                                    }else{
                                        echo $unidad->Teziutlan;
                                    }                                    
                                    ?></td>

                                    <td><?=$acFila;?></td>
                                </tr>   
                                <?php endforeach;?>  
                                    <tr>
                                        <td>Totales</td>
                                        <td> <?=number_format($acCasitas);?></td>
                                        <td> <?=number_format($acMatamoros);?></td>
                                        <td> <?=number_format($acOaxaca);?></td>
                                        <td> <?=number_format($acPoza_Rica);?></td>
                                        <td> <?=number_format($acReynosa_I);?></td>
                                        <td> <?=number_format($acReynosa_II);?></td> 
                                        <td> <?=number_format($acTeziutlan);?></td> 
                                        <td><?=$fechaConsulta?></td>
                                    </tr>
                                <?php endif;?> 
                               
                            </tbody>                            
                            </table>                            
                            <?php endif;?> 
                            
                            <?php if(isset($unidadesFP)):?> 
                            <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_unidadesFP">
                            <thead>
                                <tr>                                                                                                                                                                                                                
                                    <th>Producto</th>                                                                                                                                                                                
                                    <th >Casitas</th>                                                                                                                                                                                
                                    <th>Matamoros</th>                                         
                                    <th>Oaxaca</th>                                
                                    <th>Poza Rica</th>
                                    <th>Reynosa I</th>
                                    <th>Reynosa II</th>
                                    <th>Teziutlán</th>
                                    <th>Totales</th>                                    
                                </tr>
                            </thead>
                            <tbody> 
                                <?php if(!empty($unidadesFP)):?>
                                <?php
                                $acCasitas=0;
                                $acMatamoros=0;
                                $acOaxaca=0;
                                $acPoza_Rica=0;
                                $acReynosa_I=0;
                                $acReynosa_II=0;
								$acTeziutlan=0;
                                $acFila=0;
                                $fecha="";
                                ;
                                ?>  
                                <?php foreach ($unidadesFP as $unidad):?>
                                <?php  
                                    $acCasitas+=$unidad->Casitas;                                    
                                    $acMatamoros+=$unidad->Matamoros;
                                    $acOaxaca+=$unidad->Oaxaca;
                                    $acPoza_Rica+=$unidad->Poza_Rica;
                                    $acReynosa_I+=$unidad->Reynosa_I;
                                    $acReynosa_II+=$unidad->Reynosa_II;
									$acTeziutlan+=$unidad->Teziutlan;
                                    $acFila=
                                    $unidad->Casitas+
                                    $unidad->Matamoros+
                                    $unidad->Oaxaca+
                                    $unidad->Poza_Rica+
                                    $unidad->Reynosa_I+
                                    $unidad->Reynosa_II+
                                    $unidad->Teziutlan;
                                    ?>
                               

                                   <tr>                                   
                                    <td><?=$unidad->Producto;?></td>                                                                                                                                                                                                                         
                                    <td bgcolor="#bae6ff"><?php 
                                    if($unidad->Casitas==null){
                                        echo 0;
                                    }else{
                                        echo $unidad->Casitas;
                                    }                                    
                                    ?>
                                    </td>                                                                                                           
                                    <td bgcolor="#FA8072"><?php 
                                    if($unidad->Matamoros==null){
                                        echo 0;
                                    }else{
                                        echo $unidad->Matamoros;
                                    }                                    
                                    ?></td>                                                                                                           
                                    <td bgcolor="#8cedbc"><?php 
                                    if($unidad->Oaxaca==null){
                                        echo 0;
                                    }else{
                                        echo $unidad->Oaxaca;
                                    }                                    
                                    ?></td>                                                                                                           
                                    <td bgcolor="#ecccbb"><?php 
                                    if($unidad->Poza_Rica==null){
                                        echo 0;
                                    }else{
                                        echo $unidad->Poza_Rica;
                                    }                                    
                                    ?></td>                                                                                                           
                                    <td bgcolor="#ffd682"><?php 
                                    if($unidad->Reynosa_I==null){
                                        echo 0;
                                    }else{
                                        echo $unidad->Reynosa_I;
                                    }                                    
                                    ?></td>
                                    <td bgcolor="#e7bbec"><?php 
                                    if($unidad->Reynosa_II==null){
                                        echo 0;
                                    }else{
                                        echo $unidad->Reynosa_II;
                                    }                                    
                                    ?></td>
                                    <td bgcolor="#c7d5d8"><?php 
										if($unidad->Teziutlan==null){
											echo 0;
										}else{
											echo $unidad->Teziutlan;
										}                                    
                                    ?></td>
                                        <td><?=$acFila;?></td>
                                    
                                    </tr>   
                                    <?php endforeach;?>  
                                    <tr>
                                        <td>Totales</td>
                                        <td> <?=number_format($acCasitas);?></td>
                                        <td> <?=number_format($acMatamoros);?></td>
                                        <td> <?=number_format($acOaxaca);?></td>
                                        <td> <?=number_format($acPoza_Rica);?></td>
                                        <td> <?=number_format($acReynosa_I);?></td>
                                        <td> <?=number_format($acReynosa_II);?></td>
										<td> <?=number_format($acTeziutlan);?></td> 
                                        <td><?=$fechaConsulta?></td>
                                    </tr>
                                <?php endif;?>                                                                                                                                                                  
                            </tbody>                            
                            </table>                            
                            <?php endif;?>  
                            
                            <?php if(isset($unidadesFP2)):?> 
                            <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_unidadesFP">
                            <thead>
                                <tr>                                                                                                                                                                                                                
                                    <th>Plaza</th>                                                                                                                                                                                                                                                                                            
                                    <th>Producto</th>                                                                                                                                                                                                                                                   
                                    <th>Cantidad</th>
                                    <th>Familia</th>
                                    <th>Fecha</th>      
                                </tr>
                            </thead>
                            <tbody> 
                                <?php if(!empty($unidadesFP2)):?>
                                <?php foreach ($unidadesFP2 as $unidad):?>                                                               
                                   <tr> 
                                   <?php switch($unidad->plaza_id): 
                                    case 1: ?>
                                    <td bgcolor="#bae6ff"><?=$unidad->Plaza;?></td>
                                    <?php break; ?>

                                    <?php case 2: ?>
                                    <td bgcolor="#FA8072"><?=$unidad->Plaza;?></td>
                                    <?php break; ?>
                                    
                                    <?php case 3: ?>
                                    <td bgcolor="#8cedbc"><?=$unidad->Plaza;?></td>
                                    <?php break; ?>

                                    <?php case 4: ?>
                                    <td bgcolor="#ecccbb"><?=$unidad->Plaza;?></td>
                                    <?php break; ?>

                                    <?php case 5: ?>
                                    <td bgcolor="#ffd682"><?=$unidad->Plaza;?></td>
                                    <?php break; ?>

                                    <?php case 6: ?>
                                    <td bgcolor="#e7bbec"><?=$unidad->Plaza;?></td>
                                    <?php break; ?>
                                    <?php endswitch; ?>                                                                                       
                                                                            
                                    <td><?=$unidad->Producto;?></td>                                                                                                                                                                                                                         
                                    <td><?=$unidad->Total;?></td>  
                                    <td><?=$unidad->Familia;?></td>                                                                        
                                    <td><?=$fechaConsulta?></td>
                                    </tr>   
                                    <?php endforeach;?>                                   
                                <?php endif;?>                                                                                                                                                                  
                            </tbody>                            
                            </table>                            
                            <?php endif;?>   

                            

                             <?php if(isset($unidadesFPG)):?> 
                            <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_unidadesFP">
                            <thead>
                                <tr> 
                                    <th>Plaza</th>                                                                                                                                                                                                            
                                    <th>Producto</th>                                                                                                                                                                                
                                    <th >Cantidad</th>                                                                                                                                                                                
                                    <th>Familia</th>                                         
                                    <th>Fecha</th>                                                                                                                                            
                                </tr>
                            </thead>
                            <tbody> 
                                <?php if(!empty($unidadesFPG)):?>
                                <?php foreach ($unidadesFPG as $unidad):?>    
                                <tr>                 
                                    <td><?=$unidad->Plaza;?></td>                                                                                                                                                                                                                               
                                    <td><?=$unidad->Producto;?></td>                                                                                                                                                                                                                         
                                    <td><?=$unidad->Cantidad;?></td>                                                                                                           
                                    <td><?=$unidad->Familia;?></td>  
                                    <td><?=$unidad->Fecha;?></td>   
                                </tr>
                                    <?php endforeach;?> 
                                <?php endif;?>                                                                                                                                                                  
                            </tbody>                            
                            </table>                            
                            <?php endif;?>   
                            <!--///////////////////////////UNIDADES2//////////////////////////////////////////////////-->
                            <?php if(isset($unidades2)):?>                            
                            <table class="display responsive table table-bordered table-condensed  btn-hover nowrap" style="width:100%" id="tbl_unidades_general">
                            <thead>
                                <tr>
                                    <th>Categoria</th>                                                                            
                                    <th><?php echo $nombrePlaza?></th>      
                                    <th>Ver</th>                                                            
                                    <th>Totales</th>                                                                                                                                                                                                                                                                                                                                   
                                </tr>
                            </thead>
                            <tbody>    
                                <?php if(!empty($unidades2)):?>  
                                <?php                              
                                $acPlaza=0;                              
                                $acFila=0;
                                $fecha="";                                
                                ?>                          
                                <?php foreach ($unidades2 as $unidad):?>
                                    <?php 
                                                                      
                                    $acPlaza+=$unidad->Plaza;                                   
                                    $acFila=$unidad->Plaza;

                                    ?>
                                   <tr>
                                    <td><?=$unidad->Categoria;?></td>                                                                                                                                                                                                                                                                                                                                 
                                    <td bgcolor="#8cedbc"><?php 
                                    if($unidad->Plaza==null){
                                        echo 0;
                                    }else{
                                        echo $unidad->Plaza;
                                    }                                    
                                    ?></td>

                                    <td>                                    
                                        <button type="button" class="btn btn-info btn-view" onclick="verDesgloseFamilia('<?php echo $fechainicio;?>','<?php echo $fechafin;?>',<?php echo $unidad->plaza_id;?>,<?php echo $unidad->categoria_id;?>)" data-toggle="modal" data-target="#modalDesgloseFamilia" value="">
                                                <span class="fa fa-search"></span>
                                        </button>     
                                    </td>                                    
                                    
                                    <td>
                                    <?php 
                                    if($acFila==0){
                                        echo 0;
                                    }
                                    else{
                                        echo $acFila;
                                    }
                                    
                                    ;?>
                                    </td>
                                </tr>   
                                <?php endforeach;?>  
                                    <tr>
                                        <td>Totales</td>
                                        <td> <?=number_format($acPlaza);?></td>   
                                        <td></td>                                    
                                        <td><?=$fechaConsulta?></td>
                                    </tr>
                                <?php endif;?> 
                               
                            </tbody>                            
                            </table>                            
                            <?php endif;?>                                   
                            <!--///////////////////////////UNIDADES2//////////////////////////////////////////////////-->

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


<!--MODAL PARA VER EL DESGLOSE POR FAMILIA DE UNA PLAZA-->
    <div class="modal fade" id="modalDesgloseFamilia">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Desglose de Familia</h4>
        </div>
        <div class="modal-body">
            <div class="responsive-table">
                <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_prueba_API" >
                                <thead>                                    
                                    <tr>
                                        <th>Fecha</th>                                                                              
                                        <th>Plaza</th>                                                                                 
                                        <th>Familia</th>
                                        <th>Producto</th>  
                                        <th>Cantidad</th>  
                                        
                                                                                                                                                                                                                                       
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
<!--MODAL PARA VER EL DESGLOSE POR FAMILIA DE UNA PLAZA-->                      

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

    function verDesgloseFamilia(fechaInicio,fechaFin,plaza_id,categoria_id){        
        //alert(fechaInicio+"  "+fechaFin+"  "+plaza_id+" "+categoria_id);        
        
        var parametros = {
            "fechaInicio" : fechaInicio,
            "fechaFin" : fechaFin,        
            "categoria_id" : categoria_id,
            "plaza_id" : plaza_id
            };              

            $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>Unidades/consultarUnidadesFamilia",
            data: parametros,              
            dataType: "JSON",                                 
            success: function(response){  
                pruebaAPI.clear();                   
                var len = response.length;     
                var acUnidades=0;
                for(var i=0; i<len; i++){                   
                    var plaza=response[i].Plaza;
                    var producto=response[i].Producto;
                    var cantidad=response[i].Total;
                    var familia=response[i].Familia;                                        
                    var fecha = response[i].Fecha;   
                    acUnidades=parseFloat(acUnidades)+parseFloat(cantidad);                                                                                                                                                                                                     
                    pruebaAPI.row.add([fecha,plaza,familia,producto,cantidad]);                    
                }     
                pruebaAPI.row.add(["Totales","","","",acUnidades]);                                                            
                pruebaAPI.draw();                                                
            },
            error: function() { 
                alert("Error posting feed.");
            }
        });
    }
</script>

<?php if($busquedaPlaza==false):?>
<div class="modal fade" id="modal-default">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Análisis de Unidades</h4>
      </div>
      <div class="modal-body">
      <div class="row">
                    <div class="col-md-12">                        
                                <div class="row">
                                    
                                    <div class="col-md-12">                                        
                                        <div id="graficaPieCA">                                        
                                        </div>
                                    </div>

                                    <div class="col-md-12">                                        
                                        <div id="graficaPieMA">                                        
                                        </div>
                                    </div>

                                    <div class="col-md-12">                                        
                                        <div id="graficaPieOA">                                        
                                        </div>
                                    </div>

                                    <div class="col-md-12">                                        
                                        <div id="graficaPiePZ">                                        
                                        </div>
                                    </div>

                                    <div class="col-md-12">                                        
                                        <div id="graficaPieR1">                                        
                                        </div>
                                    </div>

                                    <div class="col-md-12">                                        
                                        <div id="graficaPieR2">                                        
                                        </div>
                                    </div>

                                    <div class="col-md-12">                                        
                                        <div id="graficaPieTZ">                                        
                                        </div>
                                    </div>

                                </div>                                
                                <!-- /.row -->                            
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
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




<script type="text/javascript">
    function crearCadenaPie(json){
        var parsed=JSON.parse(json);
        var arr=[];
        for(var x in parsed){
            arr.push(parsed[x]);
        }
        return arr;
    }
</script>



<!--CASITAS-->
    <script type="text/javascript">
    datosXCA=crearCadenaPie('<?php echo $datosXCA;?>');
    datosYCA=crearCadenaPie('<?php echo $datosYCA;?>');
    fechaInicioG='<?php echo $fechaInicioG;?>';
    fechaFinG='<?php echo $fechaFinG;?>';    

        var data = [{
            values: datosYCA,
            labels: datosXCA,    
            type: 'pie'
        }];

            var layout = {
                title: 'CASITAS del '+fechaInicioG+" al "+fechaFinG,
                height: 500,
                width: 800
                };
                
            Plotly.newPlot('graficaPieCA', data, layout);
    </script>
<!--CASITAS-->

<!--MATAMOROS-->
<script type="text/javascript">
    datosXMA=crearCadenaPie('<?php echo $datosXMA;?>');
    datosYMA=crearCadenaPie('<?php echo $datosYMA;?>');
    fechaInicioG='<?php echo $fechaInicioG;?>';
    fechaFinG='<?php echo $fechaFinG;?>';    


        
            var data = [{
            values: datosYMA,
            labels: datosXMA,    
            type: 'pie'
        }];

            var layout = {
                title: 'MATAMOROS del '+fechaInicioG+" al "+fechaFinG,
                height: 500,
                width: 800
                };        
            //alert(nombre);
            Plotly.newPlot('graficaPieMA', data, layout);
    </script>
<!--MATAMOROS-->

<!--OAXACA-->
<script type="text/javascript">
    datosXOA=crearCadenaPie('<?php echo $datosXOA;?>');
    datosYOA=crearCadenaPie('<?php echo $datosYOA;?>');
    fechaInicioG='<?php echo $fechaInicioG;?>';
    fechaFinG='<?php echo $fechaFinG;?>';    

        
            var data = [{
            values: datosYOA,
            labels: datosXOA,    
            type: 'pie'
        }];

            var layout = {
                title: 'OAXACA del '+fechaInicioG+" al "+fechaFinG,
                height: 500,
                width: 800
                };        
            //alert(nombre);
            Plotly.newPlot('graficaPieOA', data, layout);
    </script>
<!--OAXACA-->

<!--POZA RICA-->
<script type="text/javascript">
    datosXPZ=crearCadenaPie('<?php echo $datosXPZ;?>');
    datosYPZ=crearCadenaPie('<?php echo $datosYPZ;?>');
    fechaInicioG='<?php echo $fechaInicioG;?>';
    fechaFinG='<?php echo $fechaFinG;?>';    

        
            var data = [{
            values: datosYPZ,
            labels: datosXPZ,    
            type: 'pie'
        }];

            var layout = {
                title: 'POZA RICA del '+fechaInicioG+" al "+fechaFinG,
                height: 500,
                width: 800
                };        
            //alert(nombre);
            Plotly.newPlot('graficaPiePZ', data, layout);
    </script>
<!--POZA RICA-->


<!--REYNOSA I-->
<script type="text/javascript">
    datosXR1=crearCadenaPie('<?php echo $datosXR1;?>');
    datosYR1=crearCadenaPie('<?php echo $datosYR1;?>');
    fechaInicioG='<?php echo $fechaInicioG;?>';
    fechaFinG='<?php echo $fechaFinG;?>';    

        
            var data = [{
            values: datosYR1,
            labels: datosXR1,    
            type: 'pie'
        }];

            var layout = {
                title: 'REYNOSA I del '+fechaInicioG+" al "+fechaFinG,
                height: 500,
                width: 800
                };        
            //alert(nombre);
            Plotly.newPlot('graficaPieR1', data, layout);
    </script>
<!--REYNOSA I-->



<!--REYNOSA II-->
<script type="text/javascript">
    datosXR2=crearCadenaPie('<?php echo $datosXR2;?>');
    datosYR2=crearCadenaPie('<?php echo $datosYR2;?>');
    fechaInicioG='<?php echo $fechaInicioG;?>';
    fechaFinG='<?php echo $fechaFinG;?>';    

        
            var data = [{
            values: datosYR2,
            labels: datosXR2,    
            type: 'pie'
        }];

            var layout = {
                title: 'REYNOSA II del '+fechaInicioG+" al "+fechaFinG,
                height: 500,
                width: 800
                };        
            //alert(nombre);
            Plotly.newPlot('graficaPieR2', data, layout);
    </script>
<!--REYNOSA II-->





<?php elseif($busquedaPlaza==true):?>
<div class="modal fade" id="modal-default">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Análisis de Unidades</h4>
      </div>
      <div class="modal-body">
      <div class="row">
                    <div class="col-md-12">                        
                                <div class="row">
                                    <div class="col-md-12">                                        
                                        <div id="graficaPieGenerico">                                        
                                        </div>
                                </div>                        
                                <!-- /.row -->                        
                        </div>
                        <!-- /.box -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
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




<script type="text/javascript">
    function crearCadenaPie(json){
        var parsed=JSON.parse(json);
        var arr=[];
        for(var x in parsed){
            arr.push(parsed[x]);
        }
        return arr;
    }
</script>


<!--GENERICO-->
<script type="text/javascript">
    datosX=crearCadenaPie('<?php echo $datosX;?>');
    datosY=crearCadenaPie('<?php echo $datosY;?>');     
    fechaInicioG='<?php echo $fechaInicioG;?>';
    fechaFinG='<?php echo $fechaFinG;?>';    
    nombrePlaza='<?php echo $nombrePlaza;?>';    
            var data = [{
            values: datosY,
            labels: datosX,    
            type: 'pie'
        }];
            var layout = {
                title: nombrePlaza+" del "+fechaInicioG+" al "+fechaFinG,
                height:800,
                width: 800
                };        
            //alert(nombre);
            Plotly.newPlot('graficaPieGenerico', data, layout);
    </script>
<!--GENERICO-->

<?php endif;?>





