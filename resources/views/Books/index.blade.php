@extends('layouts.app')
@section('content')
    <div class="container">
        <h3 class="text-center">Livros</h3>
        <div class="mt-5">
            <div class="d-flex justify-content-end ml-3 mb-3">
                <button type="button" class="btn btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#storeBookModal">
                    <i class="fa fa-plus"></i> Livro
                </button>
            </div>
            <table class="table table-striped">
                <thead>
                <tr class="bg-light">
                    <th>Título</th>
                    <th>Editora</th>
                    <th>Assunto</th>
                    <th>Autor(es)</th>
                    <th>Edição</th>
                    <th>Ano Publicação</th>
                    <th>Valor</th>
                    <th class="text-center">Ações</th>
                </tr>
                </thead>
                <tbody>
                @foreach($results as $book)
                    <tr class="align-middle">
                        <td>{{ $book['titulo'] }}</td>
                        <td>{{ $book['editora'] }}</td>
                        <td>{{ $book['assunto']->descricao }}</td>
                        <td>
                            @foreach($book['autores']  as $author)
                                <p> {{ $author['nome'] }} </p>
                            @endforeach
                        </td>
                        <td>{{ $book['edicao'] }}</td>
                        <td>{{ $book['anoPublicacao'] }}</td>
                        <td>R$ {{ number_format($book['valor'], 2, ',', '.') }}</td>
                        <td>
                            <div class="text-center">
                                <button type="button" class="btn edit-button" data-id="{{ $book['codL'] }}" data-book="{{ json_encode($book) }}"><i class="fa fa-pencil"></i> Editar</button>
                                <button type="button" class="btn text-danger delete-button" data-id="{{ $book['codL'] }}"><i class="fa fa-trash"></i> Excluir</button>
                            </div>
                        </td>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="storeBookModal" tabindex="-1" aria-labelledby="storeBookModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="storeBookModalLabel">Salvar Livro</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formSubject">
                        @csrf
                        <div class="mb-3">
                            <label for="descricao" class="form-label">Título</label>
                            <input type="hidden" class="form-control" id="codL" name="codL">
                            <input type="text" class="form-control" id="titulo" name="titulo" required>
                        </div>
                        <div class="mb-3">
                            <label for="assunto" class="form-label">Assunto</label>
                            <select class="form-control" id="assunto" name="assunto" required>
                                <option value="">-- Selecione --</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->codAs }}">{{ $subject->descricao }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="autores" class="form-label">Autor(es)</label>
                            <select class="form-control" id="autores" name="autores[]" multiple required>
                                <option disabled>-- Selecione 1 ou mais autores --</option>
                                @foreach($authors as $author)
                                    <option value="{{ $author->codAu }}">{{ $author->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="descricao" class="form-label">Editora</label>
                            <input type="text" class="form-control" id="editora" name="editora" required>
                        </div>
                        <div class="mb-3">
                            <label for="descricao" class="form-label">Edição</label>
                            <input type="number" class="form-control" id="edicao" name="edicao" required>
                        </div>
                        <div class="mb-3">
                            <label for="descricao" class="form-label">Ano de publicação</label>
                            <input type="text" class="form-control" id="anoPublicacao" name="anoPublicacao" required>
                        </div>
                        <div class="mb-3">
                            <label for="descricao" class="form-label">Valor</label>
                            <input type="text" class="form-control" id="valor" name="valor" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Salvar Livro</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        const cleaveInstance = new Cleave('#valor', {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand',
            numeralDecimalMark: ',',
            delimiter: '.',
            prefix: 'R$ ',
            numeralPositiveOnly: true,
            numeralDecimalScale: 2,
            numeralFixedDecimalScale: true
        });

        document.getElementById('formSubject').addEventListener('submit', function(e) {
            e.preventDefault();

            const codL = document.getElementById('codL').value;
            const title = document.getElementById('titulo').value;
            const subject = document.getElementById('assunto').value;
            const editor = document.getElementById('editora').value;
            const edition = document.getElementById('edicao').value;
            const yearPublish = document.getElementById('anoPublicacao').value;
            const amount = document.getElementById('valor').value.replace(/[R$\s.]/g, '').replace(',', '.');
            const selectedAuthors = Array.from(document.getElementById('autores').selectedOptions)
                .map(option => option.value);

            const payload = {
                titulo: title,
                codAssunto: subject,
                codAutores: selectedAuthors,
                editora: editor,
                edicao: edition,
                anoPublicacao: yearPublish,
                valor: amount,
            }

            const uri = codL ? `/api/book/${codL}` : '/api/book';
            const method = codL ? 'PATCH' : 'POST';

            fetch(uri, {
                method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(payload)
            })
                .then(function (response) {
                    return response.json().then(body => {
                        if (response.ok) {
                            alert('Livro salvo com sucesso!');
                            location.reload();
                        } else {
                            alert(`Erro ao salvar o livro: ${JSON.stringify(body.errors)}`)
                        }
                    });
                })
                .catch(function (error) {
                    alert(`Erro inesperado ao salvar livro: ${JSON.stringify(error)}`);
                });
        });

        document.querySelectorAll('.edit-button').forEach(button => {
            button.addEventListener('click', function() {
                const codL = this.getAttribute('data-id');
                const dataBook = JSON.parse(this.getAttribute('data-book'));

                document.getElementById('codL').value = codL;
                document.getElementById('titulo').value = dataBook.titulo;
                document.getElementById('assunto').value = dataBook.assunto.codAs;
                document.getElementById('editora').value = dataBook.editora;
                document.getElementById('edicao').value = dataBook.edicao;
                document.getElementById('anoPublicacao').value = dataBook.anoPublicacao;

                cleaveInstance.setRawValue(dataBook.valor);

                const authorsSelect = document.getElementById('autores');
                const authorsSelected = dataBook.autores.map(author => author.codAu);

                Array.from(authorsSelect.options).forEach(option => {
                    if (authorsSelected.includes(Number(option.value))) {
                        option.selected = true;
                    }
                });

                const modalStore = new bootstrap.Modal(document.getElementById('storeBookModal'));

                modalStore.show();
            });
        });

        document.querySelectorAll('.delete-button').forEach(button => {
            button.addEventListener('click', function() {
                const codL = this.getAttribute('data-id');

                const confirmDelete = confirm("Você tem certeza que deseja excluir este livro?");

                if (confirmDelete) {
                    fetch(`/api/book/${codL}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                        .then(response => {
                            if (response.ok) {
                                alert('Livro excluído com sucesso!');
                                location.reload();
                            } else {
                                return response.json().then(body => {
                                    alert(`Erro ao excluir o livro: ${JSON.stringify(body)}`);
                                });
                            }
                        });
                }
            });
        });
    </script>

@endsection
