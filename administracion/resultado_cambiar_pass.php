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
	header("Location: ../index.php");
}

if($update)
    header("Location: ../index.php");
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
    <title>Cambiar contraseña - MiForo</title>
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
            <h1>Proceso de cambio de contraseña</h1>
            <small>La seguridad de usted ante todo.</small>
        </div>
        <div class="jumbotron2">
        <div class="container">
            <?php
            if(!$camposRellenos) {
                echo "<div class='alerta alerta-aviso' role='alert'>
                        <strong>¡Aviso!</strong> Asegúrese de no dejar campos vacíos. <a href='cambiar_pass.php' class='alerta-link'>Volver al menú anterior</a>.
                      </div>";
            }
            else if(!$autenticacion) {
                echo "<div class='alerta alerta-peligro' role='alert'>
                        <strong>¡Error!</strong> Combinación usuario/contraseña no válida. <a href='cambiar_pass.php' class='alerta-link'>Volver al menú anterior</a>.
                      </div>";
            }
            else {
                if(!$passNuevoValido) {
                    echo "<div class='alerta alerta-aviso' role='alert'>
                        <strong>¡Aviso!</strong> Contraseña no válida, debe de contener entre <strong>7</strong> y <strong>15 caracteres</strong>. <br>
                        Además, también debe de contener al menos <strong>una minúscula</strong>, <strong>una mayúscula</strong> y <strong>un dígito</strong>. <a href='cambiar_pass.php' class='alerta-link'>Volver al menú anterior</a>.
                      </div>";
                }
                else {
                    if(!$update) {
                        echo "<div class='alerta alerta-peligro' role='alert'>
                    <strong>¡Error!</strong> Lo sentimos, ha ocurrido un fallo en el cambio de contraseña.<a href='cambiar_pass.php' class='alerta-link'>Volver al menú anterior</a>.
                    </div>";
                    }
                    else {
                        header("Location: ../index.php");
                    }
                }
            }
            ?>
        </div>
        </div>
    </div>
</body>
</html>
