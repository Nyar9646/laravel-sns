<?php
// 「フォームリクエスト」 : 更新や登録で利用する共通な validation 設定

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    // return false = return brows 403 err & not exec action method.
    // 使い方 ex：ユーザが更新して良いか(他ユーザの記事を更新させないなど *1)
    //  *1 : 当appでは「ポリシー」機能で実装
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    // validation rules.
    public function rules()
    {
        return [
            'title' => 'required|max:50',
            'body' => 'required|max:500',
            // json かどうかのバリデーション
            'tags' => 'json|regex:/^(?!.*\s).+$/u|regex:/^(?!.*\/).*$/u',
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'タイトル',
            'body' => '本文',
            'tags' => 'タグ',
        ];
    }

    /**
     * 変換 json形式(vue tags input で使用) ⇨ 連想配列形式(Laravel で使用)
     * json形式から設定値である text のみ取得
     * ex json形式 : "[{"text":"USA","tiClasses":["ti-valid"]},{"text":"France","tiClasses":["ti-valid"]}]"
     */
    public function passedValidation()
    {
        $this->tags = collect(json_decode($this->tags))
            ->slice(0, 5)
            ->map(function ($requestTag) {
                return $requestTag->text;
            });
    }
}
