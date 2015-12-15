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
    <meta charset="UTF-8">
    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="jsfile"></script>
    <title>Panel de administración - MiForo</title>
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
    			<h1>Menú administración de usuario</h1>
    			<small>Cambie su contraseña si lo desea</small>
    		</div>
    	</div>
    	<div class="row">
    		<div class="col-md-3"></div>
    		<div class="col-md-6">
	    	<div class="jumbotron">
	    	<div class="container">
	    		<div class="panel panel-warning">
  					<div class="panel-heading">Cambie su contraseña</div>
  					<div class="panel-body">
    					<form action="resultado_cambiar_pass.php" method="post" role="form">
							<label for="textBoxUsuario">Usuario:</label>
							<p class="form-control-static"><?php echo $usuario?></p><br>
							<label for="textBoxPasswordOld">Contraseña actual:</label>
							<input type="password" name="passwordOld" id="textBoxPasswordOld" class="form-control"/><br>
							<label for="textBoxPasswordnew">Nueva contraseña:</label>
							<input type="password" name="passwordNew" id="textBoxPasswordNew" class="form-control"/><br>
							<span id="helpBlock" class="help-block">
								<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
								El password nuevo debe de contener entre <strong>7</strong> y <strong>15 caracteres</strong>. <br>
								Además, también debe de contener al menos <strong>una minúscula</strong>, <strong>una mayúscula</strong> y <strong>un dígito</strong>
							</span><br>
							<button type="submit" class="btn btn-warning">
								<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
								Cambiar contraseña
							</button>
						</form>
  					</div>
				</div>
	    	</div>
	    	</div>
	    	</div>
	    	<div class='col-md-3'></div>
    	</div>
    </div>
</body>
</html>
