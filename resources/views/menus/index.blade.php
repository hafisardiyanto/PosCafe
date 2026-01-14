@extends('layouts.app')

@section('title', 'Manajemen Menu')

@section('content')
<h1 class="mt-4">Manajemen Menu</h1>

{{-- ================= ALERT ================= --}}
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">{{ $errors->first() }}</div>
@endif

{{-- ======================================================
     ROLE KASIR
     ====================================================== --}}
@if(Auth::user()->role === 'kasir')

<div class="card mb-4">
    <div class="card-header bg-warning text-dark">
        <i class="fas fa-store me-1"></i>
        Ajukan Menu UMKM / Tambah Qty
    </div>

    <div class="card-body">

        <form method="POST"
              action="{{ route('menu.kasir.store') }}"
              enctype="multipart/form-data">
            @csrf

            {{-- NAMA MENU --}}
            <div class="mb-3">
                <label class="form-label">Nama Menu UMKM</label>
                <input type="text"
                       name="name"
                       class="form-control"
                       placeholder="Contoh: Es Teh UMKM"
                       required>
                <small class="text-muted">
                    Jika nama menu sudah ada & approved, sistem otomatis menambah Qty
                </small>
            </div>

            {{-- HARGA (HANYA UNTUK MENU BARU) --}}
            <div class="mb-3">
                <label class="form-label">Harga (jika menu baru)</label>
                <input type="number" name="price" class="form-control">
            </div>

            {{-- QTY --}}
            <div class="mb-3">
                <label class="form-label">Qty</label>
                <input type="number"
                       name="qty"
                       class="form-control"
                       required>
            </div>

            {{-- FOTO (OPSIONAL, KAMERA) --}}
            <div class="mb-3">
                <label class="form-label">Foto Menu (Opsional)</label>
                <input type="file"
                       name="image"
                       class="form-control"
                       accept="image/*"
                       capture="environment">
                <small class="text-muted">
                    Bisa langsung ambil foto dari kamera HP
                </small>
            </div>

            <button class="btn btn-warning w-100">
                Ajukan / Tambah Stok
            </button>
        </form>

    </div>
</div>

@endif

{{-- ======================================================
     ROLE ADMIN & MANAGER
     ====================================================== --}}
@if(in_array(Auth::user()->role, ['admin','manager']))

<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <i class="fas fa-plus-circle me-1"></i>
        Tambah Menu (Admin / Manager)
    </div>

    <div class="card-body">

        <form method="POST" action="{{ route('menu.admin.store') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nama Menu</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Harga</label>
                <input type="number" name="price" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Sumber Menu</label>
                <select name="source" class="form-control">
                    <option value="internal">Internal</option>
                    <option value="umkm">UMKM</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Stok (khusus UMKM)</label>
                <input type="number" name="stock" class="form-control">
            </div>

            <button class="btn btn-primary w-100">
                Simpan Menu
            </button>
        </form>

    </div>
</div>

{{-- ================= MENU PENDING ================= --}}
<div class="card">
    <div class="card-header bg-secondary text-white">
        <i class="fas fa-clock me-1"></i>
        Menu UMKM Menunggu Approval
    </div>

    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Qty</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pendingMenus as $menu)
                <tr>
                    <td>{{ $menu->name }}</td>
                    <td>Rp {{ number_format($menu->price) }}</td>
                    <td>{{ $menu->stock }}</td>
                    <td>
                        <form method="POST"
                              action="{{ route('menu.approve',$menu->id) }}"
                              class="d-inline">
                            @csrf
                            <button class="btn btn-success btn-sm">
                                Approve
                            </button>
                        </form>

                        <form method="POST"
                              action="{{ route('menu.reject',$menu->id) }}"
                              class="d-inline">
                            @csrf
                            <button class="btn btn-danger btn-sm">
                                Reject
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endif

@endsection
