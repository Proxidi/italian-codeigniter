<style>
    /* th { font-size: 11px; } */
    td { font-size: 11px; }
</style>            

<div class="content-wrapper">            
    <section class="content-header">
        <h1>
        Análisis Costo-Venta
        <small>Listado</small>
        </h1>
        <a href="<?php echo base_url(); ?>Productos" class="small-box-footer">Volver al Panel de Productos <i class="fa fa-arrow-circle-right"></i></a>
    </section>     

    <section class="content">        
        <div class="box box-solid">
            <div class="box-body">

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">                                            
                            <label for="read">Busqueda:</label>
                                
                            <label class="radio-inline">
                                <input type="date" class="form-control" name="fechaInicioBusqueda" id="fechaInicioBusqueda" value="<?php echo !empty($fechaLunes) ? $fechaLunes:'';?>" required>
                            </label>

                            <label class="radio-inline">                                    
                                <input type="date" class="form-control" name="fechaFinBusqueda" id="fechaFinBusqueda" value="<?php echo !empty($fechaDomingo) ? $fechaDomingo:'';?>" readonly>
                            </label>

                            <label class="radio-inline">                                    
                                <select name="cmbPlazas" id="cmbPlazas" class="form-control"> 
                                    <option value="0" selected>
                                        Todas las plazas
                                    </option>                                                 

                                    <?php foreach ($plazas as $plaza):?>                                                                                                              
                                        <option value="<?php echo $plaza->id?>">
                                            <?php echo $plaza->Nombre;?>
                                        </option>                                    
                                    <?php endforeach;?>
                                </select>
                            </label>                                

                            <label class="radio-inline">                                    
                                <button href="#" class="btn btn-success" onclick="buscarAnalisisCostoVenta()">
                                    <span class="fa fa-search"></span> Buscar
                                </button>
                            </label>                                                                                                       				                                                                
                        </div>                                    
                    </div>                                 
                </div>
                                
                <div class="row">
                    <div class="col-md-12">
                        <table class="display responsive table table-bordered  btn-hover" style="width:100%" id="tbl_insumos">
                            <thead>
                                <tr>
                                    <th>#</th>     
                                    <th>PZ</th>                               
                                    <th>Nombre</th>                                                                                                                                                                                 
                                    <th>CV</th>                                     
                                    <th>Inv.I <span id="thInventarioInicial"><?php echo "<br>". $ultimaFechaInventarioInicial; ?></span> </th>
                                    <th>Inv.I </th>
                                    <th>Inv.F <span id="thInventarioFinal"><?php echo "<br>". $ultimaFechaInventarioFinal; ?></span></th>
                                    <th>Inv.F </th>                                    
                                    <th>PC</th>
                                    <th>PV</th>
                                    <th>ΣG</th>
                                    <th>ΣI</th>
                                    <th>ΣF</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($insumos)):?>
                                <?php foreach ($insumos as $insumo):?>
                                <tr>                                    
                                    <td><?=$insumo["id"];?></td>         
                                    <td><?=$insumo["Nombre_Plaza"];?></td>                           
                                    <td><?=substr($insumo["Nombre"],0,20);?></td>                                                                               
                                    <td>$<?=number_format($insumo["Costo_Venta"],2);?></td> 
                                    <td><?=round($insumo["Valor_Fecha_Inicial"],2);?></td>
                                    <td>$<?=number_format($insumo["Valor_Calculado_Fecha_Inicial"],2);?></td>
                                    <td><?=round($insumo["Valor_Fecha_Final"],2);?></td>
                                    <td>$<?=number_format($insumo["Valor_Calculado_Fecha_Final"],2);?></td>
                                    <td><?=round($insumo["Valor_Pedido"],2);?></td>
                                    <td>$<?=number_format($insumo["Valor_Calculado_Pedido"],2);?></td>
                                    <td>$<?=number_format($insumo["Sumatoria_Gastos"],2);?></td>
                                    <td>$<?=number_format($insumo["Sumatoria_Ingresos"],2);?></td>
                                    <td>%<?=number_format($insumo["Sumatoria_Final"],5);?></td>
                                </tr>   
                                <?php endforeach;?>                                                              
                                <?php endif;?>                                
                            </tbody>                            
                        </table>                            
                    </div>
                </div>                    
            </div>                                        
        </div>                
    </section>            
</div>        


<script type="text/javascript">  
    var tbl_insumos= $('#tbl_insumos').DataTable({        
        dom: 'Bfrtip',
        "pageLength": 30,
        "aaSorting": [],
        "paging": false,
        "searching":true,
        buttons: [                
        ],            
        responsive: true
    });
                        

    function buscarAnalisisCostoVenta(){                
        let plaza=$("#cmbPlazas").val();
        let fechaInicioBusqueda=$("#fechaInicioBusqueda").val();        

        if(plaza==0){alert("Seleccione una plaza por favor"); return;}        

        let parametros={
            'plaza_id':plaza,
            'fechaInicioBusqueda': fechaInicioBusqueda
        }

        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>Ventas/tablaCostoVentaAjax",            
            data:parametros,
            dataType: "JSON",            
            success: function(response){  
                                
                let data=response.insumos;       

                $("#fechaInicioBusqueda").val(response.fechaLunes);
                $("#fechaFinBusqueda").val(response.fechaDomingo);

                $("#thInventarioInicial").text(response.ultimaFechaInventarioInicial);
                $("#thInventarioFinal").text(response.ultimaFechaInventarioFinal);                

                tbl_insumos.clear();   

                for (let index = 0; index <data.length; index++) {                                                                                                                    
                    let insumo_id=data[index]["id"];

                    let nombre_plaza=data[index]["Nombre_Plaza"];                      

                    let nombre_insumo=data[index]["Nombre"];  
                    nombre_insumo=nombre_insumo.substring(0,10);                                

                    let costo_venta=parseFloat(data[index]["Costo_Venta"]).toFixed(2);
                    costo_venta=numberWithCommas(costo_venta);

                    let valor_fecha_inicial=parseFloat(data[index]["Valor_Fecha_Inicial"]).toFixed(2);

                    let valor_calculado_fecha_inicial=parseFloat(data[index]["Valor_Calculado_Fecha_Inicial"]).toFixed(2);
                    valor_calculado_fecha_inicial=numberWithCommas(valor_calculado_fecha_inicial);

                    let valor_fecha_final=parseFloat(data[index]["Valor_Fecha_Final"]).toFixed(2);

                    let valor_calculado_fecha_final=parseFloat(data[index]["Valor_Calculado_Fecha_Final"]).toFixed(2);
                    valor_calculado_fecha_final=numberWithCommas(valor_calculado_fecha_final);

                    let valor_pedido=parseFloat(data[index]["Valor_Pedido"]).toFixed(2);                    

                    let valor_calculado_pedido=parseFloat(data[index]["Valor_Calculado_Pedido"]).toFixed(2);
                    valor_calculado_pedido=numberWithCommas(valor_calculado_pedido);
                    
                    let sumatoria_gastos= parseFloat(data[index]["Sumatoria_Gastos"]).toFixed(2);
                    sumatoria_gastos=numberWithCommas(sumatoria_gastos);

                    let sumatoria_ingresos= parseFloat(data[index]["Sumatoria_Ingresos"]).toFixed(2);
                    sumatoria_ingresos=numberWithCommas(sumatoria_ingresos);
                    
                    let sumatoria_final= parseFloat(data[index]["Sumatoria_Final"]).toFixed(5);                                            
                    sumatoria_final=numberWithCommas(sumatoria_final);

                    tbl_insumos.row.add([insumo_id,nombre_plaza,nombre_insumo,"$"+costo_venta,valor_fecha_inicial,"$"+valor_calculado_fecha_inicial,valor_fecha_final,"$"+valor_calculado_fecha_final,valor_pedido,"$"+valor_calculado_pedido,"$"+sumatoria_gastos,"$"+sumatoria_ingresos,"%"+sumatoria_final]);
                }                
                tbl_insumos.draw();                
            },
            error: function(xhr, desc, e) {                                 
                alert("Error posting feed.");                
            }
        });     
    }

    function numberWithCommas(x) {
        var parts = x.toString().split(".");
        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        return parts.join(".");
    }
</script>

