<?php

namespace App\Http\Requests\V2\Organization;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Libraries\ApiResponse;
use Illuminate\Support\Facades\Auth;

class StoreOrganizationRequest extends FormRequest
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
            'name' => 'required|string|max:100',
            'address' => 'nullable|string|max:200',
            'org_type' => 'required|in:university,college',
            'organization_code' => 'required|numeric|unique:organizations,org_code|digits_between:3,6',
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
            'name' => 'organization name',
            'address' => 'organization address',
            'org_type' => 'organization type',
            'organization_code' => 'organization code',
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
            'name.required' => 'The organization name is required.',
            'name.max' => 'The organization name may not be greater than 100 characters.',
            'address.max' => 'The organization address may not be greater than 200 characters.',
            'org_type.required' => 'The organization type is required.',
            'org_type.in' => 'The organization type must be either university or college.',
            'organization_code.required' => 'The organization code is required.',
            'organization_code.numeric' => 'The organization code must be a number.',
            'organization_code.unique' => 'The organization code has already been taken.',
            'organization_code.digits_between' => 'The organization code must be between 3 and 6 digits.',
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
        // Automatically set created_by from authenticated user
        $this->merge([
            'created_by' => Auth::user()->id ?? 1,
        ]);
    }
} 