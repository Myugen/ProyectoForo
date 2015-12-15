<?php
if(!isset($_GET["idOpinion"]))
	header("Location: ../foro.php");
else {
	require '../database/conexion.php';
	$idOpinion = $_GET["idOpinion"];
	if(!$conexion) {
		die("Error de conexión $conexion->connect_errno: $conexion->connect_error");
	}
	else {
		$peticion = "DELETE FROM mensaje WHERE id = $idOpinion";
		if($conexion->query($peticion)) {
			header("Location: ../foro.php");
			$conexion->close();
		}
		else
			die("Error en eliminar registro $conexion->errno: $conexion->error");
	}
}
?>
