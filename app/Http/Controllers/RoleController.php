<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $users = User::whereIn('role', ['owner', 'tourist'])->get();
        return view('admin.roles', compact('users'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate(['role' => 'required|in:owner,tourist']);
        $user->role = $request->role;
        $user->save();

        return redirect('/admin/roles')->with('success', 'Роль пользователя «' . $user->name . '» изменена на «' . $request->role . '»');
    }
}
