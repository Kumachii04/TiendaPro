<?php
$conexion = new mysqli("localhost", "root", "", "gestion_computo");

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$puesto = $_POST['puesto'];
$usuario_id = $_POST['usuario_id'] ? $_POST['usuario_id'] : null;

$sql = "INSERT INTO empleados (nombre, apellido, puesto, usuario_id) VALUES (?, ?, ?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("sssi", $nombre, $apellido, $puesto, $usuario_id);

if ($stmt->execute()) {
    echo "Empleado registrado exitosamente.";
} else {
    echo "Error al registrar empleado: " . $conexion->error;
}

$stmt->close();
$conexion->close();