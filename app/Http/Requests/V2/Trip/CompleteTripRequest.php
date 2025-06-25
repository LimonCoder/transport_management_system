<?php

namespace App\Http\Requests\V2\Trip;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Libraries\ApiResponse;

class CompleteTripRequest extends FormRequest
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
            'end_time' => 'required|date|after_or_equal:' . $this->getTripStartTime(),
            'distance_km' => 'nullable|numeric|min:0|max:9999.99',
            'fuel_cost' => 'nullable|numeric|min:0|max:999999.99',
            'total_cost' => 'nullable|numeric|min:0|max:999999.99',
            'actual_destination' => 'nullable|string|max:255',
            'completion_notes' => 'nullable|string|max:500',
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
            'end_time' => 'completion time',
            'distance_km' => 'actual distance (km)',
            'fuel_cost' => 'actual fuel cost',
            'total_cost' => 'total cost',
            'actual_destination' => 'actual destination',
            'completion_notes' => 'completion notes',
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
            'end_time.required' => 'Completion time is required.',
            'end_time.after_or_equal' => 'Completion time must be after or equal to the trip start time.',
            'distance_km.max' => 'The distance cannot exceed 9999.99 km.',
            'fuel_cost.max' => 'The fuel cost cannot exceed 999,999.99.',
            'total_cost.max' => 'The total cost cannot exceed 999,999.99.',
            'completion_notes.max' => 'Completion notes cannot exceed 500 characters.',
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
            // Validate trip can be completed
            $trip = $this->getTripDetails();
            
            if (!$trip) {
                $validator->errors()->add('trip_id', 'Trip not found.');
                return;
            }

            // Check if trip is already completed
            if ($trip->status === 'completed') {
                $validator->errors()->add('trip_id', 'Trip is already completed.');
            }

            // Check if trip is cancelled
            if ($trip->status === 'cancelled') {
                $validator->errors()->add('trip_id', 'Cannot complete a cancelled trip.');
            }

            // Check if trip is locked
            if ($trip->is_locked) {
                $validator->errors()->add('trip_id', 'Cannot complete a locked trip.');
            }

            // Validate total cost vs fuel cost
            if ($this->filled('total_cost') && $this->filled('fuel_cost')) {
                if ($this->total_cost < $this->fuel_cost) {
                    $validator->errors()->add('total_cost', 'Total cost cannot be less than fuel cost.');
                }
            }

            // Validate end time is not too far in the future
            if ($this->filled('end_time')) {
                $endTime = \Carbon\Carbon::parse($this->end_time);
                $maxTime = \Carbon\Carbon::now()->addHours(1); // Allow 1 hour buffer
                
                if ($endTime->gt($maxTime)) {
                    $validator->errors()->add('end_time', 'Completion time cannot be more than 1 hour in the future.');
                }
            }
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
            ApiResponse::validationError($validator->errors(), 'Trip completion validation failed')
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
            'end_time' => $this->end_time ? \Carbon\Carbon::parse($this->end_time)->format('Y-m-d H:i:s') : \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
            'distance_km' => $this->distance_km ? round(floatval($this->distance_km), 2) : null,
            'fuel_cost' => $this->fuel_cost ? round(floatval($this->fuel_cost), 2) : null,
            'total_cost' => $this->total_cost ? round(floatval($this->total_cost), 2) : null,
        ]);
    }

    /**
     * Get trip start time for validation
     *
     * @return string
     */
    private function getTripStartTime()
    {
        try {
            $trip = \App\Models\V2\Trip::find($this->trip_id);
            return $trip ? $trip->start_time->format('Y-m-d H:i:s') : \Carbon\Carbon::now()->format('Y-m-d H:i:s');
        } catch (\Exception $e) {
            return \Carbon\Carbon::now()->format('Y-m-d H:i:s');
        }
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
} 