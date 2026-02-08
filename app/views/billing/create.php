<h1>Unified Billing</h1>
<section class="card">
    <form method="POST" action="index.php?route=billing/store" id="billing-form">
        <div class="row">
            <label>Patient
                <select name="patient_id" required>
                    <?php foreach ($patients as $patient): ?>
                        <option value="<?= e($patient['id']) ?>"><?= e($patient['name']) ?> (<?= e($patient['mobile']) ?>)</option>
                    <?php endforeach; ?>
                </select>
            </label>
            <label>Bill Type
                <select name="bill_type" id="bill-type">
                    <option value="OPD">OPD</option>
                    <option value="Pathology">Pathology</option>
                </select>
            </label>
        </div>
        <div class="row">
            <label>Refer Doctor
                <input type="text" name="refer_doctor">
            </label>
            <label>Consultant Doctor
                <input type="text" name="consultant_doctor">
            </label>
        </div>
        <h2>Bill Items</h2>
        <div class="row">
            <label>Service/Test
                <select id="item-select">
                    <?php foreach ($opdItems as $item): ?>
                        <option data-type="OPD" data-price="<?= e($item['price']) ?>" value="<?= e($item['name']) ?>">OPD: <?= e($item['name']) ?></option>
                    <?php endforeach; ?>
                    <?php foreach ($pathologyItems as $item): ?>
                        <option data-type="Pathology" data-price="<?= e($item['price']) ?>" value="<?= e($item['name']) ?>">Pathology: <?= e($item['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
            <label>Quantity
                <input type="number" id="item-qty" value="1" min="1">
            </label>
            <button type="button" class="btn-secondary" id="add-item">Add</button>
        </div>
        <table id="items-table">
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Item</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Total</th>
                    <th></th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
        <input type="hidden" name="items" id="items-input">
        <div class="row">
            <label>Total Amount
                <input type="number" step="0.01" name="total_amount" id="total-amount" readonly>
            </label>
            <label>Discount (Less)
                <input type="number" step="0.01" name="discount" id="discount" value="0">
            </label>
            <label>Paid Amount
                <input type="number" step="0.01" name="paid_amount" id="paid-amount" value="0">
            </label>
            <label>Due Amount
                <input type="number" step="0.01" name="due_amount" id="due-amount" readonly>
            </label>
        </div>
        <button class="btn-primary">Generate Invoice</button>
    </form>
</section>
<script src="<?= base_url('assets/js/billing.js') ?>"></script>
