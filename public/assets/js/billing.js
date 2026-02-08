const items = [];

const itemSelect = document.getElementById('item-select');
const addItemBtn = document.getElementById('add-item');
const itemsTableBody = document.querySelector('#items-table tbody');
const itemsInput = document.getElementById('items-input');
const totalAmountInput = document.getElementById('total-amount');
const discountInput = document.getElementById('discount');
const paidAmountInput = document.getElementById('paid-amount');
const dueAmountInput = document.getElementById('due-amount');

function calculateTotals() {
    const total = items.reduce((sum, item) => sum + item.total, 0);
    const discount = parseFloat(discountInput.value || '0');
    const paid = parseFloat(paidAmountInput.value || '0');
    const net = Math.max(total - discount, 0);
    const due = Math.max(net - paid, 0);

    totalAmountInput.value = net.toFixed(2);
    dueAmountInput.value = due.toFixed(2);
    itemsInput.value = JSON.stringify(items);
}

function renderItems() {
    itemsTableBody.innerHTML = '';
    items.forEach((item, index) => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${item.item_type}</td>
            <td>${item.item_name}</td>
            <td>${item.quantity}</td>
            <td>${item.price.toFixed(2)}</td>
            <td>${item.total.toFixed(2)}</td>
            <td><button type="button" data-index="${index}" class="btn-link remove-item">Remove</button></td>
        `;
        itemsTableBody.appendChild(row);
    });
    document.querySelectorAll('.remove-item').forEach((btn) => {
        btn.addEventListener('click', (event) => {
            const index = parseInt(event.target.getAttribute('data-index'), 10);
            items.splice(index, 1);
            renderItems();
            calculateTotals();
        });
    });
}

addItemBtn.addEventListener('click', () => {
    const selected = itemSelect.options[itemSelect.selectedIndex];
    const qty = parseInt(document.getElementById('item-qty').value, 10) || 1;
    const price = parseFloat(selected.getAttribute('data-price')) || 0;
    const itemType = selected.getAttribute('data-type') || 'OPD';

    items.push({
        item_type: itemType,
        item_name: selected.value,
        quantity: qty,
        price: price,
        total: price * qty,
    });

    renderItems();
    calculateTotals();
});

[discountInput, paidAmountInput].forEach((input) => {
    input.addEventListener('input', calculateTotals);
});

calculateTotals();
