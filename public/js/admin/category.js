let tbody = document.querySelector('tbody');
let current_page_number = 1;
let current_show_function = showUserItems;

async function showUserItems()
{
    let response = await fetch('/categories?page=' + current_page_number, {
		method: 'GET',
		headers: {
			"Content-Type": "application/json",
		}
	});

    let data = await response.json();

    for(let item of data) {

        let category_link = document.createElement('a');
        category_link.innerHTML = item['name'];
        category_link.href = '/admin/categories/' + item['id'];
        
        let edit_btn = htmlToElement(`<button class="btn" style="height:40px">Edit</button>`);
        let delete_btn = htmlToElement(`<button class="btn" style="height:40px">Delete</button>`);

        edit_btn.onclick = function(e) {
            location.replace(`/categories/${item['id']}/edit`);
        };

        delete_btn.onclick = async function(e) {
            deleteElement('categories', item['id'], this);
        };
        
        add_table_row([
            item['id'],
            category_link,
            edit_btn,
            delete_btn
        ])
    }

	current_page_number++;
}

function toCategoryCreationForm()
{
    location.replace('/categories/create');
}

async function run()
{
    showUserItems();
}

run();
