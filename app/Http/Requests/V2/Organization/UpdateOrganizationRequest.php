<?php

namespace App\Http\Requests\V2\Organization;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Libraries\ApiResponse;
use Illuminate\Support\Facades\Auth;

class UpdateOrganizationRequest extends FormRequest
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
            'organization_id' => 'required|integer|exists:organizations,id',
            'name' => 'required|string|max:100',
            'address' => 'nullable|string|max:200',
            'org_type' => 'required|in:university,college',
            'updated_by' => 'required|integer|exists:users,id',
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
            'organization_id' => 'organization',
            'name' => 'organization name',
            'address' => 'organization address',
            'org_type' => 'organization type',
            'updated_by' => 'updated by user',
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
            'organization_id.exists' => 'The selected organization does not exist.',
            'name.required' => 'The organization name is required.',
            'name.max' => 'The organization name may not be greater than 100 characters.',
            'address.max' => 'The organization address may not be greater than 200 characters.',
            'org_type.required' => 'The organization type is required.',
            'org_type.in' => 'The organization type must be either university or college.',
            'updated_by.exists' => 'The selected user does not exist.',
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
        // Automatically set updated_by from authenticated user
        $this->merge([
            'updated_by' => Auth::user()->id ?? 1,
        ]);
    }
} 