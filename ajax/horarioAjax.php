<?php 

$peticionAjax = true;
require_once "../config/app.php";

if(isset($_POST['usuario_id_as']) || isset($_POST['usuario_id_del'])){
    require_once "../controladores/horarioAsesoriaControlador.php";
    $ins_hora = new horarioAsesoriaControlador();

    if(isset($_POST['usuario_id_as']) && isset($_POST['hora_asesoria_reg'])){
        echo $ins_hora->agregar_horario_asesoria_controlador();
    }

    if(isset($_POST['usuario_id_del']) && isset($_POST['hora_asesoria_del'])){

        echo $ins_hora->eliminar_horario_asesoria_controlador();
    }

}else{
    session_start(['name' => 'SAV']);
    session_unset();
    session_destroy();
    header("Location: ".SERVERURL."login/");
    exit();
}