<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    use HasFactory;

    protected $table = 'peserta';

    protected $fillable = [
        'no_peserta',
        'nama_peserta',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'gender',
        'nama_ibu_kandung',
        'kategori_id'
    ];

    public function kategoriPeserta()
    {
        return $this->belongsTo(KategoriPeserta::class, 'kategori_id', 'id');
    }

    public function pemeriksaans()
    {
        return $this->hasMany(Pemeriksaan::class, 'peserta_id', 'id');
    }
}
