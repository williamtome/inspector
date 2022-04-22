<?php

namespace App\Models;

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
}
