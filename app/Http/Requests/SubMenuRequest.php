<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubMenuRequest extends FormRequest
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
        return [
            'nama' => 'required|max:100|regex:/^[\pL\s\-]+$/u|unique:tbl_master_submenu,nama',
            'id_menu' => 'required|numeric',
            'link' => 'required|unique:tbl_master_submenu,link',
            'urutan' => 'required|numeric',
        ];
    }

    public function attributes()
    {
        return [
            'nama' => 'Nama submenu',
            'link' => 'Link',
            'urutan' => 'Urutan submenu',
        ];
    }

    public function messages()
    {
        return [
            'nama.regex' => 'Nama submenu hanya boleh diisi dengan huruf dan spasi saja.'
        ];
    }
}
