<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadRequest;
use App\Models\Importation;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionsController extends Controller
{
    private Carbon $transactionDate;

    private const FIRSTCSVROW = 0;
    private Importation $importation;

    public function index()
    {
        $importations = Importation::query()
            ->orderBy('transactions_date', 'desc')
            ->get();

        return view('form-upload', compact('importations'));
    }

    public function upload(UploadRequest $request)
    {
        $file = $request->file('csv');

        $path = $file->store('spreadsheets');

        $csvPath = storage_path('app/' . $path);

        session()->put('spreadsheet_path', $csvPath);

        $csv = fopen($csvPath, 'r');

        $data = $this->readCompleteCSVFile($csv);

        DB::beginTransaction();

        foreach ($data as $row) {
            if (!$row) {
                break;
            }

            if (array_search("", $row)) {
                continue;
            }

            $date = Carbon::parse($row[7]);

            if ($data->key() === self::FIRSTCSVROW) {
                $this->transactionDate = $date;

                if ($this->existsTransactionsForDate($this->transactionDate)) {
                    return redirect()->back()
                        ->with('error', 'Já existe transações para esta data!');
                }

                $this->importation = Importation::create([
                    'transactions_date' => $this->transactionDate->toDateString(),
                ]);

                Transaction::create($this->getCSVPayload($row, $this->importation));

                continue;
            }

            if ($this->transactionDate->toDateString() != $date->toDateString()) {
                continue;
            }

            Transaction::create($this->getCSVPayload($row, $this->importation));
        }

        DB::commit();

        return redirect('/home');
    }

    private function prepareDataToShow(): array
    {
        $spreadsheetPath = session('spreadsheet_path');
        $csv = fopen($spreadsheetPath, 'r');

        $data = [];

        while ($row = fgetcsv($csv,0,',')) {
            $data[] = $row;
        }

        return $data;
    }

    private function readCompleteCSVFile($csv): \Generator
    {
        while (!feof($csv)) {
            yield fgetcsv($csv);
        }

        return [];
    }

    private function getCSVPayload($data, $importation): array
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

    private function existsTransactionsForDate(Carbon $date)
    {
        return Transaction::where('date', 'like', $date->toDateString() . '%')->exists();
    }

}
