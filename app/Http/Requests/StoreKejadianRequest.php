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
            'jenis_kejadian' => 'required|string|max:100',
            'kronologi' => 'required|string',
            'lokasi' => 'required|string|max:100',
            'tanggal_waktu' => 'required|date',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'nama_personel' => 'required|string|max:150',
            'regu' => 'required|string|max:50',
            'shift' => 'required|string|max:50',
        ];
    }
}
