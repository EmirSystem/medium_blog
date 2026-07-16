<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role && $user->role->slug === 'super-admin') {
            return view('admin.dashboard');
        }

        return view('yazar.dashboard');
    }
}
