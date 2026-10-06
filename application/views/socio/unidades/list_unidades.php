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

                                    
                                </div>                
                                <div class="form-gropu">
                                    <label for="" class="col-md-1 control-label">Options:  </label>                           
                                        <div class="col-md-6">
                                            <input type="submit" name="buscar" value="Buscar" class="btn btn-primary">
                                            <input type="submit" name="buscarRango" value="Buscar Rango" class="btn btn-danger">                                
                                            
                                            <a href="<?php echo base_url(); ?>Unidades/indexPruebas" class="btn btn-success">Restablecer</a>
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
                        <hr>
                         <div class="row">
                            <div class="col-md-12">                            
                            <?php if(isset($unidades)):?>                            
                            <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_unidades_general">
                            <thead>
                                <tr>
                                    <th>Categoria</th>
                                                                            
                                    <th>Oaxaca</th>                                
                                  
                                    <th>Totales</th>                                                                                                                                                                                    
                                                                                                           
                                    
                                </tr>
                            </thead>
                            <tbody>    
                                <?php if(!empty($unidades)):?>  
                                <?php
                              
                                $acOaxaca=0;
                              

                                $acFila=0;
                                $fecha="";
                                
                                ?>                          
                                <?php foreach ($unidades as $unidad):?>
                                    <?php 
                                    
                                  
                                    $acOaxaca+=$unidad->Oaxaca;
                                   
                                    $acFila=$unidad->Oaxaca;

                                    ?>
                                   <tr>
                                    <td><?=$unidad->Categoria;?></td>                                                                                                                                                                                                                                                                                                                                 
                                    <td bgcolor="#8cedbc"><?php 
                                    if($unidad->Oaxaca==null){
                                        echo 0;
                                    }else{
                                        echo $unidad->Oaxaca;
                                    }                                    
                                    ?></td>

                                   

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
                                        <td> <?=number_format($acOaxaca);?></td>                                       
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
                                                                       
                                    <th>Oaxaca</th>                                
                                    
                                    <th>Totales</th>                                    
                                </tr>
                            </thead>
                            <tbody> 
                                <?php if(!empty($unidadesFP)):?>
                                <?php
                             
                                $acOaxaca=0;
                               
                                $acFila=0;
                                $fecha="";
                                ;
                                ?>  
                                <?php foreach ($unidadesFP as $unidad):?>
                                <?php  
                                  
                                    $acOaxaca+=$unidad->Oaxaca;
                              
                                    $acFila=
                                    $unidad->Oaxaca;
                                    ?>
                               

                                   <tr>                                   
                                    <td><?=$unidad->Producto;?></td>                                                                                                                                                                                                                         
                                                                                                                               
                                    <td bgcolor="#8cedbc"><?php 
                                    if($unidad->Oaxaca==null){
                                        echo 0;
                                    }else{
                                        echo $unidad->Oaxaca;
                                    }                                    
                                    ?></td>    

                                   
                                        <td><?=$acFila;?></td>
                                    
                                    </tr>   
                                    <?php endforeach;?>  
                                    <tr>
                                        <td>Totales</td>
                                        <td> <?=number_format($acOaxaca);?></td>
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
                                                                                                                       
                                    <td><?=$unidad->Plaza;?></td>                                                                                                                                                                                                                                                                 
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


    <script type="text/javascript">      
    //#region AL CAMBIAR EL GRUPO DE GASTOS SE ACTUALIZAN LOS INSUMOS DE CADA GRUPO
    $('#grupo_id').change(function(){
            
            $('#unidad_id').html('<option value="">Unidad</option>');                
            var grupo_id = $('#grupo_id').val();       

            if(grupo_id != ''){
                $.ajax({
                    url:"<?php echo base_url(); ?>Remesas/consultarInsumo",
                    method:"POST",
                    data:{grupo_id:grupo_id},
                    success:function(data)
                    {
                    $('#insumo_gasto_id').html(data);                                          
                    }
                });
            }
            else{
            //$('#grupo_id').html('<option value="">Seleccionar Grupo</option>');
            $('#insumo_gasto_id').html('<option value="">Seleccionar Insumo</option>');
            }
            
        });
    //#endregion    
    </script>
