<?php

namespace App\Http\Requests\Teams;

use App\Rules\EnumRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTeamRequest extends FormRequest
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
            'team_name'     => ['required', 'string', 'max:100', Rule::unique('teams')->where('team_gender', $this->team_gender)],
            'team_logo'     => ['required', 'image', 'mimes:jpg,jpeg,png'],
            'team_gender'   => ['required', new EnumRule(['Putra', 'Putri'])]
        ];
    }
}
