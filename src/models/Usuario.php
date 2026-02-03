<?php

require_once __DIR__ . '/../../config/database.php';

class Usuario
{
    private PDO $conn;
    private string $table = "usuarios";

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function listar(): array
    {
        $sql = "SELECT u.id, u.nombre, u.email, r.nombre AS rol
                FROM {$this->table} u
                INNER JOIN roles r ON u.rol_id = r.id
                WHERE u.activo = 1
                ORDER BY u.id DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function crear(array $data)
    {
        if (
            empty($data['nombre']) ||
            empty($data['email']) ||
            empty($data['password']) ||
            empty($data['rol_id'])
        ) {
            return "Todos los campos son obligatorios";
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return "El email no es válido";
        }

        if (strlen($data['password']) < 6) {
            return "La contraseña debe tener al menos 6 caracteres";
        }

        // Verificar email duplicado
        $check = $this->conn->prepare(
            "SELECT id FROM {$this->table} WHERE email = :email"
        );
        $check->execute([':email' => $data['email']]);

        if ($check->rowCount() > 0) {
            return "El email ya está registrado";
        }

        $passwordHash = password_hash($data['password'], PASSWORD_BCRYPT);

        $sql = "INSERT INTO {$this->table}
                (nombre, email, password, rol_id)
                VALUES (:nombre, :email, :password, :rol_id)";

        $stmt = $this->conn->prepare($sql);

        $ok = $stmt->execute([
            ':nombre' => trim($data['nombre']),
            ':email' => trim($data['email']),
            ':password' => $passwordHash,
            ':rol_id' => $data['rol_id']
        ]);

        return $ok ? true : "Error al guardar el usuario";
    }

    public function desactivar(int $id): bool
    {
        $sql = "UPDATE {$this->table}
                SET activo = 0
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
    public function obtenerPorId(int $id): ?array
    {
        $sql = "SELECT id, nombre, email, rol_id
                FROM {$this->table}
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }
    public function actualizar(int $id, array $data): bool
    {
        $sql = "UPDATE {$this->table}
                SET nombre = :nombre,
                    email = :email,
                    rol_id = :rol_id
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':nombre' => trim($data['nombre']),
            ':email' => trim($data['email']),
            ':rol_id' => $data['rol_id'],
            ':id' => $id
        ]);
    }



}
