<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use App\Models\Review;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Faker\Guesser\Name;
use Faker\Provider\Barcode;
use Faker\Provider\Company;
use Faker\Provider\Image;
use Faker\Provider\Lorem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin'),
            'is_admin' => 1,
        ]);

        Book::factory(10)->create();

        User::factory(10)->create();

        Review::factory(50)->create();

        //Category::factory(5)->create();
    }
}
