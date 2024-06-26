<?php 

if($peticionAjax){
require_once "../modelos/loginModelo.php";
}else{
require_once "./modelos/loginModelo.php";
}

class loginControlador extends loginModelo{

    public function iniciar_sesion_controlador(){
        $usuario = mainModel::limpiar_cadena($_POST['usuario_log']);
        $clave = mainModel::limpiar_cadena($_POST['clave_log']);

        if($usuario == "" || $clave == ""){
            echo '
            <script>
            Swal.fire({
                title: "Ocurrio un erro",
                text: "No se han incluido los datos necesarios",
                type: "error",
                confirmButtonText: "Aceptar"
            });
            </script>';
            exit();
        }

        $clave = mainModel::encryption($clave);
        $datos_login=[
            "Usuario" => $usuario,
            "Clave" => $clave
        ];

        $datos_cuenta=loginModelo::iniciar_sesion_modelo($datos_login);

        if($datos_cuenta->rowCount()==1){
            $row = $datos_cuenta->fetch();
            session_start(['name' => 'SAV']);

            $_SESSION['id_sav'] = $row['id'];
            $_SESSION['nombre_sav'] = $row['nombre_usuario'];
            $_SESSION['apellido_sav'] = $row['apellido_usuario'];
            $_SESSION['usuario_sav'] = $row['usuario_usuario'];
            $_SESSION['rol_sav'] = $row['rol_usuario'];
            $_SESSION['email_sav'] = $row['email_usuario'];

            return header("Location: " . SERVERURL ."home/");
        }else{
            echo'<script>
            Swal.fire({
                title: "Ocurrio un erro",
                text: "El usuario o clave no son correctos",
                type: "error",
                confirmButtonText: "Aceptar"
            });
            </script>';
        }
    }

    public function forzar_cierre_sesion_controlador(){
        session_unset();
        session_destroy();
        if(true){

            return "<script> window.location.href='".SERVERURL."login/';</script>";
        }else{
            return header("Location: " . SERVERURL ."login/");

        }
    }

    public function cerrar_sesion_controlador(){
        session_start(['name' => 'SAV']);
        $usuario=mainModel::decryption($_POST['usuario']);
        if($usuario == $_SESSION['usuario_sav']){

            session_unset();
            session_destroy();
            $alerta=[
                "Alerta" => "redireccionar",
                "URL" => SERVERURL."login/"
            ];
        }else{
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrió un error inesperado",
                "Texto"=>"No fue posible cerrar la sesion",
                "Tipo"=>"error"
            ];
        }
        echo json_encode($alerta);
    }
}