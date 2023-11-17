<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminKategoriPeserta;

class PesertaController extends Controller
{
    public function index()
    {
        return \view('peserta.index');
    }

    // fungsi mengambil data dropdown kategori peserta dan return ke ajax
    public function kategoriPeserta(Request $request)
    {
        $kategoriPeserta = new AdminKategoriPeserta;
        $kategoriPeserta->dropdownKategoriPeserta($request);
    }
}
