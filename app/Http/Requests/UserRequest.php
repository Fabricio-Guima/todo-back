<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $id = $this->segment(3);

        $rules = [
            'name' => ['required', 'string', 'min:3', 'max:100'],
            'password' => ['required', 'min:6', 'max:16'],
            'email' => ['required', 'email', 'max:255', "unique:users,email,{$id},id"],
        ];

        if ($this->method() == 'PUT') {
            $rules['password'] = ['nullable', 'min:6', 'max:16'];
        }

        return $rules;
    }
}
