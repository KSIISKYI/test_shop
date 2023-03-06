let tbody = document.querySelector('tbody');
let current_show_function = showOrdersItems;
let lazyLoadFunction;

async function showOrdersItems(data)
{
    for(let item of data) {

        let order_link = document.createElement('a');
        order_link.innerHTML = item['id'];
        order_link.href = '/admin/orders/' + item['id'];
        
        let edit_btn = htmlToElement(`<button class="btn" style="height:40px" id="${item['id']}">Edit</button>`);
        let delete_btn = htmlToElement(`<button class="btn" style="height:40px" id="${item['id']}">Delete</button>`);

        edit_btn.onclick = function(e) {
            location.replace(`/orders/${item['id']}/edit`);
        }
        delete_btn.onclick = function(e) {
            deleteElement('orders', item['id'], this);
        }
        
        addTableRow([
            order_link,
            item['user'] ? item['user']['username'] : '',
            item['total'],
            item['created_at'],
            edit_btn,
            delete_btn
        ])
    }
}

function toOrderCreationForm()
{
    location.replace('/orders/create');
}

async function run()
{
    lazyLoadFunction = await lazyLoad('/orders');

    lazyLoadFunction();
}

run();
