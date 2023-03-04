<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Standing extends Model
{
    use HasFactory;


    protected $fillable = [
        'teams_id',
        'total_win',
        'total_lose',
        'total_match',
        'pool',
        'gender',
        'winrate'
    ];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];
}
