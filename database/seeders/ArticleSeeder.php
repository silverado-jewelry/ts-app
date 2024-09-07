<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (range(1, 5) as $i) {
            foreach ($this->getData() as $data) {
                Article::factory()->create(
                    array_merge($data, ['user_id' => $i])
                );
            }
        }
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return [
            [
                'title' => 'Lorem Ipsum',
                'body' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'publish_at' => now()->addDays(rand(1, 10))->toDate(),
            ],
            [
                'title' => 'Dolor Sit Amet',
                'body' => 'Dolor sit amet, consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'publish_at' => now()->addDays(rand(1, 10))->toDate(),
            ],
            [
                'title' => 'Consectetur Adipiscing Elit',
                'body' => 'Consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'publish_at' => now()->addDays(rand(1, 10))->toDate(),
            ],
            [
                'title' => 'Sed Do Eiusmod Tempor',
                'body' => 'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'publish_at' => now()->addDays(rand(1, 10))->toDate(),
            ],
            [
                'title' => 'Incididunt Ut Labore',
                'body' => 'Incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'publish_at' => now()->addDays(rand(1, 10))->toDate(),
            ],
            [
                'title' => 'Et Dolore Magna Aliqua',
                'body' => 'Et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'publish_at' => now()->addDays(rand(1, 10))->toDate(),
            ],
            [
                'title' => 'Ut Enim Ad Minim Veniam',
                'body' => 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'publish_at' => now()->addDays(rand(1, 10))->toDate(),
            ],
            [
                'title' => 'Quis Nostrud Exercitation',
                'body' => 'Quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'publish_at' => now()->addDays(rand(1, 10))->toDate(),
            ],
            [
                'title' => 'Ullamco Laboris Nisi',
                'body' => 'Ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'publish_at' => now()->addDays(rand(1, 10))->toDate(),
            ],
            [
                'title' => 'Ut Aliquip Ex Ea Commodo',
                'body' => 'Ut aliquip ex ea commodo consequat.',
                'publish_at' => now()->addDays(rand(1, 10))->toDate(),
            ],
        ];
    }
}
