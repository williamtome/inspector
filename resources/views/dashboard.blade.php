<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Usuários') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            @foreach($errors->all() as $error)
                                <strong class="block sm:inline">{{ $error }}</strong>
                            @endforeach
                        </div>
                    @endif

                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-600 uppercase tracking-wider">
                                    Nome
                                </th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-600 uppercase tracking-wider">
                                    E-mail
                                </th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-600 uppercase tracking-wider">
                                    Opções
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($users as $user)
                            <tr>
                                <td class="px-6 py-4 text-sm text-center font-medium text-gray-900 whitespace-nowrap">{{ $user->name }}</td>
                                <td class="px-6 py-4 text-sm text-center font-medium text-gray-900 whitespace-nowrap">{{ $user->email }}</td>
                                <td class="px-6 py-4 text-sm text-center font-medium text-gray-900 whitespace-nowrap">
                                    <x-nav-link href="{{ route('register.edit', $user) }}">
                                        Editar
                                    </x-nav-link>
                                    @can('manage-users')
                                    <form method="POST" action="{{ route('register.destroy', $user) }}">
                                        @method('DELETE')
                                        @csrf
                                        <x-button>Deletar</x-button>
                                    </form>
                                    @endcan
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-sm text-center font-medium text-gray-900 whitespace-nowrap">
                                    Sem usuários
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
