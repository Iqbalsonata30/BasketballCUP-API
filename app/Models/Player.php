<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    protected $fillable = [
        'teams_id',
        'name',
        'number',
        'position',
        'height',
        'weight',
        'age'
    ];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];
    public function teams()
    {
        return $this->belongsTo(Team::class, 'id', 'teams_id');
    }
}
