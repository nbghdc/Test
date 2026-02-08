<section class="auth-card">
    <h1>Sign In</h1>
    <?php if (!empty($error)): ?>
        <p class="alert alert-error"><?= htmlspecialchars($error, ENT_QUOTES) ?></p>
    <?php endif; ?>
    <form method="post" action="/login">
        <label>Email
            <input type="email" name="email" required>
        </label>
        <label>Password
            <input type="password" name="password" required>
        </label>
        <button type="submit" class="btn primary">Login</button>
    </form>
    <p class="helper">Use sample accounts from the setup guide.</p>
</section>
