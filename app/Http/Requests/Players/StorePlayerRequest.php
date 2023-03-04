<?php

namespace App\Http\Requests\Players;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePlayerRequest extends FormRequest
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
            'teams_id'  => ['required', 'max:255',Rule::exists('teams', 'id')],
            'name'      => ['required', 'string', 'max:255'],
            'number'    => ['required', 'max:255', Rule::unique('players')->where('teams_id', $this->teams_id)],
            'position'  => ['required', 'string', 'max:255'],
            'height'    => ['required'],
            'weight'    => ['required'],
            'age'       => ['required'],
        ];
    }
}
