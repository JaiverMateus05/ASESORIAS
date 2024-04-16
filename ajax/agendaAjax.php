<?php 
$peticionAjax = true;
require_once "../config/app.php";

if(isset($_POST['id_estudiante_ag']) || isset($_POST['id_asesoria_fin'])){

    require_once "../controladores/agendaControlador.php";
    $ins_agend = new agendaControlador();

    if(isset($_POST['id_estudiante_ag'])){
        echo $ins_agend->agendar_asesoria_controlador();
    }

    if(isset($_POST['id_asesoria_fin'])){
        echo $ins_agend->finalizar_asesoria_controlador();
    }

    if(isset($_POST['id_asesoria_fin'])){
        echo $ins_agend->finalizar_asesoria1_controlador();
    }
}else{

    session_start(['name' => 'SAV']);
    session_unset();
    session_destroy();
    header("Location: ".SERVERURL."login/");
    exit();
}