<?php namespace Wcli\Crm\Classes\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Wcli\Crm\Models\Client;

class ClientsImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        $faker = \Faker\Factory::create('fr_FR');

        foreach ($rows as $row) {
            $client = new Client();
            $client->id = $row['id'];
            $client->name = $faker->unique()->company . ' ' . $row['id'];
            $client->siret = $faker->unique()->siret;
            $client->address = $faker->streetAddress;
            $client->cp = $faker->postcode;
            $client->city = $faker->city;
            $client->tel = $faker->phoneNumber;
            $client->email = $faker->email;
            $client->region_id = $row['region_id'];
            $client->save();
        }
    }
}
