<?php

namespace App\Http\Resources\Standings;

use Illuminate\Http\Resources\Json\JsonResource;

class StandingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if ($request->routeIs('change.pool')) {
            return [
                'pool'      => $this->pool,
                'updatedAt' => $this->updated_at
            ];
        } else {
            return [
                'id'        => $this->id,
                'teamName'  => $this->team_name,
                'gender'    => $this->gender,
                'pool'      => $this->pool,
                'totalWin'  => $this->total_win,
                'totalLose' => $this->total_lose,
                'totalMatch' => $this->total_match,
                'winrate'   => $this->winrate,
                'createdAt' => $this->created_at,
                'updatedAt' => $this->updated_at,
            ];
        }
    }
}
