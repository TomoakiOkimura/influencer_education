<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\admin\ArticleController as AdminArticleController;

class ArticleRequest extends FormRequest
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
            'posted_date' => 'required',
            'title' => 'required | max:255',
            'article_contents' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'posted_date' => '投稿日時',
            'title' => 'タイトル',
            'article_contents' => '本文',
        ];
    }

    public function messages() {
        return [
            'posted_date.required' => 'attributeは入力必須項目です。',
            'title.required' => 'attributeは入力必須項目です。。',
            'title.max' => ':attributeは:max字以内で入力してください。',
            'article_contents.required' => 'attributeは入力必須項目です。。',
        ];
    }
    
}
