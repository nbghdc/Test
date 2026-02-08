<?php
class Bill extends Model
{
    public function create(array $data, array $items): int
    {
        $this->db->beginTransaction();
        $stmt = $this->db->prepare('INSERT INTO bills (invoice_id, patient_id, refer_doctor_id, consultant_doctor_id, bill_type, billing_date, total_amount, paid_amount, due_amount, discount) VALUES (:invoice_id, :patient_id, :refer_doctor_id, :consultant_doctor_id, :bill_type, :billing_date, :total_amount, :paid_amount, :due_amount, :discount)');
        $stmt->execute($data);
        $billId = (int) $this->db->lastInsertId();

        $itemStmt = $this->db->prepare('INSERT INTO bill_items (bill_id, item_type, item_id, description, quantity, unit_price, total_price) VALUES (:bill_id, :item_type, :item_id, :description, :quantity, :unit_price, :total_price)');
        foreach ($items as $item) {
            $itemStmt->execute([
                'bill_id' => $billId,
                'item_type' => $item['item_type'],
                'item_id' => $item['item_id'],
                'description' => $item['description'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'total_price' => $item['total_price'],
            ]);
        }

        $this->db->commit();
        return $billId;
    }

    public function generateInvoiceId(): string
    {
        $prefix = date('Ym');
        $stmt = $this->db->prepare('SELECT COUNT(*) as total FROM bills WHERE invoice_id LIKE :prefix');
        $stmt->execute(['prefix' => $prefix . '%']);
        $count = (int) $stmt->fetch()['total'] + 1;
        return sprintf('%s-%04d', $prefix, $count);
    }
}
