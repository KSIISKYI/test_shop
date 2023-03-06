let current_page_number = 1;

async function getData(url)
{
    let response = await fetch(location.origin + url + '?page=' + current_page_number, {
		method: 'GET',
		headers: {
			"Content-Type": "application/json",
		}
	});
    current_page_number++;

    return await response.json();
}

async function lazyLoad(url)
{   
    async function inner()
    {
        let data = await getData(url);

        current_show_function(data);
    }
    
    return inner;
}

document.onscroll = async function(e) {
    let height = window.pageYOffset + window.innerHeight;
    if (document.body.scrollHeight == Math.ceil(height) || document.body.scrollHeight == Math.floor(height)) {
        
        await lazyLoadFunction();
    }
}
