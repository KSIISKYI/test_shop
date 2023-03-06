let cart_item_addition_form = document.querySelector('.add_cart_block');
let quantity = cart_item_addition_form.querySelector('#quantity');
let profile_id = cart_item_addition_form.querySelector('#profile_id');
let cart_items_count = document.querySelector('#cart_items_count');

quantity.oninput = function(e) {
    this.value = parseInt(this.max) < parseInt(this.value) ? this.max : this.value;
};

cart_item_addition_form.onsubmit = function(e) {
    e.preventDefault();

    addCartItems();
};

async function addCartItems()
{
    let form_data = new FormData(cart_item_addition_form);

    let response = await fetch(cart_item_addition_form.action, {
        method: 'POST',
        body: form_data
    });

    let data = await response.json();
    
    if (data.result) {
        cart_items_count.style.display = 'block';
        cart_items_count.innerHTML = parseInt(cart_items_count.innerHTML) + 1;
    }
}
