<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\MenuApprovalController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\LoginLogController;
use App\Http\Controllers\MenuStatusController;

/*
|--------------------------------------------------------------------------
| AUTH (LOGIN)
|--------------------------------------------------------------------------
*/
Route::get('/login', function () {
    return view('auth.login');
})->middleware('guest')->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest');

/*
|--------------------------------------------------------------------------
| FORGOT PASSWORD
|--------------------------------------------------------------------------
*/
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})
->middleware('guest')
->name('password.request');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
    ->middleware('guest')
    ->name('password.email');

/*
|--------------------------------------------------------------------------
| RESET PASSWORD
|--------------------------------------------------------------------------
*/
Route::get('/reset-password/{token}', function (string $token) {
    return view('auth.reset-password', [
        'token' => $token,
        'email' => request('email'),
    ]);
})
->middleware('guest')
->name('password.reset');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
    ->middleware('guest')
    ->name('password.update');

/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
*/
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| DASHBOARD & FITUR (SETELAH LOGIN)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Dashboard (auto berdasarkan role)
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // ================= ADMIN =================
    Route::middleware('role:admin')->group(function () {
        Route::resource('/menu-approval', MenuApprovalController::class);
    });

    // ================= MANAGER =================
    Route::middleware(['auth','role:kasir'])->group(function () {

    // HALAMAN INPUT PESANAN
    Route::get('/kasir/transaksi', function () {
        return view('kasir.transaksi');
    })->name('kasir.transaksi');

    // SIMPAN TRANSAKSI
    Route::post('/kasir/transaksi',
        [TransactionController::class, 'store']
    )->name('kasir.transaksi.store');

    Route::middleware(['auth','role:kasir'])->group(function () {

    // OPEN / CLOSE MENU
    Route::post('/menu/{menu}/open',
        [MenuStatusController::class, 'open']
    )->name('menu.open');

    Route::post('/menu/{menu}/close',
        [MenuStatusController::class, 'close']
    )->name('menu.close');
    });


});

    // ================= KASIR =================
    Route::middleware('role:kasir')->group(function () {
        Route::resource('/transaksi', TransactionController::class);
        Route::resource('/shift', ShiftController::class);
    });

    Route::middleware(['auth', 'role:admin,manager'])->group(function () {

    Route::get('/users/kasir/create', function () {
        return view('users.create-kasir');
    })->name('kasir.create');

    Route::post('/users/kasir', [UserController::class, 'store'])
        ->name('kasir.store');
    });

    Route::middleware(['auth','role:admin,manager'])->group(function () {
    Route::get('/monitoring/login-kasir', [LoginLogController::class, 'index'])
        ->name('login.logs');
});

/*
|--------------------------------------------------------------------------
| MENU UMKM & INTERNAL
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // ===============================
    // HALAMAN MENU (SEMUA ROLE LOGIN)
    // ===============================
    Route::get('/menus', [MenuApprovalController::class, 'index'])
        ->name('menus.index');

    // ===============================
    // KASIR
    // ===============================
    Route::middleware(['auth','role:kasir'])->group(function () {

    // FORM HALAMAN
    Route::get('/kasir/menu-umkm', function () {
        return view('kasir.menu-umkm');
    })->name('kasir.menu.umkm');

    // SIMPAN MENU UMKM (KASIR)
    Route::post('/kasir/menu-umkm',
        [MenuApprovalController::class, 'storeByKasir']
    )->name('menu.kasir.store');

});


    // ===============================
    // ADMIN & MANAGER
    // ===============================
    Route::middleware('role:admin,manager')->group(function () {

        Route::post('/menu', [MenuApprovalController::class, 'storeByAdmin'])
            ->name('menu.admin.store');

        Route::post('/menu/{id}/approve', [MenuApprovalController::class, 'approve'])
            ->name('menu.approve');

        Route::post('/menu/{id}/reject', [MenuApprovalController::class, 'reject'])
            ->name('menu.reject');
    });

 });

});
