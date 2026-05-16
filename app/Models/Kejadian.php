<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Kejadian extends Model
{
    use HasFactory;

    // Tambahkan ini agar Laravel mencari tabel 'kejadian', bukan 'kejadians'
    protected $table = 'kejadian';

    protected $fillable = [
        'jenis_kejadian',
        'kronologi',
        'lokasi',
        'tanggal_waktu',
        'foto',
        'nama_personel',
        'regu',
        'shift',
    ];

    // Accessors untuk format tampilan di View
    public function getTanggalFormatAttribute()
    {
        return Carbon::parse($this->tanggal_waktu)->translatedFormat('d F Y');
    }

    public function getWaktuFormatAttribute()
    {
        return Carbon::parse($this->tanggal_waktu)->format('H:i');
    }

    public function getFotoUrlAttribute()
    {
        return $this->foto ? asset('storage/' . $this->foto) : null;
    }

    public function getBadgeClassAttribute()
    {
        return match($this->regu) {
            'Alpha'   => 'badge-blue',
            'Bravo'   => 'badge-orange',
            'Charlie' => 'badge-green',
            'Delta'   => 'badge-purple',
            default   => 'badge-secondary',
        };
    }
}