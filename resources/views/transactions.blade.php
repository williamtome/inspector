@extends('welcome')

@section('content')

<h1>Transações</h1>

<table>
    <tr>
        <th>Banco Origem</th>
        <th>Agência Origem</th>
        <th>Conta Origem</th>
        <th>Banco Destino</th>
        <th>Agência Destino</th>
        <th>Conta Destino</th>
        <th>Valor</th>
        <th>Data da Transação</th>
    </tr>
    <tbody>
        @forelse($data as $row)
            <tr>
                <td>{{ $row[0] }}</td>
                <td>{{ $row[1] }}</td>
                <td>{{ $row[2] }}</td>
                <td>{{ $row[3] }}</td>
                <td>{{ $row[4] }}</td>
                <td>{{ $row[5] }}</td>
                <td>{{ $row[6] }}</td>
                <td>{{ date('d/m/Y H:i', strtotime($row[7])) }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="8">Não há transações importadas!</td>
            </tr>
        @endforelse
    </tbody>
</table>

<br><br>

<a href="/home">Home</a>

@endsection
