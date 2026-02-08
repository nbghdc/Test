<section>
    <div class="page-header">
        <h1>Patients</h1>
        <?php if (Auth::hasPermission('patients.create')): ?>
            <a class="btn primary" href="<?= htmlspecialchars($basePath, ENT_QUOTES) ?>/patients/create">New Patient</a>
        <?php endif; ?>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Age</th>
                <th>Sex</th>
                <th>Mobile</th>
                <th>History</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($patients as $patient): ?>
                <tr>
                    <td><?= htmlspecialchars($patient['name'], ENT_QUOTES) ?></td>
                    <td><?= (int) $patient['age'] ?></td>
                    <td><?= htmlspecialchars($patient['sex'], ENT_QUOTES) ?></td>
                    <td><?= htmlspecialchars($patient['mobile'], ENT_QUOTES) ?></td>
                    <td><?= htmlspecialchars($patient['history'], ENT_QUOTES) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>
