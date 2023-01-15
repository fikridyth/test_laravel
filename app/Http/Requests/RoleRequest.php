<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if (request()->routeIs('role.store')) {
            $id = 'required|numeric|min:1|max:100|unique:roles,id';
            $name = 'required|string|min:2|max:50|unique:roles,name|regex:/^[a-zA-Z0-9\s]+$/';
        } elseif (request()->routeIs('role.update')) {
            $id = [
                'sometimes',
                'numeric',
                'min:1',
                'max:100',
                Rule::unique('roles', 'id')->ignore($this->id)
            ];
            $name = [
                'required',
                'string',
                'min:2',
                'max:50',
                'regex:/^[a-zA-Z0-9\s]+$/',
                Rule::unique('roles', 'name')->ignore($this->id)
            ];
        }
        
        return [
            'id' => $id,
            'name' => $name,
            'permissions' => 'required|array',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Nama role',
            'permissions' => 'Permission',
        ];
    }

    public function messages()
    {
        return [
            'permissions.required' => 'Permission wajib dipilih minimal 1.',
            'name.regex' => 'Nama role hanya boleh diisi menggunakan huruf, angka atau spasi saja.'
        ];
    }
}
