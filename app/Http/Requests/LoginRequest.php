<?php

namespace App\Http\Requests;


class LoginRequest extends FormRequest
{
    /**
	* Mendapatkan aturan validasi yang berlaku untuk permintaan ini.
	*
	* @return array
	*/
    public function rules(): array
    {
        return [
            'username'    => 'required',
            'password' => 'required|min:6',
        ];
    }

   /**
	* Menentukan apakah pengguna berwenang untuk membuat permintaan ini.
	*
	* @return bool
	*/
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Custom validation message
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'username.required'    => 'Silahkan Masukkan username',
            'password.required' => 'Silahkan Masukkan password',
        ];
    }
}
