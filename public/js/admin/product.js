let tbody = document.querySelector('tbody');
let current_page_number = 1;
let current_show_function = showProductItems;

async function showProductItems()
{
    let response = await fetch('http://localhost:8000/products?page=' + current_page_number, {
		method: 'GET',
		headers: {
			"Content-Type": "application/json",
		}
	});

    let data = await response.json();

    for(let item of data) {
        let product_img_href = item.product_images.length > 0 ? item.product_images[0].path : 'def_product_img.jpeg';
        let product_image = htmlToElement(`
            <div style="width:100px;">
                <img src="/img/product_images/${product_img_href}">
            </div>
        `)
        let product_link = document.createElement('a');
        product_link.innerHTML = item['name'];
        product_link.href = '/admin/products/' + item['id'];

        let edit_btn = htmlToElement(`<button class="btn btn-primary" style="height:40px">Edit</button>`);
        let delete_btn = htmlToElement(`<button class="btn btn-danger" style="height:40px">Delete</button>`);

        delete_btn.onclick = async function(e) {
            deleteElement('products', item['id'], this);
        };

        edit_btn.onclick = function(e) {
            location.replace(`/products/${item['id']}/edit`);
        };
        
        add_table_row([
            item['id'],
            product_image,
            product_link,
            item['category']['name'],
            item['price'],
            item['quantity_in_stock'],
            edit_btn,
            delete_btn
        ])
    }

	current_page_number++;
}

function toProductCreationForm()
{
    location.replace('/products/create');
}

async function run()
{
    showProductItems();
}

run();
