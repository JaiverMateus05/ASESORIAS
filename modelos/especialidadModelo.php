<?php 

require_once "mainModel.php";

class especialidadModelo extends mainModel{

    protected static function crear_especialidad_modelo($datos){

        $sql=mainModel::conectar()->prepare("INSERT INTO especialidad(nombre_especialidad) VALUES (:Nombre)");
        $sql->bindParam(":Nombre",$datos['Nombre']);
        $sql->execute();
        return $sql;
    }

    protected static function eliminar_especialidad_modelo($id){

        $sql=mainModel::conectar()->prepare("DELETE FROM especialidad WHERE id=:ID");
        $sql->bindParam(":ID",$id);
        $sql->execute();
        return $sql;
    }

    protected static function asignar_especialidad_modelo($datos){

        $sql=mainModel::conectar()->prepare("INSERT INTO asesor(id_usuario,id_especialidad) VALUES (:IdUsuario, :IdEspecialidad)");
        $sql->bindParam(":IdUsuario",$datos['IdUsuario']);
        $sql->bindParam(":IdEspecialidad",$datos['IdEspecialidad']);
        $sql->execute();
        return $sql;
    }
}