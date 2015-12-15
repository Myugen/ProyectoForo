<?php
if(!isset($_GET["idTema"]))
	header("Location: ../foro.php");
else {
	require '../database/conexion.php';
	$idTema = $_GET["idTema"];
	if(!$conexion) {
		die("Error de conexión $conexion->connect_errno: $conexion->connect_error");
	}
	else {
		$peticion = "DELETE FROM tema WHERE id = $idTema";
		if($conexion->query($peticion)) {
			header("Location: ../foro.php");
			$conexion->close();
		}
		else
			die("Error en eliminar registro $conexion->errno: $conexion->error");
	}
}
?>
