<?php

namespace App\Http\Controllers;

use App\Http\Repositories\Csv\CsvRepository;
use App\Http\Repositories\Importation\ImportationRepository;
use App\Http\Repositories\Transaction\TransactionRepository;
use App\Http\Requests\UploadRequest;
use App\Models\Importation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionsController extends Controller
{
    private const FIRSTCSVROW = 0;
    private \Generator|array $rows;
    private Carbon $transactionDate;
    private Importation $importation;

    private CsvRepository $csvRepository;
    private TransactionRepository $repository;
    private ImportationRepository $importationRepository;

    public function __construct(
        TransactionRepository $repository,
        CsvRepository $csvRepository,
        ImportationRepository $importationRepository
    ) {
        $this->repository = $repository;
        $this->csvRepository = $csvRepository;
        $this->importationRepository = $importationRepository;
    }

    public function index()
    {
        $importations = $this->importationRepository->getAllByTransactionsDate();

        return view('form-upload', ['importations' => $importations]);
    }

    public function upload(UploadRequest $request)
    {
        $csvPath = $this->csvRepository->upload($request);

        $this->rows = $this->csvRepository->read($csvPath);

        DB::transaction(function () {
            $this->handleCsvFile();
        });

        return redirect('/home');
    }

    public function handleCsvFile()
    {
        foreach ($this->rows as $row) {
            if (!$row) {
                break;
            }

            if (array_search("", $row)) {
                continue;
            }

            $date = Carbon::parse($row[7]);

            if ($this->isFirstRowOfCSVFile()) {
                $this->transactionDate = $date;

                if ($this->repository->existForDate($this->transactionDate)) {
                    return redirect()->back()
                        ->with('error', 'Já existe transações para esta data!');
                }

                $this->importation = $this->importationRepository->store([
                    'transactions_date' => $this->transactionDate->toDateString(),
                ]);

                $this->repository->store(
                    $this->getCsvPayload($row, $this->importation)
                );

                continue;
            }

            if ($this->transactionDate->toDateString() != $date->toDateString()) {
                continue;
            }

            $this->repository->store($this->getCSVPayload($row, $this->importation));
        }
    }

    private function getCsvPayload($data, $importation): array
    {
        return [
            'origin_bank' => $data[0],
            'origin_agency' => $data[1],
            'origin_account' => $data[2],
            'destiny_bank' => $data[3],
            'destiny_agency' => $data[4],
            'destiny_account' => $data[5],
            'amount' => $data[6],
            'date' => $data[7],
            'importation_id' => $importation->id,
        ];
    }

    private function isFirstRowOfCSVFile(): bool
    {
        return $this->rows->key() === self::FIRSTCSVROW;
    }
}
