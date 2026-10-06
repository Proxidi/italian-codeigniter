<!-- =============================================== -->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
            Análisis de Remesas
            <small>Listado</small>
            </h1>
            <a href="<?php echo base_url(); ?>Remesas" class="small-box-footer">Volver al Panel de Administración <i class="fa fa-arrow-circle-right"></i></a>
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
                                
                                <!--INPUTS DATE PARA LAS BUSQUEDAS-->
                                    <label for="" class="col-md-1 control-label">Desde:</label>
                                        <div class="col-md-2">
                                            <input type="date" class="form-control" name="fechaInicioD" id="fechaInicioD" value="<?php echo !empty($fechainicio) ? $fechainicio:'';?>" required>
                                        </div>

                                    <label for="" class="col-md-1 control-label">Hasta:</label>
                                        <div class="col-md-2">
                                            <input type="date" class="form-control" name="fechaFinD" id="fechaFinD" value="<?php  echo !empty($fechafin) ? $fechafin:'';?>">
                                        </div>
                                <!--INPUTS DATE PARA LAS BUSQUEDAS-->

                                <!--SELECTS PLAZAS,FAMILIAS-->
                                    <label for="plaza_id" class="col-md-1 control-label">Plaza:</label>
                                        <div class="col-md-2">
                                            <select name="plaza_id" id="plaza_id" class="form-control">                                                  
                                            <?php foreach ($plazas as $plaza):?>  
                                            <?php if($plaza->id==1):?>
                                            <option value="" selected>
                                                Todas las Plazas
                                            </option>
                                            <?php endif;?>
                                            <?php if($plaza->id==$id_plaza):?>
                                            <option value="<?php echo $plaza->id?>" selected>
                                            <?php echo $plaza->Nombre;?>
                                            </option>
                                            <?php else:?>
                                            <option value="<?php echo $plaza->id?>">
                                            <?php echo $plaza->Nombre;?>
                                            </option>
                                            <?php endif;?>
                                            <?php endforeach;?>
                                            </select>                                    
                                            <input type="hidden" name="hidden_country" id="hidden_country" />
                                        </div>             

                                    <label for="grupo_remesa_id" class="col-md-1 control-label">Familias:  </label>                           
                                        <div class="col-md-2">
                                            <select name="grupo_remesa_id" id="grupo_remesa_id" class="form-control">                                                  
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
                                            <?php endforeach;?>
                                            </select>  
                                        </div>
                                <!--SELECTS PLAZAS,FAMILIAS-->         

                                </div>        

                                <div class="form-group">

                                <!--SELECTS INSUMOS,GRAFICOS-->                                                                                                         
                                    <label for="grupo_id" class="col-md-1 control-label">Insumos:  </label>                           
                                        <div class="col-md-2">
                                        <select name="insumo_gasto_remesa_id" id="insumo_gasto_remesa_id" class="form-control" >
                                            <option value="">Seleccionar Insumo</option>  
                                            <?php if(isset($insumos)):?> 
                                                <?php foreach ($insumos as $insumo):?>  
                                                    <?php if($insumo->id==$id_insumo):?>                                                    
                                                        <option value="<?php echo $insumo->id?>" selected>
                                                            <?php echo $insumo->Nombre;?>
                                                        </option>                                                    
                                                        <?php else:?>
                                                            <option value="<?php echo $insumo->id?>">
                                                        <?php echo $insumo->Nombre;?>
                                                        </option>
                                                    <?php endif;?>
                                                <?php endforeach;?>
                                            <?php endif;?>  
                                        </select> 
                                        </div>

                                    <label for="grafico_id" class="col-md-1 control-label">Gráfico:</label>                            
                                        <div class="col-md-2">
                                            <select name="grafico_id" id="grafico_id" class="form-control">                                                  
                                                <?php foreach ($tipos as $tipo):?>  
                                                    <?php if($tipo->id==7):?>
                                                            <option value="" selected>
                                                                Tipo de Gráfico
                                                            </option>
                                                        <?php endif;?>
                                                        <?php if($tipo->id==$id_grafico):?>
                                                            <option value="<?php echo $tipo->id?>" selected>
                                                                <?php echo $tipo->Nombre;?>
                                                            </option>
                                                        <?php else:?>
                                                            <option value="<?php echo $tipo->id?>">
                                                                <?php echo $tipo->Nombre;?>
                                                            </option>
                                                    <?php endif;?>
                                                <?php endforeach;?>
                                            </select>                                                                        
                                        </div>              
                                <!--SELECTS INSUMOS,GRAFICOS-->          

                                <!--BOTONES DE BUSQUEDA-->
                                    <div class="col-md-6">                                        
                                        <input type="submit" name="buscar" value="Buscar" class="btn btn-primary">
                                        <input type="submit" name="buscarRango" value="B. Rango" class="btn btn-danger">
                                        <button type='button' class="btn btn-success btn-flag" data-toggle="modal" data-target="#modalGraficoPastel"><span class="fa fa-search" ></span> Pastel</button>                                                                                                                        
                                        <button type='button' class="btn btn-success btn-flag" data-toggle="modal" data-target="#modalGraficoBarras"><span class="fa fa-search" ></span> Barras</button>                                                                                                                        
                                        <button type='button' class="btn btn-success btn-flag" data-toggle="modal" data-target="#modalGraficoLineas"><span class="fa fa-search" ></span> Lineas</button>                                                                                                                       

                                    </div>
                                <!--BOTONES DE BUSQUEDA-->

                                </div>
                            </form>                                               
                            </div>
                    </div>

                         <div class="row">
                            <div class="col-md-12">   


                        <!--UNIDADES-->
                        <!--ANÁLISIS DE TODAS LAS PLAZAS CON TODAS LAS OPCIONES EN BLANCO-->                         
                            <?php if(isset($unidades)):?>                            
                                <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_analisis_remesas">
                                <thead>
                                    <tr>
                                        <th>Categoria</th>
                                        <th >CA</th>  
                                        <th>%</th>                                                                                                                                                                              
                                        <th>MA</th>
                                        <th>%</th>                                         
                                        <th>OA</th> 
                                        <th>%</th>                               
                                        <th>PZ</th>
                                        <th>%</th>
                                        <th>RI</th>
                                        <th>%</th>
                                        <th>RII</th>
                                        <th>%</th>
                                        <th>TZ</th>
                                        <th>%</th>
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

                                    $acPCasitas=0;
                                    $acPMatamoros=0;
                                    $acPOaxaca=0;
                                    $acPPoza_Rica=0;
                                    $acPReynosa_I=0;
                                    $acPReynosa_II=0;
                                    $acPTeziutlan=0;

                                    $acFila=0;
                                    $fecha="";
                                    $vtCasitas=0;
                                    $vtMatamoros=0;
                                    $vtOaxaca=0;
                                    $vtPozaRica=0;
                                    $vtReynosaI=0;
                                    $vtReynosaII=0;
                                    $vtTeziutlan=0;
                                    
                                    ?>

                                    <?php foreach ($ventas as $venta):?>
                                    <?php switch($venta->plaza_id): 
                                            
                                        case 1: 
                                            $vtCasitas=$venta->Total_Ingresos;
                                        break;
                                        case 2:
                                            $vtMatamoros=$venta->Total_Ingresos;
                                        break;                                        
                                        case 3:
                                            $vtOaxaca=$venta->Total_Ingresos;                                        
                                        break;                                        
                                        case 4:
                                            $vtPozaRica=$venta->Total_Ingresos;                                        
                                        break;
                                        case 5:
                                            $vtReynosaI=$venta->Total_Ingresos;
                                        break;
                                        case 6:
                                            $vtReynosaII=$venta->Total_Ingresos;
                                        break;
                                        case 7:
                                            $vtTeziutlan=$venta->Total_Ingresos;
                                        break;
                                        
                                        ?>
                                        <?php endswitch; ?>     
                                    <?php endforeach;?> 


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
                                            $unidad->Teziutlan
                                            ;
                                        ?>
                            
                                    <tr>
                                    <td><?=$unidad->Categoria;?></td>                                                                                                                                                                                                                                                                                                                                 
                                    <td bgcolor="#bae6ff">
                                            <?php 
                                            if($unidad->Casitas==null){
                                                echo "$ ".number_format(0);
                                            }else{
                                                echo "$ ".number_format($unidad->Casitas);
                                            }                                    
                                            ?>
                                        </td>  
                                        
                                        <td>
                                        <?php 
                                            if($vtCasitas==0){
                                                $porcentaje=0;
                                            } else{
                                                $porcentaje=round($unidad->Casitas*100/$vtCasitas,2);                                                                        
                                            }
                                            echo $porcentaje;
                                        
                                        ?>% 
                                        <?php $acPCasitas+=$porcentaje?>                                   
                                        </td> 

                                        <td bgcolor="#FA8072">
                                            <?php 
                                            if($unidad->Matamoros==null){
                                                echo "$ ".number_format(0);
                                            }else{
                                                echo "$ ".number_format($unidad->Matamoros);
                                            }                                    
                                            ?>
                                        </td>

                                        <td>
                                        <?php 
                                        if($vtMatamoros==0){
                                            $porcentaje=0;
                                        } else{
                                            $porcentaje=round($unidad->Matamoros*100/$vtMatamoros,2);                                                                        
                                        }
                                        echo $porcentaje;                                                                                                           
                                        ?>%     
                                        <?php $acPMatamoros+=$porcentaje?>                               
                                        </td> 

                                        <td bgcolor="#8cedbc">
                                            <?php 
                                            if($unidad->Oaxaca==null){
                                                echo "$ ".number_format(0);
                                            }else{
                                                echo "$ ".number_format($unidad->Oaxaca);
                                            }                                    
                                            ?>
                                        </td>

                                        <td>
                                        <?php 
                                            if($vtOaxaca==0){
                                                $porcentaje=0;
                                            } else{
                                                $porcentaje=round($unidad->Oaxaca*100/$vtOaxaca,2);                                                                        
                                            }
                                            echo $porcentaje; 
                                        ?>
                                        %        
                                        <?php $acPOaxaca+=$porcentaje?>                             
                                        </td> 

                                        <td bgcolor="#ecccbb">
                                            <?php 
                                            if($unidad->Poza_Rica==null){
                                                echo "$ ".number_format(0);
                                            }else{
                                                echo "$ ".number_format($unidad->Poza_Rica);
                                            }                                    
                                            ?>
                                        </td>

                                        <td>
                                        <?php 
                                            if($vtPozaRica==0){
                                                $porcentaje=0;
                                            } else{
                                                $porcentaje=round($unidad->Poza_Rica*100/$vtPozaRica,2);                                                                        
                                            }
                                        echo $porcentaje;                                                                  
                                        
                                        ?>%  
                                        <?php $acPPoza_Rica+=$porcentaje?>                                   
                                        </td> 

                                        <td bgcolor="#ffd682">
                                            <?php 
                                            if($unidad->Reynosa_I==null){
                                                echo "$ ".number_format(0);
                                            }else{
                                                echo "$ ".number_format($unidad->Reynosa_I);
                                            }                                    
                                            ?>
                                        </td>

                                        <td>
                                        <?php 
                                        if($vtReynosaI==0){
                                            $porcentaje=0;
                                        } else{
                                            $porcentaje=round($unidad->Reynosa_I*100/$vtReynosaI,2);                                                                        
                                        }          
                                        echo $porcentaje;                                                                                                                                                                          
                                        ?>%    
                                        <?php $acPReynosa_I+=$porcentaje?>                                 
                                        
                                        </td>      


                                        <td bgcolor="#e7bbec">
                                            <?php 
                                            if($unidad->Reynosa_II==null){
                                                echo "$ ".number_format(0);
                                            }else{
                                                echo "$ ".number_format($unidad->Reynosa_II);
                                            }                                    
                                            ?>
                                        </td>

                                        <td>
                                        <?php 
                                        if($vtReynosaII==0){
                                            $porcentaje=0;
                                        } else{
                                            $porcentaje=round($unidad->Reynosa_II*100/$vtReynosaII,2);                                                                        
                                        }  
                                        echo $porcentaje;
                                        
                                        ?>%     
                                        <?php $acPReynosa_II+=$porcentaje?>                                
                                        </td>                                   
                                    
                                        <td bgcolor="#r7bbec">
                                            <?php 
                                            if($unidad->Teziutlan==null){
                                                echo "$ ".number_format(0);
                                            }else{
                                                echo "$ ".number_format($unidad->Teziutlan);
                                            }                                    
                                            ?>
                                        </td>

                                        <td>
                                        <?php 
                                        if($vtTeziutlan==0){
                                            $porcentaje=0;
                                        } else{
                                            $porcentaje=round($unidad->Teziutlan*100/$vtTeziutlan,2);                                                                        
                                        }  
                                        echo $porcentaje;                                    
                                        ?>%     
                                        <?php $acPTeziutlan+=$porcentaje?>                                
                                        </td> 
                                    

                                        <td>
                                            <?="$ ".number_format($acFila);?>
                                        </td>

                                    </tr>   
                                    <?php endforeach;?>  
                                    
                                    <tr class="sorting_disabled">
                                            <td>Totales</td>
                                            <td>$ <?=number_format($acCasitas);?></td>
                                            <td> <?=$acPCasitas;?>%</td>
                                            <td>$ <?=number_format($acMatamoros);?></td>
                                            <td> <?=$acPMatamoros;?>%</td>
                                            <td>$ <?=number_format($acOaxaca);?></td>
                                            <td> <?=$acPOaxaca;?>%</td>
                                            <td>$ <?=number_format($acPoza_Rica);?></td>
                                            <td> <?=$acPPoza_Rica;?>%</td>
                                            <td>$ <?=number_format($acReynosa_I);?></td>
                                            <td> <?=$acPReynosa_I;?>%</td>
                                            <td>$ <?=number_format($acReynosa_II);?></td> 
                                            <td> <?=$acPReynosa_II;?>%</td> 
                                            <td>$ <?=number_format($acTeziutlan);?></td>
                                            <td><?=$acPTeziutlan;?>%</td>
                                            <td><?=$fechaConsulta?></td>
                                        </tr>
                                                                                                                                                                                                              
                                    <?php endif;?> 
                                
                                </tbody>                            
                                </table>                            
                            <?php endif;?>  
                        <!--ANÁLISIS DE TODAS LAS PLAZAS CON TODAS LAS OPCIONES EN BLANCO-->   

                        <!--ANÁLISIS DE UNA SOLA PLAZA CON TODAS LAS OPCIONES EN BLANCO-->                                          
                             <?php if(isset($unidadesP)):?>                            
                                <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_analisis_remesas">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Plaza</th>
                                        <th>Categoria</th>   
                                        <th>Piezas</th>
                                        <th>Importe</th>                                                                                                        
                                        <th>Porcentaje</th>
                                        <th>Detalles</th>                                                                                                                                                                                                                                                                                                                                                                     
                                    </tr>
                                </thead>
                                <tbody>    
                                    <?php if(!empty($unidadesP)):?>  
                                    <?php
                                    $acCasitas=0;                                
                                    $acPCasitas=0; 
                                    $acPiezas=0; 
                                    $acFila=0;                                
                                    $fecha="";
                                    $vtCasitas=0;     
                                    $vtPlaza=0;   
                                    ;
                                    ?>

                                    <?php foreach ($ventas as $venta):?>
                                    <?php switch($venta->plaza_id):                                         
                                        case 1: 
                                            $vtPlaza=$venta->Total_Ingresos;
                                        break;
                                        case 2:
                                            $vtPlaza=$venta->Total_Ingresos;
                                        break;                                        
                                        case 3:
                                            $vtPlaza=$venta->Total_Ingresos;                                        
                                        break;                                        
                                        case 4:
                                            $vtPlaza=$venta->Total_Ingresos;                                        
                                        break;
                                        case 5:
                                            $vtPlaza=$venta->Total_Ingresos;
                                        break;
                                        case 6:
                                            $vtPlaza=$venta->Total_Ingresos;
                                        break; 
                                        case 7:
                                        $vtPlaza=$venta->Total_Ingresos;
                                        break; 
                                        
                                        ?>
                                    <?php endswitch; ?>     
                                    <?php endforeach;?> 


                                    <?php foreach ($unidadesP as $unidad):?>
                                        <?php 
                                            $acCasitas+=$unidad->Plaza;                                                         
                                            $acFila=$unidad->Plaza;
                                            $acPiezas+=$unidad->Piezas;
                                        ?>                            
                                    <tr>
                                    <td><?=$fechaConsulta?></td>
                                    <td><?=$nombrePlaza?></td>
                                    <td><?=$unidad->Categoria;?></td>   
                                    <td><?=round($unidad->Piezas,2);?></td>                                                                                                                                                                                                                                                                                                                              
                                    <td bgcolor="#bae6ff">
                                            <?php 
                                            if($unidad->Plaza==null){
                                                echo "$ ".number_format(0);
                                            }else{
                                                echo "$ ".number_format($unidad->Plaza);
                                            }                                    
                                            ?>
                                        </td>  
                                        
                                        <td>
                                        <?php 
                                            if($vtPlaza==0){
                                                $porcentaje=0;
                                            } else{
                                                $porcentaje=round($unidad->Plaza*100/$vtPlaza,2);                                                                        
                                            }
                                            echo $porcentaje;
                                        
                                        ?>% 
                                        <?php $acPCasitas+=$porcentaje?>                                   
                                        </td> 

                                        <td>
                                            <button type="button" class="btn btn-info btn-view" onclick="consultarGastosFamilia('<?php echo $fechainicio;?>','<?php echo $fechafin;?>',<?php echo $id_plaza;?>,<?php echo $unidad->familia_id;?>)" data-toggle="modal" data-target="#modal-default" value="">
                                                    <span class="fa fa-search"></span>
                                            </button> 
                                        </td>

                                    </tr>   
                                    <?php endforeach;?>                                      
                                    <tr>
                                            <td>Totales</td>
                                            <td></td>
                                            <td></td>
                                            <td><?=round($acPiezas,2);?></td>
                                            <td>$ <?=number_format($acCasitas);?></td>
                                            <td> <?=$acPCasitas;?>%</td>                                                                                        
                                            <td></td>
                                        </tr>
                                                                                                                                                                                                               
                                    <?php endif;?> 
                                
                                </tbody>                            
                                </table>                            
                             <?php endif;?>  
                        <!--ANÁLISIS DE UNA SOLA PLAZA CON TODAS LAS OPCIONES EN BLANCO-->                       

                        <!--remesasFP-->               
                        <!--BUSQUEDA EN RANGO O NORMAL CON PLAZA O TODAS DE UNA FAMILIA DE LA REMESAS SIN INSUMO-->
                            <?php if(isset($remesasFP)):?> 
                            <?php
                                $acImporte=0;
                                $acPiezas=0;                              
                            ?>
                                <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_analisis_remesas">
                                <thead>
                                    <tr>
                                        <th>Plaza2</th>                                      
                                        <th>Grupo</th>  
                                        <th>Piezas</th>
                                        <th>Precio Unitario</th>                                                                                                                                                                                  
                                        <th>Importe</th>                                                                                                                                                                                                                      
                                        <th>Detalles</th>  
                                        <th>Fecha</th>                             
                                    </tr>
                                </thead>
                                <tbody> 
                                <?php if(!empty($remesasFP)):?>
                                <?php foreach ($remesasFP as $unidad):?>
                                <?php 
                                    $acImporte+=round($unidad->Importe);
                                    $acPiezas+=round($unidad->Piezas,2);
                                ?>
                                    <tr>

                                    <?php switch($unidad->plaza_id): 
                                        case 1: ?>
                                        <td bgcolor="#bae6ff"><?=$unidad->Plaza;?></td>
                                        <?php break; ?>

                                        <?php case 2:  ?>
                                        <td bgcolor="#bae6ff"><?=$unidad->Plaza;?></td>
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

                                        <?php case 7: ?>
                                        <td bgcolor="#r7bbec"><?=$unidad->Plaza;?></td>
                                        <?php break; ?>


                                        <?php endswitch; ?>                                     
                                        <td><?=$unidad->Grupo;?></td>
                                        <td><?=round($unidad->Piezas,2);?></td>                                                                                                                                                                                                                                                                                                                                                                       
                                        <td>$<?=round($unidad->Importe/$unidad->Piezas,2);?></td>
                                        <td>$<?=number_format($unidad->Importe);?></td>      
                                        <td>
                                            <button type="button" class="btn btn-info btn-view" onclick="consultarGastosFamilia('<?php echo $fechainicio;?>','<?php echo $fechafin;?>',<?php echo $unidad->plaza_id;?>,<?php echo $id_familia;?>)" data-toggle="modal" data-target="#modal-default" value="">
                                                <span class="fa fa-search"></span>
                                            </button> 
                                        </td>                                    
                                        <td><?=$fechaConsulta?></td>
                                    </tr>   
                                    <?php endforeach;?> 
                                    <tr>
                                        <td>Totales</td>
                                        <td></td>
                                        <td><?=round($acPiezas,2);?></td>
                                        <td>$<?=round(($acImporte/$acPiezas),2);?></td>                                        
                                        <td>$<?=number_format($acImporte);?></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                <?php endif;?>                                                                                                                                                                  
                                </tbody>                            
                                </table>                            
                            <?php endif;?> 
                        <!--BUSQUEDA EN RANGO O NORMAL CON PLAZA O TODAS DE UNA FAMILIA DE LA REMESAS SIN INSUMO-->                

                        <!--REMESASFP2-->
                        <!--BUSQUEDA EN RANGO O NORMAL CON PLAZA O TODAS DE UNA FAMILIA DE LA REMESAS CON INSUMO-->                                
                            <?php if(isset($remesasFP2)):?> 
                            <?php
                                $acImporte=0;
                                $acPiezas=0;
                            ?>
                                <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_analisis_remesas">
                                <thead>
                                    <tr>
                                        <th>Plaza</th>                                      
                                        <th>Grupo</th>  
                                        <th>Piezas</th>
                                        <th>Precio Unitario</th>                                                                                                                                                                                     
                                        <th>Importe</th>                                                                                                                                                                                                                                                             
                                        <th>Fecha</th>      
                                        <th>Detalles</th>                       
                                    </tr>
                                </thead>
                                <tbody> 
                                <?php if(!empty($remesasFP2)):?>
                                <?php foreach ($remesasFP2 as $unidad):?>
                                <?php 
                                    $acImporte+=round($unidad->Importe);
                                    $acPiezas+=round($unidad->Piezas,2);                                                                       
                                ?>
                                    <tr>
                                    <?php switch($unidad->plaza_id): 
                                        case 1:  ?>
                                        <td bgcolor="#bae6ff"><?=$unidad->Plaza;?></td>
                                        
                                        <?php break; ?>

                                        <?php case 2:?>
                                        <td bgcolor="#bae6ff"><?=$unidad->Plaza;?></td>
                                        <?php break; ?>
                                        
                                        <?php case 3:?>
                                        <td bgcolor="#8cedbc"><?=$unidad->Plaza;?></td>
                                        <?php break; ?>

                                        <?php case 4:?>
                                        <td bgcolor="#ecccbb"><?=$unidad->Plaza;?></td>
                                        <?php break; ?>

                                        <?php case 5:?>
                                        <td bgcolor="#ffd682"><?=$unidad->Plaza;?></td>
                                        <?php break; ?>

                                        <?php case 6:?>
                                        <td bgcolor="#e7bbec"><?=$unidad->Plaza;?></td>
                                        <?php break; ?>

                                        <?php case 7:?>
                                        <td bgcolor="#r7bbec"><?=$unidad->Plaza;?></td>
                                        <?php break; ?>

                                        <?php endswitch; ?>                                     
                                        <td><?=$unidad->Grupo;?></td>
                                        <td><?=round($unidad->Piezas,2);?></td>                                                                                                                                                                                                                                                                                                                                                                        
                                        <td>$<?=round($unidad->Importe/$unidad->Piezas,2);?></td>                                                                        
                                        <td>$<?=number_format($unidad->Importe);?></td>     
                                        <td><?=$fechaConsulta?></td>
                                        <td>
                                            <button type="button" class="btn btn-info btn-view" onclick="verDesgloseGastosFamiliaRango('<?php echo $fechainicio;?>','<?php echo $fechafin;?>',<?php echo $id_familia;?>,<?php echo $unidad->plaza_id;?>,<?php echo $unidad->insumo_id;?>)" data-toggle="modal" data-target="#verDesgloseGastos" value="">
                                                <span class="fa fa-search"></span>
                                            </button> 
                                        </td>   
                                    </tr>   
                                    <?php endforeach;?> 
                                    <tr>
                                        <td>Totales</td>
                                        <td></td>
                                        <td><?=round($acPiezas,2);?></td>
                                        <td>$<?=round(($acImporte/$acPiezas),2);?></td>                                        
                                        <td>$ <?=number_format($acImporte);?></td>
                                        <td></td>      
                                        <td></td>                                  
                                    </tr>
                                <?php endif;?>                                                                                                                                                                  
                                </tbody>                            
                                </table>                            
                            <?php endif;?>                             
                        <!--BUSQUEDA EN RANGO O NORMAL CON PLAZA O TODAS DE UNA FAMILIA DE LA REMESAS CON INSUMO-->                                    


                                                
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


<!--MODAL VER LOS GASTOS-DESGLOSES POR FAMILIA-->
    <div class="modal fade" id="modal-default">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Desglose de gastos por familia</h4>
        </div>
        <div class="modal-body">
            <div class="responsive-table">
                <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_consulta_gastos_familia" >
                                <thead>
                                    <tr>                                                                                                                                                         
                                        <th>Plaza</th>                                                                                 
                                        <th>Gasto</th>  
                                        <th>Cantidad</th>  
                                        <th>Unidad</th>
                                        <th>Importe</th>
                                        <th>P. Unitario</th>   
                                        <th>Ver</th>                                                                                                            
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
<!--MODAL VER LOS GASTOS-DESGLOSES POR FAMILIA-->


<!--MODAL VER LOS GASTOS-DESGLOSES POR FAMILIA-->
<div class="modal fade" id="verDesgloseGastos">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Desglose de gastos</h4>
        </div>
        <div class="modal-body">
            <div class="responsive-table">
                <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_consulta_gastos_familia_2" >
                                <thead>
                                    <tr>    
                                        <th>Fecha</th>
                                        <th>Usuario</th>                                                                                                                                                     
                                        <th>Plaza</th>                                                                                 
                                        <th>Gasto</th>  
                                        <th>Cantidad</th>  
                                        <th>Unidad</th>
                                        <th>Importe</th>
                                        <th>P. Unitario</th>                                           
                                        <th>Notas</th>
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
<!--MODAL VER LOS GASTOS-DESGLOSES POR FAMILIA-->






































<!--FUNCIÓN PARA REALIZAR LA CONVERSIÓN A JSON-->
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
<!--FUNCIÓN PARA REALIZAR LA CONVERSIÓN A JSON-->


<?php if($busquedaPlaza==false):?>
    <!--//////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
<!--GRAFICOS DE TODAS LAS PLAZAS-->
    <!--//////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
    
    <!--MODAL GRAFICO PASTEL GRUPALES-->
        <div class="modal fade" id="modalGraficoPastel">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Análisis de la Remesa</h4>
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
    <!--MODAL GRAFICO PASTEL GRUPALES-->

    <!--MODAL GRAFICO BARRAS GRUPALES-->
        <div class="modal fade" id="modalGraficoBarras">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Análisis de la Remesa</h4>
            </div>
            <div class="modal-body">
            <div class="row">
                            <div class="col-md-12">                        
                                <div class="row">                                                                                                                            
                                
                                    <div class="col-md-12">                                        
                                        <div id="graficaBarrasCA">                                        
                                        </div>
                                    </div>

                                    <div class="col-md-12">                                        
                                        <div id="graficaBarrasMA">                                        
                                        </div>
                                    </div>

                                    <div class="col-md-12">                                        
                                        <div id="graficaBarrasOA">                                        
                                        </div>
                                    </div>

                                    <div class="col-md-12">                                        
                                        <div id="graficaBarrasPZ">                                        
                                        </div>
                                    </div>

                                    <div class="col-md-12">                                        
                                        <div id="graficaBarrasR1">                                        
                                        </div>
                                    </div>

                                    <div class="col-md-12">                                        
                                        <div id="graficaBarrasR2">                                        
                                        </div>
                                    </div>

                                    <div class="col-md-12">                                        
                                        <div id="graficaBarrasTZ">                                        
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
    <!--MODAL GRAFICO BARRAS GRUPALES-->

    <!--MODAL GRAFICO LINEAS-->
        <div class="modal fade" id="modalGraficoLineas">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Análisis de Ventas</h4>
            </div>
            <div class="modal-body">
            <div class="row">
                            <div class="col-md-12">                        
                                <div class="row">                                    
                            
                            
                                        <div id="graficaLineas">                                        
                                            
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
    <!--MODAL GRAFICO LINEAS-->

    <!--GRAFICOS PASTEL GRUPALES-->        
        <!--CASITAS-->
            <script type="text/javascript">
                datosXCA=crearCadenaPie('<?php echo $datosXCA;?>');
                datosYCA=crearCadenaPie('<?php echo $datosYCA;?>');
                fechaInicioG='<?php echo $fechaInicioG;?>';
                fechaFinG='<?php echo $fechaFinG;?>';    
                insumo='<?php echo $nombreInsumo;?>';
                acronimoCampo='<?php echo $acronimoCampo;?>';
                        
                var data = [{
                    values: datosYCA,
                    labels: datosXCA,    
                    type: 'pie',
                    text: datosYCA.map(String)
                }];

                    var layout = {
                            title: acronimoCampo+" "+insumo+' CASITAS del '+fechaInicioG+" al "+fechaFinG,
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
                        
                var data = [{
                    values: datosYMA,
                    labels: datosXMA,    
                    type: 'pie',
                    text: datosYMA.map(String)
                }];

                        var layout = {
                            title: acronimoCampo+" "+insumo+' MATAMOROS del '+fechaInicioG+" al "+fechaFinG,
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
                        
                var data = [{
                    values: datosYOA,
                    labels: datosXOA,    
                    type: 'pie',
                    text: datosYOA.map(String)
                }];

                        var layout = {
                            title: acronimoCampo+" "+insumo+' OAXACA del '+fechaInicioG+" al "+fechaFinG,
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
                    
                var data = [{
                        values: datosYPZ,
                        labels: datosXPZ,    
                        type: 'pie',
                        text: datosYPZ.map(String)
                    }];

                        var layout = {
                            title: acronimoCampo+" "+insumo+' POZA RICA del '+fechaInicioG+" al "+fechaFinG,
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
                        
                var data = [{
                        values: datosYR1,
                        labels: datosXR1,    
                        type: 'pie',
                        text: datosYR1.map(String)
                    }];

                        var layout = {
                            title: acronimoCampo+" "+insumo+' REYNOSA I del '+fechaInicioG+" al "+fechaFinG,
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
                
                    
                    var data = [{
                    values: datosYR2,
                    labels: datosXR2,    
                    type: 'pie',
                    text: datosYR2.map(String)
                }];

                var layout = {
                    title:acronimoCampo+" "+insumo+' REYNOSA II del '+fechaInicioG+" al "+fechaFinG,
                    height: 500,
                    width: 800
                    };        
                //alert(nombre);
                Plotly.newPlot('graficaPieR2', data, layout);
            </script>
        <!--REYNOSA II-->

        <!--TEZIUTLAN-->
            <script type="text/javascript">
                datosXTZ=crearCadenaPie('<?php echo $datosXTZ;?>');
                datosYTZ=crearCadenaPie('<?php echo $datosYTZ;?>');
                    
                var data = [{
                    values: datosYTZ,
                    labels: datosXTZ,    
                    type: 'pie',
                    text: datosYTZ.map(String)
                }];

                    var layout = {
                        title: acronimoCampo+" "+insumo+' TEZIUTLAN del '+fechaInicioG+" al "+fechaFinG,
                        height: 500,
                        width: 800
                        };        
                    //alert(nombre);
                    Plotly.newPlot('graficaPieTZ', data, layout);
            </script>
        <!--TEZIUTLAN-->
    <!--GRAFICOS PASTEL GRUPALES-->

    <!--GRAFICOS BARRAS GRUPALES-->
        <!--CASITAS-->
            <script type="text/javascript">
                datosXCA=crearCadenaPie('<?php echo $datosXCA;?>');
                datosYCA=crearCadenaPie('<?php echo $datosYCA;?>');
                fechaInicioG='<?php echo $fechaInicioG;?>';
                fechaFinG='<?php echo $fechaFinG;?>';    

                //GRAFICA DE BARRAS      
                var trace1 = {
                        x: datosXCA,
                        y: datosYCA,
                        name: 'Ingresos',
                        type: 'bar',
                        text: datosYCA.map(String),
                        textposition: 'auto',
                        hoverinfo: 'none',
                        marker: {
                        color: 'rgb(158,202,225)',
                        opacity: 0.6,
                        line: {
                        color: 'rgb(8,48,107)',
                        width: 1.5
                        }}
                    };

                    var data = [trace1];    
                    var layout = {
                        barmode: 'group', 
                        title:acronimoCampo+" "+insumo+' CASITAS del '+fechaInicioG+" al "+fechaFinG,  
                        width: 800,
                        yaxis: {tickformat: '$,.2r'}
                        };

                    Plotly.newPlot('graficaBarrasCA', data, layout);        
            </script>
        <!--CASITAS-->

        <!--MATAMOROS-->
            <script type="text/javascript">
                datosXMA=crearCadenaPie('<?php echo $datosXMA;?>');
                datosYMA=crearCadenaPie('<?php echo $datosYMA;?>');
                        
                //GRAFICA DE BARRAS      
                var trace1 = {
                        x: datosXMA,
                        y: datosYMA,
                        name: 'Ingresos',
                        type: 'bar',
                        text: datosYMA.map(String),
                        textposition: 'auto',
                        hoverinfo: 'none',
                        marker: {
                        color: 'rgb(158,202,225)',
                        opacity: 0.6,
                        line: {
                        color: 'rgb(8,48,107)',
                        width: 1.5
                        }}
                    };

                    var data = [trace1];    
                    var layout = {
                        barmode: 'group', 
                        title:acronimoCampo+" "+insumo+' MATAMOROS del '+fechaInicioG+" al "+fechaFinG,  
                        width: 800,
                        yaxis: {tickformat: '$,.2r'}
                        };

                    Plotly.newPlot('graficaBarrasMA', data, layout);
            </script>
        <!--MATAMOROS-->

        <!--OAXACA-->
            <script type="text/javascript">
                datosXOA=crearCadenaPie('<?php echo $datosXOA;?>');
                datosYOA=crearCadenaPie('<?php echo $datosYOA;?>');
        
                //GRAFICA DE BARRAS      
                var trace1 = {
                        x: datosXOA,
                        y: datosYOA,
                        name: 'Ingresos',
                        type: 'bar',
                        text: datosYOA.map(String),
                        textposition: 'auto',
                        hoverinfo: 'none',
                        marker: {
                        color: 'rgb(158,202,225)',
                        opacity: 0.6,
                        line: {
                        color: 'rgb(8,48,107)',
                        width: 1.5
                        }}
                    };

                    var data = [trace1];    
                    var layout = {
                        barmode: 'group', 
                        title:acronimoCampo+" "+insumo+' OAXACA del '+fechaInicioG+" al "+fechaFinG,  
                        width: 800,
                        yaxis: {tickformat: '$,.2r'}
                        };

                    Plotly.newPlot('graficaBarrasOA', data, layout);
            </script>
        <!--OAXACA-->

        <!--POZA RICA-->
            <script type="text/javascript">
                datosXPZ=crearCadenaPie('<?php echo $datosXPZ;?>');
                datosYPZ=crearCadenaPie('<?php echo $datosYPZ;?>');    
                    
                //GRAFICA DE BARRAS      
                var trace1 = {
                        x: datosXPZ,
                        y: datosYPZ,
                        name: 'Ingresos',
                        type: 'bar',
                        text: datosYPZ.map(String),
                        textposition: 'auto',
                        hoverinfo: 'none',
                        marker: {
                        color: 'rgb(158,202,225)',
                        opacity: 0.6,
                        line: {
                        color: 'rgb(8,48,107)',
                        width: 1.5
                        }}
                    };

                    var data = [trace1];    
                    var layout = {
                        barmode: 'group', 
                        title:acronimoCampo+" "+insumo+' POZA RICA del '+fechaInicioG+" al "+fechaFinG,  
                        width: 800,
                        yaxis: {tickformat: '$,.2r'}
                        };

                    Plotly.newPlot('graficaBarrasPZ', data, layout);
            </script>
        <!--POZA RICA-->

        <!--REYNOSA I-->
            <script type="text/javascript">
                datosXR1=crearCadenaPie('<?php echo $datosXR1;?>');
                datosYR1=crearCadenaPie('<?php echo $datosYR1;?>');
                    
                //GRAFICA DE BARRAS      
                var trace1 = {
                        x: datosXR1,
                        y: datosYR1,
                        name: 'Ingresos',
                        type: 'bar',
                        text: datosYR1.map(String),
                        textposition: 'auto',
                        hoverinfo: 'none',
                        marker: {
                        color: 'rgb(158,202,225)',
                        opacity: 0.6,
                        line: {
                        color: 'rgb(8,48,107)',
                        width: 1.5
                        }}
                    };

                    var data = [trace1];    
                    var layout = {
                        barmode: 'group', 
                        title:acronimoCampo+" "+insumo+' REYNOSA I del '+fechaInicioG+" al "+fechaFinG,  
                        width: 800,
                        yaxis: {tickformat: '$,.2r'}
                        };

                    Plotly.newPlot('graficaBarrasR1', data, layout);
            </script>
        <!--REYNOSA I-->

        <!--REYNOSA II-->
            <script type="text/javascript">
                datosXR2=crearCadenaPie('<?php echo $datosXR2;?>');
                datosYR2=crearCadenaPie('<?php echo $datosYR2;?>');
                
                //GRAFICA DE BARRAS      
                var trace1 = {
                        x: datosXR2,
                        y: datosYR2,
                        name: 'Ingresos',
                        type: 'bar',
                        text: datosYR2.map(String),
                        textposition: 'auto',
                        hoverinfo: 'none',
                        marker: {
                        color: 'rgb(158,202,225)',
                        opacity: 0.6,
                        line: {
                        color: 'rgb(8,48,107)',
                        width: 1.5
                        }}
                    };

                    var data = [trace1];    
                    var layout = {
                        barmode: 'group', 
                        title:acronimoCampo+" "+insumo+' REYNOSA II del '+fechaInicioG+" al "+fechaFinG,  
                        width: 800,
                        yaxis: {tickformat: '$,.2r'}
                        };

                    Plotly.newPlot('graficaBarrasR2', data, layout);                                            
            </script>
        <!--REYNOSA II-->

        <!--TEZIUTLAN-->
            <script type="text/javascript">
                datosXTZ=crearCadenaPie('<?php echo $datosXTZ;?>');
                datosYTZ=crearCadenaPie('<?php echo $datosYTZ;?>');

                //GRAFICA DE BARRAS      
                var trace1 = {
                        x: datosXTZ,
                        y: datosYTZ,
                        name: 'Ingresos',
                        type: 'bar',
                        text: datosYTZ.map(String),
                        textposition: 'auto',
                        hoverinfo: 'none',
                        marker: {
                        color: 'rgb(158,202,225)',
                        opacity: 0.6,
                        line: {
                        color: 'rgb(8,48,107)',
                        width: 1.5
                        }}
                    };

                    var data = [trace1];    
                    var layout = {
                        barmode: 'group', 
                        title:acronimoCampo+" "+insumo+' TEZIUTLAN del '+fechaInicioG+" al "+fechaFinG,  
                        width: 800,
                        yaxis: {tickformat: '$,.2r'}
                        };

                    Plotly.newPlot('graficaBarrasTZ', data, layout);                            
            </script>
        <!--TEZIUTLAN-->    
    <!--GRAFICOS BARRAS GRUPALES-->

    <!--GRAFICO DE LINEAS GRUPALES-->
        <script type="text/javascript">    
        
                    var trace1 = {
                    x: datosXCA,
                    y: datosYCA,
                    type: 'scatter',
                    name: 'CASITAS'
                    };

                    var trace2 = {
                    x: datosXMA,
                    y: datosYMA,
                    type: 'scatter',
                    name: 'MATAMOROS'
                    };

                    var trace3 = {
                    x: datosXOA,
                    y: datosYOA,
                    type: 'scatter',
                    name: 'OAXACA'
                    };

                    var trace4 = {
                    x: datosXPZ,
                    y: datosYPZ,
                    type: 'scatter',
                    name: 'POZA RICA'
                    };

                    var trace5 = {
                    x: datosXR1,
                    y: datosYR1,
                    type: 'scatter',
                    name: 'REYNOSA I'
                    };

                    var trace6 = {
                    x: datosXR2,
                    y: datosYR2,
                    type: 'scatter',
                    name: 'REYNOSA II'
                    };

                    var trace7 = {
                    x: datosXTZ,
                    y: datosYTZ,
                    type: 'scatter',
                    name: 'TEZIUTLÁN'
                    };

                    var layout={
                        title: acronimoCampo+" "+insumo+" "+fechaInicioG+" del al "+fechaFinG,
                        height:550,
                        width: 850,
                        yaxis: {
                            tickformat: '$,.2r'                    
                            }
                    };

                    var data = [trace1,trace2,trace3,trace4,trace5,trace6,trace7];
                    Plotly.newPlot('graficaLineas', data,layout);
        </script>        
    <!--GRAFICO DE LINEAS GRUPALES-->

    <!--//////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
<!--GRAFICOS DE TODAS LAS PLAZAS-->
    <!--//////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
<?php elseif($busquedaPlaza==true):?>    
    <!--//////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
<!--GRAFICAS DE UNA PLAZA EN ESPECIFICO-->
    <!--//////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

    <!--MODAL GRAFICO DE LINEAS-->               
        <div class="modal fade" id="modalGraficoLineas">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Análisis de la remesa</h4>
            </div>
            <div class="modal-body">
            <div class="row">
                            <div class="col-md-12">                        
                                <div class="row">                                    
                            
                            
                                        <div id="graficaVentasLineasGenerico">                                        
                                            
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
    <!--MODAL GRAFICO DE LINEAS-->               

    <!--MODAL GRAFICO DE PASTEL-->
        <div class="modal fade" id="modalGraficoPastel">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Análisis de la remesa</h4>
            </div>
            <div class="modal-body">
            <div class="row">
                            <div class="col-md-12">                        
                                <div class="row">                                                                                                                            
                                        <div id="graficaVentasPastelGenerico">                                                                               
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
    <!--MODAL GRAFICO DE PASTEL-->

    <!--MODAL GRAFICO DE BARRAS-->
        <div class="modal fade" id="modalGraficoBarras">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Análisis de la remesa</h4>
            </div>
            <div class="modal-body">
            <div class="row">
                            <div class="col-md-12">                        
                                <div class="row">                                                                                                                            
                                        <div id="graficaVentasBarrasGenerico">                                                                               
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
    <!--MODAL GRAFICO DE BARRAS-->

    <!--GRAFICA DE PASTEL GENERICA-->
        <script type="text/javascript">
            datosXPastelGenerico=crearCadenaPie('<?php echo $datosXGenerico;?>');
            datosYPastelGenerico=crearCadenaPie('<?php echo $datosYGenerico;?>');   
            
            fechaInicioG2='<?php echo $fechaInicioG;?>';
            fechaFinG2='<?php echo $fechaFinG;?>';  
            nombrePlaza='<?php echo $nombrePlaza;?>';  
            insumo='<?php echo $nombreInsumo;?>';
            acronimoCampo='<?php echo $acronimoCampo;?>';
                                                            
            //GRAFICA DE PIE PASTEL DEL TOTAL DE INGRESOS
            var data = [{
                    values: datosYPastelGenerico,
                    labels: datosXPastelGenerico,    
                    type: 'pie',
                    text: datosYPastelGenerico.map(String),
            }];

            var layout = {
                title: acronimoCampo+" "+insumo+' '+nombrePlaza+" de "+fechaInicioG2+" al "+fechaFinG2,
                height:550,
                width: 550
            };        

            Plotly.newPlot('graficaVentasPastelGenerico', data, layout);
        </script>
    <!--GRAFICA DE PASTEL GENERICA-->

    <!--GRAFICA DE BARRAS GENERICA-->
        <script type="text/javascript">               
        var trace1 = {
                x: datosXPastelGenerico,
                y: datosYPastelGenerico,
                name: 'Ingresos',
                type: 'bar',
                text: datosYPastelGenerico.map(String),
                textposition: 'auto',
                hoverinfo: 'none',
                marker: {
                color: 'rgb(158,202,225)',
                opacity: 0.6,
                line: {
                color: 'rgb(8,48,107)',
                width: 1.5
                }}
            };

            var data = [trace1];    
            var layout = {
                barmode: 'group', 
                title: acronimoCampo+" "+insumo+' '+nombrePlaza+" de "+fechaInicioG2+" al "+fechaFinG2,  
                width: 900,
                yaxis: {tickformat: '$,.2r'}
                };

            Plotly.newPlot('graficaVentasBarrasGenerico', data, layout);    
        </script>
    <!--GRAFICA DE BARRAS GENERICA-->


    <!--GRAFICA DE LINEAS GENERICA-->
     <script type="text/javascript">                        
            var trace1 = {
                x: datosXPastelGenerico,
                y: datosYPastelGenerico,
                type: 'scatter',
                name: 'CASITAS'
            };

                var layout={
                    title: acronimoCampo+" "+insumo+' '+nombrePlaza+" de "+fechaInicioG2+" al "+fechaFinG2,
                    height:550,
                    width: 850,
                    yaxis: {
                        tickformat: '$,.2r'                    
                        }
                };

                var data = [trace1];
                Plotly.newPlot('graficaVentasLineasGenerico', data,layout);
        </script>
    <!--GRAFICA DE LINEAS GENERICA-->

    <!--//////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
<!--GRAFICAS DE UNA PLAZA EN ESPECIFICO-->
    <!--//////////////////////////////////////////////////////////////////////////////////////////////////////////////-->        
<?php endif;?>

<!--FUNCIONES JAVASCRIPT-->
    <script type="text/javascript">  

        function numberWithCommas(x) {
            var parts = x.toString().split(".");
            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            return parts.join(".");
        }
    
        //#region AL CAMBIAR EL GRUPO DE GASTOS DE REMESAS SE ACTUALIZAN LOS INSUMOS DE CADA GRUPO
            $('#grupo_remesa_id').change(function(){                        
                var grupo_id = $('#grupo_remesa_id').val();       
                if(grupo_id != ''){
                    $.ajax({
                        url:"<?php echo base_url(); ?>Remesas/consultarInsumo",
                        method:"POST",
                        data:{grupo_id:grupo_id},
                        success:function(data)
                        {
                        $('#insumo_gasto_remesa_id').html(data);                                          
                        }
                    });
                }
                else{
                //$('#grupo_id').html('<option value="">Seleccionar Grupo</option>');
                $('#insumo_gasto_remesa_id').html('<option value="">Seleccionar Insumo</option>');
                }            
            });
        //#endregion

        //#region REAJUSTAR TAMAÑO DE TABLA EN MODAL
            $('#modal-default').on('shown.bs.modal', function() {
                //Get the datatable which has previously been initialized
                //var dataTable= $('#tbl_prueba_API').DataTable();
                var dataTable2= $('#tbl_consulta_gastos_familia').DataTable();
                var datatable3= $('#tbl_consulta_gastos_familia2').DataTable();
                
                //recalculate the dimensions
                //dataTable.columns.adjust().responsive.recalc();
                dataTable2.columns.adjust().responsive.recalc();

            });
        //#endregion

        var consultaGastosFamilia= $('#tbl_consulta_gastos_familia').DataTable({
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
                    
                },
                {
                    title: "Análisis de Remesas"   ,
                    extend:'copy'  
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

        var consultaGastosFamilia2= $('#tbl_consulta_gastos_familia_2').DataTable({
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
                    
                },
                {
                    title: "Análisis de Remesas"   ,
                    extend:'copy'  
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

        function consultarGastosFamilia(fechainicio,fechafin,plaza_id,familia_id){                   
            
            var parametros = {
                    "fechainicio" : fechainicio,
                    "fechafin":fechafin,
                    "familia_id":familia_id,
                    "plaza_id" : plaza_id,        
                    };         


                    $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>Remesas/consultarGastoFamiliaModal",
                    data: parametros,              
                    dataType: "JSON",                                 
                    success: function(response){                      
                        consultaGastosFamilia.clear();                       
                        var len = response.length;    
                        var acImporte=0;  
                        var acCantidad=0;
                        for(var i=0; i<len; i++){                                        
                            var plaza=response[i].Plaza;  
                            var insumo=response[i].Insumo;
                            var pago=response[i].Pago;
                            var cantidad=response[i].Cantidad;
                            var unidad=response[i].Unidad;
                            var unidad2=response[i].Unidad;
                            var importe=response[i].Importe;                          
                            var importe2=numberWithCommas(importe);  
                            var insumo_id=response[i].Insumo_ID;                          
                            var editar='<a href="#" onclick="verDesgloseGastosFamiliaRango(\''+fechainicio+'\',\''+fechafin+'\',\''+familia_id+'\','+plaza_id+','+insumo_id+')" data-toggle="modal" data-target="#verDesgloseGastos" class="btn btn-info"><span class="fa fa-search"></span></a></td>';	                                                          
                            acImporte=parseFloat(acImporte)+parseFloat(importe);   
                            acCantidad=parseFloat(acCantidad)+parseFloat(cantidad);                               
                            consultaGastosFamilia.row.add([plaza,insumo,cantidad,unidad,"$"+importe2,"$"+Math.round((importe/cantidad)*100)/100,editar]);                    
                        }
                        acImporte=Math.round(acImporte);
                        acImporte=numberWithCommas(acImporte);
                        consultaGastosFamilia.row.add(["Totales","",Math.round(acCantidad),"","$"+acImporte,"",editar]);   
                        consultaGastosFamilia.draw();                                                
                    },
                    error: function() { 
                        alert("Error posting feed.");
                    }
                });    
        }

        //verDesgloseGastosFamiliaRango(\''+fechainicio+'\',\''+fechafin+'\',\''+familia_id'\','+plaza_id+')"
        function verDesgloseGastosFamiliaRango(fechaInicio,fechaFin,familia_id,plaza_id,insumo_id){            
            //alert(fechaInicio+"  "+fechaFin+"  "+familia_id+"  "+plaza_id);            
            //alert(insumo_id);
            var parametros = {
                    "fechainicio" : fechaInicio,
                    "fechafin":fechaFin,
                    "familia_id":familia_id,
                    "plaza_id" : plaza_id,        
                    "insumo_id" : insumo_id        
            };         

                    $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>Remesas/consultarGastoFamiliaModalDesglose",
                    data: parametros,              
                    dataType: "JSON",                                 
                    success: function(response){                                              
                        consultaGastosFamilia2.clear();                       
                        var len = response.length;    
                        var acImporte=0;  
                        var acCantidad=0;
                        for(var i=0; i<len; i++){  
                            var fecha=response[i].Fecha;                                      
                            var usuario=response[i].Usuario;                                      
                            var plaza=response[i].Plaza;  
                            var insumo=response[i].Insumo;
                            var pago=response[i].Pago;
                            var cantidad=response[i].Cantidad;
                            var unidad=response[i].Unidad;
                            var unidad2=response[i].Unidad;
                            var importe=response[i].Importe;     
                            var notas=response[i].Notas;                          
                            var importe2=numberWithCommas(importe);                              
                            acImporte=parseFloat(acImporte)+parseFloat(importe);   
                            acCantidad=parseFloat(acCantidad)+parseFloat(cantidad);                               
                            consultaGastosFamilia2.row.add([fecha,usuario,plaza,insumo,cantidad,unidad,"$"+importe2,"$"+Math.round((importe/cantidad)*100)/100,notas]);                    
                        }
                        acImporte=Math.round(acImporte);
                        acImporte=numberWithCommas(acImporte);
                        consultaGastosFamilia2.row.add(["Totales","","","",Math.round(acCantidad),"","$"+acImporte,"",""]);   
                        consultaGastosFamilia2.draw();                                                
                    },
                    error: function() { 
                        alert("Error posting feed.");
                    }
                });   
        }
        
    </script>
<!--FUNCIONES JAVASCRIPT-->





