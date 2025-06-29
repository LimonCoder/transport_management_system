<?php

namespace App\Http\Requests\V2\Route;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Libraries\ApiResponse;
use Illuminate\Support\Facades\Auth;

class StoreRouteRequest extends FormRequest
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
            'title' => 'required|string|max:150',
            'details' => 'required|string',
            'created_by' => 'required|integer|exists:users,id',
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
            'title' => 'route title',
            'details' => 'route details',
            'created_by' => 'created by user',
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
            'title.required' => 'The route title is required.',
            'title.max' => 'The route title may not be greater than 150 characters.',
            'details.required' => 'The route details are required.',
            'created_by.exists' => 'The selected user does not exist.',
        ];
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
            ApiResponse::errorResponse('Validation failed',422,$validator->errors())
        );
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        // Automatically set org_code from authenticated user and default status to active
        $this->merge([
            'org_code' => Auth::user()->org_code ?? null,
            'status' => 'active', // Always set status to active for new routes
        ]);
    }
} 