<?php

namespace App\Services;

use App\Http\Requests\Players\StorePlayerRequest;
use App\Http\Requests\Players\UpdatePlayerRequest;
use App\Models\Player;
use App\Models\Team;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class PlayerServices
{
  public function createPlayer(StorePlayerRequest $request): Player
  {
    return Player::create($request->validated());
  }

  public function updatePlayer(UpdatePlayerRequest $request, int $id): Player
  {
    $player = Player::findOrFail($id);
    $player->update($request->validated());
    return $player;
  }

  public function getPlayer(Request $request, string $slug): Collection
  {
    $teamGender = $request->query('gender', 'Putra');
    $player = Team::with('players')->where(['slug' => $slug, 'team_gender' => $teamGender])->get();
    return $player;
  }


  public function deletePlayer(int $id): Player
  {
    $player = Player::findOrFail($id);
    $player->delete();
    return $player;
  }
}
