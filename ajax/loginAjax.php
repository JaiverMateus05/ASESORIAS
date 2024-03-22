<?php 

$peticionAjax=true;
require_once "../config/app.php";

if(isset($_POST['usuario'])){

    require_once "../controladores/loginControlador.php";
    $ins_login = new loginControlador();

    echo $ins_login->cerrar_sesion_controlador();
}else{
    session_start(['name' => 'SAV']);
    session_unset();
    session_destroy();
    header("Location: ".SERVERURL."login/");
}