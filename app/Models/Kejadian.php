<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Kejadian extends Model
{
    use HasFactory;

    protected $table = 'kejadian';

    protected $fillable = [
        'jenis_kejadian',
        'user_id',
        'kronologi',
        'lokasi',
        'tanggal_waktu',
        'foto',
        'nama_personel',
        'regu',
        'shift',
    ];

    protected $casts = [
        'tanggal_waktu' => 'datetime',
    ];

    public function getTanggalFormatAttribute()
    {
        return $this->tanggal_waktu->translatedFormat('d F Y');
    }

    public function getWaktuFormatAttribute()
    {
        return $this->tanggal_waktu->format('H:i');
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
