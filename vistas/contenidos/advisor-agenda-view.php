	<!-- Page header -->
	<div class="full-box page-header">
		<h3 class="text-left">
			<i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR ASESOR
		</h3>
	</div>

	<div class="container-fluid">
		<ul class="full-box list-unstyled page-nav-tabs">
			<li>
				<a href="<?php echo SERVERURL; ?>my-agenda-E/"><i class="fa fa-book"></i> &nbsp; MIS ASESORIAS</a>
			</li>

		</ul>
	</div>

	<?php

	if (!isset($_SESSION['busqueda_especialidad'])) {


	?>
		<!-- Content -->
		<div class="container-fluid">
			<form class="form-neon FormularioAjax" action="<?php echo SERVERURL; ?>ajax/buscadorAjax.php" method="POST" data-form="default" autocomplete="off">
				<input type="hidden" name="modulo" value="especialidad">
				<div class="container-fluid">
					<div class="row justify-content-md-center">
						<div class="col-12 col-md-6">
							<div class="form-group">
								<label for="inputSearch" class="bmd-label-floating">¿Qué especialidad estas buscando?</label>
								<input type="text" class="form-control" name="busqueda_inicial" id="inputSearch" maxlength="30">
							</div>
						</div>
						<div class="col-12">
							<p class="text-center" style="margin-top: 40px;">
								<button type="submit" class="btn btn-raised btn-info"><i class="fas fa-search"></i> &nbsp; BUSCAR</button>
							</p>
						</div>
					</div>
				</div>
			</form>
		</div>
	<?php } else { ?>
		<div class="container-fluid">
			<form action="<?php echo SERVERURL; ?>ajax/buscadorAjax.php" class="FormularioAjax" method="POST" data-form="search" autocomplete="off">
				<input type="hidden" name="modulo" value="especialidad">
				<input type="hidden" name="eliminar_busqueda" value="eliminar">
				<div class="container-fluid">
					<div class="row justify-content-md-center">
						<div class="col-12 col-md-6">
							<p class="text-center" style="font-size: 20px;">
								Resultados de la busqueda <strong>“<?php echo $_SESSION['busqueda_especialidad']; ?>”</strong>
							</p>
						</div>
						<div class="col-12">
							<p class="text-center" style="margin-top: 20px;">
								<button type="submit" class="btn btn-raised btn-danger"><i class="far fa-trash-alt"></i> &nbsp; ELIMINAR BÚSQUEDA</button>
							</p>
						</div>
					</div>
				</div>
			</form>
		</div>

		<div class="container-fluid">

			<?php
			require_once "./controladores/especialidadControlador.php";

			$ins_espec = new especialidadControlador();

			echo $ins_espec->paginar_especialidad_asesor_controlador($pagina[1], 10, $pagina[0], $_SESSION['busqueda_especialidad']);
			?>
		</div>
	<?php } ?>