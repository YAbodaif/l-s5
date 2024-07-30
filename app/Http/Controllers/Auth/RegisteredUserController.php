<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Employee;
use App\Models\Seller;
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

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        switch ($request->role) {
            case 'user':
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
                Auth::guard('admin')->login($user);
                return redirect(route('dashboard', absolute: false));
                break;
            case 'seller':
                $request->validate([
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
                    'password' => ['required', 'confirmed', Rules\Password::defaults()],
                ]);
                $user = Seller::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
                Auth::guard('seller')->login($user);
                return redirect(route('dashboard', absolute: false));
                break;
            case 'employee':
                $request->validate([
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
                    'password' => ['required', 'confirmed', Rules\Password::defaults()],
                ]);
                $user = Employee::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
                Auth::guard('employee')->login($user);
                return redirect(route('dashboard', absolute: false));
                break;
            case 'admin':
                $request->validate([
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
                    'password' => ['required', 'confirmed', Rules\Password::defaults()],
                ]);
                $user = Admin::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
                Auth::guard('admin')->login($user);
                return redirect(route('dashboard', absolute: false));
                break;
            default:
            return redirect(route ('register'));
                break;
        }
    }
}
// $request->validate([
//     'name' => ['required', 'string', 'max:255'],
//     'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
//     'password' => ['required', 'confirmed', Rules\Password::defaults()],
// ]);
// $user = User::create([
//     'name' => $request->name,
//     'email' => $request->email,
//     'password' => Hash::make($request->password),
// ]);
// event(new Registered($user));
// Auth::login($user);
// return redirect(route('dashboard', absolute: false));