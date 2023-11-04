<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class StoreBook extends FormRequest
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
            'title' => 'required',
            'author' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'タイトルが未入力です',
            'author.required' => '著書が未入力です'
        ];
    }


    // FormRequestのfailedValidationをオーバーライドしてJsonResponseを返すように変更する

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        $response = response()->json([
            'message' => 'Failed Validation',
            'errors' => $errors,
        ], 422, [], JSON_UNESCAPED_UNICODE);

        throw new HttpResponseException($response);
    }
}
