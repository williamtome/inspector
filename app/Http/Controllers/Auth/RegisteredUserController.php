<?php

namespace App\Http\Controllers\Auth;

use App\Events\RegisteredUser;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class RegisteredUserController extends Controller
{
    public function index()
    {
        $users = User::type()->get();

        return view('dashboard', [
            'users' => $users,
        ]);
    }

    public function create()
    {
        return view('auth.register');
    }

    public function store(UserRequest $request)
    {
        $password = rand(100000, 999999);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($password),
        ]);

        event(new RegisteredUser($user, $password));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }

    public function edit(User $user)
    {
        return view('auth.register', [
            'user' => $user,
        ]);
    }

    public function update(UserRequest $request, User $user)
    {
        $user->update([
            'name' => $request->name,
            'password' => bcrypt($request->password),
        ]);

        return redirect(RouteServiceProvider::HOME);
    }

    public function delete(User $user)
    {
        if ($user->importations()->exists()) {
            return redirect()->back()
                ->withErrors([
                    "Usuário {$user->name} tem importações realizadas.",
                ]);
        }

        $user->active = false;
        $user->save();
        $user->delete();

        return redirect(RouteServiceProvider::HOME);
    }
}
