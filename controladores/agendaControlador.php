<?php

if ($peticionAjax) {
    require_once "../modelos/agendaModelo.php";
} else {
    require_once "./modelos/agendaModelo.php";
}

class agendaControlador extends agendaModelo
{

    public function agendar_asesoria_controlador()
    {

        $id_estudiante = mainModel::limpiar_cadena($_POST['id_estudiante_ag']);
        $id_asesor = mainModel::limpiar_cadena($_POST['id_asesor_ag']);
        $id_hora_asesoria = mainModel::limpiar_cadena($_POST['id_hora_ag']);
        $fecha_asesor = $_POST['fecha_asesoria_'];

        $check_agenda = mainModel::ejecutar_consulta_simple("SELECT id_horario_asesoria, fecha_asesoria FROM asesoria WHERE id_horario_asesoria='$id_hora_asesoria' AND fecha_asesoria='$fecha_asesor'");
        if ($check_agenda->rowCount() > 0) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrio un error inesperado",
                "Texto" => "Ya se ha agendado en esta fecha, seleccione una diferente",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $datos_agenda_reg = [
            "IdAsesor" => $id_asesor,
            "IdEstudiante" => $id_estudiante,
            "LinkAsesoria" => "https://meet.google.com/div-sjmo-hqp",
            "EstadoAsesoria" => "Activa",
            "IdHorarioAsesoria" => $id_hora_asesoria,
            "FechaAsesoria" => $fecha_asesor
        ];

        $agendarAsesoria = agendaModelo::agendar_asesoria_modelo($datos_agenda_reg);

        if ($agendarAsesoria->rowCount() == 1) {
            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "Asesoria Agendada",
                "Texto" => "Se agendo la asesoria exitosamente",
                "Tipo" => "success"
            ];
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrio un error inesperado",
                "Texto" => "No fue posible agendar la asesoria",
                "Tipo" => "error"
            ];
        }

        echo json_encode($alerta);
    }

    public function paginar_agenda_estudiante_controlador($registros, $busqueda, $id)
    {
        $registros = mainModel::limpiar_cadena($registros);
        $busqueda = mainModel::limpiar_cadena($busqueda);
        $id = mainModel::limpiar_cadena($id);

        $tabla = "";

        if (isset($busqueda)) {
            $consulta = "SELECT U.nombre_usuario, U.apellido_usuario, H.hora_asesoria, A.link_asesoria, A.fecha_asesoria FROM asesoria A JOIN usuarios U ON A.id_asesor = U.id JOIN horario_asesorias H ON A.id_horario_asesoria = H.id WHERE A.id_estudiante='$id' AND A.estado_asesoria = 'Activa' ORDER BY A.fecha_asesoria ASC";
        }

        $conexion = mainModel::conectar();
        $datos = $conexion->query($consulta);
        $datos = $datos->fetchAll();
        $total = $conexion->query("SELECT FOUND_ROWS()");
        $total = (int)$total->fetchColumn();

        $tabla .= '
        <div class="table-responsive">
        <table class="table table-dark table-sm">
        <thead>
        <tr class="text-center roboto-medium">
        <th>HORA ASESORIA</th>
        <th>FECHA ASESORIA</th>
        <th>NOMBRE ASESOR</th>
        <th>LINK ASESORIA</th>
        </tr>
        </thead>
        <tbody>
        ';

        if ($total >= 1) {
            foreach ($datos as $rows) {
                $tabla .= '
                <tr class="text-center">
                <td>' . $rows['hora_asesoria'] . '</td>
                <td>' . $rows['fecha_asesoria'] . '</td>
                <td>' . $rows['nombre_usuario'] . ' ' . $rows['apellido_usuario'] . '</td>
                <td>
                <a href="' . $rows['link_asesoria'] . '" class="btn btn-success" target="_blank">LINK ASESORIA</a>
                </td>
                </tr>
                ';
            }
        } else {
            $tabla .= '<tr class="text-center"><td colspan="9">No hay asesorias agendadas</td></tr>';
        }
        $tabla .= '</tbody></table></div>';

        return $tabla;
    }

    public function paginar_agenda_asesor_controlador($pagina, $registros, $id, $busqueda, $url)
    {
        $pagina = mainModel::limpiar_cadena($pagina);
        $registros = mainModel::limpiar_cadena($registros);
        $id = mainModel::limpiar_cadena($id);

        $url = mainModel::limpiar_cadena($url);
        $url = SERVERURL . $url . "/";
        $busqueda = mainModel::limpiar_cadena($busqueda);
        $tabla = "";
        $pagina = (isset($pagina) && $pagina > 0) ? (int)$pagina : 1;
        $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;

        if (isset($busqueda)) {
            $consulta = "SELECT U.nombre_usuario, U.apellido_usuario, H.hora_asesoria, A.link_asesoria, A.fecha_asesoria, A.id, A.estado_asesoria FROM asesoria A JOIN usuarios U ON A.id_estudiante = U.id JOIN horario_asesorias H ON A.id_horario_asesoria = H.id WHERE A.id_asesor='$id' AND A.estado_asesoria = 'Activa'";
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
        <th>HORA ASESORIA</th>
        <th>FECHA ASESORIA</th>
        <th>NOMBRE ESTUDIANTE</th>
        <th>ESTADO ASESORIA</th>
        <th>LINK ASESORIA</th>
        <th>ACCION</th>
        </tr>
        </thead>
        <tbody>
        ';

        if ($total >= 1 && $pagina <= $Npaginas) {
            $contador = $inicio + 1;
            $reg_inicio = $inicio + 1;
            foreach ($datos as $rows) {

                $tabla .= '
                <tr class="text-center">
                <td>' . $rows['hora_asesoria'] . '</td>
                <td>' . $rows['fecha_asesoria'] . '</td>
                <td>' . $rows['nombre_usuario'] . ' ' . $rows['apellido_usuario'] . '</td>
                <td>' . $rows['estado_asesoria'] . '</td>
                <td>
                <a href="' . $rows['link_asesoria'] . '" class="btn btn-success" target="_blank">LINK ASESORIA</a>
                </td>
                <td>
                <form action="' . SERVERURL . 'ajax/agendaAjax.php" class="FormularioAjax" method="POST" data-form="" autocomplete="off">
                <input type="hidden" name="id_asesoria_fin" id="id_asesoria_fin" value="' . $rows['id'] . '">
                <input type="hidden" name="id_asesor_fin" id="id_asesor_fin" value="' . $_SESSION['id_sav'] . '">
                <input type="hidden" name="estado_asesoria_fin" id="estado_asesoria_fin" value="' . $rows['estado_asesoria'] . '">
                <button class="btn btn-success">FINALIZAR</button>
                </form>
                </td>
                ';
                $contador++;
            }
            $reg_final = $contador - 1;
        } else {
            $tabla .= '<tr class="text-center"><td colspan="9">No hay asesorias agendadas</td></tr>';
        }
        $tabla .= '</tbody></table></div>';

        if ($total >= 1 && $pagina <= $Npaginas) {
            $tabla .= '<p class="text-right">Mostrando asesoria ' . $reg_inicio . ' al ' . $reg_final . ' de un total de ' . $total . '</p>';

            $tabla .= mainModel::paginador_tablas($pagina, $Npaginas, $url, 5);
        }
        return $tabla;
    }

    public function finalizar_asesoria_controlador()
    {
        $id_asesoria = mainModel::limpiar_cadena($_POST['id_asesoria_fin']);
        $id_asesor = mainModel::limpiar_cadena($_POST['id_asesor_fin']);

        $check_asesoria = mainModel::ejecutar_consulta_simple("SELECT id,id_asesor FROM asesoria WHERE id='$id_asesoria' AND id_asesor='$id_asesor'");
        if ($check_asesoria->rowCount() <= 0) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrio un error inesperado",
                "Texto" => "La asesoria seleccionada no existe",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $datos_asesoria_fin = [
            "IdAsesoria" => $id_asesoria,
            "IdAsesor" => $id_asesor,
        ];

        $agregar_asesoria_fin = agendaModelo::finalizar_asesoria_modelo($datos_asesoria_fin);

        if ($agregar_asesoria_fin->rowCount() == 1){
            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "Se ha finalizado la asesoria",
                "Text" => "Se ha cambiado el estado de la asesoria",
                "Tipo" => "success"
            ];
        }else{
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrio un error inesperado",
                "Texto" => "No fue posible actualizar la asesoria",
                "Tipo" => "error"
            ];
        }
        echo json_encode($alerta);
        
    }

    public function finalizar_asesoria1_controlador(){
        $id_asesoria = mainModel::limpiar_cadena($_POST['id_asesoria_fin']);
        $check_asesoria = mainModel::ejecutar_consulta_simple("SELECT id FROM asesoria WHERE id='$id_asesoria'");
        if ($check_asesoria->rowCount() <= 0) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrio un error inesperado",
                "Texto" => "La asesoria seleccionada no existe",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

       
        $agregar_asesoria_fin = agendaModelo::finalizar_asesoria1_modelo($id_asesoria);

    }
}
