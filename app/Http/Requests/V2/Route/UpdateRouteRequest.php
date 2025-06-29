<?php

namespace App\Http\Requests\V2\Route;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Libraries\ApiResponse;
use Illuminate\Support\Facades\Auth;

class UpdateRouteRequest extends FormRequest
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
            'route_id' => 'required|integer|exists:routes,id',
            'title' => 'required|string|max:150',
            'details' => 'required|string',
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
            'route_id' => 'route',
            'title' => 'route title',
            'details' => 'route details',
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
            'route_id.exists' => 'The selected route does not exist.',
            'title.required' => 'The route title is required.',
            'title.max' => 'The route title may not be greater than 150 characters.',
            'details.required' => 'The route details are required.',
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
        // Automatically set org_code from authenticated user
        $this->merge([
            'org_code' => Auth::user()->org_code ?? null,
        ]);
    }
} 