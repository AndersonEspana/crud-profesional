<?php

require_once __DIR__ . '/../models/Usuario.php';

class UsuarioController
{
    private Usuario $usuario;

    public function __construct()
    {
        $this->usuario = new Usuario();
    }

    public function index(): array
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Desactivar usuario
            if (isset($_POST['desactivar_id'])) {
                $this->usuario->desactivar((int)$_POST['desactivar_id']);
                header("Location: index.php");
                exit;
            }

            // Actualizar usuario
            if (isset($_POST['id'])) {
                $this->usuario->actualizar((int)$_POST['id'], $_POST);
                header("Location: index.php");
                exit;
            }

            // Crear usuario
            $resultado = $this->usuario->crear($_POST);

            if ($resultado === true) {
                header("Location: index.php?success=1");
            } else {
                header("Location: index.php?error=" . urlencode($resultado));
            }
            exit;
        }

        return $this->usuario->listar();
    }

    public function obtener(int $id): ?array
    {
        return $this->usuario->obtenerPorId($id);
    }
}

