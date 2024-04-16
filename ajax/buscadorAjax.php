<?php 

session_start(['name' => 'SAV']);
require_once "../config/app.php";

if(isset($_POST['busqueda_inicial']) || isset($_POST['eliminar_busqueda'])){

    $data_url=[
        "usuario"=>"user-search",
        "especialidad"=>"advisor-agenda"
    ];

    if(isset($_POST['modulo'])){
        $modulo = $_POST['modulo'];
        if(!isset($data_url[$modulo])){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrio un error inesperado",
                "Text"=>"No es posible continuar con la busqueda debido a un error",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }
    }else{
        $alerta=[
            "Alerta"=>"simple",
            "Titulo"=>"Ocurrio un error inesperado",
            "Text"=>"No es posible continuar con la busqueda debido a un error de configuracion",
            "Tipo"=>"error"
        ];
        echo json_encode($alerta);
        exit();
    }

    $name_var="busqueda_".$modulo;

    if(isset($_POST['busqueda_inicial'])){
        if($_POST['busqueda_inicial'] == ""){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrio un error inesperado",
                "Text"=>"No se incluyo ningun dato de busqueda",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }
        $_SESSION[$name_var]=$_POST['busqueda_inicial'];
    }

    if(isset($_POST['eliminar_busqueda'])){
        unset($_SESSION[$name_var]);
    }

    $url=$data_url[$modulo];

    $alerta=[
        "Alerta"=>"redireccionar",
        "URL"=>SERVERURL.$url."/"
    ];
    echo json_encode($alerta);

}else{
    session_unset();
    session_destroy();
    header("Location: ".SERVERURL."login/");
    exit();
}