<?php
class PathologyController extends Controller
{
    public function index(): void
    {
        RBAC::requirePermission('manage_pathology');
        $items = PathologyItem::all();
        $this->render('pathology/index', ['items' => $items]);
    }

    public function store(): void
    {
        RBAC::requirePermission('manage_pathology');
        PathologyItem::create([
            'category' => trim($_POST['category'] ?? ''),
            'name' => trim($_POST['name'] ?? ''),
            'price' => (float)($_POST['price'] ?? 0),
            'commission_type' => $_POST['commission_type'] ?? 'percentage',
            'commission_value' => (float)($_POST['commission_value'] ?? 0),
        ]);
        $this->redirect('index.php?route=pathology');
    }
}
