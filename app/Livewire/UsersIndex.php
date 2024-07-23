<?php

namespace App\Livewire;

use Livewire\Attributes\Computed;
use Livewire\Component;

class UsersIndex extends Component
{
    #[Computed]
    public function users()
    {
        return [
            [
                'full_name' => fake()->firstName() . ' ' . fake()->lastName(),
                'email' => fake()->email(),
                'username' => fake()->userName(),
                'is_admin' => fake()->randomElement(['Yes', 'No']),
                'is_enabled' => fake()->randomElement(['Yes', 'No']),
            ],
            [
                'full_name' => fake()->firstName() . ' ' . fake()->lastName(),
                'email' => fake()->email(),
                'username' => fake()->userName(),
                'is_admin' => fake()->randomElement(['Yes', 'No']),
                'is_enabled' => fake()->randomElement(['Yes', 'No']),
            ],
            [
                'full_name' => fake()->firstName() . ' ' . fake()->lastName(),
                'email' => fake()->email(),
                'username' => fake()->userName(),
                'is_admin' => fake()->randomElement(['Yes', 'No']),
                'is_enabled' => fake()->randomElement(['Yes', 'No']),
            ],
            [
                'full_name' => fake()->firstName() . ' ' . fake()->lastName(),
                'email' => fake()->email(),
                'username' => fake()->userName(),
                'is_admin' => fake()->randomElement(['Yes', 'No']),
                'is_enabled' => fake()->randomElement(['Yes', 'No']),
            ],
            [
                'full_name' => fake()->firstName() . ' ' . fake()->lastName(),
                'email' => fake()->email(),
                'username' => fake()->userName(),
                'is_admin' => fake()->randomElement(['Yes', 'No']),
                'is_enabled' => fake()->randomElement(['Yes', 'No']),
            ],
            [
                'full_name' => fake()->firstName() . ' ' . fake()->lastName(),
                'email' => fake()->email(),
                'username' => fake()->userName(),
                'is_admin' => fake()->randomElement(['Yes', 'No']),
                'is_enabled' => fake()->randomElement(['Yes', 'No']),
            ],
            [
                'full_name' => fake()->firstName() . ' ' . fake()->lastName(),
                'email' => fake()->email(),
                'username' => fake()->userName(),
                'is_admin' => fake()->randomElement(['Yes', 'No']),
                'is_enabled' => fake()->randomElement(['Yes', 'No']),
            ],
        ];
    }

    public function render()
    {
        return view('livewire.users-index');
    }
}
