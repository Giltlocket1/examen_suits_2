<?php
include './app/config/conexion.php';

class AlumnosController {

    public function listarAlumnos() {
        global $conn;
        $sql = "SELECT * FROM t_alumnos";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $alumnos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($alumnos);
    }

    public function registrarAlumno($nombre, $apellido, $year_of_birth, $year_of_entry) {
        global $conn;
        $sql = "INSERT INTO t_alumnos (nombre, apellido, year_of_birth, year_of_entry_into_the_degree)
                VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute([$nombre, $apellido, $year_of_birth, $year_of_entry]);

        echo json_encode(['success' => $result]);
    }

    public function editarAlumno($id, $nombre, $apellido, $year_of_birth, $year_of_entry) {
        global $conn;
        $sql = "UPDATE t_alumnos SET nombre = ?, apellido = ?, year_of_birth = ?, year_of_entry_into_the_degree = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute([$nombre, $apellido, $year_of_birth, $year_of_entry, $id]);

        echo json_encode(['success' => $result]);
    }

    public function eliminarAlumno($id) {
        global $conn;
        $sql = "DELETE FROM t_alumnos WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute([$id]);

        echo json_encode(['success' => $result]);
    }
}

// Determinar la acción solicitada
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_GET['action'] ?? null;
    $controller = new AlumnosController();

    switch ($action) {
        case 'registrar':
            $controller->registrarAlumno($_POST['nombre'], $_POST['apellido'], $_POST['year_of_birth'], $_POST['year_of_entry']);
            break;
        case 'editar':
            $controller->editarAlumno($_POST['id'], $_POST['nombre'], $_POST['apellido'], $_POST['year_of_birth'], $_POST['year_of_entry']);
            break;
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $action = $_GET['action'] ?? null;
    $controller = new AlumnosController();

    switch ($action) {
        case 'listar':
            $controller->listarAlumnos();
            break;
        case 'eliminar':
            $controller->eliminarAlumno($_GET['id']);
            break;
    }
}
?>
