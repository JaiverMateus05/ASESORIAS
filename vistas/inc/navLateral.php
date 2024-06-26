<section class="full-box nav-lateral">
			<div class="full-box nav-lateral-bg show-nav-lateral"></div>
			<div class="full-box nav-lateral-content">
				<figure class="full-box nav-lateral-avatar">
					<i class="far fa-times-circle show-nav-lateral"></i>
					<img src="<?php echo SERVERURL; ?>vistas/assets/avatar/Avatar.png" class="img-fluid" alt="Avatar">
					<figcaption class="roboto-medium text-center">
						<?php echo $_SESSION['nombre_sav']. " ". $_SESSION['apellido_sav']; ?> <br><small class="roboto-condensed-light"><?php echo $_SESSION['rol_sav']; ?></small>
					</figcaption>
				</figure>
				<div class="full-box nav-lateral-bar"></div>
				<nav class="full-box nav-lateral-menu">
					<ul>
						<li>
							<a href="<?php echo SERVERURL; ?>home/"><i class="fab fa-dashcube fa-fw"></i> &nbsp; Inicio</a>
						</li>
						<li>
							<a href="#" class="nav-btn-submenu"><i class="fas  fa-user-secret fa-fw"></i> &nbsp; Usuarios <i class="fas fa-chevron-down"></i></a>
							<ul>
								<li>
									<a href="<?php echo SERVERURL; ?>user-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; Nuevo usuario</a>
								</li>
								<li>
									<a href="<?php echo SERVERURL; ?>user-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; Lista de usuarios</a>
								</li>
								<li>
									<a href="<?php echo SERVERURL; ?>user-search/"><i class="fas fa-search fa-fw"></i> &nbsp; Buscar usuario</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#" class="nav-btn-submenu"><i class="fa fa-folder-open"></i> &nbsp; Especialidades<i class="fas fa-chevron-down"></i></a>
							<ul>
								<li>
									<a href="<?php echo SERVERURL; ?>speciality-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; Nueva Especialidad</a>
								</li>
								<li>
									<a href="<?php echo SERVERURL; ?>speciality-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; Lista de Especialidades</a>
								</li>
								<li>
									<a href="<?php echo SERVERURL; ?>speciality-add/"><i class="fa fa-laptop"></i> &nbsp; Asignar Especialidad</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#" class="nav-btn-submenu"><i class="fa fa-user-circle"></i> &nbsp; Gestion Asesores<i class="fas fa-chevron-down"></i></a>
							<ul>
								<li>
									<a href="<?php echo SERVERURL; ?>advisor-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; Lista Asesores</a>
								</li>
								
							</ul>
						</li>
					</ul>
				</nav>
			</div>
		</section>