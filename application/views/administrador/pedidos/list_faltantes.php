<div class="content-wrapper">

    <section class="content-header">
        <h1>Historial de Insumos Faltantes en Pedidos Realizados
        <small>Pedidos</small></h1>
        <a href="<?php echo base_url();?>Pedidos" class="small-box-footer">Volver al Panel de Pedidos <i class="fa fa-arrow-circle-right"></i></a>                
    </section>

    <section class="content">
        <div class="box box-solid">
            <div class="box-body">       
                <div class="row">
                    <div class="col-md-12">

                        <div class="form-group">                            
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
                        </div>
                                            
                        <table class="display responsive table table-bordered  btn-hover" style="width:100%" id="tbl_insumos_faltantes_pedidos">
                        <thead>
                            <tr>                                                                        
                                <th>F.Emi</th>
                                <th>F.Rec</th>
                                <th>Fact</th>
                                <th>Plaza</th>
                                <th>Insumo</th>                                     
                                <th>C.O</th>
                                <th>C.R</th> 

                                <th>Unidad</th> 
                                <th>Bandera</th>
                                <th>Options</th> 
                                <!-- <th>Editar</th> 
                                <th>Eliminar</th>  -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($faltantes)):?>  
                            <?php foreach ($faltantes as $faltante):?>                                
                            <tr>                                                                        
                                <td><?=$faltante["Fecha"];?></td>     
                                <td><?=$faltante["Fecha_Recepcion"];?></td>                                     
                                <td><?=$faltante["Factura"];echo "<br>";echo $faltante["Factura2"];?></td>     
                                <td><?=$faltante["Plaza"];?></td>                                 
                                <td><?=$faltante["Nombre"];?></td>   
                                <td><?=$faltante["Cantidad_Pedido"];?></td>   
                                <td><?=$faltante["Cantidad_Inventario"];?></td>
                                <td><?=$faltante["Unidad"];?></td> 
                                 
                                <?php if($faltante["Bandera"]==2):?>                                
                                    <td bgcolor="#ff9393">NO LLEGO</td>
                                <?php elseif($faltante["Bandera"]==3):?>                                                                                                                                                                                                                                               
                                    <td bgcolor="#ffe495">CAPTURA MENOR A PEDIDO</td>   
                                <?php endif;?> 
                                
                                <td> 
                                    <button type="button" class="btn btn-success btn-xs" onclick="agregarInsumoPedido(<?php echo $faltante['id']?>,<?php echo $faltante['Cantidad_Pedido']?>,<?php echo $faltante['Cantidad_Inventario']?>,<?php echo $faltante['Bandera']?>,<?php echo $faltante['plaza_id']?>,<?php echo $faltante['insumo_id']?>)">
                                        <span class="fa fa-check"></span>
                                    </button>

                                    <button type="button" class="btn btn-danger btn-xs" onclick="eliminarInsumoPedido(<?php echo $faltante['id']?>)">
                                        <span class="fa fa-remove"></span>
                                    </button>
                                </td>                                         
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
    //Configuración de el datatable
    var tbl_insumos= $('#tbl_insumos_faltantes_pedidos').DataTable({
        "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
            /* Append the grade to the default row class name */                     
            //PREGUNTAMOS SI LA VARIABLE DEL TEMPORAL ES IGUAL AL VALOR DE LA CELDA   
            if (aData[8] == 'NO LLEGO'){                   
                $('td', nRow).eq(8).css('background-color','#ff9393');                                                                                                           
            }else if(aData[8] == 'CAPTURA MENOR A PEDIDO'){
                //ASIGNAMOS EL VALOR TEMPORAL Y COLOREAMOS             
                $('td', nRow).eq(8).css('background-color','#ffe495');                                                          
            }                                                                              
        }, 
        dom: 'Bfrtip',
        "aaSorting": [],
        "pageLength": 300,         
        buttons: [
            {
                extend: 'excelHtml5',
                title: "Datos Insumos Faltantes"            
            },
            {
                extend: 'pdfHtml5',
                title: "Datos Insumos Faltantes"          
            },{
                title: "Datos Insumos Faltantes"   ,
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

    //#region AL CAMBIAR EL GRUPO DE GASTOS DE REMESAS SE ACTUALIZAN LOS INSUMOS DE CADA GRUPO
    $('#cmbPlazas').change(function(){                                                                                    
        let plaza_id=$('#cmbPlazas').val();        
        consultarDatos(plaza_id);        
    });
    //#endregion

  
    function eliminarInsumoPedido(id){                    
        
        let parametros={
            id:id            
        }

        
        swal({
            title: '¿Está seguro?',
            text: "El insumo se quitará de esta lista y no será sumado al inventario de producción",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, eliminar',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.value) {                
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>Pedidos/eliminarInventarioInsumoFaltantePedido",            
                    data: parametros,
                    dataType: "JSON",            
                    success: function(response){                                                                                                                                       
                        if(response.value){                            
                            let plaza_id=$('#cmbPlazas').val();
                            consultarDatos(plaza_id);
                        }else{
                            alert(response.msj);
                        }
                    },
                    error: function(xhr, desc, e) {                                 
                        alert("Error posting feed.");                
                    }
                });                                                                                
            }                
        });                     
        
    }

    function agregarInsumoPedido(id,cantidad_pedido,cantidad_inventario,bandera,plaza_id,insumo_id){        
                        
        swal({
            title: '¿Está seguro?',
            text: "El insumo se agregará al inventario de producción",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, agregar',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.value) {

                let cantidadDisponible=cantidad_pedido-cantidad_inventario;
                let arrayOpcionesSelect=[];
                
                for (let index = 1; index <= cantidadDisponible; index++) {                                    
                    arrayOpcionesSelect[index]=index;                                            
                }
                
                Swal.fire({
                    title: 'Seleccionar',
                    input: 'select',
                    inputOptions:                
                        arrayOpcionesSelect
                    ,
                    inputPlaceholder: 'Seleccionar',
                    showCancelButton: true,
                    inputValidator: (value) => {                       

                        if (!value) {
                            return 'Necesita seleccionar algo!'
                        }else{                            

                            let parametros={
                                id:id,
                                cantidad_pedido:cantidad_pedido,
                                cantidad_inventario:cantidad_inventario,
                                bandera:bandera,
                                plaza_id:plaza_id,
                                insumo_id:insumo_id,
                                cantidad_agregar:value
                            }

                            $.ajax({
                                type: "POST",
                                url: "<?php echo base_url();?>Pedidos/agregarInventarioInsumoFaltantePedido",            
                                data: parametros,
                                dataType: "JSON",            
                                success: function(response){                                                                                                                                       
                                    if(response.value){                            
                                        let plaza_id=$('#cmbPlazas').val();
                                        consultarDatos(plaza_id);
                                    }else{
                                        alert(response.msj);
                                    }
                                },
                                error: function(xhr, desc, e) {                                 
                                    alert("Error posting feed.");                
                                }
                            });                            
                        }
                    }
                    })                                                                
            }                
        });                     
    }

    function consultarDatos(plaza_id){        
        $.ajax({
            type: "GET",
            url: "<?php echo base_url();?>Pedidos/faltantesPedidoTabla/"+plaza_id,            
            dataType: "JSON",            
            success: function(response){                             
                let data=response[0].faltantes;    
                //console.log(data);

                tbl_insumos.clear();                                                   
                for (let index = 0; index <data.length; index++) {                                                                                                
                    
                    let id=data[index]["id"];
                    let insumo_id=data[index]["insumo_id"];
                    let fecha=data[index]["Fecha"];
                    let fecha_recepcion=data[index]["Fecha_Recepcion"];
                    let factura=data[index]["Factura"];
                    let factura2=data[index]["Factura2"];
                    let plaza=data[index]["Plaza"];
                    let plaza_id=data[index]["plaza_id"];
                    let nombre=data[index]["Nombre"];
                    let cantidad_pedido=data[index]["Cantidad_Pedido"];
                    let cantidad_inventario=data[index]["Cantidad_Inventario"];
                    let unidad=data[index]["Unidad"];
                    let bandera=data[index]["Bandera"];          
                    let lblBandera="";
                    if(bandera==2){
                        lblBandera="NO LLEGO";
                    }else if(bandera==3){
                        lblBandera="CAPTURA MENOR A PEDIDO";
                    }                              
                    
                    let  btnSuccess='<button type="button" class="btn btn-success btn-xs" onclick="agregarInsumoPedido('+id+','+cantidad_pedido+','+cantidad_inventario+','+bandera+','+plaza_id+','+insumo_id+')"><span class="fa fa-check"></span></button>';
                    let  btnRemove='<button type="button" class="btn btn-danger btn-xs" onclick="eliminarInsumoPedido('+id+')"><span class="fa fa-remove"></span></button>';
                                            
                    tbl_insumos.row.add([fecha,fecha_recepcion,factura+"<br>"+factura2,plaza,nombre,cantidad_pedido,cantidad_inventario,unidad,lblBandera,btnSuccess+" "+btnRemove]);                                                                                     
                }                
                tbl_insumos.draw();                                                        
            },
            error: function(xhr, desc, e) {                                 
                alert("Error posting feed.");                
            }
        });  
    }

</script>







