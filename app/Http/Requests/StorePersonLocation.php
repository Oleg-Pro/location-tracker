<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePersonLocation extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'person_id' => ['required',   Rule::exists('people', 'id')->where(function ($query) {
                $query->where('user_id', $this->user()->id);
            })],
            'latitude' => 'required:numeric:between:-90,90',
            'longitude' => 'required:numeric:between:-180,180'
        ];
    }
}
