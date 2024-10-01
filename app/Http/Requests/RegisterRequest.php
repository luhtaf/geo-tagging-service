<?php

namespace App\Http\Requests;

class RegisterRequest extends FormRequest
{
   /**
	* Mendapatkan aturan validasi yang berlaku untuk permintaan ini.
	*
	* @return array
	*/
    public function rules(): array
    {
        return [       
            'username'    => 'required|min:6|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ];
    }

  /**
	* Menentukan apakah pengguna berwenang untuk membuat permintaan ini.
	*
	* @return bool
	*/
    public function authorize()
    {
        return true;
    }

    /**
     * @return array
     * Custom validation message
     */
    public function messages()
    {
        return [
            'username.required'     => 'Silahkan Masukkan username',
			'username.min' => 'Username harus memiliki minimal 6 karakter.',
            'username.unique'      => 'Username sudah digunakan. Silakan coba dengan username lain.',
            'password.required' => 'Silakan masukkan password',
			'password.min' => 'Password harus memiliki minimal 6 karakter.',
        ];
    }
}
