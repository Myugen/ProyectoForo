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
    <!-- Font Awesone Icons -->
    <link rel="stylesheet" href="assets/font-awesome-4.5.0/css/font-awesome.min.css">

    <!-- CSS -->
    <link rel="stylesheet" href="estilo/main.css">
    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="scripts/validaciones.js"></script>
    <title>Inicio - MiForo</title>
</head>
<body>
    <div class="container">
    	<div class="row">
    	<nav class="navbar navbar-fixed-top navbar-inverse">
    		<a class="navbar-brand" href="index.php"><span class="fa fa-ra fa-fw" aria-hidden="true"></span>
    			MiForo
    		</a>
  			<ul class="nav navbar-nav navbar-left">
	    		<li class="nav-item active">
	      			<a class="nav-link" href="index.php">Inicio<span class="sr-only">(current)</span></a>
	    		</li>
	    		<li class="nav-item">
	      			<a class="nav-link" href="foro.php">Foro</a>
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
    							<li><a href='administracion/cambiar_pass.php'>Cambiar contraseña</a></li>
    							<li><a href='administracion/cerrar_sesion.php'>Cerrar sesión</a></li>
  							</ul>
    					  </li>";
    			}
    			?>
    		</ul>
    	</nav>
    	</div>
    	<div class="row" style="padding-top: 20px">
    		<div class="page-header">
    			<h1>Bienvenido a MiForo</h1>
    			<small>Para disfrutar al máximo de la página, por favor, identifíquese o dese de alta.</small>
    		</div>
    	</div>
    	<div class="row">
	    	<div class="jumbotron">
	    	<div class="container">
	    	<?php
    		if($usuario == "anónimo") {
    		?>
	    	<div class="col-md-6">
	    		<div class="panel panel-primary">
  					<div class="panel-heading">Inicie sesión</div>
  					<div class="panel-body">
    					<form action="autenticacion/resultado_autenticacion.php" method="post" onsubmit="return validarFormulario(this)" role="form">
							<label for="textBoxUsuario">Usuario:</label>
							<input type="text" name="userIn" id="textBoxUsuario" class="form-control"/><br>
							<label for="textBoxPassword">Contraseña:</label>
							<input type="password" name="passwordIn" id="textBoxPassword" class="form-control"/><br>
							<button type="submit" class="btn btn-primary">
								<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
								Iniciar sesión
							</button>
						</form>
  					</div>
				</div>
	    	</div>
	    	<div class="col-md-6">
		    	<div class="panel panel-success">
	  				<div class="panel-heading"><b>O bien, cree su cuenta</b></div>
	  				<div class="panel-body">
	    				<form action="autenticacion/crear_cuenta.php" id="registroCuenta" onsubmit="return validarFormulario(this)" method="post" role="form">
							<label for="textBoxUsuario">Usuario:</label>
							<input type="text" name="userUp" id="textBoxUsuario" class="form-control"/><br>
							<label for="textBoxEmail">Email:</label>
							<input type="email" name="mailUp" id="textBoxEmail" class="form-control"/><br>
							<label for="textBoxPassword">Contraseña:</label>
							<input type="password" name="passwordUp" id="textBoxPassword" class="form-control" aria-describedby="helpBlock"/><br>
							<span id="helpBlock" class="help-block">
								<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
								El password debe de contener entre <strong>7</strong> y <strong>15 caracteres</strong>. <br>
								Además, también debe de contener al menos <strong>una minúscula</strong>, <strong>una mayúscula</strong> y <strong>un dígito</strong>
							</span><br>
							<button type="submit" class="btn btn-success">
								<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
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
	    	<div class="col-md-12">
	    		<h3>¿Has visto lo maravilloso que se ve todo con Bootstrap?</h3>
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
    </div>
</body>
</html>
