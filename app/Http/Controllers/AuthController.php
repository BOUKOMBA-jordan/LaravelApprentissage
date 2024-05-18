<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('auth.login'); // Correction de la méthode pour rediriger vers la route correcte
    }

    public function doLogin(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended(route('blog.index'));
        }

        return redirect()->route('auth.login') // Correction de la méthode pour rediriger vers la route correcte
            ->withErrors([
                'email' => "Email invalide" // Correction du message d'erreur
            ])->withInput($request->only('email')); // Correction de la méthode pour conserver les entrées valides
    }
}
