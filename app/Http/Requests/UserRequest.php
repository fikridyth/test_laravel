<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        if (request()->routeIs('manajemen-user.store')) {
            $nrik = 'required|digits:8|unique:users,nrik';
            $email = 'required|email|unique:users,email';
        } elseif (request()->routeIs('manajemen-user.update')) {
            $nrik = [
                'required',
                'digits:8',
                Rule::unique('users', 'nrik')->ignore($this->user)
            ];
            $email = [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($this->user)
            ];
        }

        return [
            'id_role' => 'required|array|min:1',
            'id_role.*' => 'required|numeric',
            'name' => 'required|regex:/^[\pL\s\-]+$/u',
            'nrik' => $nrik,
            'email' => $email,
            'tanggal_lahir' => 'required|date',
            'id_unit_kerja' => 'required|numeric',
        ];
    }

    public function attributes()
    {
        return [
            'id_role' => 'Role',
            'name' => 'Nama',
            'nrik' => 'NRIK',
            'email' => 'Email',
            'tanggal_lahir' => 'Tanggal lahir',
            'id_unit_kerja' => 'Unit kerja',
        ];
    }

    public function messages()
    {
        return [
            'name.regex' => 'Nama hanya boleh diisi menggunakan huruf atau spasi saja.'
        ];
    }
}
