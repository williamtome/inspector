<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadRequest;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    public function index()
    {
        $data = $this->prepareDataToShow();

        return view('transactions', compact('data'));
    }

    public function upload(UploadRequest $request)
    {
        $file = $request->file('csv');

        $path = $file->store('spreadsheets');

        $localPath = storage_path('app/' . $path);

        session()->put('spreadsheet_path', $localPath);

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

}
