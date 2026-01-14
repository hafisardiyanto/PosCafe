@extends('layouts.app')

@section('title','Login Kasir Harian')

@section('content')
<h1>Login Kasir Hari Ini</h1>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nama Kasir</th>
            <th>Email</th>
            <th>Login Jam</th>
            <th>Tanggal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($logs as $log)
        <tr>
            <td>{{ $log->user->name }}</td>
            <td>{{ $log->user->email }}</td>
            <td>{{ $log->login_at->format('H:i:s') }}</td>
            <td>{{ $log->login_at->format('d-m-Y') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
