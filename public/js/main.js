const articles = document.querySelector('#articles');

if (articles) {
	articles.addEventListener('click', (event) => {
		if (event.target.className === 'btn btn-danger delete-article') {
			if (confirm('Are you sure?')) {
				const id = event.target.getAttribute('data-id');
				deleteArticle(id);
			}
		}
	});
}

const deleteArticle = async (id) => {
	await fetch('/article/delete/' + id, {
		method: 'DELETE'
	});
	
	window.location.reload();
}