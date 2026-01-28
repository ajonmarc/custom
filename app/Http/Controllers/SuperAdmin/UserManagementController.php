<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class UserManagementController extends Controller
{
    public function users()
    {
        return Inertia::render('SuperAdmin/Users', [
        ]);
    }
}
