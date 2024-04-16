<?php 
$peticionAjax=true;
require_once "../config/app.php";

if(isset($_POST['especialidad_nombre_reg']) || isset($_POST['especialidad_id_del']) || isset($_POST['especialidad_user_reg'])){

    require_once "../controladores/especialidadControlador.php";
    $ins_espec = new especialidadControlador();

    if(isset($_POST['especialidad_nombre_reg'])){

        echo $ins_espec->crear_especialidad_controlador();
    }

    if(isset($_POST['especialidad_id_del'])){
        echo $ins_espec->eliminar_especialidad_controlador();

    }

    if(isset($_POST['especialidad_user_reg'])){
        echo $ins_espec->asignar_especialidad_controlador();
    }
}else{
    session_start(['name' => 'SAV']);
    session_unset();
    session_destroy();
    header("Location: ".SERVERURL."login/");
    exit();
}