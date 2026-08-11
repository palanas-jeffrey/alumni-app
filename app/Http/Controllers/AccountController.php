<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use App\Models\Role;
use App\Models\Program;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\AdminAccessKey;
// use PDF;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index() {
        $users = User::with(['accountActivation'])->get();

        return view('admin.accountManagement', compact('users'));
    }
    
    public function getProgram(){
        $userType = Auth::guard('admin')->check() ? "admin" : "alumni";

        if (!Auth::guard('admin')->check() && !Auth::guard('web')->check()) {
            Auth::guard($userType === "admin" ? 'admin' : 'web')->logout();
            $urlRedirect = ($userType == "admin") ? "/administrator-login" : "login";

            return redirect($urlRedirect);
        }
        $programs = Program:: all();
        return view("accounts.programs", compact("programs"));
    }

    public function getAccountDetails($id)
    {
        $account = User::with(['accountActivation', 'profilePhoto', 'programTaken'])->find($id);
        return view('admin.user-account', compact("account"));
    }

    public function viewAccountDetails($id)
    {
        $account = User::with(['accountActivation', 'profilePhoto', 'programTaken'])->find($id);
        return view('alumni.user-account', compact("account"));
    }
    
    // public function generateUserAccountsReport(Request $request) {
    //     $userAccounts = User::select('name', 'email', 'created_at')
    //         ->with('accountActivation:is_activated,user_id')
    //         ->get();

    //     $pdf = PDF::loadView('pdf.user-account-report', ['userAccounts' => $userAccounts], [], 
    //         [
    //             'orientation' => 'L',
    //         ]
    //     );
    //     return $pdf->stream('accounts.pdf'); // Stream the generated PDF
    // }

    public function deleteAccount(Request $request, $account_id): RedirectResponse
    {
        $request->validate([
            'password' => ['required'],
        ]);
    
        $user = Auth::user();
        $account = User::findOrFail($account_id);
    
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'The provided password is incorrect.']);
        }
    
        $account->delete();

        return redirect()->route('accounts.programs')->with('success-account-delete', 'Account deleted successfully!'); 
    }

    public function getAdminList()
    {
        $accounts = Admin::get();

        return view('admin.admin-accounts', compact("accounts"));
    }

    public function editAdminAccount($account_id)
    {
        $activeAdmin = Auth::guard('admin')->user();

        if (!$activeAdmin->has_main_control) {
            return back()->withErrors(['authorization' => 'You do not have permission to perform this action.']);
        }

        $account = Admin::findOrFail($account_id);
        return view('accounts.edit-admin-account', compact("account"));
    }

    public function viewAlumnusRegistration()
    {
        $programs = Program::select('id', 'program_name')->get();
        
        return view('accounts.registration', compact("programs"));
    }

    public function editAlumniAccount($account_id)
    {
        $account = User::findOrFail($account_id);

        return view('accounts.edit-account', compact("account"));
    }
}