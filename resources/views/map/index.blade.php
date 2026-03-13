@extends('layouts.default')


@section('content')


    <section class="bg-gray-100">
        @if(session('success'))
            <p class="text-green-600 bg-green-50 px-4 py-2 rounded border border-green-200">{{ session('success') }}</p>
        @endif

        <!--フィルター-->
        <div class="max-w-6xl mx-auto px-4 pt-6">
            <form method="GET" action="{{ route('map.index') }}"
                class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden relative z-20">
                <!--フィルター モバイル表示-->
                <div class="flex items-center justify-between px-5 py-4 md:hidden cursor-pointer bg-white" id="filterToggle">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <span class="text-sm font-bold text-gray-700">絞り込み検索</span>
                    </div>
                    <svg id="filterArrow" class="w-4 h-4 text-gray-400-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
                <!--フィルター モバイル表示-->
                <!--フィルター本体-->
                <div id="filterBody" class="hidden md:block px-6 py-5 bg-white">
                    <div class="flex flex-col md:flex-row md:items-end gap-6">
                        <div class="grid grid-cols-2 md:flex md:flex-wrap gap-4 items-center flex-1">

                            <div class="col-span-2 md:w-48">
                                <label class="block text-[10px] font-bold text-gray-400 mb-1 uppercase tracking-wider">現在地</label>
                                <button type="button" onclick="setMyLocation()"
                                    class="w-full flex items-center justify-center gap-2 bg-indigo-50 border border-indigo-200 text-indigo-600 rounded-lg px-3 py-2 text-sm font-bold hover:bg-indigo-100 ">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    現在地に移動
                                </button>
                            </div>

                            <div class="col-span-1">
                                <label class="block text-[10px] font-bold text-gray-400 mb-1 uppercase tracking-wider">カテゴリ</label>
                                <select name="filter_category" class="w-full bg-gray-50 border border-gray-300 rounded-lg px-2 py-2 text-sm focus:ring-2 focus:ring-indigo-500">
                                    <option value="">すべて</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" @selected(request('filter_category') == $category->id)>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-span-1">
                                <label class="block text-[10px] font-bold text-gray-400 mb-1 uppercase tracking-wider">訪問日</label>
                                <select name="fillter_period" class="w-full bg-gray-50 border border-gray-300 rounded-lg px-2 py-2 text-sm focus:ring-2 focus:ring-indigo-500">
                                    <option value="">全期間</option>
                                    <option value="1week">直近1週間</option>
                                    <option value="3month">直近3ヶ月</option>
                                    <option value="1year">直近1年</option>
                                </select>
                            </div>

                            <div class="col-span-2 md:flex-1 md:max-w-md">
                                <label class="block text-[10px] font-bold text-gray-400 mb-1 uppercase tracking-wider">ワード検索</label>
                                <input type="text" name="filter_keyword" value="{{ request('filter_keyword') }}"
                                    placeholder="キーワード..."
                                    class="w-full bg-gray-50 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500">
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <button type="submit" class="flex-1 md:flex-none px-8 py-2 bg-indigo-500 text-white text-sm font-bold rounded-lg shadow-md hover:bg-indigo-600 transition">検索</button>
                            <a href="{{ route('map.index') }}" class="flex-1 md:flex-none text-center px-4 py-2 bg-gray-100 text-gray-600 text-sm font-bold rounded-lg hover:bg-gray-200">クリア</a>
                        </div>
                    </div>
                </div>
                <!--フィルター本体-->
            </form>
        </div>
        <!--フィルター-->

        <!--ガイド文-->
        <div id="guide-message" class="px-2 md:px-8 mt-2">
            <div class="max-w-6xl mx-auto flex justify-center"> <div class="bg-white/90 backdrop-blur border border-indigo-100 text-indigo-700 px-5 py-1.5 rounded-full text-xs md:text-sm font-bold shadow-sm w-fit">
                    <p>📍 地図をクリックして記録しよう！</p>
                </div>
            </div>
        </div>
        <!--ガイド文-->

        <!--地図-->
        <div class="px-2 md:px-8 pb-2 md:pb-8 pt-2 ">
            <div id="map" class="w-full max-w-6xl mx-auto h-[65vh] md:h-[80vh] rounded-2xl shadow-2xl border-2 md:border-4 border-white overflow-hidden"></div>
        </div>
        <!--地図-->

        <!--モーダル登録メニュー-->
        <div id="spotModal" class="hidden fixed inset-0 bg-black/60 z-[9999] backdrop-blur-md overflow-y-auto px-4 py-6">
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-md mx-auto relative my-auto">
                <form method="POST" action="{{route('spots.store')}}" enctype="multipart/form-data" id="spotForm" class="p-6">
                    @csrf
                    <input type="hidden" name="image_base64" id="image_base64">

                    <div class="flex pb-4 border-b mb-4 items-center">
                        <h3 class="text-xl font-bold">日記登録</h3>
                        <div class="ml-auto">
                            <button type="submit" id="submit_button" class="py-2 px-4 text-sm text-white font-semibold bg-indigo-500 rounded-lg hover:bg-indigo-600">保存</button>
                        </div>
                    </div>

                    <div class="max-h-[60vh] overflow-y-auto pr-2 custom-scrollbar">
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">タイトル</label>
                            <input class="block w-full px-3 py-2 text-sm border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none" type="text" name="title">
                            @error('title')
                                <p class="error-message text-red-500 text-sm mt-1">{{$message}}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">訪問日時</label>
                            <input class="block w-full px-3 py-2 text-sm border rounded-lg" type="date" name="date" value="{{date('Y-m-d')}}">
                            @error('date')
                                <p class="error-message text-red-500 text-sm mt-1">{{$message}}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">本文</label>
                            <textarea class="block w-full px-3 py-2 text-sm border rounded-lg" rows="4" name="body">{{old('body')}}</textarea>
                            @error('body')
                                <p class="error-message text-red-500 text-sm mt-1">{{$message}}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2">画像</label>
                            <img id="previewImage" src="{{asset('storage/' . ($spot->image ?? 'photos/noprofile.jpg'))}}"
                                class="rounded w-32 h-32 object-cover mb-3 block">
                                <div class="flex items-center space-x-2">
                                    <label for="image" class="cursor-pointer whitespace-nowrap inline-block px-4 py-2 bg-indigo-500 text-white text-sm font-semibold rounded hover:bg-indigo-400">
                                        画像を選択
                                    </label>
                                    <input id="image"
                                            type="file"
                                            name="image"
                                            accept="image/*"
                                            class="file:hidden block text-sm border rounded px-3 py-2 w-60">
                                </div>
                            @error('image')
                                <p class="error-message text-red-500 text-sm mt-1">{{$message}}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">カテゴリ</label>
                            <select class="block w-full px-3 py-2 text-sm border rounded-lg" name="category_id">
                                <option value="">選択してください</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('category_id')
                            <p class="error-message text-red-500 text-sm mt-1">{{$message}}</p>
                        @enderror
                    </div>

                    <input type="hidden" id="modal-lat" name="lat" value="{{old('lat')}}">
                    <input type="hidden" id="modal-lng" name="lng" value="{{old('lng')}}">

                    <div class="mt-6 text-center">
                        <button type="button" id="closeModal" class="w-full py-2.5 text-sm text-gray-500 font-medium bg-gray-100 hover:bg-gray-200 rounded-lg">
                            キャンセル
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <!--モーダル登録メニュー-->

        <script src="/js/map.js"></script>
        <script src="/js/convHeicImage.js"></script>
        <script>
            window.spots = @json($spots);
            window.spotShowUrl = "{{ route('spots.show', ':id') }}";

            document.addEventListener('DOMContentLoaded', function() {

                //モバイル用フィルター画面開閉メニュー
                const toggle = document.getElementById('filterToggle');
                const body = document.getElementById('filterBody');
                const arrow = document.getElementById('filterArrow');

                toggle.addEventListener('click', function() {
                    body.classList.toggle('hidden');
                    arrow.classList.toggle('rotate-180');
                });

                //画像プレビュー
                const imageInput = document.getElementById('image');
                const previewImage = document.getElementById('previewImage');
                const submitBtn = document.getElementById('submit_button');
                const hidden = document.getElementById('image_base64');

                //画像Heic拡張子をjpg変換
                imageInput.onchange = async () => {
                    if(imageInput.files.length === 0) return;
                    const url = await window.handleHeicAndReplace(imageInput.files[0],imageInput,submitBtn);
                    previewImage.src = url;
                };

                document.getElementById('spotForm').addEventListener('submit', function() {
                    if (previewImage.src.startsWith('data:image')) {
                            hidden.value = previewImage.src;
                        }
                });

                //バリデーションエラー時のモーダル表示
                @if($errors->any())
                    if (typeof openModal === 'function') {
                        openModal();
                    }
                @endif
            });
        </script>
    </section>
@endsection
