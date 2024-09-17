<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\user\ProfileController as UserProfileController;

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
        return [
            'name' => 'required| max:255',
            'name_kana' => 'required| max:255',
            'email' => 'required| max:255',
            'profile_image' => 'nullable|image|max:2048',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'ユーザーネーム',
            'name_kana' => 'ユーザーネーム カナ',
            'email' => 'メールアドレス',
            'profile_image' =>'プロフィール画像'
        ];
    }

    public function messages() {
        return [
            'name.required' => 'attributeは入力必須項目です。',
            'name.max' => ':attributeは:max字以内で入力してください。',
            'name_kana.required' => 'attributeは入力必須項目です。',
            'name_kana.max' => 'attributeは:max字以内で入力してください。',
            'email.required' => 'attributeは入力必須項目です。',
            'email.max' => 'attributeは:max字以内で入力してください。',
        ];
    }
    
}
