<?php 
if($_SESSION['rol_sav']!="Estudiante"){
	echo '<script>
	window.location.href="'.SERVERURL.'home/"
	</script>';
	return;
}

?>

<div class="full-box page-header">
    <h3 class="text-left">
        <i class="fa fa-book"></i> &nbsp; MI AGENDA
    </h3>

</div>
<input type="hidden" value="<?php echo $_SESSION['id_sav'] ?>">
<div class="container-fluid">
    <ul class="full-box list-unstyled page-nav-tabs">
        <li>
            <a href="<?php echo SERVERURL; ?>advisor-agenda/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; AGENDAR NUEVA ASESORIA</a>
        </li>
    </ul>
</div>

<div class="container-fluid">
    <?php
    require_once "./controladores/agendaControlador.php";
    $ins_agenda_us = new agendaControlador();

    echo $ins_agenda_us->paginar_agenda_estudiante_controlador(5, "", $_SESSION['id_sav']);
    ?>
</div>