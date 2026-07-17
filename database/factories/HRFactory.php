<?php

namespace Database\Factories;

use App\Models\HR;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<HR>
 */
class HRFactory extends Factory
{
    protected $model = HR::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $positions = ['dispatcher', 'sales executive', 'hr', 'carrier sales', 'accounts', 'onboarding', 'marketing', 'other'];
        $departments = ['Operations', 'Sales', 'HR', 'Accounts', 'Marketing', 'Onboarding'];
        $recommendations = ['highly_recommended', 'recommended', 'maybe', 'not_recommended'];
        $statuses = ['pending', 'selected', 'rejected', 'on_hold'];

        $communication = fake()->numberBetween(1, 10);
        $english = fake()->numberBetween(1, 10);
        $computerSkills = fake()->numberBetween(1, 10);
        $confidence = fake()->numberBetween(1, 10);
        $learningAbility = fake()->numberBetween(1, 10);
        $dispatchKnowledge = fake()->numberBetween(1, 10);
        $negotiationSkills = fake()->numberBetween(1, 10);

        return [
            'candidate_name' => fake()->name(),
            'phone' => fake()->numerify('##########'),
            'email' => fake()->unique()->safeEmail(),
            'position' => fake()->randomElement($positions),
            'department' => fake()->randomElement($departments),
            'expected_salary' => fake()->numberBetween(30000, 90000),
            'experience' => fake()->numberBetween(0, 15),
            'city' => fake()->city(),
            'reference' => fake()->name(),
            'interviewer' => fake()->name(),
            'interview_date' => fake()->dateTimeBetween('-2 months', 'now')->format('Y-m-d'),
            'communication' => $communication,
            'english' => $english,
            'computer_skills' => $computerSkills,
            'confidence' => $confidence,
            'learning_ability' => $learningAbility,
            'dispatch_knowledge' => $dispatchKnowledge,
            'negotiation_skills' => $negotiationSkills,
            'typing_speed' => fake()->numberBetween(20, 80),
            'total_score' => $communication + $english + $computerSkills + $confidence + $learningAbility + $dispatchKnowledge + $negotiationSkills,
            'strengths' => fake()->sentence(),
            'weaknesses' => fake()->sentence(),
            'comments' => fake()->sentence(),
            'recommendation' => fake()->randomElement($recommendations),
            'status' => fake()->randomElement($statuses),
        ];
    }
}
