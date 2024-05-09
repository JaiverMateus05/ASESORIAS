<?php 
if($_SESSION['rol_sav']!="Administrador"){
	echo '<script>
	window.location.href="'.SERVERURL.'home/"
	</script>';
	return;
}

?>

<?php

function create_time_range($start, $end, $interval = '60 mins', $format = '12')
{
    $startTime = strtotime($start);
    $endTime   = strtotime($end);
    $returnTimeFormat = ($format == '12') ? 'g:i:s A' : 'G:i:s';

    $current   = time();
    $addTime   = strtotime('+' . $interval, $current);
    $diff      = $addTime - $current;

    $times = array();
    while ($startTime < $endTime) {
        $times[] = date($returnTimeFormat, $startTime);
        $startTime += $diff;
    }
    $times[] = date($returnTimeFormat, $startTime);
    return $times;
} ?>
<div class="full-box page-header">
    <h3 class="text-left">
        <i class="fas fa-clipboard-list fa-fw"></i> &nbsp; ASIGNAR HORARIO ASESORIAS
    </h3>
</div>
<div class="container-fluid">
    <ul class="full-box list-unstyled page-nav-tabs">
        
        <li>
            <a href="<?php echo SERVERURL; ?>advisor-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE ASESORES</a>
        </li>
        
    </ul>
</div>
<table class="table table-bordered  table-striped table-sm" id="tbClaseHorario">
    <thead>
        <tr>
            <?php
            $dias = array("Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado", "Domingo");
            for ($i = 0; $i < COUNT($dias); $i++) {
                echo "<th style ='color: black;'>" . $dias[$i] . "</th>";
            }
            ?>
        </tr>
    </thead>
    <tbody>
        <?php
        $horario_asesoria = create_time_range("8:00", "16:00", "60 mins");
        foreach ($horario_asesoria as $value) {
            echo "<tr>";
            for ($a = 0; $a < COUNT($dias); $a++) {

                require_once "./controladores/horarioAsesoriaControlador.php";
                $horaAs = new horarioAsesoriaControlador();
                $datosAs = $horaAs->listas_horas_asesoria_controlador($pagina[1]);

                
        ?>
                <td>
                    
                    <form action="<?php echo SERVERURL; ?>ajax/horarioAjax.php" class="FormularioAjax" method="POST" data-form="save" autocomplete="off">
                        <input type="hidden" name="usuario_id_as" id="usuario_id"value="<?php echo $pagina[1]; ?>">
                        <input name="hora_asesoria_reg" id="hora_asesoria" value="<?php echo $dias[$a] . " " . $value; ?>" type="hidden"><br>
                        <label><?php echo $value; ?></label>
                        <button type="submit" class="btn btn-success" style="padding: 1px 6px;"><span class="fa fa-check-square"></span></button>                                   
                    </form>
                    <form action="<?php echo SERVERURL; ?>ajax/horarioAjax.php" class="FormularioAjax" method="POST" data-form="delete" autocomplete="off">
                        <input type="hidden" name="usuario_id_del" id="usuario_id"value="<?php echo $pagina[1]; ?>">
                        <input name="hora_asesoria_del" id="hora_asesoria" value="<?php echo $dias[$a] . " " . $value; ?>" type="hidden">
                        <button type="submit" class="btn btn-danger" style="padding: 1px 6px;"><span class="fa fa-window-close"></span></button>
                    </form>
                </td>
        <?php
                
            }
            echo "</tr>";
        }
        ?>
    </tbody>
</table>