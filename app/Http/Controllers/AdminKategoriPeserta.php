<?php

namespace App\Http\Controllers;

use App\Models\KategoriPeserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminKategoriPeserta extends Controller
{
    public function index()
    {
        return view('kategori-peserta.index');
    }

    public function store(Request $request)
    {
        $requestAll = $request->all();

        // custom error messages
        $message = ['nama_kategori_peserta.required' => 'Nama Harus di isi!'];
        // validation
        $validator = Validator::make(
            $requestAll,
            [
                'nama_kategori_peserta' => 'required',
            ],
            $message
        );
        // return validation if errors
        if ($validator->fails()) {
            return response()->json($validator->errors()->all(), 403);
        }
        // unset token
        unset($requestAll['_token']);
        // create data
        $createData = KategoriPeserta::create([
            'nama_kategori_peserta' => htmlspecialchars($requestAll['nama_kategori_peserta']),
        ]);
        // response error
        if (!$createData) {
            return response()->json(['success' => false], 500);
        }
        // response success
        return response()->json(['success' => true], 200);
    }

    // fungsi untuk data tabel
    public function tableData(Request $request)
    {
        // request data tabel
        $draw = $request['draw'];
        $offset = $request['start'] ? $request['start'] : 0;
        $limit = $request['length'] ? $request['length'] : 10;
        $globalSearch = $request['search']['value'];
        // query awal
        $query = KategoriPeserta::select('*');
        // query pencarian
        if ($globalSearch) {
            $query->where('nama_kategori_peserta', 'like', '%' . $globalSearch . '%');
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
            $data['nama'] = "Data Kosong";
            $data['action'] = "#";
            $arr[] = $data;
        } else {
            foreach ($resData as $key => $value) {
                $dataButton = base64_encode($value->id);

                $data['rnum'] = $i;
                $data['nama'] = $value->nama_kategori_peserta;
                $data['action'] = '<div class="d-flex"><button class="btn btn-sm btn-primary kategori-edits" data-bs-toggle="modal"
                data-bs-target="#modalEditKategoriPeserta" title="Edit" data-btnedit="' . $dataButton . '"><i class="bx bxs-edit"></i></button><button class="btn btn-sm btn-danger kategori-deletes ms-2" title="Hapus" data-btndelete="' . $dataButton . '"><i class="bx bx-trash"></i></button></div>';

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

    // fungsi hapus data
    public function destroy($id)
    {
        $id2 = base64_decode($id);

        $hapusData = KategoriPeserta::find($id2);

        $hapusData->delete();

        return response()->json(['success' => true], 200);
    }

    // fungsi update data
    public function update(Request $request, $id)
    {
        $requestAll = $request->all();

        // custom error messages
        $message = ['nama_kategori_peserta.required' => 'Nama Harus di isi!'];
        // validation
        $validator = Validator::make(
            $requestAll,
            [
                'nama_kategori_peserta' => 'required',
            ],
            $message
        );

        // return validation if errors
        if ($validator->fails()) {
            return response()->json($validator->errors()->all(), 403);
        }

        // unset token dan method
        unset($requestAll['_token']);
        unset($requestAll['_method']);

        $id2 = base64_decode($id);

        $updateData = KategoriPeserta::find($id2);

        $result = $updateData->update(['nama_kategori_peserta' => htmlspecialchars($requestAll['nama_kategori_peserta'])]);

        if (!$result) {
            return response()->json(['success' => \false], 500);
        }
        return response()->json(['success' => \true], 200);
    }
}
