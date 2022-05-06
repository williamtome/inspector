<?php

namespace App\Http\Controllers;

use App\Http\Repositories\Importation\ImportationRepository;
use Illuminate\Http\Request;

class ImportationsController extends Controller
{
    private ImportationRepository $importationRepository;

    public function __construct(ImportationRepository $importationRepository)
    {
        $this->importationRepository = $importationRepository;
    }

    public function index()
    {
        $importations = $this->importationRepository->getAllByTransactionsDate();

        return view('upload.form', ['importations' => $importations]);
    }
}
