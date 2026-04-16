@extends('layouts.default')


  @section('content')
    @if(session('success'))
        <p class="text-green-600 mb-4 bg-green-50 px-4 py-2 rounded border border-green-200">{{ session('success') }}</p>
    @endif

  <div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
      <h2 class="text-2xl font-bold text-gray-800 mb-8">プロフィール設定</h2>

      <div class="space-y-6">
          <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden">
              <div class="p-6 sm:p-8">

                  <form method="POST" action="{{route('auth.profile.update')}}" enctype="multipart/form-data">
                      @csrf
                      @method('PUT')

                      <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6 mb-8 pb-8 border-b border-gray-100">
                          <div class="relative">
                            <!--画像表示　登録-->
                              <img id="previewImage" src="{{\Auth::user()->S3Url ?? asset('storage/photos/noprofile.jpg')}}" class="w-24 h-24 rounded-full object-cover border-2 border-gray-100 shadow-sm">
                              <label class="absolute bottom-0 right-0 bg-white p-1.5 rounded-full shadow-md border border-gray-200 cursor-pointer hover:bg-gray-50 transition">
                                  <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                  </svg>
                                  <input type="file" id="image" name="image" class="hidden" accept="image/*">
                              </label>
                          </div>
                          <!--画像表示　登録-->
                          <div>
                              <h3 class="text-sm font-bold text-gray-700">プロフィール写真</h3>
                              <p class="text-xs text-gray-500 mt-1">JPG, JPEG, PNG形式 (最大 2MB)</p>
                              @error('image')
                                  <p class="error-message text-red-500 text-sm mt-1">{{$message}}</p>
                              @enderror
                          </div>
                      </div>

                      <div class="grid grid-cols-1 gap-y-6">
                          <div>
                              <label for="name" class="block text-sm font-bold text-gray-700 mb-1">名前</label>
                              <input type="text" name="name" id="name" value="{{ old('name', Auth::user()->name) }}"
                                    class="w-fullx ma-w-md bg-gray-50 border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                              @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                              @enderror
                          </div>

                          <div>
                              <label class="block text-sm font-bold text-gray-700 mb-1">自己紹介</label>
                              <textarea name="introduction" cols="30" rows="10" class="w-full max-w-md bg-gray-100 border border-gray-300 rounded-lg px-4 py-2 text-sm text-gray-500">{{Auth::user()->introduction}}</textarea>
                              @error('introduction')
                                  <p class="error-message text-red-500 text-sm mt-1">{{$message}}</p>
                              @enderror
                          </div>
                      </div>

                      <div class="mt-10 pt-6 border-t border-gray-100 flex justify-end">
                          <button type="submit" class="px-6 py-2.5 bg-indigo-500 text-white text-sm font-bold rounded-lg shadow-md hover:bg-indigo-600">
                              変更を保存する
                          </button>
                      </div>
                  </form>
              </div>
          </div>

          <div class="bg-red-50 rounded-xl border border-red-100 overflow-hidden mt-12">
              <div class="p-6 sm:p-8 flex flex-col sm:flex-row items-center justify-between gap-6">
                  <div class="text-center sm:text-left">
                      <h3 class="text-lg font-bold text-red-800">アカウントの削除</h3>
                      <p class="text-sm text-red-600 mt-1">一度削除すると、これまでの旅日記や画像データはすべて削除されます。復元はできません。</p>
                  </div>

                  <form method="POST" action="{{route('auth.profile.destroy')}}" onsubmit="return confirm('本当に退会しますか？');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="px-6 py-2.5 bg-red-600 text-white text-sm font-bold rounded-lg hover:bg-red-700 whitespace-nowrap">
                          退会する
                      </button>
                  </form>
              </div>
          </div>
      </div>
  </div>

  <script src="/js/heicPreview.js"></script>
@endsection
