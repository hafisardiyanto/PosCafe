@extends('layouts.app')

@section('title','Data Kasir')

@section('content')
<h1>Data Kasir</h1>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $u)
        <tr>
            <td>{{ $u->name }}</td>
            <td>{{ $u->email }}</td>
            <td>
                <a href="{{ route('karyawan.show',$u->id) }}" class="btn btn-info btn-sm">Detail</a>

                <form action="{{ route('karyawan.destroy',$u->id) }}"
                      method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm"
                            onclick="return confirm('Hapus user?')">
                        Hapus
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
