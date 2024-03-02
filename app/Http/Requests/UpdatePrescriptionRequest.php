<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;

use App\Enums\Prescription_status;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePrescriptionRequest extends FormRequest
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
            'delivery_address' => 'string|max:255',
            'attachment' => 'array|max:5',
            'attachment.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', 
            'status'      => ['string', Rule::in(array_column(Prescription_status::cases(), 'value'))],
            'notes' => 'nullable|string',
            'total_amount' => 'numeric|min:0',
            
        ];

    }
}
