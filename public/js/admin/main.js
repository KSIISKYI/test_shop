function addTableRow(table_values, type)
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
