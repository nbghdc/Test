<section>
    <h1>Create Invoice</h1>
    <?php if (!empty($_GET['success'])): ?>
        <p class="alert alert-success">Invoice saved successfully.</p>
    <?php endif; ?>
    <form method="post" action="/billing">
        <div class="grid">
            <label>Invoice ID
                <input type="text" name="invoice_id" value="<?= htmlspecialchars($invoiceId, ENT_QUOTES) ?>" readonly>
            </label>
            <label>Billing Date
                <input type="date" name="billing_date" value="<?= date('Y-m-d') ?>" required>
            </label>
            <label>Patient ID
                <input type="number" name="patient_id" required>
            </label>
            <label>Bill Type
                <select name="bill_type" required>
                    <option value="opd">OPD</option>
                    <option value="pathology">Pathology</option>
                </select>
            </label>
            <label>Refer Doctor ID
                <input type="number" name="refer_doctor_id">
            </label>
            <label>Consultant Doctor ID
                <input type="number" name="consultant_doctor_id">
            </label>
        </div>

        <h2>Itemized Services/Tests</h2>
        <table class="table" id="billing-items">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Qty</th>
                    <th>Unit Price</th>
                    <th>Total</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="text" name="description" placeholder="Consultation"></td>
                    <td><input type="number" name="quantity" value="1" min="1"></td>
                    <td><input type="number" name="unit_price" value="0" min="0"></td>
                    <td class="row-total">0</td>
                    <td><button class="btn ghost" type="button" data-remove>Remove</button></td>
                </tr>
            </tbody>
        </table>
        <button class="btn secondary" type="button" id="add-item">Add Item</button>

        <div class="grid totals">
            <label>Total Amount
                <input type="number" name="total_amount" id="total-amount" readonly>
            </label>
            <label>Discount (Less)
                <input type="number" name="discount" id="discount" value="0">
            </label>
            <label>Paid Amount
                <input type="number" name="paid_amount" id="paid-amount" value="0">
            </label>
            <label>Due Amount
                <input type="number" name="due_amount" id="due-amount" readonly>
            </label>
        </div>
        <input type="hidden" name="items" id="items-field">
        <button class="btn primary" type="submit">Save Invoice</button>
    </form>
</section>
