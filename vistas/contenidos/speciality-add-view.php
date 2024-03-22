<!-- Page header -->
<div class="full-box page-header">
				<h3 class="text-left">
					<i class="fa fa-laptop"></i> &nbsp; ASIGNAR ESPECIALIDAD
				</h3>
			</div>
			
			<div class="container-fluid">
				<ul class="full-box list-unstyled page-nav-tabs">
					<li>
						<a  href="<?php echo SERVERURL; ?>speciality-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; NUEVA ESPECIALIDAD</a>
					</li>
					<li>
						<a href="<?php echo SERVERURL; ?>speciality-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE ESPECIALIDADES</a>
					</li>
					<li>
						<a class="active" href="<?php echo SERVERURL; ?>speciality-add/"><i class="fa fa-laptop"></i> &nbsp; ASIGNAR ESPECIALIDAD</a>
					</li>
				</ul>	
			</div>
			
			<!-- Content -->

			<div class="container-fluid">
			<form action="<?php echo SERVERURL; ?>ajax/especialidadAjax.php" class="form-neon FormularioAjax" method="POST" data-form="save" autocomplete="off">
				<fieldset>
				<legend><i class="fas fa-medal"></i> &nbsp; Asignar especialidad al Asesor</legend>
					<div class="container-fluid">
						<div class="row">
							<div class="col-12 col-md-6">
								<div class="form-group">
									<select class="form-control" name="especialidad_user_reg">
									        <option value="" selected="" disabled="">Seleccione una Especialidad</option>
											<?php 
											require_once "./controladores/especialidadControlador.php";
											$especialidad = new especialidadControlador();
											$datos_espc= $especialidad->listar_especialidad_controlador();
											
											foreach($datos_espc as $key){
												
												?>
												<option value="<?php echo $key['id'] ?>"><?php echo $key['nombre_especialidad'] ?></option>
											
									<?php } ?>
											
									</select>
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group">
									<select class="form-control" name="asesor_user_reg">
									        <option value="" selected="" disabled="">Seleccione un Asesor</option>
											<?php 
											require_once "./controladores/usuarioControlador.php";
											$asesor = new usuarioControlador();
											$datos_ases = $asesor->listar_asesores_controlador();

											foreach($datos_ases as $ase){
											?>
											<option value="<?php echo $ase['id'] ?>"><?php echo $ase['nombre_usuario']. " " .$ase['apellido_usuario']  ?></option>
											<?php } ?>
									</select>
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