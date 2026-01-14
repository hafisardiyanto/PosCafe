@extends('layouts.app')

@section('title','Detail Karyawan')

@section('content')
<h1>Detail Karyawan</h1>

<ul class="list-group">
    <li class="list-group-item"><b>Nama:</b> {{ $user->name }}</li>
    <li class="list-group-item"><b>Email:</b> {{ $user->email }}</li>
    <li class="list-group-item"><b>Role:</b> {{ ucfirst($user->role) }}</li>
</ul>

<a href="{{ url()->previous() }}" class="btn btn-secondary mt-3">Kembali</a>
@endsection
