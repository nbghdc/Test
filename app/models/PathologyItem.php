<?php
class PathologyItem
{
    public static function all(): array
    {
        $pdo = Database::connection();
        return $pdo->query('SELECT * FROM pathology_items ORDER BY id DESC')->fetchAll();
    }

    public static function create(array $data): void
    {
        $pdo = Database::connection();
        $stmt = $pdo->prepare('INSERT INTO pathology_items (category, name, price, commission_type, commission_value) VALUES (:category, :name, :price, :commission_type, :commission_value)');
        $stmt->execute([
            'category' => $data['category'],
            'name' => $data['name'],
            'price' => $data['price'],
            'commission_type' => $data['commission_type'],
            'commission_value' => $data['commission_value'],
        ]);
    }
}
