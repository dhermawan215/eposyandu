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

    // fungsi untuk data tabel
    public function dataPeserta(Request $request)
    {
        // request data tabel
        $draw = $request['draw'];
        $offset = $request['start'] ? $request['start'] : 0;
        $limit = $request['length'] ? $request['length'] : 10;
        $globalSearch = $request['search']['value'];
        // query awal
        $query = Peserta::select('*');
        // query pencarian
        if ($globalSearch) {
            $query->where('nama_peserta', 'like', '%' . $globalSearch . '%')
                ->orWhere('no_peserta', 'like', '%' . $globalSearch . '%');
        }
        // query table data
        $recordsFiltered = $query->count();

        $resData = $query->skip($offset)
            ->take($limit)
            ->get();

        $recordsTotal = $resData->count();

        $data = [];
        $i = $offset + 1;

        if ($resData->isEmpty()) {
            $data['rnum'] = "#";
            $data['nomer'] = "Data Kosong";
            $data['nama'] = "Data Kosong";
            $data['action'] = "#";
            $arr[] = $data;
        } else {
            foreach ($resData as $key => $value) {
                $dataButton = base64_encode($value->id);

                $data['rnum'] = $i;
                $data['nomer'] = $value->no_peserta;
                $data['nama'] = $value->nama_peserta;
                $data['action'] = '<div class="d-flex"><button type="button" data-peserta="' . $value->no_peserta . '" class="btn btn-sm btn-success btn-view-detail"><i class="bx bx-detail"></i> Detail</button><a href="' . \route('pemeriksaan', $value->no_peserta) . '" class="btn btn-sm btn-primary ms-2"><i class="bx bx-check-square"></i>Pemeriksaan</a></div>';

                $arr[] = $data;
                $i++;
            }
        }

        return \response()->json([
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $arr,
        ]);
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

    // fungsi untuk detail data di modal peserta
    // @retun value peserta
    public function detail($id)
    {
        $peserta = Peserta::with('kategoriPeserta')->where('no_peserta', $id)->first();

        $data = [];
        $data['no_peserta'] = $peserta->no_peserta;
        $data['nama_peserta'] = $peserta->nama_peserta;
        $data['tempat_lahir'] = $peserta->tempat_lahir;
        $data['tanggal_lahir'] = $peserta->tanggal_lahir;
        $data['alamat'] = $peserta->alamat;
        $data['gender'] = $peserta->gender;
        $data['nama_ibu_kandung'] = $peserta->nama_ibu_kandung;
        $data['kategori'] = $peserta->kategoriPeserta->nama_kategori_peserta;

        return \response()->json(['success' => true, 'data' => $data], 200);
    }
}
