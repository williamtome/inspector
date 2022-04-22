@extends('welcome')

@section('content')

<h1>Importar Transações</h1>


<form action="{{ route('upload') }}" method="post" enctype="multipart/form-data">
    @csrf

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <strong class="block sm:inline">{{ session('error') }}</strong>
        </div>
        <br>
    @endif

    <input type="file" name="csv">
    <br><br>
    <button>Importar</button>
</form>

<br><br>

<h1>Importações Realizadas</h1>

<table>
    <tr>
        <th>Data Transações</th>
        <th>Data Importação</th>
    </tr>
    <tbody>
        @forelse($importations as $importation)
            <tr>
                <td>{{ $importation->transactionsDate() }}</td>
                <td>{{ $importation->createdAt() }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="2">Nenhuma importação!</td>
            </tr>
        @endforelse
    </tbody>
</table>

@endsection
