<?php 
if($lc->encryption($_SESSION['id_sav'])!=$pagina[1]){
	if($_SESSION['rol_sav']!="Administrador"){
		echo $lc->forzar_cierre_sesion_controlador();
		exit();

	}
}
?>

<!-- Page header -->
<div class="full-box page-header">
				<h3 class="text-left">
					<i class="fas fa-sync-alt fa-fw"></i> &nbsp; ACTUALIZAR USUARIO
				</h3>
				<p class="text-justify">
					Lorem ipsum dolor sit amet, consectetur adipisicing elit. Suscipit nostrum rerum animi natus beatae ex. Culpa blanditiis tempore amet alias placeat, obcaecati quaerat ullam, sunt est, odio aut veniam ratione.
				</p>
			</div>
			<?php if($_SESSION['rol_sav']=="Administrador"){ ?>
			<div class="container-fluid">
				<ul class="full-box list-unstyled page-nav-tabs">
					<li>
						<a href="<?php echo SERVERURL; ?>user-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; NUEVO USUARIO</a>
					</li>
					<li>
						<a href="<?php echo SERVERURL; ?>user-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE USUARIOS</a>
					</li>
					<li>
						<a href="<?php echo SERVERURL; ?>user-search/"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR USUARIO</a>
					</li>
				</ul>	
			</div>
			<?php } ?>
			<!-- Content -->


			<div class="container-fluid">
				<?php 
				require_once "./controladores/usuarioControlador.php";
				$ins_usuario = new usuarioControlador();

				$datos_usuario=$ins_usuario->datos_usuario_controlador("Unico",$pagina[1]);

				if($datos_usuario->rowCount()==1){
					$campos=$datos_usuario->fetch();
				?>

				<form action="<?php echo SERVERURL; ?>ajax/usuarioAjax.php" class="form-neon FormularioAjax" method="POST" data-form="update" autocomplete="off">
				<input type="hidden" name="usuario_id_up" value="<?php echo $pagina[1]; ?>">	
				<fieldset>
						<legend><i class="far fa-address-card"></i> &nbsp; Información personal</legend>
						<div class="container-fluid">
							<div class="row">
								
								<div class="col-12 col-md-6">
									<div class="form-group">
										<label for="usuario_nombre" class="bmd-label-floating">Nombres</label>
										<input type="text"  class="form-control" name="usuario_nombre_up" id="usuario_nombre" maxlength="35" value="<?php echo $campos['nombre_usuario']; ?>">
									</div>
								</div>
								<div class="col-12 col-md-6">
									<div class="form-group">
										<label for="usuario_apellido" class="bmd-label-floating">Apellidos</label>
										<input type="text"  class="form-control" name="usuario_apellido_up" id="usuario_apellido" maxlength="35" value="<?php echo $campos['apellido_usuario']; ?>">
									</div>
								</div>
							</div>
						</div>
					</fieldset>
					<br><br><br>
					<fieldset>
						<legend><i class="fas fa-user-lock"></i> &nbsp; Información de la cuenta</legend>
						<div class="container-fluid">
							<div class="row">
								<div class="col-12 col-md-6">
									<div class="form-group">
										<label for="usuario_usuario" class="bmd-label-floating">Nombre de usuario</label>
										<input type="text"  class="form-control" name="usuario_usuario_up" id="usuario_usuario" maxlength="35" value="<?php echo $campos['usuario_usuario']; ?>">
									</div>
								</div>
								<div class="col-12 col-md-6">
									<div class="form-group">
										<label for="usuario_email" class="bmd-label-floating">Email</label>
										<input type="email" class="form-control" name="usuario_email_up" id="usuario_email" maxlength="70" value="<?php echo $campos['email_usuario']; ?>">
									</div>
								</div>
								
							</div>
						</div>
					</fieldset>
					<br><br><br>
					<fieldset>
						<legend style="margin-top: 40px;"><i class="fas fa-lock"></i> &nbsp; Nueva contraseña</legend>
						<p>Para actualizar la contraseña de esta cuenta ingrese una nueva y vuelva a escribirla. En caso que no desee actualizarla debe dejar vacíos los dos campos de las contraseñas.</p>
						<div class="container-fluid">
							<div class="row">
								<div class="col-12 col-md-6">
									<div class="form-group">
										<label for="usuario_clave_nueva_1" class="bmd-label-floating">Contraseña</label>
										<input type="password" class="form-control" name="usuario_clave_nueva_1" id="usuario_clave_nueva_1"  maxlength="100" >
									</div>
								</div>
								<div class="col-12 col-md-6">
									<div class="form-group">
										<label for="usuario_clave_nueva_2" class="bmd-label-floating">Repetir contraseña</label>
										<input type="password" class="form-control" name="usuario_clave_nueva_2" id="usuario_clave_nueva_2"  maxlength="100" >
									</div>
								</div>
							</div>
						</div>
					</fieldset>
					<?php if($_SESSION['rol_sav']=="Administrador" && $campos['id']!=1){ ?>
					<br><br><br>
					<fieldset>
						<legend><i class="fas fa-medal"></i> &nbsp; Rol del sistema</legend>
						<div class="container-fluid">
							<div class="row">
								<div class="col-12">
									<p><span class="badge badge-success">Asesor</span></p>
									<p><span class="badge badge-dark">Estudiante</span></p>
									<div class="form-group">
										<select class="form-control" name="usuario_rol_up">
											<option value="Asesor" <?php if($campos['rol_usuario']=="Asesor"){echo 'selected=""';} ?>>Asesor <?php if($campos['rol_usuario']=="Asesor"){echo '(Actual)';} ?></option>
											<option value="Estudiante" <?php if($campos['rol_usuario']=="Estudiante"){echo 'selected=""';} ?>>Estudiante <?php if($campos['rol_usuario']=="Estudiante"){echo '(Actual)';} ?></option>
										</select>
									</div>
								</div>
							</div>
						</div>
					</fieldset>
					<?php } ?>
					<br><br><br>
					<?php if($lc->encryption($_SESSION['id_sav'])!=$pagina[1]){ ?>
						<input type="hidden" name="tipo_cuenta" value="Impropia">
						<?php }else{ ?>
							<input type="hidden" name="tipo_cuenta" value="Propia">

							<?php } ?>
					<p class="text-center" style="margin-top: 40px;">
						<button type="submit" class="btn btn-raised btn-success btn-sm"><i class="fas fa-sync-alt"></i> &nbsp; ACTUALIZAR</button>
					</p>
				</form>
                <?php }else{ ?>
				<div class="alert alert-danger text-center" role="alert">
					<p><i class="fas fa-exclamation-triangle fa-5x"></i></p>
					<h4 class="alert-heading">¡Ocurrió un error inesperado!</h4>
					<p class="mb-0">Lo sentimos, no podemos mostrar la información solicitada debido a un error.</p>
				</div>
				<?php }?>
			</div>