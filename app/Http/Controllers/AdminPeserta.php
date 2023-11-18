<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use Illuminate\Http\Request;

class AdminPeserta extends Controller
{
    public function index()
    {
        return view('peserta.admin-peserta');
    }

    // fungsi untuk data tabel
    public function tabelDataAdmin(Request $request)
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
                $data['action'] = '';

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
}
