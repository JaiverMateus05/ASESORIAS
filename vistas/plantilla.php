<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title><?php echo COMPANY; ?></title>

	<?php include "./vistas/inc/link.php"; ?>


</head>

<body>
	<?php
	$peticionAjax = false;
	require_once "./controladores/vistasControlador.php";
	$IV = new vistasControlador();
	$vistas = $IV->obtener_vistas_controlador();

	if ($vistas == "login" || $vistas == "404") {
		require_once "./vistas/contenidos/" . $vistas . "-view.php";
	} else {
		session_start(['name' => 'SAV']);
		$pagina = explode("/", $_GET['views']);
		require_once "./controladores/loginControlador.php";
		$lc = new loginControlador();
		if (!isset($_SESSION['usuario_sav']) || !isset($_SESSION['rol_sav']) || !isset($_SESSION['id_sav'])) {

			echo $lc->forzar_cierre_sesion_controlador();
			exit();
		}
	?>

		<!-- Main container -->
		<main class="full-box main-container">
			<!-- Nav lateral -->
			<?php
			if ($_SESSION['rol_sav'] == "Administrador") {
				include "./vistas/inc/navLateral.php";
			} elseif ($_SESSION['rol_sav'] == "Asesor") {
				include "./vistas/inc/navLateralA.php";
			} else {
				include "./vistas/inc/navLateralE.php";
			}

			?>

			<!-- Page content -->
			<section class="full-box page-content">
				<?php
				include "./vistas/inc/navBar.php";
				include $vistas;
				?>

				<!-- Page header -->


			</section>
		</main>


		<!--=============================================
	=            Include JavaScript files           =
	==============================================-->
	<?php
		include "./vistas/inc/logOut.php";
	}
	include "./vistas/inc/script.php"; ?>
</body>

</html>