<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PermissionManagementController extends Controller
{
        public function permissions()
    {
        return Inertia::render('SuperAdmin/Permissions', [
        ]);
    }
}
