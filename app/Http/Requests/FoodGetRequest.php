<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use function Laravel\Prompts\error;

class FoodGetRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'search' => 'string|nullable',
            'per_page' => 'integer|nullable',
            'sort_by' => ['string', 'nullable', Rule::in([
                'name',
                'calories',
                'carb',
                'protein',
                'fat',
                'created_at',
                'updated_at'
            ])],
            'sort_direction' => ['string', 'nullable', Rule::in(['asc', 'desc'])],
        ];
    }

    // Failed validation method
    public $validator = null;

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $this->validator = $validator;
    }
}
