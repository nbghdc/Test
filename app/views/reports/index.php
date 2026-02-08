<h1>Reports & Analytics</h1>
<section class="grid">
    <div class="card">
        <h2>Daily Billing</h2>
        <form method="GET" action="index.php">
            <input type="hidden" name="route" value="reports">
            <input type="date" name="date" value="<?= e($date) ?>">
            <button class="btn-secondary">Run</button>
        </form>
        <table>
            <thead>
                <tr>
                    <th>Bill Type</th>
                    <th>Count</th>
                    <th>Total</th>
                    <th>Paid</th>
                    <th>Due</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($daily as $row): ?>
                    <tr>
                        <td><?= e($row['bill_type']) ?></td>
                        <td><?= e($row['total_bills']) ?></td>
                        <td><?= number_format((float)$row['total_amount'], 2) ?></td>
                        <td><?= number_format((float)$row['paid_amount'], 2) ?></td>
                        <td><?= number_format((float)$row['due_amount'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="card">
        <h2>Monthly Billing</h2>
        <form method="GET" action="index.php">
            <input type="hidden" name="route" value="reports">
            <input type="month" name="month" value="<?= e($month) ?>">
            <button class="btn-secondary">Run</button>
        </form>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Paid</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($monthly as $row): ?>
                    <tr>
                        <td><?= e($row['billing_date']) ?></td>
                        <td><?= number_format((float)$row['total_amount'], 2) ?></td>
                        <td><?= number_format((float)$row['paid_amount'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="card">
        <h2>Due Collection</h2>
        <table>
            <thead>
                <tr>
                    <th>Invoice</th>
                    <th>Due Amount</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($due as $row): ?>
                    <tr>
                        <td><?= e($row['invoice_id']) ?></td>
                        <td><?= number_format((float)$row['due_amount'], 2) ?></td>
                        <td><?= e($row['created_at']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="card">
        <h2>Monthly Commission Summary</h2>
        <table>
            <thead>
                <tr>
                    <th>Staff</th>
                    <th>Role</th>
                    <th>Commission</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($commissions as $row): ?>
                    <tr>
                        <td><?= e($row['staff_name']) ?></td>
                        <td><?= e($row['role']) ?></td>
                        <td><?= number_format((float)$row['commission_total'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>
