@extends('layouts.app')

@section('title','Transaksi Kasir')

@section('content')
<h1 class="mt-4">Input Pesanan</h1>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if($errors->any())
    <div class="alert alert-danger">{{ $errors->first() }}</div>
@endif

<form method="POST" action="{{ route('kasir.transaksi.store') }}">
@csrf

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Menu</th>
            <th>Qty</th>
        </tr>
    </thead>
    <tbody>

        @foreach(\App\Models\Menu::where('status','approved')->get() as $menu)

<tr>
<td>
    {{ $menu->name }} <br>

    @if($menu->availability === 'closed')
        <span class="badge bg-danger">HABIS</span>
    @else
        <span class="badge bg-success">OPEN</span>
    @endif

    <br>
    Rp {{ number_format($menu->price) }}

    @if($menu->source === 'umkm')
        <br>Stok: {{ $menu->stock }}
    @endif
</td>

<td width="150">
    @if($menu->availability === 'open')
        <input type="number"
               name="items[{{ $loop->index }}][qty]"
               class="form-control"
               min="0">
    @else
        <em class="text-muted">Tidak tersedia</em>
    @endif

    <input type="hidden"
           name="items[{{ $loop->index }}][menu_id]"
           value="{{ $menu->id }}">
</td>

<td width="120">
    {{-- OPEN / CLOSE --}}
    @if($menu->availability === 'open')
        <form method="POST" action="{{ route('menu.close',$menu->id) }}">
            @csrf
            <button class="btn btn-danger btn-sm">Close</button>
        </form>
    @else
        <form method="POST" action="{{ route('menu.open',$menu->id) }}">
            @csrf
            <button class="btn btn-success btn-sm">Open</button>
        </form>
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
