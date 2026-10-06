            
<div class="content-wrapper">            
    <section class="content-header">
        <h1>
        Insumos Costo-Venta
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
                            <div class="col-md-12">
                                <label for="read">Opciones:</label>
                                <label class="radio-inline">
                                    <input type="radio" name="permiso" id="permiso" onchange="hideTable(1)" value="1" checked="checked"> Costos Insumos Pedido
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="permiso" id="permiso" onchange="hideTable(2)" value="0" > Costos Insumos Remesas
                                </label>
                            </div>                                                                             				                                                                
                        </div>                                    
                    </div>
                </div>  

                <div class="row" id="divBusquedaCompras">
                    <div class="col-md-12">
                        <div class="form-group">                                            
                            <label for="read">Busqueda:</label>
                                
                            <label class="radio-inline">
                                <input type="date" class="form-control" name="fechaInicioBusqueda" id="fechaInicioBusqueda" value="<?php echo !empty($fechaInicioBusqueda) ? $fechaInicioBusqueda:'';?>" required>
                            </label>

                            <label class="radio-inline">                                    
                                <input type="date" class="form-control" name="fechaFinBusqueda" id="fechaFinBusqueda" value="<?php echo !empty($fechaFinBusqueda) ? $fechaFinBusqueda:'';?>" readonly>
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
                                <button href="#" class="btn btn-success" onclick="busquedaPrecioInsumo()">
                                    <span class="fa fa-search"></span> Buscar
                                </button>
                            </label>                                                                                                       				                                                                
                        </div>                                    
                    </div>                               
                </div> 
          
                <div class="row">
                    <div class="col-md-12">
                        <table class="display responsive table table-bordered  btn-hover" style="width:100%" id="tbl_insumos_pedido">
                            <thead>
                                <tr>
                                    <th>#</th>                                    
                                    <th>Nombre</th>                                                                                                                                                                                 
                                    <th>Costo Venta</th>                                     
                                    <th>Editar</th>                                  
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($insumosPedido)):?>
                                <?php foreach ($insumosPedido as $insumo):?>
                                <tr>                                    
                                    <td><?=$insumo->id;?></td>                                    
                                    <td><?=$insumo->Nombre;?></td>                                                                               
                                    <td>$<?=number_format($insumo->Costo_Venta,2);?></td>                                                                                                                                            
                                    <td>
                                        <button href="#" class="btn btn-success" onclick="configurarInsumo(<?php echo $insumo->id;?>)" data-toggle="modal" data-target="#modalActualizarCostoVenta">
                                            <span class="fa fa-edit"></span>
                                        </button>
                                    </td>

                                </tr>   
                                <?php endforeach;?>                                                              
                                <?php endif;?>                                
                            </tbody>                            
                        </table>                            
                    </div>
                </div>  
                
                <div class="row">                                        
                    <div class="col-md-12">
                        <table class="display responsive table table-bordered  btn-hover" style="width:100%" id="tbl_insumos_compras">
                            <thead>
                                <tr>
                                    <th>#</th>        
                                    <th>Plaza</th>                                                                                                                                                                                                             
                                    <th>Nombre</th>                                                                                                                                                                                 
                                    <th>Costo Venta</th>                                                                                                           
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($insumosCompras)):?>
                                <?php foreach ($insumosCompras as $insumo):?>
                                <tr>                                    
                                    <td><?=$insumo["id"];?></td>              
                                    <td><?=$insumo["Plaza"];?></td>                                                                                                     
                                    <td><?=$insumo["Nombre"];?></td>                                                                               
                                    <td>$<?=number_format($insumo["Costo_Venta"],3);?></td>                                                                                                                                                                                
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

<div class="modal fade" id="modalActualizarCostoVenta">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Modificación - Costo Venta</h4>
            </div>            
            <div class="modal-body">
            <form class="form-horizontal" method="post" id="actualizarCostoVentaInsumo" name="actualizarCostoVentaInsumo">            
            
            <input type="hidden" value="" name="insumo_id" id="insumo_id">
            
              <div class="form-group" required>
				<label for="nombre_insumo" class="col-sm-3 control-label">Nombre</label>
                <div class="col-sm-8">     
                    <input type="text" class="form-control"  id="nombre_insumo" name="nombre_insumo" readonly>                                                                          
                </div>				
              </div>
                            
              <div class="form-group" required>
				<label for="costo_venta" class="col-sm-3 control-label">Costo Venta</label>
                <div class="col-sm-8">     
                    <input type="text" class="form-control" id="costo_venta" placeholder="" name="costo_venta" required>                                                                          
                </div>				
              </div>

            </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" id="actualizar_costo_venta_insumo">Actualizar datos</button>
                </div>
            </form>
        
        </div>
    </div>
</div>

<script type="text/javascript">  
    var tbl_insumos_pedido= $('#tbl_insumos_pedido').DataTable({        
        dom: 'Bfrtip',
        "pageLength": 30,
        "paging": false,
        "searching":true,
        buttons: [                
        ],            
        responsive: true
    });

    var tbl_insumos_compras= $('#tbl_insumos_compras').DataTable({        
        dom: 'Bfrtip',
        "pageLength": 30,
        "paging": false,
        "searching":true,
        buttons: [                
        ],            
        responsive: true
    });

    $('#tbl_insumos_compras').hide();
    $('#tbl_insumos_compras_wrapper').hide();   
    $('#divBusquedaCompras').hide();  
                        
    function numberWithCommas(x) {
        var parts = x.toString().split(".");
        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        return parts.join(".");
    }
    
    $( "#actualizarCostoVentaInsumo" ).submit(function( event ) {            
            var parametros = $(this).serialize();                              

                $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>Insumos/actualizarCostoVenta",
                data: parametros,       
                dataType: "JSON",            
                success: function(response){       
                    $("#modalActualizarCostoVenta").modal('hide');                                  
                    var insumos=response.data;                     

                    tbl_insumos_pedido.clear();                                                   
                    for (let index = 0; index <insumos.length; index++) {                                                                                                        
                        var insumo_id=insumos[index]["id"];
                        var nombre_insumo=insumos[index]["Nombre"];                                                                                                  
                        var costo_venta=insumos[index]["Costo_Venta"];                         
                        costo_venta=parseFloat(costo_venta).toFixed(2);                                                                                            

                        var editar='<button href="#" class="btn btn-success" onclick="configurarInsumo('+insumo_id+')" data-toggle="modal" data-target="#modalActualizarCostoVenta"><span class="fa fa-edit"></span></button>';                        
                        tbl_insumos_pedido.row.add([insumo_id,nombre_insumo,"$"+costo_venta,editar]);                                                                                     
                    }

                    tbl_insumos_pedido.draw();                                        
                },
                error: function() { 
                    alert("Error posting feed.");
                }
            });
            event.preventDefault();
    });
    
    function configurarInsumo(insumo_id){             
        var parametros = {                
            "insumo_id":insumo_id                           
        };                         

        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>Insumos/getInsumoCostoVenta",
            data: parametros,
            dataType: "JSON",                                               
            success: function(response){ 
                $('#insumo_id').val(response[0].data[0].id);
                $('#nombre_insumo').val(response[0].data[0].Nombre);
                $('#costo_venta').val(response[0].data[0].Costo_Venta);
            },
            error: function() { 
                alert("Error posting feed.");
            }
        });      
    }    

    function hideTable(value){
        if(value==1){                        
            $('#tbl_insumos_compras').hide();
            $('#tbl_insumos_compras_wrapper').hide();
            $('#tbl_insumos_pedido').show();
            $('#tbl_insumos_pedido_wrapper').show();
            $('#divBusquedaCompras').hide();                 
        }else if(value==2){
            $('#tbl_insumos_pedido').hide();
            $('#tbl_insumos_pedido_wrapper').hide();            
            $('#tbl_insumos_compras').show();       
            $('#tbl_insumos_compras_wrapper').show();     
            $('#divBusquedaCompras').show();                 
        }
    }

    function busquedaPrecioInsumo(){        
        
        let plaza=$("#cmbPlazas").val();
        let fechaInicioBusqueda=$("#fechaInicioBusqueda").val();
        //console.log("Plaza "+plaza+" Fecha: "+fechaInicioBusqueda);

        let parametros={
            'plaza_id':plaza,
            'fechaInicioBusqueda': fechaInicioBusqueda
        }
                
        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>Insumos/getInsumosCompras",            
            data:parametros,
            dataType: "JSON",            
            success: function(response){                                             
                let data=response.insumosCompras;       

                $("#fechaInicioBusqueda").val(response.fechaInicioBusqueda);
                $("#fechaFinBusqueda").val(response.fechaFinBusqueda);

                tbl_insumos_compras.clear();                                                   
                for (let index = 0; index <data.length; index++) {                                                                                                                    
                    let id=data[index]["id"];
                    let plaza=data[index]["Plaza"];
                    let nombre=data[index]["Nombre"];
                    let costo_venta=parseFloat(data[index]["Costo_Venta"]).toFixed(3);
                    tbl_insumos_compras.row.add([id,plaza,nombre,"$"+costo_venta]);                                                                                     
                }                
                tbl_insumos_compras.draw();                                                        
            },
            error: function(xhr, desc, e) {                                 
                alert("Error posting feed.");                
            }
        });     
    }
</script>

