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
            'custom_jenis_kejadian' => 'required_if:jenis_kejadian,Lain Lain|nullable|string|max:100',
            'kronologi' => 'required',
            'lokasi' => 'required',
            'custom_lokasi' => 'required_if:lokasi,Lain Lain|nullable|string|max:100',
            'tanggal_waktu' => 'required',
            'nama_personel' => 'required',
            'regu' => 'required',
            'shift' => 'required',

            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ];
    }
}
