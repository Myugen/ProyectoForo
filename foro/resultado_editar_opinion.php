<?php
session_start();
if(empty($_POST["mensaje"]) || !isset($_SESSION["id"]) || !isset($_GET["idTema"]) || !isset($_GET["idOpinion"]))
	header("Location: ../foro.php");
else {
	require '../database/conexion.php';
	$idTema = $_GET["idTema"];
	$idOpinion = $_GET["idOpinion"];
	$idUsuario = $_SESSION["id"];
	$mensaje = $_POST["mensaje"];
	if(!$conexion) {
		die("Error de conexión $conexion->connect_errno: $conexion->connect_error");
	}
	else {
		$peticion = "UPDATE mensaje SET opinion=?, fechahora=CURRENT_TIMESTAMP WHERE ID = $idOpinion AND usuarioID = $idUsuario AND temaID = $idTema";
		$stmt = $conexion->prepare($peticion);
		if($stmt) {
			$stmt->bind_param("s", utf8_decode($mensaje));
			$stmt->execute();
			$stmt->close();
			header("Location: listado.php?idTema=" . $idTema);
			$conexion->close();
		}
		else
			die("Error en añadir comentario $conexion->errno: $conexion->error");
	}
}
?>
