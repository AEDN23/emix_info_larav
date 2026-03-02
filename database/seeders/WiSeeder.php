<?php

namespace Database\Seeders;

use App\Models\wi;
use App\Models\departemen;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class WiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $departemens = departemen::pluck('id')->toArray();
        $users = User::pluck('id')->toArray();

        if (empty($departemens) || empty($users)) {
            $this->command->warn('Skipping WiSeeder: No departemens or users found.');
            return;
        }

        for ($i = 1; $i <= 100; $i++) {
            wi::create([
                'nomer_wi' => 'WI-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'nama_wi' => 'WI ' . $faker->words(3, true),
                'departemen_id' => $faker->randomElement($departemens),
                'keterangan' => $faker->sentence(),
                'approve' => (string) $faker->numberBetween(0, 1),
                'tahun' => (string) $faker->year(),
                'file' => 'samples/sample_wi.pdf',
                'active' => '1',
                'video' => '-',
                'created_by' => $faker->randomElement($users),
            ]);
        }
    }
}
