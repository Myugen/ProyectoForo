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

require 'database/conexion.php';
if(!$conexion) {
	die("Error de conexión $conexion->errno: $conexion->error");
}
else {
	$peticion = "SELECT t.ID as idTema, t.usuarioID as idUsuario, u.usuario as usuario, t.titulo as titulo, t.fechahora as fecha
				 FROM tema as t
				 LEFT JOIN usuario as u
				 ON (t.usuarioID = u.ID)";
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
    <title>Foro - MiForo</title>
</head>
<body>
    <div class="container">
    	<div class="row">
    	<nav class="navbar navbar-fixed-top navbar-inverse">
    		<a class="navbar-brand" href="index.php"><span class="glyphicon glyphicon-leaf" aria-hidden="true"></span>
    			MiForo
    		</a>
  			<ul class="nav navbar-nav navbar-left">
	    		<li class="nav-item">
	      			<a class="nav-link" href="index.php">Inicio<span class="sr-only">(current)</span></a>
	    		</li>
	    		<li class="nav-item active">
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
    	<div class="row" style="padding-top: 70px">
    		<div class="col-md-12">
    			<?php
    			$resultado = $conexion->query($peticion);
    			if(!$resultado) {
    				echo "<div class='alert alert-danger' role='alert'><strong>Error en la base de datos</strong>, imposible obtener consulta.</div>";
    			}
    			else {
    				$numeroFilas = $resultado->num_rows;
    				echo "<div class='panel panel-primary'>";
    				echo "<div class='panel-heading'>
    						<div class='row'>
    						<div class='col-md-9'>
    						Temas <span class='badge'>$numeroFilas</span>
    						</div>";
    				if($usuario != "anónimo") {
    					echo "<div class='col-md-3 text-right'><a class='btn btn-primary' href='foro/crear_tema.php' role='button'>
								<span class='glyphicon glyphicon-edit' aria-hidden='true'></span>
								Nuevo tema
								</a></div>";
    				}
    				echo "	</div>";
    				echo "</div>";
    				echo "<ul class='list-group'>";
    				if ($numeroFilas == 0) {
    					echo "<li class='list-group-item list-group-warning'>No hay temas creados</li>";
    				}
    				else {
    					while($fila = $resultado->fetch_array()) {
    						echo "<li class='list-group-item'>";
    						echo "<div class='row'>";
    						echo "<div class='col-md-6'>";
    						echo "<a href='foro/listado.php?idTema=" . $fila["idTema"] ."'>" . utf8_encode($fila["titulo"]) . "</a>";
    						echo "</div>";
    						echo "<div class='col-md-3 text-center'>";
    						echo  "<span>Autor: <strong>". utf8_encode($fila["usuario"]) . "</strong></span>";
    						echo "</div>";
    						echo "<div class='col-md-3' text-center>";
    						echo  "<span>Creado: <strong>". utf8_encode($fila["fecha"]) . "</strong></span>";
    						echo "</div>";
    						echo "</div>";
    						if($id == $fila["idUsuario"] || $tipo == "administrador") {
    							echo "<hr>";
	    						echo "<div class='row'>";
	    						echo "<div class='col-md-12 text-right'>";
	    						echo "<a class='btn btn-warning' href='foro/editar_tema.php?idTema=" . $fila["idTema"] . "' role='button'>
										<span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>&nbsp
										Editar título
									  </a>&nbsp";
	    						echo "<a class='btn btn-danger' href='foro/borrar_tema.php?idTema=" . $fila["idTema"] . "' role='button'>
										<span class='glyphicon glyphicon-remove' aria-hidden='true'></span>&nbsp
										Eliminar tema
									  </a>";
	    						echo "</div>";
	    						echo "</div>";
    						}
    						echo "</li>";
    					}
    				}
    				echo "</ul>";
    				echo "</div>";
    				$conexion->close();
    			}
    			?>
    		</div>
    	</div>
    </div>
</body>
</html>
