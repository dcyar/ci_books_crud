<?php $this->load->view('layouts/header'); ?>

<div class="container" x-data="app()">
	<div class="d-flex justify-content-between align-items-center">
		<h1>Lista de libros</h1>
		<button class="btn btn-primary btn-sm" @click="openModal(modal.book, 'create')">Nuevo Libro</button>
	</div>
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
		<tbody>
			<template x-for="book in books" :key="book.idLibro">
				<tr>
					<th scope="row" x-text="book.idLibro">${book.idLibro}</th>
					<td x-text="book.ISBN"></td>
					<td x-text="book.Titulo"></td>
					<td class="text-center" x-text="book.NumeroEjemplares"></td>
					<td class="text-center" x-text="book.NombreAutor"></td>
					<td class="text-center" x-text="book.NombreEditorial"></td>
					<td class="text-center" x-text="book.NombreTema"></td>
					<td class="text-center">
						<button class="btn btn-warning btn-sm" @click="openModal(book, 'edit')">E</button>
						<button class="btn btn-danger btn-sm" @click="deleteBook(book)">D</button>
					</td>
				</tr>
			</template>
		</tbody>
	</table>
	<div class="d-flex justify-content-end">
		<div class="form-group mr-3">
			<select x-model="paginate.perPage" name="perPage" class="form-control">
				<option value="5">5</option>
				<option value="10" selected>10</option>
				<option value="25">25</option>
				<option value="50">50</option>
			</select>
		</div>
		<nav>
			<ul id="pagination" class="pagination">
				<li class="page-item" :class="paginate.page === 1 && 'disabled'">
					<button class="page-link" @click="paginate.page -= 1">Previous</button>
				</li>
				<template x-for="page in paginate.pages">
					<li class="page-item" :class="page === paginate.page && 'active' " aria-current="page">
						<button @click="paginate.page = page" class="page-link" x-text="page"></button>
					</li>
				</template>
				<li class="page-item" :class="paginate.page === paginate.pages && 'disabled'">
					<button class="page-link" @click="paginate.page += 1">Next</button>
				</li>
			</ul>
		</nav>
	</div>
	<div class="modal fade" id="form-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" x-text="modal.title"></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form class="form">
						<div class="form-group">
							<label for="ISBN">ISBN</label>
							<input type="text" class="form-control" :class="hasError('ISBN') && 'is-invalid'" x-model="modal.book.ISBN" name="ISBN" id="ISBN" placeholder="ISBN" />
							<div class="invalid-feedback" x-text="hasError('ISBN')"></div>
						</div>
						<div class="form-group">
							<label for="Titulo">Título</label>
							<input type="text" class="form-control" :class="hasError('Titulo') && 'is-invalid'" x-model="modal.book.Titulo" name="Titulo" id="Titulo" placeholder="Título" />
							<div class="invalid-feedback" x-text="hasError('Titulo')"></div>
						</div>
						<div class="form-group">
							<label for="NumeroEjemplares">Número de ejemplares</label>
							<input type="number" class="form-control" :class="hasError('NumeroEjemplares') && 'is-invalid'" x-model="modal.book.NumeroEjemplares" name="NumeroEjemplares" id="NumeroEjemplares" min="1" placeholder="Número de ejemplares" />
							<div class="invalid-feedback" x-text="hasError('NumeroEjemplares')"></div>
						</div>
						<div class="form-group">
							<label for="idAutor">Autor</label>
							<select class="form-control" :class="hasError('idAutor') && 'is-invalid'" x-model="modal.book.idAutor" name="idAutor" id="idAutor">
								<template x-for="author in authors" :key="author.idAutor">
									<option :value="author.idAutor" :selected="modal.book.idAutor === author.idAutor" x-text="author.NombreAutor"></option>
								</template>
							</select>
							<div class="invalid-feedback" x-text="hasError('idAutor')"></div>
						</div>
						<div class="form-group">
							<label for="idEditorial">Editorial</label>
							<select class="form-control" :class="hasError('idEditorial') && 'is-invalid'" x-model="modal.book.idEditorial" name="idEditorial" id="idEditorial">
								<template x-for="publisher in publishers" :key="publisher.idEditorial">
									<option :value="publisher.idEditorial" :selected="modal.book.idEditorial === publisher.idEditorial" x-text="publisher.NombreEditorial"></option>
								</template>
							</select>
							<div class="invalid-feedback" x-text="hasError('idEditorial')"></div>
						</div>
						<div class="form-group">
							<label for="idTema">Tema</label>
							<select class="form-control" :class="hasError('idTema') && 'is-invalid'" x-model="modal.book.idTema" name="idTema" id="idTema">
								<template x-for="topic in topics" :key="topic.idTema">
									<option :value="topic.idTema" :selected="modal.book.idTema === topic.idTema" x-text="topic.NombreTema"></option>
								</template>
							</select>
							<div class="invalid-feedback" x-text="hasError('idTema')"></div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
					<button type="button" class="btn btn-primary" @click="processForm" x-text="modal.buttonText"></button>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="//unpkg.com/alpinejs" defer></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
	function app() {
		return {
			books: [],
			authors: <?= json_encode($authors) ?>,
			publishers: <?= json_encode($publishers) ?>,
			topics: <?= json_encode($topics) ?>,
			paginate: {
				page: 1,
				perPage: 10,
				pages: 1,
				items: 0
			},
			modal: {
				formType: 'create',
				title: '',
				buttonText: '',
				errors: [],
				book: {
					idLibro: null,
					ISBN: '',
					Titulo: '',
					NumeroEjemplares: 1,
					idAutor: null,
					idEditorial: null,
					idTema: null
				},
			},
			init() {
				this.getBooks();
				this.$watch('paginate.perPage', (value) => {
					this.paginate.perPage = value;
					this.getBooks();
				});
				this.$watch('paginate.page', (page) => this.getBooks(page));
			},
			async getBooks(page = 1) {
				this.paginate.page = page
				const response = await fetch(`/api/books?page=${this.paginate.page}&perPage=${this.paginate.perPage}`);
				const data = await response.json();
				this.books = data.data;
				this.paginate.pages = data.totalPages;
				this.paginate.items = data.totalItems;
			},
			openModal(book, action) {
				this.modal.book = {
					...book
				};
				this.modal.formType = action;
				this.modal.title = action === 'edit' ? 'Editar Libro' : 'Nuevo Libro';
				this.modal.buttonText = action === 'edit' ? 'Actualizar' : 'Guardar';
				$('#form-modal').modal('show');
			},
			async processForm() {
				const url = (this.modal.formType === 'create') ?
					'/api/books/create' :
					`/api/books/${this.modal.book.idLibro}/update`;

				const formData = new FormData();

				formData.append('ISBN', this.modal.book.ISBN)
				formData.append('Titulo', this.modal.book.Titulo)
				formData.append('NumeroEjemplares', this.modal.book.NumeroEjemplares)
				formData.append('idAutor', this.modal.book.idAutor)
				formData.append('idEditorial', this.modal.book.idEditorial)
				formData.append('idTema', this.modal.book.idTema)

				axios.post(url, formData)
					.then(response => {
						this.getBooks();
						$('#form-modal').modal('hide');
					}).catch(err => {
						this.modal.errors = err.response.data.message.split('\n');
					})
			},
			deleteBook(book) {
				Swal.fire({
					title: 'Estas segur@?',
					text: "Este cambio no se puede revertir!",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Si, eliminar registro!',
					cancelButtonText: 'Cancelar'
				}).then((result) => {
					if (result.isConfirmed) {
						axios.delete(`/api/books/${book.idLibro}/delete`)
							.then(response => {
								Swal.fire(
									'Eliminado!',
									'El registro fue eliminado.',
									'success'
								)

								this.getBooks();
							}).catch(err => {
								Swal.fire(
									'Error!',
									'No se pudo eliminar el registro',
									'error'
								)
							})
					}
				})
			},
			hasError(field) {
				return this.modal.errors.find(error => error.includes(field))
			}
		}
	}
</script>

<?php $this->load->view('layouts/footer') ?>