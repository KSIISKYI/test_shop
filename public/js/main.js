function htmlToElement(html) 
{
    let template = document.createElement('template');
    html = html.trim(); // Never return a text node of whitespace as the result
    template.innerHTML = html;
    return template.content.firstChild;
}

function deleteHTMLElement(elem)
{
    elem.remove();
}

function checkAndUpdate()
{
    let len = document.querySelectorAll('tr').length;

    if (len < 11) {
        current_show_function();
    }
}

async function getMyUser()
{
    let response = await fetch('/users/my', {
		method: 'GET',
		headers: {
			"Content-Type": "application/json",
		}
	});

    return await response.json();
}

async function deleteElement(type, id, html_element)
{
    let response = await fetch(`/${type}/${id}`, {
        method: 'DELETE'
    })

    if (response.status == 200) {
        deleteHTMLElement(html_element.parentElement.parentElement);
        checkAndUpdate();
    }
}
