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
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
        ];

        if ($this->method === 'PUT') {
            $rules['password'] = ['required', 'confirmed', \Rules\Password::defaults()];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'email.unique' => 'Este e-mail já está em uso!',
        ];
    }
}
