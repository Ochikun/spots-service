@extends('layouts.default')


@section('content')
    @if(session('success'))
        <p class="text-green-600 mb-4 bg-green-50 px-4 py-2 rounded border border-green-200">{{ session('success') }}</p>
    @endif

    <div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-8">パスワードの変更</h2>

        <div class="space-y-6">
            <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden">
                <div class="p-6 sm:p-8">

                    <form method="POST" action="{{route('auth.password.update')}}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 gap-y-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">現在のパスワード</label>
                                <input type="password" name="current_password"
                                    class="w-full max-w-md bg-gray-50 border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                                @error('current_password')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="py-2">
                                <hr class="max-w-md border-gray-100">
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">新しいパスワード</label>
                                <input type="password" name="password"
                                    class="w-full max-w-md bg-gray-50 border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                                <p class="text-xs text-gray-400 mt-1">8文字以上の英数字</p>
                                @error('password')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">新しいパスワード（確認）</label>
                                <input type="password" name="password_confirmation"
                                    class="w-full max-w-md bg-gray-50 border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                            </div>
                        </div>

                        <div class="mt-10 pt-6 border-t border-gray-100 flex justify-end gap-x-4">
                            <a href="{{ route('map.index') }}" class="px-6 py-2.5 text-sm font-bold text-gray-600 hover:text-gray-800 transition duration-200 flex items-center">
                                キャンセル
                            </a>
                            <button type="submit" class="px-6 py-2.5 bg-indigo-500 text-white text-sm font-bold rounded-lg shadow-md hover:bg-indigo-600">
                                パスワードを更新する
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
