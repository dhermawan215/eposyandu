@extends('layouts.app')

@section('content')
    <style>
        .display-none {
            display: none !important;
        }
    </style>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1">
                    <li class="breadcrumb-item">
                        <a href="{{ route('app.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">Pemeriksaan</li>
                    <li class="breadcrumb-item active text-primary">{{ $peserta->nama_peserta }}</li>
                </ol>
                <hr>
            </nav>
        </div>
        <div class="row mb-3">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <a href="#" class="btn btn-outline-primary">Export Riwayat Pemerikasaan</a>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-12 col-lg-12 col-md-12">
                <div class="card">
                    <h5 class="card-header">Formulir Pemeriksaan</h5>
                    <div class="card-body">

                        <form action="javascript:;" method="post" id="formPemeriksaan">
                            @csrf
                            <div class="row mb-2">
                                <div class="col">
                                    <input type="hidden" name="peserta" id="peserta" value="{{ $peserta->no_peserta }}">
                                    <label for="namaPeserta">Nama Peserta</label>
                                    <input type="text" id="namaPeserta" class="form-control" readonly
                                        value="{{ $peserta->nama_peserta }}">
                                </div>
                                <div class="col">
                                    <label for="tanggal_pemeriksaan">Tanggal Pemeriksaan</label>
                                    <input type="date" name="tanggal_pemeriksaan" id="tanggal_pemeriksaan"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col">
                                    <label for="nama_pemeriksaan">Nama Pemeriksaan</label>
                                    <input type="text" name="nama_pemeriksaan" id="nama_pemeriksaan"
                                        class="form-control">
                                </div>
                                <div class="col">
                                    <label for="hasil_pemeriksaan">Hasil Pemeriksaan</label>
                                    <input type="text" name="hasil_pemeriksaan" id="hasil_pemeriksaan"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea name="keterangan" id="keterangan" class="form-control" cols="30" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <div class="d-flex">
                                        <button type="submit" class="btn btn-primary me-2"
                                            id="btnSimpanPemeriksaan">Simpan</button>
                                        <div class="d-flex align-items-center display-none" id="isLoading">
                                            <strong role="status">Loading...</strong>
                                            <div class="spinner-border text-primary ms-2" role="status">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-12 col-md-12 col-lg-12 order-3 order-md-2">
                <div class="row">
                    <div class="mb-4">
                        <div class="card">
                            <h5 class="card-header">Riwayat Pemeriksaan</h5>
                            <div class="card-body">
                                <div class="p-3 m-3">
                                    <table class="table table-hover" id="tabelRiwayatPemeriksaan" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal Pemeriksaan</th>
                                                <th>Nama Pemeriksaan</th>
                                                <th>Hasil Pemeriksaan</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@push('custom_js')
    <script src="{{ asset('scripts/pemeriksaan/pemeriksaan.min.js?q=') . time() }}"></script>
@endpush
