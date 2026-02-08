<?php
class AuthController extends Controller
{
    public function login(): void
    {
        if (Auth::check()) {
            $this->redirect('index.php');
        }
        $this->render('auth/login');
    }

    public function authenticate(): void
    {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        if (Auth::attempt($username, $password)) {
            $this->redirect('index.php');
        }
        $this->render('auth/login', ['error' => 'Invalid credentials']);
    }

    public function logout(): void
    {
        Auth::logout();
        $this->redirect('index.php?route=login');
    }
}
