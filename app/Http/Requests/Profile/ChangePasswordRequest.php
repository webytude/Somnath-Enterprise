<?php

namespace App\Http\Requests\profile;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
        return [
            'old_password' => 'required',
            'password' => 'required|min:6|max:15',
            'confirm_password' => 'required|same:password',
        ];
    }

    public function messages()
    {
        return [
            'confirm_password.same' => 'New password and confirm new password does not match.',
            'password.required' => 'New password is required.',
        ];
    }
}
