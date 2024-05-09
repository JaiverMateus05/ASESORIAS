<?php 

use PHPUnit\Framework\TestCase;

class usuarioTest extends TestCase{

    public function testComprobarDatosUsuario(){

        $nombre = "marco";
        $apellido = "antonio";
        $usuario = "marco32";
        $email = "marco32@gmail.com";
        $clave = "234234";
        $rol = "Asesor";

        $this->assertNotEmpty($nombre && $apellido && $usuario && $email && $clave && $rol);
    }
    public function testComprobarIdValidoEliminarUsario(){

        $id = "2";

        if($id!="" && $id > 0){

            $this->assertEquals("2",$id);
        }
    }
    public function testPaginarUsuarios(){

        $usuario = ["camilo","marco","camilo123","camilo@gmail.com"];

        if($this->assertIsArray($usuario)){
            $this->assertEquals(["camilo","marco","camilo123","camilo@gmail.com"],$usuario);
        }
        
    }
}