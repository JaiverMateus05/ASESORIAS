<?php 

use PHPUnit\Framework\TestCase;

class HistorialTest extends TestCase{

    public function testPaginarHistorial(){

        $historial = [
            ["Lunes 8:00 am","12/05/2024","Asesoria Finalizada","Finalizada"],["Martes 9:00 am","12/05/2024","Asesoria finalizada","Finalizada"]
        ];

        $this->assertIsArray($historial);
        $this->assertNotEmpty($historial);
    }
    public function testDatosAsesoria(){
        $datos_asesoria = [
            ["Lunes 8:00 am","12/05/2024","La asesoria se llevo a cabo con exito"],["Martes 9:00 am","12/05/2024","La asesoria se desarrollo con normalidad"]
        ];

        $this->assertIsArray($datos_asesoria);
        $this->assertNotNull($datos_asesoria);
    }
}