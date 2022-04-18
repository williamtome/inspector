<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadRequest;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    private Carbon $transactionDate;

    private const FIRSTCSVROW = 0;

    public function index()
    {
        $data = $this->prepareDataToShow();

        return view('transactions', compact('data'));
    }

    public function upload(UploadRequest $request)
    {
        $file = $request->file('csv');

        $path = $file->store('spreadsheets');

        $csvPath = storage_path('app/' . $path);

        session()->put('spreadsheet_path', $csvPath);

        $csv = fopen($csvPath, 'r');

        $data = $this->readCompleteCSVFile($csv);

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

                Transaction::create($this->getCSVPayload($row));

                continue;
            }

            if ($this->transactionDate->toDateString() != $date->toDateString()) {
                continue;
            }

            Transaction::create($this->getCSVPayload($row));
        }

        return redirect('/transactions');
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

    private function getCSVPayload($data): array
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
        ];
    }

    private function existsTransactionsForDate(Carbon $date)
    {
        return Transaction::where('date', 'like', $date->toDateString() . '%')->exists();
    }

}
