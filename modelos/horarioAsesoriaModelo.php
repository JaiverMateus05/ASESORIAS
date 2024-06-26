<?php 

require_once "mainModel.php";

class horarioAsesoriaModelo extends mainModel{


    protected static function agregar_horario_asesoria_modelo($datos){
        $sql=mainModel::conectar()->prepare("INSERT INTO horario_asesorias(id_asesor,hora_asesoria,estado) 
        VALUES (:IdAsesor, :HoraAsesoria, :Estado)");
        $sql->bindParam(":IdAsesor",$datos['IdAsesor']);
        $sql->bindParam(":HoraAsesoria",$datos['HoraAsesoria']);
        $sql->bindParam(":Estado",$datos['Estado']);
        $sql->execute();
        return $sql;
    }

    protected static function eliminar_horario_asesoria_modelo($id_usuario,$hora_asesoria){

        $sql=mainModel::conectar()->prepare("DELETE FROM horario_asesorias WHERE id_asesor='$id_usuario' AND hora_asesoria='$hora_asesoria'");
        $sql->execute();
        return $sql;
    }

}