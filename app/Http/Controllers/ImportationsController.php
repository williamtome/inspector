<?php

namespace App\Http\Controllers;

use App\Http\Repositories\Importation\ImportationRepository;

class ImportationsController extends Controller
{
    public function __construct(
        private ImportationRepository $importationRepository
    ) {}

    public function index()
    {
        $importations = $this->importationRepository
            ->getAllByTransactionsDate();

        return view('upload.form', compact('importations'));
    }
}
