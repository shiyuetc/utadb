<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
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
            'password_old' => [
                'required',
                function ($attribute, $value, $fail) {
                    $password = User::select('password')->find(auth()->user()->id);
                    if(!password_verify($value, $password["password"])) {
                        return $fail('現在のパスワードが一致しませんでした');
                    }
                }
            ],
            'password' => 'required|confirmed|min:6',
        ];
    }
}
