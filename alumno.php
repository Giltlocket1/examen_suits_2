<?php
session_start();
include './app/config/conexion.php'; // Asegúrate de incluir tu archivo de conexión a la base de datos

// Verificar si el usuario es un alumno
if (!isset($_SESSION['alumno'])) {
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
    <title>Visualización de Alumnos</title>
</head>
<body>
    <div class="container">
        <h1 class="my-4">Lista de Alumnos</h1>

        <!-- Tabla para mostrar los alumnos -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Año de Nacimiento</th>
                    <th>Año de Ingreso</th>
                </tr>
            </thead>
            <tbody id="alumnosList">
                <!-- Aquí se mostrarán los alumnos -->
            </tbody>
        </table>
    </div>

    <script>
        // Cargar alumnos para vista de alumnos
        async function listarAlumnos() {
            const response = await fetch('app/controller/alumnosController.php?action=listar');
            const alumnos = await response.json();
            const tbody = document.querySelector('#alumnosList');
            tbody.innerHTML = ''; // Limpiar la tabla

            alumnos.forEach(alumno => {
                tbody.innerHTML += `
                    <tr>
                        <td>${alumno.id}</td>
                        <td>${alumno.nombre}</td>
                        <td>${alumno.apellido}</td>
                        <td>${alumno.year_of_birth}</td>
                        <td>${alumno.year_of_entry_into_the_degree}</td>
                    </tr>`;
            });
        }

        document.addEventListener('DOMContentLoaded', listarAlumnos);
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
