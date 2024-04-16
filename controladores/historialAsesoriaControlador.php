<?php 

if ($peticionAjax) {
    require_once "../modelos/historialAsesoriaModelo.php";
} else {
    require_once "./modelos/historialAsesoriaModelo.php";
}


class historialAsesoriaControlador extends historialAsesoriaModelo{

    public function paginar_historial_finalizada_controlador($pagina,$registros,$id,$busqueda,$url){
        $pagina = mainModel::limpiar_cadena($pagina);
        $registros = mainModel::limpiar_cadena($registros);
        $id = mainModel::limpiar_cadena($id);

        $url = mainModel::limpiar_cadena($url);
        $url = SERVERURL.$url."/";
        $busqueda = mainModel::limpiar_cadena($busqueda);
        $tabla = "";
        $pagina = (isset($pagina) && $pagina > 0) ? (int)$pagina : 1;
        $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;

        if(isset($busqueda)){
            $consulta = "SELECT F.id, F.id_asesoria,F.descripcion_finalizada, A.fecha_asesoria, H.hora_asesoria FROM asesoria_finalizada F JOIN asesoria A ON F.id_asesoria = A.id JOIN horario_asesorias H ON A.id_horario_asesoria = H.id WHERE F.id_asesor='$id'";
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
        <th>HORA ASESORIA</th>
        <th>FECHA ASESORIA</th>
        <th>DESCRIPCION ASESORIA</th>
        <th>EDITAR</th>
        </tr>
        </thead>
        <tbody>
        ';

        if($total >= 1 && $pagina <= $Npaginas){
            $contador = $inicio + 1;
            $reg_inicio = $inicio + 1;
            foreach($datos as $rows){

                $tabla.='
                <tr class="text-center">
                <td>'.$rows['hora_asesoria'].'</td>
                <td>'.$rows['fecha_asesoria'].'</td>
                <td>'.$rows['descripcion_finalizada'].'</td>
                <td>
                <a href="'.SERVERURL. 'history-update/'.$rows['id'].'/" class="btn btn-success"><i class="fas fa-sync-alt"></i></a>
                </td>
                </tr>
                ';
                $contador++;
            }
            $reg_final = $contador -1;
        }else{
            $tabla.='<tr class="text-center"><td colspan="9">No hay asesorias finalizadas</td></tr>';
        }
        $tabla.='</tbody></table></div>';

        if($total >= 1 && $pagina <= $Npaginas){
            $tabla.='<p class="text-right">Mostrando asesoria ' . $reg_inicio . ' al ' .$reg_final. ' de un total de ' . $total . '</p>';

            $tabla.= mainModel::paginador_tablas($pagina, $Npaginas,$url,5);

        }

        return $tabla;

    }

    public function paginar_historial_controlador($pagina,$registros,$id,$busqueda,$url){
        $pagina = mainModel::limpiar_cadena($pagina);
        $registros = mainModel::limpiar_cadena($registros);
        $id = mainModel::limpiar_cadena($id);

        $url = mainModel::limpiar_cadena($url);
        $url = SERVERURL.$url."/";
        $busqueda = mainModel::limpiar_cadena($busqueda);
        $tabla = "";
        $pagina = (isset($pagina) && $pagina > 0) ? (int)$pagina : 1;
        $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;

        if(isset($busqueda)){
            $consulta = "SELECT F.id, F.id_asesoria,F.descripcion_finalizada, A.fecha_asesoria, H.hora_asesoria FROM asesoria_finalizada F JOIN asesoria A ON F.id_asesoria = A.id JOIN horario_asesorias H ON A.id_horario_asesoria = H.id WHERE F.id_asesor='$id'";
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
        <th>HORA ASESORIA</th>
        <th>FECHA ASESORIA</th>
        <th>DESCRIPCION ASESORIA</th>
        </tr>
        </thead>
        <tbody>
        ';

        if($total >= 1 && $pagina <= $Npaginas){
            $contador = $inicio + 1;
            $reg_inicio = $inicio + 1;
            foreach($datos as $rows){

                $tabla.='
                <tr class="text-center">
                <td>'.$rows['hora_asesoria'].'</td>
                <td>'.$rows['fecha_asesoria'].'</td>
                <td>'.$rows['descripcion_finalizada'].'</td>
                </tr>
                ';
                $contador++;
            }
            $reg_final = $contador -1;
        }else{
            $tabla.='<tr class="text-center"><td colspan="9">No hay asesorias finalizadas</td></tr>';
        }
        $tabla.='</tbody></table></div>';

        if($total >= 1 && $pagina <= $Npaginas){
            $tabla.='<p class="text-right">Mostrando asesoria ' . $reg_inicio . ' al ' .$reg_final. ' de un total de ' . $total . '</p>';

            $tabla.= mainModel::paginador_tablas($pagina, $Npaginas,$url,5);

        }

        return $tabla;

    }

    public function datos_asesoria_controlador($id){
        $id = mainModel::limpiar_cadena($id);

        return historialAsesoriaModelo::datos_asesoria_modelo($id);
    }

    public function actualizar_historial_controlador(){

        $id = mainModel::limpiar_cadena($_POST['id_asesoria_finalizada_up']);
        $descripcion = mainModel::limpiar_cadena($_POST['descripcion_asesoria']);

        $datos_historial_up = [
            "Descripcion" => $descripcion,
            "ID" => $id
        ];

        if(historialAsesoriaModelo::actualizar_historial_modelo($datos_historial_up)){
            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "Datos actualizados",
                "Texto" => "Se ha actualizado la descripcion",
                "Tipo" => "success"
            ];
        }else{
            $alerta = [
            "Alerta" => "simple",
            "Titulo" => "Ocurrio un error inesperado",
            "Texto" => "No fue posible actualizar la descripcion",
            "Tipo" => "error"
            ];
        }
        echo json_encode($alerta);
    }
}