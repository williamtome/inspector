<?php

namespace App\Http\Repositories\Importation;

use App\Models\Importation;

class ImportationRepository
{
    public function store(array $attributes)
    {
        return Importation::create($attributes);
    }

    public function getAllByTransactionsDate()
    {
        return Importation::query()
            ->orderBy('transactions_date', 'desc')
            ->get();
    }
}
