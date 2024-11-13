<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuotesRequest extends FormRequest
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
            /** @query */
            'lang' => ['nullable', 'string', 'in:id,en'],
            'paginate' => ['nullable', 'string', 'in:1,0'],
            'limit' => ['nullable', 'integer']
        ];
    }
}
