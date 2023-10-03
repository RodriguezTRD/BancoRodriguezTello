<?php
include_once 'conexion/conexion.php';

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $dni = $_POST['dni'];
    $prestamo = $_POST['prestamo'];

    if (empty($nombre) || empty($dni) || empty($prestamo)) {
        $mensaje = "Por favor, complete todos los campos.";
    } elseif (!preg_match("/^[A-Za-z\s]+$/", $nombre)) {
        $mensaje = "Nombre no válido. Debe contener solo letras y espacios.";
    } elseif (!preg_match("/^\d{8}$/", $dni)) {
        $mensaje = "DNI no válido. Debe tener 8 números.";
    } elseif ($prestamo > 10000) {
        $mensaje = "El monto de préstamo no debe ser mayor de 10,000 soles.";
    } else {
        $conn = new mysqli("nombre_del_servidor", "nombre_de_usuario", "contraseña", "nombre_de_la_base_de_datos");

        // Conexión
        if ($conn->connect_error) {
            die("Error de conexión: " . $conn->connect_error);
        }

        // Dni Existente 
        $stmt = $conn->prepare("SELECT dni FROM usuarios WHERE dni = ?");
        $stmt->bind_param("s", $dni);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $mensaje = "El DNI ya está registrado en la base de datos.";
        } else {
            $stmt = $conn->prepare("INSERT INTO usuarios (nombre, dni, prestamo) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $nombre, $dni, $prestamo);

            if ($stmt->execute()) {
                $mensaje = "El usuario se registró correctamente.";
            } else {
                $mensaje = "Error al registrar nuevo usuario: " . $conn->error;
            }
        }
        $conn->close();
    }
}
?>
