<?php 
$peticionAjax=true;
require_once "../config/app.php";

if(isset($_POST['usuario_nombre_reg']) || isset($_POST['usuario_id_del']) || isset($_POST['usuario_id_up'])){

    require_once "../controladores/usuarioControlador.php";
    $ins_usuario = new usuarioControlador();

    if(isset($_POST['usuario_nombre_reg']) && isset($_POST['usuario_apellido_reg'])){

        echo $ins_usuario->agregar_usuario_controlador();
    }

    if(isset($_POST['usuario_id_del'])){

        echo $ins_usuario->eliminar_usuario_controlador();
    }

    if(isset($_POST['usuario_id_up'])){
        echo $ins_usuario->actualizar_usuario_controlador();
    }

}else{
    session_start(['name' => 'SAV']);
    session_unset();
    session_destroy();
    header("Location: ".SERVERURL."login/");
    exit();
}