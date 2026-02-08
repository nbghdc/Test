<section class="dashboard">
    <h1>Welcome, <?= htmlspecialchars(Auth::user()['name'] ?? 'User', ENT_QUOTES) ?></h1>
    <div class="cards">
        <div class="card">
            <h3>Daily Billing</h3>
            <p>Track OPD and Pathology billing performance.</p>
        </div>
        <div class="card">
            <h3>Due Collections</h3>
            <p>Monitor outstanding dues and follow-up actions.</p>
        </div>
        <div class="card">
            <h3>Commission Summary</h3>
            <p>View doctor and pharmacist commission reports.</p>
        </div>
    </div>
</section>
