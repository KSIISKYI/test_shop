let tbody = document.querySelector('tbody');
let current_show_function = showUserItems;
let lazyLoadFunction;

async function showUserItems(data)
{
    for(let item of data) {

        let user_link = document.createElement('a');
        user_link.innerHTML = item['username'];
        user_link.href = '/admin/users/' + item['id'];
        
        let delete_btn = htmlToElement(`<button class="btn btn-danger" style="height:40px" id="${item['id']}">Delete</button>`);

        delete_btn.onclick = async function(e) {
            deleteElement('users', item['id'], this);
        };
        
        addTableRow([
            item['id'],
            user_link,
            item['email'],
            item['is_admin'],
            item['is_admin'] ? '' : delete_btn,
        ])
    }
}

function toUserCreationForm()
{
    location.replace('/users/create');
}

async function run()
{
    lazyLoadFunction = await lazyLoad('/users');

    lazyLoadFunction();
}

run();
