<h1>User Management</h1>
<section class="grid">
    <div class="card">
        <h2>Create User</h2>
        <form method="POST" action="index.php?route=users/store">
            <label>Username
                <input type="text" name="username" required>
            </label>
            <label>Full Name
                <input type="text" name="full_name" required>
            </label>
            <label>Password
                <input type="password" name="password" required>
            </label>
            <label>Status
                <select name="status">
                    <option value="active">Active</option>
                    <option value="disabled">Disabled</option>
                </select>
            </label>
            <label>Assign Roles</label>
            <div class="checkbox-group">
                <?php foreach ($roles as $role): ?>
                    <label>
                        <input type="checkbox" name="roles[]" value="<?= e($role['id']) ?>">
                        <?= e($role['name']) ?>
                    </label>
                <?php endforeach; ?>
            </div>
            <button class="btn-primary">Create User</button>
        </form>
    </div>
    <div class="card">
        <h2>Existing Users</h2>
        <table>
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= e($user['username']) ?></td>
                        <td><?= e($user['full_name']) ?></td>
                        <td><?= e($user['status']) ?></td>
                        <td><a class="btn-link" href="index.php?route=users/edit&id=<?= e($user['id']) ?>">Edit</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>
