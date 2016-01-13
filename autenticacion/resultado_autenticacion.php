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

if($autenticacion) {
    header("Location: ../index.php");
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
            <h1>Proceso de registro de usuario</h1>
            <small>Ver volver siempre es una alegría</small>
    	</div>
        <div class="jumbotron2">
        <div class="container">
            <?php
            if(!$camposRellenos) {
                echo "<div class='alerta alerta-aviso' role='alert'>
                        <strong>¡Aviso!</strong> Asegúrese de no dejar campos vacíos. <a href='../index.php' class='alerta-link'>Volver al índice</a>.
                      </div>";
            }
            else if(!$autenticacion) {
                echo "<div class='alerta alerta-peligro' role='alert'>
                        <strong>¡Error!</strong> Combinación usuario/contraseña no válida. <a href='../index.php' class='alerta-link'>Volver al índice</a>.
                      </div>";
            }
            else {
                echo "<div class='alerta alerta-exito role='alert'>
                        <strong>¡Enhorabuena!</strong> Login correcto. <a href='../index.php' class='alerta-link'>Volver al índice</a>.
                      </div>";
                header("Location: index.php");
            }
            ?>
        </div>
        </div>
    </div>
</body>
</html>
