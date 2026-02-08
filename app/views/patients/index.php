<h1>Patient Registration</h1>
<section class="grid">
    <div class="card">
        <h2>Register New Patient</h2>
        <form method="POST" action="index.php?route=patients/store">
            <label>Patient Name
                <input type="text" name="name" required>
            </label>
            <div class="row">
                <label>Age
                    <input type="number" name="age" required>
                </label>
                <label>Sex
                    <select name="sex">
                        <option>Male</option>
                        <option>Female</option>
                        <option>Other</option>
                    </select>
                </label>
            </div>
            <label>Mobile Number
                <input type="text" name="mobile" required>
            </label>
            <label>Address (optional)
                <input type="text" name="address">
            </label>
            <label>Patient History
                <textarea name="history" rows="3"></textarea>
            </label>
            <button class="btn-primary">Save Patient</button>
        </form>
    </div>
    <div class="card">
        <h2>Registered Patients</h2>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Sex</th>
                    <th>Mobile</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($patients as $patient): ?>
                    <tr>
                        <td><?= e($patient['name']) ?></td>
                        <td><?= e($patient['age']) ?></td>
                        <td><?= e($patient['sex']) ?></td>
                        <td><?= e($patient['mobile']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>
