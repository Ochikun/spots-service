@extends('layouts.default')

@section('content')
<section class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h2 class="text-2xl md:text-3xl font-bold text-gray-800">日記一覧</h2>
    </div>

    @if(session('success'))
        <p class="text-green-600 mb-4 bg-green-50 px-4 py-2 rounded border border-green-200">{{ session('success') }}</p>
    @endif
    <!--フィルター-->
    <div class="mb-8">
        <form method="GET" action="{{ route('spots.index') }}"
            class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden relative z-20">
            <!--フィルター モバイル表示-->
            <div class="flex items-center justify-between px-5 py-4 md:hidden cursor-pointer bg-white" id="filterToggle">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <span class="text-sm font-bold text-gray-700">絞り込み検索</span>
                </div>
                <svg id="filterArrow" class="w-4 h-4 text-gray-400 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </div>
            <!--フィルター モバイル表示-->
            <!--フィルター本体-->
            <div id="filterBody" class="hidden md:block px-6 py-5 bg-white border-t border-gray-50 md:border-t-0">
                <div class="flex flex-col md:flex-row md:items-end gap-6">
                    <div class="grid grid-cols-2 md:flex md:flex-wrap gap-4 items-center flex-1">

                        <div class="col-span-1">
                            <label class="block text-[10px] font-bold text-gray-400 mb-1 uppercase tracking-wider">カテゴリ</label>
                            <select name="filter_category" class="w-full bg-gray-50 border border-gray-300 rounded-lg px-2 py-2 text-sm focus:ring-2 focus:ring-indigo-500">
                                <option value="">すべて</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" @selected(request('filter_category') == $category->id)>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-span-1">
                            <label class="block text-[10px] font-bold text-gray-400 mb-1 uppercase tracking-wider">並び替え</label>
                            <select name="sort" class="w-full bg-gray-50 border border-gray-300 rounded-lg px-2 py-2 text-sm focus:ring-2 focus:ring-indigo-500">
                                <option value="">選択</option>
                                <option value="visited_desc" @selected(request('sort')=='visited_desc')>訪問日（新）</option>
                                <option value="visited_asc" @selected(request('sort')=='visited_asc')>訪問日（古）</option>
                                <option value="title_asc" @selected(request('sort')=='title_asc')>タイトル順</option>
                            </select>
                        </div>

                        <div class="col-span-2 md:flex-1">
                            <label class="block text-[10px] font-bold text-gray-400 mb-1 uppercase tracking-wider">ワード検索</label>
                            <input type="text" name="filter_keyword" value="{{ request('filter_keyword') }}"
                                placeholder="キーワードを入力..."
                                class="w-full bg-gray-50 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500">
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <button type="submit" class="flex-1 md:flex-none px-8 py-2 bg-indigo-500 text-white text-sm font-bold rounded-lg shadow-md hover:bg-indigo-600">検索</button>
                        <a href="{{ route('spots.index') }}" class="flex-1 md:flex-none text-center px-4 py-2 bg-gray-100 text-gray-600 text-sm font-bold rounded-lg hover:bg-gray-200">
                            クリア
                        </a>
                    </div>
                </div>
            </div>
            <!--フィルター本体-->
        </form>
    </div>
    <!--フィルター-->
    <!--リストデータ-->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">
        <div class="overflow-x-auto">
            <table class="table-auto w-full text-left">
                <thead>
                    <tr class="text-xs text-gray-400 uppercase tracking-wider border-b border-gray-100 bg-gray-50/50">
                        <th class="font-bold px-6 py-4">タイトル</th>
                        <th class="font-bold px-6 py-4">カテゴリ</th>
                        <th class="font-bold px-6 py-4">訪問日</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 whitespace-nowrap">
                    @foreach($spots as $spot)
                        <tr onclick="window.location='{{ route('spots.show', $spot->id) }}'"
                            @class(['text-sm', 'cursor-pointer', 'hover:bg-indigo-50', 'transition-colors', 'bg-gray-100' => $loop->odd])>
                            <td class="px-6 py-5">
                                <div class="flex items-center">
                                    @if($spot->image)
                                        <img class="w-14 h-14 mr-4 object-cover rounded-lg shadow-sm border border-gray-100"
                                            src="{{$spot->S3Url}}">
                                    @else
                                    <div class="w-14 h-14 mr-4 flex items-center justify-center bg-gray-200 rounded-lg shadow-sm border border-gray-100 text-gray-400">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    @endif

                                    <p class="font-bold text-gray-800 tracking-tight">
                                        {{$spot->title ?? '無題'}}
                                    </p>
                                </div>
                            </td>

                            <td class="px-6 py-5 text-gray-600">
                                <span class="flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full" style="background-color:{{ $spot->category->color ?? '#d1d5db' }}"></span>
                                    <span class="text-xs text-gray-700">{{ $spot->category->name }}</span>
                                </span>
                            </td>

                            <td class="px-6 py-5 text-gray-500 font-medium">
                                {{$spot->date}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!--リストデータ-->
    <!--ページャー-->
    <div class="mt-8 mb-12">
        {{$spots->appends(request()->query())->onEachSide(1)->links()}}
    </div>
    <!--ページャー-->
</section>

<script>
    //モバイル用フィルター画面開閉メニュー
    document.addEventListener('DOMContentLoaded', function() {
        const toggle = document.getElementById('filterToggle');
        const body = document.getElementById('filterBody');
        const arrow = document.getElementById('filterArrow');

        toggle.addEventListener('click', function() {
            if (window.innerWidth < 768) {
                body.classList.toggle('hidden');
                arrow.classList.toggle('rotate-180');
            }
        });
    });
</script>
@endsection
