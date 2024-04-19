<?php

namespace Database\Factories;

use Faker\Guesser\Name;
use Faker\Provider\Barcode;
use Faker\Provider\Company;
use Faker\Provider\Image;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = FakerFactory::create();

        return [
            'title' => $faker->title,
            'author' => $faker->firstName . " " . $faker->lastName, // Assuming you have a helper for generating author names
            'category_id' => rand(1, 5), // Assuming categories table with IDs 1 to   5
            'publisher' => $faker->company, // Assuming you have a helper for generating company names
            'published_year' => rand(1900, 2024),
            'ISBN' => $faker->isbn13(), // Assuming you have a helper for generating ISBN
            'cover' => $faker->imageUrl, // Assuming you have a helper for generating image filenames
            'created_at' => now(),
            'updated_at' => now(),
            'is_available' => 1,
        ];
    }
}
