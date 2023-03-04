<?php

namespace App\Http\Requests\Players;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePlayerRequest extends FormRequest
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
            'teams_id'  => [Rule::requiredIf($this->has($this->input('teams_id'))), 'max:255', Rule::exists('teams', 'id')],
            'name'      => [Rule::requiredIf($this->has($this->input('name'))), 'string', 'max:255'],
            'number'    => [Rule::requiredIf($this->has($this->input('number'))), 'max:255', Rule::unique('players')->where('teams_id', $this->teams_id)],
            'position'  => [Rule::requiredIf($this->has($this->input('position'))), 'string', 'max:255'],
            'height'    => [Rule::requiredIf($this->has($this->input('height')))],
            'weight'    => [Rule::requiredIf($this->has($this->input('weight')))],
            'age'       => [Rule::requiredIf($this->has($this->input('age')))],
        ];
    }
}
