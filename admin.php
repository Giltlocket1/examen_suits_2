<?php
session_start();
include './app/config/conexion.php'; // Asegúrate de incluir tu archivo de conexión a la base de datos

// Verificar si el usuario es un alumno
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

// Incluir el controlador para listar alumnos
include './app/controller/alumnosController.php';

$alumnosController = new AlumnosController();
$alumnos = $alumnosController->listarAlumnos();
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Administrar Alumnos</title>
</head>
<body>
    <div class="container">
        <h1 class="my-4">Administrar Alumnos</h1>

        <!-- Formulario para agregar/editar alumno -->
        <form id="alumnoForm">
            <input type="hidden" id="alumno_id">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="mb-3">
                <label for="apellido" class="form-label">Apellido</label>
                <input type="text" class="form-control" id="apellido" name="apellido" required>
            </div>
            <div class="mb-3">
                <label for="year_of_birth" class="form-label">Año de Nacimiento</label>
                <input type="number" class="form-control" id="year_of_birth" name="year_of_birth" required>
            </div>
            <div class="mb-3">
                <label for="year_of_entry" class="form-label">Año de Ingreso</label>
                <input type="number" class="form-control" id="year_of_entry" name="year_of_entry" required>
            </div>
            <button type="submit" class="btn btn-primary">Registrar/Actualizar Alumno</button>
        </form>

        <!-- Tabla para mostrar los alumnos -->
        <table class="table table-bordered my-4">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Año de Nacimiento</th>
                    <th>Año de Ingreso</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="alumnosList">
                <!-- Aquí se mostrarán los alumnos -->
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="public/js/admin.js"></script>
</body>
</html>
