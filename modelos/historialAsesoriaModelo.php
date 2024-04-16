<?php 

require_once "mainModel.php";

class historialAsesoriaModelo extends mainModel{


    protected static function datos_asesoria_modelo($id){
        $sql = mainModel::conectar()->prepare("SELECT * FROM asesoria_finalizada WHERE id=:ID");
        $sql->bindParam(":ID",$id);
        $sql->execute();
        return $sql;
    }

    protected static function actualizar_historial_modelo($datos){
        $sql=mainModel::conectar()->prepare("UPDATE asesoria_finalizada SET descripcion_finalizada=:Descripcion WHERE id=:ID");
        $sql->bindParam(":Descripcion",$datos['Descripcion']);
        $sql->bindParam(":ID",$datos['ID']);
        $sql->execute();
        return $sql;

    }
}