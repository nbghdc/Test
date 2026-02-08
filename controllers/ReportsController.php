<?php
class ReportsController extends Controller
{
    public function index(): void
    {
        Auth::requireLogin();
        if (!Auth::hasPermission('reports.view')) {
            http_response_code(403);
            echo 'Forbidden';
            return;
        }
        $this->view('reports/index');
    }
}
