<?php

namespace App\Http\Requests\V2\Trip;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Libraries\ApiResponse;

class CancelTripRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // You can add authorization logic here
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'trip_id' => 'required|integer|exists:trips,id',
            'reason' => 'required|string|min:10|max:255',
            'cancelled_by' => 'nullable|string|max:100',
            'cancellation_notes' => 'nullable|string|max:500',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'trip_id' => 'trip',
            'reason' => 'cancellation reason',
            'cancelled_by' => 'cancelled by',
            'cancellation_notes' => 'cancellation notes',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'trip_id.exists' => 'The selected trip does not exist.',
            'reason.required' => 'Cancellation reason is required.',
            'reason.min' => 'Cancellation reason must be at least 10 characters.',
            'reason.max' => 'Cancellation reason cannot exceed 255 characters.',
            'cancelled_by.max' => 'Cancelled by field cannot exceed 100 characters.',
            'cancellation_notes.max' => 'Cancellation notes cannot exceed 500 characters.',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            // Validate trip can be cancelled
            $trip = $this->getTripDetails();
            
            if (!$trip) {
                $validator->errors()->add('trip_id', 'Trip not found.');
                return;
            }

            // Check if trip is already cancelled
            if ($trip->status === 'cancelled') {
                $validator->errors()->add('trip_id', 'Trip is already cancelled.');
            }

            // Check if trip is completed
            if ($trip->status === 'completed') {
                $validator->errors()->add('trip_id', 'Cannot cancel a completed trip.');
            }

            // Check if trip is locked
            if ($trip->is_locked) {
                $validator->errors()->add('trip_id', 'Cannot cancel a locked trip.');
            }

            // Check if trip has started (optional business rule)
            if ($trip->start_time && \Carbon\Carbon::parse($trip->start_time)->isPast()) {
                // You might want to allow or disallow cancellation of trips that have started
                // This is commented out as it depends on business requirements
                // $validator->errors()->add('trip_id', 'Cannot cancel a trip that has already started.');
            }

            // Validate reason against predefined reasons (optional)
            $validReasons = [
                'weather conditions',
                'vehicle breakdown',
                'driver unavailable',
                'passenger request',
                'route blocked',
                'emergency',
                'administrative decision',
                'other'
            ];

            // If you want to restrict to predefined reasons, uncomment below
            // $reasonLower = strtolower($this->reason);
            // if (!in_array($reasonLower, $validReasons) && !str_contains($reasonLower, 'other')) {
            //     $validator->errors()->add('reason', 'Please provide a valid cancellation reason.');
            // }
        });
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            ApiResponse::validationError($validator->errors(), 'Trip cancellation validation failed')
        );
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        // Clean and prepare data before validation
        $this->merge([
            'reason' => $this->reason ? trim($this->reason) : null,
            'cancelled_by' => $this->cancelled_by ? trim($this->cancelled_by) : null,
            'cancellation_notes' => $this->cancellation_notes ? trim($this->cancellation_notes) : null,
        ]);
    }

    /**
     * Get trip details for validation
     *
     * @return \App\Models\V2\Trip|null
     */
    private function getTripDetails()
    {
        try {
            return \App\Models\V2\Trip::find($this->trip_id);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Get the validated data with additional processed fields
     *
     * @return array
     */
    public function validated()
    {
        $validated = parent::validated();
        
        // Add timestamp and user info
        $validated['cancelled_at'] = \Carbon\Carbon::now();
        $validated['cancelled_by'] = $validated['cancelled_by'] ?? auth()->user()->name ?? 'System';
        
        return $validated;
    }
} 