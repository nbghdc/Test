<?php
class DashboardController extends Controller
{
    public function index(): void
    {
        RBAC::requirePermission('view_dashboard');
        $recentBills = Bill::recent();
        $this->render('dashboard/index', ['recentBills' => $recentBills]);
    }
}
