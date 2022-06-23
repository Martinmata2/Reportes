<?php
namespace Clases\Reportes;

class Flujo
{

    public function Monetario($arguments = null)
    {
        return array(
            array("title"=> "ID",               "name"=>"ActUsuario",           "editable"=>false,          "width"=>"20",          "hidden"=>true,             "export"=>false),
            array("title"=> "Fecha",            "name"=>"ActFecha",             "editable"=>false,          "width"=>"40"),
            array("title"=>"Usuario",           "name"=>"ActUsuario",           "editable"=>false,          "width"=>"40",          "align"=>"center",  
                "editoptions"=>array("value"=>$arguments["usuarios"]),          "edittype"=>"select",       "op"=>"eq",             "formatter"=>"select",
                "searchoptions"=>array("value"=>$arguments["usuarios"]),        "stype"=> "select" ),
            array("title"=>"Ventas",            "name"=>"ventas",               "editable"=>false,          "width"=>"40",          "align"=>"right",           "search"=>false,
                "formatter"=>"currency","formatoptions"=>array("prefix" => "$",	"suffix" => '',	"thousandsSeparator" => ",",
                    "decimalSeparator" => ".",
                    "decimalPlaces" => 2)),
            array("title"=>"Compras",           "name"=>"compras",              "editable"=>false,          "width"=>"40",          "align"=>"right",           "search"=>false,
                "formatter"=>"currency","formatoptions"=>array("prefix" => "$",	"suffix" => '',	"thousandsSeparator" => ",",
                    "decimalSeparator" => ".",
                    "decimalPlaces" => 2)),
            array("title"=>"Devolucion",        "name"=>"devolucion",           "editable"=>false,          "width"=>"40",          "align"=>"right",           "search"=>false,
                "formatter"=>"currency","formatoptions"=>array("prefix" => "$",	"suffix" => '',	"thousandsSeparator" => ",",
                    "decimalSeparator" => ".",
                    "decimalPlaces" => 2)),
            array("title"=>"Abonos",            "name"=>"abonos",               "editable"=>false,          "width"=>"40",          "align"=>"right",           "search"=>false,
                "formatter"=>"currency","formatoptions"=>array("prefix" => "$",	"suffix" => '',	"thousandsSeparator" => ",",
                    "decimalSeparator" => ".",
                    "decimalPlaces" => 2)),
            array("title"=>"Entradas",          "name"=>"entradas",             "editable"=>false,          "width"=>"40",          "align"=>"right",           "search"=>false,
                "formatter"=>"currency","formatoptions"=>array("prefix" => "$",	"suffix" => '',	"thousandsSeparator" => ",",
                    "decimalSeparator" => ".",
                    "decimalPlaces" => 2)),
            array("title"=>"Salidas",           "name"=>"salidas",              "editable"=>false,          "width"=>"40",          "align"=>"right",           "search"=>false,
                "formatter"=>"currency","formatoptions"=>array("prefix" => "$",	"suffix" => '',	"thousandsSeparator" => ",",
                    "decimalSeparator" => ".",
                    "decimalPlaces" => 2)),
            array("title"=> "Total",            "name"=>"total",                "editable"=>false,          "width"=>"40",          "align"=>"right",
                "formatter"=>"currency","formatoptions"=>array("prefix" => "$",	"suffix" => '',	"thousandsSeparator" => ",",
                    "decimalSeparator" => ".",
                    "decimalPlaces" => 2)));
    }
    
    public function MonetarioDetalles($arguments = null)
    {
        return array(
            array("title"=> "ID",               "name"=>"ActID",                "editable"=>false,          "width"=>"40", "hidden"=>true),
            array("title"=>"Descripcion <small>Mostrar Actividad</small>","name"=>"ActDescripcion","editable"=> false,
                "link"=>$arguments["link"], //$inicio."MostrarActividad.php?id={ActRelacion}&codigo={ActCodigo}",
                "linkoptions"=>"class='actividad'","align"=>"left","width"=>"100"),
            array("title"=>"Fecha","name"=>"ActFecha","editable"=>false,"align"=>"center","width"=>"120"),
            array("title"=>"Cliente","name"=>"CliNombre","editable"=>false,"align"=>"center","width"=>"100"),
            array("title"=>"Total","name"=>"ActCantidad","editable"=>false,"align"=>"right","width"=>"60",
                "formatter"=>"currency","formatoptions"=>array("prefix" => "$",	"suffix" => '',	"thousandsSeparator" => ",",
                    "decimalSeparator" => ".",
                    "decimalPlaces" => 2)),
            array("title"=>"Codigo","name"=>"ActCodigo","width"=>"40","align"=>"right","editable"=>false,"hidden"=>true),
            array("title"=>"Documento","name"=>"ActRelacion","width"=>"40","align"=>"right","editable"=>false,"hidden"=>true),
            
        );
    }
}

