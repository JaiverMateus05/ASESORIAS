		<!-- Page header -->
        <div class="full-box page-header">
				<h3 class="text-left">
					<i class="fas fa-plus fa-fw"></i> &nbsp; NUEVA ESPECIALIDAD
				</h3>
			</div>
			
			<div class="container-fluid">
				<ul class="full-box list-unstyled page-nav-tabs">
					<li>
						<a class="active" href="<?php echo SERVERURL; ?>speciality-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; NUEVA ESPECIALIDAD</a>
					</li>
					<li>
						<a href="<?php echo SERVERURL; ?>speciality-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE ESPECIALIDADES</a>
					</li>
					<li>
						<a href="<?php echo SERVERURL; ?>speciality-add/"><i class="fa fa-laptop"></i> &nbsp; ASIGNAR ESPECIALIDAD</a>
					</li>
				</ul>	
			</div>
			<div class="container-fluid">
				<form action="<?php echo SERVERURL; ?>ajax/especialidadAjax.php" class="form-neon FormularioAjax" method="POST" data-form="save" autocomplete="off">
				<fieldset>
						<legend><i class="far fa-address-card"></i> &nbsp; Especialidad</legend>
						<div class="container-fluid">
							<div class="row">
							<div class="col-12 col-md-12">
									<div class="form-group">
										<label for="usuario_nombre" class="bmd-label-floating">Nombre Especialidad</label>
										<input type="text"  class="form-control" name="especialidad_nombre_reg" id="especialidad_nombre" maxlength="35" required="">
									</div>
								</div>
							</div>
						</div>
					</fieldset>
					<p class="text-center" style="margin-top: 40px;">
						<button type="reset" class="btn btn-raised btn-secondary btn-sm"><i class="fas fa-paint-roller"></i> &nbsp; LIMPIAR</button>
						&nbsp; &nbsp;
						<button type="submit" class="btn btn-raised btn-info btn-sm"><i class="far fa-save"></i> &nbsp; GUARDAR</button>
					</p>
				</form>

			</div>
			<!-- Content -->
		