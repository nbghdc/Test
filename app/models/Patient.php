<?php
class Patient
{
    public static function all(): array
    {
        $pdo = Database::connection();
        return $pdo->query('SELECT * FROM patients ORDER BY id DESC')->fetchAll();
    }

    public static function create(array $data): void
    {
        $pdo = Database::connection();
        $stmt = $pdo->prepare('INSERT INTO patients (name, age, sex, mobile, address, history) VALUES (:name, :age, :sex, :mobile, :address, :history)');
        $stmt->execute([
            'name' => $data['name'],
            'age' => $data['age'],
            'sex' => $data['sex'],
            'mobile' => $data['mobile'],
            'address' => $data['address'],
            'history' => $data['history'],
        ]);
    }

    public static function find(int $id): ?array
    {
        $pdo = Database::connection();
        $stmt = $pdo->prepare('SELECT * FROM patients WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $patient = $stmt->fetch();
        return $patient ?: null;
    }
}
