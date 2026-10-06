    
<div class="content-wrapper">            
    <section class="content-header">
        <h1>
        Tabla de Depósitos: <?php echo $nombreTabla; ?>                                               
        </h1>
        <a href="<?php echo base_url(); ?>Depositos/panel" class="small-box-footer">Volver al Panel de Ventas <i class="fa fa-arrow-circle-right"></i></a>
    </section>            
    <section class="content">                
        <div class="box box-solid">
            <div class="box-body">
                <div class="row"> 
                    <div class="col-md-12">                           
                        <form action="<?php echo current_url();?>" method="GET" class="form-horizontal">
                            <div class="form-group">                                                                    
                                <label for="" class="col-md-1 control-label">Desde:</label>
                                <div class="col-md-3">
                                    <input type="date" class="form-control" name="fechaInicioD" id="fechaInicioD" value="<?php echo !empty($fechainicio) ? $fechainicio:'';?>">
                                </div>

                                <label for="" class="col-md-1 control-label">Hasta:</label>
                                <div class="col-md-3">
                                    <input type="date" class="form-control" name="fechaFinD" id="fechaFinD" value="<?php  echo !empty($fechafin) ? $fechafin:'';?>">
                                </div>
                                        
                                <label for="tabla_id" class="col-md-1 control-label">Tabla:</label>                                    
                                <div class="col-md-3">
                                    <select name="tabla_id" id="tabla_id" class="form-control" required>                                                  
                                                <option value="">Seleccionar Tabla</option>  
                                        <?php foreach ($nombresTablas as $plaza):?>                                                      
                                            <?php if($plaza->id==$id_tabla):?>
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
                                </div>                                                                                                  
                            </div>  

                            <div class="form-group">                                                                    
                                <label for="" style="text-align: left;" class="col-md-2 control-label">Opciones Análisis:</label>
                                <div class="col-md-9">
                                    <input type="submit" name="buscar" value="Buscar" class="btn btn-primary">                                    
                                    <input type="submit" name="buscarRangoDesglose" value="Buscar Rango Desglose" class="btn btn-danger" id="buscar_rango_depositos_list">                                                                          
                                    <button type='button' class="btn btn-primary btn-flag" data-toggle="modal" data-target="#cajaChica"><span class="fa fa-money" ></span> Caja Chica</button>
                                    <a href="<?php echo base_url(); ?>Depositos/tablaDepositos" class="btn btn-success">Restablecer</a>  
                                </div>                                                                                                                                                                                                                          
                            </div>  

                            <div class="form-group">                                                                                                            
                                <!--Etiqueta utilizada para identar los botones presentes en las operaciones de cada tabla menos en la primera debido a que no tiene operaciones-->
                                <?php if($tipoTabla!=1):?> 
                                    <label for="" style="text-align: left;" class="col-md-2 control-label">Operaciones tabla:</label>
                                <?php endif;?>
                        
                                <div class="col-md-9">
                                    <?php if($tipoTabla==1):?>                                                       
                                    <?php elseif($tipoTabla==2):?>         
                                        <button type='button' class="btn btn-primary btn-flag" data-toggle="modal" data-target="#nuevaFila"><span class="glyphicon glyphicon-plus" ></span> Agregar Fila D. Toño</button>                                                 
                                    <?php elseif($tipoTabla==3):?>                           
                                        <button type='button' class="btn btn-primary btn-flag" data-toggle="modal" data-target="#nuevaFila"><span class="glyphicon glyphicon-plus" ></span> Agregar Fila Pedro</button>                                                 
                                    <?php elseif($tipoTabla==4):?>  
                                        <button type='button' class="btn btn-primary btn-flag" data-toggle="modal" data-target="#nuevaFila"><span class="glyphicon glyphicon-plus" ></span> Agregar Fila Pepe</button>                                                                                                         
                                    <?php elseif($tipoTabla==5):?>  
                                        <button type='button' class="btn btn-primary btn-flag" data-toggle="modal" data-target="#nuevaFila"><span class="glyphicon glyphicon-plus" ></span> Agregar Fila Vic</button>                                                                                                                                  
                                    <?php elseif($tipoTabla==6):?>                               
                                        <button type='button' class="btn btn-primary btn-flag" data-toggle="modal" data-target="#nuevaFila"><span class="glyphicon glyphicon-plus" ></span> Agregar Fila Ma. Teresa</button>                                                                                                                                  
                                    <?php elseif($tipoTabla==7):?>                                                                                                                     
                                        <button type='button' class="btn btn-primary btn-flag" data-toggle="modal" data-target="#nuevaFila"><span class="glyphicon glyphicon-plus" ></span> Agregar Fila Caja Chica</button>                                                                                                                                  
                                    <?php endif;?>                                                                                         
                                </div>                                                                                                                                                                                                                          
                            </div>                                                                                                                                                                   
                        </form>                                               
                    </div>
                </div>
                    
                <div class="row">
                    <div class="col-md-12">
                        <?php 
                            $acCA=0;
                            $acMA=0;
                            $acOA=0;
                            $acPZ=0;
                            $acR1=0;
                            $acR2=0;
                            $acTZ=0;
                            $acFila=0;
                            $acTotal=0;
                        ?>

                        <!--TABLAS-->
                            <!--Tabla Fiscal-->
                            <?php if($tipoTabla==1):?>
                                <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_depositos2">
                                    <thead>
                                        <tr>     
                                            <th>Nombre</th>                                              
                                            <th>Fecha</th>
                                            <th>CA</th>
                                            <th>MA</th>
                                            <th>OA</th>
                                            <th>PZ</th>                                    
                                            <th>R1</th>   
                                            <th>R2</th>   
                                            <th>TZ</th>  
                                            <th>Totales</th>                                                                        
                                        </tr>
                                    </thead>
                                    <tbody>    
                                        <?php if(!empty($tablaDepositos)):
                                            $tempFecha="";
                                            $i=0;                                                                                      
                                        ?>

                                        <?php foreach ($tablaDepositos as $deposito):
                                            
                                            if($i == 0){
                                                $tempFecha = $deposito->Fecha;
                                            }       

                                            $acCA+=$deposito->CA;
                                            $acMA+=$deposito->MA;
                                            $acOA+=$deposito->OA;
                                            $acPZ+=$deposito->PZ;
                                            $acR1+=$deposito->R1;
                                            $acR2+=$deposito->R2;
                                            $acTZ+=$deposito->TZ;   
                                            
                                            $acFila=
                                                $deposito->CA+
                                                $deposito->MA+
                                                $deposito->OA+
                                                $deposito->PZ+
                                                $deposito->R1+
                                                $deposito->R2+
                                                $deposito->TZ;
                                        ?>
                                            <tr>
                                                <td bgcolor="#da9694"><?=$deposito->Nombre;?></td> 
                                                
                                                <?php if($tempFecha==$deposito->Fecha):?>                                        
                                                    <?php if($i==0):?>
                                                        <td bgcolor="#da9694"><?=$deposito->Fecha;?></td> 
                                                    <?php else:?>
                                                        <td bgcolor="#da9694"></td>
                                                        <?php if($tempFecha!=$deposito->Fecha): ?>
                                                            <?php $i=0;?>
                                                        <?php endif; ?>
                                                    <?php endif;?>                                                                                                                                                                         
                                                <?php else:?>
                                                    <td bgcolor="#da9694"><?=$deposito->Fecha;?></td>
                                                    <?php $tempFecha=$deposito->Fecha;?>
                                                <?php endif;?>   

                                                <td bgcolor="#fabf8f"> $ <?=number_format($deposito->CA);?></td>
                                                <td bgcolor="#8db4e2"> $ <?=number_format($deposito->MA);?></td>
                                                <td bgcolor="#fabf8f"> $ <?=number_format($deposito->OA);?></td>
                                                <td bgcolor="#8db4e2"> $ <?=number_format($deposito->PZ);?></td>
                                                <td bgcolor="#fabf8f"> $ <?=number_format($deposito->R1);?></td>
                                                <td bgcolor="#8db4e2"> $ <?=number_format($deposito->R2);?></td>
                                                <td bgcolor="#fabf8f"> $ <?=number_format($deposito->TZ);?></td>   
                                                <td bgcolor=""><b> $ <?=number_format($acFila);?></b></td>                                                                                                                                                                                                                                                                        
                                            </tr>
                                            <?php $i++;?>
                                        <?php endforeach;?> 
                                            <?php $acTotal=$acCA+$acMA+$acOA+$acPZ+$acR1+$acR2+$acTZ?> 
                                            <tr>       
                                                <td></td>                             
                                                <td><b>Totales</b></td>                                                
                                                <td><b>$ <?=number_format($acCA);?></b></td>
                                                <td><b>$ <?=number_format($acMA);?></b></td>
                                                <td><b>$ <?=number_format($acOA);?></b></td>                                    
                                                <td><b>$ <?=number_format($acPZ);?></b></td>
                                                <td><b>$ <?=number_format($acR1);?></b></td>                                                
                                                <td><b>$ <?=number_format($acR2);?></b></td>
                                                <td><b>$ <?=number_format($acTZ);?></b></td>
                                                <td bgcolor="#d1ffaf"><b>$ <?=number_format($acTotal);?></b></td>
                                                <td></td>       
                                                <td></td>                                                           
                                            </tr>
                                        <?php endif;?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      
                                    </tbody>                            
                                </table>    

                            <!--Tabla Don Toño-->    
                            <?php elseif($tipoTabla==2):?>
                                <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_depositos2">
                                    <thead>
                                        <tr>      
                                            <th>Nombre</th>                                             
                                            <th>Fecha</th>                         
                                            <th>Teziutlán</th>  
                                            <th>Editar</th>     
                                            <th>Eliminar</th>                                    
                                        </tr>
                                    </thead>
                                    <tbody>    
                                        <?php if(!empty($tablaDepositos)):$tempFecha="";$i=0;?>
                                            <?php foreach ($tablaDepositos as $deposito):
                                                if($i==0){
                                                    $tempFecha=$deposito->Fecha;
                                                }                                        
                                                $acTZ+=$deposito->TZ;                                                
                                            ?>
                                                <tr>
                                                    <td bgcolor="#da9694"><?=$deposito->Nombre;?></td> 
                                                    <?php if($tempFecha==$deposito->Fecha):?>                                        
                                                        <?php if($i==0):?>
                                                            <td bgcolor="#da9694"><?=$deposito->Fecha;?></td> 
                                                        <?php else:?>
                                                            <td bgcolor="#da9694"></td>
                                                            <?php if($tempFecha!=$deposito->Fecha): ?>
                                                                <?php $i=0;?>
                                                            <?php endif; ?>
                                                        <?php endif;?>                                                                                                                                                                         
                                                    <?php else:?>
                                                        <td bgcolor="#da9694"><?=$deposito->Fecha;?></td>
                                                        <?php $tempFecha=$deposito->Fecha;?>
                                                    <?php endif;?>      

                                                    <td bgcolor="#fabf8f"> $ <?=number_format($deposito->TZ);?></td>                                        
                                                    <td>
                                                        <a href="#"  onclick="asignarValoresTablaDepositos('<?php echo $deposito->Fecha;?>',<?php echo $deposito->id;?>,<?php echo $deposito->CA;?>,<?php echo $deposito->MA;?>,<?php echo $deposito->OA;?>,<?php echo $deposito->PZ;?>,<?php echo $deposito->R1;?>,<?php echo $deposito->R2;?>,<?php echo $deposito->TZ;?>,<?php echo $deposito->Folio;?>)" data-toggle="modal" data-target="#editarFilaTablaDepositos" class="btn btn-info">
                                                            <span class="fa fa-pencil"></span>
                                                        </a>
                                                    </td>                                         
                                                    <td>                                        
                                                        <button onclick="borrarFilaTabla(<?php echo $deposito->tabla_id;?>,<?php echo $deposito->id;?>)" class="btn btn-danger btn-remove">
                                                            <span class="fa fa-remove"></span>
                                                        </button>      
                                                    </td>                                                                                   
                                                </tr>
                                                <?php $i++;?>
                                            <?php endforeach;?>                                              
                                            <tr>  
                                                <td></td>                                  
                                                <td><b>Totales</b></td>                                                                                                                          
                                                <td><b>$ <?=number_format($acTZ);?></b></td>
                                                <td></td>       
                                                <td></td>                                                           
                                            </tr>
                                        <?php endif;?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      
                                    </tbody>                            
                                </table>    
                            
                            <!--Tabla Pedro-->
                            <?php elseif($tipoTabla==3):?>
                                <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_depositos2">
                                    <thead>
                                        <tr>      
                                            <th>Nombre</th>                                             
                                            <th>Fecha</th>                         
                                            <th>Matamoros</th>  
                                            <th>Reynosa 1</th>  
                                            <th>Totales</th>  
                                            <th>Editar</th>     
                                            <th>Eliminar</th>                                    
                                        </tr>
                                    </thead>
                                    <tbody>    
                                        <?php if(!empty($tablaDepositos)): $tempFecha = "";$i = 0;?>                                                
                                            <?php foreach ($tablaDepositos as $deposito):
                                                if($i==0){
                                                    $tempFecha = $deposito->Fecha;
                                                }  												  
                                                $acMA += $deposito->MA;
                                                $acR1 += $deposito->R1;
                                                $acFila = $deposito->MA + $deposito->R1;
                                            ?>
                                                <tr>
                                                    <td bgcolor="#da9694"><?=$deposito->Nombre;?></td> 
                                                        <?php if($tempFecha == $deposito->Fecha):?>                                        
                                                            <?php if($i == 0):?>
                                                                <td bgcolor="#da9694"><?=$deposito->Fecha;?></td> 
                                                            <?php else:?>
                                                                <td bgcolor="#da9694"></td>
                                                                <?php if($tempFecha != $deposito->Fecha): ?>
                                                                    <?php $i = 0;?>
                                                                <?php endif; ?>
                                                            <?php endif;?>                                                                                                                                                                         
                                                        <?php else:?>
                                                    <td bgcolor="#da9694"><?=$deposito->Fecha;?></td>
                                                        <?php $tempFecha = $deposito->Fecha;?>
                                                    <?php endif;?>                                                                            
                                                    <td bgcolor="#fabf8f"> $ <?=number_format($deposito->MA);?></td>                                        
                                                    <td bgcolor="#fabf8f"> $ <?=number_format($deposito->R1);?></td>                                        
                                                    <td> <b>$ <?=number_format($acFila);?></b> </td>                                        
                                                    <td>
                                                        <a href="#"  onclick="asignarValoresTablaDepositos('<?php echo $deposito->Fecha;?>',<?php echo $deposito->id;?>,<?php echo $deposito->CA;?>,<?php echo $deposito->MA;?>,<?php echo $deposito->OA;?>,<?php echo $deposito->PZ;?>,<?php echo $deposito->R1;?>,<?php echo $deposito->R2;?>,<?php echo $deposito->TZ;?>,<?php echo $deposito->Folio;?>)" data-toggle="modal" data-target="#editarFilaTablaDepositos" class="btn btn-info">
                                                            <span class="fa fa-pencil">
                                                        </span></a>
                                                    </td>                                         
                                                    <td>                                        
                                                        <button onclick="borrarFilaTablaMultiple('<?php echo $deposito->Fecha;?>',<?php echo $deposito->tabla_id;?>,<?php echo $deposito->Folio;?>)" class="btn btn-danger btn-remove">
                                                            <span class="fa fa-remove"></span>
                                                        </button>      
                                                    </td>                                                                                   
                                                </tr>
                                                <?php $i++;?>
                                            <?php endforeach;?>  
                                            <?php $acTotal = $acMA + $acR1?>  
                                            <tr>  
                                                <td></td>                                  
                                                <td><b>Totales</b></td>                                                                                            
                                                <td><b>$ <?=number_format($acMA);?></b></td>                                                                                 
                                                <td><b>$ <?=number_format($acR1);?></b></td>                                                                                 
                                                <td bgcolor="#d1ffaf"><b>$ <?=number_format($acTotal);?></b></td>                                                      
                                                <td></td>       
                                                <td></td>                                                           
                                            </tr>
                                        <?php endif;?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              
                                    </tbody>                            
                                </table>    
                            
                            <!--Tabla Pepe-->
                            <?php elseif($tipoTabla==4):?>
                                <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_depositos2">
                                    <thead>
                                        <tr>    
                                            <th>Nombre</th>                                               
                                            <th>Fecha</th>                         
                                            <th>Reynosa II</th>   
                                            <th>Editar</th>
                                            <th>Eliminar</th>                                    
                                        </tr>
                                    </thead>
                                    <tbody>    
                                        <?php if(!empty($tablaDepositos)): $tempFecha = ""; $i = 0;?>
                                            <?php foreach ($tablaDepositos as $deposito):
                                                if($i == 0){
                                                    $tempFecha = $deposito->Fecha;
                                                }  
                                                
                                                $acR2 += $deposito->R2;                                                  
                                            ?>
                                                <tr>
                                                    <td bgcolor="#da9694"><?=$deposito->Nombre;?></td> 
                                                    <?php if($tempFecha == $deposito->Fecha):?>                                        
                                                        <?php if($i == 0):?>
                                                            <td bgcolor="#da9694"><?=$deposito->Fecha;?></td> 
                                                        <?php else:?>
                                                            <td bgcolor="#da9694"></td>
                                                            <?php if($tempFecha!=$deposito->Fecha): ?>
                                                            <?php $i = 0;?>
                                                            <?php endif; ?>
                                                        <?php endif;?>                                                                                                                                                                         
                                                    <?php else:?>
                                                        <td bgcolor="#da9694"><?=$deposito->Fecha;?></td>
                                                        <?php $tempFecha = $deposito->Fecha;?>
                                                    <?php endif;?>
                                                    <td bgcolor="#fabf8f"> $ <?=number_format($deposito->R2);?></td>
                                                    <td>
                                                        <a href="#"  onclick="asignarValoresTablaDepositos('<?php echo $deposito->Fecha;?>',<?php echo $deposito->id;?>,<?php echo $deposito->CA;?>,<?php echo $deposito->MA;?>,<?php echo $deposito->OA;?>,<?php echo $deposito->PZ;?>,<?php echo $deposito->R1;?>,<?php echo $deposito->R2;?>,<?php echo $deposito->TZ;?>,<?php echo $deposito->Folio;?>)" data-toggle="modal" data-target="#editarFilaTablaDepositos" class="btn btn-info">
                                                            <span class="fa fa-pencil"></span>
                                                        </a>
                                                    </td>                                         
                                                    <td>                                        
                                                        <button onclick="borrarFilaTabla(<?php echo $deposito->tabla_id;?>,<?php echo $deposito->id;?>)" class="btn btn-danger btn-remove">
                                                            <span class="fa fa-remove"></span>
                                                        </button>      
                                                    </td>                                                                                   
                                                </tr>
                                                <?php $i++;?>
                                            <?php endforeach;?> 
                                            <tr>        
                                                <td></td>                            
                                                <td><b>Totales</b></td>                                                                                               
                                                <td><b>$ <?=number_format($acR2);?></b></td>  
                                                <td></td>       
                                                <td></td>                                                           
                                            </tr>
                                        <?php endif;?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              
                                    </tbody>                            
                                </table>                     

                            <!--Tabla Vic-->                                                        
                            <?php elseif($tipoTabla==5):?>
                                <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_depositos2">
                                    <thead>
                                        <tr>        
                                            <th>Nombre</th>                                           
                                            <th>Fecha</th>                         
                                            <th>Casitas</th>                                                  
                                            <th>Poza Rica</th>                                                  
                                            <th>Oaxaca</th>  
                                            <th>Totales</th>  
                                            <th>Editar</th>
                                            <th>Eliminar</th>                                    
                                        </tr>
                                    </thead>
                                    <tbody>    
                                        <?php if(!empty($tablaDepositos)):
                                            $tempFecha = "";
                                            $i = 0;
                                        ?>

                                            <?php foreach ($tablaDepositos as $deposito):
                                                if($i == 0){
                                                    $tempFecha=$deposito->Fecha;
                                                }          
                                                $acCA += $deposito->CA;                              
                                                $acPZ += $deposito->PZ;                              
                                                $acOA += $deposito->OA;              
                                                $acFila = $deposito->CA + $deposito->PZ + $deposito->OA;                

                                            ?>
                                                <tr>
                                                    <td bgcolor="#da9694"><?=$deposito->Nombre;?></td> 
                                                        <?php if($tempFecha == $deposito->Fecha):?>                                        
                                                            <?php if($i == 0):?>
                                                                <td bgcolor="#da9694"><?=$deposito->Fecha;?></td> 
                                                            <?php else:?>
                                                                <td bgcolor="#da9694"></td>
                                                                <?php if($tempFecha != $deposito->Fecha): ?>
                                                                    <?php $i = 0;?>
                                                                <?php endif; ?>
                                                            <?php endif;?>                                                                                                                                                                         
                                                        <?php else:?>
                                                            <td bgcolor="#da9694"><?=$deposito->Fecha;?></td>
                                                            <?php $tempFecha = $deposito->Fecha;?>
                                                        <?php endif;?>                                                                            
                                                        <td bgcolor="#fabf8f"> $ <?=number_format($deposito->CA);?></td>                                                                                                                  
                                                        <td bgcolor="#fabf8f"> $ <?=number_format($deposito->PZ);?></td>                                                                                                                  
                                                        <td bgcolor="#fabf8f"> $ <?=number_format($deposito->OA);?></td>                                                                                                                  
                                                        <td> <b>$ <?=number_format($acFila);?></b> </td>                                        
                                                    <td>
                                                        <a href="#"  onclick="asignarValoresTablaDepositos('<?php echo $deposito->Fecha;?>',<?php echo $deposito->id;?>,<?php echo $deposito->CA;?>,<?php echo $deposito->MA;?>,<?php echo $deposito->OA;?>,<?php echo $deposito->PZ;?>,<?php echo $deposito->R1;?>,<?php echo $deposito->R2;?>,<?php echo $deposito->TZ;?>,<?php echo $deposito->Folio;?>)" data-toggle="modal" data-target="#editarFilaTablaDepositos" class="btn btn-info">
                                                            <span class="fa fa-pencil"></span>
                                                        </a>
                                                    </td>                                         
                                                    <td>                                        
                                                        <button onclick="borrarFilaTablaMultiple('<?php echo $deposito->Fecha;?>',<?php echo $deposito->tabla_id;?>,<?php echo $deposito->Folio;?>)" class="btn btn-danger btn-remove">
                                                            <span class="fa fa-remove"></span>
                                                        </button>      
                                                    </td>                                                                                   
                                                </tr>                                
                                                <?php $i++;?>
                                            <?php endforeach;?>  
                                            <?php $acTotal = $acCA + $acPZ + $acOA ?>
                                            <tr>      
                                                <td></td>                              
                                                <td><b>Totales</b></td>                                                                                                
                                                <td><b>$ <?=number_format($acCA);?></b></td>                                              
                                                <td><b>$ <?=number_format($acPZ);?></b></td>                                              
                                                <td><b>$ <?=number_format($acOA);?></b></td>  
                                                <td bgcolor="#d1ffaf"><b>$ <?=number_format($acTotal);?></b></td>                                            
                                                <td></td>       
                                                <td></td>                                                           
                                            </tr>
                                        <?php endif;?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              
                                    </tbody>                            
                                </table>   

                            <!--Tabla M.Teresa-->
                            <?php elseif($tipoTabla==6):?>
                                <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_depositos2">
                                    <thead>
                                        <tr>     
                                            <th>Nombre</th>                                              
                                            <th>Fecha</th>                         
                                            <th>MA</th>
                                            <th>R1</th>
                                            <th>R2</th> 
                                            <th>Totales</th>                                                 
                                            <th>Editar</th>
                                            <th>Eliminar</th>                                    
                                        </tr>
                                    </thead>
                                    <tbody>    
                                        <?php if(!empty($tablaDepositos)):
                                            $tempFecha="";
                                            $i=0;
                                        ?>
                                            <?php foreach ($tablaDepositos as $deposito):
                                                if($i==0){
                                                    $tempFecha=$deposito->Fecha;
                                                }      

                                                $acMA+=$deposito->MA;                                                                                                                
                                                $acR1+=$deposito->R1;
                                                $acR2+=$deposito->R2; 
                                                
                                                $acFila=                                                        
                                                $deposito->MA+                                                      
                                                $deposito->R1+
                                                $deposito->R2;
                                            ?>
                                                <tr>
                                                    <td bgcolor="#da9694"><?=$deposito->Nombre;?></td> 
                                                    <?php if($tempFecha==$deposito->Fecha):?>                                        
                                                        <?php if($i==0):?>
                                                            <td bgcolor="#da9694"><?=$deposito->Fecha;?></td> 
                                                        <?php else:?>
                                                            <td bgcolor="#da9694"></td>
                                                            <?php if($tempFecha!=$deposito->Fecha): ?>
                                                                <?php $i=0;?>
                                                            <?php endif; ?>
                                                        <?php endif;?>                                                                                                                                                                         
                                                    <?php else:?>
                                                        <td bgcolor="#da9694"><?=$deposito->Fecha;?></td>
                                                        <?php $tempFecha=$deposito->Fecha;?>
                                                    <?php endif;?>                                                                            

                                                    <td bgcolor="#fabf8f"> $ <?=number_format($deposito->MA);?></td>  
                                                    <td bgcolor="#fabf8f"> $ <?=number_format($deposito->R1);?></td>  
                                                    <td bgcolor="#fabf8f"> $ <?=number_format($deposito->R2);?></td> 
                                                    <td bgcolor=""><b> $ <?=number_format($acFila);?></b></td>                                                                                                                  
                                                    <td>
                                                        <a href="#"  onclick="asignarValoresTablaDepositos('<?php echo $deposito->Fecha;?>',<?php echo $deposito->id;?>,<?php echo $deposito->CA;?>,<?php echo $deposito->MA;?>,<?php echo $deposito->OA;?>,<?php echo $deposito->PZ;?>,<?php echo $deposito->R1;?>,<?php echo $deposito->R2;?>,<?php echo $deposito->TZ;?>,<?php echo $deposito->Folio;?>)" data-toggle="modal" data-target="#editarFilaTablaDepositos" class="btn btn-info">
                                                            <span class="fa fa-pencil"></span>
                                                        </a>
                                                    </td>                                         
                                                    <td>                                        
                                                        <button onclick="borrarFilaTablaMultiple('<?php echo $deposito->Fecha;?>',<?php echo $deposito->tabla_id;?>,<?php echo $deposito->Folio;?>)" class="btn btn-danger btn-remove">
                                                            <span class="fa fa-remove"></span>
                                                        </button>      
                                                    </td>                                                                                   
                                                </tr>
                                                <?php $i++;?>
                                            <?php endforeach;?>  
                                                <?php $acTotal=$acMA+$acR1+$acR2?> 
                                                <tr> 
                                                    <td></td>                                   
                                                    <td><b>Totales</b></td>                                                                                                
                                                    <td><b>$ <?=number_format($acMA);?></b></td>                                                                                                
                                                    <td><b>$ <?=number_format($acR1);?></b></td>                                                
                                                    <td><b>$ <?=number_format($acR2);?></b></td>
                                                    <td bgcolor="#d1ffaf"><b>$ <?=number_format($acTotal);?></b></td>
                                                    
                                                    <td></td>       
                                                    <td></td>                                                           
                                                </tr>
                                        <?php endif;?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              
                                    </tbody>                            
                                </table>  

                            
                            <!--Tabla Caja Chica-->    
                            <?php elseif($tipoTabla==7):?>                            
                                <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_depositos">
                                    <thead>
                                        <tr>    
                                            <th>Nombre</th>                                    
                                            <th>Fecha</th>
                                            <th>CA</th>
                                            <th>MA</th>
                                            <th>OA</th>
                                            <th>PZ</th>                                    
                                            <th>R1</th>   
                                            <th>R2</th>   
                                            <th>TZ</th>  
                                            <th>Total</th>
                                            <th>Editar</th>     
                                            <th>Eliminar</th>                                                                      
                                        </tr>
                                    </thead>

                                    <tbody> 
                                    <?php if(!empty($cajaChica)):
                                        $tempFecha="";
                                        $i=0;
                                    ?>
                                        <?php foreach ($cajaChica as $deposito):
                                            if($i==0){
                                                $tempFecha=$deposito->Fecha;
                                            }   

                                            $acCA+=$deposito->CA;
                                            $acMA+=$deposito->MA;
                                            $acOA+=$deposito->OA;
                                            $acPZ+=$deposito->PZ;
                                            $acR1+=$deposito->R1;
                                            $acR2+=$deposito->R2;
                                            $acTZ+=$deposito->TZ; 
                                            
                                            $acFila=
                                            $deposito->CA+
                                            $deposito->MA+
                                            $deposito->OA+
                                            $deposito->PZ+
                                            $deposito->R1+
                                            $deposito->R2+
                                            $deposito->TZ;
                                        ?>
                                            <tr>
                                                <td bgcolor="#da9694"><?=$deposito->Nombre;?></td> 
                                                <?php if($tempFecha==$deposito->Fecha):?>                                        
                                                    <?php if($i==0):?>
                                                        <td bgcolor="#da9694"><?=$deposito->Fecha;?></td> 
                                                    <?php else:?>
                                                        <td bgcolor="#da9694"></td>
                                                        <?php if($tempFecha!=$deposito->Fecha): ?>
                                                            <?php $i=0;?>
                                                        <?php endif; ?>
                                                    <?php endif;?>                                                                                                                                                                         
                                                <?php else:?>
                                                    <td bgcolor="#da9694"><?=$deposito->Fecha;?></td>
                                                    <?php $tempFecha=$deposito->Fecha;?>
                                                <?php endif;?>                                        
                                                <td bgcolor="#fabf8f"> $ <?=number_format($deposito->CA);?></td>
                                                <td bgcolor="#8db4e2"> $ <?=number_format($deposito->MA);?></td>
                                                <td bgcolor="#fabf8f"> $ <?=number_format($deposito->OA);?></td>
                                                <td bgcolor="#8db4e2"> $ <?=number_format($deposito->PZ);?></td>
                                                <td bgcolor="#fabf8f"> $ <?=number_format($deposito->R1);?></td>
                                                <td bgcolor="#8db4e2"> $ <?=number_format($deposito->R2);?></td>
                                                <td bgcolor="#fabf8f"> $ <?=number_format($deposito->TZ);?></td> 
                                                <td bgcolor=""><b> $ <?=number_format($acFila);?></b></td>                                          
                                                <td>
                                                    <a href="#"  onclick="asignarValoresTablaDepositos('<?php echo $deposito->Fecha;?>',<?php echo $deposito->id;?>,<?php echo $deposito->CA;?>,<?php echo $deposito->MA;?>,<?php echo $deposito->OA;?>,<?php echo $deposito->PZ;?>,<?php echo $deposito->R1;?>,<?php echo $deposito->R2;?>,<?php echo $deposito->TZ;?>,<?php echo $deposito->Folio;?>)" data-toggle="modal" data-target="#editarFilaTablaDepositos" class="btn btn-info">
                                                        <span class="fa fa-pencil">
                                                    </span></a>
                                                </td>                                         
                                                <td>                                        
                                                    <button onclick="borrarFilaTablaMultiple('<?php echo $deposito->Fecha;?>',<?php echo $deposito->tabla_id;?>,<?php echo $deposito->Folio;?>)" class="btn btn-danger btn-remove">
                                                        <span class="fa fa-remove"></span>
                                                    </button>      
                                                </td>                                                                                   
                                            </tr>
                                            <?php $i++;?>
                                        <?php endforeach;?> 
                                        <?php $acTotal=$acCA+$acMA+$acOA+$acPZ+$acR1+$acR2+$acTZ?>  
                                            <tr>    
                                                <td></td>                                
                                                <td><b>Totales</b></td>                                                
                                                <td><b>$ <?=number_format($acCA);?></b></td>
                                                <td><b>$ <?=number_format($acMA);?></b></td>
                                                <td><b>$ <?=number_format($acOA);?></b></td>                                    
                                                <td><b>$ <?=number_format($acPZ);?></b></td>
                                                <td><b>$ <?=number_format($acR1);?></b></td>                                                
                                                <td><b>$ <?=number_format($acR2);?></b></td>
                                                <td><b>$ <?=number_format($acTZ);?></b></td>
                                                <td bgcolor="#d1ffaf"><b>$ <?=number_format($acTotal);?></b></td>
                                                <td></td>       
                                                <td></td>                                                           
                                            </tr>
                                    <?php endif;?>  
                                    </tbody>                            
                                </table>     
                            <?php endif;?>       
                        <!--./TABLAS--> 
                    </div>
                </div>                    
            </div>                                        
        </div>                
    </section>            
</div>        
    
<div class="modal fade" id="cajaChica">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">CAJA CHICA</h4>
            </div>
            <div class="modal-body">
                <table class="display responsive table table-bordered  btn-hover nowrap" style="width:100%" id="tbl_depositos">
                    <thead>
                        <tr>                                        
                            <th>Fecha</th>
                            <th>CA</th>
                            <th>MA</th>
                            <th>OA</th>
                            <th>PZ</th>                                    
                            <th>R1</th>   
                            <th>R2</th>   
                            <th>TZ</th>  
                            <th>Editar</th>     
                            <th>Eliminar</th>                                                                      
                        </tr>
                    </thead>
                    <tbody> 
                    <?php if(!empty($cajaChica)):
                                    $tempFecha="";
                                    $i=0;
                                    ?>

                                    <?php foreach ($cajaChica as $deposito):
                                        if($i==0){
                                            $tempFecha=$deposito->Fecha;
                                        }                                        
                                    ?>
                                        <tr>
                                        <?php if($tempFecha==$deposito->Fecha):?>                                        
                                        <?php if($i==0):?>
                                            <td bgcolor="#da9694"><?=$deposito->Fecha;?></td> 
                                        <?php else:?>
                                            <td bgcolor="#da9694"></td>
                                        <?php if($tempFecha!=$deposito->Fecha): ?>
                                            <?php $i=0;?>
                                        <?php endif; ?>
                                        <?php endif;?>                                                                                                                                                                         
                                        <?php else:?>
                                        <td bgcolor="#da9694"><?=$deposito->Fecha;?></td>
                                        <?php $tempFecha=$deposito->Fecha;?>
                                        <?php endif;?>                                        
                                        <td bgcolor="#fabf8f"> $ <?=number_format($deposito->CA);?></td>
                                        <td bgcolor="#8db4e2"> $ <?=number_format($deposito->MA);?></td>
                                        <td bgcolor="#fabf8f"> $ <?=number_format($deposito->OA);?></td>
                                        <td bgcolor="#8db4e2"> $ <?=number_format($deposito->PZ);?></td>
                                        <td bgcolor="#fabf8f"> $ <?=number_format($deposito->R1);?></td>
                                        <td bgcolor="#8db4e2"> $ <?=number_format($deposito->R2);?></td>
                                        <td bgcolor="#fabf8f"> $ <?=number_format($deposito->TZ);?></td>                                        
                                        <td>
                                            <a href="#"  onclick="asignarValoresTablaDepositos('<?php echo $deposito->Fecha;?>',<?php echo $deposito->id;?>,<?php echo $deposito->CA;?>,<?php echo $deposito->MA;?>,<?php echo $deposito->OA;?>,<?php echo $deposito->PZ;?>,<?php echo $deposito->R1;?>,<?php echo $deposito->R2;?>,<?php echo $deposito->TZ;?>,<?php echo $deposito->Folio;?>)" data-toggle="modal" data-target="#editarFilaTablaDepositos" class="btn btn-info">
                                                <span class="fa fa-pencil">
                                            </span></a>
                                        </td>                                         
                                        <td>                                        
                                        <button onclick="borrarFilaTablaMultiple('<?php echo $deposito->Fecha;?>',<?php echo $deposito->tabla_id;?>,<?php echo $deposito->Folio;?>)" class="btn btn-danger btn-remove">
                                                <span class="fa fa-remove"></span>
                                        </button>      
                                        </td>                                                                                   
                                        </tr>
                                        <?php $i++;?>
                                    <?php endforeach;?>  
                                <?php endif;?>  

                    </tbody>                            
                </table>                       
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cerrar</button>
            </div>
        </div>        
    </div>    
</div>

<div class="modal fade" id="nuevaFila" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Agregar nueva Fila</h4>
          </div>
          <div class="modal-body">
            <form class="form-horizontal" method="post" id="guardarFila" name="guardarFila">						
            <input type="hidden" value="<?php echo $id_tabla;?>" name="tabla_id_formulario">
            
            <div class="form-group">
                <label for="fecha_nueva_linea" class="col-sm-3 control-label">Fecha:</label>
                <div class="col-sm-8">	
                <input type="date" class="form-control" name="fecha_nueva_linea" id="fecha_nueva_linea" value="<?php echo !empty($fecha_nueva_linea) ? $fecha_nueva_linea:'';?>" required>
                </div>
            </div>
                <!-- Fiscal -->
                <?php if($tipoTabla==1):?>    
                    <div class="form-group">
                        <label for="CA" class="col-sm-3 control-label">CA:</label>
                        <div class="col-sm-8">	
                            <input type="number" class="form-control"step="0.001" id="CA" placeholder="" name="CA" value="0" required>                            
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="MA" class="col-sm-3 control-label">MA:</label>
                        <div class="col-sm-8">	
                            <input type="number" class="form-control"step="0.001" id="MA" placeholder="" name="MA" value="0" required>                            
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="OA" class="col-sm-3 control-label">OA:</label>
                        <div class="col-sm-8">	
                            <input type="number" class="form-control"step="0.001" id="OA" placeholder="" name="OA" value="0" required>                            
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="PZ" class="col-sm-3 control-label">PZ:</label>
                        <div class="col-sm-8">	
                            <input type="number" class="form-control"step="0.001" id="PZ" placeholder="" name="PZ" value="0" required>                            
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="R1" class="col-sm-3 control-label">R1:</label>
                        <div class="col-sm-8">	
                            <input type="number" class="form-control"step="0.001" id="R1" placeholder="" name="R1" value="0" required>                            
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="R2" class="col-sm-3 control-label">R2:</label>
                        <div class="col-sm-8">	
                            <input type="number" class="form-control" step="0.001" id="R2" placeholder="" name="R2" value="0" required>                            
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="TZ" class="col-sm-3 control-label">TZ:</label>
                        <div class="col-sm-8">	
                            <input type="number" class="form-control"step="0.001" id="TZ" placeholder="" name="TZ" value="0" required>                            
                        </div>
                    </div>     
                <!-- Don Toño -->
                <?php elseif($tipoTabla==2):?>  
                    <div class="form-group">
                        <label for="TZ" class="col-sm-3 control-label">TZ:</label>
                        <div class="col-sm-8">	
                            <input type="number" class="form-control"step="0.001" id="TZ" placeholder="" name="TZ" value="0" required>                            
                        </div>
                    </div>      
                <!-- Pedro -->
                <?php elseif($tipoTabla==3):?>  
                    <div class="form-group">
                        <label for="MA" class="col-sm-3 control-label">MA:</label>
                        <div class="col-sm-8">	
                            <input type="number" class="form-control"step="0.001" id="MA" placeholder="" name="MA" value="0" required>                            
                        </div>
                    </div> 
                    <div class="form-group">
                        <label for="R1" class="col-sm-3 control-label">R1:</label>
                        <div class="col-sm-8">	
                            <input type="number" class="form-control"step="0.001" id="R1" placeholder="" name="R1" value="0" required>                            
                        </div>
                    </div> 
                <!-- Pepe -->
                <?php elseif($tipoTabla==4):?>  
                    <div class="form-group">
                        <label for="R2" class="col-sm-3 control-label">R2:</label>
                        <div class="col-sm-8">	
                            <input type="number" class="form-control" step="0.001" id="R2" placeholder="" name="R2" value="0" required>                            
                        </div>
                    </div>
                <!-- VIC -->
                <?php elseif($tipoTabla==5):?>  
                    <div class="form-group">
                        <label for="PZ" class="col-sm-3 control-label">CA:</label>
                        <div class="col-sm-8">	
                            <input type="number" class="form-control"step="0.001" id="CA" placeholder="" name="CA" value="0" required>                            
                        </div>
                    </div>                    
                    <div class="form-group">
                        <label for="PZ" class="col-sm-3 control-label">PZ:</label>
                        <div class="col-sm-8">	
                            <input type="number" class="form-control"step="0.001" id="PZ" placeholder="" name="PZ" value="0" required>                            
                        </div>
                    </div>                    
                    <div class="form-group">
                        <label for="PZ" class="col-sm-3 control-label">OA:</label>
                        <div class="col-sm-8">	
                            <input type="number" class="form-control"step="0.001" id="OA" placeholder="" name="OA" value="0" required>                            
                        </div>
                    </div>
                <!-- MA. Teresa -->
                <?php elseif($tipoTabla==6):?>                               
                    <div class="form-group">
                    <label for="MA" class="col-sm-3 control-label">MA:</label>
                    <div class="col-sm-8">	
                        <input type="number" class="form-control"step="0.001" id="MA" placeholder="" name="MA" value="0" required>                            
                    </div>
                    </div>
                
                    <div class="form-group">
                    <label for="R1" class="col-sm-3 control-label">R1:</label>
                    <div class="col-sm-8">	
                        <input type="number" class="form-control"step="0.001" id="R1" placeholder="" name="R1" value="0" required>                            
                    </div>
                    </div>

                    <div class="form-group">
                    <label for="R2" class="col-sm-3 control-label">R2:</label>
                    <div class="col-sm-8">	
                        <input type="number" class="form-control" step="0.001" id="R2" placeholder="" name="R2" value="0" required>                            
                    </div>
                    </div>
                <!-- Caja chica -->
                <?php elseif($tipoTabla==7):?>                                                                                                                     
                    <div class="form-group">
                        <label for="CA" class="col-sm-3 control-label">CA:</label>
                        <div class="col-sm-8">	
                            <input type="number" class="form-control"step="0.001" id="CA" placeholder="" name="CA" value="0" required>                            
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="MA" class="col-sm-3 control-label">MA:</label>
                        <div class="col-sm-8">	
                            <input type="number" class="form-control"step="0.001" id="MA" placeholder="" name="MA" value="0" required>                            
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="OA" class="col-sm-3 control-label">OA:</label>
                        <div class="col-sm-8">	
                            <input type="number" class="form-control"step="0.001" id="OA" placeholder="" name="OA" value="0" required>                            
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="PZ" class="col-sm-3 control-label">PZ:</label>
                        <div class="col-sm-8">	
                            <input type="number" class="form-control"step="0.001" id="PZ" placeholder="" name="PZ" value="0" required>                            
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="R1" class="col-sm-3 control-label">R1:</label>
                        <div class="col-sm-8">	
                            <input type="number" class="form-control"step="0.001" id="R1" placeholder="" name="R1" value="0" required>                            
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="R2" class="col-sm-3 control-label">R2:</label>
                        <div class="col-sm-8">	
                            <input type="number" class="form-control" step="0.001" id="R2" placeholder="" name="R2" value="0" required>                            
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="TZ" class="col-sm-3 control-label">TZ:</label>
                        <div class="col-sm-8">	
                            <input type="number" class="form-control"step="0.001" id="TZ" placeholder="" name="TZ" value="0" required>                            
                        </div>
                    </div>
                <?php endif;?>              
          
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="submit" class="btn btn-primary" id="guardar_fila2">Guardar datos</button>
			</div>
          </form>
        </div>
      </div>
	</div>
</div>

<div class="modal fade" id="editarFilaTablaDepositos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Editando Fila</h4>
          </div>
          
          <div class="modal-body">
            <form class="form-horizontal" method="post" id="actualizarFila" name="actualizarFila">
                                    
            <input type="hidden" value="<?php echo $id_tabla;?>" name="tabla_id_formulario_fila">
            <input type="hidden" value="" name="code" id="code">
            <input type="hidden" value="" name="folio_actualizar" id="folio_actualizar">
            
            <div class="form-group">
                <label for="fecha_nueva_linea" class="col-sm-3 control-label">Fecha:</label>
                <div class="col-sm-8">	
                <input type="date" class="form-control" name="fecha_nueva_linea_fila" id="fecha_nueva_linea_fila" value="<?php echo !empty($fecha_nueva_linea) ? $fecha_nueva_linea:'';?>" required readonly>
                </div>
            </div>

                <?php if($tipoTabla==1):?>    
                    <div class="form-group">
                        <label for="CA_fila" class="col-sm-3 control-label">CA:</label>
                        <div class="col-sm-8">	
                            <input type="number" class="form-control"step="0.001" id="CA_fila" placeholder="" name="CA_fila" value="0" required>                            
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="MA_fila" class="col-sm-3 control-label">MA:</label>
                        <div class="col-sm-8">	
                            <input type="number" class="form-control"step="0.001" id="MA_fila" placeholder="" name="MA_fila" value="0" required>                            
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="OA_fila" class="col-sm-3 control-label">OA:</label>
                        <div class="col-sm-8">	
                            <input type="number" class="form-control"step="0.001" id="OA_fila" placeholder="" name="OA_fila" value="0" required>                            
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="PZ_fila" class="col-sm-3 control-label">PZ:</label>
                        <div class="col-sm-8">	
                            <input type="number" class="form-control"step="0.001" id="PZ_fila" placeholder="" name="PZ_fila" value="0" required>                            
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="R1_fila" class="col-sm-3 control-label">R1:</label>
                        <div class="col-sm-8">	
                            <input type="number" class="form-control"step="0.001" id="R1_fila" placeholder="" name="R1_fila" value="0" required>                            
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="R2_fila" class="col-sm-3 control-label">R2:</label>
                        <div class="col-sm-8">	
                            <input type="number" class="form-control"step="0.001" id="R2_fila" placeholder="" name="R2_fila" value="0" required>                            
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="TZ_fila" class="col-sm-3 control-label">TZ:</label>
                        <div class="col-sm-8">	
                            <input type="number" class="form-control"step="0.001" id="TZ_fila" placeholder="" name="TZ_fila" value="0" required>                            
                        </div>
                    </div>

                <?php elseif($tipoTabla==2):?>  
                     <div class="form-group">
                        <label for="TZ_fila" class="col-sm-3 control-label">TZ:</label>
                        <div class="col-sm-8">	
                            <input type="number" class="form-control"step="0.001" id="TZ_fila" placeholder="" name="TZ_fila" value="0" required>                            
                        </div>
                    </div>            
                <!-- PEDRO                -->
                <?php elseif($tipoTabla==3):?>  
                    <div class="form-group">
                        <label for="MA_fila" class="col-sm-3 control-label">MA:</label>
                        <div class="col-sm-8">	
                            <input type="number" class="form-control"step="0.001" id="MA_fila" placeholder="" name="MA_fila" value="0" required>                            
                        </div>
                    </div>                      
                    <div class="form-group">
                        <label for="R1_fila" class="col-sm-3 control-label">R1:</label>
                        <div class="col-sm-8">	
                            <input type="number" class="form-control"step="0.001" id="R1_fila" placeholder="" name="R1_fila" value="0" required>                            
                        </div>
                    </div>                      
                <!-- PEPE -->
                <?php elseif($tipoTabla==4):?>  
                    <div class="form-group">
                        <label for="R2_fila" class="col-sm-3 control-label">R2:</label>
                        <div class="col-sm-8">	
                            <input type="number" class="form-control" step="0.001" id="R2_fila" placeholder="" name="R2_fila" value="0" required>                            
                        </div>
                    </div> 
                <!-- VIC -->
                <?php elseif($tipoTabla==5):?>  
                    
                    <div class="form-group">
                        <label for="CA_fila" class="col-sm-3 control-label">CA:</label>
                        <div class="col-sm-8">	
                            <input type="number" class="form-control"step="0.001" id="CA_fila" placeholder="" name="CA_fila" value="0" required>                            
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="PZ_fila" class="col-sm-3 control-label">PZ:</label>
                        <div class="col-sm-8">	
                            <input type="number" class="form-control"step="0.001" id="PZ_fila" placeholder="" name="PZ_fila" value="0" required>                            
                        </div>
                    </div>    


                    <div class="form-group">
                        <label for="OA_fila" class="col-sm-3 control-label">OA:</label>
                        <div class="col-sm-8">	
                            <input type="number" class="form-control"step="0.001" id="OA_fila" placeholder="" name="OA_fila" value="0" required>                            
                        </div>
                    </div>

                <?php elseif($tipoTabla==6):?>                               
                    <div class="form-group">
                        <label for="MA_fila" class="col-sm-3 control-label">MA:</label>
                        <div class="col-sm-8">	
                            <input type="number" class="form-control"step="0.001" id="MA_fila" placeholder="" name="MA_fila" value="0" required>                            
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="R1_fila" class="col-sm-3 control-label">R1:</label>
                        <div class="col-sm-8">	
                            <input type="number" class="form-control"step="0.001" id="R1_fila" placeholder="" name="R1_fila" value="0" required>                            
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="R2_fila" class="col-sm-3 control-label">R2:</label>
                        <div class="col-sm-8">	
                            <input type="number" class="form-control"step="0.001" id="R2_fila" placeholder="" name="R2_fila" value="0" required>                            
                        </div>
                    </div>

                <?php elseif($tipoTabla==7):?>                                                                                                                     
                    <div class="form-group">
                        <label for="CA_fila" class="col-sm-3 control-label">CA:</label>
                        <div class="col-sm-8">	
                            <input type="number" class="form-control"step="0.001" id="CA_fila" placeholder="" name="CA_fila" value="0" required>                            
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="MA_fila" class="col-sm-3 control-label">MA:</label>
                        <div class="col-sm-8">	
                            <input type="number" class="form-control"step="0.001" id="MA_fila" placeholder="" name="MA_fila" value="0" required>                            
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="OA_fila" class="col-sm-3 control-label">OA:</label>
                        <div class="col-sm-8">	
                            <input type="number" class="form-control"step="0.001" id="OA_fila" placeholder="" name="OA_fila" value="0" required>                            
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="PZ_fila" class="col-sm-3 control-label">PZ:</label>
                        <div class="col-sm-8">	
                            <input type="number" class="form-control"step="0.001" id="PZ_fila" placeholder="" name="PZ_fila" value="0" required>                            
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="R1_fila" class="col-sm-3 control-label">R1:</label>
                        <div class="col-sm-8">	
                            <input type="number" class="form-control"step="0.001" id="R1_fila" placeholder="" name="R1_fila" value="0" required>                            
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="R2_fila" class="col-sm-3 control-label">R2:</label>
                        <div class="col-sm-8">	
                            <input type="number" class="form-control"step="0.001" id="R2_fila" placeholder="" name="R2_fila" value="0" required>                            
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="TZ_fila" class="col-sm-3 control-label">TZ:</label>
                        <div class="col-sm-8">	
                            <input type="number" class="form-control"step="0.001" id="TZ_fila" placeholder="" name="TZ_fila" value="0" required>                            
                        </div>
                    </div>
                <?php endif;?>              
          
          
		  <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary" id="actualizar_fila2">Guardar datos</button>
          </div>

          </form>
        </div>
      </div>
</div>
</div>


<script type="text/javascript">  
    //#region REGISTRAR FILA TABLA DEPÓSITOS 2DA VERSIÓN
    $( "#guardarFila" ).submit(function( event ) {            
        var parametros = $(this).serialize();                
        $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>Depositos/storeTablaDepositos",
                data: parametros,
                success: function(datos){                                                  
                    if(datos==1){                                
                        swal({
                        position: 'top-end',
                        type: 'success',
                        title: 'Registro guardado!!!',
                        showConfirmButton: false,
                        timer: 300
                        }).then(function() {                                                            
                            location.reload();
                        });	                                
                    }else if(datos==0){
                        swal({
                        type: 'error',
                        title: 'Error en el registro',
                        text: 'Ocurrio un error al registrar el depósito'                    
                        }).then(function() {                        
                            //location.reload();
                        });
                    }                                          
            },
            error: function() { 
                swal({
                    type: 'error',
                    title: 'Error desconocido',
                    text: 'Contacte al administrador '                    
                    }).then(function() {                                                        
                    });                        
                }
        });
        event.preventDefault();
    });
    //#endregion  

    //#region ACTUALIZAR FILA TABLA DE DEPÓSITOS 2DA VERSIÓN
    $( "#actualizarFila" ).submit(function( event ) {              
        var parametros = $(this).serialize();  

        $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>Depositos/actualizarTablaDepositos",
                data: parametros,
                success: function(datos){                                                
                    if(datos==1){
                        swal({
                            position: 'top-end',
                            type: 'success',
                            title: 'Registro actualizado!!!',
                            showConfirmButton: false,
                            timer: 1500
                            }).then(function() {                                                            
                                location.reload();
                        });	                            
                    }else if(datos==0){
                        swal({
                            type: 'error',
                            title: 'Error en el registro',
                            text: 'Ocurrio un error al actualizar el depósito'                    
                        }).then(function() {                        
                            //location.reload();
                        });
                    }                                          
            },
            error: function() { 
                swal({
                    type: 'error',
                    title: 'Error desconocido',
                    text: 'Contacte al administrador '                    
                    }).then(function() {                                                        
                    });                        
                }
        });
        event.preventDefault();
    });
    //#endregion  

    function asignarValoresTablaDepositos(fecha,code,CA,MA,OA,PZ,R1,R2,TZ,folio){            
        $('#fecha_nueva_linea_fila').val(fecha);
        $('#code').val(code);
        $('#CA_fila').val(CA); 
        $('#MA_fila').val(MA);
        $('#OA_fila').val(OA); 
        $('#PZ_fila').val(PZ);
        $('#R1_fila').val(R1); 
        $('#R2_fila').val(R2);
        $('#TZ_fila').val(TZ);
        $('#folio_actualizar').val(folio);
    }

    function borrarFilaTablaMultiple(fecha,tabla_id,folio){
        swal({
            title: '¿Está seguro que desea eliminar la fila',
            text: "Confirmar eliminación",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, eliminar',
            cancelButtonText: 'No, mantener'
            }).then((result) => {                                    
                if (result.value) {                                        
                    var parametros = {                        
                        "fecha" : fecha,
                        "tabla_id":tabla_id,
                        "folio":folio
                    };    

                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url();?>Depositos/deleteFilaTablaMultiple",
                        data: parametros,                          
                        success: function(data){                                                                         
                        if(data==1)
                        {
                            swal({
                                position: 'top-end',
                                type: 'success',
                                title: 'Fila eliminada!!!',
                                showConfirmButton: false,
                                timer: 1500
                                }).then(function() {                                                            
                                    location.reload();
                            });	                        
                        }
                        else if(data==0)
                        {
                            swal({
                                    position: 'top-end',
                                    type: 'error',
                                    title: 'Fila no eliminada!!',
                                    showConfirmButton: false,
                                    timer: 1500
                                    }).then(function() {                                                            
                                    //location.reload();                                             
                                });	
                        }               
                        else
                        {
                            swal({
                                    position: 'top-end',
                                    type: 'error',
                                    title: 'Error desconocido. Contacte al administrador!!',
                                    showConfirmButton: false,
                                    timer: 1500
                                    }).then(function() {                                                            
                                    location.reload();                                             
                                });	
                        } 
                        },
                        error: function() { 
                            swal({
                                    position: 'top-end',
                                    type: 'error',
                                    title: 'Error FEED desconocido. Contacte al administrador!!',
                                    showConfirmButton: false,
                                    timer: 1500
                                    }).then(function() {                                                            
                                    location.reload();                                             
                                });	 
                        }
                    });                    
                }                
            }); 
    }

    function borrarFilaTabla(tabla_id,code){
        swal({
            title: '¿Está seguro que desea eliminar la fila',
            text: "Confirmar eliminación",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, eliminar',
            cancelButtonText: 'No, mantener'
            }).then((result) => {
            if (result.value) {                    
                var parametros = {                        
                    "code" : code,
                    "tabla_id":tabla_id                     
                };                                                       
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>Depositos/deleteFilaTabla",
                    data: parametros,                          
                    success: function(data){                                                                         
                        if(data==1)
                        {
                            swal({
                                position: 'top-end',
                                type: 'success',
                                title: 'Fila eliminada!!!',
                                showConfirmButton: false,
                                timer: 1500
                                }).then(function() {                                                            
                                    location.reload();
                            });		                        
                        }
                        else if(data==0)
                        {
                            swal({
                                    position: 'top-end',
                                    type: 'error',
                                    title: 'Fila no eliminada!!',
                                    showConfirmButton: false,
                                    timer: 1500
                                    }).then(function() {                                                            
                                    //location.reload();                                             
                                });	
                        }               
                        else
                        {
                            swal({
                                    position: 'top-end',
                                    type: 'error',
                                    title: 'Error desconocido. Contacte al administrador!!',
                                    showConfirmButton: false,
                                    timer: 1500
                                    }).then(function() {                                                            
                                    location.reload();                                             
                                });	
                        } 
                    },
                    error: function() { 
                        swal({
                            position: 'top-end',
                            type: 'error',
                            title: 'Error FEED desconocido. Contacte al administrador!!',
                            showConfirmButton: false,
                            timer: 1500
                            }).then(function() {                                                            
                            location.reload();                                             
                        });	 
                    }
                });                    
            }                
        }); 
    }
</script>

    

