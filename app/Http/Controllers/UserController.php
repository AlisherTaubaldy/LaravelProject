<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function update(Request $request, $user)
    {
        $user = User::find($user);
        $validatedData = $request->validate([
            'name' => 'required|string|max:255', // Rule for name field
            'email' => 'required|email|max:255', // Rule for email field
            'address' => 'nullable|string|max:255'
        ]);

        $user->update($validatedData);

        if (Auth::user() &&  Auth::user()->is_admin == 1) {
            return redirect()->route('admin.manage-users')->with('success', 'User updated successfully!');
        }else{
            return redirect()->route('profile')->with('success', 'User updated successfully!');
        }
    }

    public function delete(Request $request, $user)
    {
        $user = User::find($user);

        $user->delete();

        return redirect()->route('admin.manage-users')->with('success', 'User deleted successfully!');
    }
}
