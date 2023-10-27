<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemeriksaan extends Model
{
    use HasFactory;

    protected $table = 'pemeriksaan';

    protected $fillable = [
        'tanggal_pemeriksaan',
        'nama_pemeriksaan',
        'hasil_pemeriksaan',
        'keterangan',
        'peserta_id'
    ];

    public function pesertaPemeriksaan()
    {
        return $this->belongsTo(Peserta::class, 'peserta_id', 'id');
    }
}
