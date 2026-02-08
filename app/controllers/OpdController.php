<?php
class OpdController extends Controller
{
    public function index(): void
    {
        RBAC::requirePermission('manage_opd');
        $items = OpdItem::all();
        $this->render('opd/index', ['items' => $items]);
    }

    public function store(): void
    {
        RBAC::requirePermission('manage_opd');
        OpdItem::create([
            'name' => trim($_POST['name'] ?? ''),
            'price' => (float)($_POST['price'] ?? 0),
            'commission_type' => $_POST['commission_type'] ?? 'percentage',
            'commission_value' => (float)($_POST['commission_value'] ?? 0),
        ]);
        $this->redirect('index.php?route=opd');
    }
}
