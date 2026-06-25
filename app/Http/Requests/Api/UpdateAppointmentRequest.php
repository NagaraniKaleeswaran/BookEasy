<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'service_id' => 'sometimes|exists:services,id',
            'appointment_date' => 'sometimes|date|after_or_equal:today',
            'appointment_time' => 'sometimes|date_format:H:i',
            'customer_name' => 'sometimes|string|max:255',
            'customer_email' => 'sometimes|email|max:255',
            'customer_phone' => 'sometimes|string|max:20',
            'notes' => 'nullable|string',
            'status' => 'sometimes|string|in:pending,confirmed,completed,cancelled',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation Error.',
            'errors' => $validator->errors()
        ], 422));
    }
}
