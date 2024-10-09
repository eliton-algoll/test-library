<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Relatório</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<h1>Relatório de Livros</h1>

<table>
    <thead>
    <tr>
        <th>Título</th>
        <th>Autor</th>
        <th>Assunto</th>
        <th>Editora</th>
        <th>Edição</th>
        <th>Ano de publicação</th>
        <th>Valor</th>
    </tr>
    </thead>
    <tbody>
    @foreach($reportData as $bookData)
        <tr>
            <td>{{ $bookData->titulo }}</td>
            <td>{{ $bookData->autor }}</td>
            <td>{{ $bookData->assunto }}</td>
            <td>{{ $bookData->editora }}</td>
            <td>{{ $bookData->edicao }}</td>
            <td>{{ $bookData->anoPublicacao }}</td>
            <td>R$ {{ number_format($bookData->valor, 2, ',', '.') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
