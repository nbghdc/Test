<?php
class AuthController extends Controller
{
    public function showLogin(): void
    {
        $this->view('auth/login');
    }

    public function login(): void
    {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $userModel = new User();
        $user = $userModel->findByEmail($email);

        if (!$user || !password_verify($password, $user['password'])) {
            $this->view('auth/login', ['error' => 'Invalid credentials']);
            return;
        }

        $_SESSION['user'] = [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'roles' => $userModel->getUserRoles((int) $user['id']),
            'permissions' => $userModel->getUserPermissions((int) $user['id']),
        ];

        $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        header('Location: ' . ($basePath ?: '/') . '/');
        exit;
    }

    public function logout(): void
    {
        session_destroy();
        $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        header('Location: ' . ($basePath ?: '') . '/login');
        exit;
    }
}
