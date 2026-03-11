<?php
use App\Http\Controllers\MapController;
use App\Http\Controllers\SpotController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\PasswordController;
use Illuminate\Support\Facades\Route;

Route::get('/', function {
    return redirect()->route('showLoginForm');
});

//未ログイン用
Route::middleware('guest')
    ->name('auth.')
    ->group(function(){
        //ログイン処理
        Route::prefix('login')
            ->group(function(){
                Route::get('/',[LoginController::class,'showLoginForm'])->name('showLoginForm');
                Route::post('/',[LoginController::class,'login'])->name('login');
        });
        //ユーザ登録
        Route::prefix('register')
            ->group(function(){
                Route::get('/',[RegisterController::class,'show'])->name('register.show');
                Route::post('/',[RegisterController::class,'store'])->name('register.store');
        });
});

//ログイン済み用
Route::middleware('auth')
    ->group(function(){
        //日記
        Route::get('/map',[MapController::class,'index'])->name('map.index');
        Route::resource('/spots',SpotController::class)->except('create');

        Route::name('auth.')
            ->group(function(){
                //ログアウト処理
                Route::post('/logout',[LoginController::class,'logout'])->name('logout');
                //ユーザプロフ編集
                Route::prefix('profile')
                    ->name('profile.')
                    ->group(function(){
                        Route::get('/',[ProfileController::class,'edit'])->name('edit');;
                        Route::put('/',[ProfileController::class,'update'])->name('update');;
                        Route::delete('/',[ProfileController::class,'destroy'])->name('destroy');;
                });
                //ユーザパスワード編集
                Route::prefix('password')
                    ->name('password.')
                    ->group(function(){
                        Route::get('/',[PasswordController::class,'edit'])->name('edit');
                        Route::put('/',[PasswordController::class,'update'])->name('update');
                });
        });
});
