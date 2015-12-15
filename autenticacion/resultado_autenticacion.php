<?php
session_start();
$usuario = "anónimo";
$tipo = "invitado";
$id = 0;
if(!isset($_SESSION["usuario"]) && !isset($_SESSION["tipo"])) {
	if(!empty($_POST["userIn"]) && !empty($_POST["passwordIn"])) {
		require '../database/conexion.php';
		$camposRellenos = true;
		$user = $_POST["userIn"];
		$pass = $_POST["passwordIn"];
		if(!$conexion)
			die("<p>Error de conexión " . mysqli_connect_errno() . ": ". mysqli_connect_error() . "</p><br>");
		else {
			$peticion = "SELECT u.id as id, u.pass as hash, u.tipo as tipo
						 FROM usuario as u
						 WHERE u.usuario = ?";
			$stmt = $conexion->prepare($peticion);
			if($stmt) {
				$stmt->bind_param("s", utf8_decode($user));
				$stmt->execute();
				$stmt->bind_result($id, $hash, $tipo);
				$stmt->fetch();
				if(password_verify($pass, $hash)) {
					$autenticacion = true;
					$_SESSION["id"] = $id;
					$_SESSION["usuario"] = $user;
					$_SESSION["tipo"] = $tipo;
					$usuario = $_SESSION["usuario"];
				}
				else {
					$autenticacion = false;
				}
				$stmt->close();
			}
			else {
				$autenticacion = false;
			}
			$conexion->close();
		}
	}
	else
		$camposRellenos = false;
}
else {
	$usuario = $_SESSION["usuario"];
	$tipo = $_SESSION["tipo"];
	$id = $_SESSION["id"];
}
?>
<!DOCTYPE html>
<html lang="es-ES">
<head>
    <meta charset="UTF-8">
    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <title>Autenticación de usuario - MiForo</title>
</head>
<body>
    <div class="container">
    	<div class="row">
    	<nav class="navbar navbar-fixed-top navbar-inverse">
    		<a class="navbar-brand" href="../index.php"><span class="glyphicon glyphicon-leaf" aria-hidden="true"></span>
    			MiForo
    		</a>
  			<ul class="nav navbar-nav navbar-left">
	    		<li class="nav-item active">
	      			<a class="nav-link" href="../index.php">Inicio<span class="sr-only">(current)</span></a>
	    		</li>
	    		<li class="nav-item">
	      			<a class="nav-link" href="../foro.php">Foro</a>
	    		</li>
    		</ul>
    		<ul class="nav navbar-nav navbar-right">
    			<?php
    			//Mensaje especial en la zona de usuario
    			if($usuario == "anónimo")
    				echo "<li class='nav-item' style='padding-right: 15px'><p class='navbar-text'>Bienvenido, $usuario</p></li>";
    			else {
    				echo "<li class='nav-item dropdown' style='padding-right: 15px'>
    						<a id='dropdownMenu' class='dropdown-toggle' data-toggle='dropdown' href='#' role='button' aria-haspopup='true' aria-expanded='false'>
								Bienvenido, $usuario<span class='caret'></span>
    						</a>
							<ul class='dropdown-menu' aria-labelledby='dropdownMenu'>
    							<li><a href='../administracion/cambiar_pass.php'>Cambiar contraseña</a></li>
    							<li><a href='../administracion/cerrar_sesion.php'>Cerrar sesión</a></li>
  							</ul>
    					</li>";
    			}
    			?>
    		</ul>
    	</nav>
    	</div>
    	<div class="row" style="padding-top: 20px">
    		<div class="page-header">
    			<h1>Proceso de registro de usuario</h1>
    			<small>Ver volver siempre es una alegría</small>
    		</div>
    	</div>
    	<div class="row">
	    	<div class="jumbotron">
	    	<div class="container">
	    		<?php
	    		if(!$camposRellenos) {
	    			echo "<div class='alert alert-warning' role='alert'>
						  	<strong>¡Aviso!</strong> Asegúrese de no dejar campos vacíos. <a href='../index.php' class='alert-link'>Volver al índice</a>.
						  </div>";
	    		}
	    		else if(!$autenticacion) {
	    			echo "<div class='alert alert-danger' role='alert'>
						  	<strong>¡Error!</strong> Combinación usuario/contraseña no válida. <a href='../index.php' class='alert-link'>Volver al índice</a>.
						  </div>";
	    		}
	    		else {
	    			echo "<div class='alert alert-success role='alert'>
						  	<strong>¡Enhorabuena!</strong> Login correcto. <a href='../index.php' class='alert-link'>Volver al índice</a>.
						  </div>";
	    		}
	    		?>
	    	</div>
	    	</div>
    	</div>
    </div>
</body>
</html>
