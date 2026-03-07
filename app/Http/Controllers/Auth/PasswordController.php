<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UpdatePasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PasswordController extends Controller
{
    public function edit()
    {
        return view('auth.password.edit');
    }

    public function update(UpdatePasswordRequest $request)
    {
        $validated = $request->validated();
        $user = Auth::user();

        if(!Hash::check($validated['current_password'],$user->password)){
            return back()->withErrors(['current_password' => '現在のパスワードが違います']);
        }

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success','パスワードを変更しました');
    }
}
