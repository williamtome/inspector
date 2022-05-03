<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Mail\RegisteredUser;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'users' => User::where('name', '<>', 'Admin')
                ->where('id', '<>', Auth::id())
                ->get(),
        ]);
    }
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(UserRequest $request)
    {
        $password = rand(100000, 999999);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($password),
        ]);

        event(new Registered($user));

        Mail::to($user->email)
            ->send(new RegisteredUser($user, $password));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
