<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function login()
    {
        return view('admin.login');
    }

    public function vkRedirect()
    {
        return Socialite::driver('vkontakte')->redirect();
    }

    public function vkCallback()
    {
        try {
            $vk = Socialite::driver('vkontakte')->user();
        } catch (\Exception $e) {
            return redirect('/admin/login')->withErrors('Ошибка авторизации VK');
        }

        $user = User::where('vk_id', $vk->getId())->first();

        if (!$user) {
            $hasUsers = User::exists();
            $user = User::create([
                'name' => $vk->getName() ?: $vk->getNickname(),
                'email' => $vk->getEmail() ?: $vk->getId() . '@vk.user',
                'password' => '',
                'vk_id' => $vk->getId(),
                'role' => $hasUsers ? 'tourist' : 'owner',
            ]);
        }

        Auth::login($user, true);

        return redirect('/admin/pages');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin/login');
    }
}
