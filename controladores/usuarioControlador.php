<?php

if ($peticionAjax) {
    require_once "../modelos/usarioModelo.php";
} else {
    require_once "./modelos/usarioModelo.php";
}

class usuarioControlador extends usuarioModelo
{

    public function agregar_usuario_controlador()
    {
        $nombre = mainModel::limpiar_cadena($_POST['usuario_nombre_reg']);
        $apellido = mainModel::limpiar_cadena($_POST['usuario_apellido_reg']);
        $usuario = mainModel::limpiar_cadena($_POST['usuario_usuario_reg']);
        $email = mainModel::limpiar_cadena($_POST['usuario_email_reg']);
        $clave1 = mainModel::limpiar_cadena($_POST['usuario_clave_1_reg']);
        $clave2 = mainModel::limpiar_cadena($_POST['usuario_clave_2_reg']);
        $rol = mainModel::limpiar_cadena($_POST['usuario_rol_reg']);

        if ($nombre == "" || $apellido == "" || $usuario == "" || $clave1 == "" || $clave2 == "" || $rol == "") {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrio un error inesperado",
                "Texto" => "No se han llenado todos los campos",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $check_user = mainModel::ejecutar_consulta_simple("SELECT usuario_usuario FROM usuarios WHERE usuario_usuario='$usuario'");
        if ($check_user->rowCount() > 0) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "El NOMBRE DE USUARIO ingresado ya se encuentra registrado en el sistema",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }
        /*== Comprobando claves ==*/
        if ($clave1 != $clave2) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "Las claves que acaba de ingresar no coinciden",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        } else {
            $clave = mainModel::encryption($clave1);
        }

        if ($email != "") {

            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

                $check_email = mainModel::ejecutar_consulta_simple("SELECT email_usuario FROM usuarios WHERE email_usuario='$email'");
                if ($check_email->rowCount() > 0) {

                    $alerta = [
                        "Alerta" => "simple",
                        "Titulo" => "Ocurrio un error inesperado",
                        "Texto" => "El correo ingresado ya existe en el sistema",
                        "Tipo" => "error"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
            } else {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrio un error inesperado",
                    "Texto" => "El correo ingresado un correo no valido",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }
        }

        $datos_usuario_reg = [
            "Nombre" => $nombre,
            "Apellido" => $apellido,
            "Usuario" => $usuario,
            "Clave" => $clave,
            "Rol" => $rol,
            "Email" => $email
        ];

        $agregar_usuario = usuarioModelo::agregar_usuario_modelo($datos_usuario_reg);

        if ($agregar_usuario->rowCount() == 1) {
            $alerta = [
                "Alerta" => "limpiar",
                "Titulo" => "Usuario registrado",
                "Texto" => "Se guardo el usuario satisfactoriamente",
                "Tipo" => "success"
            ];
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "No fue posible guardar el usuario",
                "Tipo" => "error"
            ];
        }

        echo json_encode($alerta);
    }

    public function paginar_usuario_controlador($pagina, $registros, $id, $url, $busqueda)
    {

        $pagina = mainModel::limpiar_cadena($pagina);
        $registros = mainModel::limpiar_cadena($registros);
        $id = mainModel::limpiar_cadena($id);

        $url = mainModel::limpiar_cadena($url);
        $url = SERVERURL . $url . "/";

        $busqueda = mainModel::limpiar_cadena($busqueda);
        $tabla = "";
        $pagina = (isset($pagina) && $pagina > 0) ? (int) $pagina : 1;
        $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;

        if (isset($busqueda) && $busqueda !="") {

            $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM usuarios WHERE ((id!='$id' AND id!='1') AND (nombre_usuario LIKE '%$busqueda%' OR apellido_usuario LIKE '%$busqueda%')) ORDER BY nombre_usuario ASC LIMIT $inicio,$registros";            
        } else {

            $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM usuarios WHERE id!='$id' AND id!='1' ORDER BY nombre_usuario ASC LIMIT $inicio,$registros";
        }
            $conexion = mainModel::conectar();
            $datos = $conexion->query($consulta);
            $datos = $datos->fetchAll();
            $total = $conexion->query("SELECT FOUND_ROWS()");
            $total = (int)$total->fetchColumn();

            $Npaginas = ceil($total / $registros);

            $tabla .= '
            <div class="table-responsive">
            <table class="table table-dark table-sm">
                <thead>
                    <tr class="text-center roboto-medium">
                        <th>#</th>
                        <th>NOMBRE</th>
                        <th>APELLIDO</th>
                        <th>EMAIL</th>
                        <th>ROL</th>
                        <th>ASESORIAS AGENDADAS</th>
                        <th>ACTUALIZAR</th>
                        <th>ELIMINAR</th>
                    </tr>
                </thead>
                <tbody>
                ';

            if ($total >= 1 && $pagina <= $Npaginas) {

                $contador = $inicio + 1;
                $reg_inicio = $inicio + 1;
                foreach ($datos as $rows) {
                    $check_asesoria = mainModel::ejecutar_consulta_simple("SELECT * FROM asesoria WHERE id_asesor='$rows[id]' OR id_estudiante='$rows[id]'");

                    $tabla .= '	
                        <tr class="text-center" >
                        <td>' . $contador . '</td>
                        <td>' . $rows['nombre_usuario'] . '</td>
                        <td>' . $rows['apellido_usuario'] . '</td>
                        <td>' . $rows['email_usuario'] . '</td>
                        <td>' . $rows['rol_usuario'] . '</td>
                        <td>'.$check_asesoria->rowCount().'</td>
                        <td>
                            <a href="' . SERVERURL . 'user-update/' . mainModel::encryption($rows['id']) . '/" class="btn btn-success">
                                  <i class="fas fa-sync-alt"></i>	
                            </a>
                        </td>
                        <td>
                            <form action="' . SERVERURL . 'ajax/usuarioAjax.php" class="FormularioAjax" method="POST" data-form="delete" autocomplete="off">
                            <input type="hidden" name="usuario_id_del" value="' . mainModel::encryption($rows['id']) . '">
                                <button type="submit" class="btn btn-warning">
                                      <i class="far fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    ';
                    $contador++;
                }
                $reg_final = $contador - 1;
            } else {
                if ($total >= 1) {
                    $tabla .= '<tr class="text-center">
                        <td colspan="9">
                        <a href="' . $url . '" class="btn btn-raised btn-primary btn-sm">Haz click para recargar listado</a>
                        </td></tr>
                        ';
                } else {
                    $tabla .= '<tr class="text-center"><td colspan="9">No hay registros en el sistema</td></tr>
                        ';
                }
            }
            $tabla .= '</tbody></table></div>';


            if ($total >= 1 && $pagina <= $Npaginas) {
                $tabla .= '<p class="text-right">Mostrando usuario ' . $reg_inicio . ' al ' . $reg_final . ' de un total de ' . $total . '</p>';

                $tabla .= mainModel::paginador_tablas($pagina, $Npaginas, $url, 5);
            }
            return $tabla;
        
    }

    public function eliminar_usuario_controlador()
    {
        $id = mainModel::decryption($_POST['usuario_id_del']);
        $id = mainModel::limpiar_cadena($id);

        //comprobar usuario principal
        if ($id == 1) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "No es posible eliminar el usuario",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        //comprobar usuario en BD
        $check_usuario = mainModel::ejecutar_consulta_simple("SELECT id FROM usuarios WHERE id='$id'");
        if ($check_usuario->rowCount() <= 0) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "El usuario no existe en el sistema",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $eliminar_usuario = usuarioModelo::eliminar_usuario_modelo($id);
        if ($eliminar_usuario->rowCount() == 1) {
            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "Usuario Eliminado",
                "Texto" => "El usuario fue eliminado del sistema",
                "Tipo" => "success"
            ];
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "No fue posible eliminar el usuario",
                "Tipo" => "error"
            ];
        }
        echo json_encode($alerta);
    }

    public function datos_usuario_controlador($tipo, $id)
    {

        $tipo = mainModel::limpiar_cadena($tipo);
        $id = mainModel::decryption($id);
        $id = mainModel::limpiar_cadena($id);

        return usuarioModelo::datos_usuario_modelo($tipo, $id);
    }

    public function actualizar_usuario_controlador()
    {
        //comprobar id
        $id = mainModel::decryption($_POST['usuario_id_up']);
        $id = mainModel::limpiar_cadena($id);

        $check_user = mainModel::ejecutar_consulta_simple("SELECT * FROM usuarios WHERE id='$id'");
        if ($check_user->rowCount() <= 0) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "No se encontro el usuario en el sistema",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        } else {

            $campos = $check_user->fetch();
        }

        $nombre = mainModel::limpiar_cadena($_POST['usuario_nombre_up']);
        $apellido = mainModel::limpiar_cadena($_POST['usuario_apellido_up']);
        $usuario = mainModel::limpiar_cadena($_POST['usuario_usuario_up']);
        $email = mainModel::limpiar_cadena($_POST['usuario_email_up']);

        if (isset($_POST['usuario_rol_up'])) {
            $rol = mainModel::limpiar_cadena($_POST['usuario_rol_up']);
        } else {
            $rol = $campos['rol_usuario'];
        }

        if ($nombre == "" || $apellido == "" || $usuario == "" || $rol == "") {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrio un error inesperado",
                "Texto" => "No se han llenado todos los campos",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        if($usuario != $campos['usuario_usuario']) {
            $check_usuario = mainModel::ejecutar_consulta_simple("SELECT usuario_usuario FROM usuarios WHERE usuario_usuario='$usuario'");
            if ($check_usuario->rowCount() > 0) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "El NOMBRE DE USUARIO ingresado ya se encuentra registrado en el sistema",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }
        }

        if($email!=$campos['email_usuario'] && $email!=""){
            if(filter_var($email,FILTER_VALIDATE_EMAIL)){
                $check_email=mainModel::ejecutar_consulta_simple("SELECT email_usuario FROM usuarios WHERE email_usuario='$email'");
                if($check_email->rowCount()>0){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrio un error inesperado",
                        "Texto"=>"El email ya existe en el sistema",
                        "Tipo"=>"error"
                    ];
                    echo json_encode($alerta);
                    exit();

                }
            }else{
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"Se ha ingresado un correo no valido",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                    exit();
            }

        }

        if($_POST['usuario_clave_nueva_1']!="" || $_POST['usuario_clave_nueva_2']!=""){

            if($_POST['usuario_clave_nueva_1']!=$_POST['usuario_clave_nueva_2']){
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrio un error inesperado",
                    "Texto" => "Las claves ingresadas no coinciden",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }else{
                $clave=mainModel::encryption($_POST['usuario_clave_nueva_1']);
            }
        }else{
            $clave=$campos['clave_usuario'];
        }
    
        $datos_usuario_up=[
            "Nombre"=>$nombre,
            "Apellido"=>$apellido,
            "Usuario"=>$usuario,
            "Clave"=>$clave,
            "Rol"=>$rol,
            "Email"=>$email,
            "ID"=>$id
        ];

        if(usuarioModelo::actualizar_usuario_modelo($datos_usuario_up)){
            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "Datos actualizados",
                "Texto" => "Se han actualizados los datos",
                "Tipo" => "success"
            ];
        }else{
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrio un error inesperado",
                "Texto" => "No fue posible actualizar el usuario",
                "Tipo" => "error"
            ];
        }
        echo json_encode($alerta);

    }

    public function listar_asesores_controlador(){
        $sql=mainModel::conectar()->prepare("SELECT * FROM usuarios WHERE rol_usuario='Asesor' ORDER BY nombre_usuario ASC");
        $sql->execute();
        return $sql;
    }

    public function paginar_asesores_controlador($pagina, $registros, $url, $busqueda){

        $pagina = mainmodel::limpiar_cadena($pagina);
        $registros = mainModel::limpiar_cadena($registros);
        $url = mainModel::limpiar_cadena($url);
        $url = SERVERURL . $url . "/";
        $busqueda = mainModel::limpiar_cadena($busqueda);
        $tabla = "";

        $pagina = (isset($pagina) && $pagina > 0) ? (int) $pagina : 1;
        $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;

        if(isset($busqueda)){
            $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM usuarios WHERE rol_usuario='Asesor' ORDER BY nombre_usuario ASC LIMIT $inicio,$registros";
            
            $conexion = mainModel::conectar();
            $datos = $conexion->query($consulta);
            $datos = $datos->fetchAll();
            $total = $conexion->query("SELECT FOUND_ROWS()");
            $total = (int)$total->fetchColumn();

            $Npaginas = ceil($total / $registros);

            $tabla.='
            <div class="table-responsive">
            <table class="table table-dark table-sm">
            <thead>
            <tr class="text-center roboto-medium">
            <th>#</th>
            <th>NOMBRE</th>
            <th>APELLIDO</th>
            <th>HORARIOS ASESORIAS</th>
            </tr>
            </thead>
            <tbody>
            ';

            if($total >= 1 && $pagina <= $Npaginas){
                $contador = $inicio +1;
                $reg_inicio = $inicio +1;
                foreach($datos as $rows){
                    $tabla.='
                    <tr class="text-center">
                    <td>'.$contador.'</td>
                    <td>'.$rows['nombre_usuario'].'</td>
                    <td>'.$rows['apellido_usuario'].'</td>
                    <td>
                    <a href="' . SERVERURL . 'advisory-hour/' . $rows['id'] . '/" class="btn btn-success">
                    <i class="fa fa-calendar"></i>
                    </a>
                    </td>
                    </tr>
                    ';
                    $contador++;

                }
                $reg_final = $contador -1;

            }else{
                if($total >= 1){
                    $tabla.='<tr class="text-center">
                    <td colspan="9">
                    <a href="'.$url.'" class="btn btn-raised btn-primary btn-sm">Haz click para recargar listado</a>
                    </td></tr>
                    ';
                }else{
                    $tabla.='<tr class="text-center"><td colspan="9">No hay registros en el sistema</td></tr> ';

                }
            }
            $tabla.='</tbody></table></div>';

            if($total >= 1 && $pagina <= $Npaginas){
                $tabla.='<p class="text-right">Mostrando registros' .$reg_inicio. 'al' . $reg_final . 'de un total de ' . $total . '</p>';

                $tabla.= mainModel::paginador_tablas($pagina, $Npaginas, $url, 5);

            }
            return $tabla;
        }
    }
}
