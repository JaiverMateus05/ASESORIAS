<?php

require_once "mainModel.php";

class agendaModelo extends mainModel
{

    protected static function agendar_asesoria_modelo($datos)
    {
        $sql = mainModel::conectar()->prepare("INSERT INTO asesoria(id_asesor,id_estudiante,fecha_asesoria,link_asesoria,estado_asesoria,id_horario_asesoria) 
        VALUES (:IdAsesor, :IdEstudiante, :FechaAsesoria, :LinkAsesoria, :EstadoAsesoria, :IdHorarioAsesoria)");
        $sql->bindParam(":IdAsesor", $datos['IdAsesor']);
        $sql->bindParam(":IdEstudiante", $datos['IdEstudiante']);
        $sql->bindParam(":FechaAsesoria", $datos['FechaAsesoria']);
        $sql->bindParam(":LinkAsesoria", $datos['LinkAsesoria']);
        $sql->bindParam(":EstadoAsesoria", $datos['EstadoAsesoria']);
        $sql->bindParam(":IdHorarioAsesoria", $datos['IdHorarioAsesoria']);
        $sql->execute();
        return $sql;
    }

    protected static function finalizar_asesoria_modelo($datos)
    {

        $sql = mainModel::conectar()->prepare("INSERT INTO asesoria_finalizada(id_asesoria,id_asesor) VALUES (:IdAsesoria, :IdAsesor)");
        $sql->bindParam(":IdAsesoria", $datos['IdAsesoria']);
        $sql->bindParam(":IdAsesor", $datos['IdAsesor']);
        $sql->execute();
        return $sql;
    }

    protected static function finalizar_asesoria1_modelo($id)
    {
        $sql2 = mainModel::conectar()->prepare("UPDATE asesoria SET estado_asesoria='Finalizada' WHERE id ='$id'");
        $sql2->execute();
        return $sql2;
    }
}
