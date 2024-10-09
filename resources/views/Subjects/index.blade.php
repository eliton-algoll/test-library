@extends('layouts.app')
@section('content')
    <div class="container">
        <h3 class="text-center">Assuntos</h3>
        <div class="mt-5">
            <div class="d-flex justify-content-end ml-3 mb-3">
                <button type="button" class="btn btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#storeSubjectModal">
                    <i class="fa fa-plus"></i> Assunto
                </button>
            </div>
            <table class="table table-striped">
                <thead>
                <tr class="bg-light">
                    <th>Descrição</th>
                    <th class="text-center">Ações</th>
                </tr>
                </thead>
                <tbody>
                @foreach($subjects as $subject)
                    <tr>
                        <td>{{ $subject['descricao'] }}</td>
                        <td>
                            <div class="text-center">
                                <button type="button" class="btn edit-button" data-id="{{ $subject['codAs'] }}" data-description="{{ $subject['descricao'] }}"><i class="fa fa-pencil"></i> Editar</button>
                                <button type="button" class="btn text-danger delete-button" data-id="{{ $subject['codAs'] }}"><i class="fa fa-trash"></i> Excluir</button>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="storeSubjectModal" tabindex="-1" aria-labelledby="storeSubjectModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="storeSubjectModalLabel">Salvar Assunto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formSubject">
                        @csrf
                        <div class="mb-3">
                            <label for="descricao" class="form-label">Descrição</label>
                            <input type="hidden" class="form-control" id="codAs" name="codAs">
                            <input type="text" class="form-control" id="descricao" name="descricao" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Salvar Assunto</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('formSubject').addEventListener('submit', function(e) {
            e.preventDefault();

            const codAs = document.getElementById('codAs').value;
            const description = document.getElementById('descricao').value;

            const uri = codAs ? `/api/subject/${codAs}` : '/api/subject';
            const method = codAs ? 'PATCH' : 'POST';

            fetch(uri, {
                method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    descricao: description
                })
            })
                .then(function (response) {
                    return response.json().then(body => {
                        if (response.ok) {
                            alert('Assunto salvo com sucesso!');
                            location.reload();
                        } else {
                            alert(`Erro ao salvar o assunto: ${JSON.stringify(body.errors)}`)
                        }
                    });
                })
                .catch(function (error) {
                    alert(`Erro inesperado ao salvar assunto: ${JSON.stringify(error)}`);
                });
        });

        document.querySelectorAll('.edit-button').forEach(button => {
            button.addEventListener('click', function() {
                const codAs = this.getAttribute('data-id');

                document.getElementById('descricao').value = this.getAttribute('data-description');
                document.getElementById('codAs').value = codAs;

                const modalStore = new bootstrap.Modal(document.getElementById('storeSubjectModal'));

                modalStore.show();
            });
        });

        document.querySelectorAll('.delete-button').forEach(button => {
            button.addEventListener('click', function() {
                const codAs = this.getAttribute('data-id');

                const confirmDelete = confirm("Você tem certeza que deseja excluir este asunto?");

                if (confirmDelete) {
                    fetch(`/api/subject/${codAs}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                        .then(response => {
                            if (response.ok) {
                                alert('Assunto excluído com sucesso!');
                                location.reload();
                            } else {
                                return response.json().then(body => {
                                    alert(`Erro ao excluir o asunto: ${JSON.stringify(body)}`);
                                });
                            }
                        });
                }
            });
        });
    </script>

@endsection
