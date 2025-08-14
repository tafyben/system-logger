<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Log;
use App\Models\LogType;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Create a log entry for the new registration
        $logTypeId = LogType::where('name', 'User Action')->value('id')
            ?? LogType::first()->id; // Fallback to first type if missing

        Log::create([
            'user_id'         => $user->id,
            'log_type_id'     => $logTypeId,
            'title'           => 'New User Registration',
            'description'     => "User {$user->name} ({$user->email}) has registered.",
            'affected_system' => 'User Management System',
            'changes'         => json_encode([
                'name'  => $user->name,
                'email' => $user->email
            ]),
            'event_time'      => now(),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
