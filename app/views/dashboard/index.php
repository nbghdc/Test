<h1>Dashboard</h1>
<section class="grid">
    <div class="card">
        <h2>Quick Actions</h2>
        <ul>
            <li><a href="index.php?route=patients">Register Patient</a></li>
            <li><a href="index.php?route=billing/create">Generate Bill</a></li>
            <li><a href="index.php?route=reports">View Reports</a></li>
        </ul>
    </div>
    <div class="card">
        <h2>Recent Bills</h2>
        <table>
            <thead>
                <tr>
                    <th>Invoice</th>
                    <th>Patient</th>
                    <th>Type</th>
                    <th>Total</th>
                    <th>Due</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recentBills as $bill): ?>
                    <tr>
                        <td><?= e($bill['invoice_id']) ?></td>
                        <td><?= e($bill['patient_name']) ?></td>
                        <td><?= e($bill['bill_type']) ?></td>
                        <td><?= number_format((float)$bill['total_amount'], 2) ?></td>
                        <td><?= number_format((float)$bill['due_amount'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>
