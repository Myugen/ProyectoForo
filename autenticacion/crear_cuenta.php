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
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="icon" type="image/png" href="../assets/rebel.png" />
    <!-- Font Awesone Icons -->
    <link rel="stylesheet" href="../assets/font-awesome-4.5.0/css/font-awesome.min.css">
    <!-- CSS -->
    <link rel="stylesheet" href="../estilo/main.css">
    <!-- SCRIPTS -->
    <script type="text/javascript" src="../scripts/validaciones.js"></script>
    <script type="text/javascript" src="../scripts/menu.js"></script>
    <title>Registro de usuario - MiForo</title>
</head>
<body onload="cargar()">
    <div class="container">
    	<div class="navmenu">
    	    <div class="menu-bar">
    		    <a href="#" onclick="desplegarMenu()"><span class="fa fa-bars fa-fw"></span>&nbsp;Menú</a>
    		</div>
    		<a class="logo" href="../index.php"><span class="fa fa-ra fa-fw" aria-hidden="true"></span>
    			MiForo
    		</a>
  			<ul class="menu-izquierda" id="menu">
	    		<li>
	      			<a href="../index.php">Inicio</a>
	    		</li>
	    		<li>
	      			<a href="../foro.php">Foro</a>
	    		</li>
    		</ul>
    		<ul class="menu-derecha">
    			<?php
    			//Mensaje especial en la zona de usuario
    			if($usuario == "anónimo")
    				echo "<li><p>Bienvenido, $usuario</p></li>";
    			else {
    				echo "<li>
    						<a id='dropdownMenu'>
      							Bienvenido, $usuario &nbsp<span class='fa fa-caret-down'></span>
    						</a>
							<ul class='menu-oculto'>
    							<li><a href='../administracion/cambiar_pass.php'>Cambiar contraseña</a></li>
    							<li><a href='../administracion/cerrar_sesion.php'>Cerrar sesión</a></li>
  							</ul>
    					  </li>";
    			}
    			?>
    		</ul>
    	</div>
        <div class="cabecera">
            <h1>Proceso de registro de usuario</h1>
            <small>Cuantos más seamos, más fuerte seremos</small>
    	</div>
        <div class="jumbotron2">
        <div class="container">
            <?php
            if(!$camposRellenos) {
                echo "<div class='alerta alerta-aviso' role='alert'>
                        <strong>¡Aviso!</strong> Asegúrese de no dejar campos vacíos. <a href='../index.php' class='alerta-link'>Volver al índice</a>.
                      </div>";
            }
            else if(!$passValido) {
                echo "<div class='alerta alerta-aviso' role='alert'>
                        <strong>¡Aviso!</strong> Contraseña no válida, debe de contener entre <strong>7</strong> y <strong>15 caracteres</strong>. <br>
                        Además, también debe de contener al menos <strong>una minúscula</strong>, <strong>una mayúscula</strong> y <strong>un dígito</strong>. <a href='../index.php' class='alerta-link'>Volver al índice</a>.
                      </div>";
            }
            else if(!$email) {
                echo "<div class='alerta alerta-peligro' role='alert'>
                <strong>¡Error!</strong> Correo eléctronico no válido. <a href='../index.php' class='alerta-link'>Volver al índice</a>.
                </div>";
            }
            else if(!$creacion) {
                if($errorNo = 2525) {
                    echo "<div class='alerta alerta-peligro' role='alert'>
                    <strong>¡Error!</strong> Usuario/email repetidos.<a href='../index.php' class='alerta-link'>Volver al índice</a>.
                    </div>";
                }
                else {
                    echo "<div class='alerta alerta-peligro' role='alert'>
                    <strong>¡Error!</strong> Lo sentimos, ha ocurrido un fallo con la creación de la cuenta.<a href='../index.php' class='alerta-link'>Volver al índice</a>.
                    </div>";
                }
            }
            else {
                echo "<div class='alerta alerta-exito role='alert'>
                        <strong>¡Enhorabuena!</strong> Cuenta creada con éxito, además está logueado. <a href='../index.php' class='alerta-link'>Volver al índice</a>.
                      </div>";
            }
            ?>
        </div>
        </div>
    </div>
</body>
</html>
