@extends('layouts.app')

@section('title', 'Dashboard Kasir')

@section('content')
<h1 class="mt-4">Dashboard Kasir</h1>

<div class="row">
    <div class="col-xl-6">
        <div class="card bg-success text-white mb-4">
            <div class="card-body">Penjualan Hari Ini</div>
        </div>
    </div>

    <div class="col-xl-6">
        <div class="card bg-info text-white mb-4">
            <div class="card-body">Status Shift</div>
        </div>
    </div>
</div>
@endsection
