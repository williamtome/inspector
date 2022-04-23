<?php

namespace App\Http\Repositories\Csv;

use Illuminate\Http\Request;

class CsvRepository
{
    public function upload(Request $request): bool|string
    {
        $file = $request->file('csv');

        $path = $file->store('spreadsheets');

        return storage_path('app/' . $path);
    }

    public function read(string $csvPath): array|\Generator
    {
        $csv = fopen($csvPath, 'r');

        while (!feof($csv)) {
            yield fgetcsv($csv);
        }

        return [];
    }
}
