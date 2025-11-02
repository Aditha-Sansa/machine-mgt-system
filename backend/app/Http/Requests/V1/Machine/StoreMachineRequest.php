<?php

namespace App\Http\Requests\V1\Machine;

use Illuminate\Foundation\Http\FormRequest;

class StoreMachineRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'purchase_date' => ['required', 'date'],
            'purchase_price' => ['required', 'numeric', 'decimal:0,2', 'min:0'],
            'category' => ['required', 'string', 'max:255'],
            'brand' => ['required', 'string', 'max:255']
        ];
    }
}
