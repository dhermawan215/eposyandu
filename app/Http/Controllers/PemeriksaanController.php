<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use App\Models\Pemeriksaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PemeriksaanController extends Controller
{
    public function pemeriksaan($id)
    {
        $peserta = Peserta::where('no_peserta', $id)->first();
        return \view('pemeriksaan.index', ['peserta' => $peserta]);
    }

    // fungsi get peserta
    public function getPeserta($id)
    {
        $peserta = Peserta::select('id')->where('no_peserta', $id)->first();
        return $peserta;
    }

    // fungsi untuk menampilkan data ke data tabel riwayat pemeriksaan
    public function riwayatPemeriksaan(Request $request)
    {
        $draw = $request['draw'];
        $offset = $request['start'] ? $request['start'] : 0;
        $limit = $request['length'] ? $request['length'] : 10;
        $globalSearch = $request['search']['value'];
        $peserta = $request['peserta'];

        $pesertas = $this->getPeserta($peserta);

        $query = Pemeriksaan::select('*');
        $query->where('peserta_id', $pesertas->id);
        if ($globalSearch) {
            $query->where('nama_pemeriksaan',  'like', '%' . $globalSearch . '%')
                ->orWhere('hasil_pemeriksaan',  'like', '%' . $globalSearch . '%')
                ->orWhere('keterangan', 'like', '%' . $globalSearch . '%');
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
            $data['tgl'] = "Data Kosong";
            $data['n_pemeriksaan'] = "Data Kosong";
            $data['h_pemeriksaan'] = "Data Kosong";
            $data['ket'] = "Data Kosong";
            $arr[] = $data;
        } else {
            foreach ($resData as $key => $value) {
                $data['rnum'] = $i;
                $data['tgl'] = $value->tanggal_pemeriksaan;
                $data['n_pemeriksaan'] = $value->nama_pemeriksaan;
                $data['h_pemeriksaan'] = $value->hasil_pemeriksaan;
                $data['ket'] = $value->keterangan;

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

    public function simpanPemeriksaan(Request $request)
    {
        $requestAll = $request->all();

        $validator = Validator::make(
            $requestAll,
            [
                'tanggal_pemeriksaan' => 'required',
                'nama_pemeriksaan' => 'required',
                'hasil_pemeriksaan' => 'required',
            ]
        );

        // return validation if errors
        if ($validator->fails()) {
            return response()->json($validator->errors()->all(), 403);
        }

        // mendapatkan id peserta
        $peserta = $this->getPeserta($requestAll['peserta']);

        unset($requestAll['_token']);

        $pemeriksaan = Pemeriksaan::create([
            'tanggal_pemeriksaan' => \htmlspecialchars($requestAll['tanggal_pemeriksaan']),
            'nama_pemeriksaan' => \htmlspecialchars($requestAll['nama_pemeriksaan']),
            'hasil_pemeriksaan' => \htmlspecialchars($requestAll['hasil_pemeriksaan']),
            'keterangan' => \htmlspecialchars($requestAll['keterangan']),
            'peserta_id' => $peserta->id
        ]);

        return \response()->json(['success' => \true], 200);
    }
}
