<?php
session_start();
if(empty($_POST["titulo"]) || !isset($_SESSION["id"]) || !isset($_GET["idTema"]))
	header("Location: ../foro.php");
else {
	require '../database/conexion.php';
	$idTema = $_GET["idTema"];
	$idUsuario = $_SESSION["id"];
	$titulo = $_POST["titulo"];
	if(!$conexion) {
		die("Error de conexión $conexion->connect_errno: $conexion->connect_error");
	}
	else {
		$peticion = "UPDATE tema SET titulo=?, fechahora=CURRENT_TIMESTAMP WHERE ID=$idTema AND usuarioID = $idUsuario";
		$stmt = $conexion->prepare($peticion);
		if($stmt) {
			$stmt->bind_param("s", utf8_decode($titulo));
			$stmt->execute();
			$stmt->close();
			header("Location: ../foro.php");
			$conexion->close();
		}
		else
			die("Error en añadir tema $conexion->errno: $conexion->error");
	}
}
?>
