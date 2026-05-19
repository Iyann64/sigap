<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKejadianRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'jenis_kejadian' => 'required',
            'kronologi' => 'required',
            'lokasi' => 'required',
            'tanggal_waktu' => 'required',
            'nama_personel' => 'required',
            'regu' => 'required',
            'shift' => 'required',

            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ];
    }
}
