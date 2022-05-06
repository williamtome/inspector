<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Transações da Importação #" . $importation->id) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-400">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Banco de Origem</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Agência de Origem</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Conta de Origem</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Banco de Destino</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Agência de Destino</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Conta de Destino</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Valor</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($importation->transactions as $transaction)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-center font-medium text-gray-900 whitespace-nowrap">{{ $transaction->origin_bank }}</td>
                                    <td class="px-6 py-4 text-sm text-center font-medium text-gray-900 whitespace-nowrap">{{ $transaction->origin_agency }}</td>
                                    <td class="px-6 py-4 text-sm text-center font-medium text-gray-900 whitespace-nowrap">{{ $transaction->origin_account }}</td>
                                    <td class="px-6 py-4 text-sm text-center font-medium text-gray-900 whitespace-nowrap">{{ $transaction->destiny_bank }}</td>
                                    <td class="px-6 py-4 text-sm text-center font-medium text-gray-900 whitespace-nowrap">{{ $transaction->destiny_agency }}</td>
                                    <td class="px-6 py-4 text-sm text-center font-medium text-gray-900 whitespace-nowrap">{{ $transaction->destiny_account }}</td>
                                    <td class="px-6 py-4 text-sm text-center font-medium text-gray-900 whitespace-nowrap">{{ $transaction->amount }}</td>
                                    <td class="px-6 py-4 text-sm text-center font-medium text-gray-900 whitespace-nowrap">{{ $transaction->date() }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-4 text-sm text-center font-medium text-gray-900 whitespace-nowrap">Nenhuma importação!</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
