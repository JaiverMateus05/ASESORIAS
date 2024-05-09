<?php 
if($_SESSION['rol_sav']!="Administrador"){
	echo '<script>
	window.location.href="'.SERVERURL.'home/"
	</script>';
	return;
}

?>

<!-- Page header -->
<div class="full-box page-header">
				<h3 class="text-left">
					<i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE ESPECIALIDADES
				</h3>
			</div>
			
			<div class="container-fluid">
				<ul class="full-box list-unstyled page-nav-tabs">
					<li>
						<a href="<?php echo SERVERURL; ?>speciality-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; NUEVA ESPECIALIDAD</a>
					</li>
					<li>
						<a class="active" href="<?php echo SERVERURL; ?>speciality-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE ESPECIALIDADES</a>
					</li>
					<li>
						<a href="<?php echo SERVERURL; ?>speciality-add/"><i class="fa fa-laptop"></i> &nbsp; ASIGNAR ESPECIALIDAD</a>
					</li>
				</ul>	
			</div>
			
			<!-- Content -->
			<div class="container-fluid">
				<?php 
				require_once "./controladores/especialidadControlador.php";
				$ins_espec = new especialidadControlador();

				echo $ins_espec->paginar_especialidad_controlador($pagina[1],5,$pagina[0],"");
				?>

			</div>