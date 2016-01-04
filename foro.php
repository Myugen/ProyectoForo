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
    <!-- Font Awesone Icons -->
    <link rel="stylesheet" href="assets/font-awesome-4.5.0/css/font-awesome.min.css">
    <!-- CSS -->
    <link rel="stylesheet" href="estilo/main.css">
    <title>Foro - MiForo</title>
</head>
<body>
    <div class="container">
    	<div class="navmenu">
    		<a class="logo" href="index.php"><span class="fa fa-ra fa-fw" aria-hidden="true"></span>
    			MiForo
    		</a>
  			<ul class="menu-izquierda">
	    		<li>
	      			<a href="index.php">Inicio</a>
	    		</li>
	    		<li class="activo">
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
    	<div style="padding-top: 70px">
    		<div class="container">
    			<?php
    			$resultado = $conexion->query($peticion);
    			if(!$resultado) {
    				echo "<div class='alert alert-danger' role='alert'><strong>Error en la base de datos</strong>, imposible obtener consulta.</div>";
    			}
    			else {
    				$numeroFilas = $resultado->num_rows;
    				echo "<div class='panel panel-principal'>";
    				echo "<div class='panel-cabecera'>
    						<div class='columna-3-4'>
    						Temas <span class='badge'>$numeroFilas</span>
    						</div>";
    				if($usuario != "anónimo") {
    					echo "<div class='columna-1-4'><a href='foro/crear_tema.php'>
                                <button class='boton-principal'>
								<span class='fa fa-edit' aria-hidden='true'></span>
								Nuevo tema
                                </button>
								</a></div>";
    				}
    				echo "</div>";
    				echo "<ul class='lista'>";
    				if ($numeroFilas == 0) {
    					echo "<li class='lista-elemento list-group-warning'>No hay temas creados</li>";
    				}
    				else {
    					while($fila = $resultado->fetch_array()) {
    						echo "<li class='lista-elemento'>";
    						echo "<div class='columna-1-2'>";
    						echo "<a href='foro/listado.php?idTema=" . $fila["idTema"] ."'>" . utf8_encode($fila["titulo"]) . "</a>";
    						echo "</div>";
    						echo "<div class='columna-1-4'>";
    						echo  "<span>Autor: <strong>". utf8_encode($fila["usuario"]) . "</strong></span>";
    						echo "</div>";
    						echo "<div class='columna-1-4'>";
    						echo  "<span>Creado: <strong>". utf8_encode($fila["fecha"]) . "</strong></span>";
    						echo "</div>";
    						if($id == $fila["idUsuario"] || $tipo == "administrador") {
    							echo "<hr>";
	    						echo "<div style='clear:both;'>";
	    						echo "<div class='columna'>";
	    						echo "<a href='foro/editar_tema.php?idTema=" . $fila["idTema"] . "'>
                                        <button class='boton-aviso'>
										<span class='fa fa-pencil' aria-hidden='true'></span>&nbsp
										Editar título
                                        </button>
									  </a>&nbsp";
	    						echo "<a href='foro/borrar_tema.php?idTema=" . $fila["idTema"] . "'>
                                        <button class='boton-peligro'>
										<span class='fa fa-remove' aria-hidden='true'></span>&nbsp
										Eliminar tema
                                        </button>
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
