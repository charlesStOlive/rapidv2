<?php namespace Wcli\Crm\Classes\Imports;

use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\RemembersChunkOffset;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Wcli\Crm\Models\Sale;
use \PhpOffice\PhpSpreadsheet\Shared\Date as DateConvert;

class SalesImportDate implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading, ShouldQueue
{

    use RemembersChunkOffset;

    public function __construct()
    {

        $this->now = Carbon::now();
    }

    public function model(array $row)
    {
        $date = DateConvert::excelToDateTimeObject($row['sale_at']);
        if ($date > $this->now) {
            return;
        } else {
            return new Sale([
                'name' => $row['gamme_id'] . '-' . $row['client_id'],
                'gamme_id' => $row['gamme_id'],
                'client_id' => $row['client_id'],
                'sale_at' => DateConvert::excelToDateTimeObject($row['sale_at']),
                'montant' => $row['montant'],
            ]);
        }

    }

    public function batchSize(): int
    {
        return 1000;
    }
    public function chunkSize(): int
    {
        return 1000;
    }
}
