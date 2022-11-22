<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        return [
            'nama' => 'required|max:100|regex:/^[\pL\s\-]+$/u|unique:tbl_master_menu,nama',
            'link' => 'required',
            'urutan' => 'required|numeric|unique:tbl_master_menu,urutan',
        ];
    }

    public function attributes()
    {
        return [
            'nama' => 'Nama menu',
            'link' => 'Link',
            'urutan' => 'Urutan menu',
        ];
    }

    public function messages()
    {
        return [
            'nama.regex' => 'Nama Menu hanya boleh diisi dengan huruf dan spasi saja.'
        ];
    }
}
