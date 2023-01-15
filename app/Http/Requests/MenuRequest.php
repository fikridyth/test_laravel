<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MenuRequest extends FormRequest
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
        if (request()->routeIs('menu.store')) {
            $id = 'required|numeric|min:1|max:100000|unique:menus,id';
            $name = 'required|string|min:2|max:50|unique:menus,name|regex:/^[a-zA-Z0-9\s]+$/';
        } elseif (request()->routeIs('menu.update')) {
            $id = [
                'sometimes',
                'numeric',
                'min:1',
                'max:100000',
                Rule::unique('menus', 'id')->ignore($this->id)
            ];
            $name = [
                'required',
                'string',
                'min:2',
                'max:50',
                'regex:/^[a-zA-Z0-9\s]+$/',
                Rule::unique('menus', 'name')->ignore($this->id)
            ];
        }

        return [
            'id' => $id,
            'name' => $name,
            'route' => 'required|string|max:255',
            'icon' => 'required|string|max:255',
            'order' => 'required|numeric|min:1',
            'parent_id' => 'required|numeric|min:0',
            'roles' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Nama menu',
            'route' => 'Route',
            'icon' => 'Icon',
            'order' => 'Order',
            'roles' => 'Roles',
            'parent_id' => 'Parent',
        ];
    }

    public function messages()
    {
        return [
            'name.regex' => 'Nama menu hanya boleh diisi menggunakan huruf, angka atau spasi saja.'
        ];
    }
}
