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
                'homeId'            => $this->team_home_id,
                'awayId'            => $this->team_away_id,
                'pool'              => $this->pool,
                'day'               => $this->day,
                'time'              => Carbon::createFromFormat('H:i:s', $this->time)->format('H:i'),
                'date'              => Carbon::createFromFormat('Y-m-d', $this->date)->format('d-m-Y'),
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
            'time'          => Carbon::createFromFormat('H:i:s', $this->time)->format('H:i'),
            'date'          => Carbon::createFromFormat('Y-m-d', $this->date)->format('d-m-Y'),
            'pool'          => $this->pool,
            'createdAt'     => $this->created_at,
            'updatedAt'     => $this->updated_at
        ];
    }
}
