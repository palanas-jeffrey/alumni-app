<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth; 

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() 
    {
        if (Auth::guard('admin')->check() || Auth::guard('web')->check()) {
            return view('dashboard');
        }
        
        return redirect('/welcome');
    }
}