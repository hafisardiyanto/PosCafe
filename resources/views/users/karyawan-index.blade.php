@extends('layouts.app')

@section('title','Data Karyawan')

@section('content')
<h1>Data Karyawan</h1>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>Role</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $u)
        <tr>
            <td>{{ $u->name }}</td>
            <td>{{ $u->email }}</td>
            <td>{{ ucfirst($u->role) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
