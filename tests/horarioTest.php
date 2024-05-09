<?php 

use PHPUnit\Framework\TestCase;

class horarioTest extends TestCase{

    public function testAgregarHorarioAsesoria(){
        $id_asesor = 3;
        $hora_asesoria = "Lunes 8:00 am";

        $this->assertIsInt($id_asesor);
        $this->assertIsString($hora_asesoria);
        $this->assertNotEmpty($id_asesor,$hora_asesoria);
    }
    public function testListarHorariosAsesoria(){

        $id = 5;

        $this->assertNotNull($id);
        $this->assertIsInt($id);

    }
}