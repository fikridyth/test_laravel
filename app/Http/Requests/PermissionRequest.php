<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PermissionRequest extends FormRequest
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
        if (request()->routeIs('permission.store')) {
            $id = 'required|numeric|min:1|max:100000|unique:permissions,id';
            $name = 'required|string|alpha_dash|min:2|max:50|unique:permissions,name';
        } elseif (request()->routeIs('permission.update')) {
            $id = [
                'required',
                'numeric',
                'min:1',
                'max:100000',
                Rule::unique('permissions', 'id')->ignore($this->id)
            ];
            $name = [
                'required',
                'string',
                'alpha_dash',
                'min:2',
                'max:50',
                Rule::unique('permissions', 'name')->ignore($this->id)
            ];
        }

        return [
            'id' => $id,
            'name' => $name,
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Nama akses',
        ];
    }
}
