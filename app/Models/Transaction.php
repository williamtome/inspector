<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'origin_bank',
        'origin_agency',
        'origin_account',
        'destiny_bank',
        'destiny_agency',
        'destiny_account',
        'amount',
        'date',
        'importation_id',
    ];

    public function importation()
    {
        return $this->belongsTo('App\Models\Importation');
    }

    public function date(): string
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->date)
            ->format('d/m/Y H:i:s');
    }
}
