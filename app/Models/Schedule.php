<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_home_id',
        'team_away_id',
        'day',
        'time',
        'date',
        'pool'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];

    public function homeTeam()
    {
        return $this->belongsTo(Team::class, 'team_home_id', 'id');
    }
    public function awayTeam()
    {
        return $this->belongsTo(Team::class, 'team_away_id', 'id');
    }
}
