<?php
require_once __DIR__ . '/../src/controllers/UsuarioController.php';

$controller = new UsuarioController();

if (!isset($_GET['id'])) {
    die("ID no válido");
}

$usuario = $controller->obtener((int)$_GET['id']);
?>

<h2>Editar Usuario</h2>

<form method="POST">
    <input type="hidden" name="id" value="<?= $usuario['id'] ?>">

    <input type="text" name="nombre" value="<?= $usuario['nombre'] ?>" required><br><br>
    <input type="email" name="email" value="<?= $usuario['email'] ?>" required><br><br>

    <select name="rol_id">
        <option value="1" <?= $usuario['rol_id'] == 1 ? 'selected' : '' ?>>ADMIN</option>
        <option value="2" <?= $usuario['rol_id'] == 2 ? 'selected' : '' ?>>USUARIO</option>
    </select><br><br>

    <button type="submit">Actualizar</button>
</form>
