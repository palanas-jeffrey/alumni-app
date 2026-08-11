<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth; 

use Illuminate\Http\Request;

class ConfigurationController extends Controller
{
    public function showMain() 
    {        
        return view('configuration.index');
    }

    public function showAdminKeyConfiguration()
    {
        $admin = Auth::guard('admin')->user();

        if (!$admin->has_main_control) {
            return redirect()->route('configurations');
        }

        return view('configuration.admin-access-key');
    }
}