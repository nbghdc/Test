<?php
class ReportsController extends Controller
{
    public function index(): void
    {
        RBAC::requirePermission('view_reports');
        $date = $_GET['date'] ?? date('Y-m-d');
        $month = $_GET['month'] ?? date('Y-m');
        $daily = Report::dailyBilling($date);
        $monthly = Report::monthlyBilling($month);
        $due = Report::dueCollection();
        $commissions = Report::monthlyCommissions($month);
        $this->render('reports/index', [
            'date' => $date,
            'month' => $month,
            'daily' => $daily,
            'monthly' => $monthly,
            'due' => $due,
            'commissions' => $commissions,
        ]);
    }
}
