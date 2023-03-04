<?php

namespace App\Http\Requests\Schedules;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreScheduleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'team_home_id' => ['required', Rule::exists('teams', 'id')],
            'team_away_id' => ['required', Rule::exists('teams', 'id')],
            'day'          => ['required', 'string', 'max:100'],
            'pool'         => ['required', 'max:1', Rule::notIn(['N'])],
            'time'         => ['required', 'date_format:H:i', Rule::unique('schedules')->where('date', $this->date)],
            'date'         => ['required', 'date_format:Y-m-d'],
        ];
    }
}
