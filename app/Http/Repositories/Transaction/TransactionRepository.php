<?php

namespace App\Http\Repositories\Transaction;

use App\Models\Transaction;
use Carbon\Carbon;

class TransactionRepository
{
    public function existForDate(Carbon $date)
    {
        return Transaction::where('date', 'like', $date->toDateString() . '%')->exists();
    }

    public function store(array $attributes)
    {
        return Transaction::create($attributes);
    }
}
