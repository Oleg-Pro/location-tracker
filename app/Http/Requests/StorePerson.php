<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePerson extends FormRequest
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
        if ($this->method() == 'PATCH') {
            return [
                'city_id' => 'required_without_all:first_name,second_name,last_name,email,phone|exists:cities,id',
                'first_name' => 'required_without_all:city_id,second_name,last_name,email,phone|max:50',
                'second_name' => 'required_without_all:first_name,city_id,last_name,email,phone|max:50',
                'last_name' => 'required_without_all:first_name,second_name,city_id,email,phone|max:50',
                'email' => 'required_without_all:first_name,second_name,last_name,city_id,phone|nullable|email|max:255',
                'phone' => 'required_without_all:first_name,second_name,last_name,email,city_id|max:20',
            ];
        }

        return [
            'city_id' => 'required|exists:cities,id',
            'first_name' => 'required|max:50',
            'second_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'email' => 'nullable|email|max:255',
            'phone' => 'max:20',
        ];
    }
}
