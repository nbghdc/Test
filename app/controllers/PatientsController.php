<?php
class PatientsController extends Controller
{
    public function index(): void
    {
        RBAC::requirePermission('manage_patients');
        $patients = Patient::all();
        $this->render('patients/index', ['patients' => $patients]);
    }

    public function store(): void
    {
        RBAC::requirePermission('manage_patients');
        Patient::create([
            'name' => trim($_POST['name'] ?? ''),
            'age' => (int)($_POST['age'] ?? 0),
            'sex' => $_POST['sex'] ?? 'Other',
            'mobile' => trim($_POST['mobile'] ?? ''),
            'address' => trim($_POST['address'] ?? ''),
            'history' => trim($_POST['history'] ?? ''),
        ]);
        $this->redirect('index.php?route=patients');
    }
}
