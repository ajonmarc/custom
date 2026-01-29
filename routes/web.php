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

      Route::post('/users', [UserManagement::class, 'store'])->name('superadmin.users.store'); // Add
    Route::put('/users/{user}', [UserManagement::class, 'update'])->name('superadmin.users.update'); // Add
    Route::delete('/users/{user}', [UserManagement::class, 'destroy'])->name('superadmin.users.destroy'); // Add
    
    Route::get('/roles', [RoleManagement::class, 'roles'])->name('superadmin.roles');
        Route::post('/roles', [RoleManagement::class, 'store'])->name('superadmin.roles.store');
    Route::put('/roles/{role}', [RoleManagement::class, 'update'])->name('superadmin.roles.update');
    Route::delete('/roles/{role}', [RoleManagement::class, 'destroy'])->name('superadmin.roles.destroy');

    
    Route::get('/permissions', [PermissionManagement::class, 'permissions'])->name('superadmin.permissions');
    Route::post('/permissions', [PermissionManagement::class, 'store'])->name('superadmin.permissions.store');
    Route::put('/permissions/{permission}', [PermissionManagement::class, 'update'])->name('superadmin.permissions.update');
    Route::delete('/permissions/{permission}', [PermissionManagement::class, 'destroy'])->name('superadmin.permissions.destroy');

});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('admin.dashboard');
});

Route::middleware(['auth', 'role:user'])->prefix('user')->group(function () {
    Route::get('/dashboard', [UserDashboard::class, 'index'])->name('user.dashboard');
});


require __DIR__.'/settings.php';
