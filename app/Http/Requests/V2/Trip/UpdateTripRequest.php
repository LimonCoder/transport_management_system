<?php

namespace App\Http\Requests\V2\Trip;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Libraries\ApiResponse;

class UpdateTripRequest extends FormRequest
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
            'route_id' => 'required|integer|exists:routes,id',
            'driver_id' => 'required|integer|exists:driver_info,id',
            'driver_name' => 'required|string|max:100',
            'vehicle_id' => 'required|integer|exists:vehicle_setup,id',
            'vehicle_registration_number' => 'required|string|max:50',
            'trip_initiate_date' => 'required|date',
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
            'route_id' => 'route',
            'driver_id' => 'driver',
            'vehicle_id' => 'vehicle',
            'vehicle_registration_number' => 'vehicle registration number',
            'trip_initiate_date' => 'trip initiate date',
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
            'route_id.exists' => 'The selected route does not exist.',
            'driver_id.exists' => 'The selected driver does not exist.',
            'vehicle_id.exists' => 'The selected vehicle does not exist.',
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
            // Custom validation logic for trip_initiate_date
            if ($this->filled('trip_initiate_date')) {
                $initiateDate = \Carbon\Carbon::parse($this->trip_initiate_date);
                $today = \Carbon\Carbon::today();
                
                // Allow past dates for updates (trip might have been already initiated)
                // But validate if the date is not too far in the past (business rule)
                $minAllowedDate = $today->copy()->subDays(30); // Allow up to 30 days in the past
                
                if ($initiateDate->lt($minAllowedDate)) {
                    $validator->errors()->add('trip_initiate_date', 'Trip initiate date cannot be more than 30 days in the past.');
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
            ApiResponse::validationError($validator->errors(), 'Validation failed')
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
            'trip_initiate_date' => $this->trip_initiate_date ? \Carbon\Carbon::parse($this->trip_initiate_date)->format('Y-m-d') : null,
        ]);
    }


} 