<?php
session_start();
include './app/config/conexion.php'; // Archivo de conexión a la base de datos
include './app/controller/usuariosController.php'; // Controlador de usuarios

$error_admin = '';
$error_alumno = '';

$usuariosController = new UsuariosController(); // Crear instancia del controlador

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Manejar el inicio de sesión del administrador
    if (isset($_POST['admin_login'])) {
        $usuario = $_POST['usuario'];
        $password = $_POST['password'];

        // Validar administrador usando el método validarUsuario
        $admin = $usuariosController->validarUsuario($usuario, $password);

        if ($admin && $admin['rol'] === 'admin') { // Verificar si el rol es 'admin'
            $_SESSION['admin'] = $admin['id'];
            header('Location: admin.php');
            exit();
        } else {
            $error_admin = "Usuario o contraseña incorrectos para administrador.";
        }
    }

    // Manejar el inicio de sesión del alumno
    if (isset($_POST['alumno_login'])) {
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];

        // Consulta para verificar al alumno
        $stmt = $conn->prepare("SELECT * FROM t_alumnos WHERE nombre = ? AND apellido = ?");
        $stmt->execute([$nombre, $apellido]);
        $alumno = $stmt->fetch();

        if ($alumno) {
            // Si el alumno existe, iniciar sesión
            $_SESSION['alumno'] = $alumno['id'];
            header('Location: alumno.php');
            exit();
        } else {
            $error_alumno = "Nombre o apellido incorrectos.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Login</title>
</head>
<body>
    <div class="container">
        <div class="card my-5">
            <div class="card-body">
                <h5 class="card-title">Login Administrador</h5>
                <?php if ($error_admin): ?>
                    <div class="alert alert-danger"><?= $error_admin ?></div>
                <?php endif; ?>
                <form method="POST">
                    <div class="mb-3">
                        <label for="usuario" class="form-label">Usuario</label>
                        <input type="text" class="form-control" id="usuario" name="usuario" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" name="admin_login" class="btn btn-primary">Iniciar Sesión</button>
                </form>
            </div>
        </div>

        <div class="card my-5">
            <div class="card-body">
                <h5 class="card-title">Login Alumno</h5>
                <?php if ($error_alumno): ?>
                    <div class="alert alert-danger"><?= $error_alumno ?></div>
                <?php endif; ?>
                <form method="POST">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="apellido" class="form-label">Apellido</label>
                        <input type="text" class="form-control" id="apellido" name="apellido" required>
                    </div>
                    <button type="submit" name="alumno_login" class="btn btn-primary">Iniciar Sesión</button>
                </form>
            </div>
        </div>
    </div>

    <script src="public/js/bootstrap.bundle.min.js"></script>
</body>
</html>
