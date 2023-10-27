<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        $id = optional($this->route('user'))->id;
        $required = $this->route('user') ? 'nullable': 'required';        

        return [
            'name' => 'required', 
            'email' => ['required','email','unique:users,email,'. $id],
            'default_password' => $required.'|min:8',
            'image_link' => 'required|url:http,https',
        ];
    }
}
