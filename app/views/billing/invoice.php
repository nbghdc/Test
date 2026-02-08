<h1>Invoice</h1>
<section class="card" id="invoice-area">
    <?php if (!$bill): ?>
        <p>No invoice found.</p>
    <?php else: ?>
        <div class="invoice-header">
            <div>
                <h2>Invoice #<?= e($bill['invoice_id']) ?></h2>
                <p>Billing Date: <?= e($bill['created_at']) ?></p>
            </div>
            <button class="btn-secondary" onclick="window.print()">Print</button>
        </div>
        <div class="invoice-details">
            <p><strong>Patient:</strong> <?= e($bill['patient_name']) ?></p>
            <p><strong>Age:</strong> <?= e($bill['age']) ?> | <strong>Sex:</strong> <?= e($bill['sex']) ?></p>
            <p><strong>Mobile:</strong> <?= e($bill['mobile']) ?></p>
            <p><strong>Refer Doctor:</strong> <?= e($bill['refer_doctor']) ?></p>
            <p><strong>Consultant Doctor:</strong> <?= e($bill['consultant_doctor']) ?></p>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Item</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bill['items'] as $item): ?>
                    <tr>
                        <td><?= e($item['item_type']) ?></td>
                        <td><?= e($item['item_name']) ?></td>
                        <td><?= e($item['quantity']) ?></td>
                        <td><?= number_format((float)$item['price'], 2) ?></td>
                        <td><?= number_format((float)$item['total'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="totals">
            <p><strong>Total:</strong> <?= number_format((float)$bill['total_amount'], 2) ?></p>
            <p><strong>Discount:</strong> <?= number_format((float)$bill['discount'], 2) ?></p>
            <p><strong>Paid:</strong> <?= number_format((float)$bill['paid_amount'], 2) ?></p>
            <p><strong>Due:</strong> <?= number_format((float)$bill['due_amount'], 2) ?></p>
        </div>
    <?php endif; ?>
</section>
