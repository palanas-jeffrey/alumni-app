<?php

namespace App\Http\Controllers;

use App\Mail\AccountActivationEmail;
use App\Mail\SendEventEmail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    // public function sendAccountActivationEmail(Request $request)
    // {
    //     try {
    //         $user = User::find($request->input('user_id'));
    
    //         if (!$user) {
    //             return response()->json(['message' => 'User not found.'], 404);
    //         }
    
    //         $userName = $user->first_name;
    //         $appLink = config('app.url');
    
    //         Mail::to($user->email)->send(new AccountActivationEmail($userName, $appLink));
    
    //         return response()->json([
    //                 'success' => true,
    //                 'message' => 'Email sent successfully!'
    //             ], 200);
    
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'message' => 'Failed to send email.',
    //             'error' => $e->getMessage(),
    //         ], 500);
    //     }
    // }
}
