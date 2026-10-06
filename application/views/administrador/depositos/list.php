<!-- =============================================== -->
<!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                Ventas Generales
                <small>Listado</small>
                </h1>
                <a href="<?php echo base_url(); ?>Depositos/panel" class="small-box-footer">Volver al Panel de Ventas <i class="fa fa-arrow-circle-right"></i></a>
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
                            <div class="col-md-2">
                                <input type="date" class="form-control" name="fechaInicioD" id="fechaInicioD" value="<?php echo !empty($fechainicio) ? $fechainicio:'';?>" required>
                            </div>

                            <label for="" class="col-md-1 control-label">Hasta:</label>
                            <div class="col-md-2">
                                <input type="date" class="form-control" name="fechaFinD" id="fechaFinD" value="<?php  echo !empty($fechafin) ? $fechafin:'';?>">
                            </div>
                            
                            <label for="" class="col-md-1 control-label">Plaza:</label>                            
                            <div class="col-md-2">
                                <select name="plaza_idP" id="plaza_idP" class="form-control">                                                  
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
                                            <?php endforeach;?>
                                        </select>                                                                        
                            </div>

                            <label for="grafico" class="col-md-1 control-label">Gráfico:</label>                            
                            <div class="col-md-2">
                                <select name="grafico_id" id="grafico_id" class="form-control">                                                  
                                        <?php foreach ($tipos as $tipo):?>  
                                        <?php if($tipo->id==1):?>
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
                        </div>

                        <div class="form-group">                            
                            <label for="" class="col-md-1 control-label">Options:  </label>                           
                            <div class="col-md-11">
                                <input type="submit" name="buscar" value="Buscar" class="btn btn-primary">
                                <input type="submit" name="buscarRango" value="B. Rango" class="btn btn-danger" id="buscar_rango_depositos_list">    
                                <input type="submit" name="buscarRangoDesglose" value="B.R Desglose" class="btn btn-danger" id="buscar_rango_depositos_list">                                      
                                <a href="<?php echo base_url(); ?>Depositos" class="btn btn-success">Restablecer</a>
                                <button type='button' class="btn btn-info btn-flag" data-toggle="modal" data-target="#modalGraficoLineas"><span class="fa fa-search" ></span> Lineas</button>
                                <button type='button' class="btn btn-info btn-flag" data-toggle="modal" data-target="#modalGraficoPastel"><span class="fa fa-search" ></span> Pastel</button>                                 
                                <button type='button' class="btn btn-info btn-flag" data-toggle="modal" data-target="#modalGraficoBarras"><span class="fa fa-search" ></span> Barras</button>
                            </div>
                        </div>
                        
                        </form>                                               
                        </div>
                         </div>
                                                  
                         <div class="row">
                            <div class="col-md-12">
                            <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_depositos">
                            <thead>
                                <tr>                                                   
                                    <th>Plaza</th>
                                    <th>Fecha</th>
                                    <th>Total V</th>
                                    <th>Ventas C</th>
                                    <th>TPV</th>                                    
                                    <th>Gastos</th>   
                                    <th>% Gastos</th>   
                                    <th>Depósito</th>
                                    <th>Efectivo</th>   
                                    <th>V.Gastos</th>                                                                                                      
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($reportes)):?>
                                <?php
                                $acVentas=0;
                                $acIngresos=0;
                                $acTPV=0;
                                $acGastos=0;
                                $acDeposito=0;
                                $acEfectivo=0;?>

                                <?php foreach ($reportes as $reporte):?>
                                <?php if($menu==0):?>
                                <?php
                                $acVentas+=$reporte->Total_Ventas;
                                $acIngresos+=$reporte->Total_Ingresos;
                                $acTPV+=$reporte->TPV;
                                $acGastos+=$reporte->Gastos;
                                $acDeposito+=$reporte->Deposito;
                                $acEfectivo+=$reporte->Efectivo_Real;?>
                                   <tr>              
                                   <?php switch($reporte->plaza_id): 
                                    case 1: ?>
                                    <td bgcolor="#bae6ff"><?=$reporte->Plaza;?></td>
                                    <?php break; ?>

                                    <?php case 2: ?>
                                    <td bgcolor="#FA8072"><?=$reporte->Plaza;?></td>
                                    <?php break; ?>
                                    
                                    <?php case 3: ?>
                                    <td bgcolor="#8cedbc"><?=$reporte->Plaza;?></td>
                                    <?php break; ?>

                                    <?php case 4: ?>
                                    <td bgcolor="#ecccbb"><?=$reporte->Plaza;?></td>
                                    <?php break; ?>

                                    <?php case 5: ?>
                                    <td bgcolor="#ffd682"><?=$reporte->Plaza;?></td>
                                    <?php break; ?>

                                    <?php case 6: ?>
                                    <td bgcolor="#e7bbec"><?=$reporte->Plaza;?></td>
                                    <?php break; ?>
                                    
                                    <?php case 7: ?>
                                    <td bgcolor="#c7d5d8"><?=$reporte->Plaza;?></td>
                                    <?php break; ?>
                                    
                                    <?php endswitch; ?>

                                    <td><?=$reporte->Fecha;?></td>
                                    <td> $ <?=number_format($reporte->Total_Ingresos);?></td>
                                    <td> $ <?=number_format($reporte->Total_Ventas);?></td>
                                    <td> $ <?=number_format($reporte->TPV);?></td>                                    
                                    <td> $ <?=number_format($reporte->Gastos);?></td>
                                    <td><?=round($reporte->Gastos/$reporte->Total_Ingresos,4)*100;?>%</td>
                                    <td> $ <?=number_format($reporte->Deposito);?></td>
                                    <td> $ <?=number_format($reporte->Efectivo_Real);?></td> 
                                    <td>                                        
                                            <button type="button" class="btn btn-info btn-view" onclick="consultarGastos('<?php echo $reporte->Fecha;?>',<?php echo $reporte->plaza_id;?>)" data-toggle="modal" data-target="#modal-default" value="">
                                                <span class="fa fa-search"></span>
                                            </button>                                                                                   
                                    </td>  
                                                                                                
                                </tr>   
                                <?php endif;?> 
                                <?php if($menu==1):?>
                                <?php
                                $acVentas+=$reporte->SumaVentasC;
                                $acIngresos+=$reporte->SumaTotalV;
                                $acTPV+=$reporte->SumaTPV;
                                $acGastos+=$reporte->SumaGastos;
                                $acDeposito+=$reporte->SumaDeposito;
                                $acEfectivo+=$reporte->SumaEfectivo;?>
                                      <tr>                                                                     
                                      <?php switch($reporte->plaza_id): 
                                    case 1: ?>
                                    <td bgcolor="#bae6ff"><?=$reporte->Plaza;?></td>
                                    <?php break; ?>

                                    <?php case 2: ?>
                                    <td bgcolor="#FA8072"><?=$reporte->Plaza;?></td>
                                    <?php break; ?>
                                    
                                    <?php case 3: ?>
                                    <td bgcolor="#8cedbc"><?=$reporte->Plaza;?></td>
                                    <?php break; ?>

                                    <?php case 4: ?>
                                    <td bgcolor="#ecccbb"><?=$reporte->Plaza;?></td>
                                    <?php break; ?>

                                    <?php case 5: ?>
                                    <td bgcolor="#ffd682"><?=$reporte->Plaza;?></td>
                                    <?php break; ?>

                                    <?php case 6: ?>
                                    <td bgcolor="#e7bbec"><?=$reporte->Plaza;?></td>
                                    <?php break; ?>
                                    
                                    <?php case 7: ?>
                                    <td bgcolor="#c7d5d8"><?=$reporte->Plaza;?></td>
                                    <?php break; ?>
                                    
                                    <?php endswitch; ?>
                                        <td><?=$fechaConsulta?></td>                          
                                        <td> $ <?=number_format($reporte->SumaTotalV);?></td>   
                                        <td> $ <?=number_format($reporte->SumaVentasC);?></td>
                                        <td> $ <?=number_format($reporte->SumaTPV);?></td>                                        
                                        <td> $ <?=number_format($reporte->SumaGastos);?></td>
                                        <td><?=round($reporte->SumaGastos/$reporte->SumaTotalV,4)*100;?>%</td>       
                                        <td> $ <?=number_format($reporte->SumaDeposito);?></td>
                                        <td> $ <?=number_format($reporte->SumaEfectivo);?></td>   
                                        <td>                                        
                                            <button type="button" class="btn btn-info btn-view" onclick="consultarGastosRango('<?php echo $fechainicio;?>','<?php echo $fechafin;?>',<?php echo $reporte->plaza_id;?>)" data-toggle="modal" data-target="#modal-default" value="">
                                                <span class="fa fa-search"></span>
                                            </button>                                                                                   
                                        </td>  
                                        </tr>    
                                <?php endif;?> 
                                <?php endforeach;?>                                                                                                            
                                <tr>                                    
                                    <td><b><h4>Totales</h4></b></td>
                                    <td></td>
                                    <td><b>$ <?=number_format($acIngresos);?></b></td>
                                    <td><b>$ <?=number_format($acVentas);?></b></td>
                                    <td><b>$ <?=number_format($acTPV);?></b></td>                                    
                                    <td><b>$ <?=number_format($acGastos);?></b></td>
                                    <td><b><?=round($acGastos/$acIngresos,4)*100;?>%</b></td>
                                    <td><b>$ <?=number_format($acDeposito);?></b></td>
                                    <td><b>$ <?=number_format($acEfectivo);?></b></td>
                                    <td></td>                                                                  
                                </tr>  
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



<!--MODAL PARA CONSULTAR LOS GASTOS-->
    <div class="modal fade" id="modal-default">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Gastos Asociados al día</h4>
        </div>
        <div class="modal-body">
            <div class="responsive-table">
                <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_prueba_API" >
                    <thead>
                        <tr>                                    
                            <th>Fecha</th>                                                                                                                 
                            <th>Plaza</th>                                                                                 
                            <th>Gasto</th>  
                            <th>Cantidad</th>  
                            <th>Unidad</th>
                            <th>Importe</th>      
                            <th>P. Unitario</th>                                                                                                                                   
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
<!--MODAL PARA CONSULTAR LOS GASTOS-->


<!--MODAL GRAFICO DE LINEAS-->
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
                        
                        
                                    <div id="graficaVentasLineas">                                        
                                        
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
            <h4 class="modal-title">Análisis de Ventas</h4>
        </div>
        <div class="modal-body">
        <div class="row">
                        <div class="col-md-12">                        
                            <div class="row">                                                                                                                            
                                    <div id="graficaVentasPastel">                                                                               
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
            <h4 class="modal-title">Análisis de Ventas</h4>
        </div>
        <div class="modal-body">
        <div class="row">
                        <div class="col-md-12">                        
                            <div class="row">                                                                                                                            
                                    <div id="graficaVentasBarras">                                                                               
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


<!--FUNCION PARA CONVERTIR LOS DATOS EN JSON -->
    <script type="text/javascript">
        function crearCadenaBarras(json){
            var parsed=JSON.parse(json);
            var arr=[];
            for(var x in parsed){
                arr.push(parsed[x]);
            }
            return arr;
        }
    </script>
<!--FUNCION PARA CONVERTIR LOS DATOS EN JSON -->


<?php if($busquedaPlaza==false):?>
    <!--//////////////////////GRAFICAS DE TODAS LAS PLAZAS//////////////////////////////////////////-->
    
    <!--GRAFICO DE LINEAS DE TODAS LAS PLAZAS-->
        <script type="text/javascript">    
            datosXCA=crearCadenaBarras('<?php echo $datosXCA;?>');
            datosYCA=crearCadenaBarras('<?php echo $datosYCA;?>');  
            datosXMA=crearCadenaBarras('<?php echo $datosXMA;?>');
            datosYMA=crearCadenaBarras('<?php echo $datosYMA;?>');
            datosXOA=crearCadenaBarras('<?php echo $datosXOA;?>');
            datosYOA=crearCadenaBarras('<?php echo $datosYOA;?>');
            datosXPZ=crearCadenaBarras('<?php echo $datosXPZ;?>');
            datosYPZ=crearCadenaBarras('<?php echo $datosYPZ;?>');
            datosXRI=crearCadenaBarras('<?php echo $datosXRI;?>');
            datosYRI=crearCadenaBarras('<?php echo $datosYRI;?>');
            datosXRII=crearCadenaBarras('<?php echo $datosXRII;?>');
            datosYRII=crearCadenaBarras('<?php echo $datosYRII;?>');
            datosXTZ=crearCadenaBarras('<?php echo $datosXTZ;?>');
            datosYTZ=crearCadenaBarras('<?php echo $datosYTZ;?>');
            
            acronimoCampo='<?php echo $acronimoCampo;?>';
            
            fechaInicioG='<?php echo $fechaInicioG;?>';
            fechaFinG='<?php echo $fechaFinG;?>';  


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
                    x: datosXRI,
                    y: datosYRI,
                    type: 'scatter',
                    name: 'REYNOSA I'
                    };

                    var trace6 = {
                    x: datosXRII,
                    y: datosYRII,
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
                        title:  acronimoCampo+" del "+fechaInicioG+" al "+fechaFinG,
                        height:550,
                        width: 850,
                        yaxis: {
                            tickformat: '$,.2r'                    
                            }
                    };

                    var data = [trace1,trace2,trace3,trace4,trace5,trace6,trace7];
                    Plotly.newPlot('graficaVentasLineas', data,layout);
        </script>
    <!--GRAFICO DE LINEAS DE TODAS LAS PLAZAS-->

    <!--GRAFICO DE PASTEL DE TODAS LAS PLAZAS-->
        <script type="text/javascript">
            datosX=crearCadenaBarras('<?php echo $datosX;?>');
            datosY=crearCadenaBarras('<?php echo $datosY;?>');      
            //GRAFICA DE PIE PASTEL DEL TOTAL DE INGRESOS
            var data = [{
                    values: datosY,
                    labels: datosX,    
                    type: 'pie',
                    text: datosY.map(String),
            }];
            
            var layout = {
                title:acronimoCampo+" del "+fechaInicioG+" al "+fechaFinG,
                height:550,
                width: 550
            };        

            Plotly.newPlot('graficaVentasPastel', data, layout);
        </script>
    <!--GRAFICO DE PASTEL DE TODAS LAS PLAZAS-->

    <!--GRAFICO DE BARRAS DE TODAS LAS PLAZAS-->
        <script type="text/javascript">
            //GRAFICA DE BARRAS      
            var trace1 = {
                x: datosX,
                y: datosY,
                name: 'Ingresos',
                type: 'bar',
                text: datosY.map(String),
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
                title: acronimoCampo+" del "+fechaInicioG+" al "+fechaFinG,  
                width: 900,
                yaxis: {tickformat: '$,.2r'}
                };

            Plotly.newPlot('graficaVentasBarras', data, layout);
        </script>
    <!--GRAFICO DE BARRAS DE TODAS LAS PLAZAS-->

    <!--//////////////////////GRAFICAS DE TODAS LAS PLAZAS//////////////////////////////////////////-->
<?php elseif($busquedaPlaza==true):?>
    <!--//////////////////////GRAFICAS DE UNA PLAZA EN ESPECIFICO//////////////////////////////////////////-->

        <!--GRAFICA DE PASTEL GENERICA-->
            <script type="text/javascript">
                datosXPastelGenerico=crearCadenaBarras('<?php echo $datosXPastelGenerico;?>');
                datosYPastelGenerico=crearCadenaBarras('<?php echo $datosYPastelGenerico;?>');   
                
                acronimoCampo2='<?php echo $acronimoCampo;?>';
                
                fechaInicioG2='<?php echo $fechaInicioG;?>';
                fechaFinG2='<?php echo $fechaFinG;?>';  
                nombrePlaza='<?php echo $nombrePlaza;?>';  
                        
                //GRAFICA DE PIE PASTEL DEL TOTAL DE INGRESOS
                var data = [{
                        values: datosYPastelGenerico,
                        labels: datosXPastelGenerico,    
                        type: 'pie',
                        text: datosYPastelGenerico.map(String),
                }];

                var layout = {
                    title:'Mostrando '+acronimoCampo2+" de "+nombrePlaza+" del "+fechaInicioG2+" al "+fechaFinG2,
                    height:550,
                    width: 550
                };        

                Plotly.newPlot('graficaVentasPastel', data, layout);
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
                    title: 'Mostrando '+acronimoCampo2+" de "+nombrePlaza+" del "+fechaInicioG2+" al "+fechaFinG2,  
                    width: 900,
                    yaxis: {tickformat: '$,.2r'}
                    };

                Plotly.newPlot('graficaVentasBarras', data, layout);    
            </script>
        <!--GRAFICA DE BARRAS GENERICA-->

        <!--GRAFICA DE LINEAS GENERICA-->
            <script type="text/javascript">
                datosXLineasGenerico=crearCadenaBarras('<?php echo $datosXLineasGenerico;?>');
                datosYLineasGenerico=crearCadenaBarras('<?php echo $datosYLineasGenerico;?>');
                
                var trace1 = {
                    x: datosXLineasGenerico,
                    y: datosYLineasGenerico,
                    type: 'scatter',
                    name: 'CASITAS'
                };

                    var layout={
                        title:'Mostrando '+acronimoCampo2+" de "+nombrePlaza+" del "+fechaInicioG2+" al "+fechaFinG2,
                        height:550,
                        width: 850,
                        yaxis: {
                            tickformat: '$,.2r'                    
                            }
                    };

                    var data = [trace1];
                    Plotly.newPlot('graficaVentasLineas', data,layout);
            </script>
        <!--GRAFICA DE LINEAS GENERICA-->

    <!--//////////////////////GRAFICAS DE UNA PLAZA EN ESPECIFICO//////////////////////////////////////////-->
<?php endif;?>


<script type="text/javascript">  


    function numberWithCommas(x) {
        var parts = x.toString().split(".");
        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        return parts.join(".");
    }

    //ASIGNACIÓN DE DATATABLE 
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

    //FUNCIÓN PARA CONSULTAR LOS GASTOS 
    function consultarGastos(fecha,plaza_id){        
        var parametros = {
                "fecha" : fecha,
                "plaza_id" : plaza_id,        
                };              
                $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>Remesas/consultarGastoModal",
                data: parametros,              
                dataType: "JSON",                                 
                success: function(response){  
                    pruebaAPI.clear();                   
                    var len = response.length;    
                    var acImporte=0;
                    for(var i=0; i<len; i++){
                        var fecha = response[i].Fecha;
                        var  id=response[i].id;
                        var usuario_id = response[i].usuario_id;  
                        var plaza_id = response[i].plaza_id;   
                        var insumo_gasto_id = response[i].insumo_gasto_id;   
                        var plaza=response[i].Plaza;  
                        var insumo=response[i].Insumo;
                        var pago=response[i].Pago;
                        var cantidad=response[i].Cantidad;
                        var unidad=response[i].Unidad;
                        var unidad2=response[i].Unidad;
                        var importe=response[i].Importe;
                        var importe2=numberWithCommas(importe);                      
                        acImporte=parseFloat(acImporte)+parseFloat(importe);   
                        pruebaAPI.row.add([fecha,plaza,insumo,cantidad,unidad,"$ "+importe2,"$ "+Math.round((importe/cantidad)*100)/100]);                    
                    }

                    acImporte=Math.round(acImporte);
                    acImporte=numberWithCommas(acImporte);
                    
                    pruebaAPI.row.add(["Totales","","","","",("$ "+acImporte).bold(),"","",""]);   
                    pruebaAPI.draw();                                                
                },
                error: function() { 
                    alert("Error posting feed.");
                }
            });
                
    }

    //FUNCIÓN PARA CONSULTAR LOS GASTOS EN RANGO
    function consultarGastosRango(fechainicio,fechafin,plaza_id){                           
        var parametros = {
                "fechainicio" : fechainicio,
                "fechafin" : fechafin,
                "plaza_id" : plaza_id,        
                };                             
            
            $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>Remesas/consultarGastoModalRango",
            data: parametros,    
            dataType: "JSON",                                                
            success: function(response){             
                pruebaAPI.clear();   
                
                var len = response.length;    
                    var acImporte=0;  
                for(var i=0; i<len; i++){
                    var fecha = response[i].Fecha;
                    var usuario = response[i].Usuario;            
                    var plaza=response[i].Plaza;  
                    var insumo=response[i].Insumo;
                    var pago=response[i].Pago;
                    var cantidad=response[i].Cantidad;
                    var unidad=response[i].Unidad;
                    var unidad2=response[i].Unidad;
                    var importe=response[i].Importe;  
                        acImporte=parseFloat(acImporte)+parseFloat(importe);   
                pruebaAPI.row.add([fecha,usuario,plaza,insumo,cantidad,unidad,Math.round((importe/cantidad)*100)/100,importe]);                    
                }
                pruebaAPI.row.add(["Totales","","","","","","",Math.round(acImporte)]);   
                pruebaAPI.draw();                                                                                                          
            },
            error: function() { 
                alert("Error posting feed.");
            }
        });
            
    }

</script>





