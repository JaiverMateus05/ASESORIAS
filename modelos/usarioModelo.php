<?php 

require_once "mainModel.php";

class usuarioModelo extends mainModel{

    protected static function agregar_usuario_modelo($datos){
        $sql=mainModel::conectar()->prepare("INSERT INTO usuarios(nombre_usuario,apellido_usuario,usuario_usuario,clave_usuario,rol_usuario,email_usuario) 
        VALUES (:Nombre, :Apellido, :Usuario, :Clave, :Rol, :Email)");
        $sql->bindParam(":Nombre",$datos['Nombre']);
        $sql->bindParam(":Apellido",$datos['Apellido']);
        $sql->bindParam(":Usuario",$datos['Usuario']);
        $sql->bindParam(":Clave",$datos['Clave']);
        $sql->bindParam(":Rol",$datos['Rol']);
        $sql->bindParam(":Email",$datos['Email']);
        $sql->execute();
        return $sql;
    }

    protected static function eliminar_usuario_modelo($id){

        $sql=mainModel::conectar()->prepare("DELETE FROM usuarios WHERE id=:ID");
        $sql->bindParam(":ID",$id);
        $sql->execute();
        return $sql;
    }

    protected static function datos_usuario_modelo($tipo,$id){

        if($tipo=="Unico"){

            $sql=mainModel::conectar()->prepare("SELECT * FROM usuarios WHERE id=:ID");
            $sql->bindParam(":ID",$id);

        }elseif($tipo=="Conteo"){

            $sql=mainModel::conectar()->prepare("SELECT id FROM usuarios WHERE id!='1'");
        }
        $sql->execute();
        return $sql;
    }

    protected static function actualizar_usuario_modelo($datos){

        $sql=mainModel::conectar()->prepare("UPDATE usuarios SET nombre_usuario=:Nombre, apellido_usuario=:Apellido,usuario_usuario=:Usuario,
        clave_usuario=:Clave,rol_usuario=:Rol,email_usuario=:Email WHERE id=:ID");

        $sql->bindParam(":Nombre",$datos['Nombre']);
        $sql->bindParam(":Apellido",$datos['Apellido']);
        $sql->bindParam(":Usuario",$datos['Usuario']);
        $sql->bindParam(":Clave",$datos['Clave']);
        $sql->bindParam(":Rol",$datos['Rol']);
        $sql->bindParam(":Email",$datos['Email']);
        $sql->bindParam(":ID",$datos['ID']);
        $sql->execute();
        return $sql;
    }
}