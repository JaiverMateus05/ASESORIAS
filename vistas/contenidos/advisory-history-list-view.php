<div class="full-box page-header">
    <h3 class="text-left">
        <i class="fa fa-book"></i> &nbsp; HISTORIAL DE ASESORIAS
    </h3>
</div>
<div class="container-fluid">
    <ul class="full-box list-unstyled page-nav-tabs">
        <li>
            <a href="<?php echo SERVERURL; ?>my-agenda-A/"><i class="fa fa-calendar"></i> &nbsp; MIS ASESORIAS</a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>finished-advisory-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; ASESORIAS FINALIZADAS</a>
        </li>
        <li>
            <a class="active" href="<?php echo SERVERURL; ?>advisory-history-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; HISTORIAL DE ASESORIAS</a>
        </li>
    </ul>
</div>
<div class="container-fluid">
    <?php 
    require_once "./controladores/historialAsesoriaControlador.php";
    $ins_histo = new historialAsesoriaControlador();

    echo $ins_histo->paginar_historial_controlador($pagina[1],5,$_SESSION['id_sav'],"",$pagina[0]);
    ?>
</div>