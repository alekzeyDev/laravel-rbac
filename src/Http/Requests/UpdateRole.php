<?php

namespace Itstructure\LaRbac\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateRole
 *
 * @package Itstructure\LaRbac\Http\Requests
 *
 * @author Andrey Girnik <girnikandrey@gmail.com>
 */
class UpdateRole extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return !empty(config('rbac.routesMainPermission')) ? $this->user()->can(config('rbac.routesMainPermission')) : true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->route('role')->id;
        return [
            'name' => [
                'required',
                'string',
                'regex:/^[\w\s\-]+$/',
                'min:3',
                'max:191',
                Rule::unique('roles')->where('id', '<>', $id),
            ],
            'description' => [
                'required',
                'string',
                'min:3',
                'max:191',
                Rule::unique('roles')->where('id', '<>', $id),
            ],
            'permissions' => 'required|array',
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
            'required' => __('rbac::validation.required'),
            'string' => __('rbac::validation.string'),
            'regex' => __('rbac::validation.regex'),
            'min' => __('rbac::validation.min'),
            'max' => __('rbac::validation.max'),
            'unique' => __('rbac::validation.unique'),
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
            'name' => __('rbac::main.name'),
            'description' => __('rbac::main.description'),
            'permissions' => __('rbac::permissions.permissions'),
        ];
    }
}
