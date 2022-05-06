<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Importation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'transactions_date'
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function transactions()
    {
        return $this->hasMany('App\Models\Transaction');
    }

    public function transactionsDate(): string
    {
        return Carbon::createFromFormat('Y-m-d', $this->transactions_date)
            ->format('d/m/Y');
    }

    public function createdAt(): string
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)
            ->format('d/m/Y H:i:s');
    }
}
