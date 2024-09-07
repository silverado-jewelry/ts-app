<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->getData() as $data) {
            User::factory()->create($data);
        }
    }

    private function getData(): array
    {
        return [
            [
                'name' => 'Jon Snow',
                'email' => 'j.snow@localhost.com',
                'password' => '1234QwertY',
            ],
            [
                'name' => 'Daenerys Targaryen',
                'email' => 'dragonsmom@localhost.com',
                'password' => '1234QwertY',
            ],
            [
                'name' => 'Edard Stark',
                'email' => 'winteriscoming@localhost.com',
                'password' => '1234QwertY',
            ],
            [
                'name' => 'Tyrion Lannister',
                'email' => 't.lannister@localhost.com',
                'password' => '1234QwertY',
            ],
            [
                'name' => 'Cersei Lannister',
                'email' => 'c.lannister@localhost.com',
                'password' => '1234QwertY',
            ]
        ];
    }
}
