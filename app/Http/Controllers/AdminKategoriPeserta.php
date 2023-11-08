<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminKategoriPeserta extends Controller
{
    public function index()
    {
        return view('kategori-peserta.index');
    }

    public function store(Request $request)
    {
        $requestAll = $request->all();

        dd($requestAll);
    }
}
