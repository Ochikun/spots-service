@extends('layouts.default')

@section('content')
    <div class="bg-white p-6  max-w-5xl mx-auto mt-10">
        <form method="POST" action="{{route('spots.update', $spot->id)}}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="flex px-1 pb-4 border-b">
                <h3 class="text-xl font-bold pt-1">日記編集</h3>
                <div class="ml-auto">
                    <button type="submit" class="py-2 px-3 text-xm text-white font-semibold bg-indigo-500 rounded-md hover:bg-indigo-400">更新</button>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium mb-2">タイトル</label>
                <input class="block w-full px-4 py-3 mb-2 text-sm bg-white border rounded" type="text" name="title" value="{{old('title',$spot->title)}}">
                @error('title')
                    <p class="error-message text-red-500 text-sm mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium mb-2">訪問日時</label>
                <input class="block w-full px-4 py-3 mb-2 text-sm bg-white border rounded" type="date" name="date" value="{{old('date',$spot->date)}}">
                @error('date')
                    <p class="error-message text-red-500 text-sm mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium mb-2">本文</label>
                <textarea class="block w-full px-4 py-3 mb-2 text-sm bg-white border rounded" name="body" rows="5">{{old('body',$spot->body)}}</textarea>
                @error('body')
                    <p class="error-message text-red-500 text-sm mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium mb-2">画像</label>
                <!-- プレビュー画像 -->
                <img id="previewImage" src="{{$spot->S3Url ?? asset(('storage/photos/noprofile.jpg'))}}" class="rounded w-40 h-40 object-cover mb-3">
                <!-- ファイル選択ボタン -->
                <div class="flex items-center space-x-3">
                    <label for="image" class="cursor-pointer inline-block px-4 py-2 bg-indigo-500 text-white text-sm font-semibold rounded hover:bg-indigo-400">
                        画像を選択
                    </label>
                    <input id="image" type="file" name="image" accept="image/*" class="file:hidden block text-sm border rounded px-3 py-2 w-80">
                </div>
                @error('image')
                    <p class="error-message text-red-500 text-sm mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium mb-2">カテゴリ</label>
                <div class="flex">
                        <select class="block pl-4 pr-8 py-3 mb-2 text-sm bg-white border rounded" name="category_id">
                        <option value="">選択してください</option>
                        @foreach($categories as $category)
                            <option value="{{$category->id}}" @if($category->id == old('category_id', $spot->category->id)) selected @endif>{{$category->name}}</option>
                        @endforeach
                    </select>
                </div>
                @error('category_id')
                    <p class="error-message text-red-500 text-sm mt-1">{{$message}}</p>
                @enderror
            </div>
        </form>

        <div class="text-center mt-6">
            <a href="{{ route('spots.show', $spot->id) }}" class="inline-block py-2 px-3 text-sm text-white font-semibold bg-gray-500 hover:bg-gray-400 rounded-md">
                戻る
            </a>
        </div>
    </div>
    
    <script src="/js/convHeicImage.js"></script>
    <script>
        //画像プレビュー
        const imageInput = document.getElementById('image');
        const previewImage = document.getElementById('previewImage');

        //画像Heic拡張子をjpg変換
        imageInput.onchange = async () => {
            if(imageInput.files.length === 0) return;
            const url = await window.handleHeicAndReplace(imageInput.files[0],imageInput);
            previewImage.src = url;

        };


    </script>

@endsection
