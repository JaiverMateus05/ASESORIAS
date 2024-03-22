<?php 

require_once "mainModel.php";

class loginModelo extends mainModel{

    protected static function iniciar_sesion_modelo($datos){

        $sql=mainModel::conectar()->prepare("SELECT * FROM usuarios WHERE usuario_usuario=:Usuario AND clave_usuario=:Clave");
        $sql->bindParam(":Usuario",$datos['Usuario']);
        $sql->bindParam(":Clave",$datos['Clave']);
        $sql->execute();
        return $sql;
    }
}