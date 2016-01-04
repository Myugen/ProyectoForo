<?php
session_start();
if(!isset($_SESSION["usuario"]) && !isset($_SESSION["tipo"])) {
	header("Location: index.php");
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
    <!-- Font Awesone Icons -->
    <link rel="stylesheet" href="../assets/font-awesome-4.5.0/css/font-awesome.min.css">
    <!-- CSS -->
    <link rel="stylesheet" href="../estilo/main.css">
    <!--SCRIPTS-->
    <script type="text/javascript" src="../scripts/validaciones.js"></script>
    <title>Panel de administración - MiForo</title>
</head>
<body>
    <div class="container">
        <div class="navmenu">
            <a class="logo" href="../index.php"><span class="fa fa-ra fa-fw" aria-hidden="true"></span>
    			MiForo
    		</a>
  			<ul class="menu-izquierda">
	    		<li class="activo">
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
    							<li><a href='cambiar_pass.php'>Cambiar contraseña</a></li>
    							<li><a href='cerrar_sesion.php'>Cerrar sesión</a></li>
  							</ul>
    					  </li>";
    			}
    			?>
    		</ul>
        </div>
        <div class="cabecera">
            <h1>Menú administración de usuario</h1>
            <small>Cambie su contraseña si lo desea</small>
    	</div>
    	<div class="columna-1-4"></div>
        <div class="columna-1-2">
            <div class="jumbotron2">
                <div class="container">
                    <div class="panel panel-aviso">
                        <div class="panel-cabecera">Cambie su contraseña</div>
                        <div class="panel-cuerpo">
                            <form action="resultado_cambiar_pass.php" method="post" onsubmit="return validarFormulario(this)" role="form">
                                <label for="textBoxUsuario">Usuario:</label>
                                <p class="estatico"><?php echo $usuario?></p><br>
                                <label for="textBoxPasswordOld">Contraseña actual:</label>
                                <input type="password" name="passwordOld" id="textBoxPasswordOld"/><br>
                                <label for="textBoxPasswordnew">Nueva contraseña:</label>
                                <input type="password" name="passwordNew" id="textBoxPasswordNew"/><br>
                                <span id="helpBlock" class="bloque-ayuda">
                                    <span class="fa fa-exclamation-triangle" aria-hidden="true"></span>
                                    El password nuevo debe de contener entre <strong>7</strong> y <strong>15 caracteres</strong>. <br>
                                    Además, también debe de contener al menos <strong>una minúscula</strong>, <strong>una mayúscula</strong> y <strong>un dígito</strong>
                                </span><br>
                                <button type="submit" class="boton-aviso">
                                    <span class="fa fa-edit" aria-hidden="true"></span>
                                    Cambiar contraseña
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="columna-1-4"></div>
    </div>
</body>
</html>
