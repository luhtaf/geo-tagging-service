<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PenetapanPelaksanaanRequest extends FormRequest
{
    
	/**
	* Mendapatkan aturan validasi yang berlaku untuk permintaan ini.
	*
	* @return array
	*/
    public function rules(): array
    {
        return [
            //
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

}
