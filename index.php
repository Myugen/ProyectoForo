<?php
session_start();
if(!isset($_SESSION["usuario"]) && !isset($_SESSION["tipo"])) {
	$usuario = "anónimo";
	$id = 0;
	$tipo = "invitado";
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
    <link rel="icon" type="image/png" href="/assets/rebel.png" />
    <!-- Font Awesone Icons -->
    <link rel="stylesheet" href="assets/font-awesome-4.5.0/css/font-awesome.min.css">
    <!-- CSS -->
    <link rel="stylesheet" href="estilo/main.css">
    <!--SCRIPTS-->
    <script type="text/javascript" src="scripts/validaciones.js"></script>
    <script type="text/javascript" src="scripts/menu.js"></script>
    <title>Inicio - MiForo</title>
</head>
<body onload="cargar()">
    <div class="container">
    	<div class="navmenu">
    	    <div class="menu-bar">
    		    <a href="#" onclick="desplegarMenu()"><span class="fa fa-bars fa-fw"></span>&nbsp;Menú</a>
    		</div>
    		<a class="logo" href="index.php"><span class="fa fa-ra fa-fw" aria-hidden="true"></span>
    			MiForo
    		</a>
  			<ul class="menu-izquierda" id="menu">
	    		<li class="activo">
	      			<a href="index.php">Inicio</a>
	    		</li>
	    		<li>
	      			<a href="foro.php">Foro</a>
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
    							<li><a href='administracion/cambiar_pass.php'>Cambiar contraseña</a></li>
    							<li><a href='administracion/cerrar_sesion.php'>Cerrar sesión</a></li>
  							</ul>
    					  </li>";
    			}
    			?>
    		</ul>
    	</div>
    	<div class="cabecera">
            <h1>Bienvenido a MiForo</h1>
            <small>Para disfrutar al máximo de la página, por favor, identifíquese o dese de alta.</small>
    	</div>
        <div class="jumbotron2">
	    	<div class="container">
	    	<?php
    		if($usuario == "anónimo") {
    		?>
	    	<div class="columna-1-2">
	    		<div class="panel panel-principal">
  					<div class="panel-cabecera">Inicie sesión</div>
  					<div class="panel-cuerpo">
    					<form action="autenticacion/resultado_autenticacion.php" method="post" onsubmit="return validarFormulario(this)" role="form">
							<label for="textBoxUsuario">Usuario:</label>
							<input type="text" name="userIn" id="textBoxUsuario"/><br>
							<label for="textBoxPassword">Contraseña:</label>
							<input type="password" name="passwordIn" id="textBoxPassword"/><br>
							<button type="submit" class="boton-principal">
								<span class="fa fa-user" aria-hidden="true"></span>
								Iniciar sesión
							</button>
						</form>
  					</div>
				</div>
	    	</div>
	    	<div class="columna-1-2">
		    	<div class="panel panel-exito">
	  				<div class="panel-cabecera"><b>O bien, cree su cuenta</b></div>
	  				<div class="panel-cuerpo">
	    				<form action="autenticacion/crear_cuenta.php" id="registroCuenta" onsubmit="return validarFormulario(this)" method="post" role="form">
							<label for="textBoxUsuario">Usuario:</label>
							<input type="text" name="userUp" id="textBoxUsuario"/><br>
							<label for="textBoxEmail">Email:</label>
							<input type="email" name="mailUp" id="textBoxEmail"/><br>
							<label for="textBoxPassword">Contraseña:</label>
							<input type="password" name="passwordUp" id="textBoxPassword" aria-describedby="helpBlock"/><br>
							<span id="helpBlock" class="bloque-ayuda">
								<span class="fa fa-exclamation-triangle" aria-hidden="true"></span>
								El password debe de contener entre <strong>7</strong> y <strong>15 caracteres</strong>. <br>
								Además, también debe de contener al menos <strong>una minúscula</strong>, <strong>una mayúscula</strong> y <strong>un dígito</strong>
							</span><br>
							<button type="submit" class="boton-exito">
								<span class="fa fa-pencil" aria-hidden="true"></span>
								Crear cuenta
							</button>
						</form>
	  				</div>
				</div>
	    	</div>
	    	<?php
    		}
    		else {
	    	?>
	    	<div>
	    		<h3>¡Gracias por entrar a esta página!</h3>
	    		<span>
	    			Lorem ipsum dolor sit amet, consectetur adipisicing elit.
	    			Voluptates vero facere nemo dolorum voluptatibus tempore eos a et esse nobis dolor amet veniam odio est voluptatem quasi totam quo illum.
	    		</span>
	    	</div>
	    	<?php
    		}
	    	?>
	    	</div>
        </div>
    </div>
</body>
</html>
