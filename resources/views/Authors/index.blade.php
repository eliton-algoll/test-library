@extends('layouts.app')
@section('content')
    <div class="container">
        <h3 class="text-center">Autores</h3>
        <div class="mt-5">
            <div class="d-flex justify-content-end ml-3 mb-3">
                <button type="button" class="btn btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#storeAuthorModal">
                    <i class="fa fa-plus"></i> Autor
                </button>
            </div>
            <table class="table table-striped">
                <thead>
                <tr class="bg-light">
                    <th>Nome</th>
                    <th class="text-center">Ações</th>
                </tr>
                </thead>
                <tbody>
                @foreach($authors as $author)
                    <tr>
                        <td>{{ $author['nome'] }}</td>
                        <td>
                            <div class="text-center">
                                <button type="button" class="btn edit-button" data-id="{{ $author['codAu'] }}" data-name="{{ $author['nome'] }}"><i class="fa fa-pencil"></i> Editar</button>
                                <button type="button" class="btn text-danger delete-button" data-id="{{ $author['codAu'] }}"><i class="fa fa-trash"></i> Excluir</button>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="storeAuthorModal" tabindex="-1" aria-labelledby="storeAuthorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="storeAuthorModalLabel">Salvar Autor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formAuthor">
                        @csrf
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome do Autor</label>
                            <input type="hidden" class="form-control" id="codAu" name="codAu">
                            <input type="text" class="form-control" id="nome" name="nome" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Salvar Autor</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('formAuthor').addEventListener('submit', function(e) {
            e.preventDefault();

            const codAu = document.getElementById('codAu').value;
            const name = document.getElementById('nome').value;

            const uri = codAu ? `/api/author/${codAu}` : '/api/author';
            const method = codAu ? 'PATCH' : 'POST';

            fetch(uri, {
                method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    nome: name
                })
            })
                .then(function (response) {
                    return response.json().then(body => {
                        if (response.ok) {
                            alert('Autor salvo com sucesso!');
                            location.reload();
                        } else {
                            alert(`Erro ao salvar o autor: ${JSON.stringify(body.errors)}`)
                        }
                    });
                })
                .catch(function (error) {
                    alert(`Erro inesperado ao salvar autor: ${JSON.stringify(error)}`);
                });
        });

        document.querySelectorAll('.edit-button').forEach(button => {
            button.addEventListener('click', function() {
                const codAu = this.getAttribute('data-id');

                document.getElementById('nome').value = this.getAttribute('data-name');
                document.getElementById('codAu').value = codAu;

                const modalStore = new bootstrap.Modal(document.getElementById('storeAuthorModal'));

                modalStore.show();
            });
        });

        document.querySelectorAll('.delete-button').forEach(button => {
            button.addEventListener('click', function() {
                const codAu = this.getAttribute('data-id');

                const confirmDelete = confirm("Você tem certeza que deseja excluir este autor?");

                if (confirmDelete) {
                    fetch(`/api/author/${codAu}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                        .then(response => {
                            if (response.ok) {
                                alert('Autor excluído com sucesso!');
                                location.reload();
                            } else {
                                return response.json().then(body => {
                                    alert(`Erro ao excluir o autor: ${JSON.stringify(body)}`);
                                });
                            }
                        });
                }
            });
        });
    </script>

@endsection
