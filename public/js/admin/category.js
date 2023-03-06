let tbody = document.querySelector('tbody');
let current_show_function = showUserItems;
let lazyLoadFunction;

async function showUserItems(data)
{
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
        
        addTableRow([
            item['id'],
            category_link,
            edit_btn,
            delete_btn
        ])
    }
}

function toCategoryCreationForm()
{
    location.replace('/categories/create');
}

async function run()
{
    lazyLoadFunction = await lazyLoad('/categories');

    lazyLoadFunction();
}

run();
