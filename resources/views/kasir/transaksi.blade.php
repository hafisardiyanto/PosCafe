@extends('layouts.app')

@section('title','Transaksi Kasir')

@section('content')
<h1 class="mt-4">Input Pesanan Customer</h1>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if($errors->any())
    <div class="alert alert-danger">{{ $errors->first() }}</div>
@endif

<form method="POST" action="{{ route('kasir.transaksi.store') }}">
@csrf

<table class="table table-bordered align-middle">
    <thead class="table-dark">
        <tr>
            <th>Menu</th>
            <th width="120">Qty</th>
            <th width="120">Status</th>
        </tr>
    </thead>
    <tbody>

@foreach($menus as $index => $menu)
<tr>
<td>
    {{-- GAMBAR (OPTIONAL) --}}
    @if($menu->images && count(json_decode($menu->images)) > 0)
        <img src="{{ asset('storage/'.json_decode($menu->images)[0]) }}"
             width="70"
             class="mb-2 rounded">
        <br>
    @endif

    <strong>{{ $menu->name }}</strong><br>
    Rp {{ number_format($menu->price) }}

    @if($menu->source === 'umkm')
        <br><small>Stok: {{ $menu->stock }}</small>
    @endif
</td>

<td>
    @if($menu->availability === 'open')
        <input type="number"
               name="items[{{ $index }}][qty]"
               class="form-control"
               min="0"
               value="0">
    @else
        <em class="text-muted">Tidak tersedia</em>
    @endif

    <input type="hidden"
           name="items[{{ $index }}][menu_id]"
           value="{{ $menu->id }}">
</td>

<td class="text-center">
    @if($menu->availability === 'open')
        <span class="badge bg-success mb-2">OPEN</span>

        <button
            formaction="{{ route('menu.close',$menu->id) }}"
            formmethod="POST"
            class="btn btn-danger btn-sm w-100">
            @csrf
            Close
        </button>
    @else
        <span class="badge bg-danger mb-2">HABIS</span>

        <button
            formaction="{{ route('menu.open',$menu->id) }}"
            formmethod="POST"
            class="btn btn-success btn-sm w-100">
            @csrf
            Open
        </button>
    @endif
</td>
</tr>
@endforeach

    </tbody>
</table>

<button class="btn btn-success w-100">
    Simpan Transaksi
</button>

</form>
@endsection
