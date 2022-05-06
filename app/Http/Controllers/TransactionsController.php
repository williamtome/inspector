<?php

namespace App\Http\Controllers;

use App\Http\Repositories\Csv\CsvRepository;
use App\Http\Repositories\Importation\ImportationRepository;
use App\Http\Repositories\Transaction\TransactionRepository;
use App\Http\Requests\UploadRequest;
use App\Http\Services\Csv\CsvService;
use App\Models\Importation;
use Illuminate\Support\Facades\DB;

class TransactionsController extends Controller
{
    private CsvRepository $csvRepository;
    private ImportationRepository $importationRepository;
    private TransactionRepository $repository;

    public function __construct(
        CsvRepository $csvRepository,
        TransactionRepository $repository,
        ImportationRepository $importationRepository
    ) {
        $this->csvRepository = $csvRepository;
        $this->repository = $repository;
        $this->importationRepository = $importationRepository;
    }

    public function show(Importation $importation)
    {
        return view('upload.details', ['importation' => $importation]);
    }

    public function upload(UploadRequest $request)
    {
        $csvPath = $this->csvRepository->upload($request);

        DB::transaction(function () use (&$csvPath) {
            (new CsvService(
                $csvPath,
                $this->repository,
                $this->csvRepository,
                $this->importationRepository
            ))->handle();
        });

        return redirect()->route('upload');
    }
}
