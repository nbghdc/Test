<?php
class Bill
{
    public static function generateInvoiceId(): string
    {
        $pdo = Database::connection();
        $prefix = date('Ym');
        $stmt = $pdo->prepare('SELECT invoice_id FROM bills WHERE invoice_id LIKE :prefix ORDER BY invoice_id DESC LIMIT 1');
        $stmt->execute(['prefix' => $prefix . '-%']);
        $last = $stmt->fetchColumn();
        $sequence = 1;
        if ($last) {
            $parts = explode('-', $last);
            $sequence = ((int)($parts[1] ?? 0)) + 1;
        }
        return sprintf('%s-%04d', $prefix, $sequence);
    }

    private static function calculateCommission(float $price, string $type, float $value): float
    {
        if ($type === 'percentage') {
            return ($price * $value) / 100;
        }
        return $value;
    }

    public static function create(array $data): int
    {
        $pdo = Database::connection();
        $invoiceId = self::generateInvoiceId();
        $stmt = $pdo->prepare('INSERT INTO bills (invoice_id, patient_id, bill_type, refer_doctor, consultant_doctor, total_amount, paid_amount, due_amount, discount) VALUES (:invoice_id, :patient_id, :bill_type, :refer_doctor, :consultant_doctor, :total_amount, :paid_amount, :due_amount, :discount)');
        $stmt->execute([
            'invoice_id' => $invoiceId,
            'patient_id' => $data['patient_id'],
            'bill_type' => $data['bill_type'],
            'refer_doctor' => $data['refer_doctor'],
            'consultant_doctor' => $data['consultant_doctor'],
            'total_amount' => $data['total_amount'],
            'paid_amount' => $data['paid_amount'],
            'due_amount' => $data['due_amount'],
            'discount' => $data['discount'],
        ]);
        $billId = (int)$pdo->lastInsertId();
        $itemStmt = $pdo->prepare('INSERT INTO bill_items (bill_id, item_type, item_name, quantity, price, total) VALUES (:bill_id, :item_type, :item_name, :quantity, :price, :total)');
        $commissionStmt = $pdo->prepare('INSERT INTO commissions (staff_name, role, bill_id, commission_type, commission_value, commission_amount) VALUES (:staff_name, :role, :bill_id, :commission_type, :commission_value, :commission_amount)');

        foreach ($data['items'] as $item) {
            $itemStmt->execute([
                'bill_id' => $billId,
                'item_type' => $item['item_type'],
                'item_name' => $item['item_name'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'total' => $item['total'],
            ]);

            $commissionConfig = self::findCommissionConfig($item['item_type'], $item['item_name']);
            if ($commissionConfig && !empty($data['refer_doctor'])) {
                $commissionAmount = self::calculateCommission(
                    (float)$item['total'],
                    $commissionConfig['commission_type'],
                    (float)$commissionConfig['commission_value']
                );
                $commissionStmt->execute([
                    'staff_name' => $data['refer_doctor'],
                    'role' => 'Doctor',
                    'bill_id' => $billId,
                    'commission_type' => $commissionConfig['commission_type'],
                    'commission_value' => $commissionConfig['commission_value'],
                    'commission_amount' => $commissionAmount,
                ]);
            }
        }
        return $billId;
    }

    private static function findCommissionConfig(string $type, string $name): ?array
    {
        $pdo = Database::connection();
        if ($type === 'OPD') {
            $stmt = $pdo->prepare('SELECT commission_type, commission_value FROM opd_items WHERE name = :name LIMIT 1');
        } else {
            $stmt = $pdo->prepare('SELECT commission_type, commission_value FROM pathology_items WHERE name = :name LIMIT 1');
        }
        $stmt->execute(['name' => $name]);
        $config = $stmt->fetch();
        return $config ?: null;
    }

    public static function find(int $id): ?array
    {
        $pdo = Database::connection();
        $stmt = $pdo->prepare('SELECT b.*, p.name as patient_name, p.age, p.sex, p.mobile FROM bills b INNER JOIN patients p ON p.id = b.patient_id WHERE b.id = :id');
        $stmt->execute(['id' => $id]);
        $bill = $stmt->fetch();
        if (!$bill) {
            return null;
        }
        $itemStmt = $pdo->prepare('SELECT * FROM bill_items WHERE bill_id = :bill_id');
        $itemStmt->execute(['bill_id' => $id]);
        $bill['items'] = $itemStmt->fetchAll();
        return $bill;
    }

    public static function recent(): array
    {
        $pdo = Database::connection();
        return $pdo->query('SELECT b.id, b.invoice_id, b.bill_type, b.total_amount, b.paid_amount, b.due_amount, b.created_at, p.name as patient_name FROM bills b INNER JOIN patients p ON p.id = b.patient_id ORDER BY b.created_at DESC LIMIT 10')->fetchAll();
    }
}
