function addToCart(book, author, publisher, price) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    cart.push({ book, author, publisher, price });
    localStorage.setItem('cart', JSON.stringify(cart));
    alert(`${book} has been added to your cart.`);
}

function loadCart() {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    const cartTable = document.getElementById('cart-table');
    const emptyMessage = document.getElementById('empty-message');

    if (cart.length > 0) {
        emptyMessage.style.display = 'none';
        cart.forEach((item, index) => {
            const row = cartTable.insertRow();
            row.insertCell(0).innerText = item.book;
            row.insertCell(1).innerText = item.author;
            row.insertCell(2).innerText = item.publisher;
            row.insertCell(3).innerText = item.price;
            const actionCell = row.insertCell(4);
            const removeButton = document.createElement('button');
            removeButton.innerText = 'Remove';
            removeButton.onclick = function() {
                removeFromCart(index);
            };
            actionCell.appendChild(removeButton);
        });
    } else {
        emptyMessage.style.display = 'block';
    }
}

function removeFromCart(index) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    cart.splice(index, 1);
    localStorage.setItem('cart', JSON.stringify(cart));
    location.reload(); // Refresh the page to update the cart
}

document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('cart-table')) {
        loadCart();
    }
});
