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

            <div class="mb-3">
                <label class="form-label">Nama Menu UMKM</label>
                <input type="text"
                       name="name"
                       class="form-control"
                       required>
                <small class="text-muted">
                    Jika menu sudah ada & approved, stok otomatis ditambah
                </small>
            </div>

            <div class="mb-3">
                <label class="form-label">Harga (menu baru)</label>
                <input type="number" name="price" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Qty</label>
                <input type="number" name="qty" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Foto Menu (Opsional)</label>
                <input type="file"
                       name="image"
                       class="form-control"
                       accept="image/*">
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
        Tambah Menu (Admin / Manager)
    </div>

    <div class="card-body">

<form method="POST" action="{{ route('menu.admin.store') }}">
@csrf

<div class="mb-3">
    <label class="form-label">Pilih Menu UMKM (Approved)</label>
    <select class="form-control" id="menuDropdown">
        <option value="">-- Pilih --</option>
        @foreach($approvedUmkmMenus as $menu)
            <option
                data-name="{{ $menu->name }}"
                data-price="{{ $menu->price }}"
                data-stock="{{ $menu->stock }}">
                {{ $menu->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label>Nama Menu</label>
    <input type="text" name="name" id="name" class="form-control" required>
</div>

<div class="mb-3">
    <label>Harga</label>
    <input type="number" name="price" id="price" class="form-control" required>
</div>

<div class="mb-3">
    <label>Sumber</label>
    <select name="source" class="form-control">
        <option value="internal">Internal</option>
        <option value="umkm">UMKM</option>
    </select>
</div>

<div class="mb-3">
    <label>Stok</label>
    <input type="number" name="stock" id="stock" class="form-control">
</div>

<button class="btn btn-primary w-100">Simpan Menu</button>

</form>
</div>
</div>

{{-- AUTO FILL --}}
<script>
document.getElementById('menuDropdown').addEventListener('change', function () {
    const opt = this.options[this.selectedIndex];
    document.getElementById('name').value  = opt.dataset.name || '';
    document.getElementById('price').value = opt.dataset.price || '';
    document.getElementById('stock').value = opt.dataset.stock || '';
});
</script>

{{-- ================= PENDING MENU ================= --}}
<div class="card">
    <div class="card-header bg-secondary text-white">
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
                @forelse($pendingMenus as $menu)
                <tr>
                    <td>{{ $menu->name }}</td>
                    <td>Rp {{ number_format($menu->price) }}</td>
                    <td>{{ $menu->stock }}</td>
                    <td>
                        <form method="POST" action="{{ route('menu.approve',$menu->id) }}" class="d-inline">
                            @csrf
                            <button class="btn btn-success btn-sm">Approve</button>
                        </form>
                        <form method="POST" action="{{ route('menu.reject',$menu->id) }}" class="d-inline">
                            @csrf
                            <button class="btn btn-danger btn-sm">Reject</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">
                        Tidak ada menu pending
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endif
@endsection
