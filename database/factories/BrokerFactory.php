<?php

namespace Database\Factories;

use App\Models\Broker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Broker>
 */
class BrokerFactory extends Factory
{
    protected $model = Broker::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $equipmentTypes = ['Dry Van', 'Reefer', 'Flatbed', 'Step Deck', 'RGN', 'Box Truck', 'Tanker'];
        $states = ['AL', 'AZ', 'CA', 'CO', 'FL', 'GA', 'IL', 'NY', 'OH', 'TX'];

        return [
            'dispatcher_name' => fake()->name(),
            'company_name' => fake()->unique()->company(),
            'mc_number' => (string) fake()->unique()->numberBetween(100000, 999999),
            'dot_number' => (string) fake()->unique()->numberBetween(1000000, 9999999),
            'website' => fake()->boolean(70) ? fake()->url() : null,
            'status' => fake()->randomElement(['active', 'inactive', 'blacklisted', 'pending']),
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->numerify('##########'),
            'address' => fake()->streetAddress(),
            'city' => fake()->city(),
            'state' => fake()->randomElement($states),
            'zip_code' => fake()->postcode(),
            'equipment_type' => fake()->randomElements($equipmentTypes, fake()->numberBetween(1, 3)),
            'operating_states' => fake()->randomElements($states, fake()->numberBetween(1, 5)),
            'credit_score' => (string) fake()->numberBetween(1, 10),
            'days_to_pay' => fake()->numberBetween(0, 60),
            'notes' => fake()->boolean(60) ? fake()->sentence() : null,
        ];
    }
}
