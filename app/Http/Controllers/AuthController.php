<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view("login");
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            "email" => ["required", "email"],
            "password" => ["required"],
        ]);

        if (!Auth::validate($credentials)) {
            return back()
                ->withErrors(["email" => "Credenciales incorrectas."])
                ->onlyInput("email");
        }

        $user = User::query()->where("email", $credentials["email"])->first();

        $codigo = (string) random_int(100000, 999999);

        $user
            ->forceFill([
                "codigo" => Hash::make($codigo),
                "expiracion" => now()->addMinutes(5),
            ])
            ->save();

        Mail::raw(
            "El código de acceso es: {$codigo}\n\nVence en 5 minutos.",
            function ($message) use ($user) {
                $message->to($user->email)->subject("Código de acceso");
            },
        );

        $request->session()->put("verificar_id", $user->id);

        return redirect()->route("verificar");
    }

    public function showVerificar(Request $request)
    {
        if (!$request->session()->has("verificar_id")) {
            return redirect()->route("login");
        }

        return view("verificar");
    }

    public function verificar(Request $request)
    {
        $request->validate(
            ["codigo" => ["required", "digits:6"]],
            ["codigo.*" => "Escribe los 6 dígitos del código."],
        );

        $user = User::query()->find($request->session()->get("verificar_id"));

        if (
            !$user ||
            !$user->codigo ||
            $user->expiracion->isPast() ||
            !Hash::check($request->codigo, $user->codigo)
        ) {
            return back()->withErrors([
                "codigo" => "Código incorrecto o vencido.",
            ]);
        }

        $user->forceFill(["codigo" => null, "expiracion" => null])->save();
        $request->session()->forget("verificar_id");

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended(route("home"));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route("login");
    }
}
