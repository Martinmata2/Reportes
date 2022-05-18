<?php
namespace Clases\Reportes;

use Clases\MySql\Query;
use Clases\Utilidades\Fechas;

/**
 * @version 1_000
 * 2017
 * @author Martin Mata
 *
 */


class Auxiliar extends Query
{	
	function __construct($conexion = null, $base_datos = BD_GENERAL)
	{
		parent::__construct($base_datos);
		
	}
	
	/**
	 * 
	 * @param string $inicio
	 * @param string $final
	 * @param string $campofecha
	 * @return \StdClass
	 */
	public function iva($inicio, $final, $campofecha)
	{
	    $rango = $this->rango($inicio, $final, $campofecha);
	    $respuesta = new \StdClass();
	    $respuesta->conIva = $this->consulta("sum(DdeImporte) as total","ventas inner join ventadetalles on FacID = DdeDocumento inner join productos  on DdeProducto = ProID", $this->base_datos,
	        $rango->where." and ProIVA =1")[0]->total;
	    $respuesta->sinIva = $this->consulta("sum(DdeImporte) as total","ventas inner join ventadetalles on FacID = DdeDocumento inner join productos  on DdeProducto = ProID", $this->base_datos,
	        $rango->where." and ProIVA <> 1")[0]->total;
	    
	    $respuesta->total = $this->consulta("sum(DdeImporte) as total","ventas inner join ventadetalles on FacID = DdeDocumento", $this->base_datos,
	        $rango->where)[0]->total;	
	    return $respuesta;	    	   
	}
	/**
	 * 
	 * @param string $inicio
	 * @param string $final
	 * @param string $campofecha
	 * @return \stdClass|number
	 * 
	 */
	public function rango($inicio, $final, $campofecha)
	{
	    $rango = new \stdClass();
	    $rango->rango = "Desde: ".Fechas::fechaenLetras($inicio)."  Hasta: ".Fechas::fechaenLetras($final);
	    $rango->where = "$campofecha between '".$inicio."' AND '".$final."'";
	    $tiempo =  explode("-",$inicio);
	    $temp = explode("-", $final);
	    $rango->mespasado = str_replace("0","", $tiempo[1]);
	    $rango->actual = str_replace("0","", $temp[1]);
	    $rango->year = $temp[0];
	    return $rango;
	    
	}
	
	/**
	 * 
	 * @param string $inicio
	 * @return string
	 */
	public function reportes($inicio)
	{
	    return "<a href='".$inicio."reportes/Productos.php' class='button'>Flujo Productos en Ventas</a> | 
                <a href='".$inicio."inventario/Reporte/Compras/Productos.php' class='button'>Flujo Productos en Compras</a> | 
                <a href='".$inicio."inventario/Reporte/Salidas/Productos.php' class='button'>Flujo Productos en Movimientos</a> |
                <a href='".$inicio."reportes/FLUJO/Monetario.php' class='button'>Flujo Moneratio</a> | 
                <a href='".$inicio."reportes/Iva.php' class='button'>Ventas IVA</a>"; 
	}
	
	public function mespasadol($campofecha)
	{
	    $rango = new \stdClass();
	    $tiempo =  date("Y-n-d", strtotime("first day of previous month"));
	    $rango->rango = "Desde: ".Fechas::fechaenLetras($tiempo)."  Hasta: ".Fechas::fechaenLetras(date("Y-m-d"));
	    $rango->where = "$campofecha >= DATE_ADD(LAST_DAY(DATE_SUB(NOW(), INTERVAL 2 MONTH)), INTERVAL 1 DAY)";	    
	    $temp = explode("-", $tiempo);
	    $rango->mespasado = $temp[1];
	    $rango->actual = $temp[1] *1 + 1;
	    $rango->year = $temp[0];
	    return $rango;	    
	}
	public function estemes($campofecha)
	{
	    $rango = new \stdClass();
	    $tiempo =  date("Y-n-d", strtotime("first day of this month"));
	    $rango->rango = "Desde: ".Fechas::fechaenLetras($tiempo)."  Hasta: ".Fechas::fechaenLetras(date("Y-m-d"));
	    $rango->where = "$campofecha >= DATE_ADD(LAST_DAY(DATE_SUB(NOW(), INTERVAL 1 MONTH)), INTERVAL 1 DAY)";
	    $temp = explode("-", $tiempo);	   
	    $rango->actual = $temp[1] *1 + 1;
	    $rango->year = $temp[0];
	    return $rango;	    
	}
	
	public function hoy($campofecha)
	{
	    $rango = new \stdClass();
	    $tiempo =  date("Y-n-d");
	    $rango->rango = "Hoy: ".Fechas::fechaenLetras($tiempo);
	    $rango->where = "date($campofecha) = CURDATE()";
	    $temp = explode("-", $tiempo);
	    $rango->actual = $temp[1];
	    $rango->year = $temp[0];
	    return $rango;
	}
	
	public function datepicker()
	{
	    
	    return " <form>
    	    <div class='row'>
    			<div class='col-md-4'>
    				<div class='form-floating mb-3'>
                        <input class='hour' type='hidden' id='hourfrom' size='3' value='00:01:00' name='hourfrom'/>
    					<input class='form-control lineonly datepicker' autocomplete='off' type='text' id='datefrom' name='datefrom'/>
    					<label for='datefrom'> Desde</label>
    				</div>
    			</div>
    			<div class='col-md-4'>
    				<div class='form-floating mb-3'>
                        <input class='hour' type='hidden' id='hourto' size='3' value='23:59:59' name='hourto'/>
    					<input class='form-control lineonly datepicker' autocomplete='off' type='text' id='dateto' /> 
                        <label for='dateto'> Hasta</label>
    				</div>
    			</div>
                <div class='col-md-4'>
        			<div class='button-group text-center'>
    					<button class='btn btn-primary' id='search_date'
    						type='submit'>Enviar</button>
    				</div>
                </div>
            </div>
        </form>   
                    
        <script type='text/javascript'>
            $(document).ready(function()
		      {
                $(document).on('change', '#datefrom', function()
                {
                    $('#dateto').val($('#datefrom').val());
                });
                $('#search_date').click(function()
	    		{
	    			window.location = '?datefrom='+jQuery('#datefrom').val()+' '+jQuery('#hourfrom').val()+'&dateto='+jQuery('#dateto').val()+' '+jQuery('#hourto').val();
                    return false;
	            });
              });  
        </script>		   
	    ";		
	}
	
	/**
	 * 
	 * @param string $rango
	 * @param string $format
	 * @return number
	 */
	public function venta($rango = "mensual", $fecha = "CURRENT_DATE")
	{	   
	    switch ($rango) {
	        case "anual":
	           
                $respuesta = $this->consulta("FORMAT(SUM(FacTotal),2) as total", "ventas", $this->base_datos,
                "YEAR(FacFecha) = YEAR('$fecha')");
                break;
	        case "promedio":
	            $respuesta = $this->consulta("FORMAT(SUM(FacTotal)/DAYOFYEAR('$fecha'),2) as total", "ventas", $this->base_datos,
	            "YEAR(FacFecha) = YEAR('$fecha')");
	            
	            break;
	        case "mensual":
	            $respuesta = $this->consulta("FORMAT(SUM(FacTotal),2) as total", "ventas", $this->base_datos,
	            "YEAR(FacFecha) = YEAR('$fecha') and month(FacFecha) = Month('$fecha')");	            
	        break;
	        case "diaria":
	            $respuesta = $this->consulta("FORMAT(SUM(FacTotal),2) as total", "ventas", $this->base_datos,
	            "date(FacFecha) = date('$fecha')");
	            break;
	        default:
	            ;
	        break;
	    }
		
		if(count($respuesta)>0)
		    return $respuesta[0]->total;
		else return 0;
	}
	
	public function query($campos, $tabla, $base_datos, $where = "0", $orderby = "0", $groupby = "0", $limit = "0", $usuario = "guess")
	{
	    return $this->consulta($campos, $tabla, $base_datos, $where, $orderby, $groupby, $limit, $usuario);
	}
}