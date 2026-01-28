<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;


class RoleManagementController extends Controller
{
        public function roles()
    {
        return Inertia::render('SuperAdmin/Roles', [
        ]);
    }
}
