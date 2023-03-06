let order_form = document.querySelector('#order_form');
let order_form_btn = order_form.querySelector('#order_form-btn');
let tbody = document.querySelector('#order_table').querySelector('tbody');
let total_element = document.querySelector('.total');
let cart_items_count = document.querySelector('#cart_items_count');
let total = 0;
let products = [];
let user;
let is_authorized;

async function getCartItems()
{
    let response = await fetch('/carts/my/items', {
        headers: {
            'Content-Type': 'application/json'
        }
    })

    return await response.json();
}

function deleteCartItem(cart_item_id)
{
    fetch('/carts/my/items/' + cart_item_id, {
        method: 'DELETE'
    })
}

async function addCartItems()
{
    let data = await getCartItems();

    for(let cart_item of data) {
        let price = is_authorized ? cart_item.product.price : cart_item.product.guest_price;

        addOrderItem(cart_item.id, cart_item.product_id, cart_item.product.name, price, cart_item.quantity);
    } 
}

function addOrderItem(cart_item_id, product_id, product_name, product_price, product_quantity)
{
    let previous_item_id = Math.max(...products.map(item => item.item_id));
    let item_id = previous_item_id > 0 ? previous_item_id + 1 : 1;

    products.push({item_id: item_id, product_id: product_id, quantity: product_quantity});

    let delete_btn = htmlToElement(`<button class="btn" style="height:40px">Delete</button>`);

    delete_btn.onclick = function(e) {
        deleteCartItem(cart_item_id);
        deleteOrderItem(item_id, this, product_price, product_quantity);
        setOrderItemIndexes();
        ckeckMinCountOrderItems();

        cart_items_count.style.display = 'block';
        cart_items_count.innerHTML = parseInt(cart_items_count.innerHTML) - 1;
    }

    addTableRow(['', product_name, product_price, product_quantity, delete_btn]);

    total = parseInt(total, 10) + parseInt(product_quantity, 10) * parseInt(product_price, 10);
    total_element.value = total + ' ₴';
    
    setOrderItemIndexes();
    ckeckMinCountOrderItems();
}

function setOrderItemIndexes()
{
    let index = 1;

    tbody.querySelectorAll('tr').forEach(item => {
        item.querySelector('td').innerHTML = index;
        index++;
    })
}

function ckeckMinCountOrderItems()
{
    if (products.length < 1) {
        order_form_btn.disabled = true;
        order_form_btn.classList.add('disabled');
    } else {
        order_form_btn.disabled = false;
        order_form_btn.classList.remove('disabled');
    }
}

function deleteOrderItem(item_id, html_item, price, quantity)
{
    deleteHTMLElement(html_item.parentElement.parentElement);
    products = products.filter(product => product.item_id !== item_id);
    total -= parseInt(price, 10) * parseInt(quantity, 10);
    total_element.value = total + ' ₴';
}

order_form.onsubmit = function(event) {
    event.preventDefault();
    
    let form = new FormData(event.target);
    form.append('total', total);

    for(let product of products) {
        form.append('products[]', JSON.stringify(product));
    }

    fetch(this.action, {
        method: 'POST',
        body: form
    });

    location.replace('/');
};

async function run()
{
    user = await getMyUser();
    is_authorized = Boolean(user.username);
    await addCartItems();
    ckeckMinCountOrderItems();
}

run();
