@extends('layouts.app')

@section('title','Monitoring Login Kasir')

@section('content')
<h1>Monitoring Login Kasir</h1>

<form method="GET" class="row g-3 mb-4">

    <div class="col-md-3">
        <label>Dari Tanggal</label>
        <input type="date" name="from_date" class="form-control"
               value="{{ request('from_date') }}">
    </div>

    <div class="col-md-3">
        <label>Sampai Tanggal</label>
        <input type="date" name="to_date" class="form-control"
               value="{{ request('to_date') }}">
    </div>

    <div class="col-md-2">
        <label>Dari Jam</label>
        <input type="time" name="from_time" class="form-control"
               value="{{ request('from_time') }}">
    </div>

    <div class="col-md-2">
        <label>Sampai Jam</label>
        <input type="time" name="to_time" class="form-control"
               value="{{ request('to_time') }}">
    </div>

    <div class="col-md-2 align-self-end">
        <button class="btn btn-primary w-100">
            Filter
        </button>
    </div>
</form>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nama Kasir</th>
            <th>Email</th>
            <th>Tanggal</th>
            <th>Jam Login</th>
        </tr>
    </thead>
    <tbody>
        @forelse($logs as $log)
        <tr>
            <td>{{ $log->user->name }}</td>
            <td>{{ $log->user->email }}</td>
            <td>{{ $log->login_at->format('d-m-Y') }}</td>
            <td>{{ $log->login_at->format('H:i:s') }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="4" class="text-center">
                Data tidak ditemukan
            </td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
