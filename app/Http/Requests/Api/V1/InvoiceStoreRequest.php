<?php

namespace App\Http\Requests\Api\V1;

use App\Enums\InvoiceTypeEnum;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class InvoiceStoreRequest extends FormRequest
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
            'user_id' => ['required', 'exists:users,id'],
            'type' => Rule::in(InvoiceTypeEnum::values()),
            'paid' => ['required', 'numeric', 'between:0,1'],
            'value' => ['required', 'numeric', 'between:0,99999.99'],
            'payment_date' => ['nullable', 'date'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Os dados informados não são válidos.',
            'data' => $validator->errors(),
        ], 422));
    }
}
