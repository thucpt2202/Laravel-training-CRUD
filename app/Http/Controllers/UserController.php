<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a list of users.
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Search by name
        if ($request->name) {
            $query->where('name', 'LIKE', "%$request->name%");
        }
        // Search by email
        if ($request->email) {
            $query->where('email', 'LIKE', "%$request->email%");
        }
        // Search by status
        if ($request->status) {
            $query->where('status', $request->status);
        }
        // Filter by role
        if ($request->role) {
            $query->where('role', $request->role);
        }

        $users = $query->paginate(8);
        return view('dashboard', compact('users'));
    }

    /**
     * Delete a user.
     * Soft delete the user from the database.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('dashboard')->with('success', 'User deleted successfully.');
    }
}
