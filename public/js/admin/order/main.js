let order_form = document.querySelector('#order_form');
let order_form_btn = order_form.querySelector('#order_form-btn');
let tbody = document.querySelector('#order_table').querySelector('tbody');
let selected_product_block = document.querySelector('#selected_product');
let selected_product = selected_product_block.options[0];
let selected_product_price = document.querySelector('#selected_product-price');
let selected_product_quantity = document.querySelector('#selected_product-quantity');
let add_product_btn = document.querySelector('#add_product_btn');
let total_element = document.querySelector('.total');
let total = 0;
let products = [];


selected_product_block.onchange = function(e) {
    let product = selected_product = this.options[this.selectedIndex];
    selected_product_price.value = product.getAttribute('price') + ' ₴';
    selected_product_quantity.value = 1;
    selected_product_quantity.setAttribute('max', product.getAttribute('quantity'));
};

selected_product_quantity.oninput = function(e) {
    let max_quantity = selected_product.getAttribute('quantity');
    this.value = parseInt(max_quantity, 10) < parseInt(this.value, 10) ? max_quantity : this.value;
}

add_product_btn.onclick = function(event) {
    if (selected_product.value && parseInt(selected_product_quantity.value, 10) > 0) {
        event.preventDefault();
    } else {
        return;
    }

    let product_id = selected_product.getAttribute('product-id');
    let product_name = selected_product.innerHTML;
    let product_price = selected_product.getAttribute('price');
    let product_quantity = selected_product_quantity.value;

    addOrderItem(product_id, product_name, product_price, product_quantity);
};

function addOrderItem(product_id, product_name, product_price, product_quantity, is_create=true)
{
    let previous_item_id = Math.max(...products.map(item => item.item_id));
    let item_id = previous_item_id > 0 ? previous_item_id + 1 : 1;

    products.push({item_id: item_id, product_id: product_id, quantity: product_quantity});

    let delete_btn = htmlToElement(`<button class="btn" style="height:40px">Delete</button>`);

    delete_btn.onclick = function(e) {
        deleteOrderItem(item_id, this, product_price, product_quantity);
        setQuantity(selected_product, product_quantity);
        setOrderItemIndexes();
        checkCountOrderItems();
    }

    add_table_row(['', product_name, product_price, product_quantity, delete_btn]);

    total = parseInt(total, 10) + parseInt(product_quantity, 10) * parseInt(product_price, 10);
    total_element.value = total + ' ₴';

    setNotSelectedValue();

    if (is_create) {
        setQuantity(selected_product, -product_quantity);
    }
    
    setOrderItemIndexes();
    checkCountOrderItems();
}

function deleteOrderItem(item_id, html_item, price, quantity)
{
    deleteHTMLElement(html_item.parentElement.parentElement);
    products = products.filter(product => product.item_id !== item_id);
    total -= parseInt(price, 10) * parseInt(quantity, 10);
    total_element.value = total + ' ₴';
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

function ckeckMaxCountOrderItems()
{
    if (products.length === 20) {
        add_product_btn.disabled = true;
        add_product_btn.classList.add('disabled');
    } else {
        add_product_btn.disabled = false;
        add_product_btn.classList.remove('disabled');
    }
}

function checkCountOrderItems()
{
    ckeckMinCountOrderItems();
    ckeckMaxCountOrderItems();
}

function setQuantity(selected_product, quantity)
{
    let current_quantity = parseInt(selected_product.getAttribute('quantity'), 10);
    selected_product.setAttribute('quantity', current_quantity + parseInt(quantity, 10));

    checkQuantity();
}

function checkQuantity()
{
    for(let i = 1; i < selected_product_block.options.length; i++) {
        let option = selected_product_block.options[i];
        option.disabled = !(parseInt(option.getAttribute('quantity'), 10) > 0);
    }
}

function setNotSelectedValue(selected_product)
{
    selected_product = selected_product_block.options[0];
    selected_product.selected = true;
    selected_product_quantity.value = 0;
    selected_product_price.value = '₴';

}

function setOrderItemIndexes()
{
    let index = 1;

    tbody.querySelectorAll('tr').forEach(item => {
        item.querySelector('td').innerHTML = index;
        index++;
    })
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

    location.replace('/admin/orders');
};
