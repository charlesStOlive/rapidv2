<?php namespace Wcli\Crm\Classes\Imports;

use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\RemembersChunkOffset;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Wcli\Crm\Models\Sale;
use \PhpOffice\PhpSpreadsheet\Shared\Date as DateConvert;

class SalesImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading, ShouldQueue
{

    use RemembersChunkOffset;

    public function model(array $row)
    {
        return new Sale([
            'name' => $row['gamme_id'] . '-' . $row['client_id'],
            'gamme_id' => $row['gamme_id'],
            'client_id' => $row['client_id'],
            'sale_at' => DateConvert::excelToDateTimeObject($row['sale_at']),
            'montant' => $row['montant'],
        ]);
    }

    public function batchSize(): int
    {
        return 250;
    }
    public function chunkSize(): int
    {
        return 250;
    }
}
