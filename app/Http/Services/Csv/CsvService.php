<?php

namespace App\Http\Services\Csv;

use App\Http\Repositories\Csv\CsvRepository;
use App\Http\Repositories\Importation\ImportationRepository;
use App\Http\Repositories\Transaction\TransactionRepository;
use App\Models\Importation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CsvService
{
    private const FIRSTCSVROW = 0;
    private bool|string $csvPath;
    private \Generator|array $rows;
    private CsvRepository $csvRepository;
    private TransactionRepository $repository;
    private ImportationRepository $importationRepository;
    private Carbon $transactionDate;
    private Importation $importation;

    public function __construct(
        string $pathFile,
        TransactionRepository $repository,
        CsvRepository $csvRepository,
        ImportationRepository $importationRepository,
    ) {
        $this->csvPath = $pathFile;
        $this->repository = $repository;
        $this->csvRepository = $csvRepository;
        $this->importationRepository = $importationRepository;
    }

    public function handle()
    {
        $this->rows = $this->csvRepository->read($this->csvPath);

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
                        ->withErrors(['Já existe transações para esta data!']);
                }

                $this->importation = $this->importationRepository->store([
                    'transactions_date' => $this->transactionDate->toDateString(),
                    'user_id' => Auth::id(),
                ]);

                $this->repository->store($this->getCsvPayload($row));

                continue;
            }

            if ($this->transactionDate->toDateString() != $date->toDateString()) {
                continue;
            }

            $this->repository->store($this->getCSVPayload($row));
        }
    }

    private function getCsvPayload($data): array
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
            'importation_id' => $this->importation->id,
        ];
    }

    private function isFirstRowOfCSVFile(): bool
    {
        return $this->rows->key() === self::FIRSTCSVROW;
    }
}
