<?php 

if($peticionAjax){
    require_once "../modelos/horarioAsesoriaModelo.php";
}else{
    require_once "./modelos/horarioAsesoriaModelo.php";
}

class horarioAsesoriaControlador extends horarioAsesoriaModelo{

    public function agregar_horario_asesoria_controlador(){
        $id_asesor = mainModel::limpiar_cadena($_POST['usuario_id_as']);
        $hora_asesoria = mainModel::limpiar_cadena($_POST['hora_asesoria_reg']);


        $check_hora_as = mainModel::ejecutar_consulta_simple("SELECT id_asesor, hora_asesoria FROM horario_asesorias WHERE id_asesor='$id_asesor' AND hora_asesoria='$hora_asesoria'");
        if($check_hora_as->rowCount() > 0){
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrio un error inesperado",
                "Texto" => "El asesor ya cuenta con este horario para asesorias",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();

        }
        
        $datos_horas_reg = [
            "IdAsesor" => $id_asesor,
            "HoraAsesoria" => $hora_asesoria,
            "Estado" => "Disponible"
        ];

        $agregar_hora = horarioAsesoriaModelo::agregar_horario_asesoria_modelo($datos_horas_reg);

        if($agregar_hora->rowCount() == 1){
            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "Hora Asignada",
                "Texto" => "Se guardo la hora exitosamente",
                "Tipo" => "success"
            ];

        }else{
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrio un error inesperado",
                "Texto" => "No fue posible asignar la hora",
                "Tipo" => "error"
            ];
        }

        echo json_encode($alerta);
    }

    public function listas_horas_asesoria_controlador($id){
        $sql=mainModel::conectar()->prepare("SELECT * FROM horario_asesorias WHERE id_asesor='$id'");
        $sql->execute();
        return $sql;
    }
}