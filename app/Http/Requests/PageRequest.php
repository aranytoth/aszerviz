<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PageRequest extends FormRequest
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
            'Page.title' => 'required',
            'Page.status' => 'required',
            'Page.content' => 'required_if:Page.status,10'
        ];
    }

    public function messages(): array
    {
        return [
            'Page.title.required' => 'A cím megadása kötelező.',
            'Page.content.required_if' => 'Élesített oldalnál tartalom megadása kötelező',
        ];
    }
}
