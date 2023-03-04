<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_name',
        'slug',
        'team_logo',
        'team_gender'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s' 
    ];

    protected static function booted(): void
    {
        static::created(function (Team $team) {
            Standing::create([
                'teams_id' => $team->id,
                'gender'   => $team->team_gender,
            ]);
        });
    }

    public function players(): HasMany
    {
        return $this->hasMany(Player::class, 'teams_id', 'id');
    }

    public function homeSchedules()
    {
        return $this->hasMany(Schedule::class, 'team_home_id');
    }

    public function awaySchedules()
    {
        return $this->hasMany(Schedule::class, 'team_away_id');
    }
}
