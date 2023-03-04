<?php

namespace App\Http\Resources\Schedules;

use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if ($request->routeIs('schedules.show')) {
            return [
                'scheduleId'        => $this->id,
                'home'            => optional($this->homeTeam)->team_name,
                'away'            => optional($this->awayTeam)->team_name,
                'pool'              => $this->pool,
                'day'               => $this->day,
                'time'              => $this->getTime(),
                'date'              => $this->getDate(),
                'createdAt'         => $this->created_at,
                'updatedAt'         => $this->updated_at
            ];
        }
        return [
            'id'            => $this->id,
            'homeId'        => $this->team_home_id,
            'awayId'        => $this->team_away_id,
            'home'          => $this->team_home,
            'away'          => $this->team_away,
            'teamGender'    => $this->team_gender,
            'day'           => $this->day,
            'time'          => $this->getTime(),
            'date'          => $this->getDate(),
            'pool'          => $this->pool,
            'createdAt'     => $this->created_at,
            'updatedAt'     => $this->updated_at
        ];
    }

    public function with($request)
    {
        return [
            'homeTeam' => $this->homeTeam,
            'awayTeam' => $this->awayTeam,
        ];
    }
    private function getTime()
    {
        return Carbon::parse($this->time)->format('H:i');
    }

    private function getDate()
    {
        return Carbon::parse($this->date)->format('d-m-Y');
    }
}
