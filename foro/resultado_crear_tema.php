<?php
session_start();
if(empty($_POST["titulo"]) || !isset($_SESSION["id"]))
	header("Location: ../foro.php");
else {
	require '../database/conexion.php';
	$idUsuario = $_SESSION["id"];
	$titulo = $_POST["titulo"];
	if(!$conexion) {
		die("Error de conexión $conexion->connect_errno: $conexion->connect_error");
	}
	else {
		$peticion = "INSERT INTO tema VALUES(null, $idUsuario, ?, CURRENT_TIMESTAMP)";
		$stmt = $conexion->prepare($peticion);
		if($stmt) {
			$stmt->bind_param("s", utf8_decode($titulo));
			$stmt->execute();
			$stmt->close();
			$conexion->close();
			header("Location: ../foro.php");
		}
		else
			die("Error en añadir tema $conexion->errno: $conexion->error");
	}
}
?>
