async function getOrderData()
{
    let response = await fetch(location.href, {
        headers: {
            'Content-Type': 'application/json'
        }
    })

    return await response.json();
}

async function addOrderItems()
{
    let data = await getOrderData();

    for(let order_item of data.order.order_items) {
        addOrderItem(order_item.product_id, order_item.product.name, order_item.product.price, order_item.quantity, false);
    }

    total = data.order.total;
    total_element.value = total + ' ₴';
    
}

async function run()
{
    checkQuantity();
    await addOrderItems();
}

run();