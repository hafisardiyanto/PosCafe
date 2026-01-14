@extends('layouts.app')

@section('title','Tambah Menu UMKM')

@section('content')

<div class="kasir-umkm-wrapper">

    <h1 class="mt-4">Tambah Menu UMKM</h1>
    <p class="text-muted">Menu akan menunggu persetujuan Admin / Manager</p>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <div class="card">
        <div class="card-body">

            <form method="POST"
      action="{{ route('menu.kasir.store') }}"
      enctype="multipart/form-data">
    @csrf

                {{-- NAMA MENU --}}
                <div class="mb-3">
                    <label class="form-label">Nama Menu UMKM</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                {{-- HARGA --}}
                <div class="mb-3">
                    <label class="form-label">Harga</label>
                    <input type="number" name="price" class="form-control" required>
                </div>

                {{-- QTY --}}
                <div class="mb-3">
                    <label class="form-label">Qty</label>
                    <input type="number" name="qty" class="form-control" required>
                </div>

                {{-- FOTO (KAMERA) --}}
                <div class="mb-3">
                    <label class="form-label">Foto Menu (Kamera)</label>
                    <input type="file"
                           name="image"
                           class="form-control"
                           accept="image/*"
                           capture="environment">
                    <small class="text-muted">
                        Bisa langsung ambil foto dari kamera HP / Tablet
                    </small>
                </div>

                <button class="btn btn-warning w-100">
                    <i class="fas fa-paper-plane me-1"></i>
                    Ajukan Menu UMKM
                </button>

            </form>

        </div>
    </div>

</div>

@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/kasir.css') }}">
@endpush
