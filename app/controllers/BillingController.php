<?php
class BillingController extends Controller
{
    public function create(): void
    {
        RBAC::requirePermission('manage_billing');
        $patients = Patient::all();
        $opdItems = OpdItem::all();
        $pathologyItems = PathologyItem::all();
        $this->render('billing/create', [
            'patients' => $patients,
            'opdItems' => $opdItems,
            'pathologyItems' => $pathologyItems,
        ]);
    }

    public function store(): void
    {
        RBAC::requirePermission('manage_billing');
        $items = json_decode($_POST['items'] ?? '[]', true) ?: [];
        $billId = Bill::create([
            'patient_id' => (int)($_POST['patient_id'] ?? 0),
            'bill_type' => $_POST['bill_type'] ?? 'OPD',
            'refer_doctor' => trim($_POST['refer_doctor'] ?? ''),
            'consultant_doctor' => trim($_POST['consultant_doctor'] ?? ''),
            'total_amount' => (float)($_POST['total_amount'] ?? 0),
            'paid_amount' => (float)($_POST['paid_amount'] ?? 0),
            'due_amount' => (float)($_POST['due_amount'] ?? 0),
            'discount' => (float)($_POST['discount'] ?? 0),
            'items' => $items,
        ]);
        $this->redirect('index.php?route=billing/invoice&id=' . $billId);
    }

    public function invoice(): void
    {
        RBAC::requirePermission('manage_billing');
        $id = (int)($_GET['id'] ?? 0);
        $bill = Bill::find($id);
        $this->render('billing/invoice', ['bill' => $bill]);
    }
}
