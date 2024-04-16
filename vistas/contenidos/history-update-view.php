<div class="full-box page-header">
    <h3 class="text-left">
        <i class="fa fa-book"></i> &nbsp; MI AGENDA
    </h3>
</div>
<div class="container-fluid">
    <ul class="full-box list-unstyled page-nav-tabs">
        <li>
            <a href="<?php echo SERVERURL; ?>my-agenda-A/"><i class="fa fa-calendar"></i> &nbsp; AGENDAR NUEVA ASESORIA</a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>finished-advisory-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; ASESORIAS FINALIZADAS</a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>advisory-history-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; HISTORIAL DE ASESORIAS</a>
        </li>
    </ul>
</div>
<div class="container-fluid">
    <?php 
    require_once "./controladores/historialAsesoriaControlador.php";
    $ins_datos = new historialAsesoriaControlador();

    $datos_asesoria=$ins_datos->datos_asesoria_controlador($pagina[1]);

    if($datos_asesoria->rowCount()==1){
        $campos=$datos_asesoria->fetch();
    
    ?>
    <form action="<?php echo SERVERURL; ?>ajax/historialAjax.php" class="form-neon FormularioAjax" method="POST" data-form="update" autocomplete="off">
        <input type="hidden" name="id_asesoria_finalizada_up" id="id_asesoria_finalizada" value="<?php echo $pagina[1]; ?>">
        <fieldset>
            <legend><i class="far fa-address-card"></i> &nbsp; Descripcion de la asesoria</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-12">
                        <div class="form-group">
                            <label for="descripcion_asesoria">DESCRIPCION</label></br>
                            <textarea type="text" name="descripcion_asesoria" id="descripcion_asesoria" rows="5" cols="100" maxlength="350"><?php echo $campos['descripcion_finalizada']; ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <p class="text-center" style="margin-top: 40px;">
            <button type="submit" class="btn btn-raised btn-success btn-sm"><i class="fas fa-sync-alt"></i> &nbsp; ACTUALIZAR DESCRIPCION</button>
        </p>
    </form>
    <?php } ?>
</div>