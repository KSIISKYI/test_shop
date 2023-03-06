let product_container = document.querySelector('.product-container');
let current_show_function = showProductItems;
let lazyLoadFunction;
let user;
let is_authorized;

function showProductItems(data)
{
    for(let item of data) {
        let product_img_link = item.product_images.length > 0 ? item.product_images[0].path : 'def_product_img.jpeg';
        let price = is_authorized ? item.price : item.guest_price;
        
        let html_product_item =  htmlToElement(`
            <div class="product-demo">
                <div class="product-demo-img">
                    <img src="/img/product_images/${product_img_link}" alt="">
                </div>
                <a href="/products/${item.id}"><h3>${item.name}</h3></a>
                <h2 class="product-price">${price} ₴</h2>
            </div>
        `);

        product_container.appendChild(html_product_item);
    }
}

async function changeCategory()
{
    product_container.replaceChildren();
    let products_link = location.pathname == '/' ? '/products' : location.pathname;
    lazyLoadFunction = await lazyLoad(products_link);

    lazyLoadFunction();
}

function markSelectedCategory()
{
    for(let category_link of document.querySelectorAll('.category_link')) {
        if (location.href == category_link.href) {
            category_link.style.backgroundColor = '#ccc';
        }
    }
}

async function run()
{ 
    markSelectedCategory();
    user = await getMyUser();
    is_authorized = Boolean(user.username);
    changeCategory();
}

run();

