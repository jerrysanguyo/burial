<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserService
{
    public function login(array $data): bool
    {
        return Auth::attempt($data);
    }

    public function logout(): void
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerate();
    }
}