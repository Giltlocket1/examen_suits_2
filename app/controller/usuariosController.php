<?php
include './app/config/conexion.php';

class UsuariosController {

    // Validar credenciales de usuario
    public function validarUsuario($usuario, $password) {
        global $conn;
        $sql = "SELECT * FROM t_usuarios WHERE usuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$usuario]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar si el usuario existe y la contraseña coincide
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    // Registrar un nuevo usuario
    public function registrarUsuario($usuario, $password, $rol) {
        global $conn;
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $sql = "INSERT INTO t_usuarios (usuario, password, rol) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$usuario, $hashedPassword, $rol]);
    }

    // Editar usuario (solo para admins)
    public function editarUsuario($id, $usuario, $password, $rol) {
        global $conn;
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $sql = "UPDATE t_usuarios SET usuario = ?, password = ?, rol = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$usuario, $hashedPassword, $rol, $id]);
    }

    // Eliminar un usuario (solo para admins)
    public function eliminarUsuario($id) {
        global $conn;
        $sql = "DELETE FROM t_usuarios WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]);
    }
}
?>
