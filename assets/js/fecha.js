/////////////////////////ESTABLECIENDO LA FECHA EN EL REPORTE///////////////////
var date = new Date();
var day = date.getDate();
var month = date.getMonth() + 1;
var year = date.getFullYear();
if (month < 10) month = "0" + month;
if (day < 10) day = "0" + day;
var today = year + "-" + month + "-" + day;      
var today2 = year + "-" + month + "-" + (day-1);      
$("#theDate").attr("value", today);
//$("#fechaInicioD").attr("value", today2);


///////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////

