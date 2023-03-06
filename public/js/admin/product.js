let tbody = document.querySelector('tbody');
let current_show_function = showProductItems;
let lazyLoadFunction;

async function showProductItems(data)
{
    for(let item of data) {
        let product_img_href = item.product_images.length > 0 ? item.product_images[0].path : 'def_product_img.jpeg';
        let product_image = htmlToElement(`
            <div style="width:100px;">
                <img src="/img/product_images/${product_img_href}">
            </div>
        `)
        let product_link = document.createElement('a');
        product_link.innerHTML = item['name'];
        product_link.href = '/products/' + item['id'];

        let edit_btn = htmlToElement(`<button class="btn btn-primary" style="height:40px">Edit</button>`);
        let delete_btn = htmlToElement(`<button class="btn btn-danger" style="height:40px">Delete</button>`);

        delete_btn.onclick = async function(e) {
            deleteElement('products', item['id'], this);
        };

        edit_btn.onclick = function(e) {
            location.replace(`/products/${item['id']}/edit`);
        };
        
        addTableRow([
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
}

function toProductCreationForm()
{
    location.replace('/products/create');
}

async function run()
{
    lazyLoadFunction = await lazyLoad('/products');

    lazyLoadFunction();
}

run();
