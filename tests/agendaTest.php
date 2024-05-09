<?php 

use PHPUnit\Framework\TestCase;

class AgendaTest extends TestCase{

    public function testVerificarDatosAgendaAsesoria(){

        $id_estudiante = 2;
        $id_asesor = 3;
        $id_hora_asesoria = 2;
        $fecha_asesor = "12/15/2024";

        $datos_agenda = [$id_estudiante,$id_asesor,$id_hora_asesoria,$fecha_asesor];

        $this->assertNotEmpty($datos_agenda);
        $this->assertIsArray($datos_agenda);
    }
    public function testVerificarDatosAsesoria(){

        $datos_asesoria = ["Lunes 8:00 am", "15/05/2024", "Camilo"];

        $this->assertNotEmpty($datos_asesoria);
        $this->assertIsArray($datos_asesoria);
        $this->assertIsList($datos_asesoria);
    }
    public function testFinalizarAgenda(){

        $id_asesoria = 1;
        $id_asesor = 3;

        $this->assertIsInt($id_asesor,$id_asesoria);
        $this->assertEquals(1,$id_asesoria && 3,$id_asesor);
    }
}