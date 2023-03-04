<?php

namespace App\Services;

use App\Http\Requests\Teams\StoreTeamRequest;
use App\Http\Requests\Teams\UpdateTeamRequest;
use App\Models\Team;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TeamServices
{
  public function getTeams(Request $request): Collection
  {
    $teamGender = $request->query('gender', 'Putra');
    $team = Team::where('team_gender', $teamGender)->get();
    return $team;
  }

  public function createTeam(StoreTeamRequest $request): Team
  {
    $image = $request->file('team_logo');
    if ($image) {
      $image->storePubliclyAs('public/images/teams', $image->hashName());
      $team = Team::create(
        array_merge(
          $request->validated(),
          [
            'slug' => Str::slug($request->input('team_name'), '-'),
            'team_logo' => $image->hashName(),
          ]
        )
      );
    }
    return $team;
  }

  public function updateTeam(UpdateTeamRequest $request, int  $id): Team
  {
    $team = Team::findOrFail($id);
    $image = $request->file('team_logo');
    if ($image) {
      unlink(public_path("storage/images/teams/") . $team->team_logo);
      $image->storePubliclyAs('public/images/teams', $image->hashName());
      $team->update(array_merge(
        $request->validated(),
        [
          'slug' => ($request->input('team_name')) ? Str::slug($request->input('team_name'), '-') : $team->slug,
          'team_logo' => $image->hashName()
        ]
      ));
    } else {
      $team->update(
        array_merge(
          $request->validated(),
          [
            'slug' => ($request->input('team_name')) ? Str::slug($request->input('team_name'), '-') : $team->slug
          ]
        )
      );
    }
    return $team;
  }

  public function deleteTeam(int $id)
  {
    $team = Team::findOrFail($id);
    unlink(public_path("storage/images/teams/") . $team->team_logo);
    $team->delete();
    return $team;
  }
}
