<?php

namespace App\Http\Requests\V1\Machine;

use Illuminate\Foundation\Http\FormRequest;

class AddHoursRequest extends FormRequest
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
            'hours' => ['required', 'numeric', 'decimal:0,2', 'gt:0', 'max:72'],
        ];
    }
}
