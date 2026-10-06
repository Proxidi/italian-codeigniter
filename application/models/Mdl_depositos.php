<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mdl_depositos extends CI_model{
	
	public function getDepositos(){
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("r.*,u.Nombre as Usuario,p.Nombre as Plaza");
		$this->db->from("tbl_reporte_ventas r");
		$this->db->join("tbl_usuarios u","r.usuario_id = u.id");
		$this->db->join("tbl_plazas p","r.plaza_id = p.id");		
		$this->db->order_by("r.Fecha","desc");
        $resultados=$this->db->get();
        return $resultados->result();        
	}

	public function getDepositosTabla(){
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("r.*,u.Nombre as Usuario,p.Nombre as Plaza");
		$this->db->from("tbl_reporte_ventas r");
		$this->db->join("tbl_usuarios u","r.usuario_id = u.id");
		$this->db->join("tbl_plazas p","r.plaza_id = p.id");		
		$this->db->order_by("r.Fecha","desc");
		$this->db->order_by("r.plaza_id","asc");
        $resultados=$this->db->get();
        return $resultados->result();        
	}

	public function getDepositosPlaza($id_plaza){
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("r.*,u.Nombre as Usuario,p.Nombre as Plaza");
		$this->db->from("tbl_reporte_ventas r");
		$this->db->join("tbl_usuarios u","r.usuario_id = u.id");
		$this->db->join("tbl_plazas p","r.plaza_id = p.id");		
		$query=$this->db->where("r.plaza_id",$id_plaza);
		$this->db->order_by("r.Fecha","desc");
        $resultados=$this->db->get();
        return $resultados->result();        
	}


	public function getDepositosFecha($fechainicio,$fechafin){
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("r.*,u.Nombre as Usuario,p.Nombre as Plaza,p.Acronimo as Acronimo");
		$this->db->from("tbl_reporte_ventas r");
		$this->db->join("tbl_usuarios u","r.usuario_id = u.id");
		$this->db->join("tbl_plazas p","r.plaza_id = p.id");
		$query=$this->db->where("r.Fecha >=",$fechainicio);
		$query=$this->db->where("r.Fecha <=",$fechafin);		
		$this->db->order_by("r.plaza_id","asc");		
        $resultados=$this->db->get();
        return $resultados->result();  
	}

	/*public function getUnidadesGraficoPlaza($fechaInicio,$fechaFin,$plaza_id){
        $this->db->select("CONCAT(f.Nombre,' ',SUM(r.Cantidad)) as Nombre,SUM(r.Cantidad) as Cantidad");
        $this->db->from("tbl_platillos_vendidos_resumen r");        		
        $this->db->join("tbl_productos p","p.Clave = r.Clave");
        $this->db->join("tbl_familia_productos f","f.id = p.familia_id");        
        $query=$this->db->where("r.Fecha >=",$fechaInicio);	
        $query=$this->db->where("r.Fecha <=",$fechaFin);	
        $query=$this->db->where("r.plaza_id",$plaza_id);	        
        $this->db->group_by('f.Nombre'); 	
        $resultados=$this->db->get();
        //echo json_encode($resultados->result())
        return $resultados->result();  
	}*/

	
	//GRAFICANDO LA GRAFICA EN FORMA DE PIE 
	public function getDepositosFechaGrafico($fechainicio,$fechafin){
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("p.Nombre as Nombre,SUM(r.Total_Ingresos) as Ingresos");
		$this->db->from("tbl_reporte_ventas r");
		$this->db->join("tbl_usuarios u","r.usuario_id = u.id");
		$this->db->join("tbl_plazas p","r.plaza_id = p.id");
		$query=$this->db->where("r.Fecha >=",$fechainicio);
		$query=$this->db->where("r.Fecha <=",$fechafin);		
		$this->db->group_by('r.plaza_id'); 	
		$this->db->order_by("r.plaza_id","asc");		
        $resultados=$this->db->get();
        return $resultados->result();  
	}

	//GRAFICANDO LA GRAFICA EN FORMA DE PIE 
	public function getDepositosFechaGrafico2($fechainicio,$fechafin,$campo){
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("p.Nombre as Nombre,SUM(r.{$campo}) as Ingresos");
		$this->db->from("tbl_reporte_ventas r");
		$this->db->join("tbl_usuarios u","r.usuario_id = u.id");
		$this->db->join("tbl_plazas p","r.plaza_id = p.id");
		$query=$this->db->where("r.Fecha >=",$fechainicio);
		$query=$this->db->where("r.Fecha <=",$fechafin);		
		$this->db->group_by('r.plaza_id'); 	
		$this->db->order_by("r.plaza_id","asc");		
        $resultados=$this->db->get();
        return $resultados->result();  
	}


	//GRAFICANDO LA GRAFICA EN FORMA DE PIE 
	public function getDepositosFechaGraficoPlaza22($fechainicio,$fechafin,$plaza_id,$campo){
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("p.Nombre as Nombre,SUM(r.{$campo}) as Ingresos");
		$this->db->from("tbl_reporte_ventas r");
		$this->db->join("tbl_usuarios u","r.usuario_id = u.id");
		$this->db->join("tbl_plazas p","r.plaza_id = p.id");
		$query=$this->db->where("r.Fecha >=",$fechainicio);
		$query=$this->db->where("r.Fecha <=",$fechafin);		
		$query=$this->db->where("r.plaza_id",$plaza_id);		
		$this->db->group_by('r.plaza_id'); 	
		$this->db->order_by("r.plaza_id","asc");		
		$resultados=$this->db->get();
		return $resultados->result();  
	}

	//GRAFICANDO LA GRAFICA EN FORMA DE PIE 
	public function getDepositosFechaGraficoPlaza22Meses($fechainicio,$fechafin,$plaza_id,$campo){
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("MONTHNAME(r.Fecha) as Nombre,SUM(r.{$campo}) as Ingresos");
		$this->db->from("tbl_reporte_ventas r");
		$this->db->join("tbl_usuarios u","r.usuario_id = u.id");
		$this->db->join("tbl_plazas p","r.plaza_id = p.id");
		$query=$this->db->where("r.Fecha >=",$fechainicio);
		$query=$this->db->where("r.Fecha <=",$fechafin);		
		$query=$this->db->where("r.plaza_id",$plaza_id);		
		$this->db->group_by('MONTHNAME(r.Fecha),r.plaza_id'); 	
		$this->db->order_by("MONTH(r.Fecha)");		
		$resultados=$this->db->get();
		return $resultados->result();  
	}



	//GRAFICANDO LA GRAFICA DE BARRAS 
	public function getDepositosFechaGraficoPlaza($fechainicio,$fechafin,$plaza_id){
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("MONTHNAME(r.Fecha) as Nombre,SUM(r.Total_Ingresos) as Ingresos");
		$this->db->from("tbl_reporte_ventas r");
		$this->db->join("tbl_usuarios u","r.usuario_id = u.id");
		$this->db->join("tbl_plazas p","r.plaza_id = p.id");
		$query=$this->db->where("r.Fecha >=",$fechainicio);
		$query=$this->db->where("r.Fecha <=",$fechafin);
		$query=$this->db->where("r.plaza_id",$plaza_id);
		$this->db->group_by('MONTHNAME(r.Fecha),r.plaza_id'); 			
		$this->db->order_by("MONTH(r.Fecha)");		
        $resultados=$this->db->get();
        return $resultados->result();  
	}

	//GRAFICANDO LA GRAFICA DE BARRAS 
	public function getDepositosFechaGraficoPlaza2($fechainicio,$fechafin,$plaza_id,$campo){
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("MONTHNAME(r.Fecha) as Nombre,SUM(r.{$campo}) as Ingresos");
		$this->db->from("tbl_reporte_ventas r");
		$this->db->join("tbl_usuarios u","r.usuario_id = u.id");
		$this->db->join("tbl_plazas p","r.plaza_id = p.id");
		$query=$this->db->where("r.Fecha >=",$fechainicio);
		$query=$this->db->where("r.Fecha <=",$fechafin);
		$query=$this->db->where("r.plaza_id",$plaza_id);
		$this->db->group_by('MONTHNAME(r.Fecha),r.plaza_id'); 			
		$this->db->order_by("MONTH(r.Fecha)");		
		$resultados=$this->db->get();
		return $resultados->result();  
	}

	
	//GRAFICANDO LA GRAFICA DE BARRAS 
	public function getDepositosFechaGraficoPlazaDias($fechainicio,$fechafin,$plaza_id){
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("DAYOFMONTH(r.Fecha) as Nombre,SUM(r.Total_Ingresos) as Ingresos");
		$this->db->from("tbl_reporte_ventas r");
		$this->db->join("tbl_usuarios u","r.usuario_id = u.id");
		$this->db->join("tbl_plazas p","r.plaza_id = p.id");
		$query=$this->db->where("r.Fecha >=",$fechainicio);
		$query=$this->db->where("r.Fecha <=",$fechafin);
		$query=$this->db->where("r.plaza_id",$plaza_id);
		$this->db->group_by('DAYOFMONTH(r.Fecha),r.plaza_id'); 			
		$this->db->order_by("DAY(r.Fecha)");		
        $resultados=$this->db->get();
        return $resultados->result();  
	}

	//GRAFICANDO LA GRAFICA DE BARRAS 
	public function getDepositosFechaGraficoPlazaDias2($fechainicio,$fechafin,$plaza_id,$campo){
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("DAYOFMONTH(r.Fecha) as Nombre,SUM(r.{$campo}) as Ingresos");
		$this->db->from("tbl_reporte_ventas r");
		$this->db->join("tbl_usuarios u","r.usuario_id = u.id");
		$this->db->join("tbl_plazas p","r.plaza_id = p.id");
		$query=$this->db->where("r.Fecha >=",$fechainicio);
		$query=$this->db->where("r.Fecha <=",$fechafin);
		$query=$this->db->where("r.plaza_id",$plaza_id);
		$this->db->group_by('DAYOFMONTH(r.Fecha),r.plaza_id'); 			
		$this->db->order_by("DAY(r.Fecha)");		
        $resultados=$this->db->get();
        return $resultados->result();  
	}


	//GRAFICANDO LA GRAFICA DE BARRAS 
	public function getDepositosFechaGraficoPlazaDia($fechainicio,$fechafin,$plaza_id){
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("p.Nombre as Nombre,SUM(r.Total_Ingresos) as Ingresos");
		$this->db->from("tbl_reporte_ventas r");
		$this->db->join("tbl_usuarios u","r.usuario_id = u.id");
		$this->db->join("tbl_plazas p","r.plaza_id = p.id");
		$query=$this->db->where("r.Fecha >=",$fechainicio);
		$query=$this->db->where("r.Fecha <=",$fechafin);
		$query=$this->db->where("r.plaza_id",$plaza_id);
		$this->db->group_by('r.plaza_id'); 			
		$this->db->order_by("r.plaza_id");		
        $resultados=$this->db->get();
        return $resultados->result();  
	}


	//GRAFICANDO LA GRAFICA DE BARRAS 
	public function getDepositosFechaGraficoPlazaDia2($fechainicio,$fechafin,$plaza_id,$campo){
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("p.Nombre as Nombre,SUM(r.{$campo}) as Ingresos");
		$this->db->from("tbl_reporte_ventas r");
		$this->db->join("tbl_usuarios u","r.usuario_id = u.id");
		$this->db->join("tbl_plazas p","r.plaza_id = p.id");
		$query=$this->db->where("r.Fecha >=",$fechainicio);
		$query=$this->db->where("r.Fecha <=",$fechafin);
		$query=$this->db->where("r.plaza_id",$plaza_id);
		$this->db->group_by('r.plaza_id'); 			
		$this->db->order_by("r.plaza_id");		
        $resultados=$this->db->get();
        return $resultados->result();  
	}
	
	
	public function getIngresosFecha($fechainicio,$fechafin){
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("r.*,p.Nombre,r.Total_Ingresos");
		$this->db->from("tbl_reporte_ventas r");
		$this->db->join("tbl_usuarios u","r.usuario_id = u.id");
		$this->db->join("tbl_plazas p","r.plaza_id = p.id");
		$query=$this->db->where("r.Fecha >=",$fechainicio);
		$query=$this->db->where("r.Fecha <=",$fechafin);		
		$this->db->order_by("r.Fecha","desc");		
        $resultados=$this->db->get();
        return $resultados->result();  
	}

	public function getIngresosFechaRango($fechainicio,$fechafin){
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("r.*,p.Nombre,SUM(r.Total_Ingresos) as Total_Ingresos");
		$this->db->from("tbl_reporte_ventas r");
		$this->db->join("tbl_usuarios u","r.usuario_id = u.id");
		$this->db->join("tbl_plazas p","r.plaza_id = p.id");
		$query=$this->db->where("r.Fecha >=",$fechainicio);
		$query=$this->db->where("r.Fecha <=",$fechafin);		
		$this->db->order_by("r.plaza_id","asc");
		$this->db->group_by('r.plaza_id'); 		
        $resultados=$this->db->get();
        return $resultados->result();  
	}


	
	public function getIngresosFechaPlaza($fechainicio,$fechafin,$plaza_id){
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("r.*,p.Nombre,r.Total_Ingresos");
		$this->db->from("tbl_reporte_ventas r");
		$this->db->join("tbl_usuarios u","r.usuario_id = u.id");
		$this->db->join("tbl_plazas p","r.plaza_id = p.id");
		$query=$this->db->where("r.Fecha >=",$fechainicio);
		$query=$this->db->where("r.Fecha <=",$fechafin);	
		$query=$this->db->where("r.plaza_id",$plaza_id);	
		$this->db->order_by("r.Fecha","desc");		
        $resultados=$this->db->get();
        return $resultados->result();  
	}

	public function getIngresosFechaRangoPlaza($fechainicio,$fechafin,$plaza_id){
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("r.*,p.Nombre,SUM(r.Total_Ingresos) as Total_Ingresos");
		$this->db->from("tbl_reporte_ventas r");
		$this->db->join("tbl_usuarios u","r.usuario_id = u.id");
		$this->db->join("tbl_plazas p","r.plaza_id = p.id");
		$query=$this->db->where("r.Fecha >=",$fechainicio);
		$query=$this->db->where("r.Fecha <=",$fechafin);	
		$query=$this->db->where("r.plaza_id",$plaza_id);	
		$this->db->order_by("r.plaza_id","asc");
		$this->db->group_by('r.plaza_id'); 		
        $resultados=$this->db->get();
        return $resultados->result();  
	}





	public function getDepositosFechaPlaza($fechainicio,$fechafin,$id_plaza){
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("r.*,u.Nombre as Usuario,p.Nombre as Plaza,p.Acronimo as Acronimo");
		$this->db->from("tbl_reporte_ventas r");
		$this->db->join("tbl_usuarios u","r.usuario_id = u.id");
		$this->db->join("tbl_plazas p","r.plaza_id = p.id");
		$query=$this->db->where("r.Fecha >=",$fechainicio);
		$query=$this->db->where("r.Fecha <=",$fechafin);		
		$query=$this->db->where("r.plaza_id",$id_plaza);
		$this->db->order_by("r.Fecha","desc");		
        $resultados=$this->db->get();
        return $resultados->result();  
	}
	
	//SELECT word, SUM(amount) 
	//FROM Data 
	//Group By word


	public function getDepositosGeneral(){
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("r.*,
		SUM(r.Deposito) as SumaDeposito,
		SUM(r.Efectivo_Real) as SumaEfectivo,
		SUM(r.Total_Ventas) as SumaVentasC,
		SUM(r.Total_Ingresos) as SumaTotalV,
		SUM(r.TPV) as SumaTPV,
		SUM(r.Gastos) as SumaGastos,		
		u.Nombre as Usuario,p.Nombre as Plaza");
		$this->db->from("tbl_reporte_ventas r");
		$this->db->join("tbl_usuarios u","r.usuario_id = u.id");
		$this->db->join("tbl_plazas p","r.plaza_id = p.id");		
		$this->db->group_by('Plaza'); 
		$this->db->order_by("r.Fecha","asc");
        $resultados=$this->db->get();
        return $resultados->result();        
	}


	
	public function getDepositosGeneralFecha($fechainicio,$fechafin){
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("r.*,
		SUM(r.Deposito) as SumaDeposito,
		SUM(r.Efectivo_Real) as SumaEfectivo,
		SUM(r.Total_Ventas) as SumaVentasC,
		SUM(r.Total_Ingresos) as SumaTotalV,
		SUM(r.TPV) as SumaTPV,
		SUM(r.Gastos) as SumaGastos,
		u.Nombre as Usuario,p.Nombre as Plaza");
		$this->db->from("tbl_reporte_ventas r");
		$this->db->join("tbl_usuarios u","r.usuario_id = u.id");
		$this->db->join("tbl_plazas p","r.plaza_id = p.id");
		$query=$this->db->where("r.Fecha >=",$fechainicio);
		$query=$this->db->where("r.Fecha <=",$fechafin);			
		$this->db->group_by('Plaza'); 
        $resultados=$this->db->get();
        return $resultados->result();        
	}

	public function getDepositosGeneralFechaAnalisis($fechainicio,$fechafin){		
		$this->db->select("r.*,
		SUM(r.Deposito) as SumaDeposito,
		SUM(r.Efectivo_Real) as SumaEfectivo,
		SUM(r.Total_Ventas) as SumaVentasC,
		SUM(r.Total_Ingresos) as SumaTotalV,
		SUM(r.TPV) as SumaTPV,
		SUM(r.Gastos) as SumaGastos,
		SUM(r.Gastos_Admin) as SumaGastosAdmin,
		SUM(r.Total_Gastos) as SumaGastosTodos,
		u.Nombre as Usuario,p.Nombre as Plaza");
		$this->db->from("tbl_reporte_ventas r");
		$this->db->join("tbl_usuarios u","r.usuario_id = u.id");
		$this->db->join("tbl_plazas p","r.plaza_id = p.id");
		$query=$this->db->where("r.Fecha >=",$fechainicio);
		$query=$this->db->where("r.Fecha <=",$fechafin);			
		$this->db->group_by('Plaza'); 
        $resultados=$this->db->get();
        return $resultados->result();        
	}

	public function getDepositosGeneralFechaPlazaAnalisis($fechainicio,$fechafin,$plaza_id){		
		$this->db->select("r.*,
		SUM(r.Deposito) as SumaDeposito,
		SUM(r.Efectivo_Real) as SumaEfectivo,
		SUM(r.Total_Ventas) as SumaVentasC,
		SUM(r.Total_Ingresos) as SumaTotalV,
		SUM(r.TPV) as SumaTPV,
		SUM(r.Gastos) as SumaGastos,
		SUM(r.Gastos_Admin) as SumaGastosAdmin,
		SUM(r.Total_Gastos) as SumaGastosTodos,
		u.Nombre as Usuario,p.Nombre as Plaza");
		$this->db->from("tbl_reporte_ventas r");
		$this->db->join("tbl_usuarios u","r.usuario_id = u.id");
		$this->db->join("tbl_plazas p","r.plaza_id = p.id");
		$query=$this->db->where("r.Fecha >=",$fechainicio);
		$query=$this->db->where("r.Fecha <=",$fechafin);	
		$query=$this->db->where("r.plaza_id",$plaza_id);	
		$this->db->group_by('Plaza'); 
        $resultados=$this->db->get();
        return $resultados->result();        
	}




	public function getDepositosGeneralFechaDesglose($fechainicio,$fechafin){
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("r.*,
		SUM(r.Deposito) as SumaDeposito,
		SUM(r.Efectivo_Real) as SumaEfectivo,
		SUM(r.Total_Ventas) as SumaVentasC,
		SUM(r.Total_Ingresos) as SumaTotalV,
		SUM(r.TPV) as SumaTPV,
		SUM(r.Gastos) as SumaGastos,
		u.Nombre as Usuario,p.Nombre as Plaza,
		p.Acronimo as Acronimo
		");
		$this->db->from("tbl_reporte_ventas r");
		$this->db->join("tbl_usuarios u","r.usuario_id = u.id");
		$this->db->join("tbl_plazas p","r.plaza_id = p.id");
		$query=$this->db->where("r.Fecha >=",$fechainicio);
		$query=$this->db->where("r.Fecha <=",$fechafin);		
		$this->db->group_by("r.plaza_id,r.Fecha");				
        $resultados=$this->db->get();
        return $resultados->result();        
	}

	public function getDepositosGeneralFechaDesgloseAnalisis($fechainicio,$fechafin){
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("r.*,
		SUM(r.Deposito) as SumaDeposito,
		SUM(r.Efectivo_Real) as SumaEfectivo,
		SUM(r.Total_Ventas) as SumaVentasC,
		SUM(r.Total_Ingresos) as SumaTotalV,
		SUM(r.TPV) as SumaTPV,
		SUM(r.Gastos) as SumaGastos,
		SUM(r.Gastos_Admin) as SumaGastosAdmin,
		SUM(r.Total_Gastos) as SumaGastosTodos,
		u.Nombre as Usuario,p.Nombre as Plaza
		,p.Acronimo as Acronimo
		");
		$this->db->from("tbl_reporte_ventas r");
		$this->db->join("tbl_usuarios u","r.usuario_id = u.id");
		$this->db->join("tbl_plazas p","r.plaza_id = p.id");
		$query=$this->db->where("r.Fecha >=",$fechainicio);
		$query=$this->db->where("r.Fecha <=",$fechafin);		
		$this->db->group_by("r.plaza_id,r.Fecha");				
        $resultados=$this->db->get();
        return $resultados->result();        
	}

	public function getDepositosGeneralFechaDesglosePlazaAnalisis($fechainicio,$fechafin,$plaza_id){
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("r.*,
		SUM(r.Deposito) as SumaDeposito,
		SUM(r.Efectivo_Real) as SumaEfectivo,
		SUM(r.Total_Ventas) as SumaVentasC,
		SUM(r.Total_Ingresos) as SumaTotalV,
		SUM(r.TPV) as SumaTPV,
		SUM(r.Gastos) as SumaGastos,
		SUM(r.Gastos_Admin) as SumaGastosAdmin,
		SUM(r.Total_Gastos) as SumaGastosTodos,
		u.Nombre as Usuario,p.Nombre as Plaza
		,p.Acronimo as Acronimo
		");
		$this->db->from("tbl_reporte_ventas r");
		$this->db->join("tbl_usuarios u","r.usuario_id = u.id");
		$this->db->join("tbl_plazas p","r.plaza_id = p.id");
		$query=$this->db->where("r.Fecha >=",$fechainicio);
		$query=$this->db->where("r.Fecha <=",$fechafin);	
		$query=$this->db->where("r.plaza_id",$plaza_id);	
		$this->db->group_by("r.Fecha,r.plaza_id");				
        $resultados=$this->db->get();
        return $resultados->result();        
	}




	public function getDepositosGeneralFechaPlaza($fechainicio,$fechafin,$id_plaza){
			//Aquí se valida que la categoria se encuentre activa
			$this->db->select("r.*,
			SUM(r.Deposito) as SumaDeposito,
			SUM(r.Efectivo_Real) as SumaEfectivo,
			SUM(r.Total_Ventas) as SumaVentasC,
			SUM(r.Total_Ingresos) as SumaTotalV,
			SUM(r.TPV) as SumaTPV,
			SUM(r.Gastos) as SumaGastos,
			u.Nombre as Usuario,p.Nombre as Plaza");
			$this->db->from("tbl_reporte_ventas r");
			$this->db->join("tbl_usuarios u","r.usuario_id = u.id");
			$this->db->join("tbl_plazas p","r.plaza_id = p.id");
			$query=$this->db->where("r.Fecha >=",$fechainicio);
			$query=$this->db->where("r.Fecha <=",$fechafin);
			$query=$this->db->where("r.plaza_id",$id_plaza);
			$this->db->group_by('Plaza'); 
			$resultados=$this->db->get();
			return $resultados->result();          
	}


	public function getDepositosGeneralFechaPlazaDesglose($fechainicio,$fechafin,$id_plaza){
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("r.*,	u.Nombre as Usuario,p.Nombre as Plaza,p.Acronimo as Acronimo");
		$this->db->from("tbl_reporte_ventas r");
		$this->db->join("tbl_usuarios u","r.usuario_id = u.id");
		$this->db->join("tbl_plazas p","r.plaza_id = p.id");
		$query=$this->db->where("r.Fecha >=",$fechainicio);
		$query=$this->db->where("r.Fecha <=",$fechafin);	
		$query=$this->db->where("r.plaza_id",$id_plaza);		
		$this->db->order_by("r.Fecha","asc");
        $resultados=$this->db->get();
        return $resultados->result();        
	}




	public function years(){
		$this->db->select("YEAR(Fecha) as year");
		$this->db->from("tbl_reporte_ventas");
		$this->db->group_by("year");
		$this->db->order_by("year","desc");
		$resultados=$this->db->get();
		return $resultados->result();
	}

	public function months(){		
		$this->db->select("DATE_FORMAT(Fecha,'%M') as month");
		$this->db->from("tbl_reporte_ventas");
		$this->db->group_by("month");
		$this->db->order_by("month","desc");
		$resultados=$this->db->get();
		return $resultados->result();
	}

	public function days(){
		$this->db->select("DAY(Fecha) as day");
		$this->db->from("tbl_reporte_ventas");
		$this->db->group_by("day");
		$this->db->order_by("day","desc");
		$resultados=$this->db->get();
		return $resultados->result();
	}
	
	public function montos($year,$month,$day){
		$this->db->select("DAY(r.Fecha) as dia,MONTH(r.Fecha) as mes,SUM(r.Deposito) as monto,SUM(r.Efectivo_Real) as monto2,p.Nombre as plaza");
		$this->db->from("tbl_reporte_ventas r");
		$this->db->join("tbl_plazas p","r.plaza_id = p.id");
		$this->db->where("r.Fecha >=",$year."-".$month."-".$day);		
		$this->db->group_by("plaza");
		$this->db->order_by("dia","asc");
		$resultados=$this->db->get();
		return $resultados->result();
	}



	public function getTickets($fechainicio,$fechafin){
		$this->db->select("r.*,r.Fecha as Fecha,u.Nombre as Usuario,p.Nombre as Plaza,r.Tickets as Tickets,r.TP as TP");
		$this->db->from("tbl_tickets r");
		$this->db->join("tbl_usuarios u","r.usuario_id = u.id");
		$this->db->join("tbl_plazas p","r.plaza_id = p.id");			
		$query=$this->db->where("r.Fecha >=",$fechainicio);
		$query=$this->db->where("r.Fecha <=",$fechafin);
		$this->db->order_by("r.plaza_id","asc");	
		$this->db->group_by("r.plaza_id,r.Fecha");	
        $resultados=$this->db->get();
        return $resultados->result();
	}


	public function getTicketsRango($fechainicio,$fechafin){
		$this->db->select("	
		r.*,
		r.Fecha as Fecha,
		u.Nombre as Usuario,
		p.Nombre as Plaza,
		SUM(r.Tickets) as Tickets,
		SUM(r.Tickets_Comedor) as Tickets_Comedor,
		AVG(r.Porcentaje_Comedor) as Porcentaje_Comedor,
		SUM(r.Tickets_Llevar) as Tickets_Llevar,
		AVG(r.Porcentaje_Llevar) as Porcentaje_Llevar,
		AVG(r.TP) as TP,
		SUM(r.Unidades) as Unidades,
		AVG(r.UT) as UT
		");

		$this->db->from("tbl_tickets r");
		$this->db->join("tbl_usuarios u","r.usuario_id = u.id");
		$this->db->join("tbl_plazas p","r.plaza_id = p.id");				
		$query=$this->db->where("r.Fecha >=",$fechainicio);
		$query=$this->db->where("r.Fecha <=",$fechafin);	
		$this->db->group_by("r.plaza_id");	
        $resultados=$this->db->get();
        return $resultados->result();
	}
	

	public function getTicketsRangoDesglose($fechainicio,$fechafin){
		$this->db->select("
		r.*,
		r.Fecha as Fecha,
		u.Nombre as Usuario,
		p.Nombre as Plaza,
		SUM(r.Tickets) as Tickets,
		SUM(r.Tickets_Comedor) as Tickets_Comedor,
		SUM(r.Porcentaje_Comedor) as Porcentaje_Comedor,
		SUM(r.Tickets_Llevar) as Tickets_Llevar,
		SUM(r.Porcentaje_Llevar) as Porcentaje_Llevar,
		SUM(r.TP) as TP,
		SUM(r.Unidades) as Unidades,
		SUM(r.UT) as UT
		");
		$this->db->from("tbl_tickets r");
		$this->db->join("tbl_usuarios u","r.usuario_id = u.id");
		$this->db->join("tbl_plazas p","r.plaza_id = p.id");				
		$this->db->group_by("r.Fecha,r.plaza_id");	
		$query=$this->db->where("r.Fecha >=",$fechainicio);
		$query=$this->db->where("r.Fecha <=",$fechafin);			
		$this->db->order_by("r.plaza_id","asc");
		$this->db->order_by("r.Fecha","asc");		
        $resultados=$this->db->get();
        return $resultados->result();
	}

	public function getTicketsPlaza($fechainicio,$fechafin,$plaza_id){
		$this->db->select("
		r.*,
		r.Fecha as Fecha,
		u.Nombre as Usuario,
		p.Nombre as Plaza,
		r.Tickets as Tickets,
		r.Tickets_Comedor as Tickets_Comedor,
		r.Porcentaje_Comedor as Porcentaje_Comedor,
		r.Tickets_Llevar as Tickets_Llevar,
		r.Porcentaje_Llevar as Porcentaje_Llevar,
		r.TP as TP,
		r.Unidades as Unidades,
		r.UT as UT");
		$this->db->from("tbl_tickets  r");
		$this->db->join("tbl_usuarios u","r.usuario_id = u.id");
		$this->db->join("tbl_plazas p","r.plaza_id = p.id");				
		$this->db->group_by("r.Fecha,r.plaza_id");	
		$query=$this->db->where("r.plaza_id",$plaza_id);	
		$query=$this->db->where("r.Fecha >=",$fechainicio);
		$query=$this->db->where("r.Fecha <=",$fechafin);	
        $resultados=$this->db->get();
        return $resultados->result();
	}

	public function getTicketsPlazaRango($fechainicio,$fechafin,$plaza_id){
		$this->db->select("
		r.*,
		r.Fecha as Fecha,
		u.Nombre as Usuario,
		p.Nombre as Plaza,
		SUM(r.Tickets) as Tickets,
		SUM(r.Tickets_Comedor) as Tickets_Comedor,
		AVG(r.Porcentaje_Comedor) as Porcentaje_Comedor,
		SUM(r.Tickets_Llevar) as Tickets_Llevar,
		AVG(r.Porcentaje_Llevar) as Porcentaje_Llevar,
		SUM(r.TP) as TP,
		SUM(r.Unidades) as Unidades,
		AVG(r.UT) as UT		
		");
		$this->db->from("tbl_tickets  r");
		$this->db->join("tbl_usuarios u","r.usuario_id = u.id");
		$this->db->join("tbl_plazas p","r.plaza_id = p.id");				
		$this->db->group_by("r.plaza_id");	
		$query=$this->db->where("r.plaza_id",$plaza_id);
		$query=$this->db->where("r.Fecha >=",$fechainicio);
		$query=$this->db->where("r.Fecha <=",$fechafin);	
        $resultados=$this->db->get();
        return $resultados->result();
	}

	public function getTicketsPlazaRangoDesglose($fechainicio,$fechafin,$plaza_id){
		$this->db->select("
		r.*,
		r.Fecha as Fecha,
		u.Nombre as Usuario,
		p.Nombre as Plaza,
		SUM(r.Tickets) as Tickets,
		SUM(r.Tickets_Comedor) as Tickets_Comedor,
		SUM(r.Porcentaje_Comedor) as Porcentaje_Comedor,
		SUM(r.Tickets_Llevar) as Tickets_Llevar,
		SUM(r.Porcentaje_Llevar) as Porcentaje_Llevar,
		SUM(r.TP) as TP,
		SUM(r.Unidades) as Unidades,
		SUM(r.UT) as UT		
		");
		$this->db->from("tbl_tickets  r");
		$this->db->join("tbl_usuarios u","r.usuario_id = u.id");
		$this->db->join("tbl_plazas p","r.plaza_id = p.id");				
		$this->db->group_by("r.Fecha,r.plaza_id");	
		$query=$this->db->where("r.plaza_id",$plaza_id);
		$query=$this->db->where("r.Fecha >=",$fechainicio);
		$query=$this->db->where("r.Fecha <=",$fechafin);	
        $resultados=$this->db->get();
        return $resultados->result();
	}

	
	public function save($data){
		return $this->db->insert("tbl_reporte_ventas",$data);

	}

	public function getVenta($id){
		$this->db->where("id",$id);
		$resultado=$this->db->get("tbl_reporte_ventas");
		return $resultado->row();
	}

	public function update($id,$data){
		$this->db->where("id",$id);
		return $this->db->update("tbl_reporte_ventas",$data);
	}

	public function compararDepositosPlaza($fechainicio,$fechafin,$plaza_id){
		$this->db->select("	
		r.plaza_id as plaza_id,	
		r.Semana as N_Semana,	
		p.Nombre as Plaza,
		MONTH(r.Fecha) as Mes,
		SUM((if(r.Dia =1,r.Total_Ingresos,0))) as Venta_Lunes, 
        SUM((if(r.Dia =2,r.Total_Ingresos,0))) as Venta_Martes, 
        SUM((if(r.Dia =3,r.Total_Ingresos,0))) as Venta_Miercoles, 
        SUM((if(r.Dia =4,r.Total_Ingresos,0))) as Venta_Jueves, 
        SUM((if(r.Dia =5,r.Total_Ingresos,0))) as Venta_Viernes, 
		SUM((if(r.Dia =6,r.Total_Ingresos,0))) as Venta_Sabado,
		SUM((if(r.Dia =7,r.Total_Ingresos,0))) as Venta_Domingo,		
		");
		$this->db->from("tbl_reporte_ventas  r");	
		$this->db->join("tbl_plazas p","r.plaza_id = p.id");			
		$query=$this->db->where("r.plaza_id",$plaza_id);
		$query=$this->db->where("r.Fecha >=",$fechainicio);
		$query=$this->db->where("r.Fecha <=",$fechafin);	
		$this->db->group_by("r.Semana");	
		$this->db->order_by("r.Fecha");	
        $resultados=$this->db->get();
        return $resultados->result();
	}

	public function compararDepositos($fechainicio,$fechafin){
		$this->db->select("	
		r.plaza_id as plaza_id,	
		r.Semana as N_Semana,	
		p.Nombre as Plaza,
		MONTH(r.Fecha) as Mes,
		SUM((if(r.Dia =1,r.Total_Ingresos,0))) as Venta_Lunes, 
        SUM((if(r.Dia =2,r.Total_Ingresos,0))) as Venta_Martes, 
        SUM((if(r.Dia =3,r.Total_Ingresos,0))) as Venta_Miercoles, 
        SUM((if(r.Dia =4,r.Total_Ingresos,0))) as Venta_Jueves, 
        SUM((if(r.Dia =5,r.Total_Ingresos,0))) as Venta_Viernes, 
		SUM((if(r.Dia =6,r.Total_Ingresos,0))) as Venta_Sabado,
		SUM((if(r.Dia =7,r.Total_Ingresos,0))) as Venta_Domingo,		
		");
		$this->db->from("tbl_reporte_ventas  r");	
		$this->db->join("tbl_plazas p","r.plaza_id = p.id");					
		$query=$this->db->where("r.Fecha >=",$fechainicio);
		$query=$this->db->where("r.Fecha <=",$fechafin);
	    $this->db->group_by("r.Semana");
		$this->db->group_by("r.plaza_id");
		$this->db->order_by("r.Fecha");	
        $resultados=$this->db->get();
        return $resultados->result();
	}

	public function getNombresTablas(){
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("t.*");
		$this->db->from("tbl_tablas t");				
        $resultados=$this->db->get();
        return $resultados->result();        
	}


	public function getUltimaTabla(){
			//Aquí se valida que la categoria se encuentre activa
			$this->db->select("r.tabla_id");
			$this->db->from("tbl_bandera_tabla r");				
			$this->db->order_by("r.id","desc")->limit(1);	
			$resultados=$this->db->get();
			return $resultados->row();       
	}

	public function getNombreTabla($tabla_id){
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("t.Nombre");
		$this->db->from("tbl_tablas t");				
		$this->db->where("t.id",$tabla_id);	
		$resultados=$this->db->get();
		return $resultados->row();   
	}

	public function actualizarBanderaTabla($data){			
		return $this->db->update('tbl_bandera_tabla', $data);	
	}

	public function getDeposito($fecha,$plaza_id){
		$this->db->select("r.Deposito as Deposito");
		$this->db->from("tbl_reporte_ventas r");
		$this->db->where("r.Fecha",$fecha);
		$this->db->where("r.plaza_id",$plaza_id);
		$resultado=$this->db->get();		
		return $resultado->row();
	}


	
	public function actualizarDeposito($fechaV,$fechaD,$plaza_id,$data,$deposito,$folio){
		$this->db->trans_begin();   							

		$this->db->where("Fecha",$fechaV);
		$this->db->where("plaza_id",$plaza_id);		 
		$this->db->update('tbl_reporte_ventas', $data);	

		$data=array("Fecha_Tabla"=>$fechaV,"Fecha"=>$fechaD,"tabla_id"=>1,"plaza_id"=>$plaza_id,"Cantidad"=>$deposito,"Folio"=>$folio);
		$this->db->insert("tbl_depositos_2",$data);	

	   if ($this->db->trans_status() === FALSE){      
		   //Hubo errores en la consulta, entonces se cancela la transacción.   
		   $this->db->trans_rollback();      
		   return false;    
		}else{      
		   //Todas las consultas se hicieron correctamente.  
		   $this->db->trans_commit();    
		   return true;    
		}  	
	}

	public function desactualizarDeposito($fechaV,$fechaD,$plaza_id,$data,$deposito){
		$bandera=false;
		$this->db->trans_begin();   							
		$this->db->where("Fecha",$fechaV);
		$this->db->where("plaza_id",$plaza_id);		 
		$this->db->update('tbl_reporte_ventas', $data);	
		
		$this->db->where("Fecha",$fechaD);
		$this->db->where("plaza_id",$plaza_id);
		$this->db->where("Cantidad",$deposito);
		$this->db->delete("tbl_depositos_2");	
		
		if($this->db->affected_rows()){
			$bandera=true;
		}
		else{
			$bandera=false;
		}
	   if ($this->db->trans_status() === FALSE){      
		   //Hubo errores en la consulta, entonces se cancela la transacción.   
		   $this->db->trans_rollback();      
		   return false;
		   //return false;    
		}else{      
		   //Todas las consultas se hicieron correctamente.  
		   $this->db->trans_commit();    
		   return $bandera;    
		}  	
	}

	public function consultarLiberacion($fecha,$plaza_id){
		$this->db->select("r.Bandera as Bandera");
		$this->db->from("tbl_reporte_ventas r");
		$this->db->where("r.Fecha",$fecha);
		$this->db->where("r.plaza_id",$plaza_id);
		$resultado=$this->db->get();		
		return $resultado->row();
	}

	public function consultarFolio($fecha,$plaza_id,$valorDeposito,$tabla_id){
		$this->db->select("d.Folio as Folio,d.Fecha as Fecha");
		$this->db->from("tbl_depositos_2 d");
		$this->db->where("d.Fecha_Tabla",$fecha);
		$this->db->where("d.plaza_id",$plaza_id);
		$this->db->where("d.tabla_id",$tabla_id);
		$this->db->where("d.Cantidad",$valorDeposito);
		$resultado=$this->db->get();		
		return $resultado->row();
	}
	

	public function getTablaDepositos2($tabla_id,$fechainicio){
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("r.*,
		t.Nombre as Nombre,
		r.Fecha,
		SUM((if(r.plaza_id =1,r.Cantidad,0))) as CA, 
        SUM((if(r.plaza_id =2,r.Cantidad,0))) as MA, 
        SUM((if(r.plaza_id =3,r.Cantidad,0))) as OA, 
        SUM((if(r.plaza_id =4,r.Cantidad,0))) as PZ, 
        SUM((if(r.plaza_id =5,r.Cantidad,0))) as R1, 
		SUM((if(r.plaza_id =6,r.Cantidad,0))) as R2,
		SUM((if(r.plaza_id =7,r.Cantidad,0))) as TZ				
		");
		$this->db->from("tbl_depositos_2 r");	
		$this->db->join("tbl_tablas t","t.id = r.tabla_id");	
		$this->db->where("r.tabla_id",$tabla_id);
		$this->db->where("r.fecha>=",$fechainicio);		
		$this->db->group_by("r.Fecha,r.Folio");	
        $resultados=$this->db->get();
        return $resultados->result();        
	}


	public function getTablaDepositosCajaChica2($tabla_id){
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("r.*,
		t.Nombre as Nombre,
		r.Fecha,
		SUM((if(r.plaza_id =1,r.Cantidad,0))) as CA, 
        SUM((if(r.plaza_id =2,r.Cantidad,0))) as MA, 
        SUM((if(r.plaza_id =3,r.Cantidad,0))) as OA, 
        SUM((if(r.plaza_id =4,r.Cantidad,0))) as PZ, 
        SUM((if(r.plaza_id =5,r.Cantidad,0))) as R1, 
		SUM((if(r.plaza_id =6,r.Cantidad,0))) as R2,
		SUM((if(r.plaza_id =7,r.Cantidad,0))) as TZ				
		");
		$this->db->from("tbl_depositos_2 r");	
		$this->db->join("tbl_tablas t","t.id = r.tabla_id");	
		$this->db->where("r.tabla_id",$tabla_id);		
		$this->db->group_by("r.Fecha,r.Folio");	
        $resultados=$this->db->get();
        return $resultados->result();        
	}
















	public function getTablaDepositosFecha2($fechainicio,$tabla_id){
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("r.*,
		t.Nombre as Nombre,
		r.Fecha,
		SUM((if(r.plaza_id =1,r.Cantidad,0))) as CA, 
        SUM((if(r.plaza_id =2,r.Cantidad,0))) as MA, 
        SUM((if(r.plaza_id =3,r.Cantidad,0))) as OA, 
        SUM((if(r.plaza_id =4,r.Cantidad,0))) as PZ, 
        SUM((if(r.plaza_id =5,r.Cantidad,0))) as R1, 
		SUM((if(r.plaza_id =6,r.Cantidad,0))) as R2,
		SUM((if(r.plaza_id =7,r.Cantidad,0))) as TZ				
		");
		$this->db->from("tbl_depositos_2 r");	
		$this->db->join("tbl_tablas t","t.id = r.tabla_id");	
		$this->db->where("r.tabla_id",$tabla_id);	
		$this->db->where("r.Fecha>=",$fechainicio);			
		$this->db->group_by("r.Fecha,r.Folio");	
        $resultados=$this->db->get();
        return $resultados->result();        
	}

	public function getTablaDepositosFechaRango2($tabla_id,$fechainicio,$fechafin){
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("r.*,
		t.Nombre as Nombre,
		r.Fecha,
		SUM((if(r.plaza_id =1,r.Cantidad,0))) as CA, 
        SUM((if(r.plaza_id =2,r.Cantidad,0))) as MA, 
        SUM((if(r.plaza_id =3,r.Cantidad,0))) as OA, 
        SUM((if(r.plaza_id =4,r.Cantidad,0))) as PZ, 
        SUM((if(r.plaza_id =5,r.Cantidad,0))) as R1, 
		SUM((if(r.plaza_id =6,r.Cantidad,0))) as R2,
		SUM((if(r.plaza_id =7,r.Cantidad,0))) as TZ				
		");
		$this->db->from("tbl_depositos_2 r");	
		$this->db->join("tbl_tablas t","t.id = r.tabla_id");	
		$this->db->where("r.tabla_id",$tabla_id);	
		$this->db->where("r.Fecha>=",$fechainicio);			
		$this->db->where("r.Fecha<=",$fechafin);			
		$this->db->group_by("r.tabla_id");	
        $resultados=$this->db->get();
        return $resultados->result();        
	}


	public function getTablaDepositosFechaRangoDesglose2($tabla_id,$fechainicio,$fechafin){
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("r.*,
		t.Nombre as Nombre,
		r.Fecha,
		SUM((if(r.plaza_id =1,r.Cantidad,0))) as CA, 
        SUM((if(r.plaza_id =2,r.Cantidad,0))) as MA, 
        SUM((if(r.plaza_id =3,r.Cantidad,0))) as OA, 
        SUM((if(r.plaza_id =4,r.Cantidad,0))) as PZ, 
        SUM((if(r.plaza_id =5,r.Cantidad,0))) as R1, 
		SUM((if(r.plaza_id =6,r.Cantidad,0))) as R2,
		SUM((if(r.plaza_id =7,r.Cantidad,0))) as TZ				
		");
		$this->db->from("tbl_depositos_2 r");	
		$this->db->join("tbl_tablas t","t.id = r.tabla_id");	
		$this->db->where("r.tabla_id",$tabla_id);	
		$this->db->where("r.Fecha>=",$fechainicio);			
		$this->db->where("r.Fecha<=",$fechafin);			
		$this->db->group_by("r.Fecha,r.Folio");	
        $resultados=$this->db->get();
        return $resultados->result();        
	}

	public function consultarDisponibilidadFolio($fecha,$plaza_id,$folioInicial,$tabla_id){									
		$query=$this->db->where("Fecha",$fecha);
		$query=$this->db->where("plaza_id",$plaza_id);			
		$query=$this->db->where("Folio",$folioInicial);	
		$query=$this->db->where("tabla_id",$tabla_id);	
		$resultado=$this->db->get("tbl_depositos_2");
		if($resultado->num_rows()>0){
			return false;
		}
		else{
			return true;
		}
	}

	public function contarElementos($fecha,$plaza_id,$tabla_id){
		$this->db->select("count(*) as Total");
		$this->db->from("tbl_depositos_2 d");
		$this->db->where("d.Fecha",$fecha);
		$this->db->where("d.plaza_id",$plaza_id);
		$this->db->where("d.tabla_id",$tabla_id);		
		$resultado=$this->db->get();		
		return $resultado->row();
	}

	public function obtenerColumna($fecha,$plaza_id,$tabla_id){
		$this->db->select("d.*");
		$this->db->from("tbl_depositos_2 d");
		$this->db->where("d.Fecha",$fecha);
		$this->db->where("d.plaza_id",$plaza_id);
		$this->db->where("d.tabla_id",$tabla_id);		
		$resultados=$this->db->get();
        return $resultados->result();     
	}

	public function actualizarFolio($id,$plaza_id,$folio){
		$this->db->where("id",$id);		
		$data=array("Folio"=>$folio);
		$this->db->update("tbl_depositos_2",$data);
	}

	public function insertarDeposito2($data){
		$this->db->trans_begin();   							

		$this->db->insert("tbl_depositos_2",$data);	

	   if ($this->db->trans_status() === FALSE){      
		   //Hubo errores en la consulta, entonces se cancela la transacción.   
		   $this->db->trans_rollback();      
		   return false;    
		}else{      
		   //Todas las consultas se hicieron correctamente.  
		   $this->db->trans_commit();    
		   return true;    
		}  	
	}

	public function insertarDepositoBatch2($data){
		$this->db->trans_begin();   							

		$this->db->insert_batch("tbl_depositos_2",$data);	

	   if ($this->db->trans_status() === FALSE){      
		   //Hubo errores en la consulta, entonces se cancela la transacción.   
		   $this->db->trans_rollback();      
		   return false;    
		}else{      
		   //Todas las consultas se hicieron correctamente.  
		   $this->db->trans_commit();    
		   return true;    
		}  	
	}

	public function deleteFila2($id){		
		$this->db->where('id', $id);
		return $this->db->delete('tbl_depositos_2');
	}

	public function deleteFilaMultiple2($fecha,$tabla_id,$folio){		
		$this->db->trans_begin();  

		$this->db->where('tabla_id',$tabla_id);
		$this->db->where('Fecha',$fecha);
		$this->db->where('Folio',$folio);
		$this->db->delete('tbl_depositos_2');

		if($this->db->affected_rows()){
			$bandera=true;
		}
		else{
			$bandera=false;
		}

		if ($this->db->trans_status() === FALSE){      
			//Hubo errores en la consulta, entonces se cancela la transacción.   
			$this->db->trans_rollback();      
			return false;
			//return false;    
		 }else{      
			//Todas las consultas se hicieron correctamente.  
			$this->db->trans_commit();    
			return $bandera;    
		 } 
	}


	public function actualizarTabla2($id,$data){	
		$this->db->trans_begin();   							

		$this->db->where('id', $id);		
		$this->db->update('tbl_depositos_2', $data);	
	
	   if ($this->db->trans_status() === FALSE){      
		   //Hubo errores en la consulta, entonces se cancela la transacción.   
		   $this->db->trans_rollback();      
		   return false;    
		}else{      
		   //Todas las consultas se hicieron correctamente.  
		   $this->db->trans_commit();    
		   return true;    
		}
	}

	public function actualizarTablaPepe2($fecha,$folio,$data1,$data2,$plaza_id1,$plaza_id2,$tabla_id){	
		$this->db->trans_begin();   							

		$this->db->where('Fecha',$fecha);
		$this->db->where('Folio',$folio);
		$this->db->where('plaza_id',$plaza_id1);
		$this->db->where('tabla_id',$tabla_id);
		$this->db->update('tbl_depositos_2', $data1);
				
		$this->db->where('Fecha',$fecha);
		$this->db->where('Folio',$folio);
		$this->db->where('plaza_id',$plaza_id2);
		$this->db->where('tabla_id',$tabla_id);
		$this->db->update('tbl_depositos_2', $data2);
	
	   if ($this->db->trans_status() === FALSE){      
		   //Hubo errores en la consulta, entonces se cancela la transacción.   
		   $this->db->trans_rollback();      
		   return false;    
		}else{      
		   //Todas las consultas se hicieron correctamente.  
		   $this->db->trans_commit();    
		   return true;    
		}
	}

	public function actualizarTablaMariaTeresa2($fecha,$folio,$data1,$data2,$data3,$plaza_id1,$plaza_id2,$plaza_id3,$tabla_id){	
		$this->db->trans_begin();   							

		$this->db->where('Fecha',$fecha);
		$this->db->where('Folio',$folio);
		$this->db->where('plaza_id',$plaza_id1);
		$this->db->where('tabla_id',$tabla_id);
		$this->db->update('tbl_depositos_2', $data1);
				
		$this->db->where('Fecha',$fecha);
		$this->db->where('Folio',$folio);
		$this->db->where('plaza_id',$plaza_id2);
		$this->db->where('tabla_id',$tabla_id);
		$this->db->update('tbl_depositos_2', $data2);

		$this->db->where('Fecha',$fecha);
		$this->db->where('Folio',$folio);
		$this->db->where('plaza_id',$plaza_id3);
		$this->db->where('tabla_id',$tabla_id);
		$this->db->update('tbl_depositos_2', $data3);


	
	   if ($this->db->trans_status() === FALSE){      
		   //Hubo errores en la consulta, entonces se cancela la transacción.   
		   $this->db->trans_rollback();      
		   return false;    
		}else{      
		   //Todas las consultas se hicieron correctamente.  
		   $this->db->trans_commit();    
		   return true;    
		}
	}



	public function actualizarCajaChica2($fecha,$folio,$data1,$data2,$data3,$data4,$data5,$data6,$data7,$plaza_id1,$plaza_id2,$plaza_id3,$plaza_id4,$plaza_id5,$plaza_id6,$plaza_id7,$tabla_id){	
		$this->db->trans_begin();   							

		$this->db->where('Fecha',$fecha);
		$this->db->where('Folio',$folio);
		$this->db->where('plaza_id',$plaza_id1);
		$this->db->where('tabla_id',$tabla_id);
		$this->db->update('tbl_depositos_2', $data1);
				
		$this->db->where('Fecha',$fecha);
		$this->db->where('Folio',$folio);
		$this->db->where('plaza_id',$plaza_id2);
		$this->db->where('tabla_id',$tabla_id);
		$this->db->update('tbl_depositos_2', $data2);

		$this->db->where('Fecha',$fecha);
		$this->db->where('Folio',$folio);
		$this->db->where('plaza_id',$plaza_id3);
		$this->db->where('tabla_id',$tabla_id);
		$this->db->update('tbl_depositos_2', $data3);

		$this->db->where('Fecha',$fecha);
		$this->db->where('Folio',$folio);
		$this->db->where('plaza_id',$plaza_id4);
		$this->db->where('tabla_id',$tabla_id);
		$this->db->update('tbl_depositos_2', $data4);
				
		$this->db->where('Fecha',$fecha);
		$this->db->where('Folio',$folio);
		$this->db->where('plaza_id',$plaza_id5);
		$this->db->where('tabla_id',$tabla_id);
		$this->db->update('tbl_depositos_2', $data5);

		$this->db->where('Fecha',$fecha);
		$this->db->where('Folio',$folio);
		$this->db->where('plaza_id',$plaza_id6);
		$this->db->where('tabla_id',$tabla_id);
		$this->db->update('tbl_depositos_2', $data6);

		$this->db->where('Fecha',$fecha);
		$this->db->where('Folio',$folio);
		$this->db->where('plaza_id',$plaza_id7);
		$this->db->where('tabla_id',$tabla_id);
		$this->db->update('tbl_depositos_2', $data7);

	
	   if ($this->db->trans_status() === FALSE){      
		   //Hubo errores en la consulta, entonces se cancela la transacción.   
		   $this->db->trans_rollback();      
		   return false;    
		}else{      
		   //Todas las consultas se hicieron correctamente.  
		   $this->db->trans_commit();    
		   return true;    
		}
	}


	public function actualizarTablaVic($fecha,$folio,$data_CA,$data_PZ,$data_OA,$plaza_id_CA,$plaza_id_PZ,$plaza_id_OA,$tabla_id){	
		$this->db->trans_begin();   							

		$this->db->where('Fecha',$fecha);
		$this->db->where('Folio',$folio);
		$this->db->where('plaza_id',$plaza_id_CA);
		$this->db->where('tabla_id',$tabla_id);
		$this->db->update('tbl_depositos_2', $data_CA);
				
		$this->db->where('Fecha',$fecha);
		$this->db->where('Folio',$folio);
		$this->db->where('plaza_id',$plaza_id_PZ);
		$this->db->where('tabla_id',$tabla_id);
		$this->db->update('tbl_depositos_2', $data_PZ);

		$this->db->where('Fecha',$fecha);
		$this->db->where('Folio',$folio);
		$this->db->where('plaza_id',$plaza_id_OA);
		$this->db->where('tabla_id',$tabla_id);
		$this->db->update('tbl_depositos_2', $data_OA);

	
	   if ($this->db->trans_status() === FALSE){      
		   //Hubo errores en la consulta, entonces se cancela la transacción.   
		   $this->db->trans_rollback();      
		   return false;    
		}else{      
		   //Todas las consultas se hicieron correctamente.  
		   $this->db->trans_commit();    
		   return true;    
		}
	}

	public function actualizarTablaPedro($fecha,$folio,$data_MA,$data_R1,$plaza_id_MA,$plaza_id_R1,$tabla_id){	
		$this->db->trans_begin();   							

		$this->db->where('Fecha',$fecha);
		$this->db->where('Folio',$folio);
		$this->db->where('plaza_id',$plaza_id_MA);
		$this->db->where('tabla_id',$tabla_id);
		$this->db->update('tbl_depositos_2', $data_MA);
				
		$this->db->where('Fecha',$fecha);
		$this->db->where('Folio',$folio);
		$this->db->where('plaza_id',$plaza_id_R1);
		$this->db->where('tabla_id',$tabla_id);
		$this->db->update('tbl_depositos_2', $data_R1);
	
	   if ($this->db->trans_status() === FALSE){      
		   //Hubo errores en la consulta, entonces se cancela la transacción.   
		   $this->db->trans_rollback();      
		   return false;    
		}else{      
		   //Todas las consultas se hicieron correctamente.  
		   $this->db->trans_commit();    
		   return true;    
		}
	}

	// Permite listar la información de una sola plaza
	public function getTablaDepositosPorPlaza($tabla_id,$fechainicio,$plaza_id){
		$this->db->select("r.*,
			t.Nombre as Nombre,
			r.Fecha,
			SUM((if(r.plaza_id =1,r.Cantidad,0))) as CA, 
			SUM((if(r.plaza_id =2,r.Cantidad,0))) as MA, 
			SUM((if(r.plaza_id =3,r.Cantidad,0))) as OA, 
			SUM((if(r.plaza_id =4,r.Cantidad,0))) as PZ, 
			SUM((if(r.plaza_id =5,r.Cantidad,0))) as R1, 
			SUM((if(r.plaza_id =6,r.Cantidad,0))) as R2,
			SUM((if(r.plaza_id =7,r.Cantidad,0))) as TZ				
		");
		$this->db->from("tbl_depositos_2 r");	
		$this->db->join("tbl_tablas t","t.id = r.tabla_id");	
		$this->db->where("r.tabla_id",$tabla_id);
		$this->db->where("r.fecha>=",$fechainicio);	
		$this->db->where("r.plaza_id",$plaza_id);	
		$this->db->group_by("r.Fecha,r.Folio");	
        $resultados=$this->db->get();
        return $resultados->result();        
	}

	public function getTablaDepositosFechaRangoDesglosePorPlaza($tabla_id,$fechainicio,$fechafin,$plaza_id){
		$this->db->select("r.*,
			t.Nombre as Nombre,
			r.Fecha,
			SUM((if(r.plaza_id =1,r.Cantidad,0))) as CA, 
			SUM((if(r.plaza_id =2,r.Cantidad,0))) as MA, 
			SUM((if(r.plaza_id =3,r.Cantidad,0))) as OA, 
			SUM((if(r.plaza_id =4,r.Cantidad,0))) as PZ, 
			SUM((if(r.plaza_id =5,r.Cantidad,0))) as R1, 
			SUM((if(r.plaza_id =6,r.Cantidad,0))) as R2,
			SUM((if(r.plaza_id =7,r.Cantidad,0))) as TZ
		");
		$this->db->from("tbl_depositos_2 r");	
		$this->db->join("tbl_tablas t","t.id = r.tabla_id");	
		$this->db->where("r.tabla_id",$tabla_id);	
		$this->db->where("r.Fecha>=",$fechainicio);			
		$this->db->where("r.Fecha<=",$fechafin);			
		$this->db->where("r.plaza_id",$plaza_id);			
		$this->db->group_by("r.Fecha,r.Folio");	
        $resultados=$this->db->get();
        return $resultados->result();        
	}

	
	public function getTablaDepositosPorGrupoPlazas($tabla_id,$fechainicio,$grupoPlazas){
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("r.*,
			t.Nombre as Nombre,
			r.Fecha,
			SUM((if(r.plaza_id =1,r.Cantidad,0))) as CA, 
			SUM((if(r.plaza_id =2,r.Cantidad,0))) as MA, 
			SUM((if(r.plaza_id =3,r.Cantidad,0))) as OA, 
			SUM((if(r.plaza_id =4,r.Cantidad,0))) as PZ, 
			SUM((if(r.plaza_id =5,r.Cantidad,0))) as R1, 
			SUM((if(r.plaza_id =6,r.Cantidad,0))) as R2,
			SUM((if(r.plaza_id =7,r.Cantidad,0))) as TZ				
		");
		$this->db->from("tbl_depositos_2 r");	
		$this->db->join("tbl_tablas t","t.id = r.tabla_id");	
		$this->db->where("r.tabla_id",$tabla_id);
		$this->db->where("r.fecha>=",$fechainicio);		
		$this->db->where_in('r.plaza_id', $grupoPlazas);
		$this->db->group_by("r.Fecha,r.Folio");	
        $resultados=$this->db->get();
        return $resultados->result();        
	}

	public function getTablaDepositosFechaRangoDesglosePorGrupoPlazas($tabla_id,$fechainicio,$fechafin,$grupoPlazas){
		//Aquí se valida que la categoria se encuentre activa
		$this->db->select("r.*,
			t.Nombre as Nombre,
			r.Fecha,
			SUM((if(r.plaza_id =1,r.Cantidad,0))) as CA, 
        	SUM((if(r.plaza_id =2,r.Cantidad,0))) as MA, 
        	SUM((if(r.plaza_id =3,r.Cantidad,0))) as OA, 
        	SUM((if(r.plaza_id =4,r.Cantidad,0))) as PZ, 
        	SUM((if(r.plaza_id =5,r.Cantidad,0))) as R1, 
			SUM((if(r.plaza_id =6,r.Cantidad,0))) as R2,
			SUM((if(r.plaza_id =7,r.Cantidad,0))) as TZ				
		");
		$this->db->from("tbl_depositos_2 r");	
		$this->db->join("tbl_tablas t","t.id = r.tabla_id");	
		$this->db->where("r.tabla_id",$tabla_id);	
		$this->db->where("r.Fecha>=",$fechainicio);			
		$this->db->where("r.Fecha<=",$fechafin);		
		$this->db->where_in('r.plaza_id', $grupoPlazas);	
		$this->db->group_by("r.Fecha,r.Folio");	
        $resultados=$this->db->get();
        return $resultados->result();        
	}


	public function deleteFilaMultipleGrupoPlaza($fecha,$tabla_id,$folio,$grupoPlazas){		
		$this->db->trans_begin();  

		$this->db->where('tabla_id',$tabla_id);
		$this->db->where('Fecha',$fecha);
		$this->db->where('Folio',$folio);
		$this->db->where_in('plaza_id', $grupoPlazas);	
		$this->db->delete('tbl_depositos_2');

		if($this->db->affected_rows()){
			$bandera=true;
		}
		else{
			$bandera=false;
		}

		if ($this->db->trans_status() === FALSE){      
			//Hubo errores en la consulta, entonces se cancela la transacción.   
			$this->db->trans_rollback();      
			return false;
			//return false;    
		 }else{      
			//Todas las consultas se hicieron correctamente.  
			$this->db->trans_commit();    
			return $bandera;    
		 } 
	}

	// =========================================================================
	// CONSULTA DINÁMICA PARA UNIDADES VENDIDAS (DRY)
	// =========================================================================

	public function getDepositosDinamic($fechaInicio, $fechaFin, $plaza_id = null, $esRango = false)
	{
		// Si es búsqueda por rango, agrupamos los datos para mostrar totales
		if ($esRango) {
			$this->db->select("
				r.*,
				SUM(r.Deposito) as SumaDeposito,
				SUM(r.Efectivo_Real) as SumaEfectivo,
				SUM(r.Total_Ventas) as SumaVentasC,
				SUM(r.Total_Ingresos) as SumaTotalV,
				SUM(r.TPV) as SumaTPV,
				SUM(r.Gastos) as SumaGastos,
				u.Nombre as Usuario, 
				p.Nombre as Plaza
			");
			$this->db->group_by('Plaza');
		} else {
			// Búsqueda simple de un día específico
			$this->db->select("r.*, u.Nombre as Usuario, p.Nombre as Plaza, p.Acronimo as Acronimo");
			$this->db->order_by("r.plaza_id", "asc");
		}

		$this->db->from("tbl_reporte_ventas r");
		$this->db->join("tbl_usuarios u", "r.usuario_id = u.id");
		$this->db->join("tbl_plazas p", "r.plaza_id = p.id");

		// Aplicar filtros de fecha
		$this->db->where("r.Fecha >=", $fechaInicio);
		$this->db->where("r.Fecha <=", $fechaFin);

		// Aplicar filtro de plaza si existe
		if (!empty($plaza_id)) {
			$this->db->where("r.plaza_id", $plaza_id);
		}

		return $this->db->get()->result();
	}

}

