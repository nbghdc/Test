<div class="auth-container">
    <h1>Secure Login</h1>
    <?php if (!empty($error)): ?>
        <div class="alert alert-error"><?= e($error) ?></div>
    <?php endif; ?>
    <form method="POST" action="index.php?route=authenticate" class="card">
        <label>Username
            <input type="text" name="username" required>
        </label>
        <label>Password
            <input type="password" name="password" required>
        </label>
        <button type="submit" class="btn-primary">Login</button>
    </form>
    <p class="helper">Use the sample accounts from the setup guide.</p>
</div>
