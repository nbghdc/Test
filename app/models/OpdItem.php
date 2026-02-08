<?php
class OpdItem
{
    public static function all(): array
    {
        $pdo = Database::connection();
        return $pdo->query('SELECT * FROM opd_items ORDER BY id DESC')->fetchAll();
    }

    public static function create(array $data): void
    {
        $pdo = Database::connection();
        $stmt = $pdo->prepare('INSERT INTO opd_items (name, price, commission_type, commission_value) VALUES (:name, :price, :commission_type, :commission_value)');
        $stmt->execute([
            'name' => $data['name'],
            'price' => $data['price'],
            'commission_type' => $data['commission_type'],
            'commission_value' => $data['commission_value'],
        ]);
    }
}
