$('#tbl_depositos').DataTable({
    "aaSorting": [],
    dom: 'Bfrtip',
    "pageLength": 200,
    buttons: [
        {
            extend: 'excelHtml5',
            title: "Listado de Ventas",
            exportOptions: {
                columns: 'th:not(:last-child)'
            }
            
        },
        {
            extend: 'pdfHtml5',
            title: "Listado de Ventas"   ,
            exportOptions: {
                columns: 'th:not(:last-child)'
            }                     
        },
        {
            title: "Listado de Ventas"   ,
            extend:'copy',exportOptions: {
                columns: 'th:not(:last-child)'
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

$('#tbl_depositos2').DataTable({
    "aaSorting": [],
    dom: 'Bfrtip',
    "pageLength": 200,
    buttons: [
        {
            extend: 'excelHtml5',
            title: "Listado de Ventas",
            exportOptions: {
                columns: 'th:not(:last-child)'
            }
            
        },
        {
            extend: 'pdfHtml5',
            title: "Listado de Ventas"   ,
            exportOptions: {
                columns: 'th:not(:last-child)'
            }                     
        },
        {
            title: "Listado de Ventas"   ,
            extend:'copy',exportOptions: {
                columns: 'th:not(:last-child)'
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


$('#tbl_UT').DataTable({
    "aaSorting": [],
    dom: 'Bfrtip',
    "pageLength": 200,
    buttons: [
        {
            extend: 'excelHtml5',
            title: "Análisis de TP-UT",
            exportOptions: {
                columns: 'th:not(:last-child)'
            }
            
        },
        {
            extend: 'pdfHtml5',
            title: "Análisis de TP-UT",
            exportOptions: {
                columns: 'th:not(:last-child)'
            }                        
        },{
            title: "Análisis de TP-UT"   ,
            extend:'copy',
            exportOptions: {
                columns: 'th:not(:last-child)'
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

$('#tbl_usuarios').DataTable({
    "aaSorting": [],
    dom: 'Bfrtip',
    "pageLength": 100,
    buttons: [
        {
            extend: 'excelHtml5',
            title: "Tabla de Usuarios",
            exportOptions: {
                columns: 'th:not(:last-child)'
            }
            
        },
        {
            extend: 'pdfHtml5',
            title: "Tabla de Usuarios",
            exportOptions: {
                columns: 'th:not(:last-child)'
            }                        
        },{
            title: "Tabla de Usuarios"   ,
            extend:'copy',
            exportOptions: {
                columns: 'th:not(:last-child)'
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


$('#tbl_perfil').DataTable({
    dom: 'Bfrtip',
    "pageLength": 20,
    buttons: [
        {
            extend: 'excelHtml5',
            title: "Mi Perfil",
            exportOptions: {
                columns: 'th:not(:last-child)'
            }
            
        },
        {
            extend: 'pdfHtml5',
            title: "Mi Perfil",
            exportOptions: {
                columns: 'th:not(:last-child)'
            }                        
        },{
            title: "Mi Perfil"   ,
            extend:'copy',
            exportOptions: {
                columns: 'th:not(:last-child)'
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

 $('#tbl_datos').DataTable({
    dom: 'Bfrtip',
    "pageLength": 80,
    buttons: [
        {
            extend: 'excelHtml5',
            title: "Datos"            
        },
        {
            extend: 'pdfHtml5',
            title: "Datos"          
        },{
            title: "Datos"   ,
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


 


$('#tbl_unidadesFP').DataTable({
    "aaSorting": [],
    dom: 'Bfrtip',
    "pageLength": 80,
    buttons: [
        {
            extend: 'excelHtml5',
            title: "Análisis de Unidades"            
            
        },
        {
            extend: 'pdfHtml5',
            title: "Análisis de Unidades"                        
        },{
            title: "Análisis de Unidades"   ,
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



$('#tbl_analisis_remesas').DataTable({
    "aaSorting": [],
    dom: 'Bfrtip',
    "pageLength": 100,
    buttons: [
        {
            extend: 'excelHtml5',
            title: "Análisis de Remesas"
            
        },
        {
            extend: 'pdfHtml5',
            title: "Análisis de Remesas"                       
        },{
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


$('#tbl_unidades_general').DataTable({
    "aaSorting": [],
    dom: 'Bfrtip',
    "pageLength": 150,
    buttons: [
        {
            extend: 'excelHtml5',
            title: "Análisis de Unidades"
            
        },
        {
            extend: 'pdfHtml5',
            title: "Análisis de Unidades"                       
        },{
            title: "Análisis de Unidades"   ,
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



$('#tbl_inventario').DataTable({
    "aaSorting": [],
    dom: 'Bfrtip',
    "pageLength": 150,
    buttons: [
        {
            extend: 'excelHtml5',
            title: "Análisis de Inventarios"            
        },
        {
            extend: 'pdfHtml5',
            title: "Análisis de Inventarios"                       
        },{
            title: "Análisis de Inventarios"   ,
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





$('#tbl_remesas').DataTable({
    dom: 'Bfrtip',
    "pageLength": 50,
    buttons: [
        {
            extend: 'excelHtml5',
            title: "Remesas"
            
        },
        {
            extend: 'pdfHtml5',
            title: "Remesas"                       
        },{
            title: "Remesas"   ,
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


$('#tbl_gastos_diarios').DataTable({
    "aaSorting": [],
    dom: 'Bfrtip',
    "pageLength": 5,
    buttons: [
        {
            extend: 'excelHtml5',
            title: "Gastos Diarios"
            
        },
        {
            extend: 'pdfHtml5',
            title: "Gastos Diarios"                       
        },{
            title: "Ventas"   ,
            extend:'Gastos Diarios'  
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




$('#tbl_ventas').DataTable({
    "aaSorting": [],
    dom: 'Bfrtip',
    "pageLength": 10,
    buttons: [
        {
            extend: 'excelHtml5',
            title: "Ventas"
            
        },
        {
            extend: 'pdfHtml5',
            title: "Ventas"                       
        },{
            title: "Ventas"   ,
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



$('#tbl_ventas_otros').DataTable({
    "aaSorting": [],
    dom: 'Bfrtip',
    "pageLength": 5,
    buttons: [
        {
            extend: 'excelHtml5',
            title: "Listado de Ventas"
            
        },
        {
            extend: 'pdfHtml5',
            title: "Listado de Ventas"                       
        },{
            title: "Listado de Ventas"   ,
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






$('#tbl_gastos_admin').DataTable({
    "aaSorting": [],
    dom: 'Bfrtip',
    "pageLength": 200,
    buttons: [
        {
            extend: 'excelHtml5',
            title: "Remesas"            
        },
        {
            extend: 'pdfHtml5',
            title: "Remesas"                       
        },{
            title: "Remesas"   ,
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




$('#tbl_gastos').DataTable({
    "aaSorting": [],
    dom: 'Bfrtip',
    "pageLength": 10,
    buttons: [
        {
            extend: 'excelHtml5',
            title: "Gastos diarios"            
        },
        {
            extend: 'pdfHtml5',
            title: "Gastos diarios"                       
        },{
            title: "Gastos diarios"   ,
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



$('#tbl_notificaciones').DataTable({
    "aaSorting": [],
    dom: 'Bfrtip',
    "pageLength": 200,
    buttons: [
        {
            extend: 'excelHtml5',
            title: "Notificaciones"
            
        },
        {
            extend: 'pdfHtml5',
            title: "Notificaciones"                       
        },{
            title: "Notificaciones"   ,
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

$('#tbl_respaldos_inventario').DataTable({
    "aaSorting": [],
    dom: 'Bfrtip',
    "pageLength": 200,
    buttons: [
        {
            extend: 'excelHtml5',
            title: "Respaldos de Inventario"
            
        },
        {
            extend: 'pdfHtml5',
            title: "Respaldos de Inventario"                       
        },{
            title: "Respaldos de Inventario"   ,
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


$('#tbl_todas_formulas').DataTable({
    "aaSorting": [],
    dom: 'Bfrtip',
    "pageLength": 200,
    buttons: [
        {
            extend: 'excelHtml5',
            title: "Fórmulas"          
        },
        {
            extend: 'pdfHtml5',
            title: "Fórmulas"                       
        },{
            title: "Fórmulas"   ,
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

$('#tbl_fechas_quebrantos').DataTable({
    "aaSorting": [],
    dom: 'Bfrtip',
    "pageLength": 200,
    buttons: [
        {
            extend: 'excelHtml5',
            title: "Quebrantos"            
        },
        {
            extend: 'pdfHtml5',
            title: "Quebrantos"                       
        },{
            title: "Quebrantos"   ,
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


$('#tbl_comparar_ventas').DataTable({    
    dom: 'Bfrtip',
    "pageLength": 200,
    buttons: [
        {
            extend: 'excelHtml5',
            title: "Comparar Ventas"            
        },
        {
            extend: 'pdfHtml5',
            title: "Comparar Ventas"                       
        },{
            title: "Comparar Ventas"   ,
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


$('#tbl_archivos_dlc').DataTable({
    "aaSorting": [],
    dom: 'Bfrtip',
    "pageLength": 5,
    buttons: [
        {
            extend: 'excelHtml5',
            title: "Listado de envíos DLC"            
        },
        {
            extend: 'pdfHtml5',
            title: "Listado de envíos DLC"                       
        },{
            title: "Listado de envíos DLC"   ,
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








