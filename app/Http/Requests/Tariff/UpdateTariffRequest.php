<?php

namespace App\Http\Requests\Tariff;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTariffRequest extends FormRequest
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
        $id = $this->route('tariff');
        return [
            'name' => ['sometimes', 'string', 'max:50', Rule::unique('tariffs', 'name')->ignore($id)],
            'max_users' => ['sometimes', 'integer', 'min:1', 'max:1000000'],
            'price' => ['sometimes', 'numeric', 'min:0', 'max:1000000'],
        ];
    }
}
