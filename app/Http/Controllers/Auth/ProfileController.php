<?php

namespace App\Http\Controllers\Auth;

use Exception;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('auth.profile.edit');
    }


    public function update(UpdateProfileRequest $request)
    {
        $updateData = $request->validated();
        $user = Auth::user();
        try{
            if($request->hasFile('image')){
                if(!empty($user->image)){
                    Storage::disk('s3')->delete($user->image);
                }
                $updateData['image'] = $request->file('image')->store('photos','s3');
            }
            $user->update($updateData);

            return to_route('auth.profile.edit')->with('success','プロフィールを更新しました');

        }catch(Exception $e){
            return back()->withErrors(['image' =>'画像のアップロードに失敗しました']);
        }

    }

    public function destroy(User $user)
    {
        $user = Auth::user();

        foreach($user->spots as $spot){
            if(!empty($spot->image)){
                Storage::disk('s3')->delete($spot->image);
            }
        }
        if(!empty($user->image)){
            Storage::disk('s3')->delete($user->image);
        }
        $user->delete();

        return to_route('auth.login')->with('success','アカウントを削除しました');
    }
}
