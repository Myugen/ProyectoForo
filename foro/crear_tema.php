<?php
session_start();
if(!isset($_SESSION["usuario"]) && !isset($_SESSION["tipo"])) {
	header("Location: ../index.php");
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
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="icon" type="image/png" href="../assets/rebel.png" />
    <!-- Font Awesone Icons -->
    <link rel="stylesheet" href="../assets/font-awesome-4.5.0/css/font-awesome.min.css">
    <!-- CSS -->
    <link rel="stylesheet" href="../estilo/main.css">
    <!-- SCRIPTS -->
    <script type="text/javascript" src="../scripts/validaciones.js"></script>
    <script type="text/javascript" src="../scripts/menu.js"></script>
    <title>Nuevo tema - MiForo</title>
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
	    		<li class="activo">
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
            <h1>Crea un tema</h1>
            <small>El conocimiento no pesa</small>
    	</div>
        <div class="columna-1-4"></div>
        <div class="columna-1-2">
        <div class="jumbotron">
        <div class="container">
            <div class="panel panel-principal">
                <div class="panel-cabecera">Nuevo tema</div>
                <div class="panel-cuerpo">
                    <form action="resultado_crear_tema.php" onsubmit="return validarFormulario(this)" method="post" role="form">
                        <label for="textBoxTema">Título:</label>
                        <input type="text" name="titulo" id="textBoxTema"/><br>
                        <button type="submit" class="boton-exito">
                            <span class="fa fa-pencil" aria-hidden="true"></span>
                            Añadir tema
                        </button>
                    </form>
                </div>
            </div>
        </div>
        </div>
        </div>
        <div class='columna-1-4'></div>
    </div>
</body>
</html>
