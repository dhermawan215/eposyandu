<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriPeserta extends Model
{
    use HasFactory;

    protected $table = 'kategori_peserta';

    protected $fillable = ['nama_kategori_peserta'];

    public function pesertas()
    {
        return $this->hasMany(Peserta::class, 'kategori_id', 'id');
    }
}
