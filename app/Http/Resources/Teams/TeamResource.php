<?php

namespace App\Http\Resources\Teams;

use App\Http\Resources\Players\PlayerResource;
use App\Http\Resources\Schedules\ScheduleResource;
use App\Http\Resources\Standings\StandingResource;
use Illuminate\Http\Resources\Json\JsonResource;

class TeamResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if ($request->routeIs('players.show')) {
            return    [
                'teamName'      => $this->team_name,
                'teamGender'    => $this->team_gender,
                'players'       => PlayerResource::collection($this->whenLoaded('players'))
            ];
        } else if ($request->routeIs('schedules.show')) {
            return [
                'teamName'      => $this->team_name,
                'teamGender'    => $this->team_gender,
                'homeSchedules' => ScheduleResource::collection($this->whenLoaded('homeSchedules')),
                'awaySchedules' => ScheduleResource::collection($this->whenLoaded('awaySchedules'))
            ];
        } else {
            return [
                'id'            => $this->id,
                'teamName'      => $this->team_name,
                'slug'          => $this->slug,
                'teamLogo'      => asset("/storage/images/teams/$this->team_logo"),
                'teamGender'    => $this->team_gender,
                'createdAt'     => $this->created_at,
                'updatedAt'     => $this->updated_at,
            ];
        }
    }
}
