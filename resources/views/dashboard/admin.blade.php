@extends('layouts.app')

@section('bg-admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="dashboard-bg admin-bg">
<h1 class="mt-4">Dashboard Admin</h1>
</div>

<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card bg-primary text-white mb-4">
            <div class="card-body">Total Pemasukan</div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card bg-danger text-white mb-4">
            <div class="card-body">Total Pengeluaran</div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
    <div class="card bg-success text-white mb-4">
        <div class="card-body">
            <h5>Total User Kasir</h5>
         <h2>{{ $totalKasir }}</h2>
        </div>
    </div>
</div>



</div>
@endsection
