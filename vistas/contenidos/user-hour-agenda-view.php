<div class="full-box page-header">
    <h3 class="text-left">
        <i class="fas fa-search fa-fw"></i> &nbsp; AGENDAR ASESORIA
    </h3>
</div>

<div class="container-fluid">
    <ul class="full-box list-unstyled page-nav-tabs">
        <li>
            <a href="<?php echo SERVERURL; ?>advisor-agenda/"><i class="fa fa-user"></i> &nbsp; BUSCAR ASESOR</a>
        </li>

    </ul>
</div>

<div class="container-fluid">
    <?php 
    require_once "./controladores/especialidadControlador.php";
    $ins_hora_as = new especialidadControlador();
    echo $ins_hora_as->paginar_horarios_asesoria_controlador(5,"",$pagina[1]);
    ?>
</div>