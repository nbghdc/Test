<?php
class PatientsController extends Controller
{
    public function index(): void
    {
        Auth::requireLogin();
        if (!Auth::hasPermission('patients.view')) {
            http_response_code(403);
            echo 'Forbidden';
            return;
        }
        $patientModel = new Patient();
        $patients = $patientModel->all();
        $this->view('patients/index', ['patients' => $patients]);
    }

    public function create(): void
    {
        Auth::requireLogin();
        if (!Auth::hasPermission('patients.create')) {
            http_response_code(403);
            echo 'Forbidden';
            return;
        }
        $this->view('patients/create');
    }

    public function store(): void
    {
        Auth::requireLogin();
        if (!Auth::hasPermission('patients.create')) {
            http_response_code(403);
            echo 'Forbidden';
            return;
        }
        $data = [
            'name' => trim($_POST['name'] ?? ''),
            'age' => (int) ($_POST['age'] ?? 0),
            'sex' => $_POST['sex'] ?? '',
            'mobile' => trim($_POST['mobile'] ?? ''),
            'address' => trim($_POST['address'] ?? ''),
            'history' => trim($_POST['history'] ?? ''),
        ];

        $patientModel = new Patient();
        $patientModel->create($data);
        header('Location: /patients');
        exit;
    }
}
