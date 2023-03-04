<?php

namespace App\Services;

use App\Models\Standing;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class StandingServices
{
  public function getStanding(Request $request): Collection
  {
    $teamGender = $request->query('gender', 'Putra');
    $standing =  Standing::leftJoin('teams', 'teams_id', '=', 'teams.id')
      ->select('standings.id as id', 'teams.id as teams_id', 'teams.team_name as team_name', 'standings.*')
      ->where('gender', $teamGender)
      ->get();
    return $standing;
  }

  public function changePool(Request $request, int  $id)
  {
    $standing = Standing::findOrFail($id);
    $standing->update(
      $request->validate(
        ['pool'  => 'max:1|alpha:ascii']
      )
    );
    return $standing;
  }
}
