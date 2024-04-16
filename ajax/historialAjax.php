<?php 

$peticionAjax = true;

require_once "../config/app.php";

if(isset($_POST['id_asesoria_finalizada_up'])){
    require_once "../controladores/historialAsesoriaControlador.php";
    $ins_historial = new historialAsesoriaControlador();

    if(isset($_POST['id_asesoria_finalizada_up'])){
        echo $ins_historial->actualizar_historial_controlador();

    }

}else{
    session_start(['name' => 'SAV']);
    session_unset();
    session_destroy();
    header("Location: ".SERVERURL."login/");
    exit();
}