<h1>OPD Items & Services</h1>
<section class="grid">
    <div class="card">
        <h2>Add OPD Service</h2>
        <form method="POST" action="index.php?route=opd/store">
            <label>Service Name
                <input type="text" name="name" required>
            </label>
            <label>Price
                <input type="number" step="0.01" name="price" required>
            </label>
            <div class="row">
                <label>Commission Type
                    <select name="commission_type">
                        <option value="percentage">Percentage</option>
                        <option value="fixed">Fixed</option>
                    </select>
                </label>
                <label>Commission Value
                    <input type="number" step="0.01" name="commission_value" required>
                </label>
            </div>
            <button class="btn-primary">Save</button>
        </form>
    </div>
    <div class="card">
        <h2>Available Services</h2>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Commission</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?= e($item['name']) ?></td>
                        <td><?= number_format((float)$item['price'], 2) ?></td>
                        <td><?= e($item['commission_type']) ?> <?= e($item['commission_value']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>
