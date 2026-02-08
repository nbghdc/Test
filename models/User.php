<?php
class User extends Model
{
    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE email = :email AND is_active = 1');
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public function getUserPermissions(int $userId): array
    {
        $sql = 'SELECT DISTINCT p.slug
                FROM permissions p
                JOIN role_permissions rp ON rp.permission_id = p.id
                JOIN user_roles ur ON ur.role_id = rp.role_id
                WHERE ur.user_id = :user_id
                UNION
                SELECT p.slug
                FROM permissions p
                JOIN user_permissions up ON up.permission_id = p.id
                WHERE up.user_id = :user_id';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        return array_column($stmt->fetchAll(), 'slug');
    }

    public function getUserRoles(int $userId): array
    {
        $stmt = $this->db->prepare('SELECT r.slug FROM roles r JOIN user_roles ur ON ur.role_id = r.id WHERE ur.user_id = :user_id');
        $stmt->execute(['user_id' => $userId]);
        return array_column($stmt->fetchAll(), 'slug');
    }
}
