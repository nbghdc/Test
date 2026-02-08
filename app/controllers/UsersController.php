<?php
class UsersController extends Controller
{
    public function index(): void
    {
        RBAC::requirePermission('manage_users');
        $users = User::all();
        $roles = User::rolesList();
        $this->render('users/index', ['users' => $users, 'roles' => $roles]);
    }

    public function store(): void
    {
        RBAC::requirePermission('manage_users');
        User::create([
            'username' => trim($_POST['username'] ?? ''),
            'full_name' => trim($_POST['full_name'] ?? ''),
            'password' => $_POST['password'] ?? '',
            'status' => $_POST['status'] ?? 'active',
            'roles' => $_POST['roles'] ?? [],
        ]);
        $this->redirect('index.php?route=users');
    }

    public function edit(): void
    {
        RBAC::requirePermission('manage_users');
        $id = (int)($_GET['id'] ?? 0);
        $user = User::find($id);
        $roles = User::rolesList();
        $userRoles = User::roles($id);
        $this->render('users/edit', ['user' => $user, 'roles' => $roles, 'userRoles' => $userRoles]);
    }

    public function update(): void
    {
        RBAC::requirePermission('manage_users');
        $id = (int)($_POST['id'] ?? 0);
        User::update($id, [
            'full_name' => trim($_POST['full_name'] ?? ''),
            'password' => $_POST['password'] ?? '',
            'status' => $_POST['status'] ?? 'active',
            'roles' => $_POST['roles'] ?? [],
        ]);
        $this->redirect('index.php?route=users');
    }
}
