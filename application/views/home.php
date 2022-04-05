<?php require_once(APPPATH . 'views/layouts/header.php'); ?>

<div class="container">
	<h1>Lista de libros</h1>
	<table class="table table-striped">
		<thead>
			<tr>
				<th scope="col">#</th>
				<th scope="col">ISBN</th>
				<th scope="col">Título</th>
				<th class="text-center" scope="col"># de ejemplares</th>
				<th class="text-center" scope="col">Autor</th>
				<th class="text-center" scope="col">Editorial</th>
				<th class="text-center" scope="col">Tema</th>
				<th class="text-center" scope="col">Acciones</th>
			</tr>
		</thead>
		<tbody id="table-body">
		</tbody>
	</table>
	<div class="d-flex justify-content-end">
		<nav>
			<ul id="pagination" class="pagination">
				<li class="page-item disabled">
					<a class="page-link">Previous</a>
				</li>
				<li class="page-item"><a class="page-link" href="#">1</a></li>
				<li class="page-item active" aria-current="page">
					<a class="page-link" href="#">2</a>
				</li>
				<li class="page-item"><a class="page-link" href="#">3</a></li>
				<li class="page-item">
					<a class="page-link" href="#">Next</a>
				</li>
			</ul>
		</nav>
	</div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script>
	let page = 1,
		perPage = 10;

	$(document).ready(function() {
		getBooks();
	});

	function getBooks() {
		$.get(`http://localhost/api/books/?page=${page}&perPage=${perPage}`, function(data, status) {
			printBooks(data.data);
			printPagination(data)
		});
	}

	function printBooks(books) {
		let booksHtml = ''
		$('#table-body').children().remove();

		books.forEach(book => {
			booksHtml += `<tr>
				<th scope="row">${book.idLibro}</th>
				<td>${book.ISBN}</td>
				<td>${book.Titulo}</td>
				<td class="text-center">${book.NumeroEjemplares}</td>
				<td class="text-center">${book.NombreAutor}</td>
				<td class="text-center">${book.NombreEditorial}</td>
				<td class="text-center">${book.NombreTema}</td>
				<td class="text-center"><button>E</button></td>
			</tr>`
		});

		$('#table-body').html(booksHtml);
	}

	function printPagination(data) {
		let paginationHtml = '';
		$('#pagination').children().remove();

		paginationHtml += printPreviousPageButton(data)
		paginationHtml += printPaginateButtons(data)
		paginationHtml += printNextPageButton(data)

		$('#pagination').html(paginationHtml);

		$('.page-item').on('click', function(e) {
			e.preventDefault();

			if (page !== $(this).data('page')) {
				page = $(this).data('page');
				getBooks();
			}
		});
	}

	function printPreviousPageButton(data) {
		return `<li class="page-item ${(data.currentPage === 1 ? 'disabled' : '')}" data-page="${(data.currentPage === 1 ? 1 : data.currentPage - 1)}"><a class="page-link" href="#">Anterior</a></li>`;
	}

	function printNextPageButton(data) {
		return `<li class="page-item ${(data.currentPage === data.totalPages ? 'disabled' : '')}" data-page="${(data.currentPage === data.totalPages ? data.totalPages : data.currentPage + 1)}"><a class="page-link" href="#">Siguiente</a></li>`;
	}

	function printPaginateButtons(data) {
		let paginateButtons = '';

		for (let currentPage = 1; currentPage <= data.totalPages; currentPage++) {
			paginateButtons += `<li class="page-item ${(data.currentPage === currentPage ? 'active' : '')}" data-page="${currentPage}">
				<button class="page-link">
					${currentPage}
				</button>
			</li>`;
		}

		return paginateButtons;
	}
</script>

<?php require_once(APPPATH . 'views/layouts/footer.php'); ?>