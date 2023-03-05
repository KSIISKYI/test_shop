function add_table_row(table_values, type)
{
    let tr = document.createElement('tr');

	for(let table_value of table_values) {
		let td = document.createElement('td');

        if (table_value instanceof HTMLElement) {
            td.appendChild(table_value);
        } else {
            td.innerHTML = table_value;
        }

        tr.appendChild(td);
		
	}

    tbody.appendChild(tr);
}

document.onscroll = function(e) {
    let height = window.pageYOffset + window.innerHeight;
    if (document.body.scrollHeight == Math.ceil(height) || document.body.scrollHeight == Math.floor(height)) {
        current_show_function();
    }
}

function markSelectedMenu()
{
    let menu_links = document.querySelectorAll('.nav-inner-link');
    
    menu_links.forEach(link => {
        if (location.href.includes(link.href)) {
            link.style.backgroundColor = '#ccc';
        }
    });
}

markSelectedMenu();

// let content_block = document.querySelector('#main-content');
// let current_page_number = 1;
// let current_show_function;
// let tbody;


// function init_table_items(table_items)
// {
// 	let html_table_items = '';

// 	for(let key in table_items) {
//         if (key == table_items.length - 1) {
//             html_table_items += `<th class="text-center" colspan="2">${table_items[key]}</th>`;
//         } else {
//             html_table_items += `<th class="text-center">${table_items[key]}</th>`;
//         }
// 	}

// 	return html_table_items;
// }


// function init_table(table_name, table_items)
// {
// 	let html_table_items = init_table_items(table_items);

// 	let el = htmlToElement(`
// 		<div>
// 			<h2 style="margin-bottom: 10px;">${table_name}</h2>
// 			<table class="table">
// 				<thead>
// 					<tr>${html_table_items}</tr>
// 				</thead>
// 			    <tbody></tbody>
// 			</table>
// 		</div>
// 	`)

// 	content_block.appendChild(el);
//     tbody = content_block.querySelector('tbody');
// }

// function add_table_row(table_values)
// {
//     let tr = document.createElement('tr');

// 	for(let table_value of table_values) {
// 		let td = document.createElement('td');

//         if (table_value instanceof HTMLElement) {
//             td.appendChild(table_value);
//         } else {
//             td.innerHTML = table_value;
//         }

//         tr.appendChild(td);
		
// 	}

//     tbody.appendChild(tr);
// }

// async function initProductTable()
// {
    
// }

// async function showProductItems()
// {
//     current_show_function = showProductItems;

// 	let response = await fetch('http://localhost:8000/products?page=' + current_page_number, {
// 		method: 'GET',
// 		headers: {
// 			"Content-Type": "application/json",
// 		}
// 	});

//     let data = await response.json();

//     if (!tbody) {
//         init_table('Products', ['C.N.', 'Product Image', 'Product Name', 'Category Name', 'Price', 'Quantity In Stock', 'Actions']);
//     }

//     for(let item of data) {
//         let product_img_href = item.product_images.length > 0 ? item.product_images[0] : '/img/def_product_img.jpeg';
//         let product_image = htmlToElement(`
//             <div style="width:100px;">
//                 <img src="${product_img_href}">
//             </div>
//         `)

//         let edit_btn = htmlToElement(`<button class="btn btn-primary" style="height:40px">Edit</button>`);
//         let delete_btn = htmlToElement(`<button class="btn btn-danger" style="height:40px">Delete</button>`);
        
//         add_table_row([
//             item['id'],
//             product_image,
//             item['name'],
//             item['category']['name'],
//             item['price'],
//             item['quantity_in_stock'],
//             edit_btn,
//             delete_btn
//         ])
//     }

// 	current_page_number++;
// }













