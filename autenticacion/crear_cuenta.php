<?php
session_start();
if(isset($_SESSION["usuario"]) && isset($_SESSION["tipo"])) {
	header("Location: index.php");
}
else {
	$usuario = "anónimo";
	$id = 0;
	$tipo = "invitado";
	if(!empty($_POST["userUp"]) && !empty($_POST["passwordUp"]) && !empty($_POST["mailUp"])) {
		$camposRellenos = true;
		$user = $_POST["userUp"];
		$pass = $_POST["passwordUp"];
		$hash = password_hash($pass, PASSWORD_DEFAULT);
		$email = $_POST["mailUp"];
		$tipo = "usuario";
		if(preg_match_all("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z!@#$%]{7,15}$/", $pass)) {
			$passValido = true;
			if(filter_var($email, FILTER_VALIDATE_EMAIL) != false) {
				require '../database/conexion.php';
				$emailValido = true;
				if(!$conexion)
					die("<p>Error de conexión " . mysqli_connect_errno() . ": ". mysqli_connect_error() . "</p><br>");
					else {
						$peticion = "INSERT INTO usuario VALUES(null, ?, ?, '$tipo', ?);";
						$stmt = $conexion->prepare($peticion);
						if($stmt) {
							$stmt->bind_param("sss", utf8_decode($user), $hash, $email);
							$stmt->execute();
							$stmt->close();
							$_SESSION["id"] = $conexion->insert_id;
							$creacion = true;
							$_SESSION["usuario"] = $user;
							$_SESSION["tipo"] = $tipo;
							$usuario = $_SESSION["usuario"];
							$para = $email;
							$titulo = "MiForo - Confirmación de registro ";
							$mensaje = "Hola $user, te damos la bienvenida a nuestra página, esperemos que la disfrutes tanto como nosotros de tu compañía.\n
										A continuación le enviamos su contraseña, si tiene algún problema con ella, no dude en cambiarla desde la opción
										Cambiar contraseña que se encuentra en el menú desplegable de administración.\n
										Su contraseña: $pass \n
										Un saludo de parte de la administración de MiForo.";
							$cabeceras = "From: admin@miforo.com";
							mail($para, $titulo, $mensaje, $cabeceras);
						}
						else {
							$errorNo = $conexion->errno;
							$creacion = false;
						}
					}
			}
			else
				$emailValido = false;
		}
		else
			$passValido = false;
	}
	else
		$camposRellenos = false;
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
    <title>Registro de usuario - MiForo</title>
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
    			<small>Cuantos más seamos, más fuerte seremos</small>
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
	    		else if(!$passValido) {
	    			echo "<div class='alert alert-warning' role='alert'>
						  	<strong>¡Aviso!</strong> Contraseña no válida, debe de contener entre <strong>7</strong> y <strong>15 caracteres</strong>. <br>
							Además, también debe de contener al menos <strong>una minúscula</strong>, <strong>una mayúscula</strong> y <strong>un dígito</strong>. <a href='../index.php' class='alert-link'>Volver al índice</a>.
						  </div>";
	    		}
	    		else if(!$email) {
	    			echo "<div class='alert alert-danger' role='alert'>
	    			<strong>¡Error!</strong> Correo eléctronico no válido. <a href='../index.php' class='alert-link'>Volver al índice</a>.
	    			</div>";
	    		}
	    		else if(!$creacion) {
	    			if($errorNo = 2525) {
	    				echo "<div class='alert alert-danger' role='alert'>
		    			<strong>¡Error!</strong> Usuario/email repetidos.<a href='../index.php' class='alert-link'>Volver al índice</a>.
		    			</div>";
	    			}
	    			else {
		    			echo "<div class='alert alert-danger' role='alert'>
		    			<strong>¡Error!</strong> Lo sentimos, ha ocurrido un fallo con la creación de la cuenta.<a href='../index.php' class='alert-link'>Volver al índice</a>.
		    			</div>";
	    			}
	    		}
	    		else {
	    			echo "<div class='alert alert-success role='alert'>
						  	<strong>¡Enhorabuena!</strong> Cuenta creada con éxito, además está logueado. <a href='../index.php' class='alert-link'>Volver al índice</a>.
						  </div>";
	    		}
	    		?>
	    	</div>
	    	</div>
    	</div>
    </div>
</body>
</html>
