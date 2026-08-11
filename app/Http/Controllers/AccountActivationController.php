<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccountActivation;
use App\Models\User;

class AccountActivationController extends Controller
{
    public function activateUserAccount($userId)
    {
        try {
            // Validate that the user exists
            $user = User::find($userId);

            if (!$user) {
                return response()->json(['message' => 'User not found.'], 404);
            }

            // Find the activation record for the user
            $activation = AccountActivation::where('user_id', $userId)->first();

            if (!$activation) {
                return response()->json(['message' => 'Activation record not found.'], 404);
            }

            // Update the activation status to active
            $activation->update(['is_activated' => true]);

            return response()->json([
                    'success' => true,
                    'message' => 'User account successfully activated.'
                ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to send email.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function createActivationRecord($userId)
    {
        AccountActivation::create([
            'user_id' => $userId, // ID of the user
            'token' => Str::random(100), // Generate a unique token
            'expired_at' => now()->addDays(7), // Set expiration date to 7 days later
            'is_activated' => false // Initial activation status
        ]);

        return response()->json(['message' => 'Activation record created successfully!']);
    }

}