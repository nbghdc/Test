<?php
class User
{
    public static function all(): array
    {
        $pdo = Database::connection();
        return $pdo->query('SELECT id, username, full_name, status FROM users ORDER BY id DESC')->fetchAll();
    }

    public static function create(array $data): void
    {
        $pdo = Database::connection();
        $stmt = $pdo->prepare('INSERT INTO users (username, full_name, password_hash, status) VALUES (:username, :full_name, :password_hash, :status)');
        $stmt->execute([
            'username' => $data['username'],
            'full_name' => $data['full_name'],
            'password_hash' => password_hash($data['password'], PASSWORD_BCRYPT),
            'status' => $data['status'],
        ]);
        $userId = (int)$pdo->lastInsertId();
        self::syncRoles($userId, $data['roles'] ?? []);
    }

    public static function update(int $id, array $data): void
    {
        $pdo = Database::connection();
        $stmt = $pdo->prepare('UPDATE users SET full_name = :full_name, status = :status WHERE id = :id');
        $stmt->execute([
            'full_name' => $data['full_name'],
            'status' => $data['status'],
            'id' => $id,
        ]);
        if (!empty($data['password'])) {
            $stmt = $pdo->prepare('UPDATE users SET password_hash = :password_hash WHERE id = :id');
            $stmt->execute([
                'password_hash' => password_hash($data['password'], PASSWORD_BCRYPT),
                'id' => $id,
            ]);
        }
        self::syncRoles($id, $data['roles'] ?? []);
    }

    public static function find(int $id): ?array
    {
        $pdo = Database::connection();
        $stmt = $pdo->prepare('SELECT id, username, full_name, status FROM users WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public static function roles(int $id): array
    {
        $pdo = Database::connection();
        $stmt = $pdo->prepare('SELECT role_id FROM user_roles WHERE user_id = :id');
        $stmt->execute(['id' => $id]);
        return array_column($stmt->fetchAll(), 'role_id');
    }

    public static function syncRoles(int $userId, array $roles): void
    {
        $pdo = Database::connection();
        $pdo->prepare('DELETE FROM user_roles WHERE user_id = :user_id')->execute(['user_id' => $userId]);
        $stmt = $pdo->prepare('INSERT INTO user_roles (user_id, role_id) VALUES (:user_id, :role_id)');
        foreach ($roles as $roleId) {
            $stmt->execute(['user_id' => $userId, 'role_id' => $roleId]);
        }
        unset($_SESSION['permissions']);
    }

    public static function rolesList(): array
    {
        $pdo = Database::connection();
        return $pdo->query('SELECT id, name FROM roles ORDER BY name')->fetchAll();
    }
}
