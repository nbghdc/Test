<?php
class Report
{
    public static function dailyBilling(string $date): array
    {
        $pdo = Database::connection();
        $stmt = $pdo->prepare('SELECT bill_type, COUNT(*) as total_bills, SUM(total_amount) as total_amount, SUM(paid_amount) as paid_amount, SUM(due_amount) as due_amount FROM bills WHERE DATE(created_at) = :date GROUP BY bill_type');
        $stmt->execute(['date' => $date]);
        return $stmt->fetchAll();
    }

    public static function monthlyBilling(string $month): array
    {
        $pdo = Database::connection();
        $stmt = $pdo->prepare('SELECT DATE(created_at) as billing_date, SUM(total_amount) as total_amount, SUM(paid_amount) as paid_amount FROM bills WHERE DATE_FORMAT(created_at, "%Y-%m") = :month GROUP BY DATE(created_at)');
        $stmt->execute(['month' => $month]);
        return $stmt->fetchAll();
    }

    public static function dueCollection(): array
    {
        $pdo = Database::connection();
        return $pdo->query('SELECT invoice_id, due_amount, created_at FROM bills WHERE due_amount > 0 ORDER BY created_at DESC')->fetchAll();
    }

    public static function monthlyCommissions(string $month): array
    {
        $pdo = Database::connection();
        $stmt = $pdo->prepare('SELECT staff_name, role, SUM(commission_amount) as commission_total FROM commissions WHERE DATE_FORMAT(created_at, "%Y-%m") = :month GROUP BY staff_name, role');
        $stmt->execute(['month' => $month]);
        return $stmt->fetchAll();
    }
}
