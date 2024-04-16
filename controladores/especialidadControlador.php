<?php

if ($peticionAjax) {
    require_once "../modelos/especialidadModelo.php";
} else {
    require_once "./modelos/especialidadModelo.php";
}
class especialidadControlador extends especialidadModelo
{

    public function crear_especialidad_controlador()
    {
        $nombre = mainModel::limpiar_cadena($_POST['especialidad_nombre_reg']);



        $check_esp = mainModel::ejecutar_consulta_simple("SELECT nombre_especialidad FROM especialidad WHERE nombre_especialidad='$nombre'");
        if ($check_esp->rowCount() > 0) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrio un error inesperado",
                "Texto" => "La especialidad ya se encuentra registrada",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $datos_especialidad_reg = [
            "Nombre" => $nombre
        ];

        $agregar_especialidad = especialidadModelo::crear_especialidad_modelo($datos_especialidad_reg);
        if ($agregar_especialidad->rowCount() == 1) {
            $alerta = [
                "Alerta" => "limpiar",
                "Titulo" => "Especialidad registrada",
                "Texto" => "La especialidad fue creada",
                "Tipo" => "success"
            ];
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrio un error inesperado",
                "Texto" => "No fue posible crear la especialidad",
                "Tipo" => "error"
            ];
        }
        echo json_encode($alerta);
    }

    public function paginar_especialidad_controlador($pagina, $registros, $url, $busqueda)
    {

        $pagina = mainModel::limpiar_cadena($pagina);
        $registros = mainModel::limpiar_cadena($registros);
        $url = mainModel::limpiar_cadena($url);
        $url = SERVERURL . $url . "/";
        $busqueda = mainModel::limpiar_cadena($busqueda);
        $tabla = "";

        $pagina = (isset($pagina) && $pagina > 0) ? (int) $pagina : 1;
        $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;

        if (isset($busqueda)) {
            $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM especialidad ORDER BY nombre_especialidad ASC LIMIT $inicio,$registros";

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
            <th>NOMBRE ESPECIALIDAD</th>
            <th>ELIMINAR</th>
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
                    <td>'.$rows['nombre_especialidad'].'</td>
                    <td>
                    <form action="'. SERVERURL.'ajax/especialidadAjax.php" class="FormularioAjax" method="POST" data-form="delete" autocomplete="off">
                    <input type="hidden" name="especialidad_id_del" value="'.$rows['id'].'">
                    <button type="submit" class="btn btn-warning">
                    <i class="far fa-trash-alt"></i>
                    </button>
                    </form> 
                    </td>
                    </tr>
                    ';
                    $contador++;
                }
                $reg_final = $contador -1;

            }else{
                if ($total >= 1) {
                    $tabla .= '<tr class="text-center">
                        <td colspan="9">
                        <a href="' . $url . '" class="btn btn-raised btn-primary btn-sm">Haz click para recargar listado</a>
                        </td></tr>
                        ';
                } else {
                    $tabla .= '<tr class="text-center"><td colspan="9">No hay registros en el sistea</td></tr>
                        ';
                }
            }
            $tabla.='</tbody></table></div>';

            if($total >= 1 && $pagina <= $Npaginas){
                $tabla.='<p class="text-right">Mostrando registros' . $reg_inicio . ' al ' . $reg_final . 'de un total de ' . $total . '</p>';

                $tabla.= mainModel::paginador_tablas($pagina, $Npaginas, $url, 5);

            }
            return $tabla;
        }
    }

    public function eliminar_especialidad_controlador(){

        $id = $_POST['especialidad_id_del'];
        $id = mainModel::limpiar_cadena($id);

        $check_espec = mainModel::ejecutar_consulta_simple("SELECT id FROM especialidad WHERE id='$id'");
        if($check_espec->rowCount()<=0){

            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrio un error inesperado",
                "Texto" => "La especialidad seleccionada no existe",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $eliminar_especialidad = especialidadModelo::eliminar_especialidad_modelo($id);
        if($eliminar_especialidad->rowCount() == 1){
            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "Especialidad Eliminada",
                "Texto" => "La especialidad fue eliminada",
                "Tipo" => "success"
            ];
        }else{
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrio un error inesperado",
                "Texto" => "No fue posible eliminar la especialidad",
                "Tipo" => "error"
            ];
        }
        echo json_encode($alerta);
    }

    public function listar_especialidad_controlador(){
        $sql=mainModel::conectar()->prepare("SELECT * FROM especialidad ORDER BY nombre_especialidad ASC");
        $sql->execute();
        return $sql;
    }

    public function asignar_especialidad_controlador(){
        $idUsuario = mainModel::limpiar_cadena($_POST['asesor_user_reg']);
        $idEspecialidad = mainModel::limpiar_cadena($_POST['especialidad_user_reg']);

        $check_asig = mainModel::ejecutar_consulta_simple("SELECT id_usuario, id_especialidad FROM asesor WHERE id_usuario='$idUsuario' AND id_especialidad='$idEspecialidad'");
        if($check_asig->rowCount() > 0){
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrio un error inesperado",
                "Texto" => "La especialidad ya se encuentra asignada al usuario",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();

        }
        $datos_especialidad_usuario=[
            "IdUsuario" => $idUsuario,
            "IdEspecialidad" => $idEspecialidad
        ];

        $asignar_especialidad = especialidadModelo::asignar_especialidad_modelo($datos_especialidad_usuario);

        if($asignar_especialidad->rowCount()==1){
            $alerta = [
                "Alerta" => "limpiar",
                "Titulo" => "Especialidad asignada",
                "Texto" => "La especialidad fue asignada exitosamente",
                "Tipo" => "success"
            ];

        }else{
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrio un error inesperado",
                "Texto" => "No fue posible asignar la especialidad",
                "Tipo" => "error"
            ];
        }
        echo json_encode($alerta);
    }

    public function paginar_especialidad_asesor_controlador($pagina,$registros,$url,$busqueda){
        $pagina = mainModel::limpiar_cadena($pagina);
        $registros = mainModel::limpiar_cadena($registros);

        $url = mainModel::limpiar_cadena($url);
        $url = SERVERURL . $url . "/";

        $busqueda = mainModel::limpiar_cadena($busqueda);
        $tabla = "";
        $pagina = (isset($pagina) && $pagina > 0) ? (int) $pagina : 1;
        $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;

        if(isset($busqueda) && $busqueda != ""){
            $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM usuarios U JOIN asesor A ON U.id = A.id_usuario JOIN especialidad E ON A.id_especialidad = E.id WHERE E.nombre_especialidad LIKE '%$busqueda%' ORDER BY nombre_usuario ASC LIMIT $inicio,$registros";
        }

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
        <th>NOMBRE ASESOR</th>
        <th>ACCION</th>
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
                <td> '.$rows['nombre_usuario'].' '.$rows['apellido_usuario'].'</td>
                <td>
                <a href="'.SERVERURL.'user-hour-agenda/' . $rows['id_usuario'].'/" class="btn btn-success">AGENDAR</a>
                
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
                <a href ="'.$url.'" class="btn btn-raised btn-primary btn-sm">Haz click para recargar listado</a>
                </td></tr>
                ';
            }else{
                $tabla.='<tr class="text-center"><td colspan="9">No hay asesores con la especialidad seleccionada en el sistema</td></tr>';
            }
        }
        $tabla.='</tbody></table></div>';

        if($total >= 1 && $pagina <= $Npaginas){
            $tabla.='<p class="text-right">Mostrando asesor' .$reg_inicio.' al ' . $reg_final . 'de un total de' . $total . '</p>';

            $tabla.=mainModel::paginador_tablas($pagina,$Npaginas,$url,5);


        }

        return $tabla;
    }

    public function paginar_horarios_asesoria_controlador($registros, $busqueda,$id){

        $registros = mainModel::limpiar_cadena($registros);
        $busqueda = mainModel::limpiar_cadena($busqueda);
        $id = mainModel::limpiar_cadena($id);

        $tabla = "";

        if(isset($busqueda)){
            $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM horario_asesorias WHERE id_asesor = '$id'";
        }

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
        <tr class="text-center roboto-meduim">
        <th>HORA ASESORIA</th>
        <th>ESTADO</th>
        <th>FECHA ASESORIA</th>
        
        </tr>
        </thead>
        <tbody>
        

        ';
        if($total >=1){
            foreach ($datos as $rows){
                $tabla.='
                <tr class="text-center">
                
                <td>'.$rows['hora_asesoria'].'</td>
                <td>'.$rows['estado'].'</td>
                <td>
                <form action="'.SERVERURL.'ajax/agendaAjax.php" class="FormularioAjax" method="POST" data-form="save" autocomplete="off">
                <input type="hidden" name="id_estudiante_ag" value="'.$_SESSION['id_sav'].'">
                <input type="hidden" name="id_asesor_ag" value="'.$rows['id_asesor'].'">
                <input type="hidden" name="id_hora_ag" value="'.$rows['id'].'">
                <input type="date" name="fecha_asesoria_" id="fecha_asesoria_" class="form-control">
                <button type="submit" class="btn btn-success">Agendar</button>
                </form>
                </td>
                
                
                </tr>
                ';
            }
        }else{
            $tabla.='<tr class="text-center"><td colspan="9">El asesor no cuenta con horarios disponibles</td></tr>';
        }
        $tabla.='</tbody></table></div>';

        return $tabla;

    }
}
