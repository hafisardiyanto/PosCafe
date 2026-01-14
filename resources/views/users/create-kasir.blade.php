@extends('layouts.app')

@section('title', 'Tambah Karyawan Kasir')

@section('content')
<h1 class="mt-4">Tambah Karyawan (Kasir)</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Tambah Kasir</li>
</ol>

<div class="card form-kasir">
    <div class="card-header">
        <i class="fas fa-user-plus me-1"></i>
        Form Tambah Kasir
    </div>

    <div class="card-body">

        {{-- SUCCESS --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- ERROR --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('kasir.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button class="btn btn-primary">
                Simpan Kasir
            </button>
        </form>

    </div>
</div>
@endsection
