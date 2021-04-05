<?php namespace Wcli\Crm\Classes\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Wcli\Crm\Models\Region;

class RegionsImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        $faker = \Faker\Factory::create('fr_FR');
        
        foreach ($rows as $row) {
            $region = new Region();
            $region->id = $row['id'] ?? null;
            $region->name = $row['name'] ?? null;
            $region->slug = $row['slug'] ?? null;
            $region->email = $faker->email;
            $region->save();
        }
    }
}
