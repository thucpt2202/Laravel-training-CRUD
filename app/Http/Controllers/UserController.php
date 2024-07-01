<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use Illuminate\View\View;

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

        $currentRole = Auth::user()->role;
        $users = $query->paginate(8);
        return view('dashboard', compact('users', 'currentRole'));
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

    /**
     * Update a user
     */
    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'nullable|string|min:8',
            'role' => 'required|string|in:admin,nuser,oper',
            'status' => 'required|string|in:active,inactive',
        ]);

        $user = User::findOrFail($id);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->status = $request->status;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();
        return redirect()->route('dashboard')->with('success', 'User updated successfully.');
    }

    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }
    
    /**
     * Add a new user
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'nuser',
        ]);

        event(new Registered($user));

        toastr()->success('User has been created successfully!');
        return redirect()->intended(RouteServiceProvider::HOME);
    }
}
