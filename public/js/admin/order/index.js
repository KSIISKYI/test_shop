let tbody = document.querySelector('tbody');
let current_page_number = 1;
let current_show_function = showOrdersItems;

async function showOrdersItems()
{
    let response = await fetch('http://localhost:8000/orders?page=' + current_page_number, {
		method: 'GET',
		headers: {
			"Content-Type": "application/json",
		}
	});

    let data = await response.json();

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
        
        add_table_row([
            order_link,
            item['user'] ? item['user']['username'] : '',
            item['total'],
            item['created_at'],
            edit_btn,
            delete_btn
        ])
    }

	current_page_number++;
}

function toOrderCreationForm()
{
    location.replace('/orders/create');
}

async function run()
{
    showOrdersItems();
}

run();
