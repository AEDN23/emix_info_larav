<?php

namespace Database\Seeders;

use App\Models\std;
use App\Models\departemen;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class StdSeeder extends Seeder
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
            $this->command->warn('Skipping StdSeeder: No departemens or users found.');
            return;
        }

        for ($i = 1; $i <= 100; $i++) {
            std::create([
                'nomer_std' => 'STD-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'nama_std' => 'STD ' . $faker->words(3, true),
                'departemen_id' => $faker->randomElement($departemens),
                'keterangan' => $faker->sentence(),
                'approve' => (string) $faker->numberBetween(0, 1),
                'tahun' => (string) $faker->year(),
                'file' => 'samples/sample_std.pdf',
                'active' => '1',
                'video' => '-',
                'created_by' => $faker->randomElement($users),
            ]);
        }
    }
}
