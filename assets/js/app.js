const billingTable = document.querySelector('#billing-items');
const basePath = document.body?.dataset?.basePath || '';

const updateTotals = () => {
    if (!billingTable) {
        return;
    }
    const rows = Array.from(billingTable.querySelectorAll('tbody tr'));
    const items = rows.map((row) => {
        const description = row.querySelector('input[name="description"]').value;
        const quantity = parseFloat(row.querySelector('input[name="quantity"]').value || 0);
        const unitPrice = parseFloat(row.querySelector('input[name="unit_price"]').value || 0);
        const total = quantity * unitPrice;
        row.querySelector('.row-total').textContent = total.toFixed(2);
        return {
            description,
            quantity,
            unit_price: unitPrice,
            total_price: total,
            item_type: 'custom',
            item_id: 0,
        };
    });

    fetch(`${basePath}/billing/calc`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(items),
    })
        .then((response) => response.json())
        .then((data) => {
            const totalAmount = document.getElementById('total-amount');
            const discount = parseFloat(document.getElementById('discount').value || 0);
            const paidAmount = parseFloat(document.getElementById('paid-amount').value || 0);
            totalAmount.value = data.total.toFixed(2);
            const dueAmount = document.getElementById('due-amount');
            const due = Math.max(data.total - discount - paidAmount, 0);
            dueAmount.value = due.toFixed(2);
            const itemsField = document.getElementById('items-field');
            itemsField.value = JSON.stringify(items);
        });
};

if (billingTable) {
    billingTable.addEventListener('input', updateTotals);
    billingTable.addEventListener('click', (event) => {
        if (event.target.matches('[data-remove]')) {
            event.preventDefault();
            const row = event.target.closest('tr');
            if (row) {
                row.remove();
                updateTotals();
            }
        }
    });

    document.getElementById('add-item').addEventListener('click', () => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td><input type="text" name="description" placeholder="Service"></td>
            <td><input type="number" name="quantity" value="1" min="1"></td>
            <td><input type="number" name="unit_price" value="0" min="0"></td>
            <td class="row-total">0</td>
            <td><button class="btn ghost" type="button" data-remove>Remove</button></td>
        `;
        billingTable.querySelector('tbody').appendChild(row);
    });

    document.getElementById('discount').addEventListener('input', updateTotals);
    document.getElementById('paid-amount').addEventListener('input', updateTotals);
    updateTotals();
}
