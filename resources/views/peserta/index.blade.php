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
                    <li class="breadcrumb-item active">Peserta</li>
                </ol>
                <hr>
            </nav>
        </div>
        <div class="row mb-4">
            <div class="col-12 col-lg-12 col-md-12">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#modalDaftarPesertaBaru">Daftar
                    Peserta Baru</button>
            </div>
        </div>
        <div class="row mt-2 mb-2 mx-2">
            <div class="spinner-border text-primary display-none" id="isLoading" role="status">

            </div>
        </div>
        <div class="row mt-2">
            <div class="col-12 col-md-12 col-lg-12 order-3 order-md-2">
                <div class="row">
                    <div class="mb-4">
                        <div class="card">
                            <h5 class="card-header">Data Peserta</h5>
                            <div class="p-3 m-3">
                                <table class="table table-hover" id="tabelPeserta" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No Peserta</th>
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

    <!-- modal daftar peserta baru -->
    <div class="modal fade" id="modalDaftarPesertaBaru" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Modal Datar Peserta Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="javascript:;" method="post" id="formDaftarPesertaBaru">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="namaPeserta" class="form-label">Nama Peserta</label>
                                <input type="text" id="namaPeserta" name="nama_peserta" class="form-control"
                                    placeholder="Nama peserta" />
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col mb-1">
                                <label for="tempatLahir" class="form-label">Tempat Lahir</label>
                                <input type="text" id="tempatLahir" name="tempat_lahir" class="form-control"
                                    placeholder="Tempat lahir" />
                            </div>
                            <div class="col mb-1">
                                <label for="tanggalLahir" class="form-label">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" id="tanggalLahir" class="form-control"
                                    placeholder="DD / MM / YY" />
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col mb-1">
                                <label for="gender" class="form-label">Jenis Kelamin</label>
                                <select name="gender" id="gender" class="form-control">
                                    <option value="LAKI-LAKI">LAKI-LAKI</option>
                                    <option value="PEREMPUAN">PEREMPUAN</option>
                                </select>
                            </div>
                            <div class="col mb-1">
                                <label for="namaIbuKandung" class="form-label">Nama Ibu Kandung</label>
                                <input type="text" name="nama_ibu_kandung" id="namaIbuKandung" class="form-control"
                                    placeholder="Nama ibu kandung" />
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col mb-1">
                                <label for="alamat" class="form-label">Alamat</label>
                                <input type="text" name="alamat" id="alamat" class="form-control"
                                    placeholder="Alamat" />
                            </div>
                        </div>
                        <div class="row g-2">

                            <label for="kategori_peserta" class="form-label">Kategori Peserta</label>
                            <select name="kategori_id" id="kategoriPesertasss" class="form-control">
                                <option selected>Pilih Kategori Peserta</option>
                                @foreach ($dropdownData as $value)
                                    <option value="{{ $value->id }}">{{ $value->nama_kategori_peserta }}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="row g-2 m-2">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Tutup
                    </button>

                </div>
            </div>
        </div>
    </div>

    <!-- modal detail peserta -->
    <div class="modal fade" id="modalDetailPeserta" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Modal Detail Peserta </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="namaPeserta" class="form-label">Nomor Peserta</label>
                            <input type="text" id="noPeserta" class="form-control" placeholder="No peserta"
                                readonly />
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-3">
                            <label for="namaPeserta" class="form-label">Nama Peserta</label>
                            <input type="text" id="namaPesertaView" class="form-control" placeholder="Nama peserta"
                                readonly />
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-1">
                            <label for="tempatLahir" class="form-label">Tempat Lahir</label>
                            <input type="text" id="tempatLahirView" class="form-control" placeholder="Tempat lahir"
                                readonly />
                        </div>
                        <div class="col mb-1">
                            <label for="tanggalLahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" id="tanggalLahirView" class="form-control" placeholder="DD / MM / YY"
                                readonly />
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-1">
                            <label for="gender" class="form-label">Jenis Kelamin</label>
                            <input type="text" id="genderView" class="form-control" readonly>
                        </div>
                        <div class="col mb-1">
                            <label for="namaIbuKandung" class="form-label">Nama Ibu Kandung</label>
                            <input type="text" id="namaIbuKandungView" class="form-control"
                                placeholder="Nama ibu kandung" readonly />
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-1">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input type="text" id="alamatView" class="form-control" placeholder="Alamat" readonly />
                        </div>
                    </div>
                    <div class="row g-2">

                        <label for="kategori_peserta" class="form-label">Kategori Peserta</label>
                        <input type="text" id="kategoriView" class="form-control" readonly>

                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Tutup
                    </button>

                </div>
            </div>
        </div>
    </div>
@endsection
@push('custom_js')
    <script src="{{ asset('scripts/select2.js') }}"></script>
    <script src="{{ asset('scripts/peserta/peserta.min.js?q=') . time() }}"></script>
@endpush
