<h1>Edit User</h1>
<section class="card">
    <form method="POST" action="index.php?route=users/update">
        <input type="hidden" name="id" value="<?= e($user['id']) ?>">
        <label>Full Name
            <input type="text" name="full_name" value="<?= e($user['full_name']) ?>" required>
        </label>
        <label>New Password (optional)
            <input type="password" name="password">
        </label>
        <label>Status
            <select name="status">
                <option value="active" <?= $user['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                <option value="disabled" <?= $user['status'] === 'disabled' ? 'selected' : '' ?>>Disabled</option>
            </select>
        </label>
        <label>Assign Roles</label>
        <div class="checkbox-group">
            <?php foreach ($roles as $role): ?>
                <label>
                    <input type="checkbox" name="roles[]" value="<?= e($role['id']) ?>" <?= in_array($role['id'], $userRoles, true) ? 'checked' : '' ?>>
                    <?= e($role['name']) ?>
                </label>
            <?php endforeach; ?>
        </div>
        <button class="btn-primary">Update</button>
    </form>
</section>
