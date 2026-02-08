<?php
class RBAC
{
    public static function userPermissions(int $userId): array
    {
        $pdo = Database::connection();
        $stmt = $pdo->prepare(
            'SELECT DISTINCT p.name FROM permissions p
            INNER JOIN role_permissions rp ON rp.permission_id = p.id
            INNER JOIN roles r ON r.id = rp.role_id
            INNER JOIN user_roles ur ON ur.role_id = r.id
            WHERE ur.user_id = :user_id'
        );
        $stmt->execute(['user_id' => $userId]);
        return array_column($stmt->fetchAll(), 'name');
    }

    public static function hasPermission(string $permission): bool
    {
        $user = Auth::user();
        if (!$user) {
            return false;
        }
        if (!isset($_SESSION['permissions'])) {
            $_SESSION['permissions'] = self::userPermissions($user['id']);
        }
        return in_array($permission, $_SESSION['permissions'], true);
    }

    public static function requirePermission(string $permission): void
    {
        if (!self::hasPermission($permission)) {
            http_response_code(403);
            include __DIR__ . '/../views/layouts/header.php';
            echo '<div class="alert">Access denied for this action.</div>';
            include __DIR__ . '/../views/layouts/footer.php';
            exit;
        }
    }
}
