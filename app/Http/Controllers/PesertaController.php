<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminKategoriPeserta;
use App\Models\Peserta;
use Illuminate\Support\Facades\Validator;

class PesertaController extends Controller
{
    public function index()
    {
        $kategoriPeserta = new AdminKategoriPeserta;
        $dropdown = $kategoriPeserta->dropdownKategoriPeserta();

        return \view('peserta.index', ['dropdownData' => $dropdown]);
    }

    // fungsi simpan data peserta
    // @return value id untuk pemerikasaan
    public function store(Request $request)
    {
        $requestAll = $request->all();

        $validator = Validator::make(
            $requestAll,
            [
                'nama_peserta' => 'required|string|max:50',
                'tempat_lahir' => 'required',
                'tanggal_lahir' => 'required',
                'alamat' => 'required',
                'gender' => 'required',
                'nama_ibu_kandung' => 'required'
            ]
        );

        // return validation if errors
        if ($validator->fails()) {
            return response()->json($validator->errors()->all(), 403);
        }
        // create no Peserta;
        $cekDataNoPeserta = Peserta::max('no_peserta');
        $kode = $cekDataNoPeserta;
        $urutan = (int) \substr($kode, 5, 5);
        $urutan++;
        $noPeserta = 'MBR-' . sprintf("%05s", $urutan);

        unset($requestAll['_token']);

        //create data
        $dataPeserta = Peserta::create([
            'no_peserta' => $noPeserta,
            'nama_peserta' => $requestAll['nama_peserta'],
            'tempat_lahir' => $requestAll['tempat_lahir'],
            'tanggal_lahir' => $requestAll['tanggal_lahir'],
            'alamat' => $requestAll['alamat'],
            'gender' => $requestAll['gender'],
            'nama_ibu_kandung' => $requestAll['nama_ibu_kandung'],
            'kategori_id' => $requestAll['kategori_id']
        ]);

        return \response()->json(['success' => \true, 'peserta' => $dataPeserta->no_peserta], 200);
    }
}
