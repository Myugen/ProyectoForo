<?php
session_start();
if(empty($_POST["mensaje"]) || !isset($_SESSION["id"]) || !isset($_GET["idTema"]))
	header("Location: ../foro.php");
else {
	require '../database/conexion.php';
	$idTema = $_GET["idTema"];
	$idUsuario = $_SESSION["id"];
	$mensaje = $_POST["mensaje"];
	if(!$conexion) {
		die("Error de conexión $conexion->connect_errno: $conexion->connect_error");
	}
	else {
		$peticion = "INSERT INTO mensaje VALUEs(null, $idUsuario, $idTema, ?, CURRENT_TIMESTAMP)";
		$stmt = $conexion->prepare($peticion);
		if($stmt) {
			$stmt->bind_param("s", utf8_decode($mensaje));
			$stmt->execute();
			$stmt->close();
			$conexion->close();
			header("Location: listado.php?idTema=" . $idTema);
		}
		else
			die("Error en añadir comentario $conexion->errno: $conexion->error");
	}
}
?>
