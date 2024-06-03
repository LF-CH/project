
let cart = {};


function addToCart(foodId, foodName, price) {
    if (cart[foodId]) {
        cart[foodId].quantity += 1;
    } else {
        cart[foodId] = { name: foodName, quantity: 1, price: price };
    }
    updateCartDisplay();
}


function updateCartDisplay() {
    let cartArea = document.getElementById('cart');
    cartArea.innerHTML = '';

    let total = 0;
    for (let id in cart) {
        let item = cart[id];
        total += item.quantity * item.price;

        let itemElement = document.createElement('div');
        itemElement.innerText = `${item.name}, Quantity: ${item.quantity} `;

        let minusButton = document.createElement('button');
        minusButton.innerText = '-';
        minusButton.className = 'cart-minus-btn'; 
        minusButton.onclick = function() { updateQuantity(id, -1); };

        let plusButton = document.createElement('button');
        plusButton.innerText = '+';
        plusButton.className = 'cart-plus-btn'; 
        plusButton.onclick = function() { updateQuantity(id, 1); }; 


        itemElement.appendChild(minusButton);
        itemElement.appendChild(plusButton);

        cartArea.appendChild(itemElement);
    }

    let totalElement = document.createElement('div');
    totalElement.innerText = `Total: $${total.toFixed(2)}`;
    cartArea.appendChild(totalElement);

   
    let clearCartButton = document.createElement('button');
    clearCartButton.innerText = 'Clear Cart';
    clearCartButton.id = 'clear-cart-btn'; 
    clearCartButton.onclick = clearCart;
    cartArea.appendChild(clearCartButton);

   
    let checkoutButton = document.createElement('button');
    checkoutButton.innerText = 'Checkout';
    checkoutButton.id = 'checkout-btn'; 
    checkoutButton.onclick = function() {
        prepareBookingData();
        document.getElementById('cart_form').submit();
    };
    cartArea.appendChild(checkoutButton);

  
    prepareBookingData();
}

function updateQuantity(id, change) {
    if (cart[id]) {
        cart[id].quantity += change;
        if (cart[id].quantity <= 0) {
            delete cart[id];
        }
        updateCartDisplay();
    }
}


function clearCart() {
    cart = {};
    updateCartDisplay();
}


window.onload = function() {
    updateCartDisplay(); 
};


function prepareBookingData() {
    let cartData = JSON.stringify(cart);
    document.getElementById('cart_data_input').value = cartData;

    let totalAmount = 0;
    for (let id in cart) {
        totalAmount += cart[id].quantity * cart[id].price;
    }
    document.getElementById('total_amount_input').value = totalAmount.toFixed(2);
}
