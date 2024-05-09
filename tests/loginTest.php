<?php

use PHPUnit\Framework\TestCase;

class loginTest extends TestCase{

    public function testComprobarValoresIgualesLogin(){

        $usuario = "admin";
        $contraseña = "43242";

        if($usuario!="" && $contraseña!=""){
            $this->assertEquals("admin",$usuario);
            $this->assertEquals("43242",$contraseña);
        }
    }
    public function testComprobarValoresVacios(){
        $usuario ="fsff";
        $contraseña="ewras";

        $this->assertNotEmpty($usuario && $contraseña);
    }
}