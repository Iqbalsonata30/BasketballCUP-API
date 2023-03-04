<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Team>
 */
class TeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $team_name  = fake()->word();
        $file = UploadedFile::fake()->image('test.jpg');
        Storage::disk('public')->put('images/teams/', $file);
        return [
            'team_name' => $team_name,
            'slug'      => Str::slug($team_name, '-'),
            'team_logo' => $file->hashName(),
            'team_gender' => 'Putra'
        ];
    }
}
