@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Kategori Peserta</span></h4>
        <div class="row mb-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#modalTambahKategoriPeserta">
                            <i class='bx bx-plus'></i> Tambah Data
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12 order-3 order-md-2">
                <div class="row">
                    <div class="mb-4">
                        <div class="card">
                            <h5 class="card-header">Data Kategori Peserta</h5>
                            <div class="p-3 m-3">
                                <table class="table table-hover" id="tableKtgPeserta" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Aksi</th>
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

    <!-- Modal -->
    <div class="modal fade" id="modalTambahKategoriPeserta" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Formulir Tambah Kategori Peserta</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="javascript:;" method="post" id="kategorispesertas">
                        @csrf
                        <div class="mb-3">
                            <label for="nama-kategori-peserta" class="col-form-label">Nama Kategori</label>
                            <input class="form-control" name="nama_kategori_peserta" id="nama-kategori-peserta"
                                placeholder="nama kategori, misal ibu hamil / balita"></input>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('custom_js')
    <script src="{{ asset('scripts/kategori-peserta/view.min.js?q=') . time() }}"></script>
@endpush
