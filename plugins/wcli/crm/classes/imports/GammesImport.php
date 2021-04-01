<?php namespace Wcli\Crm\Classes\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Wcli\Crm\Models\Gamme;

class GammesImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $gamme = new Gamme();
            $gamme->id = $row['id'] ?? null;
            $gamme->name = $row['name'] ?? null;
            $gamme->slug = $row['slug'] ?? null;
            $gamme->description = $row['description'] ?? null;
            $gamme->parent_id = $row['parent_id'] ?? null;
            $gamme->save();
        }
    }
}
