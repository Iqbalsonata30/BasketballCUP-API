<?php

namespace App\Services;

use App\Http\Requests\Schedules\StoreScheduleRequest;
use App\Models\Schedule;
use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScheduleServices
{
  public function getSchedules(Request $request)
  {
    $now = Carbon::now()->format('Y-m-d');
    $date = $request->query('date', $now);
    $schedules = DB::table('schedules')
      ->leftJoin('teams as home', 'schedules.team_home_id', '=', 'home.id')
      ->leftJoin('teams as away', 'schedules.team_away_id', '=', 'away.id')
      ->whereDate('date', '=', $date)
      ->selectRaw('
            schedules.id,
            home.id AS team_home_id,
            away.id as team_away_id,
            home.team_name AS team_home,
            away.team_name as team_away,
            away.team_gender as team_gender,
            schedules.day,
            schedules.date,
            schedules.time,
            schedules.pool,
            schedules.created_at,
            schedules.updated_at')
      ->get();

    return $schedules;
  }

  public function createSchedule(StoreScheduleRequest $request): Schedule
  {
    $schedule = Schedule::create($request->validated());
    return $schedule;
  }

  public function getSpecificSchedule(Request $request, string $slug)
  {
    $teamGender = $request->query('gender', 'Putra');
    $schedules = Team::with(['homeSchedules', 'awaySchedules'])
      ->where(['slug' => $slug, 'team_gender' => $teamGender])
      ->get();
    return $schedules;
  }

  public function deleteSchedule(int $id)
  {
    $schedule = Schedule::findOrFail($id);
    $schedule->delete();
    return $schedule;
  }
}
