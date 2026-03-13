<?php

namespace App\Http\Controllers\Auth;

use Exception;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Imagick\Driver;

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

            if($request->hasFile('image')){
                if(!empty($user->image)){
                    Storage::disk('s3')->delete($user->image);
                }
                $imgManager = new ImageManager(new Driver());

                $imgFile = $request->file('image');
                $image = $imgManager->read($imgFile);

                $encoded = $image->toJpeg(70);
                $fileName = 'photos/' . Str::random(40) . '.jpg';

                Storage::disk('s3')->put($fileName,(string) $encoded);
                $updateData['image'] = $fileName;
            }
            $user->update($updateData);

            return to_route('auth.profile.edit')->with('success','プロフィールを更新しました');
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
