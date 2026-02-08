<?php
class BillingController extends Controller
{
    public function create(): void
    {
        Auth::requireLogin();
        if (!Auth::hasPermission('billing.create')) {
            http_response_code(403);
            echo 'Forbidden';
            return;
        }

        $billModel = new Bill();
        $invoiceId = $billModel->generateInvoiceId();
        $this->view('billing/create', ['invoiceId' => $invoiceId]);
    }

    public function store(): void
    {
        Auth::requireLogin();
        if (!Auth::hasPermission('billing.create')) {
            http_response_code(403);
            echo 'Forbidden';
            return;
        }

        $billModel = new Bill();
        $items = json_decode($_POST['items'] ?? '[]', true);
        $data = [
            'invoice_id' => $_POST['invoice_id'],
            'patient_id' => (int) $_POST['patient_id'],
            'refer_doctor_id' => (int) ($_POST['refer_doctor_id'] ?? 0),
            'consultant_doctor_id' => (int) ($_POST['consultant_doctor_id'] ?? 0),
            'bill_type' => $_POST['bill_type'],
            'billing_date' => $_POST['billing_date'],
            'total_amount' => (float) $_POST['total_amount'],
            'paid_amount' => (float) $_POST['paid_amount'],
            'due_amount' => (float) $_POST['due_amount'],
            'discount' => (float) $_POST['discount'],
        ];

        $billModel->create($data, $items);
        $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        header('Location: ' . ($basePath ?: '') . '/billing/create?success=1');
        exit;
    }

    public function calculate(): void
    {
        Auth::requireLogin();
        $items = json_decode(file_get_contents('php://input'), true) ?? [];
        $total = 0;
        foreach ($items as $item) {
            $total += ((float) $item['quantity']) * ((float) $item['unit_price']);
        }
        $this->json(['total' => $total]);
    }
}
