<?php
require_once __DIR__ . '/../src/controllers/UsuarioController.php';

$controller = new UsuarioController();
$usuarios = $controller->index();
?>
<?php if (isset($_GET['success'])): ?>
    <p style="color: green;">Usuario creado correctamente</p>
<?php endif; ?>

<?php if (isset($_GET['error'])): ?>
    <p style="color: red;">
        <?= htmlspecialchars($_GET['error']) ?>
    </p>
<?php endif; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CRUD Profesional</title>
</head>
<body>

<h1>Listado de Usuarios</h1>
<h2>Crear Usuario</h2>


<form method="POST" action="">
    <input type="text" name="nombre" placeholder="Nombre" required>
    <br><br>

    <input type="email" name="email" placeholder="Email" required>
    <br><br>

    <input type="password" name="password" placeholder="Contraseña" required>
    <br><br>

    <select name="rol_id" required>
        <option value="">Seleccione rol</option>
        <option value="1">ADMIN</option>
        <option value="2">USUARIO</option>
    </select>
    <br><br>

    <button type="submit">Guardar</button>
</form>

<hr>
<table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Email</th>
        <th>Rol</th>
        <th>Acciones</th>
        
    </tr>

    <?php foreach ($usuarios as $usuario): ?>
        <tr>
            <td><?= $usuario['id'] ?></td>
            <td><?= $usuario['nombre'] ?></td>
            <td><?= $usuario['email'] ?></td>
            <td><?= $usuario['rol'] ?></td>      
            <td>
                <form method="POST" action="" style="display:inline;">
                    <input type="hidden" name="desactivar_id" value="<?= $usuario['id'] ?>">
                    <a href="editar.php?id=<?= $usuario['id'] ?>">Editar</a>
                    <button type="submit">Desactivar</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>

</table>

</body>
</html>
