<?php

namespace App\Http\Requests\Api\V1;

use App\Enums\InvoiceTypeEnum;
use App\Traits\HttpResponses;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class InvoiceUpdateRequest extends FormRequest
{
    use HttpResponses;
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
            'user_id' => 'required|exists:users,id',
            'type' => ['required', Rule::in(InvoiceTypeEnum::values())],
            'paid' => 'required|numeric|between:0,1',
            'amount' => 'required|numeric|between:0,99999.99',
            'payment_date' => 'nullable|date_format:Y-m-d H:i:s',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $this->error('Os Dados informados são inválidos', 422, $validator->errors());
    }
}
