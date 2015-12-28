<?php
session_start();
if((!isset($_SESSION["usuario"]) && !isset($_SESSION["tipo"])) || !isset($_GET["idTema"])) {
	header("Location: ../index.php");
}
else {
	$idTema = $_GET["idTema"];
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
    <script type="text/javascript" src="../scripts/validaciones.js"></script>
    <title>Nueva opinión - MiForo</title>
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
    			<h1>Crear opinión</h1>
    			<small>Opinar es necesario, no tanto la falta de respeto</small>
    		</div>
    	</div>
    	<div class="row">
    		<div class="col-md-3"></div>
    		<div class="col-md-6">
	    	<div class="jumbotron">
	    	<div class="container">
	    		<div class="panel panel-primary">
  					<div class="panel-heading">Nueva opinión</div>
  					<div class="panel-body">
    					<form action="resultado_crear_opinion.php?idTema= <?php echo $idTema ?>" onsubmit="return validarFormulario(this)"  method="post" role="form">
							<label for="textAreaComentario">Comentario:</label>
							<textarea name="mensaje" id="textAreaComentario" cols="30" rows="10" class="form-control"></textarea><br>
							<button type="submit" class="btn btn-success">
								<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
								Añadir opinión
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
