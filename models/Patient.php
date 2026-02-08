<?php
class Patient extends Model
{
    public function all(): array
    {
        $stmt = $this->db->query('SELECT * FROM patients ORDER BY created_at DESC');
        return $stmt->fetchAll();
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare('INSERT INTO patients (name, age, sex, mobile, address, history) VALUES (:name, :age, :sex, :mobile, :address, :history)');
        $stmt->execute($data);
        return (int) $this->db->lastInsertId();
    }
}
