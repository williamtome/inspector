<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Importar Transações') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('upload') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        @if ($errors->any())
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                @foreach($errors->all() as $error)
                                    <strong class="block sm:inline">{{ $error }}</strong>
                                @endforeach
                            </div>
                            <br>
                        @endif

                        <input type="file" name="csv">
                        <br><br>
                        <button>Importar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1>Importações Realizadas</h1>

                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-400">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data Transações</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data Importação</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usuário</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($importations as $importation)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-center font-medium text-gray-900 whitespace-nowrap">{{ $importation->transactionsDate() }}</td>
                                    <td class="px-6 py-4 text-sm text-center font-medium text-gray-900 whitespace-nowrap">{{ $importation->createdAt() }}</td>
                                    <td class="px-6 py-4 text-sm text-center font-medium text-gray-900 whitespace-nowrap">{{ $importation->user->name }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="px-6 py-4 text-sm text-center font-medium text-gray-900 whitespace-nowrap">Nenhuma importação!</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
