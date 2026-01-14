@extends('layouts.app')

@section('title', 'Dashboard Manager')

@section('content')
<h1 class="mt-4">Dashboard Manager</h1>

<div class="row">
    <div class="col-xl-4">
        <div class="card bg-warning text-white mb-4">
            <div class="card-body">Laporan Mingguan</div>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="card bg-success text-white mb-4">
            <div class="card-body">Laporan Bulanan</div>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="card bg-primary text-white mb-4">
            <div class="card-body">Shift Kasir</div>
        </div>
    </div>
</div>
@endsection
