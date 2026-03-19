<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    public function definition(): array
    {
        $total = $this->faker->numberBetween(50, 500);

        $titles = [
            'Laravel Conference 2025',
            'PHP Developer Summit',
            'Tech Startup Meetup',
            'AI & Machine Learning Expo',
            'Web Design Workshop',
            'Cybersecurity Forum',
            'Mobile App Hackathon',
            'Cloud Computing Summit',
            'Digital Marketing Conference',
            'Open Source Festival',
        ];

        $locations = [
            'Karachi, Pakistan',
            'Lahore, Pakistan',
            'Islamabad, Pakistan',
            'Dubai, UAE',
            'London, UK',
        ];

        return [
            'title'           => $this->faker->randomElement($titles) . ' ' . $this->faker->year(),
            'description'     => $this->faker->paragraphs(2, true),
            'location'        => $this->faker->randomElement($locations),
            'event_date'      => $this->faker->dateTimeBetween('+1 week', '+6 months'),
            'total_seats'     => $total,
            'available_seats' => $total,
            'created_by'      => User::factory(),
        ];
    }
}