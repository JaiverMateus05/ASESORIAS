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
					<i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE USUARIOS
				</h3>
				
			</div>
			
			<div class="container-fluid">
				<ul class="full-box list-unstyled page-nav-tabs">
					<li>
						<a href="<?php echo SERVERURL; ?>user-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; NUEVO USUARIO</a>
					</li>
					<li>
						<a class="active" href="<?php echo SERVERURL; ?>user-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE USUARIOS</a>
					</li>
					<li>
						<a href="<?php echo SERVERURL; ?>user-search/"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR USUARIO</a>
					</li>
				</ul>	
			</div>
			
			<!-- Content -->
			<div class="container-fluid">
				<?php 
				require_once "./controladores/usuarioControlador.php";
				$ins_usuario = new usuarioControlador();

				echo $ins_usuario->paginar_usuario_controlador($pagina[1],15,$_SESSION['id_sav'],$pagina[0],"");
				?>
			</div>