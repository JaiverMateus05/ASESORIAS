<?php 
if($_SESSION['rol_sav']!="Administrador"){
	echo '<script>
	window.location.href="'.SERVERURL.'home/"
	</script>';
	return;
}

?>

<div class="full-box page-header">
    <h3 class="text-left">
        <i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE ASESORES

    </h3>

    <div class="container-fluid">
        <?php 
        require_once "./controladores/usuarioControlador.php";
        $ins_ases_esp = new usuarioControlador();

        echo $ins_ases_esp->paginar_asesores_controlador($pagina[1],15,$pagina[0],"");
        ?>
    </div>
</div>