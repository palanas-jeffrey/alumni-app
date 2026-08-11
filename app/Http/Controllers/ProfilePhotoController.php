<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ProfilePhoto;
use App\Models\Admin;
use App\Models\AdminProfilePhoto;
use Illuminate\Http\Request;

class ProfilePhotoController extends Controller
{
    // Controller method to handle the request
    public function uploadProfilePhoto(Request $request, $user_id)
    {
        // Validate the incoming request (e.g., for a valid image file)
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Example validation
        ]);

        // Find the user by ID
        $user = User::find($user_id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Handle the uploaded file
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filePath = $file->store('profiles', 'public'); // Save file in the 'public' disk

            // Save the file path in the profile_photos table
            $profilePhoto = ProfilePhoto::updateOrCreate(
                ['user_id' => $user->id], // Find by user_id
                ['photo_path' => $filePath] // Update or insert photo_path
            );

            session(['status' => 'profile-photo-updated']);

            return response()->json([
                'message' => 'Profile photo uploaded successfully',
                'photo_path' => $filePath,
            ]);
        }

        return response()->json(['error' => 'Photo upload failed'], 500);
    }

    public function uploadAdminProfilePhoto(Request $request, $admin_id)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $admin = Admin::find($admin_id);

        if (!$admin) {
            return response()->json(['error' => 'Admin not found'], 404);
        }

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filePath = $file->store('profiles', 'public');

            $profilePhoto = AdminProfilePhoto::updateOrCreate(
                ['admin_id' => $admin->id],
                ['photo_path' => $filePath]
            );

            session(['status' => 'profile-photo-updated']);

            return response()->json([
                'message' => 'Profile photo uploaded successfully',
                'photo_path' => $filePath,
            ]);
        }

        return response()->json(['error' => 'Photo upload failed'], 500);
    }
}