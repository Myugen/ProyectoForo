<?php
session_start();
$usuario = "anónimo";
$tipo = "invitado";
$id = 0;
if(isset($_SESSION["usuario"]) && isset($_SESSION["tipo"])) {
	if(!empty($_POST["passwordOld"]) && !empty($_POST["passwordNew"])) {
		require '../database/conexion.php';
		$camposRellenos = true;
		$usuario = $_SESSION["usuario"];
		$passViejo = $_POST["passwordOld"];
		$passNuevo = $_POST["passwordNew"];
		$id = $_SESSION["id"];
		if(!$conexion)
			die("<p>Error de conexión " . mysqli_connect_errno() . ": ". mysqli_connect_error() . "</p><br>");
		else {
			$peticionUsuario = "SELECT u.pass
						 FROM usuario as u
						 WHERE u.usuario = ?";
			$stmtAutenticacion = $conexion->prepare($peticionUsuario);
			if($stmtAutenticacion) {
				$stmtAutenticacion->bind_param("s", utf8_decode($usuario));
				$stmtAutenticacion->execute();
				$stmtAutenticacion->bind_result($hash);
				$stmtAutenticacion->fetch();
				$stmtAutenticacion->close();
				if(password_verify($passViejo, $hash)) {
					$autenticacion = true;
					if(preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z!@#$%]{7,15}$/", $passNuevo)) {
						$passNuevoValido = true;
						$hashNuevo = password_hash($passNuevo, PASSWORD_DEFAULT);
						$peticionUpdate = "UPDATE usuario SET pass= ? WHERE id= ?";
						$stmtUpdate = $conexion->prepare($peticionUpdate);
						if($stmtUpdate) {
							$stmtUpdate->bind_param("si", $hashNuevo, $id);
							$stmtUpdate->execute();
							$stmtUpdate->close();
							$update = true;
							$para = $email;
							$titulo = "MiForo - Confirmación de cambio de contraseña";
							$mensaje = "Hola $usuario, le informamos del cambio correcto de contraseña.\n
							Su nueva contraseña: $passNuevo \n
							Un saludo de parte de la administración de MiForo.";
							$cabeceras = "From: admin@miforo.com";
							mail($para, $titulo, $mensaje, $cabeceras);
						}
						else {
							$update = false;
						}
					}
					else {
						$passNuevoValido = false;
					}
				}
				else {
					$autenticacion = false;
				}
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
	header("Location: index.php");
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
    <title>Cambio de contraseña - MiForo</title>
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
    							<li><a href='cambiar_pass.php'>Cambiar contraseña</a></li>
    							<li><a href='cerrar_sesion.php'>Cerrar sesión</a></li>
  							</ul>
    					</li>";
    			}
    			?>
    		</ul>
    	</nav>
    	</div>
    	<div class="row" style="padding-top: 20px">
    		<div class="page-header">
    			<h1>Proceso de cambio de contraseña</h1>
    			<small>La seguridad de usted ante todo.</small>
    		</div>
    	</div>
    	<div class="row">
	    	<div class="jumbotron">
	    	<div class="container">
	    		<?php
	    		if(!$camposRellenos) {
	    			echo "<div class='alert alert-warning' role='alert'>
						  	<strong>¡Aviso!</strong> Asegúrese de no dejar campos vacíos. <a href='cambiar_pass.php' class='alert-link'>Volver al menú anterior</a>.
						  </div>";
	    		}
	    		else if(!$autenticacion) {
	    			echo "<div class='alert alert-danger' role='alert'>
						  	<strong>¡Error!</strong> Combinación usuario/contraseña no válida. <a href='cambiar_pass.php' class='alert-link'>Volver al menú anterior</a>.
						  </div>";
	    		}
	    		else {
	    			if(!$passNuevoValido) {
	    				echo "<div class='alert alert-warning' role='alert'>
						  	<strong>¡Aviso!</strong> Contraseña no válida, debe de contener entre <strong>7</strong> y <strong>15 caracteres</strong>. <br>
							Además, también debe de contener al menos <strong>una minúscula</strong>, <strong>una mayúscula</strong> y <strong>un dígito</strong>. <a href='cambiar_pass.php' class='alert-link'>Volver al menú anterior</a>.
						  </div>";
	    			}
	    			else {
	    				if(!$update) {
	    					echo "<div class='alert alert-danger' role='alert'>
		    			<strong>¡Error!</strong> Lo sentimos, ha ocurrido un fallo en el cambio de contraseña.<a href='cambiar_pass.php' class='alert-link'>Volver al menú anterior</a>.
		    			</div>";
	    				}
	    				else {
	    					echo "<div class='alert alert-success role='alert'>
						  	<strong>¡Hecho!</strong> Contraseña cambiada con éxito. <a href='../index.php' class='alert-link'>Volver al índice</a>.
						  </div>";
	    				}
	    			}
	    		}
	    		?>
	    	</div>
	    	</div>
    	</div>
    </div>
</body>
</html>
