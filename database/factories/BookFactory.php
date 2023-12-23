<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Client;

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

        $clientIds = Client::pluck('id')->toArray();
        $clientId = $this->faker->randomElement([$this->faker->randomElement($clientIds), null]);

        return [
            'title' => $this->faker->sentence(),
            'author' => $this->faker->name(),
            'published_date' => $this->faker->date(),
            'client_id' => $clientId,
            'due_date' => $clientId ? $this->faker->dateTimeBetween('-4 week', '+4 week') : null,
        ];
        // return [
        //     'title' => $this->faker->sentence(),
        //     'author' => $this->faker->name(),
        //     'published_date' => $this->faker->date(),
        //     'client_id' => function () {
        //         return \App\Models\Client::inRandomOrder()->first()->id;
        //     },
        //     'due_date' => $this->faker->dateTimeBetween('-4 week', '+4 week'),
        // ];
    }
}



// use Faker\Generator as Faker;
// use App\Models\Book;
// use App\Models\Client;

// $factory->define(Book::class, function (Faker $faker) {
//     $clientIds = Client::pluck('id')->toArray();
//     $clientId = $faker->randomElement([$faker->randomElement($clientIds), null]);

//     return [
//         'title' => $faker->sentence,
//         'author' => $faker->name,
//         'published_date' => $faker->date,
//         'client_id' => $clientId,
//         'due_date' => $clientId ? $faker->date : null,
//     ];
// });