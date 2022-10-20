<?php

declare(strict_types=1);

namespace App\Services;

class CsvService
{
    public function getCsvData(string $csvItem, array $keys, string $fileName): array
    {
        $csvData = [];

        if (($open = fopen(storage_path() . "/" . $fileName, 'rb')) !== false) {
            while (($data = fgetcsv($open, 1000)) !== false) {
                $csvData[] = new $csvItem(array_combine($keys, $data));
            }

            fclose($open);
        }

        return $csvData;
    }
}
