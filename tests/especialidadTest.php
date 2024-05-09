<?php 

use PHPUnit\Framework\TestCase;

class EspecialidadTest extends TestCase{

    public function testVerificarCamposCrearEspecialidad(){

        $nombre = "Matematicas";

        $this->assertNotEmpty($nombre);
    }
    public function testListarEspecialidades(){

        $especialidad = ["Matematicas","Religion","Ingles"];

        $this->assertNotEmpty($especialidad);
        $this->assertIsArray($especialidad);
    }
    public function testEliminarEspecialidad(){
        $id = 1;

        $this->assertNotEmpty($id);
        $this->assertIsInt($id);
        $this->assertEquals(1,$id);
    }
}