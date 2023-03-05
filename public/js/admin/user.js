let tbody = document.querySelector('tbody');
let current_page_number = 1;
let current_show_function = showUserItems;

async function showUserItems()
{
    let response = await fetch('http://localhost:8000/users?page=' + current_page_number, {
		method: 'GET',
		headers: {
			"Content-Type": "application/json",
		}
	});

    let data = await response.json();

    for(let item of data) {

        let user_link = document.createElement('a');
        user_link.innerHTML = item['username'];
        user_link.href = '/admin/users/' + item['id'];
        
        let delete_btn = htmlToElement(`<button class="btn btn-danger" style="height:40px" id="${item['id']}">Delete</button>`);

        delete_btn.onclick = async function(e) {
            deleteElement('users', item['id'], this);
        };
        
        add_table_row([
            item['id'],
            user_link,
            item['email'],
            item['is_admin'],
            item['is_admin'] ? '' : delete_btn,
        ])
    }

	current_page_number++;
}

function toUserCreationForm()
{
    location.replace('/users/create');
}

async function run()
{
    showUserItems();
}

run();
