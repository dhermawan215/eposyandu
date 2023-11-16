@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Admin - Peserta</span></h4>
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12 order-3 order-md-2">
                <div class="row">
                    <div class="mb-4">
                        <div class="card">
                            <h5 class="card-header">Data Peserta</h5>
                            <div class="p-3 m-3">
                                <table class="table table-hover" id="tabelAdminPeserta" style="width:100%">
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
@endsection
@push('custom_js')
    <script src="{{ asset('scripts/peserta/admin-peserta.min.js?q=') . time() }}"></script>
@endpush
