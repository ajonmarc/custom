<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

use App\Http\Middleware\RedirectByRole;

Route::get('/dashboard', function () {
    // This route does nothing except redirect via middleware
})->middleware(['auth', RedirectByRole::class])->name('dashboard');

use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboard;
use App\Http\Controllers\SuperAdmin\UserManagementController as UserManagement;
use App\Http\Controllers\SuperAdmin\RoleManagementController as RoleManagement;
use App\Http\Controllers\SuperAdmin\PermissionManagementController as PermissionManagement;





use App\Http\Controllers\Admin\DashboardController as AdminDashboard;

use App\Http\Controllers\User\DashboardController as UserDashboard;

Route::middleware(['auth', 'role:superadmin'])->prefix('superadmin')->group(function () {
    Route::get('/dashboard', [SuperAdminDashboard::class, 'index'])->name('superadmin.dashboard');
    Route::get('/users', [UserManagement::class, 'users'])->name('superadmin.users');
    Route::get('/roles', [RoleManagement::class, 'roles'])->name('superadmin.roles');
    Route::get('/permissions', [PermissionManagement::class, 'permissions'])->name('superadmin.permissions');


});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('admin.dashboard');
});

Route::middleware(['auth', 'role:user'])->prefix('user')->group(function () {
    Route::get('/dashboard', [UserDashboard::class, 'index'])->name('user.dashboard');
});


require __DIR__.'/settings.php';
